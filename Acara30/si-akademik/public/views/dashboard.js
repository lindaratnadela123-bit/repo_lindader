'use strict';

const API_BASE_URL = new URL('../', window.location.href).href.replace(/\/$/, '');
const token = localStorage.getItem('token');
const role = localStorage.getItem('role');
const isAdmin = role === 'admin';
const statusElement = document.querySelector('#status');
const notificationElement = document.querySelector('#notification');
const loadingIndicator = document.querySelector('#loading-indicator');
const listElement = document.querySelector('#mahasiswa-list');
const form = document.querySelector('#mahasiswa-form');
const management = document.querySelector('#management');
let editingId = null;

if (!token || !role) {
  window.location.replace('login.html');
} else {
  document.querySelector('#role-label').textContent = role;
  management.hidden = !isAdmin;
  document.querySelector('#actions-heading').hidden = !isAdmin;
  loadMahasiswa();
}

function setStatus(message, isError = false) {
  statusElement.textContent = message;
  statusElement.classList.toggle('error', isError);
}

function showNotification(message, isError = false) {
  notificationElement.textContent = message;
  notificationElement.className = `alert ${isError ? 'alert-danger' : 'alert-success'}`;
  notificationElement.hidden = false;
}

function logout() {
  localStorage.removeItem('token');
  localStorage.removeItem('role');
  window.location.replace('login.html');
}

async function apiRequest(path, options = {}) {
  const isFormData = options.body instanceof FormData;
  const response = await window.fetchWithNetworkRetry(`${API_BASE_URL}${path}`, {
    ...options,
    headers: {
      Accept: 'application/json',
      ...(options.body && !isFormData ? { 'Content-Type': 'application/json' } : {}),
      Authorization: `Bearer ${token}`,
      ...options.headers,
    },
  });
  const result = await response.json();
  if (!response.ok || !result.success) {
    if (response.status === 401) logout();
    const details = Object.entries(result.errors || {})
      .flatMap(([field, messages]) => messages.map((message) => `${field}: ${message}`))
      .join(' ');
    throw new Error([result.message, details].filter(Boolean).join(' '));
  }
  return result;
}

function makeCell(value) {
  const cell = document.createElement('td');
  cell.textContent = String(value ?? '');
  return cell;
}

async function loadMahasiswa() {
  setStatus('Memuat data...');
  loadingIndicator.hidden = false;
  listElement.replaceChildren();
  try {
    const result = await apiRequest('/mahasiswa');
    if (!Array.isArray(result.data)) throw new Error('Format data dari API tidak sesuai.');
    document.querySelector('#total').textContent = String(result.data.length);
    if (result.data.length === 0) {
      setStatus('Belum ada data mahasiswa.');
      return;
    }

    for (const mahasiswa of result.data) {
      const row = document.createElement('tr');
      const photoCell = document.createElement('td');
      if (typeof mahasiswa.foto === 'string' && /^[a-f0-9]{32}\.(jpg|png)$/.test(mahasiswa.foto)) {
        const image = document.createElement('img');
        image.className = 'student-photo';
        image.alt = `Foto ${mahasiswa.nama}`;
        image.src = `${API_BASE_URL}/uploads/${encodeURIComponent(mahasiswa.foto)}`;
        photoCell.append(image);
      } else {
        photoCell.textContent = '—';
      }
      row.append(photoCell, makeCell(mahasiswa.nim), makeCell(mahasiswa.nama), makeCell(mahasiswa.prodi));
      if (isAdmin) {
        const actions = document.createElement('td');
        const editButton = document.createElement('button');
        editButton.type = 'button';
        editButton.className = 'btn btn-sm btn-outline-primary me-2';
        editButton.textContent = 'Ubah';
        editButton.addEventListener('click', () => beginEdit(mahasiswa));
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-sm btn-outline-danger';
        deleteButton.textContent = 'Hapus';
        deleteButton.addEventListener('click', () => deleteMahasiswa(mahasiswa.id, deleteButton));
        actions.append(editButton, deleteButton);
        row.append(actions);
      }
      listElement.append(row);
    }
    setStatus(`${result.data.length} data mahasiswa.`);
  } catch (error) {
    setStatus(`Gagal memuat data: ${error.message}`, true);
  } finally {
    loadingIndicator.hidden = true;
  }
}

function beginEdit(mahasiswa) {
  editingId = mahasiswa.id;
  form.elements.namedItem('nim').value = mahasiswa.nim;
  form.elements.namedItem('nama').value = mahasiswa.nama;
  form.elements.namedItem('prodi').value = mahasiswa.prodi;
  form.elements.namedItem('foto').value = '';
  document.querySelector('#save-button').textContent = 'Simpan perubahan';
  document.querySelector('#cancel-edit').hidden = false;
}

function resetForm() {
  editingId = null;
  form.reset();
  document.querySelector('#save-button').textContent = 'Tambah';
  document.querySelector('#cancel-edit').hidden = true;
}

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  if (!isAdmin) return;
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  const nim = form.elements.namedItem('nim').value.trim();
  if (!/^[0-9]{9}$/.test(nim)) {
    showNotification('NIM wajib terdiri dari 9 digit.', true);
    form.elements.namedItem('nim').focus();
    return;
  }
  const file = form.elements.namedItem('foto').files[0];
  if (file && (!['image/jpeg', 'image/png'].includes(file.type) || file.size > 2 * 1024 * 1024)) {
    showNotification('Foto harus JPG/PNG dan berukuran maksimal 2MB.', true);
    return;
  }
  const formData = new FormData(form);
  const wasEditing = editingId !== null;
  formData.set('nim', nim);
  if (editingId) formData.append('_method', 'PUT');
  const button = document.querySelector('#save-button');
  button.disabled = true;
  button.textContent = 'Menyimpan...';
  try {
    await apiRequest(editingId ? `/mahasiswa?id=${encodeURIComponent(editingId)}` : '/mahasiswa', {
      method: 'POST',
      body: formData,
    });
    resetForm();
    await loadMahasiswa();
    showNotification(wasEditing ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
  } catch (error) {
    showNotification(error.message, true);
  } finally {
    button.disabled = false;
    button.textContent = editingId ? 'Simpan perubahan' : 'Tambah';
  }
});

async function deleteMahasiswa(id, button) {
  if (!isAdmin || !window.confirm('Hapus data mahasiswa ini?')) return;
  button.disabled = true;
  button.textContent = 'Menghapus...';
  try {
    await apiRequest(`/mahasiswa?id=${encodeURIComponent(id)}`, { method: 'DELETE' });
    await loadMahasiswa();
    showNotification('Data berhasil dihapus.');
  } catch (error) {
    showNotification(error.message, true);
  } finally {
    button.disabled = false;
    button.textContent = 'Hapus';
  }
}

document.querySelector('#cancel-edit').addEventListener('click', resetForm);
document.querySelector('#logout').addEventListener('click', logout);
