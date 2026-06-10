@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Post</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('all.blog.post') }}"><i
                                    class="bx bx-message-square-detail"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Post</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Create Post</h5>

                <form method="POST" action="{{ route('store.blog.post') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="blog_cat_id" class="form-label">Blog Category</label>
                        <select id="blog_cat_id" name="blog_cat_id" class="form-select">
                            <option selected="">Select Category</option>
                            @foreach ($blog_cat as $cat)
                                <option value="{{ $cat->id }}">{{$cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="post_title" class="form-label">Post Title</label>
                        <input type="text" id="post_title" name="post_title"
                            class="form-control @error('post_title') is-invalid @enderror" value="{{ old('post_title') }}">
                        @error('post_title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="short_desc" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_desc') is-invalid @enderror"
                            value="{{ old('short_desc') }}" id="short_desc" name="short_desc" rows="3"></textarea>
                        @error('short_desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="long_desc" class="form-label">Description</label>
                        <textarea class="form-control @error('long_desc') is-invalid @enderror"
                            value="{{ old('long_desc') }}" id="myeditorinstance" name="long_desc" rows="3"></textarea>
                        @error('long_desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Post Image</label>
                        <input type="file" id="image" name="post_image"
                            class="form-control @error('post_image') is-invalid @enderror" accept="image/*">
                        @error('post_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="col-sm-3">
                            <h6 class="mb-0"></h6>
                        </div>
                        <div class="col-sm-9 text-secondary form-group">
                            <img id="showImage" src="{{  url("upload/no_image.jpeg")}}" alt="Admin"
                                class="rounded-circle p-1 bg-primary" width="70" height="70">
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Save Change</button>
                        <a href="{{ route('all.blog.post') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Xem trước ảnh ngay khi chọn file --}}
    <script type="text/javascript">
        // Đảm bảo code HTML chạy xong
        $(document).ready(function () {
            // Khi user chọn file thì code bên trong chạy (Lắng nghe sự kiện change)
            $('#image').change(function (e) {
                // Đọc file khi đã chọn file xong
                var reader = new FileReader();
                // Khi đọc file xong thì sẽ chạy hàm này (onload)
                reader.onload = function (e) {
                    // Gán ảnh vửa mới đọc từ reader và hiển thị ngay lập tức
                    $('#showImage').attr('src', e.target.result); // e.target.result là dữ liệu ảnh dạng base64
                }
                // Đọc file từ input (readAsDataURL: chuyển file thành data url)
                reader.readAsDataURL(e.target.files['0']); // e.target.files['0']: file đầu tiên user chọn
            })
        })
    </script>
@endsection