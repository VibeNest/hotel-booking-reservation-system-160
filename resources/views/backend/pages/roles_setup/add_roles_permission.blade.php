@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Role In Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-user-plus"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Role In Permission</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('store.roles') }}" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="role_id" class="form-label">Roles Name</label>
                        <select name="role_id" id="role_id" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>Select Role</option>

                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">All Permissions</label>
                    </div>

                    <hr>

                    @foreach ($permission_groups as $group)
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">{{ $group->group_name }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Save change</button>
                        <a href="{{ route('all.roles') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection