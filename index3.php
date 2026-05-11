<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Divisas</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: system-ui, sans-serif; background: #0f1117; color: #e2e8f0; min-height: 100vh; }

  .header { background: #1a1d2e; border-bottom: 1px solid #2d3148; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; }
  .header h1 { font-size: 16px; font-weight: 600; color: #fff; letter-spacing: 1px; }
  .live-badge { background: #0f6e56; color: #9fe1cb; font-size: 12px; padding: 4px 12px; border-radius: 20px; display: flex; align-items: center; gap: 6px; }
  .dot { width: 7px; height: 7px; border-radius: 50%; background: #5dcaa5; animation: pulse 1.5s infinite; }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
  .clock { font-size: 13px; color: #94a3b8; font-variant-numeric: tabular-nums; }

  .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; padding: 16px 24px; }
  .stat { background: #1a1d2e; border: 0.5px solid #2d3148; border-radius: 10px; padding: 14px 16px; }
  .stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 6px; }
  .stat-val { font-size: 22px; font-weight: 600; }
  .stat-val.green { color: #5dcaa5; }
  .stat-val.blue { color: #60a5fa; }
  .stat-val.amber { color: #fbbf24; }
  .stat-val.red { color: #f87171; }
  .stat-sub { font-size: 11px; color: #64748b; margin-top: 4px; }

  .main { display: grid; grid-template-columns: 1fr 1fr 380px; gap: 0; height: calc(100vh - 130px); }

  .panel { padding: 20px; border-right: 1px solid #2d3148; display: flex; flex-direction: column; gap: 16px; overflow-y: auto; }
  .panel-title { font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-align: center; padding: 10px; border-radius: 8px; }
  .panel-title.compra { background: #0f6e56; color: #9fe1cb; }
  .panel-title.venta { background: #185fa5; color: #b5d4f4; }

  .field { display: flex; flex-direction: column; gap: 6px; }
  .field label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; }
  .input-wrap { position: relative; display: flex; align-items: center; }
  .input-wrap span { position: absolute; left: 12px; color: #64748b; font-size: 14px; }
  .input-wrap input { width: 100%; background: #0f1117; border: 1px solid #2d3148; border-radius: 8px; padding: 10px 12px 10px 28px; font-size: 15px; color: #e2e8f0; outline: none; transition: border .2s; }
  .input-wrap input:focus { border-color: #5dcaa5; }
  .input-wrap .unit { left: auto; right: 12px; font-size: 12px; }

  .slider-wrap { display: flex; align-items: center; gap: 10px; }
  .slider-wrap input[type=range] { flex: 1; accent-color: #5dcaa5; }
  .slider-val { font-size: 13px; font-weight: 600; min-width: 40px; text-align: right; color: #5dcaa5; }

  .result-box { background: #0f1117; border: 1px solid #2d3148; border-radius: 10px; padding: 14px 16px; }
  .result-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 13px; }
  .result-row:not(:last-child) { border-bottom: 1px solid #1e2235; }
  .result-label { color: #64748b; }
  .result-val { font-weight: 600; }
  .result-val.neg { color: #f87171; }
  .result-val.pos { color: #5dcaa5; }
  .total-row { display: flex; justify-content: space-between; align-items: center; margin-top: 6px; }
  .total-label { font-size: 13px; color: #94a3b8; font-weight: 600; }
  .total-val { font-size: 20px; font-weight: 700; color: #fff; }

  .btn { width: 100%; padding: 12px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; letter-spacing: .5px; cursor: pointer; transition: opacity .2s, transform .1s; }
  .btn:hover { opacity: .9; }
  .btn:active { transform: scale(.98); }
  .btn.compra { background: #0f6e56; color: #9fe1cb; }
  .btn.venta { background: #185fa5; color: #b5d4f4; }

  .historial { padding: 16px; overflow-y: auto; background: #13161f; }
  .hist-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
  .hist-title { font-size: 13px; font-weight: 700; letter-spacing: 1px; color: #94a3b8; text-transform: uppercase; }
  .search-box { position: relative; }
  .search-box input { background: #0f1117; border: 1px solid #2d3148; border-radius: 6px; padding: 6px 10px 6px 30px; font-size: 12px; color: #e2e8f0; outline: none; width: 160px; }
  .search-box i { position: absolute; left: 8px; top: 50%; transform: translateY(-50%); color: #475569; font-size: 14px; }

  .filter-bar { display: flex; gap: 6px; margin-bottom: 12px; }
  .filter-btn { font-size: 11px; padding: 4px 10px; border-radius: 20px; border: 1px solid #2d3148; background: transparent; color: #64748b; cursor: pointer; transition: all .2s; }
  .filter-btn.active { background: #1e3a5f; border-color: #378add; color: #60a5fa; }

  .cot-card { background: #1a1d2e; border: 0.5px solid #2d3148; border-radius: 10px; margin-bottom: 10px; overflow: hidden; transition: border .2s; }
  .cot-card:hover { border-color: #3d4268; }
  .cot-header { display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; cursor: pointer; }
  .cot-id { font-size: 12px; font-weight: 600; color: #94a3b8; }
  .cot-date { font-size: 10px; color: #475569; margin-top: 2px; }
  .badge { font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 600; }
  .badge.compra { background: #0f3d2e; color: #5dcaa5; }
  .badge.venta { background: #0c2a47; color: #60a5fa; }
  .cot-body { padding: 0 12px 12px; border-top: 1px solid #1e2235; }
  .cot-row { display: flex; justify-content: space-between; font-size: 12px; padding: 4px 0; }
  .cot-row span:first-child { color: #475569; }
  .cot-row span:last-child { font-weight: 500; }
  .cot-total { display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-top: 6px; padding-top: 6px; border-top: 1px solid #1e2235; }
  .cot-total span:last-child { color: #fff; }
  .cot-actions { display: flex; gap: 8px; margin-top: 10px; }
  .icon-btn { background: transparent; border: 1px solid #2d3148; border-radius: 6px; padding: 5px 8px; color: #64748b; cursor: pointer; font-size: 14px; transition: all .2s; }
  .icon-btn:hover { border-color: #5dcaa5; color: #5dcaa5; }
  .icon-btn.red:hover { border-color: #f87171; color: #f87171; }
  .toast { position: fixed; bottom: 24px; right: 24px; background: #1a1d2e; border: 1px solid #5dcaa5; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #5dcaa5; opacity: 0; transform: translateY(10px); transition: all .3s; z-index: 99; pointer-events: none; }
  .toast.show { opacity: 1; transform: translateY(0); }
  .empty { text-align: center; color: #475569; font-size: 13px; padding: 30px 0; }
</style>
</head>
<body>

<div class="header">
  <h1><i class="ti ti-currency-dollar" style="font-size:18px;vertical-align:-3px;margin-right:6px" aria-hidden="true"></i>DASHBOARD DIVISAS</h1>
  <div style="display:flex;align-items:center;gap:16px;">
    <div class="clock" id="clock">00:00:00</div>
    <div class="live-badge"><div class="dot"></div><span id="live-rate">$17.34 MXN</span> en vivo</div>
  </div>
</div>

<div class="stats">
  <div class="stat">
    <div class="stat-label">Tipo de cambio compra</div>
    <div class="stat-val green" id="rate-compra-stat">$17.34</div>
    <div class="stat-sub">USD/MXN</div>
  </div>
  <div class="stat">
    <div class="stat-label">Tipo de cambio venta</div>
    <div class="stat-val blue" id="rate-venta-stat">$17.47</div>
    <div class="stat-sub">USD/MXN</div>
  </div>
  <div class="stat">
    <div class="stat-label">Operaciones hoy</div>
    <div class="stat-val amber" id="ops-hoy">0</div>
    <div class="stat-sub">cotizaciones guardadas</div>
  </div>
  <div class="stat">
    <div class="stat-label">Volumen total (MXN)</div>
    <div class="stat-val red" id="vol-total">$0.00</div>
    <div class="stat-sub">suma neto del día</div>
  </div>
</div>

<div class="main">
  <!-- COMPRA -->
  <div class="panel">
    <div class="panel-title compra">COMPRA DLLS</div>
    <div class="field">
      <label>Cantidad en USD</label>
      <div class="input-wrap">
        <span>$</span>
        <input type="number" id="c-usd" placeholder="0.00" min="0" step="100" oninput="calcCompra()">
      </div>
    </div>
    <div class="field">
      <label>Tipo de cambio</label>
      <div class="input-wrap">
        <span>$</span>
        <input type="number" id="c-tc" placeholder="17.34" step="0.01" oninput="calcCompra()">
      </div>
    </div>
    <div class="field">
      <label>Comisión (%)</label>
      <div class="slider-wrap">
        <input type="range" id="c-com-slider" min="0" max="10" step="0.1" value="0" oninput="syncCom('c','slider')">
        <span class="slider-val" id="c-com-disp">0.0%</span>
      </div>
      <div class="input-wrap">
        <input type="number" id="c-com" placeholder="0.0" min="0" max="10" step="0.1" oninput="syncCom('c','input')">
        <span class="unit">%</span>
      </div>
    </div>
    <div class="result-box">
      <div class="result-row"><span class="result-label">Conversión (MXN)</span><span class="result-val" id="c-conv">$0.00</span></div>
      <div class="result-row"><span class="result-label">Comisión (resta)</span><span class="result-val neg" id="c-com-val">-$0.00</span></div>
      <div class="total-row"><span class="total-label">TOTAL NETO</span><span class="total-val" id="c-total">$0.00</span></div>
    </div>
    <button class="btn compra" onclick="guardar('compra')"><i class="ti ti-device-floppy" aria-hidden="true"></i> Guardar y Ver</button>
  </div>

  <!-- VENTA -->
  <div class="panel">
    <div class="panel-title venta">VENTA DLLS</div>
    <div class="field">
      <label>Cantidad en USD</label>
      <div class="input-wrap">
        <span>$</span>
        <input type="number" id="v-usd" placeholder="0.00" min="0" step="100" oninput="calcVenta()">
      </div>
    </div>
    <div class="field">
      <label>Tipo de cambio</label>
      <div class="input-wrap">
        <span>$</span>
        <input type="number" id="v-tc" placeholder="17.47" step="0.01" oninput="calcVenta()">
      </div>
    </div>
    <div class="field">
      <label>Comisión (%)</label>
      <div class="slider-wrap">
        <input type="range" id="v-com-slider" min="0" max="10" step="0.1" value="0" oninput="syncCom('v','slider')">
        <span class="slider-val" id="v-com-disp">0.0%</span>
      </div>
      <div class="input-wrap">
        <input type="number" id="v-com" placeholder="0.0" min="0" max="10" step="0.1" oninput="syncCom('v','input')">
        <span class="unit">%</span>
      </div>
    </div>
    <div class="result-box">
      <div class="result-row"><span class="result-label">Conversión (MXN)</span><span class="result-val" id="v-conv">$0.00</span></div>
      <div class="result-row"><span class="result-label">Comisión (suma)</span><span class="result-val pos" id="v-com-val">+$0.00</span></div>
      <div class="total-row"><span class="total-label">TOTAL NETO</span><span class="total-val" id="v-total">$0.00</span></div>
    </div>
    <button class="btn venta" onclick="guardar('venta')"><i class="ti ti-device-floppy" aria-hidden="true"></i> Guardar y Ver</button>
  </div>

  <!-- HISTORIAL -->
  <div class="historial">
    <div class="hist-header">
      <div class="hist-title"><i class="ti ti-history" aria-hidden="true"></i> Historial</div>
      <div class="search-box">
        <i class="ti ti-search" aria-hidden="true"></i>
        <input type="text" id="buscar" placeholder="Buscar folio..." oninput="renderHist()">
      </div>
    </div>
    <div class="filter-bar">
      <button class="filter-btn active" onclick="setFilter('todos',this)">Todos</button>
      <button class="filter-btn" onclick="setFilter('compra',this)">Compra</button>
      <button class="filter-btn" onclick="setFilter('venta',this)">Venta</button>
    </div>
    <div id="hist-list"></div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
let historial = [];
let filtro = 'todos';
let baseRate = 17.34;
let folio = 1000 + Math.floor(Math.random() * 9000);

function fmt(n) { return '$' + Number(n).toLocaleString('es-MX', {minimumFractionDigits:2,maximumFractionDigits:2}); }

function initRates() {
  document.getElementById('c-tc').value = baseRate.toFixed(2);
  document.getElementById('v-tc').value = (baseRate + 0.13).toFixed(2);
  document.getElementById('rate-compra-stat').textContent = '$' + baseRate.toFixed(2);
  document.getElementById('rate-venta-stat').textContent = '$' + (baseRate + 0.13).toFixed(2);
  document.getElementById('live-rate').textContent = '$' + baseRate.toFixed(2) + ' MXN';
}

function updateClock() {
  const now = new Date();
  document.getElementById('clock').textContent = now.toLocaleTimeString('es-MX');
}

function calcCompra() {
  const usd = parseFloat(document.getElementById('c-usd').value) || 0;
  const tc = parseFloat(document.getElementById('c-tc').value) || 0;
  const com = parseFloat(document.getElementById('c-com').value) || 0;
  const conv = usd * tc;
  const comVal = conv * (com / 100);
  const total = conv - comVal;
  document.getElementById('c-conv').textContent = fmt(conv);
  document.getElementById('c-com-val').textContent = '-' + fmt(comVal);
  document.getElementById('c-total').textContent = fmt(total);
}

function calcVenta() {
  const usd = parseFloat(document.getElementById('v-usd').value) || 0;
  const tc = parseFloat(document.getElementById('v-tc').value) || 0;
  const com = parseFloat(document.getElementById('v-com').value) || 0;
  const conv = usd * tc;
  const comVal = conv * (com / 100);
  const total = conv + comVal;
  document.getElementById('v-conv').textContent = fmt(conv);
  document.getElementById('v-com-val').textContent = '+' + fmt(comVal);
  document.getElementById('v-total').textContent = fmt(total);
}

function syncCom(p, src) {
  const slider = document.getElementById(p + '-com-slider');
  const input = document.getElementById(p + '-com');
  const disp = document.getElementById(p + '-com-disp');
  if (src === 'slider') {
    input.value = parseFloat(slider.value).toFixed(1);
  } else {
    let v = Math.min(10, Math.max(0, parseFloat(input.value) || 0));
    slider.value = v;
  }
  disp.textContent = parseFloat(slider.value).toFixed(1) + '%';
  p === 'c' ? calcCompra() : calcVenta();
}

function guardar(tipo) {
  const pfx = tipo === 'compra' ? 'c' : 'v';
  const usd = parseFloat(document.getElementById(pfx + '-usd').value) || 0;
  const tc = parseFloat(document.getElementById(pfx + '-tc').value) || 0;
  const com = parseFloat(document.getElementById(pfx + '-com').value) || 0;
  if (!usd || !tc) { showToast('⚠️ Ingresa cantidad y tipo de cambio'); return; }
  const conv = usd * tc;
  const comVal = conv * (com / 100);
  const total = tipo === 'compra' ? conv - comVal : conv + comVal;
  const now = new Date();
  const entry = {
    id: 'COT-' + (++folio),
    tipo,
    fecha: now.toLocaleString('es-MX'),
    usd,
    tc,
    com,
    total,
    open: true
  };
  historial.unshift(entry);
  renderHist();
  updateStats();
  showToast('✓ ' + entry.id + ' guardada correctamente');
}

function updateStats() {
  document.getElementById('ops-hoy').textContent = historial.length;
  const vol = historial.reduce((a, e) => a + e.total, 0);
  document.getElementById('vol-total').textContent = fmt(vol);
}

function setFilter(f, btn) {
  filtro = f;
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderHist();
}

function renderHist() {
  const q = document.getElementById('buscar').value.toLowerCase();
  const list = document.getElementById('hist-list');
  const items = historial.filter(e => {
    const matchFiltro = filtro === 'todos' || e.tipo === filtro;
    const matchQ = !q || e.id.toLowerCase().includes(q) || e.fecha.includes(q);
    return matchFiltro && matchQ;
  });
  if (!items.length) { list.innerHTML = '<div class="empty"><i class="ti ti-inbox" style="font-size:28px;display:block;margin-bottom:8px" aria-hidden="true"></i>Sin resultados</div>'; return; }
  list.innerHTML = items.map(e => `
    <div class="cot-card">
      <div class="cot-header" onclick="this.parentElement.querySelector('.cot-body').style.display=this.parentElement.querySelector('.cot-body').style.display==='none'?'block':'none'">
        <div>
          <div class="cot-id">${e.id}</div>
          <div class="cot-date">${e.fecha}</div>
        </div>
        <span class="badge ${e.tipo}">${e.tipo.toUpperCase()}</span>
      </div>
      <div class="cot-body">
        <div class="cot-row"><span>Dólares (USD):</span><span>${fmt(e.usd)}</span></div>
        <div class="cot-row"><span>Tipo de cambio:</span><span>$${e.tc.toFixed(2)}</span></div>
        <div class="cot-row"><span>Comisión aplicada:</span><span>${e.com.toFixed(2)}%</span></div>
        <div class="cot-total"><span>Total neto:</span><span>${fmt(e.total)}</span></div>
        <div class="cot-actions">
          <button class="icon-btn" title="Ver" onclick="showToast('Folio ${e.id} — Total: ${fmt(e.total)}')"><i class="ti ti-eye" aria-hidden="true"></i></button>
          <button class="icon-btn" title="Descargar" onclick="showToast('Descarga no disponible en demo')"><i class="ti ti-download" aria-hidden="true"></i></button>
          <button class="icon-btn" title="Editar" onclick="showToast('Edición no disponible en demo')"><i class="ti ti-edit" aria-hidden="true"></i></button>
          <button class="icon-btn red" title="Eliminar" onclick="eliminar('${e.id}')"><i class="ti ti-trash" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
  `).join('');
}

function eliminar(id) {
  historial = historial.filter(e => e.id !== id);
  renderHist();
  updateStats();
  showToast('Cotización eliminada');
}

let toastTimer;
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}

setInterval(updateClock, 1000);
updateClock();
initRates();
renderHist();

setInterval(() => {
  const delta = (Math.random() - 0.5) * 0.04;
  baseRate = Math.max(17, Math.min(18, baseRate + delta));
  document.getElementById('live-rate').textContent = '$' + baseRate.toFixed(2) + ' MXN';
}, 8000);
</script>
</body>
</html>