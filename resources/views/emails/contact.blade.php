<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .success-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        .success-body {
            padding: 30px;
        }
        .message-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            width: 100px;
            color: #495057;
        }
        .detail-value {
            flex: 1;
        }
        .btn-home {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .confirmation-email {
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            border-radius: 5px;
            margin-top: 25px;
        }
        .timer {
            font-size: 14px;
            color: #6c757d;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-container">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Message Sent Successfully!</h1>
                <p class="mb-0">Thank you for contacting us. We'll get back to you soon.</p>
            </div>
            
            <div class="success-body">
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                        Your message has been delivered successfully. We've sent a confirmation to your email address.
                    </div>
                </div>
                
                <h3 class="mb-3">Message Details</h3>
                <div class="message-details">
                    <div class="detail-row">
                        <div class="detail-label">Name:</div>
                        <div class="detail-value" id="user-name">John Doe</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value" id="user-email">john.doe@example.com</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Subject:</div>
                        <div class="detail-value" id="user-subject">Website Inquiry</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Message:</div>
                        <div class="detail-value" id="user-message">Hello, I would like to inquire about your services. Please contact me at your earliest convenience.</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Sent:</div>
                        <div class="detail-value" id="sent-time">Just now</div>
                    </div>
                </div>
                
                <div class="confirmation-email">
                    <h5><i class="fas fa-envelope me-2"></i>Confirmation Email Sent</h5>
                    <p class="mb-0">We've sent a copy of this message to your email address for your records.</p>
                </div>
                
                <div class="text-center mt-4">
                    <button class="btn btn-home me-2" id="return-home">
                        <i class="fas fa-home me-2"></i>Return to Homepage
                    </button>
                    <button class="btn btn-outline-secondary" id="send-another">
                        <i class="fas fa-plus me-2"></i>Send Another Message
                    </button>
                </div>
                
                <div class="timer text-center">
                    <p>You will be automatically redirected to the homepage in <span id="countdown">10</span> seconds</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simulate dynamic data - in a real application, this would come from your backend
        document.addEventListener('DOMContentLoaded', function() {
            // Set current time
            const now = new Date();
            document.getElementById('sent-time').textContent = now.toLocaleString();
            
            // Countdown timer for automatic redirect
            let countdown = 10;
            const countdownElement = document.getElementById('countdown');
            const countdownInterval = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = '/';
                }
            }, 1000);
            
            // Button event handlers
            document.getElementById('return-home').addEventListener('click', function() {
                window.location.href = '/';
            });
            
            document.getElementById('send-another').addEventListener('click', function() {
                window.location.href = '/contact';
            });
        });
    </script>
</body>
</html>