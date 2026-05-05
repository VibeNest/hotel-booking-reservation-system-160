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
                @forelse ($rooms as $room)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-card">
                            <a href="{{ route('room.details', $room->id) }}">
                                <img class="room-list-img"
                                    src="{{ $room->image ? asset('upload/room_images/' . $room->image) : asset('frontend/assets/img/room/room-img1.jpg') }}"
                                    alt="{{ $room->type->name ?? 'Room Image' }}">
                            </a>
                            <div class="content">
                                <h3>
                                    <a href="{{ route('room.details', $room->id) }}">
                                        {{ $room->type->name ?? 'Room' }}
                                    </a>
                                </h3>
                                <ul>
                                    <li class="text-color">{{ $room->price ?? 0 }}</li>
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
                @empty
                    <div class="col-12">
                        <p class="text-center">No rooms found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Room Area End -->

    <style>
        .room-list-img {
            width: 550px;
            height: 450px;
            max-width: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
@endsection