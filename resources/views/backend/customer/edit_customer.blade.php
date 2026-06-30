@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Edit Customer</h4>

                    <form method="POST" action="{{ route('customer.update') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $customer->id }}">

                        <!-- Name -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" value="{{ $customer->name }}">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" value="{{ $customer->address }}">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Password <small class="text-muted">(leave blank to keep
                                    current)</small></label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>

                        <!-- Photo Upload -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Photo</label>
                            <div class="col-sm-10">
                                <input type="file" name="photo" class="form-control" id="photo">
                            </div>
                        </div>

                        <!-- Preview Image -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <img id="showImage"
                                    src="{{ (!empty($customer->photo)) ? asset($customer->photo) . '?v=' . time() : url('upload/no_image.jpg') }}"
                                    alt="Customer Photo" class="rounded-circle p-1 bg-primary" width="70" height="70">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                <a href="{{ route('all.customer') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('photo').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('showImage').src = URL.createObjectURL(file);
            }
        });
    </script>

@endsection