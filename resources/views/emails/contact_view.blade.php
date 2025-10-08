@extends('client.layouts.layoutMaster')

@section('title', 'Nouveau message de contact')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouveau message de contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            background: linear-gradient(90deg, #ffba00 0%, #ff6c00 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .info-item {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-left: 4px solid #ffba00;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .message-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nouveau message de contact</h1>
            <p>Site: {{ config('app.name') }}</p>
        </div>
        
        <div class="content">
            <p>Vous avez reçu un nouveau message de contact via le formulaire de votre site.</p>
            
            <div class="info-item">
                <span class="label">Nom:</span> {{ $name }}
            </div>
            
            <div class="info-item">
                <span class="label">Email:</span> {{ $email }}
            </div>
            
            <div class="info-item">
                <span class="label">Sujet:</span> {{ $subject }}
            </div>
            
            <div class="message-box">
                <strong>Message:</strong>
                <p>{{ $messageContent }}</p>
            </div>
            
            <div style="margin-top: 25px; padding: 15px; background: #e7f3ff; border-radius: 5px;">
                <strong>💡 Information:</strong>
                <p style="margin: 5px 0 0 0; font-size: 14px;">
                    Ce message a été envoyé depuis le formulaire de contact de votre site web. 
                    Vous pouvez répondre directement à cet email pour contacter {{ $name }}.
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
@endsection