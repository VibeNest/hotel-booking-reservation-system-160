@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Gallery</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-images"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Gallery</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('update.gallery') }}" class="row g-3" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $gallery->id }}">

                    <div class="col-md-6">
                        <label for="multiImg" class="form-label">Gallery Image</label>
                        <input type="file" id="image" name="photo_name" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <img id="showImage" src="{{ asset($gallery->photo_name) }}" alt="Gallery Image" width="70"
                            height="70">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Save change</button>
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