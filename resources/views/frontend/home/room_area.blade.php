<div class="room-area pt-100 pb-70 section-bg" style="background-color:#ffffff">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">ROOMS</span>
            <h2>Our Rooms & Rates</h2>
        </div>

        @php
           
            $rooms = App\Models\Room::with('type')->latest()->get();
        @endphp

        <div class="row pt-45">
            @foreach($rooms as $index => $room)
            <div class="col-lg-6 {{ $index >= 4 ? 'd-none extra-room' : '' }}">
                <div class="room-card-two">
                    <div class="row align-items-center">

                        {{-- IMAGE --}}
                        <div class="col-lg-5 col-md-4 p-0">
                            <div class="room-card-img">
                                <a href="#">
                                    <img src="{{ asset('upload/room_images/'.$room->image) }}" alt="Images">
                                </a>
                            </div>
                        </div>

                        {{-- CONTENT --}}
                        <div class="col-lg-7 col-md-8 p-0">
                            <div class="room-card-content">

                                <h3>
                                    <a href="{{ route('room.details', $room->id) }}">
                                       {{ $room->type->name ?? '' }}
                                    </a>
                                </h3>

                                <span>{{ $room->price ?? 0 }} / Per Night </span>

                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                </div>

                           
                                <div class="room-desc">
                                    {!! html_entity_decode($room->description ?? '') !!}
                                </div>

                                <ul>
                                    <li><i class='bx bx-user'></i>
                                    {{ ($room->total_adult ?? 0) + ($room->total_child ?? 0) }} Person
                                    <li><i class='bx bx-expand'></i> {{ $room->size ?? 0 }} m2</li>
                                </ul>

                                <ul>
                                    <li><i class='bx bx-show-alt'></i> {{ $room->view ?? '' }}</li>
                                    <li><i class='bx bxs-hotel'></i> {{ $room->bed_style ?? '' }}</li>
                                </ul>

                                <a href="#" class="book-more-btn">
                                    Book Now
                                </a>

                            </div>
                            </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- VIEW ALL --}}
        @if(count($rooms) > 4)
        <div class="text-center mt-4">
            <button id="toggleBtn" class="default-btn">View All Rooms</button>
        </div>
        @endif

    </div>
</div>

{{-- JS --}}
<script>
    let expanded = false;

    document.getElementById('toggleBtn')?.addEventListener('click', function () {
        const extraRooms = document.querySelectorAll('.extra-room');

        expanded = !expanded;

        extraRooms.forEach(room => {
            room.classList.toggle('d-none');
        });

        this.innerText = expanded ? 'Hide Rooms' : 'View All Rooms';
    });
</script>

{{-- INLINE CSS --}}
<style>
.room-desc {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;

  line-height: 1.6;
  min-height: 6.4em;
}
</style>