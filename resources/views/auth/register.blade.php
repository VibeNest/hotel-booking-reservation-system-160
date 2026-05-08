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
                    <li>Sign Up</li>
                </ul>
                <h3>Sign Up</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Sign Up Area -->
    <div class="sign-up-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="user-all-form">
                        <div class="contact-form">
                            <div class="section-title text-center">
                                <span class="sp-color">Sign Up</span>
                                <h2>Create an Account!</h2>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') register-input-error @enderror"
                                                data-error="Please enter your Name" placeholder="Name">

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') register-input-error @enderror"
                                                data-error="Please enter email" placeholder="Email">

                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 ">
                                        <div class="form-group">
                                            <input type="text" name="phone" id="phone"
                                                class="form-control @error('phone') register-input-error @enderror"
                                                data-error="Please enter your Phone" placeholder="Phone">

                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 ">
                                        <div class="form-group">
                                            <input type="text" name="address" id="address"
                                                class="form-control @error('address') register-input-error @enderror"
                                                data-error="Please enter your Address" placeholder="Address">

                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <input class="form-control @error('password') register-input-error @enderror"
                                                type="password" name="password" id="password" placeholder="Password">

                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <input
                                                class="form-control @error('password_confirmation') register-input-error @enderror"
                                                type="password" name="password_confirmation" id="password_confirmation"
                                                placeholder="Confirm Password">

                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 text-center">
                                        <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                            Sign Up
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <p class="account-desc">
                                            Already have an account?
                                            <a href="{{ route('login') }}">Sign In</a>
                                        </p>
                                    </div>
                                </div>
                            </form>

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
    <!-- Sign Up Area End -->
@endsection