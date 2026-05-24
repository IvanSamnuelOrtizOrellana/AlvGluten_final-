<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <style>
        body { margin: 0; padding: 0; background: #f3f4f6; font-family: 'Segoe UI', sans-serif; }
        .wrapper { max-width: 600px; margin: 40px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #65a30d, #4d7c0f); padding: 40px 32px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 28px; font-weight: 900; }
        .header p { color: #d9f99d; margin: 8px 0 0; font-size: 15px; }
        .body { padding: 32px; }
        .greeting { font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 28px; }
        .order-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .order-id { font-size: 13px; color: #6b7280; margin-bottom: 4px; }
        .order-id strong { color: #65a30d; font-size: 20px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .items-table th { background: #f3f4f6; padding: 10px 12px; text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; }
        .items-table td { padding: 12px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #374151; }
        .items-table tr:last-child td { border-bottom: none; }
        .total-row { background: #f0fdf4; }
        .total-row td { font-weight: 900; font-size: 16px; color: #15803d; padding: 14px 12px; }
        .badge { display: inline-block; background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .footer { background: #f9fafb; padding: 24px 32px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 4px 0; }
        .footer a { color: #65a30d; text-decoration: none; font-weight: 600; }
        .cta { display: block; background: #65a30d; color: white !important; text-decoration: none; text-align: center; padding: 14px 28px; border-radius: 12px; font-weight: 800; font-size: 15px; margin: 24px 0 0; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <a href="/" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo_alvgluten.png') }}" alt="Logo AlvGluten" class="h-24 w-auto max-w-[300px] sm:h-16 sm:max-w-[340px] object-contain transition-transform group-hover:scale-130">

        </a>
    </div>

    {{-- Body --}}
    <div class="body">
        <p class="greeting">¡Hola, {{ $userName }}! </p>
        <p class="subtitle">
            Tu pedido fue recibido y está siendo procesado. Aquí tienes el resumen:
        </p>

        <div class="order-box">
            <p class="order-id">
                Número de pedido: <strong>#{{ $order->id }}</strong>
            </p>
            <p style="margin: 8px 0 0; font-size: 13px; color: #6b7280;">
                Fecha: {{ $order->created_at->format('d/m/Y H:i') }} ·
                <span class="badge">{{ ucfirst($order->status) }}</span>
            </p>
        </div>

        {{-- Tabla de productos --}}
        <table class="items-table">
            <thead>
            <tr>
                <th>Producto</th>
                <th style="text-align:center">Cant.</th>
                <th style="text-align:right">Precio</th>
                <th style="text-align:right">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align:center">{{ $item->quantity }}</td>
                    <td style="text-align:right">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align:right; font-weight:700">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total pagado</td>
                <td style="text-align:right">${{ number_format($order->total, 2) }} MXN</td>
            </tr>
            </tbody>
        </table>

        <a href="{{ url('/') }}" class="cta">
            Seguir comprando →
        </a>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>¿Dudas? Escríbenos a <a href="mailto:hola@alvgluten.com">hola@alvgluten.com</a></p>
        <p style="margin-top:8px">© {{ date('Y') }} AlvGluten · Guadalajara, Jalisco, México 🇲🇽</p>
        <p>Hecho para celíacos que no son millonarios</p>
    </div>

</div>
</body>
</html>