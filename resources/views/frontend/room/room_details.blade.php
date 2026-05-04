@extends('frontend.home_page')

@section('home')

<!-- Banner -->
<div class="inner-banner inner-bg10">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li><a href="/">Home</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Room Details</li>
            </ul>
            <h3>{{ $room->room_type_name ?? 'Room Details' }}</h3>
        </div>
    </div>
</div>

<!-- Room Details -->
<div class="room-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">

            <!-- LEFT -->
            <div class="col-lg-4">
                <div class="side-bar-form">
                    <h3>Booking Sheet</h3>

                    <form>
                        <div class="form-group">
                            <label>Check in</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Check out</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Number of Persons</label>
                            <select class="form-control">
                                @for($i = 1; $i <= 5; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Number of Rooms</label>
                            <select class="form-control">
                                @for($i = 1; $i <= 5; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <button class="default-btn btn-bg-three w-100">
                            Book Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-8">

                <!-- SLIDER -->
                <div class="room-details-slider owl-carousel">
                    @forelse($multiImages as $img)
                        <div>
                            <img src="{{ asset($img->multi_img) }}" alt="">
                        </div>
                    @empty
                        <div>
                            <img src="{{ asset('upload/no_image.jpg') }}" alt="">
                        </div>
                    @endforelse
                </div>

                <!-- TITLE -->
                <div class="room-details-title mt-3">
                    <h2>{{ $room->room_type_name }}</h2>
                    <b>${{ number_format($room->price) }} / Night</b>
                </div>

                <!-- CONTENT -->
                <div class="room-details-content mt-3">
                    <p>{{ $room->short_desc }}</p>
                    <p>{{ $room->description }}</p>

                    <!-- FACILITIES -->
                    <div class="side-bar-plan">
                        <h3>Facilities</h3>
                        <ul>
                            @forelse($facilities as $item)
                                <li>{{ $item->facility_name }}</li>
                            @empty
                                <li>No facilities</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- INFO -->
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="services-bar-widget">
                                <h3 class="title">Room Info</h3>

                                <ul>
                                    <li><b>Capacity:</b> {{ $room->room_capacity }}</li>
                                    <li><b>Size:</b> {{ $room->size }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="services-bar-widget">
                                <h3 class="title">More Details</h3>

                                <ul>
                                    <li><b>View:</b> {{ $room->view }}</li>
                                    <li><b>Bed Style:</b> {{ $room->bed_style }}</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- REVIEW (đặt đúng chỗ) -->
                <div class="room-details-review mt-4">
                    <h2>Clients Review</h2>

                    <div class="review-ratting">
                        <h3>Your rating:</h3>
                        <i class='bx bx-star'></i>
                        <i class='bx bx-star'></i>
                        <i class='bx bx-star'></i>
                        <i class='bx bx-star'></i>
                        <i class='bx bx-star'></i>
                    </div>

                    <form>
                        <textarea class="form-control mb-3" rows="5"
                                  placeholder="Write your review..."></textarea>

                        <button class="default-btn btn-bg-three">
                            Submit Review
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Room Details Area End -->

<!-- Room Details Other -->
    <div class="room-details-other pb-70">
        <div class="container">
            <div class="room-details-text">
                <h2>Our Related Offer</h2>
            </div>

            <div class="row ">
                <div class="col-lg-6">
                    <div class="room-card-two">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-4 p-0">
                                <div class="room-card-img">
                                    <a href="room-details.html">
                                        <img src="{{ asset('frontend/assets/img/room/room-style-img1.jpg') }}" alt="Images">
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-7 col-md-8 p-0">
                                <div class="room-card-content">
                                    <h3>
                                        <a href="room-details.html">Luxury Room</a>
                                    </h3>
                                    <span>320 / Per Night </span>
                                    <div class="rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed
                                        pulvinar purus.</p>
                                    <ul>
                                        <li><i class='bx bx-user'></i> 4 Person</li>
                                        <li><i class='bx bx-expand'></i> 35m2 / 376ft2</li>
                                    </ul>

                                    <ul>
                                        <li><i class='bx bx-show-alt'></i> Sea Balcony</li>
                                        <li><i class='bx bxs-hotel'></i> Kingsize / Twin</li>
                                    </ul>

                                    <a href="room-details.html" class="book-more-btn">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="room-card-two">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-4 p-0">
                                <div class="room-card-img">
                                    <a href="room-details.html">
                                        <img src="{{ asset('frontend/assets/img/room/room-style-img2.jpg') }}" alt="Images">
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-7 col-md-8 p-0">
                                <div class="room-card-content">
                                    <h3>
                                        <a href="room-details.html">Single Room</a>
                                    </h3>
                                    <span>300 / Per Night </span>
                                    <div class="rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed
                                        pulvinar purus.</p>
                                    <ul>
                                        <li><i class='bx bx-user'></i> 1 Person</li>
                                        <li><i class='bx bx-expand'></i> 25m2 / 276ft2</li>
                                    </ul>

                                    <ul>
                                        <li><i class='bx bx-show-alt'></i> Sea Balcony</li>
                                        <li><i class='bx bxs-hotel'></i> Smallsize / Twin</li>
                                    </ul>

                                    <a href="room-details.html" class="book-more-btn">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Room Details Other End -->
@endsection