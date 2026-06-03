@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Room List</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-door-open"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Room List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body p-4">

                                {{-- <form class="row g-3" id="myForm" method="POST"
                                    action="{{ route('store.room.list') }}">
                                    @csrf

                                    <div class="col-md-4">
                                        <label for="room_type_id" class="form-label">Room Types</label>
                                        <select id="room_type_id" class="form-select" name="rooms_id">
                                            <option selected="">Select Room Type</option>
                                            @foreach ($room_types as $item)
                                            <option value="{{ $item->room->id }}" {{ collect(old('room_type_id'))->
                                                contains($item->id) ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="check_in" class="form-label">Check in</label>
                                        <input type="date" class="form-control" id="check_in" name="check_in">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="check_out" class="form-label">Check out</label>
                                        <input type="date" class="form-control" id="check_out" name="check_out">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="number_of_rooms" class="form-label">Rooms</label>
                                        <input type="number" name="number_of_rooms" id="number_of_rooms"
                                            class="form-control">

                                        <input type="hidden" name="available_room" id="available_room" class="form-control">

                                        <div class="mt-2">
                                            <label for="">Availability: <span
                                                    class="text-success availability"></span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="person" class="form-label">Guests</label>
                                        <input type="text" name="person" class="form-control" id="person">
                                    </div>

                                    <h3 class="mt-3 mb-5 text-center text-danger">Customer Information</h3>

                                    <div class="col-md-4 form-group">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            value="{{ old('email') }}">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            value="{{ old('phone') }}">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" class="form-control" id="country"
                                            value="{{ old('country') }}">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" name="state" class="form-control" id="state"
                                            value="{{ old('state') }}">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="zip_code" class="form-label">Zip Code</label>
                                        <input type="text" name="zip_code" class="form-control" id="zip_code"
                                            value="{{ old('zip_code') }}">
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        </div>
                                    </div>
                                </form> --}}

                                <style>
                                    .booking-wrapper {
                                        padding: 1.5rem 0;
                                    }

                                    .page-title {
                                        font-size: 1.5rem;
                                        font-weight: 600;
                                        color: #1a1a2e;
                                        margin-bottom: 0.25rem;
                                    }

                                    .page-subtitle {
                                        font-size: 0.9rem;
                                        color: #6c757d;
                                        margin-bottom: 1.5rem;
                                    }

                                    .section-card {
                                        background: #ffffff;
                                        border: 1px solid #e9ecef;
                                        border-radius: 12px;
                                        padding: 1.75rem;
                                        margin-bottom: 1.25rem;
                                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
                                    }

                                    .section-header {
                                        display: flex;
                                        align-items: center;
                                        gap: 12px;
                                        margin-bottom: 1.5rem;
                                        padding-bottom: 1rem;
                                        border-bottom: 1px solid #f0f0f0;
                                    }

                                    .section-icon {
                                        width: 38px;
                                        height: 38px;
                                        border-radius: 10px;
                                        background: #e8f4fd;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: #0d6efd;
                                        font-size: 1.1rem;
                                        flex-shrink: 0;
                                    }

                                    .section-title {
                                        font-size: 0.95rem;
                                        font-weight: 600;
                                        margin: 0;
                                        color: #1a1a2e;
                                    }

                                    .section-subtitle {
                                        font-size: 0.78rem;
                                        color: #6c757d;
                                        margin: 2px 0 0;
                                    }

                                    .form-label {
                                        font-size: 0.72rem;
                                        font-weight: 600;
                                        text-transform: uppercase;
                                        letter-spacing: 0.05em;
                                        color: #6c757d;
                                        margin-bottom: 6px;
                                    }

                                    .form-control,
                                    .form-select {
                                        height: 42px;
                                        padding: 0 14px;
                                        font-size: 0.875rem;
                                        border: 1px solid #dee2e6;
                                        border-radius: 8px;
                                        background-color: #f8f9fa;
                                        color: #1a1a2e;
                                        transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
                                    }

                                    .form-control:focus,
                                    .form-select:focus {
                                        border-color: #0d6efd;
                                        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
                                        background-color: #ffffff;
                                        outline: none;
                                    }

                                    .form-control::placeholder {
                                        color: #adb5bd;
                                        font-size: 0.85rem;
                                    }

                                    textarea.form-control {
                                        height: auto;
                                        padding: 10px 14px;
                                    }

                                    .availability-badge {
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 5px;
                                        padding: 3px 10px;
                                        border-radius: 20px;
                                        font-size: 0.75rem;
                                        font-weight: 500;
                                        background: #d1fae5;
                                        color: #065f46;
                                        margin-top: 6px;
                                    }

                                    .btn-submit {
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                        padding: 0 28px;
                                        height: 46px;
                                        background: #0d6efd;
                                        color: #ffffff;
                                        border: none;
                                        border-radius: 8px;
                                        font-size: 0.9rem;
                                        font-weight: 500;
                                        cursor: pointer;
                                        transition: background-color 0.15s ease, transform 0.1s ease;
                                        text-decoration: none;
                                    }

                                    .btn-submit:hover {
                                        background: #0b5ed7;
                                        color: #ffffff;
                                    }

                                    .btn-submit:active {
                                        transform: scale(0.98);
                                    }
                                </style>

                                <div class="booking-wrapper">
                                    <h2 class="page-title">Book a Room</h2>
                                    <p class="page-subtitle">Fill in the details below to complete your reservation</p>

                                    <form id="myForm" method="POST" action="{{ route('store.room.list') }}">
                                        @csrf

                                        {{-- Reservation Details --}}
                                        <div class="section-card">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                                <div>
                                                    <p class="section-title">Reservation details</p>
                                                    <p class="section-subtitle">Choose your room type and dates</p>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="room_type_id" class="form-label">Room type</label>
                                                        <select id="room_type_id" class="form-select" name="rooms_id">
                                                            <option value="" selected>Select room type</option>
                                                            @foreach ($room_types as $item)
                                                                <option value="{{ $item->room->id }}" {{ collect(old('room_type_id'))->contains($item->id) ? 'selected' : '' }}>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="check_in" class="form-label">Check-in</label>
                                                        <input type="date" class="form-control" id="check_in"
                                                            name="check_in">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="check_out" class="form-label">Check-out</label>
                                                        <input type="date" class="form-control" id="check_out"
                                                            name="check_out">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="number_of_rooms" class="form-label">Number of
                                                            rooms</label>
                                                        <input type="number" name="number_of_rooms" id="number_of_rooms"
                                                            class="form-control" min="1" placeholder="e.g. 2">
                                                        <input type="hidden" name="available_room" id="available_room">
                                                        <div class="mt-1">
                                                            <span class="availability-badge">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="13"
                                                                    height="13" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                                </svg>
                                                                <span>Available: <span class="availability"></span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="person" class="form-label">Guests</label>
                                                        <input type="text" name="person" class="form-control" id="person"
                                                            placeholder="e.g. 3">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Customer Information --}}
                                        <div class="section-card">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="bx bx-user-circle"></i>
                                                </div>
                                                <div>
                                                    <p class="section-title">Customer information</p>
                                                    <p class="section-subtitle">Personal and contact details</p>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Full name</label>
                                                        <input type="text" name="name" class="form-control" id="name"
                                                            value="{{ old('name') }}" placeholder="John Smith">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control" id="email"
                                                            value="{{ old('email') }}" placeholder="john@email.com">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        <input type="text" name="phone" class="form-control" id="phone"
                                                            value="{{ old('phone') }}" placeholder="+84 xxx xxx xxx">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="country" class="form-label">Country</label>
                                                        <input type="text" name="country" class="form-control" id="country"
                                                            value="{{ old('country') }}" placeholder="Vietnam">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="state" class="form-label">State / Province</label>
                                                        <input type="text" name="state" class="form-control" id="state"
                                                            value="{{ old('state') }}" placeholder="Hanoi">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="zip_code" class="form-label">Zip code</label>
                                                        <input type="text" name="zip_code" class="form-control"
                                                            id="zip_code" value="{{ old('zip_code') }}" placeholder="10000">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address" class="form-label">Address</label>
                                                        <textarea class="form-control" id="address" name="address" rows="3"
                                                            placeholder="Enter full address...">{{ old('address') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Submit --}}
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn-submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47L15.964.686zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178z" />
                                                </svg>
                                                Submit reservation
                                            </button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lấy date của checkin và checkout --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();

            // Check in = hôm nay
            document.getElementById('check_in').value = today.toISOString().split('T')[0];

            // Check out = hôm nay + 1 ngày
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            document.getElementById('check_out').value = tomorrow.toISOString().split('T')[0];
        });
    </script>

    {{-- Check Availability --}}
    <script>
        $(document).ready(function () {
            $('#room_type_id').on('change', function () {
                $('#check_in').val('');
                $('#check_out').val('');
                $('.availability').text(0);
                $('#available_room').val(0);
            });

            $('#check_in').on('change', function () {

                let checkIn = new Date($(this).val());
                let checkOut = new Date($('#check_out').val());

                // Nếu checkout chưa có hoặc <= checkin
                if (!$('#check_out').val() || checkOut <= checkIn) {
                    checkIn.setDate(checkIn.getDate() + 1);

                    $('#check_out').val(
                        checkIn.toISOString().split('T')[0]
                    );
                }

                getAvailability();
            });

            $('#check_out').on('change', function () {
                getAvailability();
            });
        });

        function getAvailability() {
            var check_in = $('#check_in').val();
            var check_out = $('#check_out').val();
            var room_id = $('#room_type_id').val();

            if (!check_in || !check_out || !room_id) {
                return;
            }

            var startDate = new Date(check_in);
            var endDate = new Date(check_out);

            $.ajax({
                url: "{{ route('check_room_availability') }}",
                data: {
                    room_id: room_id,
                    check_in: check_in,
                    check_out: check_out
                },
                success: function (data) {
                    $('.availability').text(data['available_room']);
                    $('#available_room').val(data['available_room']);
                }
            });
        };
    </script>

    {{-- Form Validation --}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myForm').validate({
                rules: {
                    number_of_rooms: {
                        required: true,
                    },
                    person: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    zip_code: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                },
                messages: {
                    number_of_rooms: {
                        required: 'Please Enter Number of Rooms',
                    },
                    person: {
                        required: 'Please Enter Number of Persons',
                    },
                    name: {
                        required: 'Please Enter Name',
                    },
                    email: {
                        required: 'Please Enter Email',
                    },
                    country: {
                        required: 'Please Enter Country',
                    },
                    state: {
                        required: 'Please Enter State',
                    },
                    phone: {
                        required: 'Please Enter Phone',
                    },
                    zip_code: {
                        required: 'Please Enter Zip Code',
                    },
                    address: {
                        required: 'Please Enter Address',
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection