@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg10">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>OTP Verification</li>
                </ul>
                <h3>OTP Verification</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <div class="sign-up-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="user-all-form">
                        <div class="contact-form">
                            <div class="section-title text-center">
                                <span class="sp-color">Verify your account</span>
                                <h2>Enter the 6-digit OTP</h2>
                            </div>

                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if ($user)
                                <p class="text-center mb-4">
                                    We sent an OTP to <strong>{{ $user->email }}</strong>. Enter it below to activate your
                                    account.
                                </p>
                            @endif

                            <form method="POST" action="{{ route('otp.verification.verify') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $user->email ?? request('email') }}">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="otp" id="otp"
                                                class="form-control @error('otp') register-input-error @enderror"
                                                maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                                                placeholder="Enter 6-digit OTP">

                                            @error('otp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 text-center">
                                        <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                            Verify OTP
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('otp.verification.resend') }}" class="mt-3 text-center">
                                @csrf
                                <input type="hidden" name="email" value="{{ $user->email ?? request('email') }}">
                                <button type="submit" class="btn btn-link p-0 text-decoration-none">
                                    Resend OTP
                                </button>
                            </form>

                            <div class="mt-4 text-center">
                                <a href="{{ route('register') }}">Back to registration</a>
                            </div>

                            <style>
                                .contact-form .form-group .form-control.register-input-error {
                                    border-color: #dc3545 !important;
                                }

                                .contact-form .form-group .form-control.register-input-error:focus {
                                    border-color: #dc3545 !important;
                                    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection