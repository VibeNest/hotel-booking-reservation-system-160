@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Admin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-group"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Admin</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    @if(Auth::user()->can('admin.create'))
                        <a href="{{ route('add.admin') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                            Admin</a>
                    @endif
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Admin</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_admin as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ (!empty($item->photo)) ? url("upload/admin_images/{$item->photo}") : url("upload/no_image.jpeg")}}"
                                            alt="Admin Avatar" width="50" height="50"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>
                                        @foreach ($item->roles as $role)
                                            <span class="badge badge-pill bg-danger">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('admin.edit'))
                                            <a href="{{ route('edit.admin', $item->id) }}"
                                                class="btn btn-warning px-3 radius-30">Edit</a>
                                        @endif
                                        @if(Auth::user()->can('admin.delete'))
                                            {{-- form Xóa --}}
                                            <a href="{{ route('delete.admin', $item->id) }}" class="btn btn-danger px-3 radius-30"
                                                id="delete">Delete</a>
                                        @endif
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