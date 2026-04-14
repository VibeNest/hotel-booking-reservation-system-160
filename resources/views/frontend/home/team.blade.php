<div class="team-area-three pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">TEAM</span>
            <h2>Let's Meet Up With Our Special Team Members</h2>
        </div>

        <div class="team-slider-two owl-carousel owl-theme pt-45">

            @foreach($team as $item)
            <div class="team-item">

                <!-- IMAGE -->
                <a href="#">
                    <img src="{{ !empty($item->image) 
                        ? asset($item->image) 
                        : asset('frontend/assets/img/team/team-img1.jpg') }}" 
                        alt="Images">
                </a>

                <div class="content">

                    <!-- NAME -->
                    <h3>{{ $item->name }}</h3>

                    <!-- POSITION -->
                    <span>{{ $item->position }}</span>

                    <!-- SOCIAL -->
                    <ul class="social-link">

                        <!-- FACEBOOK -->
                        <li>
                            <a href="{{ $item->facebook ? 'https://'.$item->facebook : '#' }}" target="_blank">
                                <i class='bx bxl-facebook'></i>
                            </a>
                        </li>

                        <!-- TIKTOK -->
                        <li>
                            <a href="{{ $item->tiktok ? 'https://'.$item->tiktok : '#' }}" target="_blank">
                                <i class='bx bxl-tiktok'></i>
                            </a>
                        </li>

                        <!-- INSTAGRAM -->
                        <li>
                            <a href="{{ $item->instagram ? 'https://'.$item->instagram : '#' }}" target="_blank">
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
