@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Book Area</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-building-house"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Book Area</li>
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
                            <form action="{{ route("book_area.update") }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $bookArea->id }}">

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sub title</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="sub_title" class="form-control"
                                                value="{{ $bookArea->sub_title }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Title</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="title" class="form-control"
                                                value="{{ $bookArea->title }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Description</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea name="description" class="form-control"
                                                placeholder="Enter Description"
                                                rows="4">{{ $bookArea->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Link</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="link_url" class="form-control"
                                                placeholder="Enter Link URL" value="{{ $bookArea->link_url }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Image</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input class="form-control" type="file" id="image" name="image">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{  asset($bookArea->image)}}" alt="Admin"
                                                class="rounded-circle p-1 bg-primary" width="80">
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