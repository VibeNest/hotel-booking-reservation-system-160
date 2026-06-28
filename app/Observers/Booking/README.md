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
