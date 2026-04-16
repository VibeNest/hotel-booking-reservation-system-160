@php
    $book_area = App\Models\BookArea::find(1);
@endphp

<div class="book-area-two pt-100 pb-70">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="book-content-two">
                    <div class="section-title">
                        <span class="sp-color">{{ $book_area->sub_title }}</span>
                        <h2>{{ $book_area->sub_title }}</h2>
                        <p>
                            {{ $book_area->description }}
                        </p>
                    </div>
                    <a href="{{ $book_area->link_url }}" class="default-btn btn-bg-three">Booking</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="book-img-2">
                    <img src="{{ $book_area->image }}" alt="Images">
                </div>
            </div>
        </div>
    </div>
</div>