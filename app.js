// app.js — YK2 Gaming PS-Only (PHP/MySQL backend)
'use strict';

// ─── GLOBAL STATE (override dari script inline) ──────────────
var units = [], sessions = [], savedSess = [], historyData = [];
var curPage = 'dashboard';
var MODE = 'ps';
var miUnitId = null, miJam = 1, miConsole = 'PS3';
var tjUnitId = null, tjJam = 1, tjSessId = null;
var stopUnitId = null, stopSessId = null;
var resumeSavedId = null, editingUnitId = null;
let miPayMethod = 'tunai'; // 'tunai' | 'qris'

// ─── API CONFIG ──────────────────────────────────────────────
const API = 'api.php';
async function api(action, data) {
  const ts = Date.now();
  const res = data
    ? await fetch(API + '?t=' + ts, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({action,...data}) })
    : await fetch(`${API}?action=${action}&t=${ts}`);
  const json = await res.json();
  if (json.error) throw new Error(json.error);
  return json;
}

const toLocalSQL = (date) => {
  const pad = n => String(n).padStart(2, '0');
  return `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())} ${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
};

// ─── PS-ONLY: Sembunyikan semua elemen PC + wizard ──────────
(function hidePCElements() {
  const style = document.createElement('style');
  style.textContent = `
    #setup-wizard { display:none !important; }
    #pc-btn, #mpc-btn { display:none !important; }
    #nav-saved, #bnav-saved { display:none !important; }
    #page-saved { display:none !important; }
    .mob-mbtn.mob-pc { display:none !important; }
    #stop-simpan-grp { display:none !important; }
  `;
  document.head.appendChild(style);
})();

// ─── OVERRIDE STATE (PS hardcoded) ──────────────────────────
window.addEventListener('DOMContentLoaded', () => {
  // Paksa mode PS, sembunyikan tombol PC
  if (typeof setMode === 'function') setMode('ps');
  initApp();
});

// ─── FETCH ALL (PHP API) ─────────────────────────────────────
async function fetchAll() {
  try {
    const d = await api('fetch_all');
    units       = (d.units || []).filter(u => u.mode === 'ps');
    sessions    = d.sessions    || [];
    savedSess   = [];   // PC feature — diabaikan
    historyData = d.history     || [];
    renderAll();
  } catch(e) {
    console.error(e);
    toast('Gagal koneksi server: ' + e.message, 'err');
  }
}

// ─── INIT APP (tanpa wizard, tanpa demo) ────────────────────
function initApp() {
  // Sembunyikan wizard secara paksa
  ['setup-wizard','demo-banner'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.style.cssText = 'display:none!important';
  });
  // Tampilkan main app
  const app = document.querySelector('.app');
  if (app) app.style.display = 'flex';
  // Update tanggal
  const tgl = document.getElementById('tgl-display');
  if (tgl) tgl.textContent = new Date().toLocaleDateString('id-ID', {weekday:'long',day:'numeric',month:'long',year:'numeric'});
  // Update status sidebar
  const cs = document.getElementById('conn-status');
  if (cs) cs.innerHTML = '<span class="dot-online"></span> MySQL';
  const cu = document.getElementById('conn-url-display');
  if (cu) cu.textContent = 'adminpoli @ localhost';
  fetchAll();
}

// ─── SHOW SETTINGS ───────────────────────────────────────────
function showSettings() {
  const uc = document.getElementById('set-unit-count');
  if (uc) uc.textContent = (typeof units !== 'undefined' ? units.length : '?') + ' unit PS';
  if (typeof openModal === 'function') openModal('modal-settings');
}

// ─── KONFIRMASI MULAI SESI (PHP API) ────────────────────────
async function konfirmasiMulai() {
  if (typeof units === 'undefined' || typeof miUnitId === 'undefined') return;
  const u = units.find(x => x.id === miUnitId);
  if (!u) return;
  const nama    = document.getElementById('mi-nama').value.trim() || 'Umum';
  const konsol  = document.getElementById('mi-console-custom')?.value.trim() || miConsole;
  const startTime = new Date();
  const endTime   = new Date(startTime.getTime() + miJam * 3600000);
  const total     = miJam * u.harga;
  try {
    await api('insert_session', {
      unit_id: miUnitId, unit_name: `${u.tipe} ${u.nomor}`,
      customer: nama, mode: 'ps',
      start_time: toLocalSQL(startTime), end_time: toLocalSQL(endTime),
      duration_minutes: miJam * 60, harga: u.harga,
      metode_bayar: miPayMethod
    });
    closeModal('modal-mulai');
    if (typeof showStruk === 'function')
      showStruk({type:'awal', unit:`${u.tipe} ${u.nomor}`, konsol, nama, mulai:startTime, durasi:miJam*60, berakhir:endTime, total});
    const methodLabel = miPayMethod === 'qris' ? 'QRIS' : 'Cash';
    toast(`▶ Sesi ${u.tipe} ${u.nomor} dimulai! ${miJam} jam — ${methodLabel}`, 'ok');
    miPayMethod = 'tunai'; // reset untuk sesi berikutnya
    await fetchAll();
  } catch(e) { toast('Gagal: ' + e.message, 'err'); }
}

// ─── KONFIRMASI TAMBAH JAM (PHP API) ────────────────────────
async function konfirmasiTambah() {
  const u = units.find(x => x.id === tjUnitId);
  const s = sessions.find(x => x.id === tjSessId);
  if (!u || !s) return;
  const newEnd     = new Date(new Date(s.end_time).getTime() + tjJam * 3600000);
  const extraTotal = tjJam * u.harga;
  try {
    await api('update_session', {id: s.id, end_time: toLocalSQL(newEnd), duration_minutes: s.duration_minutes + tjJam * 60});
    closeModal('modal-tambah');
    if (typeof showStruk === 'function')
      showStruk({type:'tambah', unit:`${u.tipe} ${u.nomor}`, konsol:null, nama:s.customer, mulai:new Date(s.start_time), durasi:tjJam*60, berakhir:newEnd, total:extraTotal});
    toast(`+${tjJam} jam untuk ${u.tipe} ${u.nomor}!`, 'info');
    await fetchAll();
  } catch(e) { toast('Gagal: ' + e.message, 'err'); }
}

// ─── KONFIRMASI STOP SESI (PHP API) ─────────────────────────
var _stopPaymentData = null;

async function konfirmasiStop() {
  const u = units.find(x => x.id === stopUnitId);
  const s = sessions.find(x => x.id === stopSessId);
  if (!u || !s) return;
  const endTime    = new Date();
  const durationMin = s.duration_minutes; // Bayar di depan (tetap pakai durasi yang dibeli)
  const isToken    = s.metode_bayar === 'token';
  const total      = isToken ? 0 : (durationMin / 60) * u.harga; // Prepaid: exact integer, no rounding

  // Simpan data pembayaran sementara
  _stopPaymentData = {
    session_id: s.id,
    unit_id: u.id,
    unit_name: `${u.tipe} ${u.nomor}`,
    mode: 'ps',
    tipe: u.tipe,
    customer: s.customer,
    duration_minutes: durationMin,
    total: total,
    start_time: s.start_time,
    end_time: toLocalSQL(endTime)
  };

  // Tutup modal stop lama
  closeModal('modal-stop');

  // Sesi token: sudah dibayar sebelumnya — langsung selesaikan tanpa modal pembayaran
  if (isToken) {
    toast(`Sesi token selesai. Tidak ada tagihan.`, 'info');
  }

  // Selesaikan sesi langsung menggunakan metode pembayaran yang tersimpan di sesi
  await bayarStopSesi(s.metode_bayar);
}

function tampilkanQrisSesi() {
  document.getElementById('pay-state-select').style.display = 'none';
  document.getElementById('pay-state-qris').style.display = 'block';
}

function kembaliKePilihanBayar() {
  document.getElementById('pay-state-select').style.display = 'block';
  document.getElementById('pay-state-qris').style.display = 'none';
}

async function bayarStopSesi(metodeBayar) {
  if (!_stopPaymentData) return;
  
  const payload = {
    ..._stopPaymentData,
    metode_bayar: metodeBayar
  };

  try {
    await api('stop_session', payload);
    closeModal('modal-pembayaran');
    if (metodeBayar !== 'token') {
      toast(`Sesi ${payload.unit_name} selesai.`, 'ok');
    }
    _stopPaymentData = null;
    await fetchAll();
  } catch(e) { 
    toast('Gagal menyelesaikan sesi: ' + e.message, 'err'); 
  }
}

// ─── SIMPAN UNIT (PHP API) ───────────────────────────────────
async function simpanUnit() {
  const no    = parseInt(document.getElementById('eu-no').value);
  const tipe  = document.getElementById('eu-tipe').value.trim();
  const harga = parseInt(document.getElementById('eu-harga').value);
  if (!no || !tipe || !harga) { toast('Lengkapi semua field!', 'err'); return; }
  const payload = {nomor: no, tipe, mode: 'ps', harga};
  try {
    if (editingUnitId) {
      await api('update_unit', {id: editingUnitId, ...payload});
      toast('Unit diperbarui', 'ok');
    } else {
      await api('insert_unit', payload);
      toast('Unit berhasil ditambahkan', 'ok');
    }
    closeModal('modal-unit');
    await fetchAll();
  } catch(e) { toast('Gagal: ' + e.message, 'err'); }
}

async function hapusUnit(id, name) {
  let m = document.getElementById('modal-hapus');
  if (!m) {
    m = document.createElement('div');
    m.className = 'overlay'; m.id = 'modal-hapus';
    m.innerHTML = `
      <div class="modal" style="max-width:350px">
        <div class="modal-title" style="color:var(--red)">Hapus Unit?</div>
        <p id="mh-text" style="margin:0 0 20px 0; color:var(--muted); font-size:0.95rem"></p>
        <div class="modal-actions">
          <button class="mbtn mbtn-cancel" onclick="closeModal('modal-hapus')">Batal</button>
          <button class="mbtn mbtn-red" id="mh-ok">🗑️ Ya, Hapus</button>
        </div>
      </div>`;
    document.body.appendChild(m);
  }
  document.getElementById('mh-text').textContent = `Menghapus "${name}" akan ikut menghapus semua riwayat sesinya. Yakin?`;
  document.getElementById('mh-ok').onclick = async () => {
    closeModal('modal-hapus');
    try {
      await api('delete_unit_cascade', {id});
      toast(`Unit "${name}" dihapus`, 'ok');
      await fetchAll();
    } catch(e) { toast('Gagal: ' + e.message, 'err'); }
  };
  openModal('modal-hapus');
}

// ─── HAPUS RIWAYAT (PHP API) ─────────────────────────────────
async function hapusSatuRiwayat(id) {
  let m = document.getElementById('modal-hapus-riwayat');
  if (!m) {
    m = document.createElement('div');
    m.className = 'overlay'; m.id = 'modal-hapus-riwayat';
    m.innerHTML = `
      <div class="modal" style="max-width:350px">
        <div class="modal-title" style="color:var(--red)">Hapus Riwayat?</div>
        <p style="margin:0 0 20px 0; color:var(--muted); font-size:0.95rem">Riwayat ini akan dihapus permanen. Yakin?</p>
        <div class="modal-actions">
          <button class="mbtn mbtn-cancel" onclick="closeModal('modal-hapus-riwayat')">Batal</button>
          <button class="mbtn mbtn-red" id="mhr-ok">🗑️ Ya, Hapus</button>
        </div>
      </div>`;
    document.body.appendChild(m);
  }
  document.getElementById('mhr-ok').onclick = async () => {
    closeModal('modal-hapus-riwayat');
    try { await api('delete_history', {id}); toast('Riwayat dihapus', 'ok'); await fetchAll(); }
    catch(e) { toast('Gagal: ' + e.message, 'err'); }
  };
  openModal('modal-hapus-riwayat');
}

async function hapusSemuaRiwayat() {
  let m = document.getElementById('modal-hapus-semua');
  if (!m) {
    m = document.createElement('div');
    m.className = 'overlay'; m.id = 'modal-hapus-semua';
    m.innerHTML = `
      <div class="modal" style="max-width:350px">
        <div class="modal-title" style="color:var(--red)">Hapus SEMUA Riwayat?</div>
        <p style="margin:0 0 20px 0; color:var(--muted); font-size:0.95rem">Tindakan ini akan menghapus seluruh data riwayat PS secara permanen. Lanjutkan?</p>
        <div class="modal-actions">
          <button class="mbtn mbtn-cancel" onclick="closeModal('modal-hapus-semua')">Batal</button>
          <button class="mbtn mbtn-red" id="mhs-ok">🗑️ Ya, Hapus Semua</button>
        </div>
      </div>`;
    document.body.appendChild(m);
  }
  document.getElementById('mhs-ok').onclick = async () => {
    closeModal('modal-hapus-semua');
    try { await api('delete_all_history', {mode: 'ps'}); toast('Semua riwayat dihapus', 'ok'); await fetchAll(); }
    catch(e) { toast('Gagal: ' + e.message, 'err'); }
  };
  openModal('modal-hapus-semua');
}
