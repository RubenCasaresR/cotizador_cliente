<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dólar en Tiempo Real</title>
    <style>
        body { background: #121212; color: white; font-family: sans-serif; text-align: center; padding-top: 50px; }
        .ticker { font-family: 'Courier New', monospace; font-size: 3.5rem; color: #2ecc71; margin: 10px 0; }
        .timestamp { font-size: 1.5rem; color: #f1c40f; }
        .status { font-size: 0.8rem; color: #7f8c8d; }
    </style>
</head>
<body>

    <div>
        <h1>USD / MXN - Fluctuación</h1>
        <div id="precio" class="ticker">$0.0000</div>
        <div id="reloj" class="timestamp">00:00:00</div>
        <p id="mensaje" class="status">Sincronizando con el servidor...</p>
    </div>

    <script>
        // 1. RELOJ EN TIEMPO REAL (Segundo a segundo)
        function iniciarReloj() {
            setInterval(() => {
                const ahora = new Date();
                const tiempo = ahora.toLocaleTimeString();
                document.getElementById('reloj').innerText = tiempo;
            }, 1000);
        }

        // 2. ACTUALIZACIÓN DEL DÓLAR (Cada 20 segundos para no saturar la API)
        function actualizarDolar() {
            fetch('prueba_api.php')
                .then(response => response.json())
                .then(data => {
                    if(data.precio && data.precio !== "Error") {
                        document.getElementById('precio').innerText = '$' + data.precio;
                        document.getElementById('mensaje').innerText = "Última actualización de precio: " + data.hora;
                    } else {
                        document.getElementById('mensaje').innerText = "Esperando turno de la API...";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('mensaje').innerText = "Error de conexión.";
                });
        }

        // Iniciar procesos
        iniciarReloj();
        actualizarDolar(); 
        
        // Ejecutar cada 20 segundos (3 veces por minuto, seguro para tu API Key)
        setInterval(actualizarDolar, 20000); 
    </script>
</body>
</html>