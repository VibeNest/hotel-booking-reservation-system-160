@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg7">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Place Order</li>
                </ul>
                <h3>Place Order</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Place Order Area -->
    <div class="place-order-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="place-order-card text-center">
                        <div class="success-icon">
                            <i class='bx bx-check'></i>
                        </div>

                        <h2>Your Order Has Been Placed Successfully!</h2>

                        <p>
                            Thank you for choosing our hotel booking service.
                            Your reservation is currently being processed.
                            A confirmation email with booking details will be sent shortly.
                        </p>

                        <div class="order-info">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <h5>Booking Number</h5>
                                        <span>#{{ $booking->code }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="info-box">
                                        <h5>Payment</h5>
                                        <span>{{ $booking->payment_status == 1 ? 'Complete' : 'Pending' }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="info-box">
                                        <h5>Status</h5>
                                        <span>{{ $booking->status == 1 ? 'Complete' : 'Pending' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="place-order-btn mt-4">
                            <a href="/" class="default-btn btn-bg-one border-radius-5">
                                Back To Home
                            </a>

                            <a href="/booking-history" class="default-btn btn-bg-two border-radius-5 ms-3">
                                View Booking
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Place Order Area End -->

    <!-- Custom Style -->
    <style>
        .place-order-area {
            background: #f8f9fc;
        }

        .place-order-card {
            background: #fff;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .place-order-card:hover {
            transform: translateY(-5px);
        }

        .success-icon {
            width: 110px;
            height: 110px;
            line-height: 110px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #5cd67c);
            color: #fff;
            font-size: 55px;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.35);
        }

        .place-order-card h2 {
            font-size: 34px;
            font-weight: 700;
            color: #222;
            margin-bottom: 20px;
        }

        .place-order-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 35px;
        }

        .order-info {
            margin-top: 20px;
        }

        .info-box {
            background: #f4f7fb;
            padding: 25px 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .info-box:hover {
            background: #eef4ff;
            transform: translateY(-3px);
        }

        .info-box h5 {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .info-box span {
            font-size: 18px;
            font-weight: 700;
            color: #111;
        }

        .place-order-btn .default-btn {
            padding: 12px 30px;
            font-size: 16px;
        }

        @media only screen and (max-width: 767px) {
            .place-order-card {
                padding: 40px 20px;
            }

            .place-order-card h2 {
                font-size: 26px;
            }

            .place-order-btn .default-btn {
                display: block;
                width: 100%;
                margin-bottom: 15px;
            }

            .place-order-btn .ms-3 {
                margin-left: 0 !important;
            }
        }
    </style>
@endsection