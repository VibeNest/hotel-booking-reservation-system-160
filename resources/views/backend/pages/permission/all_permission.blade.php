@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-key"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Permission</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    @if(Auth::user()->can('permission.create'))
                        <a href="{{ route('add.permission') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                            Permission</a>
                    @endif
                </div>
                <div class="btn-group">
                    @if(Auth::user()->can('permission.import'))
                        <a href="{{ route('import.permission') }}" class="btn btn-warning px-3"><i
                                class="bx bx-import me-1"></i>
                            Import</a>
                    @endif
                </div>
                <div class="btn-group">
                    @if(Auth::user()->can('permission.export'))
                        <a href="{{ route('export.permission') }}" class="btn btn-success px-3"><i
                                class="bx bx-export me-1"></i>
                            Export</a>
                    @endif
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Permission</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Permission Name</th>
                                <th>Permission Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->group_name }}</td>
                                    <td>
                                        @if(Auth::user()->can('permission.edit'))
                                            <a href="{{ route('edit.permission', $item->id) }}"
                                                class="btn btn-warning px-3 radius-30">Edit</a>
                                        @endif
                                        @if(Auth::user()->can('permission.delete'))
                                            {{-- form Xóa --}}
                                            <a href="{{ route('delete.permission', $item->id) }}"
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