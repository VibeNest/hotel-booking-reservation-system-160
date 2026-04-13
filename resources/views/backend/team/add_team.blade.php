@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Team</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('all.team') }}"><i class="bx bx-group"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Team</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Create Team Member</h5>

                <form method="POST" action="{{ route('store.team') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" id="position" name="position"
                            class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
                        @error('position')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="facebook" class="form-label">Facebook URL</label>
                        <input type="url" id="facebook" name="facebook"
                            class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook') }}">
                        @error('facebook')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="tiktok" class="form-label">Tiktok URL</label>
                        <input type="url" id="tiktok" name="tiktok"
                            class="form-control @error('tiktok') is-invalid @enderror" value="{{ old('tiktok') }}">
                        @error('tiktok')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="instagram" class="form-label">Instagram URL</label>
                        <input type="url" id="instagram" name="instagram"
                            class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram') }}">
                        @error('instagram')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" name="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Save Team</button>
                        <a href="{{ route('all.team') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
