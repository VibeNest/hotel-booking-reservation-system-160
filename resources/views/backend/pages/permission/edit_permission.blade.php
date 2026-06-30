@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-key"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('update.permission') }}" class="row g-3">
                    @csrf

                    <input type="hidden" name="id" value="{{ $permission->id }}">

                    <div class="col-md-6">
                        <label for="name" class="form-label">Permission Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $permission->name }}">
                    </div>

                    <div class="col-md-6">
                        <label for="group_name" class="form-label">Permission Group</label>
                        <select class="form-select mb-3" name="group_name" id="group_name"
                            aria-label="Default select example">

                            <option selected="" disabled>Select Group</option>

                            <option value="Dashboard" {{ $permission->group_name == 'Dashboard' ? 'selected' : '' }}>
                                Dashboard
                            </option>

                            <option value="Teams Management" {{ $permission->group_name == 'Teams Management' ? 'selected' : '' }}>
                                Teams Management
                            </option>

                            <option value="Customer Management" {{ $permission->group_name == 'Customer Management' ? 'selected' : '' }}>
                                Customer Management
                            </option>

                            <option value="Book Area Management" {{ $permission->group_name == 'Book Area Management' ? 'selected' : '' }}>
                                Book Area Management
                            </option>

                            <option value="Testimonial Management" {{ $permission->group_name == 'Testimonial Management' ? 'selected' : '' }}>
                                Testimonial Management
                            </option>

                            <option value="Blog" {{ $permission->group_name == 'Blog' ? 'selected' : '' }}>
                                Blog
                            </option>

                            <option value="Comment Management" {{ $permission->group_name == 'Comment Management' ? 'selected' : '' }}>
                                Comment Management
                            </option>

                            <option value="Hotel Gallery" {{ $permission->group_name == 'Hotel Gallery' ? 'selected' : '' }}>
                                Hotel Gallery
                            </option>

                            <option value="Room Type Management" {{ $permission->group_name == 'Room Type Management' ? 'selected' : '' }}>
                                Room Type Management
                            </option>

                            <option value="Add-ons Facility Management" {{ $permission->group_name == 'Add-ons Facility Management' ? 'selected' : '' }}>
                                Add-ons Facility Management
                            </option>

                            <option value="Booking" {{ $permission->group_name == 'Booking' ? 'selected' : '' }}>
                                Booking
                            </option>

                            <option value="Room List Management" {{ $permission->group_name == 'Room List Management' ? 'selected' : '' }}>
                                Room List Management
                            </option>

                            <option value="Booking Report" {{ $permission->group_name == 'Booking Report' ? 'selected' : '' }}>
                                Booking Report
                            </option>

                            <option value="Role and Permission" {{ $permission->group_name == 'Role and Permission' ? 'selected' : '' }}>
                                Role and Permission
                            </option>

                            <option value="Manage Admin" {{ $permission->group_name == 'Manage Admin' ? 'selected' : '' }}>
                                Manage Admin
                            </option>

                            <option value="Contact" {{ $permission->group_name == 'Contact' ? 'selected' : '' }}>
                                Contact
                            </option>

                            <option value="Setting" {{ $permission->group_name == 'Setting' ? 'selected' : '' }}>
                                Setting
                            </option>

                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Save change</button>
                        <a href="{{ route('all.permission') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection