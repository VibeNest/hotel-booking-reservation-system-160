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

                @foreach ($rooms as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-card">
                            <a href="{{ route('room.details', $item->id) }}">
                                <img src="{{ asset('upload/room_images/' . $item->image) }}" alt="Images" width="550"
                                    height="450">
                            </a>
                            <div class="content">
                                <h3><a href="{{ route('room.details', $item->id) }}">{{ $item->type->name }}</a></h3>
                                <ul>
                                    <li class="text-color">${{ $item->price }}</li>
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
                @endforeach

                <div class="col-lg-12 col-md-12">
                    {{ $rooms->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    <!-- Room Area End -->
@endsection
<style>
.custom-pagination {
    gap: 10px;
}

.custom-pagination li {
    list-style: none;
}

.custom-pagination li a,
.custom-pagination li span {
    width: 40px;
    height: 40px;
    line-height: 40px;
    border-radius: 50%;
    display: inline-block;
    text-align: center;
    background: #f2f2f2;
    color: #333;
    font-weight: 500;
    text-decoration: none;
    transition: 0.3s;
}

.custom-pagination li.active span {
    background: #ff6b4a; 
    color: #fff;
}

.custom-pagination li a:hover {
    background: #ff6b4a;
    color: #fff;
}

.custom-pagination li.disabled span {
    opacity: 0.5;
    cursor: not-allowed;
}
``
</style>