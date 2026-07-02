<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consulta de Facturas Facturama</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: system-ui, sans-serif; background: #0f1117; color: #e2e8f0; min-height: 100vh; }

.header { background: #1a1d2e; border-bottom: 1px solid #2d3148; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; }
.header h1 { font-size: 16px; font-weight: 600; color: #fff; letter-spacing: 1px; }

.search-section { padding: 16px 24px; background: #13161f; border-bottom: 1px solid #2d3148; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
.search-section input { background: #0f1117; border: 1px solid #2d3148; border-radius: 8px; padding: 10px 14px; font-size: 14px; color: #e2e8f0; outline: none; flex: 1; min-width: 250px; transition: border .2s; }
.search-section input:focus { border-color: #60a5fa; }
.search-section select { background: #0f1117; border: 1px solid #2d3148; border-radius: 8px; padding: 10px 14px; font-size: 14px; color: #e2e8f0; outline: none; cursor: pointer; }
.search-section button { background: #185fa5; border: none; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600; color: #b5d4f4; cursor: pointer; transition: opacity .2s, transform .1s; letter-spacing: .5px; display: flex; align-items: center; gap: 6px; }
.search-section button:hover { opacity: .9; }
.search-section button:active { transform: scale(.97); }
.search-hint { font-size: 11px; color: #475569; width: 100%; margin-top: 4px; }

.content { padding: 20px 24px; max-width: 1200px; margin: 0 auto; }

.loading { display: none; text-align: center; padding: 40px 0; color: #64748b; }
.loading.show { display: block; }
.loading .spinner { width: 32px; height: 32px; border: 3px solid #2d3148; border-top-color: #60a5fa; border-radius: 50%; animation: spin .8s linear infinite; margin: 0 auto 12px; }
@keyframes spin { to { transform: rotate(360deg); } }

.empty-state { text-align: center; padding: 60px 0; color: #475569; }
.empty-state i { font-size: 48px; display: block; margin-bottom: 12px; }
.empty-state p { font-size: 14px; }

.error-box { background: #2d1b1b; border: 1px solid #991b1b; border-radius: 8px; padding: 14px 16px; color: #fca5a5; font-size: 13px; margin-bottom: 16px; display: none; }
.error-box.show { display: block; }

.result-card { background: #1a1d2e; border: 0.5px solid #2d3148; border-radius: 12px; overflow: hidden; display: none; }
.result-card.show { display: block; }

.result-header { padding: 16px 20px; border-bottom: 1px solid #2d3148; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
.result-header .folio-section { display: flex; align-items: center; gap: 12px; }
.result-header .folio-num { font-size: 18px; font-weight: 700; color: #fff; }
.result-header .folio-label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; }
.status-badge { font-size: 11px; padding: 4px 12px; border-radius: 20px; font-weight: 600; }
.status-badge.active { background: #0f3d2e; color: #5dcaa5; }
.status-badge.canceled { background: #3d1f1f; color: #f87171; }

.result-body { padding: 20px; }

.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
.info-group { background: #0f1117; border-radius: 8px; padding: 12px 14px; }
.info-group label { font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; display: block; margin-bottom: 4px; }
.info-group .value { font-size: 14px; font-weight: 600; color: #e2e8f0; }
.info-group .value.mono { font-family: monospace; font-size: 12px; }
.info-group.full { grid-column: 1 / -1; }

.section-title { font-size: 13px; font-weight: 700; letter-spacing: 1.5px; color: #94a3b8; text-transform: uppercase; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }

.items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
.items-table th { text-align: left; padding: 10px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; border-bottom: 1px solid #2d3148; }
.items-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #1e2235; }
.items-table tr:last-child td { border-bottom: none; }
.items-table .right { text-align: right; }

.totals-box { background: #0f1117; border-radius: 8px; padding: 16px; margin-bottom: 24px; }
.total-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
.total-row .label { color: #64748b; }
.total-row .val { font-weight: 600; }
.total-row.grand { border-top: 1px solid #2d3148; margin-top: 6px; padding-top: 10px; }
.total-row.grand .label { font-size: 14px; color: #94a3b8; font-weight: 700; }
.total-row.grand .val { font-size: 20px; font-weight: 700; color: #fff; }

.taxes-box { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
.tax-chip { background: #0f1117; border: 1px solid #2d3148; border-radius: 6px; padding: 8px 12px; font-size: 12px; }
.tax-chip .tax-name { color: #94a3b8; }
.tax-chip .tax-val { color: #fbbf24; font-weight: 600; }

.uuid-box { background: #0f1117; border: 1px solid #2d3148; border-radius: 8px; padding: 12px 14px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
.uuid-box .uuid-label { font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; }
.uuid-box .uuid-val { font-family: monospace; font-size: 13px; color: #60a5fa; }
.uuid-box button { background: transparent; border: 1px solid #2d3148; border-radius: 6px; padding: 6px 10px; color: #64748b; cursor: pointer; font-size: 14px; transition: all .2s; }
.uuid-box button:hover { border-color: #60a5fa; color: #60a5fa; }

.action-bar { display: flex; gap: 10px; flex-wrap: wrap; padding-top: 16px; border-top: 1px solid #2d3148; margin-top: 16px; }
.action-bar button { display: flex; align-items: center; gap: 6px; padding: 10px 18px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: opacity .2s, transform .1s; letter-spacing: .5px; }
.action-bar button:hover { opacity: .9; }
.action-bar button:active { transform: scale(.97); }
.btn-xml { background: #1e3a5f; color: #60a5fa; }
.btn-pdf { background: #3d1f2e; color: #f9a8d4; }
.btn-status { background: #1a3d2e; color: #5dcaa5; }

@media (max-width: 768px) {
  .info-grid { grid-template-columns: 1fr; }
  .search-section { flex-direction: column; }
  .search-section input { min-width: auto; width: 100%; }
  .search-section button { width: 100%; justify-content: center; }
  .header { flex-direction: column; gap: 8px; text-align: center; }
}
</style>
</head>
<body>

<div class="header">
  <h1><i class="ti ti-file-search" style="font-size:18px;vertical-align:-3px;margin-right:6px"></i>CONSULTA DE FACTURAS FACTURAMA</h1>
  <a href="index3.php" style="color:#64748b;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px"><i class="ti ti-arrow-left"></i> Volver al Dashboard</a>
</div>

<div class="search-section">
  <input type="text" id="search-input" placeholder="Buscar por UUID, Folio, RFC o palabra clave..." onkeydown="if(event.key==='Enter')buscar()">
  <select id="search-type">
    <option value="keyword">Palabra clave</option>
    <option value="uuid" selected>UUID (Folio Fiscal)</option>
    <option value="id">ID Interno Facturama</option>
  </select>
  <button onclick="buscar()"><i class="ti ti-search"></i> Consultar</button>
  <div class="search-hint"><i class="ti ti-info-circle"></i> Ingresa el UUID de la factura (ej: 215CEC43-7E57-44AC-9D63-B54BBC4745BD) o cualquier palabra clave</div>
</div>

<div class="content">
  <div class="loading" id="loading">
    <div class="spinner"></div>
    <span>Consultando factura...</span>
  </div>

  <div class="error-box" id="error-box"></div>

  <div class="empty-state" id="empty-state">
    <i class="ti ti-file-search"></i>
    <p>Ingresa el UUID o palabra clave para consultar una factura</p>
  </div>

  <div class="result-card" id="result-card">
    <div class="result-header">
      <div class="folio-section">
        <div>
          <div class="folio-label">Folio</div>
          <div class="folio-num" id="r-folio">--</div>
        </div>
      </div>
      <span class="status-badge active" id="r-status">Activa</span>
    </div>

    <div class="result-body">
      <div class="uuid-box">
        <div>
          <div class="uuid-label">UUID (Folio Fiscal)</div>
          <div class="uuid-val" id="r-uuid">--</div>
        </div>
        <button onclick="copiarUUID()" title="Copiar UUID"><i class="ti ti-copy"></i></button>
      </div>

      <div class="section-title"><i class="ti ti-building"></i> Informaci&oacute;n General</div>
      <div class="info-grid">
        <div class="info-group">
          <label>Emisor</label>
          <div class="value" id="r-emisor">--</div>
        </div>
        <div class="info-group">
          <label>RFC Emisor</label>
          <div class="value mono" id="r-emisor-rfc">--</div>
        </div>
        <div class="info-group">
          <label>Receptor</label>
          <div class="value" id="r-receptor">--</div>
        </div>
        <div class="info-group">
          <label>RFC Receptor</label>
          <div class="value mono" id="r-receptor-rfc">--</div>
        </div>
        <div class="info-group">
          <label>Fecha de emisi&oacute;n</label>
          <div class="value" id="r-fecha">--</div>
        </div>
        <div class="info-group">
          <label>R&eacute;gimen Fiscal</label>
          <div class="value" id="r-regimen">--</div>
        </div>
        <div class="info-group">
          <label>Uso CFDI</label>
          <div class="value" id="r-uso-cfdi">--</div>
        </div>
        <div class="info-group">
          <label>Forma de pago</label>
          <div class="value" id="r-forma-pago">--</div>
        </div>
      </div>

      <div class="section-title"><i class="ti ti-list-details"></i> Conceptos</div>
      <table class="items-table" id="items-table">
        <thead>
          <tr>
            <th style="width:50px">Cant.</th>
            <th>Descripci&oacute;n</th>
            <th style="width:120px" class="right">P. Unitario</th>
            <th style="width:120px" class="right">Importe</th>
          </tr>
        </thead>
        <tbody id="items-body"></tbody>
      </table>

      <div class="section-title"><i class="ti ti-calculator"></i> Totales</div>
      <div class="totals-box">
        <div class="total-row"><span class="label">Subtotal</span><span class="val" id="r-subtotal">$0.00</span></div>
        <div class="total-row"><span class="label">Descuento</span><span class="val" id="r-descuento">$0.00</span></div>
        <div id="taxes-container" class="taxes-box"></div>
        <div class="total-row grand"><span class="label">Total</span><span class="val" id="r-total">$0.00</span></div>
      </div>

      <div class="section-title"><i class="ti ti-download"></i> Acciones</div>
      <div class="action-bar" id="action-bar">
        <button class="btn-xml" onclick="descargar('xml')"><i class="ti ti-file-code"></i> Descargar XML</button>
        <button class="btn-pdf" onclick="descargar('pdf')"><i class="ti ti-file-text"></i> Descargar PDF</button>
        <button class="btn-status" onclick="consultarEstatus()"><i class="ti ti-shield-check"></i> Estatus SAT</button>
      </div>
    </div>
  </div>
</div>

<div style="position:fixed;bottom:24px;right:24px;background:#1a1d2e;border:1px solid #5dcaa5;border-radius:8px;padding:12px 16px;font-size:13px;color:#5dcaa5;opacity:0;transform:translateY(10px);transition:all .3s;z-index:99;pointer-events:none" id="toast"></div>

<script>
let facturaActual = null;

const currencyFormat = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: 2 });

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.style.opacity = '1';
  t.style.transform = 'translateY(0)';
  setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(10px)'; }, 2800);
}

function showError(msg) {
  const el = document.getElementById('error-box');
  el.textContent = msg;
  el.classList.add('show');
  document.getElementById('result-card').classList.remove('show');
  document.getElementById('empty-state').style.display = 'block';
}

function setLoading(v) {
  document.getElementById('loading').classList.toggle('show', v);
}

function copiarUUID() {
  const uuid = document.getElementById('r-uuid').textContent;
  if (!uuid || uuid === '--') return;
  navigator.clipboard.writeText(uuid).then(() => showToast('UUID copiado')).catch(() => {});
}

async function buscar() {
  const input = document.getElementById('search-input').value.trim();
  const type = document.getElementById('search-type').value;

  document.getElementById('error-box').classList.remove('show');
  document.getElementById('result-card').classList.remove('show');
  document.getElementById('empty-state').style.display = 'none';

  if (!input) {
    document.getElementById('empty-state').style.display = 'block';
    document.querySelector('#empty-state p').textContent = 'Ingresa un t\u00e9rmino de b\u00fasqueda';
    return;
  }

  setLoading(true);
  facturaActual = null;

  try {
    let url = 'api_factura.php?action=';
    if (type === 'uuid') {
      url += 'consultar&uuid=' + encodeURIComponent(input);
    } else if (type === 'id') {
      url += 'consultar&id=' + encodeURIComponent(input);
    } else {
      url += 'listar&q=' + encodeURIComponent(input);
    }

    const res = await fetch(url);
    const data = await res.json();

    if (!data.success) {
      showError(data.error || 'Error al consultar la factura');
      setLoading(false);
      return;
    }

    if (type === 'keyword') {
      if (!data.facturas || data.facturas.length === 0) {
        showError('No se encontraron facturas');
        setLoading(false);
        return;
      }
      mostrarLista(data.facturas);
    } else {
      if (!data.factura) {
        showError('No se encontr\u00f3 la factura');
        setLoading(false);
        return;
      }
      mostrarFactura(data.factura);
    }
  } catch (e) {
    showError('Error de conexi\u00f3n: ' + e.message);
  }
  setLoading(false);
}

function mostrarLista(facturas) {
  const card = document.getElementById('result-card');
  const body = card.querySelector('.result-body');
  body.innerHTML = `
    <div class="section-title"><i class="ti ti-list"></i> Resultados (${facturas.length})</div>
    <div style="display:flex;flex-direction:column;gap:8px">
      ${facturas.map(f => `
        <div style="background:#0f1117;border:1px solid #2d3148;border-radius:8px;padding:12px 14px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;transition:border .2s" onclick="consultarPorId('${f.Id}')" onmouseover="this.style.borderColor='#60a5fa'" onmouseout="this.style.borderColor='#2d3148'">
          <div>
            <div style="font-weight:600;color:#e2e8f0">${f.Serie || ''} ${f.Folio || ''}</div>
            <div style="font-size:11px;color:#64748b;margin-top:2px">${f.Receptor || 'Sin receptor'} | ${formatearFecha(f.Fecha)}</div>
          </div>
          <div style="text-align:right">
            <div style="font-weight:700;color:#fff">${currencyFormat.format(f.Total)}</div>
            <div style="font-size:10px;color:#475569;margin-top:2px">${f.Uuid ? f.Uuid.substring(0,8) + '...' : ''}</div>
          </div>
        </div>
      `).join('')}
    </div>
  `;
  document.querySelector('.result-header .folio-num').textContent = facturas.length + ' resultado(s)';
  document.getElementById('r-status').textContent = '';
  document.getElementById('r-uuid').textContent = '';
  card.classList.add('show');
}

async function consultarPorId(id) {
  setLoading(true);
  try {
    const res = await fetch('api_factura.php?action=consultar&id=' + encodeURIComponent(id));
    const data = await res.json();
    if (data.success && data.factura) {
      mostrarFactura(data.factura);
    } else {
      showError(data.error || 'Error al consultar detalle');
    }
  } catch (e) {
    showError('Error de conexi\u00f3n');
  }
  setLoading(false);
}

function mostrarFactura(f) {
  facturaActual = f;
  const card = document.getElementById('result-card');

  document.querySelector('.result-header .folio-num').textContent = (f.Serie || '') + ' ' + (f.Folio || '');
  document.getElementById('r-folio').textContent = (f.Serie || '') + ' ' + (f.Folio || '');

  const uuid = f.Complement && f.Complement.TaxStamp ? (f.Complement.TaxStamp.Uuid || '--') : '--';
  document.getElementById('r-uuid').textContent = uuid;

  const isActive = f.Status === undefined || f.Status === 'Active' || !f.Status;
  const statusEl = document.getElementById('r-status');
  if (uuid !== '--' && isActive) {
    statusEl.textContent = 'ACTIVA';
    statusEl.className = 'status-badge active';
  } else if (uuid !== '--') {
    statusEl.textContent = 'CANCELADA';
    statusEl.className = 'status-badge canceled';
  } else {
    statusEl.textContent = '';
  }

  document.getElementById('r-emisor').textContent = f.Issuer ? (f.Issuer.TaxName || f.Issuer.Name || '--') : '--';
  document.getElementById('r-emisor-rfc').textContent = f.Issuer ? (f.Issuer.Rfc || '--') : '--';
  document.getElementById('r-receptor').textContent = f.Receiver ? (f.Receiver.Name || '--') : '--';
  document.getElementById('r-receptor-rfc').textContent = f.Receiver ? (f.Receiver.Rfc || '--') : '--';

  document.getElementById('r-fecha').textContent = formatearFecha(f.Date);
  document.getElementById('r-regimen').textContent = f.Issuer ? (f.Issuer.FiscalRegime || '--') : '--';
  document.getElementById('r-uso-cfdi').textContent = f.Receiver ? (f.Receiver.CfdiUse || '--') : '--';
  document.getElementById('r-forma-pago').textContent = f.PaymentTerms || '--';

  const items = f.Items || [];
  const tbody = document.getElementById('items-body');
  if (items.length) {
    tbody.innerHTML = items.map(item => `
      <tr>
        <td>${item.Quantity || 1}</td>
        <td>${item.Description || '--'}</td>
        <td class="right">${currencyFormat.format(item.UnitValue || item.UnitPrice || 0)}</td>
        <td class="right">${currencyFormat.format(item.Total || 0)}</td>
      </tr>
    `).join('');
  } else {
    tbody.innerHTML = '<tr><td colspan="4" style="color:#475569;text-align:center">Sin conceptos</td></tr>';
  }

  document.getElementById('r-subtotal').textContent = currencyFormat.format(f.Subtotal || 0);
  document.getElementById('r-descuento').textContent = currencyFormat.format(f.Discount || 0);
  document.getElementById('r-total').textContent = currencyFormat.format(f.Total || 0);

  const taxes = f.Taxes || [];
  const taxesContainer = document.getElementById('taxes-container');
  if (taxes.length) {
    taxesContainer.innerHTML = taxes.map(t => `
      <div class="tax-chip">
        <span class="tax-name">${t.Name || 'IVA'}: </span>
        <span class="tax-val">${currencyFormat.format(t.Total || 0)}</span>
        <span style="color:#64748b;font-size:11px"> (${(t.Rate || 0) * 100}%)</span>
      </div>
    `).join('');
  } else {
    taxesContainer.innerHTML = '<span style="color:#475569;font-size:12px">Sin impuestos</span>';
  }

  const idFacturama = f.Id || '';
  const bar = document.getElementById('action-bar');
  bar.innerHTML = `
    <button class="btn-xml" onclick="descargar('xml')"><i class="ti ti-file-code"></i> Descargar XML</button>
    <button class="btn-pdf" onclick="descargar('pdf')"><i class="ti ti-file-text"></i> Descargar PDF</button>
    <button class="btn-status" onclick="consultarEstatus()"><i class="ti ti-shield-check"></i> Estatus SAT</button>
  `;

  card.classList.add('show');
}

function formatearFecha(fecha) {
  if (!fecha) return '--';
  try {
    const d = new Date(fecha);
    return d.toLocaleString('es-MX');
  } catch (e) {
    return fecha;
  }
}

async function descargar(formato) {
  if (!facturaActual || !facturaActual.Id) {
    showError('No hay factura seleccionada');
    return;
  }
  const id = facturaActual.Id;
  try {
    const res = await fetch('api_factura.php?action=descargar&id=' + encodeURIComponent(id) + '&formato=' + formato);
    const data = await res.json();
    if (!data.success || !data.archivo) {
      showError(data.error || 'Error al descargar');
      return;
    }
    const archivo = data.archivo;
    const byteChars = atob(archivo.content);
    const byteNums = new Array(byteChars.length);
    for (let i = 0; i < byteChars.length; i++) {
      byteNums[i] = byteChars.charCodeAt(i);
    }
    const byteArray = new Uint8Array(byteNums);
    const blob = new Blob([byteArray], { type: 'application/' + formato });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = (facturaActual.Serie || 'F') + (facturaActual.Folio || '') + '.' + formato;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast(formato.toUpperCase() + ' descargado');
  } catch (e) {
    showError('Error al descargar');
  }
}

async function consultarEstatus() {
  if (!facturaActual) return;
  const uuid = facturaActual.Complement?.TaxStamp?.Uuid;
  const emisorRfc = facturaActual.Issuer?.Rfc;
  const receptorRfc = facturaActual.Receiver?.Rfc;
  const total = facturaActual.Total;
  if (!uuid || !emisorRfc || !receptorRfc || !total) {
    showError('Faltan datos para consultar el estatus SAT');
    return;
  }
  try {
    const res = await fetch('api_factura.php?action=estatus&uuid=' + encodeURIComponent(uuid)
      + '&emisor_rfc=' + encodeURIComponent(emisorRfc)
      + '&receptor_rfc=' + encodeURIComponent(receptorRfc)
      + '&total=' + encodeURIComponent(total));
    const data = await res.json();
    if (data.success) {
      const estatus = data.data;
      let msg = 'Estatus SAT: ';
      if (typeof estatus === 'string') msg += estatus;
      else msg += JSON.stringify(estatus);
      showToast(msg);
    } else {
      showError(data.error || 'Error al consultar estatus');
    }
  } catch (e) {
    showError('Error de conexi\u00f3n');
  }
}

window.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const uuid = params.get('uuid');
  const q = params.get('q');
  if (uuid) {
    document.getElementById('search-input').value = uuid;
    document.getElementById('search-type').value = 'uuid';
    buscar();
  } else if (q) {
    document.getElementById('search-input').value = q;
    document.getElementById('search-type').value = 'keyword';
    buscar();
  }
});
</script>

</body>
</html>
