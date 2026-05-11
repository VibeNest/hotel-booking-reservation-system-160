@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-body">

                    <h4>Edit Room Number</h4>

                    <form method="POST" action="{{ route('update.roomnumber', $editData->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" name="room_number" value="{{ $editData->room_number }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $editData->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $editData->status == 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Update
                        </button>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            Back
                        </a>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection