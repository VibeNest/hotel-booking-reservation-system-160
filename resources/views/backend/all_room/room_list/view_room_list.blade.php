@extends("admin.admin_dashboard")

@section("admin")
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Rooms List</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-door-open"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Rooms List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.team') }}" class="btn btn-primary px-3"><i class="bx bx-plus me-1"></i>Add
                        Booking</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">All Rooms List</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Room Name</th>
                                <th>Room Number</th>
                                <th>Booking Status</th>
                                <th>Check in/out</th>
                                <th>Booking Number</th>
                                <th>Customer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($room_number_list as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->room_number }}</td>
                                    <td>
                                        @if ($item->booking_id != '')
                                            @if ($item->booking_status == 1)
                                                <span class="badge bg-success">Booked</span>
                                            @else
                                                <span class="badge bg-danger">Pending</span>
                                            @endif
                                        @else
                                            <span class="badge bg-dark">Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->booking_id != '')
                                            <span class="badge bg-primary rounded-pill">{{$item->check_in  }}</span>
                                            to
                                            <span class="badge bg-warning text-dark rounded-pill">{{$item->check_out  }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->booking_id != '')
                                            {{$item->booking_number  }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->booking_id != '')
                                            {{$item->customer_name  }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->booking_id != '')
                                            @if ($item->status == "Active")
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">InActive</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection