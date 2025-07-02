<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Boleto de Entrada</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f7f7f7;
        }
        .ticket {
            width: 600px;
            margin: 30px auto;
            background: #fff;
            border: 3px dashed #6b21a8;
            border-radius: 12px;
            padding: 20px;
            position: relative;
        }
        .ticket::before, .ticket::after {
            content: "";
            position: absolute;
            width: 40px;
            height: 40px;
            background: #f7f7f7;
            border-radius: 50%;
        }
        .ticket::before {
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
        }
        .ticket::after {
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 15px;
        }
        .ticket-header img {
            height: 60px;
            margin-bottom: 5px;
        }
        .ticket-header h2 {
            margin: 0;
            color: #6b21a8;
        }
        .ticket-content {
            margin-top: 15px;
            font-size: 16px;
        }
        .ticket-content p {
            margin: 4px 0;
        }
        .qr {
            text-align: center;
            margin-top: 15px;
        }
        .qr p {
            font-size: 12px;
            color: #666;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="ticket">
        <div class="ticket-header">
            
            <h2>Boleto de Entrada</h2>
        </div>
        <div class="ticket-content">
            <p><strong>🎬 Película:</strong> {{ $boleto->funcion->pelicula->titulo }}</p>
            <p><strong>📅 Fecha:</strong> {{ \Carbon\Carbon::parse($boleto->funcion->fecha)->locale('es')->translatedFormat('l d \d\e F Y') }}</p>
            <p><strong>🕒 Hora:</strong> {{ substr($boleto->funcion->hora_inicio, 0, 5) }}</p>
            <p><strong>🏛️ Sala:</strong> {{ $boleto->funcion->sala->nombre }}</p>
            <p><strong>🪑 Butaca:</strong> {{ $boleto->butaca->numero }} </p>
        </div>
        <div class="qr">
            {!! $qr !!}
            <p>Escanea para validar tu entrada</p>
        </div>
    </div>
</body>
</html>
