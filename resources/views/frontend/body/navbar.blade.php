@php
    $setting = App\Models\SiteSetting::find(1);
@endphp

<div class="navbar-area">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="/" class="logo">
            <img src="{{ asset($setting->logo) }}" class="logo-one" alt="Logo Image">
            <img src="{{ asset($setting->logo) }}" class="logo-two" alt="Logo Image">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light ">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset($setting->logo) }}" class="logo-one" alt="Logo Image">
                    <img src="{{ asset($setting->logo) }}" class="logo-two" alt="Logo Image">
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
                            <a href="{{ route('show.gallery') }}"
                                class="nav-link {{ Request::is('gallery') ? 'active' : '' }}">
                                Gallery
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
                            <a href="{{ route('contact.us') }}"
                                class="nav-link {{ Request::is('contact') ? 'active' : '' }}">
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