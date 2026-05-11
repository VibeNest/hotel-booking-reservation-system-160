@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg7">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li> Check Out</li>
                </ul>
                <h3> Check Out</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Checkout Area -->
    <section class="checkout-area pt-100 pb-70">
        <div class="container">
            <form>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="billing-details">
                            <h3 class="title">Billing Details</h3>

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Country <span class="required">*</span></label>
                                        <div class="select-box">
                                            <select class="form-control">
                                                <option value="5">United Arab Emirates</option>
                                                <option value="1">China</option>
                                                <option value="2">United Kingdom</option>
                                                <option value="0">Germany</option>
                                                <option value="3">France</option>
                                                <option value="4">Japan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>First Name <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Last Name <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group">
                                        <label>Address <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group">
                                        <label>Town / City <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>State / County <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Postcode / Zip <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Email Address <span class="required">*</span></label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Phone <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="create-an-account">
                                        <label class="form-check-label" for="create-an-account">Create an account?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <section class="checkout-area pb-70">
                            <div class="card-body">
                                <div class="billing-details">
                                    <h3 class="title">Booking Summary</h3>
                                    <hr>

                                    <div style="display: flex">
                                        <img style="height:100px; width:100px;object-fit: cover"
                                            src="{{ (!empty($room->image)) ? asset('upload/room_images/' . $room->image) : asset('upload/no_image.jpg') }}"
                                            alt="{{ $room->type->name }}">
                                        <div style="padding-left: 10px;">
                                            <a href=" "
                                                style="font-size: 20px; color: #595959;font-weight: bold">{{ $room->type->name }}</a>
                                            <p><b>${{ $room->price }} / Night</b></p>
                                        </div>

                                    </div>

                                    <br>

                                    <table class="table" style="width: 100%">

                                        @php
                                            $subtotal = $room->price * $book_data['number_of_rooms'] * $nights;
                                            $discount = ($room->discount / 100) * $subtotal;
                                            $total = $subtotal - $discount;
                                        @endphp

                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Total Night <br><b style="color: red">
                                                        ({{ $book_data['check_in'] }} -
                                                        {{ $book_data['check_out'] }})</b></p>
                                            </td>
                                            <td style="text-align: right">
                                                <p>{{ $nights }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Total Room</p>
                                            </td>
                                            <td style=" text-align: right">
                                                <p>{{ $book_data['number_of_rooms'] }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Subtotal</p>
                                            </td>
                                            <td style="text-align: right">
                                                <p>${{ $subtotal }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Discount</p>
                                            </td>
                                            <td style="text-align:right">
                                                <p>${{ $discount }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Total</p>
                                            </td>
                                            <td style="text-align:right">
                                                <p>${{ $total }}</p>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </section>

                    </div>


                    {{-- <div class="col-lg-8 col-md-8">
                        <div class="payment-box">
                            <div class="payment-method">
                                <p>
                                    <input type="radio" id="cash-on-delivery" name="radio-group">
                                    <label for="cash-on-delivery">Cash On Delivery</label>
                                </p>
                                <p>
                                    <input type="radio" id="paypal" name="radio-group">
                                    <label for="paypal">PayPal</label>
                                </p>
                                <p>
                                    <input type="radio" id="stripe" name="radio-group">
                                    <label for="stripe">Stripe</label>
                                </p>
                                <p>
                                    <input type="radio" id="vn-pay" name="radio-group">
                                    <label for="vn-pay">VN Pay</label>
                                </p>
                            </div>

                            <a href="#" class="order-btn three">
                                Place to Order
                            </a>
                        </div>
                    </div> --}}

                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

                    <div class="col-lg-8 col-md-8">
                        <div class="payment-box">

                            <h4 class="payment-title">Choose Payment Method</h4>

                            <div class="payment-method">

                                <label class="payment-card">
                                    <input type="radio" name="payment_method" value="cod">

                                    <div class="payment-content">
                                        <div class="payment-left">
                                            <i class="fa-solid fa-money-bill-wave payment-icon cod"></i>
                                            <span>Cash On Delivery</span>
                                        </div>

                                        <div class="checkmark"></div>
                                    </div>
                                </label>

                                <label class="payment-card">
                                    <input type="radio" name="payment_method" value="paypal">

                                    <div class="payment-content">
                                        <div class="payment-left">
                                            <i class="fa-brands fa-paypal payment-icon paypal"></i>
                                            <span>PayPal</span>
                                        </div>

                                        <div class="checkmark"></div>
                                    </div>
                                </label>

                                <label class="payment-card">
                                    <input type="radio" name="payment_method" value="stripe">

                                    <div class="payment-content">
                                        <div class="payment-left">
                                            <i class="fa-brands fa-cc-stripe payment-icon stripe"></i>
                                            <span>Stripe</span>
                                        </div>

                                        <div class="checkmark"></div>
                                    </div>
                                </label>

                                <label class="payment-card">
                                    <input type="radio" name="payment_method" value="vnpay">

                                    <div class="payment-content">
                                        <div class="payment-left">
                                            <i class="fa-solid fa-wallet payment-icon vnpay"></i>
                                            <span>VN Pay</span>
                                        </div>

                                        <div class="checkmark"></div>
                                    </div>
                                </label>

                            </div>

                            <a href="#" class="order-btn three place-order-btn">
                                Place Order
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Area End -->
@endsection

<style>
    .payment-box {
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    }

    .payment-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .payment-method {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .payment-card {
        cursor: pointer;
        margin: 0;
    }

    .payment-card input {
        display: none;
    }

    .payment-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 2px solid #e5e5e5;
        border-radius: 14px;
        padding: 18px 20px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .payment-card:hover .payment-content {
        border-color: #0d6efd;
        transform: translateY(-2px);
    }

    .payment-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .payment-icon {
        font-size: 26px;
    }

    .payment-left span {
        font-size: 17px;
        font-weight: 600;
    }

    .cod {
        color: #28a745;
    }

    .paypal {
        color: #003087;
    }

    .stripe {
        color: #635bff;
    }

    .vnpay {
        color: #005baa;
    }

    .checkmark {
        width: 22px;
        height: 22px;
        border: 2px solid #ccc;
        border-radius: 50%;
        position: relative;
        transition: 0.3s;
    }

    .payment-card input:checked+.payment-content {
        border-color: #0d6efd;
        background: #f4f8ff;
    }

    .payment-card input:checked+.payment-content .checkmark {
        border-color: #0d6efd;
    }

    .payment-card input:checked+.payment-content .checkmark::after {
        content: "";
        width: 10px;
        height: 10px;
        background: #0d6efd;
        border-radius: 50%;
        position: absolute;
        top: 4px;
        left: 4px;
    }

    .place-order-btn {
        display: inline-block;
        width: 100%;
        text-align: center;
        margin-top: 30px;
        padding: 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0d6efd, #0056d2);
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
    }

    .place-order-btn:hover {
        transform: translateY(-2px);
        color: #fff;
    }
</style>