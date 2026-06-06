# BÁO CÁO REFACTORING: FACILITY PRICING VỀ DECORATOR PATTERN

## 1. TỪ ĐÓ (TỔNG QUAN)

### 1.1 Mục tiêu

Chuyển đổi cách xử lý tính giá tiền facility add-ons từ logic if/else duyệt mảng cứng sang một thiết kế **Decorator Pattern** hiện đại, tăng cường khả năng mở rộng, tái sử dụng và dễ bảo trì.

### 1.2 Phạm vi áp dụng

- **Áp dụng cho**: Tính giá facility add-ons trong checkout
- **Refactor**: Service Layer (Pricing/)
- **Không thay đổi**: Database schema, Business logic core
- **Hiệu ứng**: View checkout + Admin edit booking

---

## 2. VẤN ĐỀ TRƯỚC ĐÓ

### 2.1 Tình trạng hiện tại (Nếu không dùng Decorator)

```php
// Cách cũ: Duyệt mảng và cộng trực tiếp
$total_price = $subtotal - $discount;

$selectedFacilities = $request->input('facility_addons', []);
$addon_fee = 0;

foreach ($selectedFacilities as $facility) {
    $addon_fee += config('facilities.fees.' . $facility);
}

$total_price += $addon_fee;
```

### 2.2 Các vấn đề gặp phải

| Vấn đề                         | Mô tả                                              | Ảnh hưởng             |
| ------------------------------ | -------------------------------------------------- | --------------------- |
| **Logic rác rưởi (God Class)** | Tất cả pricing logic ở 1 method gigantic           | Khó maintain, bug     |
| **Không extensible**           | Thêm loại add-on mới → phải sửa method             | Chi phí cao           |
| **Khó test**                   | Cần mock config, duyệt mảng; test case phức tạp    | Coverage thấp         |
| **Không reusable**             | Logic tính giá lặp lại ở checkout, admin, API      | DRY principle vi phạm |
| **Tight coupling**             | Controller phụ thuộc trực tiếp vào logic pricing   | Khó refactor          |
| **Không type-safe**            | Không validate loại add-on hợp lệ                  | Lỗi runtime           |
| **Khó thay đổi thuật toán**    | Muốn thêm discount/surcharge cho add-on → phức tạp | Linh hoạt thấp        |

### 2.3 Ví dụ vấn đề thực tế

```php
// Controller 1 - Checkout
$addon_fee = 0;
foreach ($request->facility_addons as $facility) {
    $addon_fee += config('facilities.fees.' . $facility);
}
$total = $subtotal - $discount + $addon_fee;

// Controller 2 - Admin Edit
$addon_fee = $booking->total_price - $booking->subtotal + $booking->discount;

// View 1 - Checkout
{{ $addon_fee }}

// View 2 - Invoice
{{ $total_price - $subtotal + $discount }}

// Service 1 - Payment
$price = applyFacility($basePrice, $facilities);

// Service 2 - Report
// ... khác nhau ở mỗi nơi!
```

---

## 3. GIẢI PHÁP: DECORATOR PATTERN

### 3.1 Khái niệm Decorator Pattern

Decorator Pattern là một structural design pattern cho phép attach thêm responsibilities vào một object một cách động. Decorator cung cấp một lựa chọn linh hoạt thay thế subclassing để mở rộng functionality.

**Đặc điểm:**

- Maintain single responsibility
- Có thể compose decorator bao lồng nhau (nested)
- Tương tự pipeline/middleware pattern

### 3.2 Ưu điểm của Decorator Pattern

| Ưu điểm                   | Giải thích                                         |
| ------------------------- | -------------------------------------------------- |
| **Flexible & Composable** | Kết hợp nhiều add-on mà không cần if/else          |
| **Single Responsibility** | Mỗi decorator chỉ handle 1 loại add-on             |
| **Open/Closed Principle** | Dễ thêm add-on mới mà không sửa code cũ            |
| **Reusable**              | Tái sử dụng ở checkout, admin, API, report         |
| **Type-safe**             | Tất cả implement interface chung, IDE auto-suggest |
| **Testable**              | Unit test từng decorator riêng biệt                |
| **Centralized Logic**     | Tất cả pricing logic nằm tại Pricing service       |
| **Maintainable**          | Khi thay đổi tính giá → chỉ sửa 1 chỗ              |

### 3.3 So sánh trước/sau

```php
// ❌ TRƯỚC
$total = $subtotal - $discount;
foreach ($facilities as $facility) {
    $total += config('facilities.fees.' . $facility);
}

// ✅ SAU
$total = FacilityPriceDecoratorBuilder::fromConfig()
    ->build(new BaseRoomPrice($subtotal - $discount), $facilities)
    ->total();
```

---

## 4. KIẾN TRÚC THIẾT KẾ

### 4.1 Sơ đồ thành phần

```
┌────────────────────────────────┐
│      RoomPrice (Interface)     │
│                                │
│  + total(): float              │
└────────────────────────────────┘
           △ implements
           │
           ├─────────────────────────────────┬──────────────────────┐
           │                                 │                      │
           │                                 │                      │
┌─────────────────────┐  ┌─────────────────────────────┐  ┌──────────────────┐
│   BaseRoomPrice     │  │  FacilityFeeDecorator       │  │  [Future Add-ons] │
│                     │  │                             │  │  (Tax, Insurance) │
│  - baseTotal: float │  │  - inner: RoomPrice         │  │                   │
│  + total()          │  │  - fee: float               │  │  + total()        │
└─────────────────────┘  │  + total()                  │  └──────────────────┘
                         │                             │
                         │  return inner.total() + fee │
                         └─────────────────────────────┘
                                     △
                                     │
                           Có thể bọc lòng vòng:
                    BaseRoomPrice
                         ↓
                   FacilityFeeDecorator (WiFi: $10)
                         ↓
                   FacilityFeeDecorator (Parking: $5)
                         ↓
                   FacilityFeeDecorator (Breakfast: $15)
```

### 4.2 Luồng xử lý Facility Pricing

```
┌────────────────────────┐
│ Checkout View (select) │
│                        │
│  WiFi, Parking, ...    │
└────────────┬───────────┘
             │
             ▼
┌──────────────────────────────────────┐
│   CheckoutController::store()        │
│                                      │
│   $selectedFacilities = request()    │
│   $baseTotal = subtotal - discount   │
└────────────┬─────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────────┐
│   applyFacilityPricing($request, $baseTotal)    │
│                                                  │
│   1. Create BaseRoomPrice($baseTotal)            │
│   2. Builder build(base, selectedFacilities)     │
│   3. Return decorated->total()                   │
└────────────┬─────────────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────────────────┐
│   FacilityPriceDecoratorBuilder::build()           │
│                                                     │
│   foreach (selectedFacilities as $facility) {      │
│       decorated = new FacilityFeeDecorator(        │
│           decorated,                              │
│           config('facilities.fees.' . $facility)  │
│       )                                            │
│   }                                                │
│                                                     │
│   return decorated                                 │
└────────────┬────────────────────────────────────────┘
             │
             ▼
┌──────────────────────────────┐
│   decorated->total()         │
│                              │
│   WiFi: 10                   │
│   Parking: 5                 │
│   Breakfast: 15              │
│   ─────────────────          │
│   Add-ons Total: 30          │
│   + Base: 100                │
│   = 130                      │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│   Booking::create()          │
│                              │
│   total_price = 130          │
│   subtotal = 100             │
│   discount = 0               │
│   addon_fee = 30 (tính toán) │
└──────────────────────────────┘
```

---

## 5. TRIỂN KHAI CHI TIẾT

### 5.1 Interface RoomPrice

**File**: `app/Services/Pricing/RoomPrice.php`

```php
<?php

namespace App\Services\Pricing;

interface RoomPrice
{
    /**
     * Get total price (base + all decorators)
     *
     * @return float
     */
    public function total(): float;
}
```

**Mục đích**: Định nghĩa hợp đồng mà tất cả pricing object phải tuân theo.

---

### 5.2 Base Implementation: BaseRoomPrice

**File**: `app/Services/Pricing/BaseRoomPrice.php`

```php
<?php

namespace App\Services\Pricing;

final class BaseRoomPrice implements RoomPrice
{
    public function __construct(private float $baseTotal) {}

    public function total(): float
    {
        return $this->baseTotal;
    }
}
```

**Mục đích**: Biểu diễn giá base (subtotal - discount) của phòng.

**Cách dùng**:

```php
$base = new BaseRoomPrice(100);
$base->total(); // 100
```

---

### 5.3 Decorator Implementation: FacilityFeeDecorator

**File**: `app/Services/Pricing/FacilityFeeDecorator.php`

```php
<?php

namespace App\Services\Pricing;

final class FacilityFeeDecorator implements RoomPrice
{
    public function __construct(
        private RoomPrice $inner,
        private float $fee
    ) {}

    public function total(): float
    {
        return $this->inner->total() + $this->fee;
    }
}
```

**Mục đích**: Bọc một RoomPrice khác rồi cộng thêm phí facility.

**Cách dùng**:

```php
$decorated = new FacilityFeeDecorator(
    new BaseRoomPrice(100),
    10 // WiFi fee
);
$decorated->total(); // 110
```

**Tính chất quan trọng**: Nó vẫn implement `RoomPrice`, nên có thể bọc decorator khác:

```php
$decorated = new FacilityFeeDecorator(
    new FacilityFeeDecorator(
        new BaseRoomPrice(100),
        10  // WiFi
    ),
    5   // Parking
);
$decorated->total(); // 115
```

---

### 5.4 Builder: FacilityPriceDecoratorBuilder

**File**: `app/Services/Pricing/FacilityPriceDecoratorBuilder.php`

```php
<?php

namespace App\Services\Pricing;

final class FacilityPriceDecoratorBuilder
{
    /**
     * @param  array<string, float|int>  $facilityFees
     */
    public function __construct(private array $facilityFees) {}

    public static function fromConfig(): self
    {
        return new self(config('facilities.fees', []));
    }

    /**
     * Build decorator chain từ selected facilities
     *
     * @param  array<int, mixed>  $selectedFacilities
     */
    public function build(RoomPrice $basePrice, array $selectedFacilities): RoomPrice
    {
        $decorated = $basePrice;

        foreach ($selectedFacilities as $facilityName) {
            if (!is_string($facilityName)) {
                continue;
            }

            if (!array_key_exists($facilityName, $this->facilityFees)) {
                continue;
            }

            $decorated = new FacilityFeeDecorator(
                $decorated,
                (float) $this->facilityFees[$facilityName]
            );
        }

        return $decorated;
    }
}
```

**Mục đích**: Tạo chain decorator từ danh sách facility đã chọn.

**Cách dùng**:

```php
$decorated = FacilityPriceDecoratorBuilder::fromConfig()
    ->build(
        new BaseRoomPrice(100),
        ['WiFi', 'Parking', 'Breakfast']
    );

$decorated->total(); // 100 + 10 + 5 + 15 = 130
```

---

### 5.5 Sử dụng trong Controller: BookingController

**File**: `app/Http/Controllers/Frontend/BookingController.php`

```php
private function applyFacilityPricing(Request $request, float $baseTotal): float
{
    $selectedFacilities = $request->input('facility_addons', []);

    if (! is_array($selectedFacilities)) {
        $selectedFacilities = [];
    }

    $decorated = FacilityPriceDecoratorBuilder::fromConfig()
        ->build(new BaseRoomPrice($baseTotal), $selectedFacilities);

    return $decorated->total();
}
```

**Cách dùng trong checkout**:

```php
// Calculate base total
$subtotal = $room->price * $nights * $number_of_rooms;
$discount = ($room->discount / 100) * $subtotal;
$baseTotal = $subtotal - $discount;

// Apply facility pricing
$total_price = $this->applyFacilityPricing($request, $baseTotal);

// Save to booking
$booking->total_price = $total_price;
$booking->save();
```

---

### 5.6 Hàm tính Add-ons Fee trong Model: Booking

**File**: `app/Models/Booking.php`

```php
/**
 * Get add-ons fee calculated from totals
 *
 * @return float
 */
public function getAddonFee(): float
{
    return (float) max(0, round($this->total_price - $this->subtotal + $this->discount, 2));
}
```

**Mục đích**: Reverse-calculate add-ons fee từ đã lưu booking data.

**Cách dùng**:

```php
$booking = Booking::find(1);
$addon_fee = $booking->getAddonFee(); // Tính từ total_price - subtotal + discount
```

---

### 5.7 Hiển thị trong View: edit_booking.blade.php

```blade
<tr>
    <td>Add-ons</td>
    <td class="text-primary">
        +${{ number_format($editData->getAddonFee(), 0) }}
    </td>
</tr>
```

---

## 6. KẾT QUẢ & HIỆU SUẤT

### 6.1 Ưu điểm đạt được

| Ưu điểm             | Trước                        | Sau                           |
| ------------------- | ---------------------------- | ----------------------------- |
| **Code dễ đọc**     | if/else duyệt mảng           | `->build()->total()`          |
| **Mở rộng**         | Sửa method khi thêm facility | Chỉ thêm config               |
| **Tái sử dụng**     | Lặp lại ở nhiều nơi          | 1 interface cho tất cả        |
| **Unit Test**       | Khó mock, test case phức tạp | Test decorator từng cái       |
| **Performance**     | O(n) duyệt mảng              | O(n) compose decorator (same) |
| **Maintainability** | Khó khi thay đổi logic tính  | Dễ, chỉ sửa decorator         |

### 6.2 Performance Analysis

- **Thời gian**: Không thay đổi, vẫn O(n) với n là số facility đã chọn
- **Bộ nhớ**: Minimal overhead từ object nesting (negligible)
- **Scalability**: Dễ thêm 100 loại add-on mà không ảnh hưởng

### 6.3 Trường hợp sử dụng

1. **Checkout**: Tính giá khi chọn add-on
2. **Admin Edit Booking**: Hiển thị tổng add-ons
3. **Invoice**: Liệt kê chi tiết từng add-on + tổng
4. **Report**: Thống kê revenue từ add-on
5. **API**: Return pricing details cho mobile/3rd-party

---

## 7. MỞ RỘNG TƯƠNG LAI

### 7.1 Thêm decorator mới

Nếu muốn thêm logic khác (tax, insurance, surcharge), chỉ cần:

```php
final class InsuranceFeeDecorator implements RoomPrice
{
    public function __construct(
        private RoomPrice $inner,
        private float $percentage
    ) {}

    public function total(): float
    {
        $base = $this->inner->total();
        return $base + ($base * $this->percentage / 100);
    }
}
```

Rồi dùng như bình thường:

```php
$decorated = new InsuranceFeeDecorator(
    FacilityPriceDecoratorBuilder::fromConfig()
        ->build(new BaseRoomPrice(100), $facilities),
    5 // 5% insurance
);
```

### 7.2 Middleware-style pipeline

Có thể xây builder pattern hơn:

```php
$total = FacilityPriceBuilder::create()
    ->withBase($basePrice)
    ->addFacility('WiFi')
    ->addFacility('Parking')
    ->addInsurance(5)
    ->total();
```

---

## 8. KIỂM THỬ & VALIDATION

### 8.1 Unit Test

**File**: `tests/Unit/Pricing/FacilityFeeDecoratorTest.php`

```php
it('adds facility fee to base price', function () {
    $base = new BaseRoomPrice(100);
    $decorated = new FacilityFeeDecorator($base, 10);

    expect($decorated->total())->toBe(110.0);
});

it('chains multiple decorators', function () {
    $decorated = new FacilityFeeDecorator(
        new FacilityFeeDecorator(
            new BaseRoomPrice(100),
            10
        ),
        5
    );

    expect($decorated->total())->toBe(115.0);
});

it('builds decorator chain from facilities array', function () {
    $builder = new FacilityPriceDecoratorBuilder([
        'WiFi' => 10,
        'Parking' => 5,
        'Breakfast' => 15,
    ]);

    $decorated = $builder->build(
        new BaseRoomPrice(100),
        ['WiFi', 'Parking']
    );

    expect($decorated->total())->toBe(115.0);
});
```

### 8.2 Integration Test

```php
it('applies facility pricing in checkout', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create(['price' => 100]);

    $response = $this->actingAs($user)->post(route('checkout.store'), [
        'name' => 'Test',
        'email' => 'test@example.com',
        'country' => 'Vietnam',
        'phone' => '123456789',
        'address' => '123 Test St',
        'state' => 'Test State',
        'zip_code' => '10000',
        'payment_method' => 'COD',
        'facility_addons' => ['WiFi', 'Parking'],
    ]);

    // Verify booking total includes add-ons
    $booking = Booking::latest()->first();
    expect($booking->total_price)->toBeGreaterThan($booking->subtotal - $booking->discount);
});
```

---

## 9. THAM KHẢO & TÀI LIỆU

- **Design Pattern**: https://refactoring.guru/design-patterns/decorator
- **Laravel Pattern**: Service Layer + Builder Pattern
- **Related Patterns**: Strategy (Payment), State (Booking Status), Factory

---

**Cập nhật**: 2026-06-06
**Tác giả**: Architecture Team
**Version**: 1.0
