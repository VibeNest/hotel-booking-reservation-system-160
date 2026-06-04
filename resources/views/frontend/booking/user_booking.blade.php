@extends('frontend.home_page')

@section('home')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg6">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>User Booing List </li>
                </ul>
                <h3>User Booking List</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Service Details Area -->
    <div class="service-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    {{-- Sidebar --}}
                    @include('frontend.dashboard.user_menu')
                </div>

                <div class="col-lg-9">
                    <div class="service-article">
                        <section class="checkout-area pb-70">
                            <div class="container">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <h3 class="fw-bold mb-1">
                                                    <i class='bx bx-calendar-check text-primary'></i>
                                                    My Booking List
                                                </h3>
                                                <p class="text-muted mb-0">
                                                    View all your hotel reservations
                                                </p>
                                            </div>

                                            <span class="badge bg-primary fs-6">
                                                {{ count($allData) }} Bookings
                                            </span>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">

                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Booking No</th>
                                                        <th>Booking Date</th>
                                                        <th>Customer</th>
                                                        <th>Room Type</th>
                                                        <th>Stay Period</th>
                                                        <th>Rooms</th>
                                                        <th>Guests</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @forelse ($allData as $item)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('user.invoice', $item->id) }}"><span
                                                                        class="fw-semibold text-primary">
                                                                        {{ $item->code }}</span></a>
                                                            </td>

                                                            <td>
                                                                {{ $item->created_at->format('d/m/Y') }}
                                                            </td>

                                                            <td>
                                                                {{ $item->name }}
                                                            </td>

                                                            <td>
                                                                {{ $item->room->type->name }}
                                                            </td>

                                                            <td>
                                                                <div>
                                                                    <small class="badge bg-primary">
                                                                        {{ $item->check_in }}
                                                                    </small>
                                                                    <br>
                                                                    <small class="badge bg-warning text-dark">
                                                                        {{ $item->check_out }}
                                                                    </small>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                {{ $item->number_of_rooms }}
                                                            </td>

                                                            <td>
                                                                {{ $item->person }}
                                                            </td>

                                                            <td>
                                                                @if ($item->status == 1)
                                                                    <span class="badge bg-success">
                                                                        Complete
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-danger">
                                                                        Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center py-5">
                                                                <i class='bx bx-calendar-x fs-1 text-muted'></i>
                                                                <p class="mt-2 mb-0 text-muted">
                                                                    No bookings found
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Service Details Area End -->
@endsection