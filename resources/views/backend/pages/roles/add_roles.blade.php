@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Role</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-user-pin"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Role</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('store.roles') }}" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="name" class="form-label">Roles Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Save change</button>
                        <a href="{{ route('all.roles') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection