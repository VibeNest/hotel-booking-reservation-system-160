@php
    $teams = App\Models\Team::latest()->get();
@endphp

<div class="team-area-three pt-100 pb-70">
    <div class="container">

        <div class="section-title text-center">
            <span class="sp-color">TEAM</span>
            <h2>Let's Meet Up With Our Special Team Members</h2>
        </div>

        <div class="team-slider-two owl-carousel owl-theme pt-45">

            @foreach($teams as $item)
                <div class="team-item">

                    <a href="#">
                        <img src="{{ asset($item->image) }}" alt={{ $item->name }}>
                    </a>

                    <div class="content">

                        <h3>{{ $item->name }}</h3>

                        <span>{{ $item->position }}</span>

                        <ul class="social-link">

                            <li>
                                <a href="{{ $item->facebook  }}" target="_blank">
                                    <i class='bx bxl-facebook'></i>
                                </a>
                            </li>

                            <li>
                                <a href="{{ $item->tiktok }}" target="_blank">
                                    <i class='bx bxl-tiktok'></i>
                                </a>
                            </li>

                            <li>
                                <a href="{{ $item->instagram }}" target="_blank">
                                    <i class='bx bxl-instagram'></i>
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>