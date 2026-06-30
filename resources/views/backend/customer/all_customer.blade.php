@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Customers</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-user"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Customers</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    @if(Auth::user()->can('customer.create'))
                        <a href="{{ route('add.customer') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                            Customer</a>
                    @endif
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Customers</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($item->photo)
                                            <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <img src="{{ url('upload/no_image.jpeg') }}" alt="No Image"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ Str::limit($item->address, 30, '...') }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->role }}</span>
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('customer.edit'))
                                            <a href="{{ route('edit.customer', $item->id) }}"
                                                class="btn btn-warning px-3 radius-30">Edit</a>
                                        @endif

                                        @if(Auth::user()->can('customer.delete'))
                                            <a href="{{ route('delete.customer', $item->id) }}"
                                                class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
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