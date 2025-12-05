<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alerta de Stock Bajo</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #d97706;">¡ALERTA DE STOCK BAJO!</h2>
    <p>El producto <strong>{{ $producto->nombre }}</strong> tiene solo <strong style="color: red;">{{ $producto->stock }} unidades</strong> en inventario.</p>
    <p>Stock mínimo recomendado: <strong>10 unidades</strong></p>
    <p>Se recomienda reabastecer lo antes posible para evitar interrupciones en la producción.</p>
    <hr>
    <p><small>Este es un mensaje automático del Sistema de Gestión de Inventario - Panadería La Antigua</small></p>
</body>
</html>