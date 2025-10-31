<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RALankaProperty Newsletter</title>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #1167B1;">RALankaProperty</h1>
        </div>
        
        <div style="background: #f8f9fa; padding: 30px; border-radius: 8px;">
            @if($type === 'new')
                <h2 style="color: #1167B1; margin-bottom: 20px;">Welcome to Our Newsletter!</h2>
                <p>Thank you for subscribing to RALankaProperty newsletter. You'll now receive:</p>
                <ul>
                    <li>Latest property listings and updates</li>
                    <li>Exclusive deals and offers</li>
                    <li>Market insights and trends</li>
                    <li>Helpful real estate tips</li>
                </ul>
            @else
                <h2 style="color: #1167B1; margin-bottom: 20px;">Welcome Back!</h2>
                <p>We're glad to have you back in our RALankaProperty newsletter community!</p>
            @endif
            
            <p style="margin-top: 20px;">
                <strong>Email:</strong> {{ $email }}
            </p>
        </div>
        
        <div style="text-align: center; margin-top: 30px; color: #666; font-size: 14px;">
            <p>If you wish to unsubscribe at any time, you can do so from your account settings.</p>
            <p>&copy; {{ date('Y') }} RALankaProperty. All rights reserved.</p>
        </div>
    </div>
</body>
</html>