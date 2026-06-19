# BÁO CÁO REFACTORING: PROXY PATTERN CHO UPLOAD ẢNH

## 1. TỔNG QUAN

### 1.1 Mục tiêu

Tách toàn bộ logic xử lý filesystem ảnh (upload, resize, cover, delete) khỏi các controller vào một **Proxy Service** tập trung. Proxy Pattern cung cấp một lớp gián tiếp (surrogate) kiểm soát quyền truy cập đến filesystem, giúp:

- Loại bỏ code lặp `ImageManager` ở 6 controller khác nhau
- Tập trung xử lý lỗi, kiểm tra tồn tại, tạo thư mục vào một chỗ
- Dễ dàng swap storage (local → S3) sau này
- Dễ kiểm thử (mock proxy thay vì mock file)

### 1.2 Phạm vi áp dụng

| | |
|---|---|
| **Proxy** | `app/Services/ImageUploadProxy.php` — service mới |
| **Controller sửa** | `CrudController`, `AdminController`, `UserController`, `BlogController`, `SettingController`, `RoomController` |
| **Controller con kế thừa** | `TeamController`, `BookAreaController`, `Testimonial`, `Gallery` — không đổi (dùng qua CrudController) |
| **Không thay đổi** | Views (.blade), Routes, Models, Database schema, Business logic |

---

## 2. VẤN ĐỀ TRƯỚC ĐÓ

### 2.1 Code lặp ImageManager

Trước refactoring, **4 controller khác nhau** tự new `ImageManager(new Driver)`:

```php
// BlogController::StoreBlogPost
$manager = new ImageManager(new Driver);
$img = $manager->read($image);
$img->resize(550, 370)->save(public_path('upload/posts/'.$name_gen));

// SettingController::SiteUpdate
$manager = new ImageManager(new Driver());
$img = $manager->read($image);
$img->resize(110, 44)->save(public_path('upload/site/'.$name_gen));

// RoomController::UpdateRoom (main image)
$manager = new ImageManager(new Driver);
$manager->read($image)->cover(550, 850)->save($path.$name);

// RoomController::UpdateRoom (multi image)
$manager = new ImageManager(new Driver);
$manager->read($img)->save($path.$name);
```

### 2.2 Code lặp xóa ảnh

Mỗi controller tự xóa ảnh cũ với cách khác nhau (`unlink`, `File::delete`, `@unlink`):

```php
// AdminController
if ($oldPhoto && file_exists(public_path('upload/admin_images/'.$oldPhoto))) {
    unlink(public_path('upload/admin_images/'.$oldPhoto));
}

// BlogController
if ($post->post_image && file_exists(public_path($post->post_image))) {
    unlink(public_path($post->post_image));
}

// RoomController
if (! empty($room->image) && File::exists($path.$room->image)) {
    File::delete($path.$room->image);
}
```

### 2.3 Kiểm tra thư mục rải rác

```php
// RoomController
$path = public_path('upload/room_images/');
if (! File::exists($path)) {
    File::makeDirectory($path, 0777, true);
}
```

### 2.4 Tổng hợp code lặp

| Loại lặp | Số chỗ | File bị ảnh hưởng |
|---|---|---|
| `new ImageManager(new Driver)` | **5** | CrudController, BlogController, SettingController, RoomController (×2) |
| `hexdec(uniqid())` filename gen | **4** | CrudController, BlogController, SettingController (×2) |
| `file_exists(public_path(...))` + `unlink` | **5** | AdminController, UserController, BlogController, SettingController, CrudController |
| `File::exists` + `File::delete` | **2** | RoomController (×2) |
| `File::makeDirectory` / `File::ensureDirectoryExists` | **3** | CrudController, RoomController (×2) |

---

## 3. GIẢI PHÁP: PROXY PATTERN

### 3.1 Khái niệm

**Proxy Pattern** là một structural design pattern cung cấp một đối tượng thay thế (surrogate) kiểm soát truy cập đến đối tượng thật. Trong trường hợp này:

- **RealSubject**: Filesystem + ImageManager (thao tác I/O thật)
- **Proxy** (`ImageUploadProxy`): Lớp trung gian che giấu details của filesystem
- **Client**: 6 controller (Admin, User, Blog, Setting, Room, CrudController)

### 3.2 Sơ đồ thành phần

```
┌─────────────────────────────────────────────────────────────────────┐
│                        Controller Clients                           │
├──────────────────┬──────────┬──────────┬──────────┬─────────────────┤
│  AdminController │UserCtrl  │BlogCtrl  │SettingCtrl│  RoomController │
│  CrudController  │          │          │           │                 │
└────────┬─────────┴────┬─────┴────┬─────┴─────┬─────┴────────┬────────┘
         │              │          │           │              │
         │        $this->imageProxy->upload/move/delete()
         ▼              ▼          ▼           ▼              ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    ImageUploadProxy (PROXY)                          │
├─────────────────────────────────────────────────────────────────────┤
│  + upload($file, $folder, $width, $height, $method, $filename)      │
│      → filename only  (dùng ImageManager: resize/cover)             │
│  + move($file, $folder, $filename)                                  │
│      → filename only  (chỉ move, không xử lý)                       │
│  + delete($path) → void                                             │
│      → kiểm tra tồn tại + unlink                                    │
├─────────────────────────────────────────────────────────────────────┤
│  - ensureDirectory(string $folder): void                             │
│  - processImage($file, $folder, $filename, ...): void               │
└──────────────────────────┬──────────────────────────────────────────┘
                           │
                           ▼
┌──────────────────────────────────────────────────────────────────────┐
│                   Filesystem (RealSubject)                           │
├──────────────────────────────────────────────────────────────────────┤
│  public_path() + File::ensureDirectoryExists()                       │
│  + ImageManager::read()->resize()/cover()->save()                    │
│  + UploadedFile::move()                                              │
│  + unlink()                                                          │
└──────────────────────────────────────────────────────────────────────┘
```

### 3.3 Luồng xử lý upload (ví dụ: BlogController)

```
User POST /blog/store
       │
       ▼
BlogController::StoreBlogPost()
       │
       ▼
$request->file('post_image')
       │
       ▼
$this->imageProxy->upload($image, 'upload/posts', 550, 370)
       │
       ▼
┌─────────────────────────────────────────────────────┐
│  1. Tạo filename: hexdec(uniqid()).ext              │
│  2. Đảm bảo thư mục: File::ensureDirectoryExists()  │
│  3. Resize: ImageManager::read()->resize(550, 370)  │
│  4. Save file: $img->save()                         │
│  5. Return filename                                 │
└─────────────────────────────────────────────────────┘
       │
       ▼
'upload/posts/' . $filename → lưu vào DB
```

---

## 4. TRIỂN KHAI CHI TIẾT

### 4.1 Proxy Service: ImageUploadProxy

**File**: `app/Services/ImageUploadProxy.php`

```php
class ImageUploadProxy
{
    // Upload có xử lý ảnh (resize/cover) → return filename
    public function upload(
        UploadedFile $file,
        string $folder,
        int $width,
        int $height,
        string $method = 'resize',
        ?string $filename = null
    ): string;

    // Upload không xử lý (chỉ move) → return filename
    public function move(
        UploadedFile $file,
        string $folder,
        ?string $filename = null
    ): string;

    // Xóa file ảnh (kiểm tra tồn tại + unlink)
    public function delete(string $path): void;
}
```

### 4.2 Thay đổi ở các Controller

#### CrudController

Helper methods `uploadImage()` và `deleteImageFile()` được giữ nguyên API (backward compatible) nhưng nội bộ gọi proxy:

```php
// TRƯỚC: tự new ImageManager + resize + save
$name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
$manager = new ImageManager(new Driver);
$img = $manager->read($file);
$img->cover(550, 670)->save(public_path('upload/team/'.$name_gen));
return 'upload/team/'.$name_gen;

// SAU: delegate to proxy
$filename = $this->imageUploadProxy->upload($file, $folder, $width, $height, $method);
return $folder . '/' . $filename;
```

4 controller con (Team, BookArea, Testimonial, Gallery) **không thay đổi** — vẫn gọi `$this->uploadImage()` như cũ.

#### AdminController, UserController

```php
// TRƯỚC:
if ($oldPhoto && file_exists(public_path('upload/admin_images/'.$oldPhoto))) {
    unlink(public_path('upload/admin_images/'.$oldPhoto));
}
$file = $request->file('photo');
$filename = date('YmdHi').'-'.$file->getClientOriginalName();
$file->move(public_path('upload/admin_images'), $filename);
$data->photo = $filename;

// SAU:
if ($oldPhoto) {
    $this->imageProxy->delete('upload/admin_images/'.$oldPhoto);
}
$file = $request->file('photo');
$filename = date('YmdHi').'-'.$file->getClientOriginalName();
$this->imageProxy->move($file, 'upload/admin_images', $filename);
$data->photo = $filename;
```

#### BlogController

```php
// TRƯỚC:
$manager = new ImageManager(new Driver);
$img = $manager->read($image);
$img->resize(550, 370)->save(public_path('upload/posts/'.$name_gen));
$save_url = 'upload/posts/'.$name_gen;

// SAU:
$save_url = 'upload/posts/'.$this->imageProxy->upload($image, 'upload/posts', 550, 370);
```

#### SettingController

```php
// TRƯỚC:
$manager = new ImageManager(new Driver());
$img = $manager->read($image);
$img->resize(110, 44)->save(public_path('upload/site/'.$name_gen));
$save_url = 'upload/site/'.$name_gen;

// SAU:
$save_url = 'upload/site/'.$this->imageProxy->upload($image, 'upload/site', 110, 44);
```

#### RoomController

```php
// TRƯỚC (main image):
$path = public_path('upload/room_images/');
if (! File::exists($path)) { File::makeDirectory($path, 0777, true); }
if (! empty($room->image) && File::exists($path.$room->image)) {
    File::delete($path.$room->image);
}
$name = uniqid().'.'.$image->getClientOriginalExtension();
if (app()->environment('testing')) {
    $image->move($path, $name);
} else {
    $manager = new ImageManager(new Driver);
    $manager->read($image)->cover(550, 850)->save($path.$name);
}

// SAU (main image):
if (! empty($room->image)) {
    $this->imageProxy->delete('upload/room_images/'.$room->image);
}
$name = uniqid().'.'.$image->getClientOriginalExtension();
if (app()->environment('testing')) {
    $this->imageProxy->move($image, 'upload/room_images', $name);
} else {
    $this->imageProxy->upload($image, 'upload/room_images', 550, 850, 'cover', $name);
}
```

---

## 5. FILE BỊ ẢNH HƯỞNG

### 5.1 File tạo mới

| File | Dòng | Mô tả |
|---|---|---|
| `app/Services/ImageUploadProxy.php` | ~65 | Proxy service với 3 public methods |

### 5.2 File sửa đổi

| File | Thay đổi | Dòng giảm |
|---|---|---|
| `CrudController.php` | Delegate `uploadImage()` + `deleteImageFile()` → proxy, xóa ImageManager imports | -5 |
| `AdminController.php` | Thêm constructor + proxy, xóa `file_exists` + `unlink` + `->move()` | -4 |
| `UserController.php` | Thêm constructor + proxy, xóa `file_exists` + `unlink` + `->move()` | -4 |
| `BlogController.php` | Thêm constructor + proxy, xóa ImageManager imports + resize code | -12 |
| `SettingController.php` | Thêm constructor + proxy, xóa ImageManager imports + resize code | -10 |
| `RoomController.php` | Thêm constructor + proxy, xóa ImageManager imports + File::exists/delete + mkdir | -25 |

### 5.3 File không thay đổi

| File | Lý do |
|---|---|
| TeamController, BookAreaController, TestimonialController, GalleryController | Dùng CrudController → gọi proxy gián tiếp qua `$this->uploadImage()` |
| Tất cả .blade.php | Upload trả về cùng định dạng path như cũ |
| Routes (web.php) | Không liên quan |
| Models | Không liên quan |
| Database | Không liên quan |

---

## 6. SO SÁNH: TRƯỚC VÀ SAU

### 6.1 Số lượng `new ImageManager(new Driver)`

| File | TRƯỚC | SAU |
|---|---|---|
| CrudController | 1 | 0 (trong proxy) |
| BlogController | 1 | 0 |
| SettingController | 1 | 0 |
| RoomController | 2 | 0 |
| **ImageUploadProxy** | — | **1** (duy nhất) |
| **Tổng** | **5** | **1** |

### 6.2 Xóa ảnh

| File | TRƯỚC | SAU |
|---|---|---|
| AdminController | `unlink()` | `$this->imageProxy->delete()` |
| UserController | `unlink()` | `$this->imageProxy->delete()` |
| BlogController | `unlink()` | `$this->imageProxy->delete()` |
| SettingController | `unlink()` | `$this->imageProxy->delete()` |
| RoomController | `File::delete()` + `unlink()` + `@unlink()` | `$this->imageProxy->delete()` |
| CrudController | `unlink()` | `$this->imageProxy->delete()` |
| **Dùng chung** | **Không** — cách khác nhau | **Proxy** — tất cả đều gọi `delete()` |

### 6.3 Tóm tắt

| Tiêu chí | TRƯỚC | SAU |
|---|---|---|
| Số chỗ dùng ImageManager | 5 | 1 (trong proxy) |
| Cách xóa ảnh | unlink / File::delete / @unlink | Tất cả: proxy->delete() |
| Kiểm tra thư mục | Rải rác | Proxy tự xử lý |
| Thêm controller mới có upload? | Phải tự viết new ImageManager + unlink | Gọi `$imageProxy->upload()` 1 dòng |
| Chuyển local → S3 | Sửa 6 controller | Sửa DUY NHẤT proxy->delete() và proxy->upload() |
| Kiểm thử | Mock từng file | Mock ImageUploadProxy 1 lần |

---

## 7. KIẾN TRÚC THƯ MỤC

```
app/
├── Services/
│   ├── ImageUploadProxy.php          # [MỚI] Proxy service
│   ├── BookingStateManager.php       # (đã có)
│   ├── Payment/
│   └── Pricing/
│
└── Http/Controllers/
    ├── Controller.php
    ├── AdminController.php           # [SỬA] dùng proxy
    ├── UserController.php            # [SỬA] dùng proxy
    └── Backend/
        ├── CrudController.php        # [SỬA] dùng proxy
        ├── TeamController.php        # KHÔNG ĐỔI
        ├── BookAreaController.php    # KHÔNG ĐỔI
        ├── TestimonialController.php # KHÔNG ĐỔI
        ├── GalleryController.php     # KHÔNG ĐỔI
        ├── BlogController.php        # [SỬA] dùng proxy
        ├── SettingController.php     # [SỬA] dùng proxy
        ├── RoomController.php        # [SỬA] dùng proxy
        └── ...
```

---

## 8. KẾT LUẬN

### 8.1 Thành tựu

- ✅ Loại bỏ hoàn toàn `new ImageManager(new Driver)` khỏi controller — chỉ còn 1 chỗ trong proxy
- ✅ Tất cả controller dùng chung proxy upload (`upload()`, `move()`, `delete()`)
- ✅ Kiểm tra thư mục tập trung
- ✅ Xóa ảnh đồng nhất: tất cả gọi `$this->imageProxy->delete()`
- ✅ Giữ nguyên API `uploadImage()` + `deleteImageFile()` trong CrudController — 4 controller con không đổi
- ✅ Dễ dàng swap storage (chỉ sửa proxy)

### 8.2 Hướng mở rộng

- **S3 Storage**: Sửa ImageUploadProxy để dùng `Storage::disk('s3')` thay vì `public_path()` + `unlink()`
- **WebP conversion**: Thêm method `convertToWebP()` trong proxy
- **Watermark**: Thêm step watermark trong `processImage()`
- **Async upload**: Queue job upload trong proxy's method
- **Image optimization**: Tích hợp `spatie/image-optimizer` trong proxy

---

**Cập nhật**: 2026-06-19
**Tác giả**: Architecture Team
**Version**: 1.0
