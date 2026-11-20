'use strict';

const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

async function loadHelper(fetchImplementation) {
  const context = {
    TypeError,
    fetch: fetchImplementation,
    window: { setTimeout: (callback) => { callback(); return 0; } },
  };
  vm.createContext(context);
  const source = fs.readFileSync(
    path.join(__dirname, '..', 'public', 'views', 'api.js'),
    'utf8'
  );
  vm.runInContext(source, context);
  return context.window.fetchWithNetworkRetry;
}

(async () => {
  let calls = 0;
  const retryGet = await loadHelper(async () => {
    calls += 1;
    if (calls === 1) throw new TypeError('temporary network failure');
    return { ok: true };
  });
  assert.equal((await retryGet('/mahasiswa')).ok, true);
  assert.equal(calls, 2, 'GET retries once');
  console.log('PASS GET retries once after a network error');

  calls = 0;
  const doNotRetryPost = await loadHelper(async () => {
    calls += 1;
    throw new TypeError('network failure');
  });
  await assert.rejects(() => doNotRetryPost('/mahasiswa', { method: 'POST' }));
  assert.equal(calls, 1, 'mutating POST is not retried');
  console.log('PASS mutating POST is not retried');

  calls = 0;
  const failedGet = await loadHelper(async () => {
    calls += 1;
    throw new TypeError('network failure');
  });
  await assert.rejects(() => failedGet('/mahasiswa'));
  assert.equal(calls, 2, 'failed GET stops after one retry');
  console.log('PASS failed GET stops after two attempts');
})().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
