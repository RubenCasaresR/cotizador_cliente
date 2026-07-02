<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Factura Facturama</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: system-ui, sans-serif; background: #0f1117; color: #e2e8f0; min-height: 100vh; }

.header { background: #1a1d2e; border-bottom: 1px solid #2d3148; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
.header h1 { font-size: 16px; font-weight: 600; color: #fff; letter-spacing: 1px; }
.header-links { display: flex; gap: 12px; }
.header-links a { color: #64748b; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 4px; transition: color .2s; }
.header-links a:hover { color: #60a5fa; }

.content { padding: 20px 24px; max-width: 1200px; margin: 0 auto; }

.section-card { background: #1a1d2e; border: 0.5px solid #2d3148; border-radius: 12px; padding: 20px; margin-bottom: 16px; }
.section-title { font-size: 13px; font-weight: 700; letter-spacing: 1.5px; color: #94a3b8; text-transform: uppercase; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form-grid.three { grid-template-columns: 1fr 1fr 1fr; }
.form-group { display: flex; flex-direction: column; gap: 4px; }
.form-group.full { grid-column: 1 / -1; }
.form-group label { font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; font-weight: 600; }
.form-group label .req { color: #f87171; }
.form-group input, .form-group select { background: #0f1117; border: 1px solid #2d3148; border-radius: 8px; padding: 10px 12px; font-size: 14px; color: #e2e8f0; outline: none; transition: border .2s; }
.form-group input:focus, .form-group select:focus { border-color: #60a5fa; }
.form-group input:disabled { opacity: .5; cursor: not-allowed; }
.form-group select option { background: #1a1d2e; color: #e2e8f0; }

.items-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
.items-table th { text-align: left; padding: 8px 10px; font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: .8px; border-bottom: 1px solid #2d3148; }
.items-table td { padding: 6px 10px; border-bottom: 1px solid #1e2235; vertical-align: middle; }
.items-table td input, .items-table td select { width: 100%; background: #0f1117; border: 1px solid #2d3148; border-radius: 6px; padding: 8px 10px; font-size: 13px; color: #e2e8f0; outline: none; transition: border .2s; }
.items-table td input:focus, .items-table td select:focus { border-color: #60a5fa; }
.items-table td .importe-cell { font-weight: 600; font-size: 13px; text-align: right; padding-top: 10px; }
.items-table td .btn-remove-item { background: transparent; border: 1px solid #5f1d1d; border-radius: 6px; padding: 6px 8px; color: #f87171; cursor: pointer; font-size: 14px; transition: all .2s; }
.items-table td .btn-remove-item:hover { background: #5f1d1d; }

.btn-add-item { background: transparent; border: 1px dashed #2d3148; border-radius: 8px; padding: 10px; color: #64748b; cursor: pointer; font-size: 13px; width: 100%; text-align: center; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 16px; }
.btn-add-item:hover { border-color: #60a5fa; color: #60a5fa; }

.totals-box { background: #0f1117; border-radius: 8px; padding: 16px; }
.total-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
.total-row .label { color: #64748b; }
.total-row .val { font-weight: 600; }
.total-row.grand { border-top: 1px solid #2d3148; margin-top: 6px; padding-top: 10px; }
.total-row.grand .label { font-size: 14px; color: #94a3b8; font-weight: 700; }
.total-row.grand .val { font-size: 20px; font-weight: 700; color: #fff; }

.btn-submit { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 15px; font-weight: 700; letter-spacing: .5px; cursor: pointer; transition: opacity .2s, transform .1s; background: #0f6e56; color: #9fe1cb; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 16px; }
.btn-submit:hover { opacity: .9; }
.btn-submit:active { transform: scale(.98); }
.btn-submit:disabled { opacity: .4; cursor: not-allowed; }
.btn-submit.loading { pointer-events: none; }

.loading-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 50; justify-content: center; align-items: center; flex-direction: column; gap: 12px; }
.loading-overlay.show { display: flex; }
.loading-overlay .spinner { width: 40px; height: 40px; border: 3px solid #2d3148; border-top-color: #5dcaa5; border-radius: 50%; animation: spin .8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }
.loading-overlay span { color: #94a3b8; font-size: 14px; }

.result-modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 60; justify-content: center; align-items: center; padding: 24px; }
.result-modal.show { display: flex; }
.result-content { background: #1a1d2e; border: 1px solid #2d3148; border-radius: 12px; width: 100%; max-width: 520px; padding: 28px; }
.result-content .icon-success { text-align: center; font-size: 48px; color: #5dcaa5; margin-bottom: 12px; }
.result-content h2 { text-align: center; font-size: 18px; color: #fff; margin-bottom: 20px; }
.result-info { background: #0f1117; border-radius: 8px; padding: 14px 16px; margin-bottom: 12px; }
.result-info .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
.result-info .row .rl { color: #64748b; }
.result-info .row .rv { font-weight: 600; color: #e2e8f0; font-family: monospace; }
.result-info .row .rv.uuid { color: #60a5fa; }
.result-actions { display: flex; gap: 10px; margin-top: 20px; }
.result-actions a { flex: 1; text-align: center; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: opacity .2s; }
.result-actions a:hover { opacity: .9; }
.result-actions .btn-view { background: #185fa5; color: #b5d4f4; }
.result-actions .btn-close { background: #2d3148; color: #94a3b8; cursor: pointer; border: none; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 600; transition: opacity .2s; }
.result-actions .btn-close:hover { opacity: .9; }

.error-msg { background: #2d1b1b; border: 1px solid #991b1b; border-radius: 8px; padding: 12px 14px; color: #fca5a5; font-size: 13px; display: none; margin-bottom: 12px; }
.error-msg.show { display: block; }

.toast { position: fixed; bottom: 24px; right: 24px; background: #1a1d2e; border: 1px solid #5dcaa5; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #5dcaa5; opacity: 0; transform: translateY(10px); transition: all .3s; z-index: 99; pointer-events: none; }

@media (max-width: 768px) {
  .form-grid { grid-template-columns: 1fr; }
  .form-grid.three { grid-template-columns: 1fr; }
  .header { flex-direction: column; text-align: center; }
  .items-table { font-size: 12px; }
  .items-table td, .items-table th { padding: 4px 6px; }
}
</style>
</head>
<body>

<div class="header">
  <h1><i class="ti ti-file-plus" style="font-size:18px;vertical-align:-3px;margin-right:6px"></i>CREAR FACTURA FACTURAMA</h1>
  <div class="header-links">
    <a href="consulta_factura.php"><i class="ti ti-file-search"></i> Consultar facturas</a>
    <a href="index3.php"><i class="ti ti-arrow-left"></i> Dashboard</a>
  </div>
</div>

<div class="content">
  <div class="error-msg" id="error-msg"></div>

  <form id="factura-form" onsubmit="return false;">

    <div class="section-card">
      <div class="section-title"><i class="ti ti-building"></i> Datos del Emisor</div>
      <div class="form-grid">
        <div class="form-group">
          <label>RFC <span class="req">*</span></label>
          <input type="text" id="e-rfc" placeholder="RFC del emisor" required>
        </div>
        <div class="form-group">
          <label>Nombre <span class="req">*</span></label>
          <input type="text" id="e-nombre" placeholder="Razón social" required>
        </div>
        <div class="form-group">
          <label>Régimen Fiscal <span class="req">*</span></label>
          <select id="e-regimen" required><option value="">Cargando...</option></select>
        </div>
        <div class="form-group">
          <label>Código Postal <span class="req">*</span></label>
          <input type="text" id="e-cp" placeholder="Código postal" maxlength="5" required>
        </div>
      </div>
    </div>

    <div class="section-card">
      <div class="section-title"><i class="ti ti-user"></i> Datos del Receptor</div>
      <div class="form-grid">
        <div class="form-group">
          <label>RFC <span class="req">*</span></label>
          <input type="text" id="r-rfc" placeholder="RFC del cliente" required>
        </div>
        <div class="form-group">
          <label>Nombre <span class="req">*</span></label>
          <input type="text" id="r-nombre" placeholder="Nombre o razón social" required>
        </div>
        <div class="form-group">
          <label>Régimen Fiscal <span class="req">*</span></label>
          <select id="r-regimen" required><option value="">Cargando...</option></select>
        </div>
        <div class="form-group">
          <label>Uso CFDI <span class="req">*</span></label>
          <select id="r-uso-cfdi" required><option value="">Cargando...</option></select>
        </div>
        <div class="form-group">
          <label>Código Postal <span class="req">*</span></label>
          <input type="text" id="r-cp" placeholder="Código postal" maxlength="5" required>
        </div>
      </div>
    </div>

    <div class="section-card">
      <div class="section-title"><i class="ti ti-settings"></i> Configuraci&oacute;n de la Factura</div>
      <div class="form-grid three">
        <div class="form-group">
          <label>Serie</label>
          <input type="text" id="f-serie" placeholder="Ej: FAC">
        </div>
        <div class="form-group">
          <label>Folio</label>
          <input type="text" id="f-folio" placeholder="Auto">
        </div>
        <div class="form-group">
          <label>Forma de Pago <span class="req">*</span></label>
          <select id="f-forma-pago" required><option value="">Cargando...</option></select>
        </div>
        <div class="form-group">
          <label>M&eacute;todo de Pago <span class="req">*</span></label>
          <select id="f-metodo-pago" required>
            <option value="PUE">PUE - Pago en una sola exhibici&oacute;n</option>
            <option value="PPD">PPD - Pago en parcialidades</option>
          </select>
        </div>
        <div class="form-group">
          <label>Lugar de Expedici&oacute;n (CP) <span class="req">*</span></label>
          <input type="text" id="f-exp-cp" placeholder="C&oacute;digo postal" maxlength="5" required>
        </div>
        <div class="form-group">
          <label>Moneda</label>
          <select id="f-moneda">
            <option value="MXN">MXN - Peso Mexicano</option>
            <option value="USD">USD - D&oacute;lar</option>
          </select>
        </div>
      </div>
    </div>

    <div class="section-card">
      <div class="section-title"><i class="ti ti-list-details"></i> Conceptos</div>
      <table class="items-table" id="items-table">
        <thead>
          <tr>
            <th style="width:36px">#</th>
            <th>Descripci&oacute;n</th>
            <th style="width:80px">Cant.</th>
            <th style="width:120px">P. Unitario</th>
            <th style="width:80px">IVA %</th>
            <th style="width:120px">Importe</th>
            <th style="width:40px"></th>
          </tr>
        </thead>
        <tbody id="items-body"></tbody>
      </table>
      <button class="btn-add-item" onclick="agregarItem()" type="button"><i class="ti ti-plus"></i> Agregar concepto</button>

      <div class="totals-box">
        <div class="total-row"><span class="label">Subtotal</span><span class="val" id="t-subtotal">$0.00</span></div>
        <div id="t-taxes-container"></div>
        <div class="total-row grand"><span class="label">Total</span><span class="val" id="t-total">$0.00</span></div>
      </div>
    </div>

    <button class="btn-submit" id="btn-submit" onclick="crearFactura()" type="button">
      <i class="ti ti-cloud-upload"></i> Timbrar Factura
    </button>
  </form>
</div>

<div class="loading-overlay" id="loading-overlay">
  <div class="spinner"></div>
  <span>Timbrando factura...</span>
</div>

<div class="result-modal" id="result-modal">
  <div class="result-content">
    <div class="icon-success"><i class="ti ti-circle-check"></i></div>
    <h2>Factura creada exitosamente</h2>
    <div class="result-info">
      <div class="row"><span class="rl">Folio</span><span class="rv" id="res-folio">--</span></div>
      <div class="row"><span class="rl">UUID</span><span class="rv uuid" id="res-uuid">--</span></div>
      <div class="row"><span class="rl">Total</span><span class="rv" id="res-total">--</span></div>
      <div class="row"><span class="rl">Receptor</span><span class="rv" id="res-receptor">--</span></div>
    </div>
    <div class="result-actions">
      <a class="btn-view" id="res-consultar-link" href="consulta_factura.php?uuid=" target="_blank"><i class="ti ti-file-search"></i> Ver detalle</a>
      <button class="btn-close" onclick="cerrarResultado()"><i class="ti ti-x"></i> Cerrar</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
let itemCount = 0;

const currencyFmt = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: 2 });

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.style.opacity = '1'; t.style.transform = 'translateY(0)';
  setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(10px)'; }, 2800);
}

function showError(msg) {
  const el = document.getElementById('error-msg');
  el.textContent = msg; el.classList.add('show');
}

function hideError() {
  document.getElementById('error-msg').classList.remove('show');
}

async function cargarCatalogo(tipo, selectId, textoVacio) {
  try {
    const res = await fetch('api_factura.php?action=catalogo&tipo=' + tipo);
    const data = await res.json();
    const sel = document.getElementById(selectId);
    if (data.success && Array.isArray(data.data)) {
      sel.innerHTML = '<option value="">' + (textoVacio || 'Seleccionar...') + '</option>';
      data.data.forEach(item => {
        const opt = document.createElement('option');
        opt.value = item.Name || item.id || item.value || '';
        opt.textContent = (item.Name || '') + (item.Description ? ' - ' + item.Description : '');
        sel.appendChild(opt);
      });
    }
  } catch (e) {
    console.error('Error cargando catálogo ' + tipo, e);
  }
}

async function cargarEmisor() {
  try {
    const res = await fetch('api_factura.php?action=emisor');
    const data = await res.json();
    if (data.success && data.emisor) {
      const e = data.emisor;
      document.getElementById('e-rfc').value = e.Rfc || '';
      document.getElementById('e-nombre').value = e.Name || '';
      document.getElementById('e-cp').value = e.TaxZipCode || '';
      document.getElementById('f-exp-cp').value = e.TaxZipCode || '';
      if (e.FiscalRegime) {
        const sel = document.getElementById('e-regimen');
        for (const opt of sel.options) {
          if (opt.value && opt.value.startsWith(e.FiscalRegime)) {
            opt.selected = true; break;
          }
        }
      }
    }
  } catch (e) { console.error('Error cargando emisor', e); }
}

async function init() {
  await Promise.all([
    cargarCatalogo('fiscalRegimens', 'e-regimen', 'Seleccionar...'),
    cargarCatalogo('fiscalRegimens', 'r-regimen', 'Seleccionar...'),
    cargarCatalogo('cfdiUses', 'r-uso-cfdi', 'Seleccionar...'),
    cargarCatalogo('paymentForms', 'f-forma-pago', 'Seleccionar...'),
    cargarEmisor(),
  ]);
  agregarItem();
}

function agregarItem(desc, cant, precio, iva) {
  itemCount++;
  const idx = itemCount;
  const tbody = document.getElementById('items-body');
  const tr = document.createElement('tr');
  tr.id = 'item-' + idx;
  tr.innerHTML = `
    <td style="color:#475569;font-size:12px">${idx}</td>
    <td><input type="text" class="item-desc" placeholder="Descripci&oacute;n del producto o servicio" value="${desc || ''}" oninput="calcTotales()"></td>
    <td><input type="number" class="item-cant" value="${cant || 1}" min="0.001" step="1" oninput="calcTotales()"></td>
    <td><input type="number" class="item-precio" value="${precio || ''}" min="0" step="0.01" oninput="calcTotales()"></td>
    <td>
      <select class="item-iva" oninput="calcTotales()">
        <option value="0" ${iva == 0 ? 'selected' : ''}>0%</option>
        <option value="0.08" ${iva == 0.08 ? 'selected' : ''}>8%</option>
        <option value="0.16" ${(iva === undefined || iva == 0.16) ? 'selected' : ''}>16%</option>
      </select>
    </td>
    <td class="importe-cell"><span class="item-importe" id="imp-${idx}">$0.00</span></td>
    <td><button class="btn-remove-item" onclick="quitarItem(${idx})" type="button"><i class="ti ti-trash"></i></button></td>
  `;
  tbody.appendChild(tr);
  calcTotales();
}

function quitarItem(idx) {
  const el = document.getElementById('item-' + idx);
  if (el) { el.remove(); calcTotales(); }
}

function calcTotales() {
  let subtotal = 0;
  let taxes = {};
  const rows = document.querySelectorAll('#items-body tr');

  rows.forEach(row => {
    const desc = row.querySelector('.item-desc');
    const cant = row.querySelector('.item-cant');
    const precio = row.querySelector('.item-precio');
    const ivaSel = row.querySelector('.item-iva');
    const impSpan = row.querySelector('.item-importe');

    const c = parseFloat(cant?.value) || 0;
    const p = parseFloat(precio?.value) || 0;
    const importe = c * p;
    const ivaRate = parseFloat(ivaSel?.value) || 0;

    subtotal += importe;
    if (ivaRate > 0) {
      const ivaTotal = importe * ivaRate;
      const key = 'IVA ' + (ivaRate * 100) + '%';
      taxes[key] = (taxes[key] || 0) + ivaTotal;
    }

    if (impSpan) impSpan.textContent = currencyFmt.format(importe);
  });

  const totalTaxes = Object.values(taxes).reduce((a, b) => a + b, 0);
  const total = subtotal + totalTaxes;

  document.getElementById('t-subtotal').textContent = currencyFmt.format(subtotal);

  const tc = document.getElementById('t-taxes-container');
  const taxKeys = Object.keys(taxes);
  if (taxKeys.length) {
    tc.innerHTML = taxKeys.map(k =>
      '<div class="total-row"><span class="label">' + k + '</span><span class="val" style="color:#fbbf24">' + currencyFmt.format(taxes[k]) + '</span></div>'
    ).join('');
  } else {
    tc.innerHTML = '<div class="total-row"><span class="label">Sin impuestos</span><span class="val" style="color:#64748b">$0.00</span></div>';
  }

  document.getElementById('t-total').textContent = currencyFmt.format(total);
}

function getItemsData() {
  const items = [];
  const rows = document.querySelectorAll('#items-body tr');
  rows.forEach(row => {
    const desc = row.querySelector('.item-desc')?.value.trim();
    const cant = parseFloat(row.querySelector('.item-cant')?.value) || 0;
    const precio = parseFloat(row.querySelector('.item-precio')?.value) || 0;
    const ivaRate = parseFloat(row.querySelector('.item-iva')?.value) || 0;
    if (!desc || cant <= 0 || precio <= 0) return;

    const subt = cant * precio;
    const taxes = [];
    if (ivaRate > 0) {
      taxes.push({
        Name: 'IVA',
        Rate: ivaRate,
        Total: parseFloat((subt * ivaRate).toFixed(2)),
        Base: parseFloat(subt.toFixed(2)),
        IsRetention: false,
      });
    }
    items.push({
      ProductCode: '01010101',
      Description: desc,
      Unit: 'Pieza',
      UnitCode: 'H87',
      UnitPrice: parseFloat(precio.toFixed(2)),
      Quantity: cant,
      Subtotal: parseFloat(subt.toFixed(2)),
      TaxObject: taxes.length ? '02' : '01',
      Taxes: taxes,
      Total: parseFloat((subt + taxes.reduce((a, t) => a + t.Total, 0)).toFixed(2)),
    });
  });
  return items;
}

function validarForm() {
  const reqs = [
    ['e-rfc', 'RFC del emisor'],
    ['e-nombre', 'Nombre del emisor'],
    ['e-regimen', 'Régimen fiscal del emisor'],
    ['e-cp', 'Código postal del emisor'],
    ['r-rfc', 'RFC del receptor'],
    ['r-nombre', 'Nombre del receptor'],
    ['r-regimen', 'Régimen fiscal del receptor'],
    ['r-uso-cfdi', 'Uso CFDI'],
    ['r-cp', 'Código postal del receptor'],
    ['f-forma-pago', 'Forma de pago'],
    ['f-exp-cp', 'Lugar de expedición'],
  ];
  for (const [id, label] of reqs) {
    const el = document.getElementById(id);
    if (!el.value.trim()) {
      showError('Campo requerido: ' + label);
      el.focus();
      return false;
    }
  }
  const items = getItemsData();
  if (!items.length) {
    showError('Debe agregar al menos un concepto válido');
    return false;
  }
  return true;
}

async function crearFactura() {
  hideError();
  if (!validarForm()) return;

  const items = getItemsData();
  const subtotal = items.reduce((a, i) => a + i.Subtotal, 0);
  const totalTaxes = items.reduce((a, i) => a + i.Taxes.reduce((t, tx) => t + tx.Total, 0), 0);
  const total = items.reduce((a, i) => a + i.Total, 0);

  const payload = {
    CfdiType: 'I',
    Serie: document.getElementById('f-serie').value.trim() || undefined,
    Folio: document.getElementById('f-folio').value.trim() || undefined,
    Currency: document.getElementById('f-moneda').value,
    ExpeditionPlace: document.getElementById('f-exp-cp').value.trim(),
    PaymentForm: document.getElementById('f-forma-pago').value,
    PaymentMethod: document.getElementById('f-metodo-pago').value,
    Exportation: '01',
    Issuer: {
      Rfc: document.getElementById('e-rfc').value.trim(),
      Name: document.getElementById('e-nombre').value.trim(),
      FiscalRegime: document.getElementById('e-regimen').value,
    },
    Receiver: {
      Rfc: document.getElementById('r-rfc').value.trim(),
      Name: document.getElementById('r-nombre').value.trim(),
      CfdiUse: document.getElementById('r-uso-cfdi').value,
      FiscalRegime: document.getElementById('r-regimen').value,
      TaxZipCode: document.getElementById('r-cp').value.trim(),
    },
    Items: items,
    Subtotal: subtotal,
    Total: total,
  };

  document.getElementById('loading-overlay').classList.add('show');
  document.getElementById('btn-submit').classList.add('loading');
  document.getElementById('btn-submit').disabled = true;

  try {
    const res = await fetch('api_factura.php?action=crear', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
    const data = await res.json();

    if (!data.success) {
      const errMsg = typeof data.error === 'string' ? data.error
        : (data.error?.message || JSON.stringify(data.error));
      showError('Error al crear factura: ' + errMsg);
      return;
    }

    const f = data.factura;
    const uuid = f.Complement?.TaxStamp?.Uuid || '--';
    const folio = (f.Serie || '') + ' ' + (f.Folio || '');
    document.getElementById('res-folio').textContent = folio.trim() || '--';
    document.getElementById('res-uuid').textContent = uuid;
    document.getElementById('res-total').textContent = currencyFmt.format(f.Total || 0);
    document.getElementById('res-receptor').textContent = f.Receiver?.Name || '--';

    const consultarLink = document.getElementById('res-consultar-link');
    consultarLink.href = 'consulta_factura.php?uuid=' + encodeURIComponent(uuid);

    document.getElementById('loading-overlay').classList.remove('show');
    document.getElementById('result-modal').classList.add('show');
  } catch (e) {
    showError('Error de conexión: ' + e.message);
  }
  document.getElementById('btn-submit').classList.remove('loading');
  document.getElementById('btn-submit').disabled = false;
  document.getElementById('loading-overlay').classList.remove('show');
}

function cerrarResultado() {
  document.getElementById('result-modal').classList.remove('show');
  document.getElementById('factura-form').reset();
  document.getElementById('items-body').innerHTML = '';
  agregarItem();
  calcTotales();
}

document.addEventListener('DOMContentLoaded', init);
</script>
</body>
</html>
