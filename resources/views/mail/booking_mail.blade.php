<!DOCTYPE html>

<html>

<head>
    <title>Booking Confirmation - HotelHub</title>
    <meta charset="utf-8" />
    <meta content="width=device-width" name="viewport" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2d3748;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -1px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .welcome-section {
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-section h2 {
            font-size: 28px;
            color: #2d3748;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .welcome-section p {
            font-size: 16px;
            color: #718096;
            line-height: 1.6;
        }

        .booking-details {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }

        .booking-details h3 {
            font-size: 14px;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }

        .detail-value {
            color: #2d3748;
            font-size: 14px;
        }

        .cta-section {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .footer-section {
            background-color: #f7fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .footer-link {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .copyright {
            color: #a0aec0;
            font-size: 12px;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .header h1 {
                font-size: 36px;
            }

            .welcome-section h2 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .detail-item {
                flex-direction: column;
            }

            .detail-value {
                margin-top: 5px;
                font-weight: 500;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏨 HotelHub</h1>
            <p>Booking Confirmation</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2>Your Booking is Confirmed!</h2>
                <p>Thank you for choosing HotelHub. We're excited to host you! Your reservation details are below.</p>
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <h3>📋 Booking Details</h3>
                <div class="detail-item">
                    <span class="detail-label">Check-in Date: </span>
                    <span class="detail-value">{{ $booking['check_in'] }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Check-out Date: </span>
                    <span class="detail-value">{{ $booking['check_out'] }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Guest Name: </span>
                    <span class="detail-value">{{ $booking['name'] }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email: </span>
                    <span class="detail-value">{{ $booking['email'] }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone: </span>
                    <span class="detail-value">{{ $booking['phone'] }}</span>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-section">
                <a href="{{ route('user.booking') }}" class="btn">View Your Booking</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-section">
            <div class="footer-links">
                <a href="#" class="footer-link">About Us</a>
                <a href="#" class="footer-link">Contact Us</a>
                <a href="#" class="footer-link">Help Center</a>
            </div>
            <div class="copyright">
                <p>2026 © HotelHub. All Rights Reserved.</p>
                <p>This email was sent to you because you made a booking with us. If you have any questions, please
                    contact our support team.</p>
            </div>
        </div>
</body>