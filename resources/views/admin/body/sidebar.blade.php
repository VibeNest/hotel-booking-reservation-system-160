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
        @if(Auth::user()->can('dashboard.view'))
            <li>
                <a href="{{ route("admin.dashboard") }}">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
        @endif

        @if(Auth::user()->can('team.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-group"></i>
                    </div>
                    <div class="menu-title">Teams Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('team.view'))
                        <li> <a href="{{ route("all.team") }}"><i class='bx bx-radio-circle'></i>All Teams</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('team.create'))
                        <li> <a href="{{ route("add.team") }}"><i class='bx bx-radio-circle'></i>Add Team</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('testimonial.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-message-square-detail"></i>
                    </div>
                    <div class="menu-title">Testimonial Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('testimonial.view'))
                        <li> <a href="{{ route("all.testimonial") }}"><i class='bx bx-radio-circle'></i>All Testimonials</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('testimonial.create'))
                        <li> <a href="{{ route("add.testimonial") }}"><i class='bx bx-radio-circle'></i>Add Testimonial</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('blog.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-news"></i>
                    </div>
                    <div class="menu-title">Blog</div>
                </a>
                <ul>
                    @if(Auth::user()->can('blog.category.view'))
                        <li> <a href="{{ route("blog.category") }}"><i class='bx bx-radio-circle'></i>Blog Category</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('blog.post.view'))
                        <li> <a href="{{ route("all.blog.post") }}"><i class='bx bx-radio-circle'></i>All Blog Posts</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('comment.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-message-detail"></i>
                    </div>
                    <div class="menu-title">Comment Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('comment.view'))
                        <li> <a href="{{ route("all.comment") }}"><i class='bx bx-radio-circle'></i>All Comments</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('book.area.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-building-house"></i>
                    </div>
                    <div class="menu-title">Book Area Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('book.area.view'))
                        <li> <a href="{{ route("all.book.area") }}"><i class='bx bx-radio-circle'></i>All book area</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('book.area.create'))
                        <li> <a href="{{ route("add.book.area") }}"><i class='bx bx-radio-circle'></i>Add book area</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('gallery.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-images"></i>
                    </div>
                    <div class="menu-title">Hotel Gallery</div>
                </a>
                <ul>
                    @if(Auth::user()->can('gallery.view'))
                        <li> <a href="{{ route("all.gallery") }}"><i class='bx bx-radio-circle'></i>All Gallery</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('gallery.create'))
                        <li> <a href="{{ route("add.gallery") }}"><i class='bx bx-radio-circle'></i>Add Gallery</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('room.type.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-bed"></i>
                    </div>
                    <div class="menu-title">Room Type Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('room.type.view'))
                        <li> <a href="{{ route("room.type.list") }}"><i class='bx bx-radio-circle'></i>List Room Types</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('room.type.create'))
                        <li> <a href="{{ route("add.room.type") }}"><i class='bx bx-radio-circle'></i>Add Room Type</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('addon.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-plus-circle"></i></div>
                    <div class="menu-title">Add-ons Facility Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('addon.view'))
                        <li><a href="{{ route('all.addons') }}"><i class='bx bx-radio-circle'></i>All Add-ons</a></li>
                    @endif
                    @if(Auth::user()->can('addon.create'))
                        <li><a href="{{ route('add.addon') }}"><i class='bx bx-radio-circle'></i>Add Add-on</a></li>
                    @endif
                </ul>
            </li>
        @endif

        <li class="menu-label">Booking Management</li>

        @if(Auth::user()->can('booking.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-calendar-check'></i>
                    </div>
                    <div class="menu-title">Booking</div>
                </a>
                <ul>
                    @if(Auth::user()->can('booking.view'))
                        <li> <a href="{{ route("booking.list") }}"><i class='bx bx-radio-circle'></i>Booking List</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('booking.create'))
                        <li> <a href="{{ route('add.room.list') }}"><i class='bx bx-radio-circle'></i>Add Booking</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('room.list.menu'))
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-door-open'></i>
                    </div>
                    <div class="menu-title">Room List Management</div>
                </a>
                <ul>
                    @if(Auth::user()->can('room.list.view'))
                        <li> <a href="{{ route('view.room.list') }}"><i class='bx bx-radio-circle'></i>Room List</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('booking.report.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-bar-chart-alt-2"></i>
                    </div>
                    <div class="menu-title">Booking Report</div>
                </a>
                <ul>
                    @if(Auth::user()->can('booking.report.view'))
                        <li> <a href="{{ route("booking.report") }}"><i class='bx bx-radio-circle'></i>Booking Report</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <li class="menu-label">Role & Permission</li>

        @if(Auth::user()->can('permission.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-shield-quarter"></i>
                    </div>
                    <div class="menu-title">Role & Permission</div>
                </a>
                <ul>
                    @if(Auth::user()->can('permission.view'))
                        <li> <a href="{{ route("all.permission") }}"><i class='bx bx-radio-circle'></i>All Permission</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('role.view'))
                        <li> <a href="{{ route("all.roles") }}"><i class='bx bx-radio-circle'></i>All Roles</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('role.assign'))
                        <li> <a href="{{ route("all.roles.permission") }}"><i class='bx bx-radio-circle'></i>All Roles In
                                Permission</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('admin.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-group"></i>
                    </div>
                    <div class="menu-title">Manage Admin</div>
                </a>
                <ul>
                    @if(Auth::user()->can('admin.view'))
                        <li> <a href="{{ route("all.admin") }}"><i class='bx bx-radio-circle'></i>All Admin</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('admin.create'))
                        <li> <a href="{{ route("add.admin") }}"><i class='bx bx-radio-circle'></i>Add Admin</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <li class="menu-label">Other</li>

        @if(Auth::user()->can('contact.message.menu'))
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-phone'></i>
                    </div>
                    <div class="menu-title">Contact</div>
                </a>
                <ul>
                    @if(Auth::user()->can('contact.message.view'))
                        <li> <a href="{{ route('contact.message') }}"><i class='bx bx-radio-circle'></i>Contact Message</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if(Auth::user()->can('setting.menu'))
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-cog'></i>
                    </div>
                    <div class="menu-title">Setting</div>
                </a>
                <ul>
                    @if(Auth::user()->can('smtp.setting.view'))
                        <li> <a href="{{ route('smtp.setting') }}"><i class='bx bx-radio-circle'></i>SMTP Setting</a>
                        </li>
                    @endif
                    @if(Auth::user()->can('site.setting.view'))
                        <li> <a href="{{ route('site.setting') }}"><i class='bx bx-radio-circle'></i>Site Setting</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
    <!--end navigation-->
</div>