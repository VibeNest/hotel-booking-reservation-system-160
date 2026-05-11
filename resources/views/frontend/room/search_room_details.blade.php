@extends('frontend.home_page')

@section('home')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Inner Banner -->
    <div class="inner-banner inner-bg10">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Search Room Details </li>
                </ul>
                <h3>{{ $roomdetails->type->name }}</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Room Details Area End -->
    <div class="room-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="room-details-side">
                        <div class="side-bar-form">
                            <h3>Booking Sheet </h3>

                            <form action="{{ route('user_booking_store', $room_id)  }}" method="post" id="form">
                                @CSRF

                                <input type="hidden" name="room_id" value="{{ $room_id }}">

                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Check in</label>
                                            <div class="input-group">
                                                <input autocomplete="off" name="check_in" id="check_in" type="text" required
                                                    class="form-control"
                                                    value="{{ old('check_in') ? date('d-m-Y', strtotime(old('check_in'))) : '' }}">
                                                <span class="input-group-addon"></span>
                                            </div>
                                            <i class='bx bxs-calendar'></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Check Out</label>
                                            <div class="input-group">
                                                <input autocomplete="off" name="check_out" id="check_out" type="text"
                                                    required class="form-control"
                                                    value="{{ old('check_out') ? date('d-m-Y', strtotime(old('check_out'))) : '' }}">
                                                <span class="input-group-addon"></span>
                                            </div>
                                            <i class='bx bxs-calendar'></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Numbers of Persons</label>
                                            <select class="form-control" name="person" id="number_of_person">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option {{ old('person') == $i ? 'selected' : '' }} value="0{{ $i }}">
                                                        0{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" id="total_person" value="{{  $total_person }}">
                                    <input type="hidden" id="price" value="{{ $roomdetails->price }}">
                                    <input type="hidden" id="discount" value="{{ $roomdetails->discount }}">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Numbers of Rooms</label>
                                            <select class="form-control number_of_rooms" name="number_of_rooms"
                                                id="select_room">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="0{{ $i }}">0{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <input type="hidden" name="available_room" id="available_room">
                                        <p class="available_room" style="font-weight: 600"></p>
                                    </div>

                                    <div class="col-lg-12">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Sub Total</p>
                                                    </td>
                                                    <td style="text-align: right"><span class="subtotal">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Discount</p>
                                                    </td>
                                                    <td style="text-align: right"><span class="t_discount">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Total</p>
                                                    </td>
                                                    <td style="text-align: right"><span class="total_price">0</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="room-details-article">
                        <div class="room-details-slider owl-carousel owl-theme">
                            @foreach ($multiImages as $image)
                                <div class="room-details-item">
                                    <img src="{{asset($image->multi_img)}}" alt="Images" width="1000" height="600">
                                </div>
                            @endforeach
                        </div>

                        <div class="room-details-title">
                            <h2>{{ $roomdetails->type->name }}</h2>
                            <ul>

                                <li>
                                    <b> Basic : ${{ $roomdetails->price }}/Night/Room</b>
                                </li>

                            </ul>
                        </div>

                        <div class="room-details-content">
                            <p>
                                {!! html_entity_decode($roomdetails->description) !!}
                            </p>

                            <div class="side-bar-plan">
                                <h3>Basic Plan Facilities</h3>
                                <ul>
                                    @foreach ($facilities as $facility)
                                        <li><a href="#">{{ $facility->facility_name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="services-bar-widget">
                                        <h3 class="title">Room Details</h3>
                                        <div class="side-bar-list">
                                            <ul>
                                                <li>
                                                    <a href="#"> <b>Capacity : </b> {{ $roomdetails->room_capacity }} Person
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"> <b>Size : </b> {{ $roomdetails->size }} m2 </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="services-bar-widget">
                                        <h3 class="title">Room Details</h3>
                                        <div class="side-bar-list">
                                            <ul>
                                                <li>
                                                    <a href="#"> <b>View : </b> {{ $roomdetails->view }} </a>
                                                </li>
                                                <li>
                                                    <a href="#"> <b>Bad Style : </b> {{ $roomdetails->bed_style }} </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="room-details-review">
                            <h2>Clients Review and Retting's</h2>
                            <div class="review-ratting">
                                <h3>Your retting: </h3>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" cols="30" rows="8" required
                                                data-error="Write your message"
                                                placeholder="Write your review here.... "></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn btn-bg-three">
                                            Submit Review
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Details Area End -->

    <!-- Room Details Other -->
    <div class="room-details-other pb-70">
        <div class="container">
            <div class="room-details-text">
                <h2>Other Rooms</h2>
            </div>

            <div class="row ">

                @foreach ($otherRooms as $room)
                    <div class="col-lg-6">
                        <div class="room-card-two">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="room-card-img">
                                        <a href="{{ route('room.details', $room->id) }}">
                                            <img src="{{ asset('upload/room_images/' . $room->image) }}" alt="Images">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-8 p-0">
                                    <div class="room-card-content">
                                        <h3>
                                            <a href="{{ route('room.details', $room->id) }}">{{ $room->type->name }}</a>
                                        </h3>
                                        <span>{{ $room->price ?? 0 }} / Per Night </span>

                                        <div class="rating">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                        </div>


                                        <div class="room-desc">
                                            {!! html_entity_decode($room->short_desc ?? '') !!}
                                        </div>

                                        <ul>
                                            <li><i class='bx bx-user'></i>
                                                {{ $room->room_capacity }} Person
                                            </li>
                                            <li><i class='bx bx-expand'></i> {{ $room->size ?? 0 }} m2</li>
                                        </ul>

                                        <ul>
                                            <li><i class='bx bx-show-alt'></i> {{ $room->view ?? '' }}</li>
                                            <li><i class='bx bxs-hotel'></i> {{ $room->bed_style ?? '' }}</li>
                                        </ul>

                                        <a href="room-details.html" class="book-more-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Room Details Other End -->

    <script>
        $(document).ready(function () {
            // Lấy id phòng
            var room_id = {{ $room_id }};

            // Hàm kiểm tra phòng trống
            function checkRoomAvailability() {
                // Lấy ngày nhận phòng
                var check_in = $("#check_in").val();
                // Lấy ngày trả phòng
                var check_out = $("#check_out").val();

                if (check_in != '' && check_out != '') {
                    getAvaility(check_in, check_out, room_id);
                }
            }

            $("#check_in").datepicker("destroy");

            // Khi thay đổi ngày nhận phòng => gọi hàm kiểm tra phòng trống
            $("#check_in").datepicker({
                dateFormat: "dd-mm-yy",
                minDate: 0,

                onSelect: function () {
                    let checkInDate = $(this).datepicker("getDate");

                    // Checkout tối thiểu = checkin + 1 ngày
                    let minCheckout = new Date(checkInDate);
                    minCheckout.setDate(minCheckout.getDate() + 1);

                    // Update minDate checkout
                    $("#check_out").datepicker("option", "minDate", minCheckout);

                    // Checkout hiện tại
                    let currentCheckout = $("#check_out").datepicker("getDate");

                    // Nếu checkout chưa hợp lệ
                    if (!currentCheckout || currentCheckout <= checkInDate) {
                        $("#check_out").datepicker("setDate", minCheckout);
                    }

                    // Gọi ajax
                    checkRoomAvailability();
                }
            });

            $("#check_out").datepicker("destroy");

            // Khi thay đổi ngày trả phòng => gọi hàm kiểm tra phòng trống
            $("#check_out").datepicker({
                dateFormat: "dd-mm-yy",
                minDate: 1,

                onSelect: function () {
                    // Gọi ajax
                    checkRoomAvailability();
                }
            });

            let oldCheckIn = $("#check_in").datepicker("getDate");

            if (oldCheckIn) {
                let minCheckout = new Date(oldCheckIn);
                minCheckout.setDate(minCheckout.getDate() + 1);

                $("#check_out").datepicker("option", "minDate", minCheckout);

                let oldCheckout = $("#check_out").datepicker("getDate");

                if (!oldCheckout || oldCheckout <= oldCheckIn) {
                    $("#check_out").datepicker("setDate", minCheckout);
                }

                // Auto check availability khi reload
                checkRoomAvailability();
            }

            // Khi thay đổi số lượng phòng => gọi hàm kiểm tra phòng trống
            $(".number_of_rooms").on('change', function () {
                checkRoomAvailability();
            });
        });

        // Kiểm tra tình trạng phòng trống
        function getAvaility(check_in, check_out, room_id) {
            $.ajax({
                url: "{{ route('check_room_availability') }}",
                data: {
                    room_id: room_id,
                    check_in: check_in,
                    check_out: check_out
                },
                success: function (data) {
                    $(".available_room").html(
                        'Available Room: <span class="text-success">' +
                        data['available_room'] +
                        ' Rooms</span>'
                    );
                    $("#available_room").val(data['available_room']);
                    price_calculate(data['total_nights']);
                }
            });
        };

        // Tính tổng tiền phòng
        function price_calculate(total_nights) {
            var room_price = $('#price').val();
            var discount = $('#discount').val();
            var select_room = $('#select_room').val();

            // Tính tổng tiền chưa giảm giá
            var sub_total = room_price * total_nights * parseInt(select_room);

            // Tính tổng tiền giảm giá
            var discount_price = (parseInt(discount) / 100) * sub_total;

            // Tính tổng tiền sau khi giảm giá
            var total_price = sub_total - discount_price;

            // Hiển thị giá tiền lên giao diện
            $('.subtotal').text('$' + sub_total);
            $('.t_discount').text('$' + discount_price);
            $('.total_price').text('$' + total_price);
        };


        // Kiểm tra các điều kiện trước khi submit form
        $("#form").on('submit', function () {
            // Lấy số lượng phòng đã chọn
            var select_room = $('#select_room').val();
            // Lấy số lượng phòng còn trống
            var available_room = $('#available_room').val();

            if (parseInt(select_room) > parseInt(available_room)) {
                toastr.error('Sorry, you selected more rooms than available', 'Booking Error', {
                    "timeOut": "3000",
                    "positionClass": "toast-bottom-right",
                });

                return false;
            }

            // Lấy số lượng người sau khi chọn
            var number_of_person = $('#number_of_person').val();

            // Lấy số lượng người tối đa của phòng
            var total_person = $('#total_person').val();

            if (parseInt(number_of_person) > parseInt(total_person)) {
                toastr.error('Sorry, you select maximum number of person', 'Booking Error', {
                    "timeOut": "3000",
                    "positionClass": "toast-bottom-right",
                });

                return false;
            }
        });

    </script>
@endsection