@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-key"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('store.permission') }}" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="name" class="form-label">Permission Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="group_name" class="form-label">Permission Group</label>
                        <select class="form-select mb-3" name="group_name" id="group_name"
                            aria-label="Default select example">
                            <option selected="" disabled>Select Group</option>
                            <option value="Dashboard">Dashboard</option>
                            <option value="Teams Management">Teams Management</option>
                            <option value="Book Area Management">Book Area Management</option>
                            <option value="Testimonial Management">Testimonial Management</option>
                            <option value="Blog">Blog</option>
                            <option value="Comment Management">Comment Management</option>
                            <option value="Hotel Gallery">Hotel Gallery</option>
                            <option value="Room Type Management">Room Type Management</option>
                            <option value="Add-ons Facility Management">Add-ons Facility Management</option>
                            <option value="Booking">Booking</option>
                            <option value="Room List Management">Room List Management</option>
                            <option value="Booking Report">Booking Report</option>
                            <option value="Role and Permission">Role and Permission</option>
                            <option value="Manage Admin">Manage Admin</option>
                            <option value="Contact">Contact</option>
                            <option value="Setting">Setting</option>
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