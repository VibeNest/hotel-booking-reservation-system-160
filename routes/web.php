<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminBookingController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BookAreaController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\frontend\PostController;
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
    // Auth Routes
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
        Route::get('/download/invoice/{id}', 'DownloadInvoice')->name('download.invoice');
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

    // Smtp Setting Routes
    Route::controller(SettingController::class)->group(function () {
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/smtp/update', 'SmtpUpdate')->name('smtp.update');
    });

    // Testimonials All Routes
    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/all/testimonial', 'AllTestimonial')->name('all.testimonial');
        Route::get('/add/testimonial', 'AddTestimonial')->name('add.testimonial');
        Route::post('/testimonial/store', 'TestimonialStore')->name('testimonial.store');
        Route::get('/edit/testimonial/{id}', 'EditTestimonial')->name('edit.testimonial');
        Route::post('/testimonial/update', 'TestimonialUpdate')->name('testimonial.update');
        Route::get('/delete/testimonial/{id}', 'DeleteTestimonial')->name('delete.testimonial');
    });

    // Blog Category Routes
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog/category', 'BlogCategory')->name('blog.category');
        Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');
    });

    // Blog Posts All Routes
    Route::controller(BlogController::class)->group(function () {
        Route::get('/all/blog/post', 'AllBlogPost')->name('all.blog.post');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post');
    });

    // Comment All Routes
    Route::controller(CommentController::class)->group(function () {
        Route::get('/all/comment', 'AllComment')->name('all.comment');
        Route::post('/update/comment/status', 'UpdateCommentStatus')->name('update.comment.status');
    });

    // Booking Report All Routes
    Route::controller(ReportController::class)->group(function () {
        Route::get('/booking/report', 'BookingReport')->name('booking.report');
        Route::post('/seach-by-date', 'SeachByDate')->name('seach-by-date');
    });

    // Site Setting Routes
    Route::controller(SettingController::class)->group(function () {
        Route::get('/site/setting', 'SiteSetting')->name('site.setting');
        Route::post('/site/update', 'SiteUpdate')->name('site.update');
    });

    // Gallery All Routes
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('store.gallery');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/update/gallery', 'UpdateGallery')->name('update.gallery');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');
        Route::post('/delete/gallery/multiple', 'DeleteGalleryMultiple')->name('delete.gallery.multiple');
    });
});

// Instructor Group Middleware
Route::middleware(['auth', 'roles:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
});

// User not need login to access this routes
// Frontend Room All Routes
Route::controller(FrontendRoomController::class)->group(function () {
    Route::get('/rooms', 'AllFrontendRoomList')->name('room.all');
    Route::get('/room/details/{id}', 'RoomDetailsPage')->name('room.details');
    Route::get('/bookings', 'BookingSearch')->name('booking.search');
    Route::get('/search/room/details/{id}', 'SearchRoomDetails')->name('search_room_details');
    Route::get('/check_room_availability', 'CheckRoomAvailability')->name('check_room_availability');
});

// Frontend Blog All Routes
Route::controller(PostController::class)->group(function () {
    Route::get('/blog/details/{slug}', 'BlogDetails');
    Route::get('/blog/category/list/{id}', 'BlogCategoryList');
    Route::get('/blog', 'BlogList')->name('blog.list');
    Route::get('/blog/search', 'BlogSearch')->name('blog.search');
    Route::get('/blog/category/list/{id}/search', 'BlogCategorySearch')->name('blog.category.search');
});

// Frontend Comment All Routes
Route::controller(CommentController::class)->group(function () {
    Route::post('/store/comment', 'StoreComment')->name('store.comment');
});

// Frontend Gallery All Routes
Route::controller(GalleryController::class)->group(function () {
    Route::get('/gallery', 'ShowGallery')->name('show.gallery');
});

// Frontend Contact All Routes
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'ContactUs')->name('contact.us');
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

        // User Booking Routes
        Route::get('/user/booking', 'UserBooking')->name('user.booking');
        Route::get('/user/invoice/{id}', 'UserInvoice')->name('user.invoice');
    });
});

require __DIR__ . '/auth.php';
