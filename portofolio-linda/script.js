document.getElementById('year').textContent = new Date().getFullYear();
const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

// Efek mengetik (ganti daftar peran sesukamu)
const roles = ['Software Engineer', 'Web Developer', 'Mahasiswa Teknik Informatika', 'Master of Ceremony'];
const typed = document.getElementById('typed');
let r = 0, c = 0, del = false;
function type() {
  const word = roles[r];
  typed.textContent = word.slice(0, c);
  if (!del && c === word.length) { del = true; return setTimeout(type, 1400); }
  if (del && c === 0) { del = false; r = (r + 1) % roles.length; }
  c += del ? -1 : 1;
  setTimeout(type, del ? 45 : 90);
}
reduce ? typed.textContent = roles[0] : type();

// Muncul saat di-scroll + bar keahlian + angka berhitung
const io = new IntersectionObserver(entries => entries.forEach(e => {
  if (!e.isIntersecting) return;
  e.target.classList.add('show');
  e.target.querySelectorAll('.bars').forEach(b => b.classList.add('show'));
  e.target.querySelectorAll('[data-count]').forEach(el => {
    const target = +el.dataset.count; let n = 0;
    const t = setInterval(() => { el.textContent = ++n; if (n >= target) clearInterval(t); }, 90);
  });
  io.unobserve(e.target);
}), { threshold: .2 });
document.querySelectorAll('.reveal').forEach(el => io.observe(el));
document.querySelectorAll('.bars').forEach(b => io.observe(b));

// Progress bar scroll + cahaya mengikuti kursor
const progress = document.getElementById('progress');
addEventListener('scroll', () => {
  const h = document.documentElement;
  progress.style.width = (h.scrollTop / (h.scrollHeight - h.clientHeight) * 100) + '%';
});
const glow = document.getElementById('glow');
addEventListener('mousemove', e => { glow.style.left = e.clientX + 'px'; glow.style.top = e.clientY + 'px'; });

// Filter proyek
const chips = document.querySelectorAll('.chip'), cards = document.querySelectorAll('.card');
chips.forEach(chip => chip.addEventListener('click', () => {
  chips.forEach(x => x.classList.remove('active')); chip.classList.add('active');
  const f = chip.dataset.filter;
  cards.forEach(card => { card.classList.toggle('hide', f !== 'all' && card.dataset.cat !== f); });
}));

// Form kontak membuka WhatsApp dengan pesan yang sudah diisi.
document.getElementById('contact-form').addEventListener('submit', e => {
  e.preventDefault();
  const d = new FormData(e.target);
  const body = encodeURIComponent(`Halo Linda, saya ${d.get('nama')} (${d.get('email')}).\n\n${d.get('pesan')}`);
  location.href = `https://wa.me/6283846947918?text=${body}`;
  document.getElementById('form-status').textContent = 'WhatsApp terbuka dengan pesan Anda. Tekan Kirim di WhatsApp untuk mengirimnya.';
});

// Jendela detail & bukti (proyek, pengalaman, sertifikat, dokumentasi)
const dlg = document.getElementById('dlg'), dImg = document.getElementById('dlg-img');
const dlgVideo = document.getElementById('dlg-video'), dlgVideoWrap = document.getElementById('dlg-video-wrap');
const dlgLink = document.getElementById('dlg-link');
document.addEventListener('click', e => {
  const t = e.target.closest('[data-title]');
  if (!t || e.target.closest('a, video') || t.closest('dialog')) return;
  const d = t.dataset;
  document.getElementById('dlg-title').textContent = d.title;
  document.getElementById('dlg-meta').textContent = d.meta || '';
  document.getElementById('dlg-desc').textContent = d.desc || '';
  document.getElementById('dlg-dl').innerHTML = [['Peran', d.role], ['Teknologi', d.tech], ['Hasil', d.result]]
    .filter(r => r[1]).map(r => `<dt>${r[0]}</dt><dd>${r[1]}</dd>`).join('');
  dlgVideo.pause();
  dlgVideoWrap.hidden = !d.video;
  const videoSource = dlgVideo.querySelector('source');
  if (d.video) {
    videoSource.src = d.video;
    dlgVideo.poster = d.img || '';
  } else {
    videoSource.removeAttribute('src');
    dlgVideo.removeAttribute('poster');
  }
  dlgVideo.load();
  dlgLink.hidden = !d.link;
  if (d.link) { dlgLink.href = d.link; dlgLink.textContent = d.linkLabel || 'Lihat proyek'; }
  dImg.hidden = true;
  if (d.img) { dImg.onload = () => dImg.hidden = false; dImg.onerror = () => dImg.hidden = true; dImg.src = d.img; }
  dlg.showModal();
});
dlg.addEventListener('close', () => dlgVideo.pause());
document.getElementById('dlg-x').addEventListener('click', () => dlg.close());
dlg.addEventListener('click', e => { if (e.target === dlg) dlg.close(); });
