<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminBookingController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BookAreaController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Admin\AddOnController;
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

// About Page
Route::get('/about', function () {
    return view('frontend.about.about_us');
})->name('about.us');

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
        Route::get('/all/team', 'index')->name('all.team')->middleware('permission:team.view');
        Route::get('/add/team', 'create')->name('add.team')->middleware('permission:team.create');
        Route::post('/store/team', 'store')->name('store.team')->middleware('permission:team.create');
        Route::get('/delete/team/{id}', 'destroy')->name('delete.team')->middleware('permission:team.delete');
        Route::get('/edit/team/{id}', 'edit')->name('edit.team')->middleware('permission:team.edit');
        Route::post('/team/update', 'update')->name('team.update')->middleware('permission:team.update');
    });

    // Add-ons All Routes
    Route::controller(AddOnController::class)->group(function () {
        Route::get('/all/addons', 'index')->name('all.addons')->middleware('permission:addon.view');
        Route::get('/add/addon', 'create')->name('add.addon')->middleware('permission:addon.create');
        Route::post('/store/addon', 'store')->name('store.addon')->middleware('permission:addon.create');
        Route::get('/edit/addon/{id}', 'edit')->name('edit.addon')->middleware('permission:addon.edit');
        Route::post('/update/addon/{id}', 'update')->name('update.addon')->middleware('permission:addon.update');
        Route::get('/delete/addon/{id}', 'destroy')->name('delete.addon')->middleware('permission:addon.delete');
    });

    // Book Area Management Routes
    Route::controller(BookAreaController::class)->group(function () {
        Route::get('/all/book_area', 'index')->name('all.book.area')->middleware('permission:book.area.view');
        Route::get('/add/book_area', 'create')->name('add.book.area')->middleware('permission:book.area.create');
        Route::post('/book_area/store', 'store')->name('book_area.store')->middleware('permission:book.area.create');
        Route::get('/edit/book_area/{id}', 'edit')->name('edit.book_area')->middleware('permission:book.area.edit');
        Route::post('/book_area/update', 'update')->name('book_area.update')->middleware('permission:book.area.update');
        Route::get('/delete/book_area/{id}', 'destroy')->name('delete.book_area')->middleware('permission:book.area.delete');
    });

    // Room Type Management Routes
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('/room/type/list', 'RoomTypeList')->name('room.type.list')->middleware('permission:room.type.view');
        Route::get('/add/room/type', 'AddRoomType')->name('add.room.type')->middleware('permission:room.type.create');
        Route::post('/room/type/store', 'RoomTypeStore')->name('room.type.store')->middleware('permission:room.type.create');
    });

    // Room Management Routes
    Route::controller(RoomController::class)->group(function () {
        Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room')->middleware('permission:room.list.edit');
        Route::post('/update/room/{id}', 'UpdateRoom')
            ->name('update.room')->middleware('permission:room.list.update');
        Route::get('/multi/image/delete/{id}', 'MultiImageDelete')
            ->name('multi.image.delete')->middleware('permission:room.list.delete');
        Route::get('/delete/room/{id}', 'DeleteRoom')->name('delete.room')->middleware('permission:room.list.delete');

        // Edit
        Route::get('/edit/roomnumber/{id}', 'EditRoomNumber')
            ->name('edit.roomnumber')->middleware('permission:room.list.edit');

        // Store
        Route::post('/store/room/number/{id}', 'StoreRoomNumber')
            ->name('store.room.number')->middleware('permission:room.list.create');

        // Update
        Route::post('/update/roomnumber/{id}', 'UpdateRoomNumber')
            ->name('update.roomnumber')->middleware('permission:room.list.update');

        // Delete
        Route::get('/delete/room/number/{id}', 'DeleteRoomNumber')->name('delete.room.number')->middleware('permission:room.list.delete');
    });

    // Admin Booking Management Routes
    Route::controller(AdminBookingController::class)->group(function () {
        Route::get('/booking/list', 'BookingList')->name('booking.list')->middleware('permission:booking.view');
        Route::get('/edit/booking/{id}', 'EditBooking')->name('edit_booking')->middleware('permission:booking.edit');
        Route::get('/download/invoice/{id}', 'DownloadInvoice')->name('download.invoice')->middleware('permission:booking.detail');
        Route::post('/update/booking/status/{id}', 'UpdateBookingStatus')->name('update.booking.status')->middleware('permission:booking.update');
        Route::post('/update/booking/{id}', 'UpdateBooking')->name('update.booking')->middleware('permission:booking.update');

        // Assign Room Routes
        Route::get('/assign_room/{id}', 'AssignRoom')->name('assign_room')->middleware('permission:booking.update');
        Route::get('/assign_room/store/{booking_id}/{room_number_id}', 'AssignRoomStore')->name('assign_room_store')->middleware('permission:booking.update');
        Route::get('/assign_room/delete/{id}', 'AssignRoomDelete')->name('assign_room_delete')->middleware('permission:booking.delete');
    });

    // Admin Room List Management Routes
    Route::controller(RoomListController::class)->group(function () {
        Route::get('/view/room/list', 'ViewRoomList')->name('view.room.list')->middleware('permission:room.list.view');
        Route::get('/add/room/list', 'AddRoomList')->name('add.room.list')->middleware('permission:room.list.create');
        Route::post('/store/room/list', 'StoreRoomList')->name('store.room.list')->middleware('permission:room.list.create');
    });

    // Smtp Setting Routes
    Route::controller(SettingController::class)->group(function () {
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting')->middleware('permission:smtp.setting.view');
        Route::post('/smtp/update', 'SmtpUpdate')->name('smtp.update')->middleware('permission:smtp.setting.update');
    });

    // Testimonials All Routes
    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/all/testimonial', 'index')->name('all.testimonial')->middleware('permission:testimonial.view');
        Route::get('/add/testimonial', 'create')->name('add.testimonial')->middleware('permission:testimonial.create');
        Route::post('/testimonial/store', 'store')->name('testimonial.store')->middleware('permission:testimonial.create');
        Route::get('/edit/testimonial/{id}', 'edit')->name('edit.testimonial')->middleware('permission:testimonial.edit');
        Route::post('/testimonial/update', 'update')->name('testimonial.update')->middleware('permission:testimonial.update');
        Route::get('/delete/testimonial/{id}', 'destroy')->name('delete.testimonial')->middleware('permission:testimonial.delete');
    });

    // Blog Category Routes
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog/category', 'BlogCategory')->name('blog.category')->middleware('permission:blog.category.view');
        Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category')->middleware('permission:blog.category.create');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory')->middleware('permission:blog.category.edit');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category')->middleware('permission:blog.category.edit');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category')->middleware('permission:blog.category.delete');
    });

    // Blog Posts All Routes
    Route::controller(BlogController::class)->group(function () {
        Route::get('/all/blog/post', 'AllBlogPost')->name('all.blog.post')->middleware('permission:blog.post.view');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post')->middleware('permission:blog.post.create');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post')->middleware('permission:blog.post.create');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post')->middleware('permission:blog.post.edit');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post')->middleware('permission:blog.post.edit');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post')->middleware('permission:blog.post.delete');
    });

    // Comment All Routes
    Route::controller(CommentController::class)->group(function () {
        Route::get('/all/comment', 'AllComment')->name('all.comment')->middleware('permission:comment.view');
        Route::post('/update/comment/status', 'UpdateCommentStatus')->name('update.comment.status')->middleware('permission:comment.approve');
    });

    // Booking Report All Routes
    Route::controller(ReportController::class)->group(function () {
        Route::get('/booking/report', 'BookingReport')->name('booking.report')->middleware('permission:booking.report.view');
        Route::post('/seach-by-date', 'SeachByDate')->name('seach-by-date')->middleware('permission:booking.report.filter');
    });

    // Site Setting Routes
    Route::controller(SettingController::class)->group(function () {
        Route::get('/site/setting', 'SiteSetting')->name('site.setting')->middleware('permission:site.setting.view');
        Route::post('/site/update', 'SiteUpdate')->name('site.update')->middleware('permission:site.setting.update');
    });

    // Gallery All Routes
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/all/gallery', 'index')->name('all.gallery')->middleware('permission:gallery.view');
        Route::get('/add/gallery', 'create')->name('add.gallery')->middleware('permission:gallery.create');
        Route::post('/store/gallery', 'store')->name('store.gallery')->middleware('permission:gallery.create');
        Route::get('/edit/gallery/{id}', 'edit')->name('edit.gallery')->middleware('permission:gallery.edit');
        Route::post('/update/gallery', 'update')->name('update.gallery')->middleware('permission:gallery.update');
        Route::get('/delete/gallery/{id}', 'destroy')->name('delete.gallery')->middleware('permission:gallery.delete');
        Route::post('/delete/gallery/multiple', 'DeleteGalleryMultiple')->name('delete.gallery.multiple')->middleware('permission:gallery.delete');
    });

    // Contact All Routes
    Route::controller(ContactController::class)->group(function () {
        Route::get('/contact/message', 'ContactMessage')->name('contact.message')->middleware('permission:contact.message.view');
    });

    // Notification All Routes
    Route::controller(AdminBookingController::class)->group(function () {
        Route::post('/mark-notification-as-read/{id}', 'MarkAsRead');
    });

    // Role and Permission All Routes
    Route::controller(RoleController::class)->group(function () {
        // Permission
        Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('permission:permission.view');
        Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('permission:permission.create');
        Route::post('/store/permission', 'StorePermission')->name('store.permission')->middleware('permission:permission.create');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('permission:permission.edit');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission')->middleware('permission:permission.edit');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('permission:permission.delete');
        Route::get('/import/permission', 'ImportPermission')->name('import.permission')->middleware('permission:permission.create');
        Route::get('/export/permission', 'ExportPermission')->name('export.permission')->middleware('permission:permission.view');
        Route::post('/import', 'Import')->name('import')->middleware('permission:permission.create');

        // Roles
        Route::get('/all/roles', 'AllRoles')->name('all.roles')->middleware('permission:role.view');
        Route::get('/add/roles', 'AddRoles')->name('add.roles')->middleware('permission:role.create');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles')->middleware('permission:role.create');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles')->middleware('permission:role.edit');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles')->middleware('permission:role.edit');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles')->middleware('permission:role.delete');

        // Roles In Permission
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('permission:role.assign');
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('permission:role.assign');
        Route::post('/roles/permission/store', 'RolesPermissionStore')->name('roles.permission.store')->middleware('permission:role.assign');
        Route::get('/edit/roles/permission/{id}', 'EditRolesPermission')->name('edit.roles.permission')->middleware('permission:role.assign');
        Route::post('/roles/permission/update/{id}', 'RolesPermissionUpdate')->name('roles.permission.update')->middleware('permission:role.assign');
        Route::get('/delete/roles/permission/{id}', 'DeleteRolesPermission')->name('delete.roles.permission')->middleware('permission:role.assign');
    });

    // Admin All Routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('permission:admin.view');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('permission:admin.create');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin')->middleware('permission:admin.create');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('permission:admin.edit');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin')->middleware('permission:admin.update');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('permission:admin.delete');
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
    Route::post('/store/contact', 'StoreContact')->name('store.contact');
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