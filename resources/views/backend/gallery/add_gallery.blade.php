@extends("admin.admin_dashboard")

@section("admin")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Gallery</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-images"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Gallery</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('store.gallery') }}" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-6">
                    <label for="multiImg" class="form-label">Gallery Image</label>
                    <input type="file" id="multiImg" name="photo_name[]" class="form-control" multiple>

                    <div class="row" id="preview_img" style="margin-top: 10px;"></div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4">Save change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------===Show MultiImage ========------->
<script>
    $(document).ready(function () {
        $('#multiImg').on('change', function () { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $.each(data, function (index, file) { //loop though each file
                    if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function (file) { //trigger function on successful read
                            return function (e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(70)
                                    .height(50); //create image element 
                                $('#preview_img').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            } else {
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });
    });
</script>
@endsection