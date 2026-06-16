@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Gallery</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-images"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Gallery</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.gallery') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                        Gallery</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Gallery</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <form action="{{ route('delete.gallery.multiple') }}" method="POST">
                        @csrf

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="50px">Select</th>
                                    <th width="50px">Sl</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gallery as $key => $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selectedItem[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->photo_name) }}" alt="Gallery Image"
                                                style="width:50px;height:50px;">
                                        </td>
                                        <td>
                                            <a href="{{ route('edit.gallery', $item->id) }}"
                                                class="btn btn-warning px-3 radius-30">Edit</a>

                                            <a href="{{ route('delete.gallery', $item->id) }}"
                                                class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Action Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                            <div>
                                <span class="text-muted">
                                    Select one or more gallery items to delete.
                                </span>
                            </div>

                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bx bx-trash me-1"></i>
                                Delete Selected
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection