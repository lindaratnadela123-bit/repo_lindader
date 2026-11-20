'use strict';

const API_BASE_URL = new URL('../', window.location.href).href.replace(/\/$/, '');
const loginForm = document.querySelector('#form-login');
const messageElement = document.querySelector('#message');
const loginButton = document.querySelector('#login-button');

loginForm.addEventListener('submit', async (event) => {
  event.preventDefault();
  loginButton.disabled = true;
  loginButton.textContent = 'Memeriksa akun...';
  messageElement.textContent = 'Memeriksa akun...';

  const formData = new FormData(loginForm);
  try {
    const response = await window.fetchWithNetworkRetry(`${API_BASE_URL}/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify({
        username: formData.get('username'),
        password: formData.get('password'),
      }),
    }, true);
    const result = await response.json();
    if (!response.ok || !result.success) {
      throw new Error(result.message || `Login gagal (${response.status}).`);
    }

    localStorage.setItem('token', result.data.token);
    localStorage.setItem('role', result.data.role);
    window.location.href = 'dashboard.html';
  } catch (error) {
    messageElement.textContent = error.message;
  } finally {
    loginButton.disabled = false;
    loginButton.textContent = 'Login';
  }
});
