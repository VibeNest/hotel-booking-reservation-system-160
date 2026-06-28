# Hotel Booking Reservation System

Hệ thống đặt phòng khách sạn được xây dựng bằng Laravel, hỗ trợ quản lý phòng, đặt phòng, thanh toán, phân quyền quản trị, nội dung website và báo cáo vận hành.

## Mục Lục

- [Giới thiệu](#giới-thiệu)
- [Tính năng chính](#tính-năng-chính)
- [Công nghệ sử dụng](#công-nghệ-sử-dụng)
- [Cấu trúc dự án](#cấu-trúc-dự-án)
- [Yêu cầu môi trường](#yêu-cầu-môi-trường)
- [Cài đặt dự án](#cài-đặt-dự-án)
- [Cấu hình môi trường](#cấu-hình-môi-trường)
- [Tài khoản mặc định](#tài-khoản-mặc-định)
- [Luồng nghiệp vụ](#luồng-nghiệp-vụ)
- [Kiểm thử](#kiểm-thử)
- [Ghi chú phát triển](#ghi-chú-phát-triển)

## Giới Thiệu

Hotel Booking Reservation System là một ứng dụng web đặt phòng khách sạn hoàn chỉnh. Người dùng có thể xem danh sách phòng, kiểm tra phòng trống, đặt phòng, chọn tiện ích bổ sung, thanh toán và tải hóa đơn. Quản trị viên có thể quản lý toàn bộ dữ liệu vận hành từ phòng, loại phòng, booking, gallery, blog, đánh giá, liên hệ, vai trò, quyền hạn đến cấu hình website.

Ứng dụng được tổ chức theo mô hình Laravel MVC, có tách lớp service cho thanh toán, upload ảnh, trạng thái booking, tính giá và các design pattern phục vụ mở rộng hệ thống.

## Tính Năng Chính

### Khách hàng

- Xem trang chủ, danh sách phòng, chi tiết phòng và thư viện ảnh.
- Tìm kiếm phòng theo ngày nhận phòng, ngày trả phòng, số khách và số lượng phòng.
- Kiểm tra tình trạng phòng trống trước khi đặt.
- Đăng ký, đăng nhập, cập nhật hồ sơ và đổi mật khẩu.
- Đặt phòng, chọn add-ons/tiện ích bổ sung và nhập thông tin thanh toán.
- Thanh toán bằng COD, Stripe, PayPal hoặc VNPay.
- Xem lịch sử đặt phòng và tải hóa đơn PDF.
- Đọc blog, tìm kiếm bài viết, xem bài theo danh mục và gửi bình luận.
- Gửi thông tin liên hệ đến khách sạn.

### Quản trị viên

- Dashboard quản trị riêng cho admin.
- Quản lý hồ sơ admin và đổi mật khẩu.
- Quản lý loại phòng, danh sách phòng, số phòng, ảnh đại diện và nhiều ảnh chi tiết.
- Quản lý booking: xem, chỉnh sửa, cập nhật trạng thái, gán phòng và tải hóa đơn.
- Quản lý ngày đã đặt để tránh trùng lịch phòng.
- Quản lý tiện ích bổ sung/add-ons.
- Quản lý đội ngũ, testimonials, book area, gallery, blog category, blog post và comment.
- Quản lý tin nhắn liên hệ.
- Quản lý SMTP, thông tin website và thiết lập hiển thị.
- Quản lý admin, role, permission và gán quyền theo Spatie Permission.
- Import/export permission bằng Excel.
- Lọc báo cáo booking theo ngày.
- Nhận notification khi khách đặt phòng thành công.

### Phân quyền

- Hỗ trợ các vai trò: `admin`, `instructor`, `user`.
- Middleware kiểm tra role và permission.
- Permission được chia theo nhóm chức năng như Booking, Room List, Gallery, Blog, Setting, Admin Management, Role and Permission.

## Công Nghệ Sử Dụng

| Nhóm | Công nghệ |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, Vite, Tailwind CSS, Alpine.js, Bootstrap assets |
| Database | MySQL |
| Auth | Laravel Breeze |
| Permission | Spatie Laravel Permission |
| Payment | COD, Stripe, PayPal, VNPay/Omnipay |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |
| Image | Intervention Image |
| Test | Pest, PHPUnit |

## Cấu Trúc Dự Án

```text
app/
├── Contracts/          # Contract cho payment strategy
├── Context/            # Payment context
├── Factories/          # Factory khởi tạo payment strategy
├── Http/Controllers/   # Controller frontend, backend, auth, admin
├── Http/Middleware/    # Middleware role, auth, redirect
├── Models/             # Eloquent models
├── Notifications/      # Notification khi booking hoàn tất
├── Services/           # Image upload, booking state, payment, pricing
├── Specifications/     # Điều kiện lọc/tìm phòng
└── States/             # State pattern cho trạng thái booking

database/
├── migrations/         # Cấu trúc bảng
├── seeders/            # Dữ liệu mẫu, user, permission, add-ons
└── factories/          # Factory phục vụ test/dữ liệu mẫu

resources/views/
├── frontend/           # Giao diện khách hàng
├── backend/            # Giao diện quản trị nghiệp vụ
├── admin/              # Layout/dashboard admin
├── auth/               # Login/register/reset password
└── mail/               # Template email

routes/
├── web.php             # Route chính của hệ thống
├── auth.php            # Route xác thực
└── console.php         # Console routes

Design_Pattern/         # Báo cáo/tài liệu các design pattern đã áp dụng
tests/                  # Feature test và unit test
```

## Yêu Cầu Môi Trường

- PHP `^8.2`
- Composer
- Node.js và npm
- MySQL
- Extension PHP phổ biến cho Laravel: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `ctype`, `json`, `tokenizer`, `xml`

## Cài Đặt Dự Án

Clone source code và cài dependency:

```bash
composer install
npm install
```

Tạo file môi trường:

```bash
cp .env.example .env
php artisan key:generate
```

Cấu hình database trong `.env`, sau đó chạy migration và seed dữ liệu:

```bash
php artisan migrate --seed
```

Build asset frontend:

```bash
npm run build
```

Chạy dự án ở môi trường local:

```bash
php artisan serve
npm run dev
```

Hoặc dùng script có sẵn để chạy server, queue và Vite cùng lúc:

```bash
composer run dev
```

Truy cập ứng dụng tại:

```text
http://127.0.0.1:8000
```

## Cấu Hình Môi Trường

### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_booking_reservation_system
DB_USERNAME=root
DB_PASSWORD=
```

### Queue và session

Ứng dụng đang dùng database cho session và queue:

```env
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

Khi xử lý notification/queue trong môi trường phát triển, có thể chạy:

```bash
php artisan queue:listen --tries=1
```

### Mail/SMTP

Mặc định `.env.example` dùng mail log. Nếu muốn gửi email thật, cấu hình lại:

```env
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Ngoài ra admin có thể cập nhật SMTP trong màn hình quản trị.

### PayPal

```env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=
PAYPAL_SANDBOX_CLIENT_SECRET=
PAYPAL_CURRENCY=USD
```

### VNPay

```env
VNP_TMN_CODE=
VNP_HASH_SECRET=
VNP_RETURN_URL="${APP_URL}/vnpay-return"
VNP_TEST_MODE=true
VNP_CURRENCY=VND
VNP_LOCALE=vi
```

### Stripe

Stripe được xử lý qua `stripe/stripe-php` và `StripeStrategy`. Hãy bổ sung khóa Stripe trong `.env` theo cấu hình thực tế của dự án trước khi chạy thanh toán thật.

## Tài Khoản Mặc Định

Sau khi chạy seeder, hệ thống tạo sẵn các tài khoản:

| Vai trò | Email | Mật khẩu |
| --- | --- | --- |
| Admin | `admin@gmail.com` | `12345678` |
| Instructor | `instructor@gmail.com` | `12345678` |
| User | `user@gmail.com` | `12345678` |
| Test User | `test@example.com` | Theo factory mặc định |

Trang đăng nhập admin:

```text
/admin/login
```

## Luồng Nghiệp Vụ

### Đặt phòng

1. Khách hàng chọn phòng và nhập ngày nhận/trả phòng.
2. Hệ thống kiểm tra số phòng còn trống theo `RoomBookedDate`.
3. Thông tin booking tạm thời được lưu vào session.
4. Khách hàng vào checkout, chọn tiện ích bổ sung và phương thức thanh toán.
5. Hệ thống tính tổng tiền theo số đêm, số phòng, giảm giá và add-ons.
6. Booking được tạo, ngày đặt phòng được ghi nhận, admin nhận notification.
7. Khách hàng xem trang đặt phòng thành công và có thể tải hóa đơn.

### Thanh toán

- `COD`: ghi nhận booking với trạng thái thanh toán theo chiến lược COD.
- `Stripe`: xử lý token Stripe qua `StripeStrategy`.
- `PayPal`: tạo order, redirect sang PayPal, capture thanh toán khi quay lại.
- `VNPay`: tạo giao dịch VNPay, kiểm tra chữ ký callback, cập nhật trạng thái thanh toán.

### Quản trị booking

1. Admin vào danh sách booking.
2. Xem chi tiết, cập nhật thông tin hoặc trạng thái booking.
3. Gán số phòng cụ thể cho booking.
4. Tải invoice PDF khi cần.
5. Lọc báo cáo booking theo khoảng ngày.

## Design Pattern Đã Áp Dụng

Dự án có thư mục `Design_Pattern/` ghi lại các pattern đã triển khai:

- Strategy Pattern cho thanh toán.
- State Pattern cho trạng thái booking.
- Decorator Pattern cho tính giá phòng và phí tiện ích.
- Specification Pattern cho tìm kiếm/kiểm tra phòng.
- Proxy Pattern cho upload ảnh.
- Template Method cho CRUD/report.

Các phần code liên quan nằm trong `app/Services`, `app/States`, `app/Specifications`, `app/Contracts`, `app/Context` và `app/Factories`.

## Kiểm Thử

Chạy toàn bộ test:

```bash
php artisan test
```

Hoặc dùng script Composer:

```bash
composer test
```

Một số nhóm test hiện có:

- Booking checkout flow.
- Booking state.
- Pricing decorator.
- Multi image.
- Team feature.

## Ghi Chú Phát Triển

- Không commit file `.env` thật lên repository.
- Kiểm tra kỹ khóa thanh toán trước khi dùng môi trường live.
- Khi thêm chức năng admin mới, nên bổ sung permission tương ứng trong `PermissionSeeder`.
- Khi thêm route admin, nên gắn middleware `auth`, `roles:admin` và permission phù hợp.
- Khi thay đổi logic booking/thanh toán, nên bổ sung feature test để tránh lỗi trùng lịch hoặc sai trạng thái thanh toán.

## License

Dự án dùng nền tảng Laravel và có thể tùy chỉnh license theo yêu cầu triển khai thực tế.
