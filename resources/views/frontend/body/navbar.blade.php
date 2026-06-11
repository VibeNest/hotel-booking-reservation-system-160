<div class="navbar-area">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="/" class="logo">
            <img src="{{ asset('frontend/assets/img/logos/logo-1.png') }}" class="logo-one" alt="Logo">
            <img src="{{ asset('frontend/assets/img/logos/footer-logo1.png') }}" class="logo-two" alt="Logo">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light ">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('frontend/assets/img/logos/logo-1.png') }}" class="logo-one" alt="Logo">
                    <img src="{{ asset('frontend/assets/img/logos/footer-logo1.png') }}" class="logo-two" alt="Logo">
                </a>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="about.html" class="nav-link {{ Request::is('about.html') ? 'active' : '' }}">
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ Request::is('restaurant') ? 'active' : '' }}">
                                Restaurant
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link {{ Request::is('recreation') ? 'active' : '' }}">
                                Recreation
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('blog.list') }}"
                                class="nav-link {{ Request::is('blog') ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('room.all') }}"
                                class="nav-link {{ Request::routeIs('room.all') ? 'active' : '' }}">
                                All Rooms
                                <i class='bx bx-chevron-down'></i>
                            </a>

                            @php
                                $rooms = App\Models\Room::latest()->get();
                            @endphp

                            <ul class="dropdown-menu">
                                @foreach ($rooms as $item)
                                    <li class="nav-item">
                                        <a href="{{ route('room.details', $item->id) }}" class="nav-link">
                                            {{ $item->type->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="contact.html" class="nav-link {{ Request::is('contact.html') ? 'active' : '' }}">
                                Contact
                            </a>
                        </li>

                        <li class="nav-item-btn">
                            <a href="#" class="default-btn btn-bg-one border-radius-5">Book Now</a>
                        </li>
                    </ul>

                    <div class="nav-btn">
                        <a href="#" class="default-btn btn-bg-one border-radius-5">Book Now</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>