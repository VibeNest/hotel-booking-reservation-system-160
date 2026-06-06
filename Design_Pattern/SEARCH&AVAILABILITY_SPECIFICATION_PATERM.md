# BÁO CÁO REFACTORING: ROOM SEARCH & AVAILABILITY VỀ SPECIFICATION PATTERN

## 1. TỔNG QUAN

### 1.1 Mục tiêu

Chuyển đổi logic tìm kiếm phòng từ việc xử lý nhiều điều kiện trực tiếp trong Controller sang mô hình **Specification Pattern**, giúp hệ thống dễ mở rộng, dễ bảo trì và tuân thủ các nguyên tắc thiết kế hướng đối tượng.

### 1.2 Phạm vi áp dụng

- Áp dụng cho chức năng tìm kiếm phòng
- Kiểm tra phòng còn trống
- Tìm kiếm theo ngày nhận/trả phòng
- Tìm kiếm theo số lượng khách
- Refactor Controller Layer
- Không thay đổi Database Schema

---

## 2. VẤN ĐỀ TRƯỚC ĐÓ

### 2.1 Tình trạng hiện tại

Trong `FrontendRoomController`, method `BookingSearch()` đang thực hiện toàn bộ logic:

- Xử lý khoảng thời gian
- Tìm booking bị trùng ngày
- Tính số phòng còn trống
- Kiểm tra sức chứa phòng
- Lọc danh sách phòng
- Phân trang

Ví dụ:

```php
foreach ($rooms as $room) {

    $total_persons =
        $room->total_adult +
        $room->total_child;

    if (
        $available_room > 0 &&
        $request->person <= $total_persons
    ) {

        $availableRooms[] = $room;
    }
}
```

---

### 2.2 Các vấn đề gặp phải

| Vấn đề          | Mô tả                                            |
| --------------- | ------------------------------------------------ |
| God Method      | Controller chứa quá nhiều business logic         |
| Khó mở rộng     | Thêm điều kiện tìm kiếm phải sửa controller      |
| Vi phạm OCP     | Mỗi điều kiện mới đều sửa code cũ                |
| Khó kiểm thử    | Logic bị dính chặt vào controller                |
| Khó tái sử dụng | Không dùng lại được điều kiện tìm kiếm           |
| Coupling cao    | Controller phụ thuộc trực tiếp vào mọi điều kiện |

---

### 2.3 Ví dụ thực tế

```php
if (
    $available_room > 0 &&
    $request->person <= $total_persons
) {
    $availableRooms[] = $room;
}
```

Sau này nếu muốn thêm:

- Search theo giá
- Search theo loại phòng
- Search theo tiện nghi

thì controller sẽ ngày càng dài.

---

## 3. GIẢI PHÁP: SPECIFICATION PATTERN

### 3.1 Khái niệm

Specification Pattern là một Design Pattern dùng để đóng gói các điều kiện nghiệp vụ thành các đối tượng riêng biệt.

Mỗi điều kiện được biểu diễn bằng một Specification.

Các Specification có thể kết hợp với nhau bằng:

- AND
- OR
- NOT

để tạo ra các điều kiện phức tạp.

---

### 3.2 Vì sao phù hợp

Chức năng Availability là tập hợp nhiều điều kiện:

```text
Room Available

=
Available Date
AND
Capacity Match
```

Mỗi điều kiện có thể tách riêng thành một Specification.

---

### 3.3 So sánh trước/sau

#### Trước

```php
if (
    $available_room > 0 &&
    $request->person <= $total_persons
) {
    $availableRooms[] = $room;
}
```

#### Sau

```php
$specification = new AndSpecification(
    new AvailableDateSpecification(
        $checkIn,
        $checkOut
    ),
    new CapacitySpecification(
        $person
    )
);

if ($specification->isSatisfiedBy($room)) {
    $filteredRooms[] = $room;
}
```

---

## 4. KIẾN TRÚC THIẾT KẾ

### 4.1 Sơ đồ thành phần

```text
FrontendRoomController
            |
            v
     AndSpecification
        /       \
       /         \
      v           v

AvailableDate   Capacity
Specification   Specification

        ^
        |
RoomSpecification
(Interface)
```

---

### 4.2 Luồng xử lý

```text
User Search

      |
      v

BookingSearch()

      |
      v

AndSpecification

      |
      +-------------------+
      |                   |
      v                   v

AvailableDate      Capacity
Specification      Specification

      |
      v

Kết quả tìm kiếm
```

---

## 5. TRIỂN KHAI CHI TIẾT

### 5.1 RoomSpecification Interface

```php
interface RoomSpecification
{
    public function isSatisfiedBy(Room $room): bool;
}
```

Mục đích:

Định nghĩa hợp đồng cho tất cả Specification.

---

### 5.2 CapacitySpecification

```php
class CapacitySpecification
    implements RoomSpecification
{
    public function isSatisfiedBy(Room $room): bool
    {
        $capacity =
            $room->total_adult +
            $room->total_child;

        return $this->person <= $capacity;
    }
}
```

Mục đích:

Kiểm tra số lượng khách có phù hợp với sức chứa phòng hay không.

---

### 5.3 AvailableDateSpecification

```php
class AvailableDateSpecification
    implements RoomSpecification
{
    public function isSatisfiedBy(Room $room): bool
    {
        return $availableRoom > 0;
    }
}
```

Mục đích:

Kiểm tra phòng còn trống trong khoảng thời gian người dùng chọn.

---

### 5.4 AndSpecification

```php
class AndSpecification
    implements RoomSpecification
{
    public function isSatisfiedBy(Room $room): bool
    {
        foreach (
            $this->specifications
            as $spec
        ) {

            if (
                !$spec->isSatisfiedBy($room)
            ) {
                return false;
            }
        }

        return true;
    }
}
```

Mục đích:

Kết hợp nhiều Specification bằng toán tử AND.

---

### 5.5 Sử dụng trong Controller

```php
$specification = new AndSpecification(
    new AvailableDateSpecification(
        $request->check_in,
        $request->check_out
    ),

    new CapacitySpecification(
        $request->person
    )
);
```

```php
foreach ($allRooms as $room) {

    if (
        $specification
            ->isSatisfiedBy($room)
    ) {

        $filteredRooms[] = $room;
    }
}
```

---

## 6. HƯỚNG DẪN MỞ RỘNG

### Thêm PriceSpecification

```php
class PriceSpecification
    implements RoomSpecification
{
    public function isSatisfiedBy(
        Room $room
    ): bool {

        return $room->price
            <= $this->maxPrice;
    }
}
```

Sử dụng:

```php
new AndSpecification(
    new AvailableDateSpecification(...),
    new CapacitySpecification(...),
    new PriceSpecification(...)
);
```

---

### Thêm FacilitySpecification

```php
class FacilitySpecification
    implements RoomSpecification
{
    public function isSatisfiedBy(
        Room $room
    ): bool {

        return $room
            ->facilities
            ->contains(
                $this->facility
            );
    }
}
```

---

## 7. LỢI ÍCH ĐẠT ĐƯỢC

| Lợi ích       | Mô tả                                              |
| ------------- | -------------------------------------------------- |
| Dễ mở rộng    | Thêm điều kiện mới bằng cách tạo Specification mới |
| Dễ bảo trì    | Logic được tách riêng                              |
| Tái sử dụng   | Specification dùng được ở nhiều nơi                |
| Tuân thủ OCP  | Không sửa code cũ khi thêm điều kiện               |
| Dễ kiểm thử   | Unit Test từng Specification                       |
| Giảm Coupling | Controller không chứa business logic               |

---

## 8. HƯỚNG PHÁT TRIỂN

Có thể bổ sung:

- PriceSpecification
- RoomTypeSpecification
- FacilitySpecification
- RatingSpecification
- OrSpecification
- NotSpecification

để xây dựng hệ thống tìm kiếm phòng linh hoạt hơn.

---

## KẾT LUẬN

Specification Pattern giúp tách biệt các điều kiện tìm kiếm phòng thành các đối tượng độc lập. Thiết kế này làm cho chức năng Search & Availability trở nên dễ mở rộng, dễ bảo trì và phù hợp với các nguyên tắc SOLID, đặc biệt là Open/Closed Principle.
