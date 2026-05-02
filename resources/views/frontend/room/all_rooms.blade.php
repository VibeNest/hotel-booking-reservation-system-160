@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg9">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Rooms</li>
                </ul>
                <h3>Rooms</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Room Area -->
    <div class="room-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color">ROOMS</span>
                <h2>Our Rooms & Rates</h2>
            </div>
            <div class="row pt-45">
                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <a href="{{ url('room/details') }}">
                            <img src="{{ asset('frontend/assets/img/room/room-img1.jpg') }}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="{{ url('room/details') }}">Luxury Room</a></h3>
                            <ul>
                                <li class="text-color">320</li>
                                <li class="text-color">Per Night</li>
                            </ul>
                            <div class="rating text-color">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star-half'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <a href="room-details.html">
                            <img src="{{ asset('frontend/assets/img/room/room-img2.jpg') }}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="room-details.html">Single Room</a></h3>
                            <ul>
                                <li class="text-color">300</li>
                                <li class="text-color">Per Night</li>
                            </ul>
                            <div class="rating text-color">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star-half'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <a href="room-details.html">
                            <img src="{{ asset('frontend/assets/img/room/room-img3.jpg') }}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="room-details.html">Double Room</a></h3>
                            <ul>
                                <li class="text-color">350</li>
                                <li class="text-color">Per Night</li>
                            </ul>
                            <div class="rating text-color">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star-half'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <a href="room-details.html">
                            <img src="{{ asset('frontend/assets/img/room/room-img4.jpg') }}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="room-details.html">Family Room</a></h3>
                            <ul>
                                <li class="text-color">370</li>
                                <li class="text-color">Per Night</li>
                            </ul>
                            <div class="rating text-color">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star-half'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <a href="room-details.html">
                            <img src="{{ asset('frontend/assets/img/room/room-img5.jpg') }}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="room-details.html">Deluxe Room</a></h3>
                            <ul>
                                <li class="text-color">270</li>
                                <li class="text-color">Per Night</li>
                            </ul>
                            <div class="rating text-color">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star-half'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <a href="room-details.html">
                            <img src="{{ asset('frontend/assets/img/room/room-img6.jpg') }}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="room-details.html">Presidential Room</a></h3>
                            <ul>
                                <li class="text-color">270</li>
                                <li class="text-color">Per Night</li>
                            </ul>
                            <div class="rating text-color">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star-half'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="pagination-area">
                        <a href="#" class="prev page-numbers">
                            <i class='bx bx-chevrons-left'></i>
                        </a>

                        <span class="page-numbers current" aria-current="page">1</span>
                        <a href="#" class="page-numbers">2</a>
                        <a href="#" class="page-numbers">3</a>

                        <a href="#" class="next page-numbers">
                            <i class='bx bx-chevrons-right'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Area End -->
@endsection