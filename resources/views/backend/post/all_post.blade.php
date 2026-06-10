@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-news"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Posts</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.blog.post') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                        Post</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Posts</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Post Title</th>
                                <th>Blog Category</th>
                                <th>Post Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($post as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->post_title }}</td>
                                    <td>{{ $item->blog->category_name }}</td>
                                    <td><img src="{{ asset($item->post_image) }}" alt="{{ $item->post_title }}"
                                            style="width: 50px; height: 50px;"></td>
                                    <td>
                                        <a href="{{ route('edit.testimonial', $item->id) }}"
                                            class="btn btn-warning px-3 radius-30">Edit</a>
                                        {{-- form Xóa --}}
                                        <a href="{{ route('delete.testimonial', $item->id) }}"
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