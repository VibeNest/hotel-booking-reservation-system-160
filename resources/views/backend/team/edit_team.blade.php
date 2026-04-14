@extends('admin.admin_dashboard')

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Edit Team</h4>

                <form method="POST" action="{{ route('team.update') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $team->id }}">

                    <!-- Name -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" value="{{ $team->name }}">
                        </div>
                    </div>

                    <!-- Position -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-10">
                            <input type="text" name="position" class="form-control" value="{{ $team->position }}">
                        </div>
                    </div>

                    <!-- Facebook -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-10">
                            <input type="text" name="facebook" class="form-control" value="{{ $team->facebook }}">
                        </div>
                    </div>

                    <!-- Tiktok -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Tiktok</label>
                        <div class="col-sm-10">
                            <input type="text" name="tiktok" class="form-control" value="{{ $team->tiktok }}">
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Instagram</label>
                        <div class="col-sm-10">
                            <input type="text" name="instagram" class="form-control" value="{{ $team->instagram }}">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                    </div>

                    <!-- Preview Image -->
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <img id="showImage" 
                                 src="{{ (!empty($team->image)) ? asset($team->image).'?v='.time() : url('upload/no_image.jpg') }}"
                                 alt="Team Image" 
                                 class="rounded-circle" 
                                 width="110">
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="row">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('showImage').src = URL.createObjectURL(file);
        }
    });
</script>

@endsection