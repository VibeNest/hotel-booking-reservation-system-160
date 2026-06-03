<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminBookingController;
use App\Http\Controllers\Backend\BookAreaController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// HomePage
Route::get('/', [UserController::class, 'Index']);

// User Dashboard Routes
Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Group Middleware
Route::middleware('auth')->group(function () {
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware('admin.guest')->name('admin.login');

// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    // Teams Management Routes
    Route::controller(TeamController::class)->group(function () {
        Route::get('/all/team', 'AllTeam')->name('all.team');
        Route::get('/add/team', 'AddTeam')->name('add.team');
        Route::post('/store/team', 'StoreTeam')->name('store.team');
        Route::get('/delete/team/{id}', 'DeleteTeam')->name('delete.team');
        Route::get('/edit/team/{id}', 'EditTeam')->name('edit.team');
        Route::post('/team/update', 'UpdateTeam')->name('team.update');
    });

    // Book Area Management Routes
    Route::controller(BookAreaController::class)->group(function () {
        Route::get('/all/book_area', 'AllBookArea')->name('all.book.area');
        Route::get('/add/book_area', 'AddBookArea')->name('add.book.area');
        Route::post('/book_area/store', 'StoreBookArea')->name('book_area.store');
        Route::get('/edit/book_area/{id}', 'EditBookArea')->name('edit.book_area');
        Route::post('/book_area/update', 'UpdateBookArea')->name('book_area.update');
        Route::get('/delete/book_area/{id}', 'DeleteBookArea')->name('delete.book_area');
    });

    // Room Type Management Routes
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('/room/type/list', 'RoomTypeList')->name('room.type.list');
        Route::get('/add/room/type', 'AddRoomType')->name('add.room.type');
        Route::post('/room/type/store', 'RoomTypeStore')->name('room.type.store');
    });

    // Room Management Routes
    Route::controller(RoomController::class)->group(function () {
        Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room');
        Route::post('/update/room/{id}', 'UpdateRoom')
            ->name('update.room');
        Route::get('/multi/image/delete/{id}', 'MultiImageDelete')
            ->name('multi.image.delete');
        Route::get('/delete/room/{id}', 'DeleteRoom')->name('delete.room');

        // Edit
        Route::get('/edit/roomnumber/{id}', 'EditRoomNumber')
            ->name('edit.roomnumber');

        // Store
        Route::post('/store/room/number/{id}', 'StoreRoomNumber')
            ->name('store.room.number');

        // Update
        Route::post('/update/roomnumber/{id}', 'UpdateRoomNumber')
            ->name('update.roomnumber');

        // Delete
        Route::get('/delete/room/number/{id}', 'DeleteRoomNumber')->name('delete.room.number');
    });

    // Admin Booking Management Routes
    Route::controller(AdminBookingController::class)->group(function () {
        Route::get('/booking/list', 'BookingList')->name('booking.list');
        Route::get('/edit/booking/{id}', 'EditBooking')->name('edit_booking');
        Route::post('/update/booking/status/{id}', 'UpdateBookingStatus')->name('update.booking.status');
        Route::post('/update/booking/{id}', 'UpdateBooking')->name('update.booking');

        // Assign Room Routes
        Route::get('/assign_room/{id}', 'AssignRoom')->name('assign_room');
        Route::get('/assign_room/store/{booking_id}/{room_number_id}', 'AssignRoomStore')->name('assign_room_store');
        Route::get('/assign_room/delete/{id}', 'AssignRoomDelete')->name('assign_room_delete');
    });

    // Admin Room List Management Routes
    Route::controller(RoomListController::class)->group(function () {
        Route::get('/view/room/list', 'ViewRoomList')->name('view.room.list');
        Route::get('/add/room/list', 'AddRoomList')->name('add.room.list');
        Route::post('/store/room/list', 'StoreRoomList')->name('store.room.list');
    });
});

// Instructor Group Middleware
Route::middleware(['auth', 'roles:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
});

// Room All Routes
Route::controller(FrontendRoomController::class)->group(function () {
    Route::get('/rooms', 'AllFrontendRoomList')->name('room.all');
    Route::get('/room/details/{id}', 'RoomDetailsPage')->name('room.details');
    Route::get('/bookings', 'BookingSearch')->name('booking.search');
    Route::get('/search/room/details/{id}', 'SearchRoomDetails')->name('search_room_details');
    Route::get('/check_room_availability', 'CheckRoomAvailability')->name('check_room_availability');
});

// VNPay return callback (no auth required)
Route::get('/vnpay-return', [BookingController::class, 'vnpayReturn'])->name('vnpay.return');

// Auth Middleware, User mush have login for access this routes
Route::middleware('auth')->group(function () {
    // Checkout All Routes
    Route::controller(BookingController::class)->group(function () {
        Route::get('/checkout', 'Checkout')->name('checkout');
        Route::post('/booking/store/{id}', 'BookingStore')->name('user_booking_store');

        // Payment by cash
        Route::post('/checkout/store', 'CheckoutStore')->name('checkout.store');

        // Payment by Stripe
        Route::match(['get', 'post'], '/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');

        // Payment by VNPay
        Route::post('/vnpay-payment', 'vnpayPayment')->name('vnpay.payment');

        // Payment by paypal
        Route::prefix('paypal')->group(function () {
            Route::get('/payment', 'PaypalPayment')->name('paypal.payment');
            Route::get('/success', 'PaypalSuccess')->name('paypal.success');
            Route::get('/cancel', 'PaypalCancel')->name('paypal.cancel');
        });

        // Place Order success page 
        Route::get('/place/order', [BookingController::class, 'PlaceOrder'])->name('place.order');
    });
});

require __DIR__ . '/auth.php';
