# Booking Observer Pattern Implementation

## Tổng quan

Observer Pattern đã được triển khai cho hệ thống đặt phòng (Booking System) nhằm tách biệt logic nghiệp vụ khỏi các side effects như gửi email, thông báo, cập nhật phòng, v.v.

## Cấu trúc

```
app/Observers/Booking/
├── BookingObserverInterface.php    # Interface cho các Observer
├── BookingSubjectInterface.php     # Interface cho Subject
├── BookingSubject.php              # Concrete Subject - quản lý danh sách observers
├── BookingEventManager.php         # Singleton Manager - điểm truy cập chính
└── Observers/
    ├── EmailNotifierObserver.php       # Gửi email xác nhận
    ├── AdminNotifierObserver.php       # Thông báo cho admin
    └── RoomAvailabilityUpdaterObserver.php  # Cập nhật trạng thái phòng
```

## Các thành phần

### 1. BookingObserverInterface

Interface định nghĩa các phương thức mà tất cả observers phải implement:

- `created(Booking $booking)` - Khi booking được tạo
- `approved(Booking $booking)` - Khi booking được duyệt
- `cancelled(Booking $booking)` - Khi booking bị hủy

### 2. BookingSubject

Class quản lý danh sách observers và thông báo:

- `attach()` - Đăng ký observer
- `detach()` - Hủy đăng ký observer
- `notifyCreated()` - Thông báo khi booking được tạo
- `notifyApproved()` - Thông báo khi booking được duyệt
- `notifyCancelled()` - Thông báo khi booking bị hủy

### 3. BookingEventManager

Singleton Manager - điểm truy cập duy nhất để fire events:

- `getInstance()` - Lấy instance singleton
- `attach()` - Đăng ký observer
- `created()` - Fire event khi booking được tạo
- `approved()` - Fire event khi booking được duyệt
- `cancelled()` - Fire event khi booking bị hủy

### 4. Các Observer cụ thể

#### EmailNotifierObserver

- Không gửi email khi booking được tạo (chỉ gửi thông báo admin)
- Gửi email thông báo khi booking được duyệt (admin duyệt đơn)
- Gửi email thông báo khi booking bị hủy

#### AdminNotifierObserver

- Gửi thông báo database cho admin khi có booking mới (khi khách đặt phòng thành công)
- Không gửi thông báo khi booking được duyệt (chỉ gửi email cho khách)
- Không gửi thông báo khi booking bị hủy (chỉ gửi email cho khách)

#### RoomAvailabilityUpdaterObserver

- Tạo các ngày đã đặt (RoomBookedDate) khi booking được tạo
- Xóa các ngày đã đặt khi booking bị hủy

## Cách sử dụng

### Đăng ký Observers

Observers được đăng ký tự động trong `AppServiceProvider`:

```php
private function registerBookingObservers(): void
{
    $manager = BookingEventManager::getInstance();

    // Observer order matters: first update availability, then send notifications
    $manager->attach(new RoomAvailabilityUpdaterObserver);
    $manager->attach(new EmailNotifierObserver);
    $manager->attach(new AdminNotifierObserver);
}
```

### Fire Events trong Controllers

Thay vì gọi trực tiếp các hàm send mail, notification, tạo RoomBookedDate, bây giờ chỉ cần:

```php
// Khi booking được tạo
BookingEventManager::getInstance()->created($booking);

// Khi booking được duyệt
BookingEventManager::getInstance()->approved($booking);

// Khi booking bị hủy
BookingEventManager::getInstance()->cancelled($booking);
```

## Lợi ích

1. **Tách biệt concerns**: Logic nghiệp vụ (tạo/duyệt/hủy booking) tách biệt khỏi các side effects (email, notification, cập nhật phòng)

2. **Dễ mở rộng**: Thêm observer mới không cần sửa code controller, chỉ cần tạo class mới implement `BookingObserverInterface` và đăng ký trong `AppServiceProvider`

3. **Dễ bảo trì**: Mỗi observer chỉ lo một nhiệm vụ, code dễ đọc và dễ test

4. **Tuân thủ Single Responsibility Principle**: Mỗi class có một lý do để thay đổi

5. **Linh hoạt**: Có thể attach/detach observers động theo nhu cầu

## Ví dụ thêm Observer mới

```php
<?php

namespace App\Observers\Booking\Observers;

use App\Models\Booking;
use App\Observers\Booking\BookingObserverInterface;

class ReportUpdaterObserver implements BookingObserverInterface
{
    public function created(Booking $booking): void
    {
        // Cập nhật báo cáo doanh thu
    }

    public function approved(Booking $booking): void
    {
        // Cập nhật báo cáo khi booking được duyệt
    }

    public function cancelled(Booking $booking): void
    {
        // Cập nhật báo cáo khi booking bị hủy
    }
}
```

Sau đó đăng ký trong `AppServiceProvider`:

```php
$manager->attach(new ReportUpdaterObserver);
```

## Luồng nghiệp vụ chi tiết (Business Flow)

### Scenario 1: Khách hàng đặt phòng thành công

**Bước 1: Khách chọn phòng và thanh toán**

```
Frontend/BookingController::CheckoutStore()
├── Validate thông tin khách hàng
├── Tính tiền phòng, discount, addon
├── Xử lý thanh toán (Stripe/COD/PayPal/VNPay)
└── Tạo Booking mới (status = 0 - Pending)
    └── $booking->save()
```

**Bước 2: Fire event "created"**

```php
BookingEventManager::getInstance()->created($booking);
```

**Bước 3: Observer Pattern thực thi**

```
BookingSubject::notifyCreated($booking)
├── Observer 1: RoomAvailabilityUpdaterObserver::created()
│   ├── Parse check_in, check_out từ booking
│   ├── Tạo danh sách các ngày (CarbonPeriod)
│   └── Lưu vào RoomBookedDate table
│       ├── booking_id = $booking->id
│       ├── room_id = $booking->rooms_id
│       └── book_date = Y-m-d
│
├── Observer 2: EmailNotifierObserver::created()
│   └── KHÔNG gửi email (chỉ gửi khi admin duyệt)
│
└── Observer 3: AdminNotifierObserver::created()
    ├── Lấy danh sách admin (role = 'admin')
    ├── Lấy thông tin user đặt phòng
    └── Gửi notification database cho admin
        ├── message: 'Added new booking in Hotel'
        ├── user_image: $user->photo
        └── user_id: $booking->user_id
```

**Kết quả:**

- ✅ Phòng đã được đánh dấu là đã đặt (RoomBookedDate)
- ✅ Admin nhận được thông báo có booking mới
- ❌ Khách chưa nhận được email (chờ admin duyệt)

---

### Scenario 2: Admin duyệt đơn đặt phòng

**Bước 1: Admin xem danh sách booking và duyệt**

```
Backend/AdminBookingController::UpdateBookingStatus()
├── Tìm booking theo ID
├── Cập nhật payment_status và status = 1 (Complete)
└── $booking->save()
```

**Bước 2: Fire event "approved"**

```php
BookingEventManager::getInstance()->approved($booking);
```

**Bước 3: Observer Pattern thực thi**

```
BookingSubject::notifyApproved($booking)
├── Observer 1: RoomAvailabilityUpdaterObserver::approved()
│   └── Không làm gì (phòng đã được đánh dấu ở bước created)
│
├── Observer 2: EmailNotifierObserver::approved()
│   ├── Chuẩn bị data: check_in, check_out, name, email, phone
│   └── Gửi email cho khách qua BookConfirm mailable
│       └── Mail::to($booking->email)->send(new BookConfirm($data))
│
└── Observer 3: AdminNotifierObserver::approved()
    └── Không gửi thông báo (đã thông báo khi tạo booking)
```

**Kết quả:**

- ✅ Khách nhận được email xác nhận đặt phòng thành công
- ✅ Phòng vẫn giữ trạng thái đã đặt
- ❌ Admin không nhận thông báo thêm

---

### Scenario 3: Khách hủy đặt phòng

**Bước 1: Hệ thống hủy booking**

```
Booking::cancel() hoặc Admin hủy
├── $booking->status = 0 (hoặc giá trị hủy)
└── $booking->save()
```

**Bước 2: Fire event "cancelled"**

```php
BookingEventManager::getInstance()->cancelled($booking);
```

**Bước 3: Observer Pattern thực thi**

```
BookingSubject::notifyCancelled($booking)
├── Observer 1: RoomAvailabilityUpdaterObserver::cancelled()
│   ├── Xóa tất cả RoomBookedDate của booking này
│   │   └── RoomBookedDate::where('booking_id', $id)->delete()
│   └── Xóa tất cả BookingRoomList của booking này
│       └── BookingRoomList::where('booking_id', $id)->delete()
│
├── Observer 2: EmailNotifierObserver::cancelled()
│   ├── Chuẩn bị data: check_in, check_out, name, email, phone
│   └── Gửi email hủy cho khách
│       └── Mail::to($booking->email)->send(new BookConfirm($data))
│
└── Observer 3: AdminNotifierObserver::cancelled()
    └── Không gửi thông báo
```

**Kết quả:**

- ✅ Phòng được giải phóng (xóa RoomBookedDate)
- ✅ Khách nhận được email thông báo hủy
- ❌ Admin không nhận thông báo

---

### Luồng tổng quan (Flow Diagram)

```
┌─────────────────────────────────────────────────────────────────┐
│                    KHÁCH HÀNG ĐẶT PHÒNG                         │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  Controller: CheckoutStore / vnpayPayment / PaypalSuccess       │
│  - Tạo booking mới (status = 0)                                 │
│  - $booking->save()                                             │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│              BookingEventManager::created($booking)             │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                      OBSERVER PATTERN                           │
├─────────────────────────────────────────────────────────────────┤
│  1. RoomAvailabilityUpdaterObserver                             │
│     → Tạo RoomBookedDate (đánh dấu phòng đã đặt)                │
│                                                                 │
│  2. EmailNotifierObserver                                       │
│     → KHÔNG gửi email (chờ admin duyệt)                         │
│                                                                 │
│  3. AdminNotifierObserver                                       │
│     → Gửi thông báo database cho admin                          │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    ADMIN DUYỆT ĐƠN                              │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  Controller: UpdateBookingStatus                                │
│  - Cập nhật status = 1 (Complete)                               │
│  - $booking->save()                                             │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│            BookingEventManager::approved($booking)              │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                      OBSERVER PATTERN                           │
├─────────────────────────────────────────────────────────────────┤
│  1. RoomAvailabilityUpdaterObserver                             │
│     → Không làm gì (phòng đã đánh dấu)                          │
│                                                                 │
│  2. EmailNotifierObserver                                       │
│     → Gửi email xác nhận cho khách qua Mailtrap                 │
│                                                                 │
│  3. AdminNotifierObserver                                       │
│     → Không gửi thông báo (đã thông báo khi tạo)                │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│              KHÁCH NHẬN EMAIL XÁC NHẬN                          │
│              "Đặt phòng thành công!"                             │
└─────────────────────────────────────────────────────────────────┘
```

---

### Lợi ích của luồng này:

1. **Tách biệt rõ ràng**: Mỗi bước nghiệp vụ chỉ quan tâm đến business logic, còn side effects được xử lý bởi observers

2. **Dễ theo dõi**: Luồng từ Controller → Event Manager → Observers rất rõ ràng

3. **Dễ mở rộng**: Muốn thêm chức năng (ví dụ: gửi SMS, cập nhật CRM) chỉ cần tạo observer mới

4. **Dễ test**: Có thể test từng observer độc lập

5. **Maintainable**: Thay đổi logic email/notification không ảnh hưởng đến controller

## Testing

Để test observer, có thể mock các observer và verify chúng được gọi đúng:

```php
it('fires created event when booking is created', function () {
    $observer = mock(BookingObserverInterface::class);
    $observer->shouldReceive('created')->once();

    $manager = BookingEventManager::getInstance();
    $manager->attach($observer);

    $booking = Booking::factory()->create();
    $manager->created($booking);
});
```
