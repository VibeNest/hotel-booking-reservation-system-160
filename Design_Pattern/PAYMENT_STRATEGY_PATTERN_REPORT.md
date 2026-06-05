# BÁO CÁO REFACTORING: PAYMENT METHODS VỀ STRATEGY PATTERN

## 1. TỪ ĐÓ (TỔNG QUAN)

### 1.1 Mục tiêu

Chuyển đổi cách xử lý các phương thức thanh toán từ các giá trị string cứng (COD, Stripe, ...) và logic if/else lặp lại sang một thiết kế **Strategy Pattern** hiện đại, tăng cường khả năng mở rộng và dễ bảo trì.

### 1.2 Phạm vi áp dụng

- **Áp dụng cho**: Tất cả các phương thức thanh toán (COD, Stripe, VNPay, v.v.)
- **Refactor**: Payment Service Layer + Controllers
- **Giao thức**: Đổi tương tác thanh toán thành các strategy riêng biệt
- **Không thay đổi**: Database schema, Business logic core

---

## 2. VẤN ĐỀ TRƯỚC ĐÓ

### 2.1 Tình trạng hiện tại

```php
// Trước: Sử dụng magic strings + if/else rải rác
$method = 'COD'; // hoặc 'Stripe'

if ($method === 'COD') {
    // Xử lý COD
    $booking->status = 1;
    $booking->save();
} elseif ($method === 'Stripe') {
    // Xử lý Stripe
    $stripeClient = new StripeClient();
    $charge = $stripeClient->charges->create([...]);
    if ($charge->status === 'succeeded') {
        $booking->status = 1;
    }
} elseif ($method === 'VNPay') {
    // Xử lý VNPay
    // ...
}
```

### 2.2 Các vấn đề gặp phải

| Vấn đề                         | Mô tả                                               | Ảnh hưởng             |
| ------------------------------ | --------------------------------------------------- | --------------------- |
| **Magic Strings**              | Sử dụng 'COD', 'Stripe' trực tiếp trong code        | Khó trace, dễ typo    |
| **Logic rác rưởi (God Class)** | Tất cả logic thanh toán ở 1 method gigantic         | Khó maintain, bug     |
| **Không type-safe**            | Không validate phương thức thanh toán               | Lỗi runtime           |
| **Không extensible**           | Thêm phương thức mới → sửa if/else statement        | Chi phí cao           |
| **Code duplication**           | Logic thanh toán lặp lại ở nhiều controller/service | DRY principle vi phạm |
| **Khó testing**                | Cần mock nhiều dependencies, test cases phức tạp    | Coverage thấp         |
| **Tight Coupling**             | Controller phụ thuộc trực tiếp vào logic thanh toán | Khó refactor          |

### 2.3 Ví dụ vấn đề thực tế

```php
// Controller 1 - Booking
if ($paymentMethod === 'COD') {
    $booking->markAsCompleted();
} elseif ($paymentMethod === 'Stripe') {
    $charge = Stripe::charge(...);
    if ($charge) $booking->markAsCompleted();
}

// Controller 2 - Payment
switch($request->payment_method) {
    case 'cod':
        // ...
        break;
    case 'stripe':
        // ...
        break;
}

// Service - Invoice
public function generateInvoice($method) {
    if ($method == 'COD') {
        // Logic COD
    } elseif ($method == 'Stripe') {
        // Logic Stripe
    }
    // Ai quản lý consistency?
}
```

---

## 3. GIẢI PHÁP: STRATEGY PATTERN

### 3.1 Khái niệm Strategy Pattern

Strategy Pattern là một behavioral design pattern cho phép định nghĩa một tập hợp các thuật toán, đóng gói từng cái vào một lớp riêng biệt, và làm cho chúng có thể hoán đổi. Strategy cho phép thuật toán được thay đổi độc lập từ các client sử dụng nó.

### 3.2 Ưu điểm của Strategy Pattern

| Ưu điểm                    | Giải thích                                         |
| -------------------------- | -------------------------------------------------- |
| **Type-safe**              | Không có magic strings, tất cả được đóng gói class |
| **Separation of Concerns** | Mỗi payment method có logic riêng biệt             |
| **Single Responsibility**  | Mỗi strategy chỉ handle 1 phương thức thanh toán   |
| **Open/Closed Principle**  | Dễ thêm phương thức mới mà không sửa code cũ       |
| **Loose Coupling**         | Client không biết chi tiết implementation          |
| **Testability**            | Dễ unit test từng strategy riêng biệt              |
| **Reusability**            | Tái sử dụng strategy ở nhiều nơi                   |
| **Centralized Logic**      | Tất cả hành động của 1 payment method ở 1 chỗ      |

### 3.3 So sánh trước/sau

```php
// ❌ TRƯỚC
if ($method === 'COD') {
    $booking->status = 1;
    $booking->payment_method = 'COD';
} elseif ($method === 'Stripe') {
    $charge = Stripe::charge(...);
    if ($charge->status === 'succeeded') {
        $booking->status = 1;
    }
}

// ✅ SAU
$strategy = PaymentFactory::make($method);
$strategy->pay($paymentData);
```

---

## 4. KIẾN TRÚC THIẾT KẾ

### 4.1 Sơ đồ thành phần

```
┌─────────────────────────────────────────┐
│     Payment Processing (Controller)     │
│                                         │
│  - $method (string)                     │
│  + processPayment($method, $data)       │
└──────────────┬──────────────────────────┘
               │
               ├─────► PaymentFactory (Factory)
               │       - make($method): PaymentStrategy
               │       - Moostrap logic
               │
               └─────► PaymentStrategy (Interface)
                       ├─ CodStrategy
                       ├─ StripeStrategy
                       ├─ VNPayStrategy
                       └─ [Thêm strategies mới]
```

### 4.2 Luồng xử lý Payment

```
┌──────────────────┐
│   Client (UI)    │
│                  │
│  Submit Payment  │
│  Method: Stripe  │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────────────────┐
│   PaymentFactory::make('Stripe')     │
│                                      │
│  ← StripeStrategy instance           │
└────────┬─────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────┐
│   StripeStrategy->pay($data)         │
│                                      │
│   • Initialize Stripe Client         │
│   • Create charge                    │
│   • Handle response                  │
│   • Return status                    │
└────────┬─────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────┐
│   Update Booking Status              │
│                                      │
│   if (payment succeeded)             │
│     - Mark booking as completed      │
│     - Create invoice                 │
│     - Send notification              │
└──────────────────────────────────────┘
```

---

## 5. TRIỂN KHAI CHI TIẾT

### 5.1 Interface PaymentStrategy

**File**: `app/Contracts/PaymentStrategy.php`

```php
<?php

namespace App\Contracts;

interface PaymentStrategy
{
    /**
     * Thực hiện thanh toán
     *
     * @param array $data Dữ liệu thanh toán (amount, currency, booking_id, v.v.)
     * @return array Response: ['status' => 'success'|'failed', 'transaction_id' => '...', 'message' => '...']
     */
    public function pay(array $data);
}
```

**Mục đích**: Định nghĩa hợp đồng mà tất cả payment strategy class phải tuân theo.

---

### 5.2 Implementation: CodStrategy

**File**: `app/Services/Payment/CodStrategy.php`

```php
<?php

namespace App\Services\Payment;

use App\Contracts\PaymentStrategy;

class CodStrategy implements PaymentStrategy
{
    /**
     * Xử lý thanh toán COD (Cash On Delivery)
     *
     * @param array $data
     * @return array
     */
    public function pay(array $data): array
    {
        try {
            // COD logic: Chỉ tạo record, không xử lý payment
            // Payment sẽ được xác nhận khi khách hàng giao dịch trực tiếp

            $bookingId = $data['booking_id'];
            $amount = $data['amount'];

            // Log transaction
            \Illuminate\Support\Facades\Log::info('COD Payment Initiated', [
                'booking_id' => $bookingId,
                'amount' => $amount,
            ]);

            return [
                'status' => 'pending',
                'transaction_id' => 'COD_' . $bookingId . '_' . time(),
                'message' => 'Payment will be collected on delivery',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'transaction_id' => null,
                'message' => $e->getMessage(),
            ];
        }
    }
}
```

---

### 5.3 Implementation: StripeStrategy

**File**: `app/Services/Payment/StripeStrategy.php`

```php
<?php

namespace App\Services\Payment;

use App\Contracts\PaymentStrategy;
use Stripe\Stripe;
use Stripe\Charge;

class StripeStrategy implements PaymentStrategy
{
    /**
     * Xử lý thanh toán Stripe
     *
     * @param array $data
     * @return array
     */
    public function pay(array $data): array
    {
        try {
            // Khởi tạo Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            $amount = (int) ($data['amount'] * 100); // Stripe tính theo cents
            $token = $data['stripe_token']; // Token từ client

            // Tạo charge
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $data['currency'] ?? 'usd',
                'source' => $token,
                'description' => 'Booking #' . $data['booking_id'],
                'metadata' => [
                    'booking_id' => $data['booking_id'],
                ],
            ]);

            // Log
            \Illuminate\Support\Facades\Log::info('Stripe Payment Processed', [
                'booking_id' => $data['booking_id'],
                'charge_id' => $charge->id,
                'status' => $charge->status,
            ]);

            return [
                'status' => $charge->status === 'succeeded' ? 'success' : 'failed',
                'transaction_id' => $charge->id,
                'message' => $charge->status === 'succeeded'
                    ? 'Payment successful'
                    : 'Payment failed: ' . ($charge->failure_message ?? 'Unknown error'),
            ];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Stripe Payment Error', [
                'booking_id' => $data['booking_id'] ?? null,
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => 'failed',
                'transaction_id' => null,
                'message' => 'Payment processing error: ' . $e->getMessage(),
            ];
        }
    }
}
```

---

### 5.4 PaymentFactory

**File**: `app/Factories/PaymentFactory.php`

```php
<?php

namespace App\Factories;

use App\Contracts\PaymentStrategy;
use App\Services\Payment\CodStrategy;
use App\Services\Payment\StripeStrategy;
use InvalidArgumentException;

class PaymentFactory
{
    /**
     * Tạo payment strategy dựa trên payment method
     *
     * @param string $method
     * @return PaymentStrategy
     * @throws InvalidArgumentException
     */
    public static function make(string $method): PaymentStrategy
    {
        return match (strtoupper($method)) {
            'COD' => new CodStrategy(),
            'STRIPE' => new StripeStrategy(),
            // Thêm strategies mới ở đây
            // 'VNPAY' => new VNPayStrategy(),
            // 'PAYPAL' => new PayPalStrategy(),

            default => throw new InvalidArgumentException("Unsupported payment method: {$method}"),
        };
    }
}
```

**Mục đích**: Tập trung logic tạo strategy, dễ thêm payment method mới.

---

### 5.5 Cách sử dụng trong Controller

**File**: `app/Http/Controllers/PaymentController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Factories\PaymentFactory;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'payment_method' => 'required|string',
                'amount' => 'required|numeric|min:0.01',
                'stripe_token' => 'required_if:payment_method,Stripe|string',
            ]);

            // Lấy booking
            $booking = Booking::findOrFail($validated['booking_id']);

            // Factory tạo strategy
            $strategy = PaymentFactory::make($validated['payment_method']);

            // Xử lý payment
            $result = $strategy->pay([
                'booking_id' => $booking->id,
                'amount' => $validated['amount'],
                'currency' => 'usd',
                'stripe_token' => $validated['stripe_token'] ?? null,
            ]);

            // Cập nhật booking dựa trên kết quả
            if ($result['status'] === 'success') {
                $booking->update([
                    'status' => 1, // Completed
                    'payment_method' => $validated['payment_method'],
                    'transaction_id' => $result['transaction_id'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'booking_id' => $booking->id,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
```

---

## 6. HƯỚNG DẪN MỞ RỘNG

### 6.1 Thêm phương thức thanh toán mới

Giả sử muốn thêm **VNPay Strategy**:

**Bước 1**: Tạo class implement `PaymentStrategy`

```php
// app/Services/Payment/VNPayStrategy.php
<?php

namespace App\Services\Payment;

use App\Contracts\PaymentStrategy;

class VNPayStrategy implements PaymentStrategy
{
    public function pay(array $data): array
    {
        // Implement VNPay logic
        // ...
        return [...];
    }
}
```

**Bước 2**: Thêm vào Factory

```php
// app/Factories/PaymentFactory.php
public static function make(string $method): PaymentStrategy
{
    return match (strtoupper($method)) {
        'COD' => new CodStrategy(),
        'STRIPE' => new StripeStrategy(),
        'VNPAY' => new VNPayStrategy(), // ← Thêm dòng này

        default => throw new InvalidArgumentException(...),
    };
}
```

**Bước 3**: Kiểm thử

- Viết unit test cho `VNPayStrategy`
- Test factory tạo strategy đúng

---

## 7. LỢI ÍCH ĐẠT ĐƯỢC

| Lợi ích                     | Chi tiết                                            |
| --------------------------- | --------------------------------------------------- |
| **Dễ thêm phương thức mới** | Chỉ cần thêm 1 strategy class + 1 dòng ở factory    |
| **Dễ test**                 | Mock strategy riêng biệt, không cần mock toàn bộ hệ |
| **Dễ maintain**             | Logic mỗi payment method ở 1 chỗ                    |
| **Dễ reuse**                | Sử dụng strategy ở nhiều service/controller         |
| **Type-safe**               | Interface rõ ràng, IDE auto-complete                |
| **Giảm bug**                | Không có magic string, logic rõ ràng                |
| **Team productivity**       | Developer mới hiểu code nhanh hơn                   |

---

## 8. LƯỚI ĐỀ CẢI THIỆN SAU

- Thêm **Strategy caching** để tối ưu performance
- Implement **Payment event system** (PaymentProcessed, PaymentFailed)
- Thêm **Payment audit logging** cho compliance
- Implement **Retry logic** cho failed payments
- Thêm **Payment webhook handlers** cho Stripe/VNPay confirmation

---

## Kết luận

**Strategy Pattern** giải quyết bài toán quản lý nhiều phương thức thanh toán một cách elegant, flexible, và dễ mở rộng. Thiết kế này tuân theo **SOLID principles** và tăng chất lượng code đáng kể.
