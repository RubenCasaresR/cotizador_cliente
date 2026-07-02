<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cotizador de Dólares</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

    <style>
        /* Ocultar el selector de "registros por página" para ahorrar espacio en el panel lateral */
        .dataTable-dropdown { display: none; }
        /* Estilizar la barra de búsqueda */
        .dataTable-search { width: 100%; float: none !important; margin-bottom: 10px; }
        .dataTable-input { 
            width: 100% !important; 
            border-radius: 0.5rem; 
            border: 1px solid #d1d5db; 
            font-size: 0.75rem; 
            padding: 0.5rem 0.75rem; 
            outline: none;
        }
        .dataTable-input:focus { border-color: #374151; box-shadow: 0 0 0 2px rgba(55, 65, 81, 0.2); }
        /* Estilizar la paginación y el texto de información */
        .dataTable-bottom { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            gap: 10px; 
            padding: 15px 10px !important; 
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }
        .dataTable-info { margin: 0; font-size: 0.7rem; color: #6b7280; font-weight: 600;}
        .dataTable-pagination { margin: 0; }
        .dataTable-pagination a { color: #4b5563; border-radius: 0.25rem; padding: 4px 10px; font-size: 0.75rem; font-weight: bold;}
        .dataTable-pagination .active a, .dataTable-pagination .active a:hover { background-color: #1f2937; color: white; }
        .dataTable-container { border-bottom: none !important; }
    </style>
</head>
<body class="bg-gray-100 h-screen overflow-hidden flex flex-col font-sans relative">

    <header class="bg-gray-900 text-white py-3 px-6 shadow-md flex justify-between items-center shrink-0 z-10">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h1 id="dashboard_titulo" class="text-xl font-bold tracking-wider">DASHBOARD DIVISAS</h1>
            <div class="flex items-center gap-1 ml-4 bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
                <button id="btn-mode-usa" onclick="setModo('usa')" class="px-3 py-1 text-xs font-bold bg-green-600 text-white transition">USA</button>
                <button id="btn-mode-china" onclick="setModo('china')" class="px-3 py-1 text-xs font-bold text-gray-400 hover:text-white transition">CHINA</button>
            </div>
        </div>
        
        <div class="flex items-center gap-6">
            <div class="text-sm font-mono text-gray-300 font-bold tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span id="reloj_vivo">00:00:00</span>
            </div>

            <div id="api_status" class="text-xs font-semibold px-4 py-1.5 rounded-full bg-gray-800 text-gray-400 border border-gray-700 shadow-inner flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-gray-500 animate-pulse" id="api_dot"></span>
                <span id="api_text">Conectando...</span>
            </div>
        </div>
    </header>

    <div class="flex-1 flex overflow-hidden p-4 gap-4">

        <div class="w-[65%] flex gap-4 overflow-y-auto pr-1">
            
            <div class="w-1/2 bg-white rounded-xl shadow border border-gray-200 flex flex-col h-fit relative">
                <div id="badge_compra" class="hidden absolute -top-3 -right-3 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow z-10">Editando</div>
                <div class="bg-green-700 text-white p-3 rounded-t-xl">
                    <h2 class="text-lg font-bold text-center tracking-wide">COMPRA DLLS</h2>
                </div>
                <div class="p-5 space-y-3 flex-grow">
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">CANTIDAD EN USD</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">$</span><input type="text" inputmode="numeric" id="c_usd" class="w-full pl-8 pr-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-green-500 outline-none transition" value=""></div></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">TIPO DE CAMBIO</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">$</span><input type="text" inputmode="numeric" id="c_tc" class="w-full pl-8 pr-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-green-500 outline-none transition"></div></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">COMISIÓN (%)</label><div class="relative"><input type="number" id="c_comision_pct" class="w-full pl-3 pr-8 py-1.5 bg-gray-100 border rounded cursor-not-allowed" value="1.25" readonly><span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 font-bold">%</span></div></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">NOMBRE DEL CLIENTE</label><input type="text" id="c_nombre" class="w-full px-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-green-500 outline-none transition" placeholder="Nombre completo"></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">CORREO ELECTRÓNICO</label><input type="email" id="c_correo" class="w-full px-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-green-500 outline-none transition" placeholder="cliente@ejemplo.com"></div>
                    <hr class="my-3 border-gray-200">
                    <div class="flex justify-between items-center text-sm text-gray-600"><span class="font-semibold">Conversión (<span id="c_moneda_label">MXN</span>)</span><span id="c_conversion" class="font-mono">$0.00</span></div>
                    <div class="flex justify-between items-center text-sm text-red-600"><span class="font-semibold">Comisión (Resta)</span><span id="c_comision_monto" class="font-mono">-$0.00</span></div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100 mt-2"><span class="text-sm font-bold text-gray-700">TOTAL NETO</span><span id="c_total" class="text-xl font-mono font-bold text-green-700">$0.00</span></div>
                </div>
                <div class="p-3 bg-gray-50 border-t border-gray-200 rounded-b-xl flex gap-2">
                    <button id="btn_compra" onclick="generarPDF('compra')" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded shadow-sm transition flex justify-center items-center gap-2 text-sm">Guardar y Ver</button>
                    <button id="btn_cancelar_compra" onclick="cancelarEdicion('compra')" class="hidden bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-3 rounded shadow-sm transition text-sm">X</button>
                </div>
            </div>

            <div class="w-1/2 bg-white rounded-xl shadow border border-gray-200 flex flex-col h-fit relative">
                <div id="badge_venta" class="hidden absolute -top-3 -right-3 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow z-10">Editando</div>
                <div class="bg-blue-800 text-white p-3 rounded-t-xl">
                    <h2 class="text-lg font-bold text-center tracking-wide">VENTA DLLS</h2>
                </div>
                <div class="p-5 space-y-3 flex-grow">
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">CANTIDAD EN USD</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">$</span><input type="text" inputmode="numeric" id="v_usd" class="w-full pl-8 pr-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-blue-500 outline-none transition" value=""></div></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">TIPO DE CAMBIO</label><div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">$</span><input type="text" inputmode="numeric" id="v_tc" class="w-full pl-8 pr-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-blue-500 outline-none transition"></div></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">COMISIÓN (%)</label><div class="relative"><input type="number" id="v_comision_pct" class="w-full pl-3 pr-8 py-1.5 bg-gray-100 border rounded cursor-not-allowed" value="1.25" readonly><span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 font-bold">%</span></div></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">NOMBRE DEL CLIENTE</label><input type="text" id="v_nombre" class="w-full px-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Nombre completo"></div>
                    <div><label class="block text-xs font-bold text-gray-600 mb-1">CORREO ELECTRÓNICO</label><input type="email" id="v_correo" class="w-full px-3 py-1.5 bg-gray-50 border rounded focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="cliente@ejemplo.com"></div>
                    <hr class="my-3 border-gray-200">
                    <div class="flex justify-between items-center text-sm text-gray-600"><span class="font-semibold">Conversión (<span id="v_moneda_label">MXN</span>)</span><span id="v_conversion" class="font-mono">$0.00</span></div>
                    <div class="flex justify-between items-center text-sm text-blue-600"><span class="font-semibold">Comisión (Suma)</span><span id="v_comision_monto" class="font-mono">+$0.00</span></div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100 mt-2"><span class="text-sm font-bold text-gray-700">TOTAL NETO</span><span id="v_total" class="text-xl font-mono font-bold text-blue-800">$0.00</span></div>
                </div>
                <div class="p-3 bg-gray-50 border-t border-gray-200 rounded-b-xl flex gap-2">
                    <button id="btn_venta" onclick="generarPDF('venta')" class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 rounded shadow-sm transition flex justify-center items-center gap-2 text-sm">Guardar y Ver</button>
                    <button id="btn_cancelar_venta" onclick="cancelarEdicion('venta')" class="hidden bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-3 rounded shadow-sm transition text-sm">X</button>
                </div>
            </div>
        </div>

        <div class="w-[35%] bg-white rounded-xl shadow border border-gray-200 flex flex-col overflow-hidden">
            <div class="bg-gray-800 text-white p-3 flex justify-between items-center shrink-0">
                <h2 class="text-sm font-bold tracking-wide">HISTORIAL</h2>
                <button onclick="cargarHistorial()" class="text-xs bg-gray-700 hover:bg-gray-600 px-2 py-1 rounded transition">Actualizar</button>
            </div>
            <div class="flex-1 overflow-y-auto p-3">
                <table id="tabla-historial" class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 border-b border-gray-200 shadow-sm z-10">
                        <tr class="text-gray-600 uppercase text-[10px] tracking-wider">
                            <th class="p-2 font-bold">Detalles</th>
                            <th class="p-2 font-bold text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-historial-body" class="divide-y divide-gray-100">
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-preview" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex justify-center items-center p-6 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl h-full max-h-[90vh] flex flex-col overflow-hidden">
            <div class="bg-gray-100 p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-lg">Vista Previa del Documento</h3>
                <button onclick="cerrarVistaPrevia()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded shadow">Cerrar</button>
            </div>
            <div class="flex-grow p-0 w-full h-full">
                <iframe id="preview-iframe" class="w-full h-full border-none" src=""></iframe>
            </div>
        </div>
    </div>

    <div class="absolute left-[-9999px] top-[-9999px]">
        <div id="plantilla-pdf" class="w-[800px] p-12 bg-white text-black font-sans">
            
            <h1 class="text-3xl font-extrabold text-center text-black uppercase tracking-wide mb-10" id="pdf-titulo-tipo">COTIZACIÓN</h1>

            <table class="w-full text-sm text-left border-collapse mb-8">
                <tbody class="border-2 border-gray-400">
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-3 w-1/3 bg-gray-100 font-bold text-black">Folio:</td>
                        <td class="py-2.5 px-3 text-black font-semibold" id="pdf-folio"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-3 w-1/3 bg-gray-100 font-bold text-black">Fecha y hora de emisión:</td>
                        <td class="py-2.5 px-3 text-black font-semibold" id="pdf-fecha"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-3 w-1/3 bg-gray-100 font-bold text-black">Cliente:</td>
                        <td class="py-2.5 px-3 text-black font-semibold" id="pdf-cliente"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-3 w-1/3 bg-gray-100 font-bold text-black">Correo:</td>
                        <td class="py-2.5 px-3 text-black font-semibold" id="pdf-correo"></td>
                    </tr>
                </tbody>
            </table>

            <table class="w-full text-sm text-left border-collapse mb-12 shadow-sm rounded-md overflow-hidden border-2 border-gray-400">
                <thead>
                    <tr class="bg-gray-200 text-black">
                        <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-[12px] border-b-2 border-gray-400 w-1/2">Concepto</th>
                        <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-[12px] border-b-2 border-gray-400">Detalle</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-4 text-black font-semibold">Monto en dólares (USD)</td>
                        <td class="py-2.5 px-4 font-mono font-bold text-black" id="pdf-usd"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-4 text-black font-semibold">Tipo de cambio</td>
                        <td class="py-2.5 px-4 font-mono font-bold text-black" id="pdf-tc"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-4 text-black font-semibold">Conversión base <span id="pdf-conversion-label">a pesos</span></td>
                        <td class="py-2.5 px-4 font-mono font-bold text-black" id="pdf-conversion"></td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="py-2.5 px-4 text-black font-semibold">Comisión aplicada (<span id="pdf-pct-txt"></span>%)</td>
                        <td class="py-2.5 px-4 font-mono font-bold text-black" id="pdf-comision"></td>
                    </tr>
                    <tr class="border-b border-gray-300 bg-gray-50">
                        <td class="py-3 px-4 text-black font-extrabold text-base">Total Neto</td>
                        <td class="py-3 px-4 font-mono font-extrabold text-black text-base" id="pdf-total"></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-[12px] text-black space-y-3 mt-16 text-center border-t-2 border-gray-400 pt-6">
                <p class="font-semibold">Nota: Esta cotización es de carácter informativo y está sujeta a la volatilidad del mercado cambiario en tiempo real.</p>
                <p class="font-extrabold text-black">Vigencia: Esta cotización tiene una vigencia de 30 minutos a partir de su hora de emisión.</p>
            </div>
            
        </div>
    </div>

    <script>
        let currencyFormatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: 2 });
        const usdFormatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2 });

        let paisActual = 'usa';
        let editando = { compra: null, venta: null };
        let dataTableInstancia = null; 
        let ultimoFolioGenerado = null; // Variable para identificar la nueva cotización

        function aplicarMascaraMoneda(input) {
            let numeros = input.value.replace(/\D/g, '');
            if (numeros === '') { input.value = ''; return; }
            numeros = numeros.padStart(3, '0');
            let parteEntera = numeros.slice(0, -2);
            let parteDecimal = numeros.slice(-2);
            parteEntera = parseInt(parteEntera, 10).toString();
            parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            input.value = parteEntera + '.' + parteDecimal;
        }

        function obtenerValorLimpio(id) {
            let valor = document.getElementById(id).value;
            return parseFloat(valor.replace(/,/g, '')) || 0;
        }

        function calcularCompra() {
            const usd = obtenerValorLimpio('c_usd');
            const tc = obtenerValorLimpio('c_tc');
            const comisionPct = parseFloat(document.getElementById('c_comision_pct').value) || 0;
            const conversion = usd * tc;
            const comisionMonto = conversion * (comisionPct / 100);
            const total = conversion - comisionMonto;

            document.getElementById('c_conversion').innerText = currencyFormatter.format(conversion);
            document.getElementById('c_comision_monto').innerText = "-" + currencyFormatter.format(comisionMonto);
            document.getElementById('c_total').innerText = currencyFormatter.format(total);
        }

        function calcularVenta() {
            const usd = obtenerValorLimpio('v_usd');
            const tc = obtenerValorLimpio('v_tc');
            const comisionPct = parseFloat(document.getElementById('v_comision_pct').value) || 0;
            const conversion = usd * tc;
            let total = 0; if (comisionPct < 100) total = conversion / (1 - (comisionPct / 100));
            const comisionMonto = total - conversion;

            document.getElementById('v_conversion').innerText = currencyFormatter.format(conversion);
            document.getElementById('v_comision_monto').innerText = "+" + currencyFormatter.format(comisionMonto);
            document.getElementById('v_total').innerText = currencyFormatter.format(total);
        }

        function setModo(pais) {
            paisActual = pais;

            document.getElementById('btn-mode-usa').className = pais === 'usa'
                ? 'px-3 py-1 text-xs font-bold bg-green-600 text-white transition'
                : 'px-3 py-1 text-xs font-bold text-gray-400 hover:text-white transition';
            document.getElementById('btn-mode-china').className = pais === 'china'
                ? 'px-3 py-1 text-xs font-bold bg-green-600 text-white transition'
                : 'px-3 py-1 text-xs font-bold text-gray-400 hover:text-white transition';

            if (pais === 'china') {
                currencyFormatter = new Intl.NumberFormat('zh-CN', { style: 'currency', currency: 'CNY', minimumFractionDigits: 2 });
            } else {
                currencyFormatter = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: 2 });
            }

            document.getElementById('c_moneda_label').innerText = pais === 'china' ? 'CNY' : 'MXN';
            document.getElementById('v_moneda_label').innerText = pais === 'china' ? 'CNY' : 'MXN';
            document.getElementById('dashboard_titulo').innerText = pais === 'china' ? 'DASHBOARD DIVISAS \u2014 CHINA' : 'DASHBOARD DIVISAS';

            obtenerTipoCambioYahoo();
            cargarHistorial();
            calcularCompra();
            calcularVenta();
        }

        async function obtenerTipoCambioYahoo() {
            try {
                const moneda = paisActual === 'china' ? 'CNY' : 'MXN';
                const res = await fetch('api_dolar.php?moneda=' + moneda);
                const data = await res.json();
                if (data.success) {
                    const tcCompra = parseFloat(data.precio);
                    const recargo = paisActual === 'china' ? 0.18 : 0.13;
                    const tcVenta = tcCompra + recargo;
                    const simbolo = paisActual === 'china' ? '\u00a5' : '$';
                    const codigo = paisActual === 'china' ? 'CNY' : 'MXN';
                    
                    if(!editando.compra) { 
                        document.getElementById('c_tc').value = tcCompra.toFixed(2); 
                        aplicarMascaraMoneda(document.getElementById('c_tc')); 
                    }
                    if(!editando.venta) { 
                        document.getElementById('v_tc').value = tcVenta.toFixed(2); 
                        aplicarMascaraMoneda(document.getElementById('v_tc')); 
                    }
                    
                    const ahora = new Date();
                    const horaStr = ahora.toLocaleTimeString('es-MX', { hour12: false });
                    
                    document.getElementById('api_text').innerText = "En vivo: " + simbolo + tcCompra.toFixed(2) + " " + codigo + " (Actualizado " + horaStr + ")";
                    document.getElementById('api_status').classList.replace('bg-gray-800', 'bg-green-900');
                    document.getElementById('api_status').classList.replace('text-gray-400', 'text-green-100');
                    document.getElementById('api_dot').classList.replace('bg-gray-500', 'bg-green-400');
                    
                    calcularCompra(); calcularVenta();
                }
            } catch (error) { 
                console.error("Error API"); 
            }
        }

        // --- ARREGLO DE FECHAS: Función auxiliar para formatear la fecha correctamente ---
        function obtenerFechaFormateada(fechaTextoBaseDatos = null) {
            let fechaObj;
            if (fechaTextoBaseDatos) {
                // Reemplaza espacio por 'T' para evitar errores de Invalid Date en navegadores iOS/Safari
                const fechaLimpia = fechaTextoBaseDatos.replace(' ', 'T'); 
                fechaObj = new Date(fechaLimpia);
            } else {
                fechaObj = new Date(); // Si no hay fecha, usa la del momento exacto (nueva cotización)
            }
            
            const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit', hour12: true };
            return fechaObj.toLocaleDateString('es-MX', opciones);
        }

        async function generarPDF(tipo) {
            let prefijo = tipo === 'compra' ? 'c_' : 'v_';
            
            // --- VALIDACIÓN DE CAMPOS ---
            const inputUsdTxt = document.getElementById(prefijo + 'usd').value.trim();
            const inputComisionTxt = document.getElementById(prefijo + 'comision_pct').value.trim();
            const usdLimpio = obtenerValorLimpio(prefijo + 'usd');

            if (inputUsdTxt === '' || usdLimpio <= 0) {
                alert("⚠️ Error: Por favor ingresa una cantidad de Dólares mayor a cero.");
                document.getElementById(prefijo + 'usd').focus();
                return; // Detiene el proceso
            }

            if (inputComisionTxt === '') {
                alert("⚠️ Error: Por favor ingresa el porcentaje de comisión.");
                document.getElementById(prefijo + 'comision_pct').focus();
                return; // Detiene el proceso
            }

            const folioActual = editando[tipo] ? editando[tipo].folio : "COT-" + Math.floor(Math.random() * 100000);
            
            // Registramos este folio como el último generado para ponerle la etiqueta
            ultimoFolioGenerado = folioActual;

            const datos = {
                id: editando[tipo] ? editando[tipo].id : null, 
                tipo: tipo,
                folio: folioActual,
                cliente_nombre: document.getElementById(prefijo + 'nombre').value.trim(),
                cliente_correo: document.getElementById(prefijo + 'correo').value.trim(),
                usd: usdLimpio,
                tc: obtenerValorLimpio(prefijo + 'tc'),
                comision_pct: parseFloat(inputComisionTxt) || 0,
                comision_monto: parseFloat(document.getElementById(prefijo + 'comision_monto').innerText.replace(/[^0-9.-]+/g,"")),
                total: parseFloat(document.getElementById(prefijo + 'total').innerText.replace(/[^0-9.-]+/g,"")),
                fecha: obtenerFechaFormateada()
            };

            try {
                await fetch('api_historial.php?action=guardar&pais=' + paisActual, {
                    method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos)
                });
                cancelarEdicion(tipo); 
                cargarHistorial(); 
            } catch (e) { console.error("Error BD", e); }

            // MODIFICACIÓN: Ya no descarga, solo abre la vista previa
            ejecutarAccionPDF(datos, 'previsualizar');
        }

        function activarEdicion(regString) {
            const reg = JSON.parse(regString.replace(/&quot;/g, '"'));
            const tipo = reg.tipo;
            const prefijo = tipo === 'compra' ? 'c_' : 'v_';
            
            document.getElementById(prefijo + 'usd').value = parseFloat(reg.usd).toFixed(2);
            document.getElementById(prefijo + 'tc').value = parseFloat(reg.tc).toFixed(2);
            document.getElementById(prefijo + 'comision_pct').value = reg.comision_pct;
            document.getElementById(prefijo + 'nombre').value = reg.cliente_nombre || '';
            document.getElementById(prefijo + 'correo').value = reg.cliente_correo || '';
            
            aplicarMascaraMoneda(document.getElementById(prefijo + 'usd'));
            aplicarMascaraMoneda(document.getElementById(prefijo + 'tc'));
            
            editando[tipo] = reg;
            document.getElementById('badge_' + tipo).classList.remove('hidden');
            document.getElementById('btn_' + tipo).innerText = "Actualizar Cotización";
            document.getElementById('btn_' + tipo).classList.replace('bg-' + (tipo==='compra'?'green':'blue') + '-600', 'bg-yellow-600');
            document.getElementById('btn_cancelar_' + tipo).classList.remove('hidden');
            
            if(tipo === 'compra') calcularCompra(); else calcularVenta();
        }

        function cancelarEdicion(tipo) {
            editando[tipo] = null;
            document.getElementById('badge_' + tipo).classList.add('hidden');
            const colorOriginal = tipo === 'compra' ? 'green' : 'blue';
            document.getElementById('btn_' + tipo).innerText = "Guardar y Ver"; // Actualizamos el texto
            document.getElementById('btn_' + tipo).className = `w-full bg-${colorOriginal}-600 hover:bg-${colorOriginal}-700 text-white font-bold py-2 rounded shadow-sm transition flex justify-center items-center gap-2 text-sm`;
            document.getElementById('btn_cancelar_' + tipo).classList.add('hidden');
            const prefijo = tipo === 'compra' ? 'c_' : 'v_';
            document.getElementById(prefijo + 'nombre').value = '';
            document.getElementById(prefijo + 'correo').value = '';
        }

        async function eliminarCotizacion(id) {
            if(confirm("¿Estás seguro de eliminar esta cotización del historial?")) {
                await fetch('api_historial.php?action=eliminar&pais=' + paisActual, {
                    method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({id: id})
                });
                cargarHistorial();
            }
        }

        function ejecutarAccionPDF(d, accion) {
            document.getElementById('pdf-titulo-tipo').innerText = d.tipo === 'compra' ? 'COTIZACIÓN DE COMPRA DE DIVISAS' : 'COTIZACIÓN DE VENTA DE DIVISAS';
            document.getElementById('pdf-folio').innerText = d.folio;
            
            // Simplemente imprimimos la fecha que ya viene lista
            document.getElementById('pdf-fecha').innerText = d.fecha;
            document.getElementById('pdf-cliente').innerText = d.cliente_nombre || '---';
            document.getElementById('pdf-correo').innerText = d.cliente_correo || '---';
            
            document.getElementById('pdf-usd').innerText = usdFormatter.format(d.usd);
            document.getElementById('pdf-tc').innerText = currencyFormatter.format(d.tc) + " " + (paisActual === 'china' ? 'CNY' : 'MXN');
            document.getElementById('pdf-conversion-label').innerText = paisActual === 'china' ? 'a Yuan (CNY)' : 'a pesos (MXN)';
            document.getElementById('pdf-conversion').innerText = currencyFormatter.format(d.usd * d.tc);
            document.getElementById('pdf-pct-txt').innerText = d.comision_pct;
            
            // Inyectamos la comisión y el total (sin intentar cambiarles el color a rojo/azul)
            document.getElementById('pdf-comision').innerText = currencyFormatter.format(d.comision_monto);
            document.getElementById('pdf-total').innerText = currencyFormatter.format(d.total);

            const elemento = document.getElementById('plantilla-pdf');
            
            // --- MAGIA DE NITIDEZ ---
            // Aumentamos scale a 4, mejoramos la calidad de imagen y activamos letterRendering
            const opciones = { 
                margin: 0, 
                filename: `${d.folio}_${d.tipo}.pdf`, 
                image: { type: 'jpeg', quality: 1.0 },
                html2canvas: { scale: 4, letterRendering: true, useCORS: true }, 
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' } 
            };

            if(accion === 'descargar') {
                html2pdf().set(opciones).from(elemento).save();
            } else if (accion === 'previsualizar') {
                html2pdf().set(opciones).from(elemento).outputPdf('bloburl').then(function(pdfUrl) {
                    document.getElementById('preview-iframe').src = pdfUrl;
                    document.getElementById('modal-preview').classList.remove('hidden');
                });
            } else if (accion === 'enviar') {
                document.getElementById('modal-preview').classList.add('hidden');
                html2pdf().set(opciones).from(elemento).outputPdf('datauristring').then(function(dataUrl) {
                    fetch('api_correo.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ correo: d.cliente_correo, nombre: d.cliente_nombre, folio: d.folio, pdfBase64: dataUrl })
                    }).then(function(r) { return r.json(); }).then(function(res) {
                        if (res.success) { alert('Correo enviado con éxito a ' + d.cliente_correo); }
                        else { alert('Error: ' + (res.error || 'Desconocido')); }
                    }).catch(function() { alert('Error de conexión al enviar correo'); });
                });
            }
        }

        function abrirVistaPrevia(regString) {
            const reg = JSON.parse(regString.replace(/&quot;/g, '"'));
            reg.fecha = obtenerFechaFormateada(reg.fecha_hora);
            ejecutarAccionPDF(reg, 'previsualizar');
        }

        function cerrarVistaPrevia() {
            document.getElementById('modal-preview').classList.add('hidden');
            document.getElementById('preview-iframe').src = ""; 
        }

        function reimprimir(regString) {
            const reg = JSON.parse(regString.replace(/&quot;/g, '"'));
            reg.fecha = obtenerFechaFormateada(reg.fecha_hora);
            ejecutarAccionPDF(reg, 'descargar');
        }

        function enviarCotizacion(regString) {
            const reg = JSON.parse(regString.replace(/&quot;/g, '"'));
            if (!reg.cliente_correo) { alert('El registro no tiene correo electrónico'); return; }
            reg.fecha = obtenerFechaFormateada(reg.fecha_hora);
            ejecutarAccionPDF(reg, 'enviar');
        }

        async function cargarHistorial() {
            try {
                const cliente = document.getElementById('c_nombre').value.trim() || document.getElementById('v_nombre').value.trim() || '';
                let url = 'api_historial.php?action=listar&pais=' + paisActual;
                if (cliente) url += '&cliente=' + encodeURIComponent(cliente);
                const res = await fetch(url);
                const data = await res.json();
                
                if (dataTableInstancia) { dataTableInstancia.destroy(); }

                const tbody = document.getElementById('tabla-historial-body');
                tbody.innerHTML = '';

                data.forEach(reg => {
                    const jsonReg = JSON.stringify(reg).replace(/"/g, '&quot;');
                    const colorTipo = reg.tipo === 'compra' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
                    
                    // --- CREACIÓN DEL BADGE ¡NUEVO! ---
                    let badgeReciente = '';
                    if (reg.folio === ultimoFolioGenerado) {
                        badgeReciente = `<span class="ml-2 px-1.5 py-0.5 bg-green-500 text-white text-[9px] font-bold uppercase rounded animate-pulse shadow">¡Nuevo!</span>`;
                    }

                    const tr = document.createElement('tr');
                    tr.className = "hover:bg-gray-50 transition border-b border-gray-100";
                    tr.innerHTML = `
                        <td class="p-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <div class="font-bold text-gray-800 text-xs flex items-center">${reg.folio} ${badgeReciente}</div>
                                    <div class="text-[10px] text-gray-500">${reg.fecha_hora}</div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase shadow-sm ${colorTipo}">${reg.tipo}</span>
                            </div>
                            
                            <div class="bg-gray-100 p-2.5 rounded-md border border-gray-200 text-[10px] space-y-1.5 shadow-inner">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 font-semibold uppercase">Dólares (USD):</span>
                                    <span class="font-mono font-bold text-gray-700">${usdFormatter.format(reg.usd)}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 font-semibold uppercase">Tipo de Cambio:</span>
                                    <span class="font-mono font-bold text-gray-700">${currencyFormatter.format(reg.tc)}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 font-semibold uppercase">Comisión Aplicada:</span>
                                    <span class="font-mono font-bold text-gray-700">${reg.comision_pct}%</span>
                                </div>
                                <div class="flex justify-between items-center border-t border-gray-300 pt-1.5 mt-1">
                                    <span class="text-gray-800 font-extrabold uppercase text-[11px]">Total Neto:</span>
                                    <span class="font-mono font-extrabold text-[12px] text-gray-900">${currencyFormatter.format(reg.total)}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 align-middle w-14">
                            <div class="flex flex-col gap-1.5 justify-center">
                                <button onclick="abrirVistaPrevia('${jsonReg}')" class="text-blue-600 hover:bg-blue-100 p-1.5 rounded-md border border-transparent hover:border-blue-200 transition bg-white shadow-sm" title="Ver PDF"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                <button onclick="reimprimir('${jsonReg}')" class="text-green-600 hover:bg-green-100 p-1.5 rounded-md border border-transparent hover:border-green-200 transition bg-white shadow-sm" title="Descargar PDF"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                <button onclick="activarEdicion('${jsonReg}')" class="text-yellow-600 hover:bg-yellow-100 p-1.5 rounded-md border border-transparent hover:border-yellow-200 transition bg-white shadow-sm" title="Editar"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                ${reg.cliente_correo ? '<button onclick="enviarCotizacion(\'' + jsonReg + '\')" class="text-blue-500 hover:bg-blue-100 p-1.5 rounded-md border border-transparent hover:border-blue-200 transition bg-white shadow-sm" title="Enviar por correo"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></button>' : ''}
                                <button onclick="eliminarCotizacion(${reg.id})" class="text-red-500 hover:bg-red-100 p-1.5 rounded-md border border-transparent hover:border-red-200 transition bg-white shadow-sm" title="Eliminar"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                dataTableInstancia = new simpleDatatables.DataTable("#tabla-historial", {
                    searchable: true,
                    perPage: 10,
                    labels: {
                        placeholder: "Buscar folio, fecha...",
                        noRows: "No hay cotizaciones guardadas",
                        info: "{start} a {end} de {rows}"
                    }
                });

            } catch (error) { console.error("Error", error); }
        }

        ['c_usd', 'c_tc'].forEach(id => { document.getElementById(id).addEventListener('input', function(e) { aplicarMascaraMoneda(e.target); calcularCompra(); }); });
        document.getElementById('c_comision_pct').addEventListener('input', calcularCompra);
        document.getElementById('c_nombre').addEventListener('input', cargarHistorial);

        ['v_usd', 'v_tc'].forEach(id => { document.getElementById(id).addEventListener('input', function(e) { aplicarMascaraMoneda(e.target); calcularVenta(); }); });
        document.getElementById('v_comision_pct').addEventListener('input', calcularVenta);
        document.getElementById('v_nombre').addEventListener('input', cargarHistorial);

        // --- NUEVA FUNCIÓN: Reloj que avanza segundo a segundo ---
        function iniciarRelojVivo() {
            setInterval(() => {
                const ahora = new Date();
                // Formato de 24 horas con segundos (Ej. 14:05:09)
                document.getElementById('reloj_vivo').innerText = ahora.toLocaleTimeString('es-MX', { hour12: false });
            }, 1000); // 1000 milisegundos = 1 segundo
        }

        // Inicialización principal
        window.addEventListener('DOMContentLoaded', () => {
            aplicarMascaraMoneda(document.getElementById('c_usd'));
            aplicarMascaraMoneda(document.getElementById('v_usd'));
            calcularCompra(); 
            calcularVenta();   
            obtenerTipoCambioYahoo(); 
            cargarHistorial();    

            // Encendemos el reloj visual de la barra superior (cada 1 segundo)
            iniciarRelojVivo();

            // Encendemos la actualización de Yahoo Finance (cada 15 segundos)
            setInterval(obtenerTipoCambioYahoo, 15000);
        });
    </script>
</body>
</html>