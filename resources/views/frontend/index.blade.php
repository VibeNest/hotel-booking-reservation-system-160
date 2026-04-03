@extends('frontend.home_page')

@section('home')
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