@extends('frontend.home_page')

@section('home')
    <!-- Banner Area -->
    <div class="banner-area" style="height: 480px;">
        <div class="container">
            <div class="banner-content">
                <h1>Discover a Hotel & Resort to Book a Suitable Room</h1>


            </div>
        </div>
    </div>
    <!-- Banner Area End -->

    <!-- Banner Form Area -->
    <div class="banner-form-area">
        <div class="container">
            <div class="banner-form">

                <form method="get" action="{{ route('booking.search') }}">
                    <div class="row align-items-center">

                        <!-- CHECK IN -->
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label>CHECK IN TIME</label>
                                <div class="input-group">
                                    <input id="startdate1" autocomplete="off" name="check_in" type="text" required
                                        class="form-control">
                                    <span class="input-group-addon"></span>
                                </div>
                                <i class='bx bxs-chevron-down'></i>
                            </div>
                        </div>

                        <!-- CHECK OUT -->
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label>CHECK OUT TIME</label>
                                <div class="input-group">
                                    <input id="enddate1" autocomplete="off" name="check_out" type="text" required
                                        class="form-control">
                                    <span class="input-group-addon"></span>
                                </div>
                                <i class='bx bxs-chevron-down'></i>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <label>GUESTS</label>

                                <select name="person" class="form-control">

                                    @for ($i = 1; $i <= 5; $i++)

                                        <option value="{{ 0 . $i }}">
                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                        </option>

                                    @endfor

                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <button type="submit" class="default-btn btn-bg-one border-radius-5">
                                Search Now
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Banner Form Area End -->

    <!-- Room Area -->
    @include('frontend.home.room_area')
    <!-- Room Area End -->

    <!-- Book Area Two-->
    @include('frontend.home.book_area')
    <!-- Book Area Two End -->

    <!-- Services Area Three -->
    @include('frontend.home.services')
    <!-- Services Area Three End -->

    <!-- Team Area Three -->
    @include('frontend.home.team')
    <!-- Team Area Three End -->

    <!-- Testimonials Area Three -->
    @include('frontend.home.testimonials')
    <!-- Testimonials Area Three End -->

    <!-- FAQ Area -->
    @include('frontend.home.faq')
    <!-- FAQ Area End -->

    <!-- Blog Area -->
    @include('frontend.home.blog')
    <!-- Blog Area End -->
@endsection