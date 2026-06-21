@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg1">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>About</li>
                </ul>
                <h3>About HotelHub</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- About Area -->
    <div class="about-area pt-100 pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img">
                        <img src="{{ asset('frontend/assets/img/ability-img2.jpg') }}" alt="HotelHub hospitality">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about-content">
                        <div class="section-title">
                            <span class="sp-color">About Us</span>
                            <h2>We Make Every Stay Feel Carefully Prepared</h2>
                            <p>
                                HotelHub is built for travelers who want comfort, clear choices, and a booking experience
                                that feels simple from the first search to the final check-out.
                            </p>
                        </div>

                        <ul>
                            <li>
                                <i class='flaticon-hotel'></i>
                                <div class="content">
                                    <h3>Curated Room Selection</h3>
                                    <p>
                                        Every room is presented with practical details, real photos, facilities, and
                                        availability so guests can book with confidence.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <i class='flaticon-resort'></i>
                                <div class="content">
                                    <h3>Hospitality With Purpose</h3>
                                    <p>
                                        Our team focuses on clean spaces, thoughtful service, flexible reservations, and
                                        quick support for both leisure and business stays.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <i class='flaticon-calendar'></i>
                                <div class="content">
                                    <h3>Fast Booking Flow</h3>
                                    <p>
                                        Guests can search dates, compare rooms, confirm details, and manage bookings in
                                        a smooth digital journey.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Area End -->

    <!-- Ability Area -->
    <div class="ability-area pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="ability-content">
                        <div class="section-title">
                            <span class="sp-color">Our Strength</span>
                            <h2>Designed Around Guest Comfort and Hotel Operations</h2>
                            <p>
                                From room discovery to booking confirmation, HotelHub connects guest expectations with
                                the hotel's daily workflow. The result is a cleaner reservation process and a calmer
                                arrival experience.
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="ability-counter">
                                    <h3>24/7</h3>
                                    <p>Guest Support</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="ability-counter">
                                    <h3>98%</h3>
                                    <p>Happy Guests</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="ability-counter">
                                    <h3>45+</h3>
                                    <p>Room Choices</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="ability-counter">
                                    <h3>12K</h3>
                                    <p>Bookings Served</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ability-img">
                        <img src="{{ asset('frontend/assets/img/about/about-img3.jpg') }}" alt="HotelHub guest lounge">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ability Area End -->

    <!-- Choose Area -->
    <div class="choose-area pt-100 pb-70 section-bg">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color">Why Choose Us</span>
                <h2>Everything Guests Need Before They Decide to Stay</h2>
            </div>

            <div class="row pt-45">
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <i class='flaticon-wifi-signal-1'></i>
                        <h3>Comfortable Facilities</h3>
                        <p>
                            High-speed Wi-Fi, essential amenities, clean rooms, and relaxing shared spaces are prepared
                            to make every stay productive and restful.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <i class='bx bx-time-five'></i>
                        <h3>Simple Reservation</h3>
                        <p>
                            Guests can check availability, select room types, and complete a reservation with fewer
                            steps and clearer booking details.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <i class='bx bx-support'></i>
                        <h3>Friendly Assistance</h3>
                        <p>
                            Our service team helps with special requests, booking questions, arrival plans, and support
                            throughout the guest journey.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <i class='flaticon-restaurant'></i>
                        <h3>Dining Convenience</h3>
                        <p>
                            Breakfast, refreshments, and nearby dining guidance help guests enjoy the destination
                            without spending extra time planning.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <i class='flaticon-buildings'></i>
                        <h3>Business Ready</h3>
                        <p>
                            Meeting-friendly spaces, calm working corners, and practical room options support business
                            travelers and group stays.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <i class='bx bx-shield-quarter'></i>
                        <h3>Secure Experience</h3>
                        <p>
                            Clear booking records, trusted payment flows, and organized guest information help make each
                            reservation reliable.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Choose Area End -->

    <!-- Services Area Three -->
    <div class="services-area-three pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color">How It Works</span>
                <h2>A Smooth Journey From Search to Check-Out</h2>
            </div>

            <div class="row pt-45">
                <div class="col-lg-6 col-md-6">
                    <div class="service-item-two">
                        <i class='bx bx-search-alt'></i>
                        <div class="content">
                            <h3><a href="{{ route('room.all') }}">Explore Available Rooms</a></h3>
                            <p>
                                Browse room styles, compare details, review facilities, and find the space that matches
                                your travel purpose.
                            </p>
                            <a href="{{ route('room.all') }}" class="read-btn">View Rooms</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="service-item-two">
                        <i class='flaticon-calendar'></i>
                        <div class="content">
                            <h3><a href="/">Check Your Dates</a></h3>
                            <p>
                                Search check-in and check-out dates before booking so the final choice is practical,
                                available, and transparent.
                            </p>
                            <a href="/" class="read-btn">Search Dates</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="service-item-two">
                        <i class='flaticon-money'></i>
                        <div class="content">
                            <h3><a href="{{ route('room.all') }}">Confirm Securely</a></h3>
                            <p>
                                Review booking details, add guest information, and complete payment through the
                                supported checkout options.
                            </p>
                            <a href="{{ route('room.all') }}" class="read-btn">Start Booking</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="service-item-two">
                        <i class='flaticon-hotel'></i>
                        <div class="content">
                            <h3><a href="{{ route('contact.us') }}">Arrive With Confidence</a></h3>
                            <p>
                                Your reservation information is ready for the hotel team, helping check-in feel faster
                                and more welcoming.
                            </p>
                            <a href="{{ route('contact.us') }}" class="read-btn">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services Area Three End -->

    <!-- Team Area Three -->
    @include('frontend.home.team')
    <!-- Team Area Three End -->

    <!-- Testimonials Area Three -->
    @include('frontend.home.testimonials')
    <!-- Testimonials Area Three End -->
@endsection