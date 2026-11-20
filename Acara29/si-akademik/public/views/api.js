'use strict';

window.fetchWithNetworkRetry = async function (url, options = {}, retrySafe = null) {
  const method = (options.method || 'GET').toUpperCase();
  const canRetry = retrySafe === null ? method === 'GET' : retrySafe;
  for (let attempt = 0; ; attempt += 1) {
    try {
      return await fetch(url, options);
    } catch (error) {
      if (!canRetry || attempt >= 1 || !(error instanceof TypeError)) throw error;
      await new Promise((resolve) => window.setTimeout(resolve, 300));
    }
  }
};
