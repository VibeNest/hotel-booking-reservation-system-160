@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Role Permissions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-shield-quarter"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Role Permissions</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.roles.permission') }}" class="btn btn-primary px-3"><i
                            class="bx bx-plus me-1"></i>Add
                        Roles In Permissions</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Roles Permissions</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Roles Name</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($item->permissions as $permission)
                                                <span class="badge bg-danger fs-7 px-2 py-1">{{ $permission->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.roles.permission', $item->id) }}"
                                            class="btn btn-warning px-3 radius-30">Edit</a>
                                        {{-- form Xóa --}}
                                        <a href="{{ route('delete.roles.permission', $item->id) }}"
                                            class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection