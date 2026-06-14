<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <a href="{{ route("admin.dashboard") }}" class="d-flex align-items-center text-decoration-none">
            <div>
                <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text">HotelHub</h4>
            </div>
        </a>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route("admin.dashboard") }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-group"></i>
                </div>
                <div class="menu-title">Teams Management</div>
            </a>
            <ul>
                <li> <a href="{{ route("all.team") }}"><i class='bx bx-radio-circle'></i>All Teams</a>
                </li>
                <li> <a href="{{ route("add.team") }}"><i class='bx bx-radio-circle'></i>Add Team</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-message-square-detail"></i>
                </div>
                <div class="menu-title">Testimonial Management</div>
            </a>
            <ul>
                <li> <a href="{{ route("all.testimonial") }}"><i class='bx bx-radio-circle'></i>All Testimonials</a>
                </li>
                <li> <a href="{{ route("add.testimonial") }}"><i class='bx bx-radio-circle'></i>Add Testimonial</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-news"></i>
                </div>
                <div class="menu-title">Blog</div>
            </a>
            <ul>
                <li> <a href="{{ route("blog.category") }}"><i class='bx bx-radio-circle'></i>Blog Category</a>
                </li>
                <li> <a href="{{ route("all.blog.post") }}"><i class='bx bx-radio-circle'></i>All Blog Posts</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-message-detail"></i>
                </div>
                <div class="menu-title">Comment Management</div>
            </a>
            <ul>
                <li> <a href="{{ route("all.comment") }}"><i class='bx bx-radio-circle'></i>All Comments</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-building-house"></i>
                </div>
                <div class="menu-title">Book Area Management</div>
            </a>
            <ul>
                <li> <a href="{{ route("all.book.area") }}"><i class='bx bx-radio-circle'></i>All book area</a>
                </li>
                <li> <a href="{{ route("add.book.area") }}"><i class='bx bx-radio-circle'></i>Add book area</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-images"></i>
                </div>
                <div class="menu-title">Hotel Gallery</div>
            </a>
            <ul>
                <li> <a href="{{ route("all.gallery") }}"><i class='bx bx-radio-circle'></i>All Gallery</a>
                </li>
                <li> <a href="{{ route("add.gallery") }}"><i class='bx bx-radio-circle'></i>Add Gallery</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-bed"></i>
                </div>
                <div class="menu-title">Room Type Management</div>
            </a>
            <ul>
                <li> <a href="{{ route("room.type.list") }}"><i class='bx bx-radio-circle'></i>List Room Types</a>
                </li>
                <li> <a href="{{ route("add.room.type") }}"><i class='bx bx-radio-circle'></i>Add Room Type</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Booking Management</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-calendar-check'></i>
                </div>
                <div class="menu-title">Booking</div>
            </a>
            <ul>
                <li> <a href="{{ route("booking.list") }}"><i class='bx bx-radio-circle'></i>Booking List</a>
                </li>
                <li> <a href="{{ route('add.room.list') }}"><i class='bx bx-radio-circle'></i>Add Booking</a>
                </li>
            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-door-open'></i>
                </div>
                <div class="menu-title">Room List Management</div>
            </a>
            <ul>
                <li> <a href="{{ route('view.room.list') }}"><i class='bx bx-radio-circle'></i>Room List</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-bar-chart-alt-2"></i>
                </div>
                <div class="menu-title">Booking Report</div>
            </a>
            <ul>
                <li> <a href="{{ route("booking.report") }}"><i class='bx bx-radio-circle'></i>Booking Report</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Configuration</li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-cog'></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
            <ul>
                <li> <a href="{{ route('smtp.setting') }}"><i class='bx bx-radio-circle'></i>SMTP Setting</a>
                </li>
                <li> <a href="{{ route('site.setting') }}"><i class='bx bx-radio-circle'></i>Site Setting</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>