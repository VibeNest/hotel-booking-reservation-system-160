@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Update Site Setting</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-wrench"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update Site Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <form action="{{ route("site.update") }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $site->id }}">

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $site->phone}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $site->email}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="address" class="form-control"
                                                value="{{ $site->address}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Facebook</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="facebook" class="form-control"
                                                value="{{ $site->facebook}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Tiktok</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="tiktok" class="form-control"
                                                value="{{ $site->tiktok}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Instagram</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="instagram" class="form-control"
                                                value="{{ $site->instagram}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Copyright</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="copyright" class="form-control"
                                                value="{{ $site->copyright}}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Logo</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" id="image" name="logo" class="form-control" accept="image/*">
                                            <img id="showImage" src="{{ asset($site->logo) }}" alt="Logo Image" width="70"
                                                height="70" style="margin-top: 15px;">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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