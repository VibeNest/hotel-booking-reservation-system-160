@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Testimonial</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('all.team') }}"><i
                                    class="bx bx-message-square-detail"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Testimonial</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Create Testimonial</h5>

                <form method="POST" action="{{ route('testimonial.store') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="city" class="form-label">City</label>
                        <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror"
                            value="{{ old('city') }}">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" value="{{ old('message') }}"
                            id="message" name="message" rows="3"></textarea>
                        @error('message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                            accept="image/*">
                        @error('image')
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
                        <a href="{{ route('all.testimonial') }}" class="btn btn-secondary">Back</a>
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