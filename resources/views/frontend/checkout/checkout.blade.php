@extends('frontend.home_page')

@section('home')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
            <form role="form" method="POST" action="{{ route('checkout.store') }}" class="stripe_form require-validation"
                data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="billing-details">
                            <h3 class="title">Billing Details</h3>

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Country <span class="required">*</span></label>
                                        <div class="select-box">
                                            <select class="form-control" name="country">
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="China">China</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="Germany">Germany</option>
                                                <option value="France">France</option>
                                                <option value="Japan">Japan</option>
                                                <option value="United States">United States</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="India">India</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Italy">Italy</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label> Name <span class="required">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label> Email <span class="required">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label> Phone <span class="required">*</span></label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ optional(Auth::user())->phone }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label> Address <span class="required">*</span></label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ optional(Auth::user())->address }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label> State <span class="required">*</span></label>
                                        <input type="text" name="state" class="form-control">
                                        @if ($errors->has('state'))
                                            <span class="text-danger">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label> Zip Code <span class="required">*</span></label>
                                        <input type="text" name="zip_code" class="form-control">
                                        @if ($errors->has('zip_code'))
                                            <span class="text-danger">{{ $errors->first('zip_code') }}</span>
                                        @endif
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div class="billing-details">
                            <h3 class="title">Facility Add-ons</h3>

                            @php
                                $facilityFees = config('facilities.fees', []);
                            @endphp

                            @if (count($facilityFees) > 0)
                                <div class="form-group">
                                    @foreach ($facilityFees as $facility => $fee)
                                        <div style="margin-bottom: 8px;">
                                            <label style="display: flex; justify-content: space-between; gap: 12px;">
                                                <span>
                                                    <input type="checkbox" name="facility_addons[]" value="{{ $facility }}"
                                                        data-fee="{{ (float) $fee }}">
                                                    {{ $facility }}
                                                </span>
                                                <span>
                                                    {{ $fee > 0 ? '$' . number_format((float) $fee, 0) : 'Free' }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No add-ons available.</p>
                            @endif
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
                                            <td style="text-align: right;">
                                                <p style="color: red; font-weight: 600">{{ $nights }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Total Room</p>
                                            </td>
                                            <td style=" text-align: right; color: red;">
                                                <p style="color: red; font-weight: 600">{{ $book_data['number_of_rooms'] }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Subtotal</p>
                                            </td>
                                            <td style="text-align: right;">
                                                <p style="color: red; font-weight: 600">${{ $subtotal }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Discount</p>
                                            </td>
                                            <td style="text-align:right; ">
                                                <p style="color: red; font-weight: 600">${{ $discount }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Total</p>
                                            </td>
                                            <td style="text-align:right;">
                                                <p style="color: red; font-weight: 600">${{ $total }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Facility Add-ons</p>
                                            </td>
                                            <td style="text-align:right;">
                                                <p id="facility-addon-total" style="color: red; font-weight: 600"
                                                    data-base-total="{{ $total }}">$0</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-weight: 600">Grand Total</p>
                                            </td>
                                            <td style="text-align:right;">
                                                <p id="facility-grand-total" style="color: red; font-weight: 600">
                                                    ${{ $total }}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </section>

                    </div>

                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

                    <div class="col-lg-8 col-md-8">
                        <div class="payment-box">

                            <h4 class="payment-title">Choose Payment Method</h4>

                            <div class="payment-method">
                                @if ($errors->has('payment_method'))
                                    <span class="text-danger">
                                        {{ $errors->first('payment_method') }}
                                    </span>
                                @endif

                                <label class="payment-card">
                                    <input type="radio" class="pay_method" name="payment_method" id="cash-on-delivery"
                                        value="COD">

                                    <div class="payment-content">
                                        <div class="payment-left">
                                            <i class="fa-solid fa-money-bill-wave payment-icon cod"></i>
                                            <span>Cash On Delivery</span>
                                        </div>

                                        <div class="checkmark"></div>
                                    </div>
                                </label>

                                <label class="payment-card">
                                    <input type="radio" class="pay_method" name="payment_method" id="stripe" value="Stripe">

                                    <div class="payment-content">
                                        <div class="payment-left">
                                            <i class="fa-brands fa-cc-stripe payment-icon stripe"></i>
                                            <span>Stripe</span>
                                        </div>

                                        <div class="checkmark"></div>
                                    </div>
                                </label>

                                <div id="stripe_pay" class="stripe-payment-form d-none">

                                    <div class="stripe-header">
                                        <i class="fa-brands fa-cc-stripe"></i>
                                        <span>Secure Stripe Payment</span>
                                    </div>

                                    <div class="stripe-card-box">

                                        <div class="form-group mb-3">
                                            <label class="stripe-label">
                                                Name on Card
                                            </label>

                                            <input type="text" id="card-holder-name" class="form-control stripe-input"
                                                placeholder="John Doe">
                                        </div>

                                        <div class="form-group">

                                            <label class="stripe-label">
                                                Card Information
                                            </label>

                                            <div id="card-element"></div>

                                            <small class="text-muted d-block mt-2">
                                                Test card: 4242 4242 4242 4242
                                            </small>

                                            <div id="card-errors" class="text-danger mt-2"></div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="payment-actions">
                                <button type="submit" class="order-btn three place-order-btn" id="myButton">
                                    Place to Order
                                </button>

                                <div class="payment-separator">Or pay directly</div>

                                <div class="direct-payment-actions">
                                    <button type="submit" name="payment_method" value="paypal"
                                        class="direct-payment-btn paypal-btn">
                                        <i class="fa-brands fa-paypal payment-icon"></i>
                                        <span>Pay with PayPal</span>
                                    </button>

                                    <button type="submit" name="payment_method" value="VN Pay"
                                        formaction="{{ route('vnpay.payment') }}" class="direct-payment-btn vnpay-btn">
                                        <i class="fa-solid fa-wallet payment-icon"></i>
                                        <span>Pay with VN Pay</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        const facilityInputs = document.querySelectorAll('input[name="facility_addons[]"]');
                        const addonTotalEl = document.getElementById('facility-addon-total');
                        const grandTotalEl = document.getElementById('facility-grand-total');

                        const toMoney = (value) => `$${Math.round(Number(value))}`;

                        const updateFacilityTotals = () => {
                            if (!addonTotalEl || !grandTotalEl) {
                                return;
                            }

                            const baseTotal = Number(addonTotalEl.dataset.baseTotal || 0);
                            let addonTotal = 0;

                            facilityInputs.forEach((input) => {
                                if (input.checked) {
                                    addonTotal += Number(input.dataset.fee || 0);
                                }
                            });

                            addonTotalEl.textContent = toMoney(addonTotal);
                            grandTotalEl.textContent = toMoney(baseTotal + addonTotal);
                        };

                        facilityInputs.forEach((input) => {
                            input.addEventListener('change', updateFacilityTotals);
                        });

                        updateFacilityTotals();
                    </script>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Area End -->

    <style>
        .hide {
            display: none
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // SHOW / HIDE STRIPE FORM
        $(document).ready(function () {
            $(".pay_method").on('change', function () {
                let payment_method = $(this).val();

                if (payment_method === 'Stripe') {
                    $("#stripe_pay").removeClass('d-none');
                } else {
                    $("#stripe_pay").addClass('d-none');
                }
            });
        });

        // STRIPE V3

        const stripe = Stripe("{{ env('STRIPE_KEY') }}");

        const elements = stripe.elements();

        const card = elements.create('card', {
            style: {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',

                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },

                invalid: {
                    color: '#dc3545',
                    iconColor: '#dc3545'
                }
            }
        });

        card.mount('#card-element');

        // REALTIME ERROR

        card.on('change', function (event) {
            const displayError = document.getElementById('card-errors');

            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // FORM SUBMIT

        const form = document.querySelector('.stripe_form');

        form.addEventListener('submit', async function (e) {
            // BUTTON ĐƯỢC CLICK
            const clickedButton = document.activeElement;

            // PAYPAL / VNPAY => CHO SUBMIT THẲNG
            if (clickedButton && (clickedButton.value === 'paypal' || clickedButton.value === 'VN Pay')) {
                return true;
            }

            // PLACE ORDER BUTTON
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');

            // NO PAYMENT
            if (!selectedPayment) {
                e.preventDefault();
                alert('Please select payment method');
                return;
            }

            // COD

            if (selectedPayment.value === 'COD') {
                return true;
            }

            // STRIPE
            if (selectedPayment.value === 'Stripe') {
                e.preventDefault();

                const submitBtn = document.getElementById('myButton');

                submitBtn.disabled = true;

                submitBtn.innerHTML = 'Processing...';

                const { token, error } = await stripe.createToken(card);

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;

                    submitBtn.disabled = false;

                    submitBtn.innerHTML = 'Place to Order';
                } else {
                    const hiddenInput = document.createElement('input');

                    hiddenInput.setAttribute('type', 'hidden');

                    hiddenInput.setAttribute('name', 'stripeToken');

                    hiddenInput.setAttribute('value', token.id);

                    form.appendChild(hiddenInput);

                    form.submit();
                }
            }
        });
    </script>
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
        min-height: 56px;
    }

    .stripe {
        color: #635bff;
    }

    .vnpay {
        color: #005baa;
        min-height: 56px;
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

    .payment-actions {
        margin-top: 30px;
    }

    .payment-separator {
        margin: 18px 0 14px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #7a7a7a;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .direct-payment-actions {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .direct-payment-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        border: 0;
        border-radius: 12px;
        padding: 15px 16px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        transition: 0.3s ease;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
    }

    .direct-payment-btn:hover {
        transform: translateY(-2px);
    }

    .direct-payment-btn .payment-icon {
        font-size: 20px;
    }

    .paypal-btn {
        background: #ffc439;
        color: #003087;
        border: 1px solid #f0b800;
        border-radius: 999px;
        min-height: 44px;
        padding: 10px 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        font-weight: 700;
    }

    .vnpay-btn {
        background: #f6f7f9;
        color: #003087;
        border: 1px solid #d7dbe3;
        border-left: 5px solid #003087;
        border-radius: 12px;
        min-height: 44px;
        padding: 10px 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        font-weight: 700;
    }

    .vnpay-btn .payment-icon,
    .vnpay-btn span {
        color: #003087;
    }

    .vnpay-btn:hover {
        background: #eef1f5;
        color: #003087;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .paypal-btn .payment-icon,
    .paypal-btn span {
        color: #003087;
    }

    .paypal-btn .payment-icon {
        font-size: 22px;
    }

    .paypal-btn:hover {
        background: #ffd34d;
        color: #003087;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 575px) {
        .direct-payment-actions {
            grid-template-columns: 1fr;
        }
    }

    #card-element {
        padding: 16px;
        border: 1px solid #dcdfe6;
        border-radius: 12px;
        background: #fff;
        transition: 0.3s;
    }

    #card-element.StripeElement--focus {
        border-color: #635bff;
        box-shadow: 0 0 0 4px rgba(99, 91, 255, 0.12);
    }

    #card-element.StripeElement--invalid {
        border-color: #dc3545;
    }
</style>