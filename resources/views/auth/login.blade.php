@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg9">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Sign In</li>
                </ul>
                <h3>Sign In</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Sign In Area -->
    <div class="sign-in-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="user-all-form">
                        <div class="contact-form">
                            <div class="section-title text-center">
                                <span class="sp-color">Sign In</span>
                                <h2>Sign In to Your Account!</h2>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="form-group">
                                            <input type="text" name="login" id="login"
                                                class="form-control @error('login') login-input-error @enderror"
                                                data-error="Please enter your Username or Email"
                                                placeholder="Email/Name/Phone">

                                            @error('login')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="password-field">
                                                <input class="form-control @error('password') login-input-error @enderror"
                                                    type="password" name="password" id="password" placeholder="Password">
                                                <button type="button" class="toggle-password" aria-label="Show password"
                                                    aria-pressed="false">
                                                    <i class="bx bx-hide"></i>
                                                </button>
                                            </div>

                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-6 form-condition">
                                        <div class="agree-label">
                                            <input type="checkbox" id="chb1">
                                            <label for="chb1">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-6">
                                        <a class="forget" href="{{ route('password.request') }}">Forgot My Password?</a>
                                    </div>

                                    <div class="col-lg-12 col-md-12 text-center">
                                        <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                            Sign In Now
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <p class="account-desc">
                                            Not a Member?
                                            <a href="{{ route('register') }}">Sign Up</a>
                                        </p>
                                    </div>
                                </div>
                            </form>

                            <style>
                                .contact-form .form-group .form-control.login-input-error {
                                    border-color: #dc3545 !important;
                                }

                                .contact-form .form-group .form-control.login-input-error:focus {
                                    border-color: #dc3545 !important;
                                    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                                }

                                .contact-form .password-field {
                                    position: relative;
                                }

                                .contact-form .password-field .form-control {
                                    padding-right: 50px;
                                }

                                .contact-form .password-field .toggle-password {
                                    position: absolute;
                                    top: 50%;
                                    right: 15px;
                                    width: 24px;
                                    height: 24px;
                                    padding: 0;
                                    border: 0;
                                    background: transparent;
                                    color: #555;
                                    cursor: pointer;
                                    line-height: 1;
                                    transform: translateY(-50%);
                                }

                                .contact-form .password-field .toggle-password:focus {
                                    outline: none;
                                    color: #f9ab30;
                                }

                                .contact-form .password-field .toggle-password i {
                                    font-size: 20px;
                                }
                            </style>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const togglePassword = document.querySelector('.toggle-password');
                                    const passwordInput = document.getElementById('password');

                                    if (!togglePassword || !passwordInput) {
                                        return;
                                    }

                                    togglePassword.addEventListener('click', function () {
                                        const isPassword = passwordInput.getAttribute('type') === 'password';
                                        const icon = this.querySelector('i');

                                        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                                        this.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                                        this.setAttribute('aria-pressed', isPassword ? 'true' : 'false');

                                        icon.classList.toggle('bx-hide', !isPassword);
                                        icon.classList.toggle('bx-show', isPassword);
                                    });
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign In Area End -->
@endsection
