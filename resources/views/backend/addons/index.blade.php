@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add-ons</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="bx bx-plus-circle"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Add-ons</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-header">
                    @if(Auth::user()->can('addon.create'))
                        <a href="{{ route('add.addon') }}" class="btn btn-primary">+ Add New Add-on</a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addons as $addon)
                                <tr>
                                    <td>{{ $addon->name }}</td>
                                    <td>${{ number_format($addon->price, 0) }}</td>
                                    <td>{{ $addon->description }}</td>
                                    <td>
                                        @if(Auth::user()->can('addon.edit'))
                                            <a href="{{ route('edit.addon', $addon->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                        @if(Auth::user()->can('addon.delete'))
                                            <a href="{{ route('delete.addon', $addon->id) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this add-on?')">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if($addons->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No add-ons found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection