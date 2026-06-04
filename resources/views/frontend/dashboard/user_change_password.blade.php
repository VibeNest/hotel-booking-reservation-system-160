@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg6">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>User Change Password </li>
                </ul>
                <h3>User Change Password</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Service Details Area -->
    <div class="service-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    {{-- Sidebar --}}
                    @include('frontend.dashboard.user_menu')
                </div>


                <div class="col-lg-9">
                    <div class="service-article">


                        <section class="checkout-area pb-70">
                            <div class="container">

                                <form action="{{ route("user.password.update") }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="billing-details">
                                                <h3 class="title">User Change Password </h3>

                                                <div class="row">

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Current Password</label>
                                                            <input type="password" name="current_password"
                                                                id="current_password"
                                                                class="form-control @error('current_password') is-invalid @enderror"
                                                                placeholder="Enter current password">

                                                            @error('current_password')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <input type="password" name="new_password" id="new_password"
                                                                class="form-control @error('new_password') is-invalid @enderror"
                                                                placeholder="Enter new password">

                                                            @error('new_password')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Confirm New Password</label>
                                                            <input type="password" name="new_password_confirmation"
                                                                id="new_password_confirmation" class="form-control"
                                                                placeholder="Enter confirm new password">
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-danger">Save Changes </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </section>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Service Details Area End -->
@endsection