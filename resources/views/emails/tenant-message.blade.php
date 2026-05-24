<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .header { background: #0d9488; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thomas Apartment Notification</h2>
        </div>
        <div class="content">
            <p>Dear {{ $tenantName }},</p>
            <p>{{ $messageBody }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Thomas Apartment Management. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
