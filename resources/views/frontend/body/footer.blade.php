@php
    $setting = App\Models\SiteSetting::find(1);
    $logo = $setting->logo ?? 'frontend/assets/img/logo.png';
    $address2 = $setting->address ?? '';
    $phone2 = $setting->phone ?? '';
    $email2 = $setting->email ?? '';
    $copyright = $setting->copyright ?? '';
    $facebook = $setting->facebook ?? '#';
    $tiktok = $setting->tiktok ?? '#';
    $instagram = $setting->instagram ?? '#';
@endphp

<footer class="footer-area footer-bg">
    <div class="container">
        <div class="footer-top pt-100 pb-70">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="/">
                                <img src="{{ asset($logo) }}" alt="Logo Image">
                            </a>
                        </div>
                        <p>
                            Developed a hotel booking website that allows users to search hotels, view room details,
                            make reservations, manage bookings, and process online payments. Built with a responsive
                            interface and an admin dashboard for managing hotels, rooms, bookings, and users.
                        </p>
                        <ul class="footer-list-contact">
                            <li>
                                <i class='bx bx-home-alt'></i>
                                <a href="#">{{ $address2 }}</a>
                            </li>
                            <li>
                                <i class='bx bx-phone-call'></i>
                                <a href="#">{{ $phone2 }}</a>
                            </li>
                            <li>
                                <i class='bx bx-envelope'></i>
                                <a href="#">{{ $email2 }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget pl-5">
                        <h3>Links</h3>
                        <ul class="footer-list">
                            <li>
                                <a href="/">
                                    <i class='bx bx-caret-right'></i>
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about.us') }}">
                                    <i class='bx bx-caret-right'></i>
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('show.gallery') }}">
                                    <i class='bx bx-caret-right'></i>
                                    Gallery
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('blog.list') }}">
                                    <i class='bx bx-caret-right'></i>
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('room.all') }}">
                                    <i class='bx bx-caret-right'></i>
                                    Rooms
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact.us') }}">
                                    <i class='bx bx-caret-right'></i>
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <h3>Newsletter</h3>
                        <p>
                            A web application for hotel search, room booking, online payments, booking management,
                            newsletter subscriptions, and administrative management of hotels, rooms, and users.
                        </p>
                        <div class="footer-form">
                            <form class="newsletter-form" data-toggle="validator" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Your Email*"
                                                name="EMAIL" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn btn-bg-one">
                                            Subscribe Now
                                        </button>
                                        <div id="validator-newsletter" class="form-result"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copy-right-area">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="copy-right-text text-align1">
                        <p>
                            {{ $copyright }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="social-icon text-align2">
                        <ul class="social-link">
                            <li>
                                <a href="{{ $facebook }}" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="{{ $tiktok }}" target="_blank"><i class='bx bxl-tiktok'></i></a>
                            </li>
                            <li>
                                <a href="{{ $instagram }}" target="_blank"><i class='bx bxl-instagram'></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>