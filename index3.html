  <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Divisas</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
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

  .main { display: grid; grid-template-columns: 1fr 1fr 380px; gap: 0; height: calc(100vh - 178px); }

  .panel { padding: 20px; border-right: 1px solid #2d3148; display: flex; flex-direction: column; gap: 16px; overflow-y: auto; position: relative; }
  .panel-title { font-size: 13px; font-weight: 700; letter-spacing: 1.5px; padding: 12px 16px; border-radius: 8px; display: flex; align-items: center; gap: 8px; }
  .panel-title.compra { background: rgba(15,110,86,0.40); border-left: 3px solid #0f6e56; color: #5dcaa5; }
  .panel-title.venta { background: rgba(24,95,165,0.40); border-left: 3px solid #185fa5; color: #60a5fa; }
  .edit-badge { display: none; position: absolute; top: -10px; right: -10px; background: #f59e0b; color: #000; font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 20px; z-index: 10; align-items: center; gap: 4px; }
  .edit-badge.show { display: flex; }
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
  .filter-btn:hover { border-color: #5dcaa5; color: #5dcaa5; }
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

  .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 50; justify-content: center; align-items: center; padding: 24px; }
  .modal-overlay.show { display: flex; }
  .modal-content { background: #1a1d2e; border-radius: 12px; width: 100%; max-width: 900px; height: 90vh; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #2d3148; }
  .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #2d3148; }
  .modal-header h3 { font-size: 16px; font-weight: 700; color: #e2e8f0; }
  .modal-close { background: #ef4444; border: none; color: white; padding: 6px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 13px; }
  .modal-close:hover { opacity: .9; }
  .modal-body { flex: 1; }
  .modal-body iframe { width: 100%; height: 100%; border: none; }
  .btn-row { display: flex; gap: 8px; }
  .btn-row .btn { flex: 1; }
  .btn-sm { flex: 0 0 auto; padding: 12px 16px; background: #6b7280; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; display: none; transition: opacity .2s; }
  .btn-sm:hover { opacity: .9; }
  .btn-sm.show { display: block; }

  #tab-cotizador { display: grid; grid-template-columns: 1fr 1fr 380px; gap: 0; height: calc(100vh - 178px); }

  @media (max-width: 1024px) {
    #tab-cotizador { grid-template-columns: 1fr; height: auto; }
    .main { grid-template-columns: 1fr; }
    .panel { border-right: none; border-bottom: 1px solid #2d3148; }
    .stats { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 640px) {
    .stats { grid-template-columns: 1fr; }
    .header { flex-direction: column; gap: 8px; }
  }

  .chart-section { padding: 16px 24px; background: #0f1117; border-top: 1px solid #2d3148; }
  .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
  .chart-title { font-size: 13px; font-weight: 700; letter-spacing: 1px; color: #94a3b8; text-transform: uppercase; display: flex; align-items: center; gap: 6px; }
  .chart-box { background: #1a1d2e; border: 0.5px solid #2d3148; border-radius: 10px; padding: 16px; position: relative; height: 380px; }
  .chart-box canvas { width: 100% !important; height: 100% !important; }
  .chart-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 11px; color: #475569; }
  .chart-footer .live-dot { width: 6px; height: 6px; border-radius: 50%; background: #5dcaa5; display: inline-block; animation: pulse 1.5s infinite; margin-right: 4px; }

  .alerta-bar { background: #1a1d2e; border-bottom: 1px solid #2d3148; padding: 12px 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
  .alerta-bar .alerta-title { font-size: 13px; font-weight: 700; letter-spacing: 1px; color: #fbbf24; text-transform: uppercase; display: flex; align-items: center; gap: 6px; }
  .alerta-bar input { background: #0f1117; border: 1px solid #2d3148; border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #e2e8f0; outline: none; width: 110px; transition: border .2s; }
  .alerta-bar input:focus { border-color: #fbbf24; }
  .alerta-bar button { background: #f59e0b; border: none; border-radius: 8px; padding: 8px 16px; font-size: 12px; font-weight: 600; color: #000; cursor: pointer; transition: opacity .2s, transform .1s; letter-spacing: .5px; }
  .alerta-bar button:hover { opacity: .85; }
  .alerta-bar button:active { transform: scale(.97); }
  .alerta-bar button.active { background: #dc2626; color: #fff; }
  .alerta-bar .alerta-status { font-size: 11px; color: #64748b; }

  .alerta-visual { position: fixed; top: 0; left: 0; right: 0; z-index: 9999; padding: 18px 24px; text-align: center; font-weight: 700; font-size: 15px; transform: translateY(-100%); transition: transform .5s cubic-bezier(.22,1,.36,1); box-shadow: 0 6px 24px rgba(0,0,0,.6); display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; cursor: pointer; }
  .alerta-visual.show { transform: translateY(0); }
  .alerta-visual.up { background: linear-gradient(135deg, #064e3b, #059669); color: #6ee7b7; }
  .alerta-visual.down { background: linear-gradient(135deg, #7f1d1d, #dc2626); color: #fca5a5; }
  .alerta-visual .alerta-icon { font-size: 24px; }
  .alerta-visual .alerta-close { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: inherit; opacity: .6; font-size: 20px; cursor: pointer; padding: 4px 8px; border-radius: 4px; }
  .alerta-visual .alerta-close:hover { opacity: 1; background: rgba(0,0,0,.2); }
  .alerta-visual .alerta-change { font-size: 12px; font-weight: 400; opacity: .8; }
</style>
</head>
<body>

<div class="header">
  <h1><i class="ti ti-currency-dollar" style="font-size:18px;vertical-align:-3px;margin-right:6px"></i>DASHBOARD DIVISAS</h1>
  <div style="display:flex;align-items:center;gap:16px;">
    <a href="crear_factura_ui.php" style="color:#60a5fa;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;transition:opacity .2s" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"><i class="ti ti-file-plus"></i> Facturaci&oacute;n</a>
    <div class="clock" id="clock">00:00:00</div>
    <div class="live-badge"><div class="dot"></div><span id="live-rate">$17.34 MXN</span> en vivo</div>
  </div>
</div>


<!-- ALERTAS DE PRECIO -->
<div class="alerta-bar">
  <div class="alerta-title"><i class="ti ti-bell-ringing"></i> ALERTAS DE PRECIO</div>
  <input type="number" id="alerta-min" placeholder="M&iacute;n $" step="0.01">
  <input type="number" id="alerta-max" placeholder="M&aacute;x $" step="0.01">
  <button id="btn-alertas" onclick="toggleAlertas()">Activar Monitoreo</button>
  <span class="alerta-status" id="alerta-status">Establece un l&iacute;mite m&iacute;nimo o m&aacute;ximo</span>
</div>

<!-- COTIZADOR STATS -->
<div id="cotizador-stats" class="stats">
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
    <div class="stat-sub">suma neto del d&iacute;a</div>
  </div>
</div>



<!-- COTIZADOR TAB -->
<div id="tab-cotizador">
  <div class="panel">
    <div id="edit-badge-compra" class="edit-badge"><i class="ti ti-edit"></i> Editando</div>
    <div class="panel-title compra"><i class="ti ti-trending-down"></i> COMPRA DLLS</div>
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
      <label>Comisi&oacute;n (%)</label>
      <div class="slider-wrap">
        <input type="range" id="c-com-slider" min="0" max="10" step="0.1" value="0" oninput="syncCom('c','slider')">
        <span class="slider-val" id="c-com-disp">0.0%</span>
      </div>
      <div class="input-wrap">
        <input type="number" id="c-com" placeholder="0.0" min="0" max="10" step="0.1" oninput="syncCom('c','input')">
        <span class="unit">%</span>
      </div>
    </div>
    <div class="field">
      <label>Nombre del Cliente</label>
      <div class="input-wrap">
        <i class="ti ti-user" style="position:absolute;left:10px;color:#64748b;font-size:14px"></i>
        <input type="text" id="c-nombre" placeholder="Nombre completo" style="padding-left:32px">
      </div>
    </div>
    <div class="field">
      <label>Correo Electr&oacute;nico</label>
      <div class="input-wrap">
        <i class="ti ti-mail" style="position:absolute;left:10px;color:#64748b;font-size:14px"></i>
        <input type="email" id="c-correo" placeholder="cliente@ejemplo.com" style="padding-left:32px">
      </div>
    </div>
    <div class="result-box">
      <div class="result-row"><span class="result-label">Conversi&oacute;n (MXN)</span><span class="result-val" id="c-conv">$0.00</span></div>
      <div class="result-row"><span class="result-label">Comisi&oacute;n (resta)</span><span class="result-val neg" id="c-com-val">-$0.00</span></div>
      <div class="total-row"><span class="total-label">TOTAL NETO</span><span class="total-val" id="c-total">$0.00</span></div>
    </div>
    <div class="btn-row">
      <button class="btn compra" id="btn-compra" onclick="guardar('compra')"><i class="ti ti-device-floppy"></i> Guardar y Ver</button>
      <button class="btn-sm" id="cancel-compra" onclick="cancelarEdicion('compra')"><i class="ti ti-x"></i></button>
    </div>
  </div>

  <div class="panel">
    <div id="edit-badge-venta" class="edit-badge"><i class="ti ti-edit"></i> Editando</div>
    <div class="panel-title venta"><i class="ti ti-trending-up"></i> VENTA DLLS</div>
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
      <label>Comisi&oacute;n (%)</label>
      <div class="slider-wrap">
        <input type="range" id="v-com-slider" min="0" max="10" step="0.1" value="0" oninput="syncCom('v','slider')">
        <span class="slider-val" id="v-com-disp">0.0%</span>
      </div>
      <div class="input-wrap">
        <input type="number" id="v-com" placeholder="0.0" min="0" max="10" step="0.1" oninput="syncCom('v','input')">
        <span class="unit">%</span>
      </div>
    </div>
    <div class="field">
      <label>Nombre del Cliente</label>
      <div class="input-wrap">
        <i class="ti ti-user" style="position:absolute;left:10px;color:#64748b;font-size:14px"></i>
        <input type="text" id="v-nombre" placeholder="Nombre completo" style="padding-left:32px">
      </div>
    </div>
    <div class="field">
      <label>Correo Electr&oacute;nico</label>
      <div class="input-wrap">
        <i class="ti ti-mail" style="position:absolute;left:10px;color:#64748b;font-size:14px"></i>
        <input type="email" id="v-correo" placeholder="cliente@ejemplo.com" style="padding-left:32px">
      </div>
    </div>
    <div class="result-box">
      <div class="result-row"><span class="result-label">Conversi&oacute;n (MXN)</span><span class="result-val" id="v-conv">$0.00</span></div>
      <div class="result-row"><span class="result-label">Comisi&oacute;n (suma)</span><span class="result-val pos" id="v-com-val">+$0.00</span></div>
      <div class="total-row"><span class="total-label">TOTAL NETO</span><span class="total-val" id="v-total">$0.00</span></div>
    </div>
    <div class="btn-row">
      <button class="btn venta" id="btn-venta" onclick="guardar('venta')"><i class="ti ti-device-floppy"></i> Guardar y Ver</button>
      <button class="btn-sm" id="cancel-venta" onclick="cancelarEdicion('venta')"><i class="ti ti-x"></i></button>
    </div>
  </div>

  <div class="historial">
    <div class="hist-header">
      <div class="hist-title"><i class="ti ti-history"></i> Historial</div>
      <div class="search-box">
        <i class="ti ti-search"></i>
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

<!-- CHART SECTION -->
<div class="chart-section">
  <div class="chart-header">
    <div class="chart-title"><i class="ti ti-chart-line" style="color:#5dcaa5"></i> Precio USD/MXN en Vivo</div>
    <div class="filter-bar" style="margin-bottom:0">
      <button class="filter-btn active" onclick="cargarChart('1d',this)">24 Horas</button>
      <button class="filter-btn" onclick="cargarChart('5d',this)">1 Semana</button>
      <button class="filter-btn" onclick="cargarChart('1mo',this)">1 Mes</button>
    </div>
  </div>
  <div class="chart-box">
    <canvas id="chart-dolar"></canvas>
  </div>
  <div class="chart-footer">
    <span><span class="live-dot"></span> Actualizando cada 60s</span>
    <span id="chart-update-info">Esperando datos...</span>
  </div>
</div>

<div class="toast" id="toast"></div>

<div class="modal-overlay" id="modal-preview">
  <div class="modal-content">
    <div class="modal-header">
      <h3><i class="ti ti-file-text"></i> Vista Previa del Documento</h3>
      <button class="modal-close" onclick="cerrarVistaPrevia()">Cerrar</button>
    </div>
    <div class="modal-body">
      <iframe id="preview-iframe"></iframe>
    </div>
  </div>
</div>

<div style="position:absolute;left:-9999px;top:-9999px">
  <div id="plantilla-pdf" style="width:800px;padding:60px;background:white;color:black;font-family:system-ui,sans-serif">
    <h1 style="font-size:28px;font-weight:900;text-align:center;text-transform:uppercase;letter-spacing:2px;margin-bottom:50px" id="pdf-titulo-tipo">COTIZACI&Oacute;N</h1>
    <table style="width:100%;border-collapse:collapse;margin-bottom:30px;border:2px solid #666">
      <tbody>
        <tr style="border-bottom:1px solid #ccc"><td style="padding:10px 14px;width:33%;background:#f3f4f6;font-weight:700;color:#000">Folio:</td><td style="padding:10px 14px;font-weight:600;color:#000" id="pdf-folio"></td></tr>
        <tr><td style="padding:10px 14px;width:33%;background:#f3f4f6;font-weight:700;color:#000">Fecha y hora de emisi&oacute;n:</td><td style="padding:10px 14px;font-weight:600;color:#000" id="pdf-fecha"></td></tr>
        <tr><td style="padding:10px 14px;width:33%;background:#f3f4f6;font-weight:700;color:#000">Cliente:</td><td style="padding:10px 14px;font-weight:600;color:#000" id="pdf-cliente"></td></tr>
        <tr><td style="padding:10px 14px;width:33%;background:#f3f4f6;font-weight:700;color:#000">Correo:</td><td style="padding:10px 14px;font-weight:600;color:#000" id="pdf-correo"></td></tr>
      </tbody>
    </table>
    <table style="width:100%;border-collapse:collapse;margin-bottom:50px;border:2px solid #666;border-radius:6px;overflow:hidden">
      <thead><tr style="background:#e5e7eb;color:#000"><th style="padding:12px 16px;font-weight:900;text-transform:uppercase;font-size:12px;border-bottom:2px solid #666;width:50%;text-align:left">Concepto</th><th style="padding:12px 16px;font-weight:900;text-transform:uppercase;font-size:12px;border-bottom:2px solid #666;text-align:left">Detalle</th></tr></thead>
      <tbody style="background:white">
        <tr style="border-bottom:1px solid #ddd"><td style="padding:10px 16px;font-weight:600;color:#000">Monto en d&oacute;lares (USD)</td><td style="padding:10px 16px;font-family:monospace;font-weight:700;color:#000" id="pdf-usd"></td></tr>
        <tr style="border-bottom:1px solid #ddd"><td style="padding:10px 16px;font-weight:600;color:#000">Tipo de cambio</td><td style="padding:10px 16px;font-family:monospace;font-weight:700;color:#000" id="pdf-tc"></td></tr>
        <tr style="border-bottom:1px solid #ddd"><td style="padding:10px 16px;font-weight:600;color:#000">Conversi&oacute;n base a pesos</td><td style="padding:10px 16px;font-family:monospace;font-weight:700;color:#000" id="pdf-conversion"></td></tr>
        <tr style="border-bottom:1px solid #ddd"><td style="padding:10px 16px;font-weight:600;color:#000">Comisi&oacute;n aplicada (<span id="pdf-pct-txt"></span>%)</td><td style="padding:10px 16px;font-family:monospace;font-weight:700;color:#000" id="pdf-comision"></td></tr>
        <tr style="background:#f9fafb"><td style="padding:14px 16px;font-weight:900;font-size:16px;color:#000">Total Neto</td><td style="padding:14px 16px;font-family:monospace;font-weight:900;font-size:16px;color:#000" id="pdf-total"></td></tr>
      </tbody>
    </table>
    <div style="font-size:12px;color:#000;margin-top:60px;text-align:center;border-top:2px solid #666;padding-top:24px">
      <p style="font-weight:600;margin-bottom:4px">Nota: Esta cotizaci&oacute;n es de car&aacute;cter informativo y est&aacute; sujeta a la volatilidad del mercado cambiario en tiempo real.</p>
      <p style="font-weight:900">Vigencia: Esta cotizaci&oacute;n tiene una vigencia de 30 minutos a partir de su hora de emisi&oacute;n.</p>
    </div>
  </div>
</div>



<script>
let historial = [];
let filtro = 'todos';
let editandoId = null;
let editandoTipo = null;
let alertasActivas = false;
let audioCtx = null;
let ultimoPrecio = null;

const currencyFormatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: 2 });
const usdFormatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2 });

function fmt(n) { return currencyFormatter.format(n); }

function generarFolio() {
  return 'COT-' + String(Math.floor(Math.random() * 100000)).padStart(5, '0');
}

function fechaFormateada(f) {
  if (!f) return '';
  try {
    const d = new Date(f.replace(' ', 'T'));
    return d.toLocaleString('es-MX');
  } catch (e) { return f; }
}

function esHoy(f) {
  if (!f) return false;
  return f.startsWith(new Date().toISOString().slice(0, 10));
}

function updateClock() {
  document.getElementById('clock').textContent = new Date().toLocaleTimeString('es-MX');
}

async function obtenerTipoCambioYahoo() {
  try {
    const res = await fetch('api_dolar.php');
    const data = await res.json();
    if (data.success) {
      const tcCompra = parseFloat(data.precio);
      verificarAlertas(tcCompra);
      const tcVenta = tcCompra + 0.13;

      if (editandoTipo !== 'compra') {
        document.getElementById('c-tc').value = (tcCompra - 0.15).toFixed(2);
      }
      if (editandoTipo !== 'venta') {
        document.getElementById('v-tc').value = (tcVenta - 0.15).toFixed(2);
      }

      document.getElementById('rate-compra-stat').textContent = '$' + tcCompra.toFixed(2);
      document.getElementById('rate-venta-stat').textContent = '$' + tcVenta.toFixed(2);
      document.getElementById('live-rate').textContent = '$' + tcCompra.toFixed(2) + ' MXN';

      calcCompra(); calcVenta();
      return { compra: tcCompra, venta: tcVenta };
    }
  } catch (e) { console.error('Error API', e); }
  return null;
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

async function guardar(tipo) {
  const pfx = tipo === 'compra' ? 'c' : 'v';
  const usd = parseFloat(document.getElementById(pfx + '-usd').value) || 0;
  const tc = parseFloat(document.getElementById(pfx + '-tc').value) || 0;
  const comPct = parseFloat(document.getElementById(pfx + '-com').value) || 0;

  if (!usd || !tc) { showToast('Ingresa cantidad y tipo de cambio'); return; }

  const conv = usd * tc;
  const comVal = conv * (comPct / 100);
  const comision_monto = tipo === 'compra' ? -comVal : comVal;
  const total = conv + comision_monto;
  const folio = generarFolio();

  const datos = {
    id: editandoId && editandoTipo === tipo ? editandoId : null,
    folio: folio,
    tipo: tipo,
    cliente_nombre: document.getElementById(pfx + '-nombre').value.trim(),
    cliente_correo: document.getElementById(pfx + '-correo').value.trim(),
    usd: usd,
    tc: tc,
    comision_pct: comPct,
    comision_monto: comision_monto,
    total: total
  };

  try {
    const res = await fetch('api_historial.php?action=guardar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(datos)
    });
    const result = await res.json();
    if (result.success) {
      showToast(editandoId ? folio + ' actualizada' : folio + ' guardada');
      cancelarEdicion();
      await cargarHistorial();
      generarPDF(datos, 'previsualizar');
    } else {
      showToast('Error: ' + (result.error || 'Desconocido'));
    }
  } catch (e) { showToast('Error de conexi\u00f3n'); }
}

async function eliminar(id) {
  if (!confirm('Eliminar esta cotizaci\u00f3n?')) return;
  try {
    const res = await fetch('api_historial.php?action=eliminar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: id })
    });
    if ((await res.json()).success) {
      showToast('Cotizaci\u00f3n eliminada');
      cargarHistorial();
    }
  } catch (e) { showToast('Error al eliminar'); }
}

async function cargarHistorial() {
  try {
    const res = await fetch('api_historial.php?action=listar');
    historial = await res.json();
    renderHist();
    updateStats();
  } catch (e) { showToast('Error al cargar historial'); }
}

function editarCotizacion(id) {
  const entry = historial.find(e => parseInt(e.id) === id);
  if (!entry) return;
  const tipo = entry.tipo;
  const pfx = tipo === 'compra' ? 'c' : 'v';
  document.getElementById(pfx + '-usd').value = parseFloat(entry.usd).toFixed(2);
  document.getElementById(pfx + '-tc').value = parseFloat(entry.tc).toFixed(2);
  document.getElementById(pfx + '-com').value = parseFloat(entry.comision_pct).toFixed(1);
  document.getElementById(pfx + '-com-slider').value = Math.min(10, parseFloat(entry.comision_pct));
  document.getElementById(pfx + '-com-disp').textContent = parseFloat(entry.comision_pct).toFixed(1) + '%';
  document.getElementById(pfx + '-nombre').value = entry.cliente_nombre || '';
  document.getElementById(pfx + '-correo').value = entry.cliente_correo || '';
  editandoId = parseInt(entry.id);
  editandoTipo = tipo;
  document.getElementById('edit-badge-' + tipo).classList.add('show');
  document.getElementById('btn-' + tipo).innerHTML = '<i class="ti ti-refresh"></i> Actualizar';
  document.getElementById('cancel-' + tipo).classList.add('show');
  if (tipo === 'compra') calcCompra(); else calcVenta();
}

function cancelarEdicion(tipo) {
  const t = tipo || editandoTipo;
  if (!t) return;
  const pfx = t === 'compra' ? 'c' : 'v';
  document.getElementById(pfx + '-usd').value = '';
  document.getElementById(pfx + '-com').value = '0';
  document.getElementById(pfx + '-com-slider').value = '0';
  document.getElementById(pfx + '-com-disp').textContent = '0.0%';
  document.getElementById(pfx + '-nombre').value = '';
  document.getElementById(pfx + '-correo').value = '';
  document.getElementById('edit-badge-' + t).classList.remove('show');
  document.getElementById('btn-' + t).innerHTML = '<i class="ti ti-device-floppy"></i> Guardar y Ver';
  document.getElementById('cancel-' + t).classList.remove('show');
  editandoId = null;
  editandoTipo = null;
  if (t === 'compra') calcCompra(); else calcVenta();
}

function generarPDF(datos, accion) {
  const tipo = datos.tipo;
  document.getElementById('pdf-titulo-tipo').textContent = tipo === 'compra' ? 'COTIZACI\u00d3N DE COMPRA DE DIVISAS' : 'COTIZACI\u00d3N DE VENTA DE DIVISAS';
  document.getElementById('pdf-folio').textContent = datos.folio;
  document.getElementById('pdf-fecha').textContent = new Date().toLocaleString('es-MX');
  document.getElementById('pdf-cliente').textContent = datos.cliente_nombre || '---';
  document.getElementById('pdf-correo').textContent = datos.cliente_correo || '---';
  document.getElementById('pdf-usd').textContent = usdFormatter.format(datos.usd);
  document.getElementById('pdf-tc').textContent = currencyFormatter.format(datos.tc) + ' MXN';
  document.getElementById('pdf-conversion').textContent = currencyFormatter.format(datos.usd * datos.tc);
  document.getElementById('pdf-pct-txt').textContent = datos.comision_pct;
  document.getElementById('pdf-comision').textContent = currencyFormatter.format(Math.abs(datos.comision_monto));
  document.getElementById('pdf-total').textContent = currencyFormatter.format(datos.total);
  const opciones = { margin: 0, filename: datos.folio + '_' + tipo + '.pdf', image: { type: 'jpeg', quality: 1.0 }, html2canvas: { scale: 4, letterRendering: true, useCORS: true }, jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' } };
  const elemento = document.getElementById('plantilla-pdf');
  if (accion === 'descargar') { html2pdf().set(opciones).from(elemento).save(); }
  else if (accion === 'previsualizar') { html2pdf().set(opciones).from(elemento).outputPdf('bloburl').then(function(pdfUrl) { document.getElementById('preview-iframe').src = pdfUrl; document.getElementById('modal-preview').classList.add('show'); }); }
  else if (accion === 'enviar') {
    showToast('Generando PDF para env\u00edo...');
    html2pdf().set(opciones).from(elemento).outputPdf('datauristring').then(function(dataUrl) {
      showToast('Enviando correo...');
      fetch('api_correo.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ correo: datos.cliente_correo, nombre: datos.cliente_nombre, folio: datos.folio, pdfBase64: dataUrl })
      }).then(function(r) { return r.json(); }).then(function(res) {
        if (res.success) { showToast('Correo enviado con \u00e9xito a ' + datos.cliente_correo); }
        else { showToast('Error: ' + (res.error || 'Desconocido')); }
      }).catch(function() { showToast('Error de conexi\u00f3n al enviar correo'); });
    });
  }
}

function abrirVistaPrevia(id) {
  const entry = historial.find(e => parseInt(e.id) === id);
  if (!entry) return;
  generarPDF({ ...entry, fecha: entry.fecha_hora }, 'previsualizar');
}

function reimprimir(id) {
  const entry = historial.find(e => parseInt(e.id) === id);
  if (!entry) return;
  generarPDF({ ...entry, fecha: entry.fecha_hora }, 'descargar');
}

function enviarCotizacion(id) {
  const entry = historial.find(e => parseInt(e.id) === id);
  if (!entry) return;
  if (!entry.cliente_correo) { showToast('El registro no tiene correo electr\u00f3nico'); return; }
  generarPDF({ ...entry, fecha: entry.fecha_hora }, 'enviar');
}

function cerrarVistaPrevia() {
  document.getElementById('modal-preview').classList.remove('show');
  document.getElementById('preview-iframe').src = '';
}

function updateStats() {
  const hoy = new Date().toISOString().slice(0, 10);
  const opsHoy = historial.filter(e => e.fecha_hora && e.fecha_hora.startsWith(hoy));
  document.getElementById('ops-hoy').textContent = opsHoy.length;
  const vol = opsHoy.reduce((a, e) => a + parseFloat(e.total), 0);
  document.getElementById('vol-total').textContent = fmt(vol);
}

function setFilter(f, btn) {
  filtro = f;
  document.querySelectorAll('#tab-cotizador .filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderHist();
}

function renderHist() {
  const q = document.getElementById('buscar').value.toLowerCase();
  const list = document.getElementById('hist-list');
  const items = historial.filter(e => {
    const matchFiltro = filtro === 'todos' || e.tipo === filtro;
    const matchQ = !q || e.folio.toLowerCase().includes(q) || (e.fecha_hora || '').includes(q);
    return matchFiltro && matchQ;
  });
  if (!items.length) { list.innerHTML = '<div class="empty"><i class="ti ti-inbox" style="font-size:28px;display:block;margin-bottom:8px"></i>Sin resultados</div>'; return; }
  list.innerHTML = items.map(e => `
    <div class="cot-card">
      <div class="cot-header" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'block':'none'">
        <div><div class="cot-id">${e.folio}</div><div class="cot-date">${fechaFormateada(e.fecha_hora)}</div></div>
        <span class="badge ${e.tipo}">${e.tipo.toUpperCase()}</span>
      </div>
      <div class="cot-body">
        <div class="cot-row"><span>D&oacute;lares (USD):</span><span>${usdFormatter.format(e.usd)}</span></div>
        <div class="cot-row"><span>Tipo de cambio:</span><span>$${parseFloat(e.tc).toFixed(2)}</span></div>
        <div class="cot-row"><span>Comisi&oacute;n aplicada:</span><span>${parseFloat(e.comision_pct).toFixed(2)}%</span></div>
        <div class="cot-total"><span>Total neto:</span><span>${fmt(e.total)}</span></div>
        <div class="cot-actions">
          <button class="icon-btn" title="Ver" onclick="abrirVistaPrevia(${e.id})"><i class="ti ti-eye"></i></button>
          <button class="icon-btn" title="Descargar" onclick="reimprimir(${e.id})"><i class="ti ti-download"></i></button>
          <button class="icon-btn" title="Editar" onclick="editarCotizacion(${e.id})"><i class="ti ti-edit"></i></button>
          ${e.cliente_correo ? '<button class="icon-btn" title="Enviar por correo" onclick="enviarCotizacion(' + e.id + ')"><i class="ti ti-send" style="color:#60a5fa"></i></button>' : ''}
          <button class="icon-btn red" title="Eliminar" onclick="eliminar(${e.id})"><i class="ti ti-trash"></i></button>
        </div>
      </div>
    </div>
  `).join('');
}

let toastTimer;
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}

// ========== DOLLAR CHART ==========

let dolarChart = null;
let chartRange = '1d';
let chartInterval = null;

function formatChartTime(timestamp, range) {
  const d = new Date(timestamp * 1000);
  if (range === '1d') return d.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
  if (range === '5d') return d.toLocaleString('es-MX', { weekday: 'short', hour: '2-digit', minute: '2-digit' });
  return d.toLocaleString('es-MX', { day: 'numeric', month: 'short' });
}

async function cargarChart(range, btn) {
  if (btn) {
    document.querySelectorAll('.chart-section .filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }
  chartRange = range;
  document.getElementById('chart-update-info').textContent = 'Cargando...';
  try {
    const res = await fetch('api_dolar_historial.php?range=' + range);
    const data = await res.json();
    if (!data.success || !data.points.length) {
      document.getElementById('chart-update-info').textContent = 'Sin datos disponibles';
      return;
    }
    const labels = data.points.map(p => formatChartTime(p.time, range));
    const values = data.points.map(p => p.close);
    const lastVal = values[values.length - 1];
    const firstVal = values[0];
    const diff = lastVal - firstVal;
    const pct = firstVal ? ((diff / firstVal) * 100) : 0;
    const lineColor = diff >= 0 ? '#5dcaa5' : '#f87171';

    document.getElementById('chart-update-info').textContent =
      'Último: $' + lastVal.toFixed(2) + ' | ' +
      (diff >= 0 ? '+' : '') + diff.toFixed(4) + ' (' +
      (pct >= 0 ? '+' : '') + pct.toFixed(2) + '%)' +
      ' | ' + data.points.length + ' puntos';

    if (!dolarChart) {
      const ctx = document.getElementById('chart-dolar').getContext('2d');
      dolarChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'USD/MXN',
            data: values,
            borderColor: lineColor,
            backgroundColor: function(context) {
              const chart = context.chart;
              const { ctx, chartArea } = chart;
              if (!chartArea) return 'transparent';
              const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
              gradient.addColorStop(0, lineColor + '40');
              gradient.addColorStop(1, lineColor + '00');
              return gradient;
            },
            borderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 6,
            tension: 0.15,
            fill: true,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#1a1d2e',
              titleColor: '#94a3b8',
              bodyColor: '#e2e8f0',
              borderColor: '#2d3148',
              borderWidth: 1,
              padding: 10,
              displayColors: false,
              callbacks: {
                title: function(items) { return items[0].label; },
                label: function(item) { return '$' + item.parsed.y.toFixed(4); }
              }
            }
          },
          scales: {
            x: {
              ticks: {
                color: '#475569',
                maxTicksLimit: 10,
                font: { size: 10 }
              },
              grid: { color: '#1e2235', display: true }
            },
            y: {
              ticks: {
                color: '#475569',
                font: { size: 10 },
                callback: function(val) { return '$' + val.toFixed(2); }
              },
              grid: { color: '#1e2235' }
            }
          },
          interaction: {
            intersect: false,
            mode: 'index'
          }
        }
      });
    } else {
      dolarChart.data.labels = labels;
      dolarChart.data.datasets[0].data = values;
      dolarChart.data.datasets[0].borderColor = lineColor;
      dolarChart.data.datasets[0].backgroundColor = function(context) {
        const chart = context.chart;
        const { ctx, chartArea } = chart;
        if (!chartArea) return 'transparent';
        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
        gradient.addColorStop(0, lineColor + '40');
        gradient.addColorStop(1, lineColor + '00');
        return gradient;
      };
      dolarChart.update('none');
    }
  } catch (e) {
    console.error('Chart error:', e);
    document.getElementById('chart-update-info').textContent = 'Error al cargar datos';
  }
}

// ========== ALERTAS ==========

function emitirSonidoAlerta() {
  if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();
  osc.type = 'sine';
  osc.frequency.value = 880;
  gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
  gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.6);
  osc.connect(gain);
  gain.connect(audioCtx.destination);
  osc.start();
  osc.stop(audioCtx.currentTime + 0.6);
}

function toggleAlertas() {
  const minInput = document.getElementById('alerta-min');
  const maxInput = document.getElementById('alerta-max');
  const btn = document.getElementById('btn-alertas');
  const status = document.getElementById('alerta-status');

  if (alertasActivas) { apagarAlertas(); return; }

  const min = parseFloat(minInput.value);
  const max = parseFloat(maxInput.value);
  if (isNaN(min) && isNaN(max)) {
    status.textContent = 'Configura al menos un l\u00edmite (m\u00edn o m\u00e1x)';
    return;
  }

  if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
    Notification.requestPermission();
  }

  if (!('Notification' in window) || Notification.permission === 'denied') {
    status.textContent = 'Notificaciones bloqueadas en el navegador';
    return;
  }

  if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();

  ultimoPrecio = null;
  alertasActivas = true;
  btn.textContent = 'Monitoreando...';
  btn.classList.add('active');
  status.textContent = 'Alertas activas \u2014 monitoreando subidas y bajadas';
}

function apagarAlertas(mensajeToast) {
  alertasActivas = false;
  const btn = document.getElementById('btn-alertas');
  const status = document.getElementById('alerta-status');
  btn.textContent = 'Activar Monitoreo';
  btn.classList.remove('active');
  status.textContent = mensajeToast || 'Monitoreo desactivado';
}

function mostrarAlertaVisual(tipo, mensaje, precioActual, cambio) {
  const el = document.getElementById('alerta-visual');
  const icon = document.getElementById('alerta-icon');
  const msg = document.getElementById('alerta-msg');
  const change = document.getElementById('alerta-change');

  el.className = 'alerta-visual show ' + tipo;
  icon.textContent = tipo === 'up' ? '\u2191' : '\u2193';
  msg.textContent = mensaje;
  change.textContent = '$' + precioActual.toFixed(2) + ' (' + (cambio >= 0 ? '+' : '') + '$' + cambio.toFixed(2) + ')';

  if (el._hideTimer) clearTimeout(el._hideTimer);
  el._hideTimer = setTimeout(function() { el.classList.remove('show'); }, 5000);
}

function verificarAlertas(precioActual) {
  if (!alertasActivas) return;

  const min = parseFloat(document.getElementById('alerta-min').value);
  const max = parseFloat(document.getElementById('alerta-max').value);

  if (ultimoPrecio !== null) {
    const cambio = precioActual - ultimoPrecio;
    if (Math.abs(cambio) >= 0.10) {
      const tipo = cambio > 0 ? 'up' : 'down';
      const mensaje = tipo === 'up'
        ? 'USD/MXN SUBI\u00d3  \u2191'
        : 'USD/MXN BAJ\u00d3  \u2193';

      mostrarAlertaVisual(tipo, mensaje, precioActual, cambio);
      emitirSonidoAlerta();

      if ('Notification' in window && Notification.permission === 'granted') {
        new Notification('Alerta de Precio', {
          body: mensaje + '  $' + ultimoPrecio.toFixed(2) + ' \u2192 $' + precioActual.toFixed(2)
        });
      }
    }
  }
  ultimoPrecio = precioActual;

  if (!isNaN(min) && precioActual <= min) {
    mostrarAlertaVisual('down', 'USD/MXN BAJ\u00d3  \u2193', precioActual, precioActual - min);
    emitirSonidoAlerta();
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification('Alerta de Precio', { body: 'Precio cay\u00f3 al m\u00ednimo: $' + precioActual.toFixed(2) });
    }
    apagarAlertas('M\u00ednimo alcanzado');
    return;
  }

  if (!isNaN(max) && precioActual >= max) {
    mostrarAlertaVisual('up', 'USD/MXN SUBI\u00d3  \u2191', precioActual, precioActual - max);
    emitirSonidoAlerta();
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification('Alerta de Precio', { body: 'Precio subi\u00f3 al m\u00e1ximo: $' + precioActual.toFixed(2) });
    }
    apagarAlertas('M\u00e1ximo alcanzado');
    return;
  }
}

// ========== INIT ==========

setInterval(updateClock, 1000);
updateClock();

window.addEventListener('DOMContentLoaded', () => {
  calcCompra();
  calcVenta();
  cargarHistorial();
  obtenerTipoCambioYahoo();
  setInterval(obtenerTipoCambioYahoo, 15000);
  cargarChart('1d');
  chartInterval = setInterval(() => cargarChart(chartRange), 60000);
});
</script>

<div id="alerta-visual" class="alerta-visual" onclick="this.classList.remove('show')">
  <span class="alerta-icon" id="alerta-icon"></span>
  <span id="alerta-msg"></span>
  <span class="alerta-change" id="alerta-change"></span>
  <span class="alerta-close" onclick="event.stopPropagation();this.parentElement.classList.remove('show')">&times;</span>
</div>

</body>
</html>
