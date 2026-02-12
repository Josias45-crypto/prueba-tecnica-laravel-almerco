<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $emailData->asunto }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #0056b3;">{{ $emailData->asunto }}</h2>
        
        <div style="margin: 20px 0;">
            {!! nl2br(e($emailData->cuerpo)) !!}
        </div>
        
        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
        
        <p style="font-size: 12px; color: #666;">
            <strong>Enviado por:</strong> {{ $emailData->user->nombre }}<br>
            <strong>Email:</strong> {{ $emailData->user->email }}<br>
            <strong>Fecha:</strong> {{ $emailData->created_at->format('d/m/Y H:i') }}
        </p>
        
        <p style="font-size: 12px; color: #999; margin-top: 20px;">
            Este es un email enviado desde {{ config('app.name') }}
        </p>
    </div>
</body>
</html>
