@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">List Room Types</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-bed"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">List Room Types</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.room.type') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                        Room Type</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">List Room Types</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $key => $item)

                                @php
                                    // Lấy tất cả các phòng thuộc đúng loại phòng hiện tại 
                                    $rooms = App\Models\Room::where('roomtype_id', $item->id)->get();
                                @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ (!empty($item->room->image)) ? url('upload/room_images/' . $item->room->image) : url('upload/no_image.jpg') }}"
                                            alt="{{ $item->name }}" width="50"></td>
                                    <td>{{ $item->name }}</td>

                                    @foreach ($rooms as $room)
                                        <td>
                                            <a href="{{ route('edit.room', $room->id) }}"
                                                class="btn btn-warning px-3 radius-30">Edit</a>
                                            <a href="" class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
                                        </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection