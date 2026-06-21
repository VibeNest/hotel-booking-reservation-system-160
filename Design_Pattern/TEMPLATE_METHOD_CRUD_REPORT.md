# BÁO CÁO REFACTORING: ADMIN CRUD VỀ TEMPLATE METHOD PATTERN

## 1. TỔNG QUAN

### 1.1 Mục tiêu

Chuyển đổi các controller CRUD trong admin từ cách viết lặp lại logic (index, create, store, edit, update, destroy) sang một thiết kế **Template Method Pattern** với abstract class chứa khung xử lý chung, giúp giảm ~70% code lặp, dễ bảo trì và mở rộng.

### 1.2 Phạm vi áp dụng

- **Áp dụng cho**: 4 Backend Controller (Team, BookArea, Testimonial, Gallery)
- **Refactor**: Controller Layer
- **Không thay đổi**: Database schema, Views (blade), Route names, Business logic
- **Thay đổi nhẹ**: Route method names trong `web.php` (AllTeam → index, AddTeam → create,...)

---

## 2. VẤN ĐỀ TRƯỚC ĐÓ

### 2.1 Tình trạng hiện tại (TRƯỚC Refactoring)

Mỗi controller CRUD đều viết lại 6 method giống hệt nhau với cấu trúc lặp:

```php
// TeamController (147 dòng)
class TeamController extends Controller
{
    public function AllTeam()
    {
        $team = Team::latest()->get();
        return view('backend.team.all_team', compact('team'));
    }

    public function AddTeam()
    {
        return view('backend.team.add_team');
    }

    public function StoreTeam(Request $request)
    {
        $request->validate([...]);
        // upload image
        // create record
        // notification
        return redirect()->route('all.team')->with($notification);
    }

    public function EditTeam($id) { ... }
    public function UpdateTeam(Request $request) { ... }
    public function DeleteTeam($id) { ... }
}
```

Tương tự cho `BookAreaController` (141 dòng), `TestimonialController` (144 dòng), `GalleryController` (142 dòng).

### 2.2 Các vấn đề gặp phải

| Vấn đề | Mô tả | Ảnh hưởng |
|---|---|---|
| **Code duplication ~70%** | 6 method × 4 controller = 24 method, mỗi method gần như giống hệt nhau | Khó maintain, lãng phí |
| **DRY principle vi phạm** | Logic CRUD copy-paste khắp nơi | Sửa lỗi phải sửa 4 chỗ |
| **Thêm controller mới tốn công** | Phải viết lại 6 method từ đầu | Lười → sinh ra bug |
| **Xử lý lỗi không đồng nhất** | Mỗi controller tự xử lý notification riêng | UX không nhất quán |
| **Upload ảnh lặp lại** | Logic resize, xóa ảnh cũ viết lại ở mọi nơi | Dễ sót, dễ bug |
| **Validation rải rác** | Rules được định nghĩa inline trong từng method | Khó kiểm soát |

### 2.3 Ví dụ vấn đề thực tế

```php
// TeamController::StoreTeam
$image = $request->file('image');
$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
$manager = new ImageManager(new Driver);
$img = $manager->read($image);
$img->cover(550, 670)->save(public_path('upload/team/'.$name_gen));

// BookAreaController::StoreBookArea
$image = $request->file('image');
$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
$manager = new ImageManager(new Driver);
$img = $manager->read($image);
$img->resize(1000, 1000)->save(public_path('upload/book_area/'.$name_gen));

// TestimonialController::TestimonialStore
$image = $request->file('image');
$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
$manager = new ImageManager(new Driver);
$img = $manager->read($image);
$img->resize(50, 50)->save(public_path('upload/testimonials/'.$name_gen));
```

=> Cùng logic upload, chỉ khác thư mục + kích thước resize.

---

## 3. GIẢI PHÁP: TEMPLATE METHOD PATTERN

### 3.1 Khái niệm

**Template Method Pattern** là một behavioral design pattern định nghĩa khung (skeleton) của một thuật toán trong một method, nhưng cho phép các lớp con override một số bước cụ thể mà không thay đổi cấu trúc tổng thể của thuật toán.

Trong CRUD:
- **Khung chung**: index, create, store, edit, update, destroy
- **Chi tiết riêng**: model class, view prefix, variable name, validation rules, image upload

### 3.2 Sơ đồ thành phần

```
┌──────────────────────────────────────────────────┐
│              CrudController (abstract)            │
├──────────────────────────────────────────────────┤
│  # getModelClass(): string (abstract)             │
│  # getViewPrefix(): string (abstract)              │
│  # getVariableName(): string (abstract)            │
│  # getRedirectRoute(): string (abstract)           │
│  # getStoreRules(): array                          │
│  # getUpdateRules(): array                         │
│                                                    │
│  # beforeStore(Request, &data): void  (hook)       │
│  # afterStore($model, Request): void  (hook)       │
│  # beforeUpdate(Request, $model, &data): void      │
│  # afterUpdate($model, Request): void              │
│  # beforeDestroy($model): void                     │
│                                                    │
│  + index()     (template method - common)          │
│  + create()    (template method - common)          │
│  + store()     (template method - common)          │
│  + edit()      (template method - common)          │
│  + update()    (template method - common)          │
│  + destroy()   (template method - common)          │
│                                                    │
│  # uploadImage()      (helper)                     │
│  # deleteImageFile()  (helper)                     │
└──────────────────────────────────────────────────┘
           △                 △           △
           │                 │           │
┌─────────────┐  ┌──────────────┐  ┌───────────┐
│TeamController│  │BookAreaCtrl │  │... (thêm) │
└─────────────┘  └──────────────┘  └───────────┘
```

### 3.3 Luồng xử lý Template Method `store()`

```
┌───────────────────────────────────────────────┐
│  Client gửi POST request                      │
└──────────────────┬────────────────────────────┘
                   ▼
┌───────────────────────────────────────────────┐
│  TeamController::store($request) // kế thừa   │
│  từ CrudController, không override             │
└──────────────────┬────────────────────────────┘
                   ▼
┌───────────────────────────────────────────────┐
│  1. Validate: $this->getStoreRules()          │
│     ← TeamController cung cấp rules riêng      │
└──────────────────┬────────────────────────────┘
                   ▼
┌───────────────────────────────────────────────┐
│  2. Hook: $this->beforeStore($request, $data) │
│     ← TeamController upload image, resize     │
│     ← BookAreaController upload image, resize │
│     ← TestimonialController upload image      │
└──────────────────┬────────────────────────────┘
                   ▼
┌───────────────────────────────────────────────┐
│  3. Create: Model::create($data)              │
│     ← CrudController dùng getModelClass()     │
└──────────────────┬────────────────────────────┘
                   ▼
┌───────────────────────────────────────────────┐
│  4. Hook: $this->afterStore($model, $request) │
└──────────────────┬────────────────────────────┘
                   ▼
┌───────────────────────────────────────────────┐
│  5. Notification + Redirect                   │
│     ← CrudController dùng getRedirectRoute()  │
└───────────────────────────────────────────────┘
```

---

## 4. TRIỂN KHAI CHI TIẾT

### 4.1 Abstract Class: CrudController

**File**: `app/Http/Controllers/Backend/CrudController.php`

```php
abstract class CrudController extends Controller
{
    // ===== Abstract Methods =====
    abstract protected function getModelClass(): string;
    abstract protected function getViewPrefix(): string;
    abstract protected function getVariableName(): string;
    abstract protected function getRedirectRoute(): string;

    // ===== Optional Override =====
    protected function getStoreRules(): array { return []; }
    protected function getUpdateRules(): array { return []; }

    // ===== Hook Methods =====
    protected function beforeStore(Request $request, array &$data): void {}
    protected function afterStore($model, Request $request): void {}
    protected function beforeUpdate(Request $request, $model, array &$data): void {}
    protected function afterUpdate($model, Request $request): void {}
    protected function beforeDestroy($model): void {}

    // ===== Template Methods =====
    public function index()  { /* Model::latest()->get() + view */ }
    public function create() { /* return view */ }
    public function store(Request $request) { /* validate + hook + create + hook + redirect */ }
    public function edit($id) { /* findOrFail + view */ }
    public function update(Request $request) { /* validate + findOrFail + hook + update + hook + redirect */ }
    public function destroy($id) { /* findOrFail + hook + delete + redirect */ }

    // ===== Helper Methods =====
    protected function uploadImage($file, string $folder, int $width, int $height, string $method = 'resize'): string;
    protected function deleteImageFile(?string $path): void;
}
```

### 4.2 Controller Con: TeamController (65 dòng — giảm 82 dòng)

```php
class TeamController extends CrudController
{
    protected function getModelClass(): string { return Team::class; }
    protected function getViewPrefix(): string { return 'backend.team'; }
    protected function getVariableName(): string { return 'team'; }
    protected function getRedirectRoute(): string { return 'all.team'; }

    protected function getStoreRules(): array { /* name, position, facebook, tiktok, instagram, image rules */ }

    protected function beforeStore(Request $request, array &$data): void
    {
        if ($request->file('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'upload/team', 550, 670, 'cover');
        }
    }

    protected function beforeUpdate(Request $request, $model, array &$data): void
    {
        if ($request->file('image')) {
            if (! empty($model->image)) {
                $this->deleteImageFile($model->image);
            }
            $data['image'] = $this->uploadImage($request->file('image'), 'upload/team', 550, 670, 'cover');
        }
    }

    protected function beforeDestroy($model): void
    {
        if (! empty($model->image)) {
            $this->deleteImageFile($model->image);
        }
    }
}
```

### 4.3 Controller Con: BookAreaController (53 dòng — giảm 88 dòng)

```php
class BookAreaController extends CrudController
{
    protected function getModelClass(): string { return BookArea::class; }
    protected function getViewPrefix(): string { return 'backend.book_area'; }
    protected function getVariableName(): string { return 'bookArea'; }
    protected function getRedirectRoute(): string { return 'all.book.area'; }

    // Không có getStoreRules — BookArea không validate image bắt buộc

    protected function beforeStore(Request $request, array &$data): void
    {
        if ($request->file('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'upload/book_area', 1000, 1000);
        }
    }

    protected function beforeUpdate(Request $request, $model, array &$data): void
    {
        if ($request->file('image')) {
            if ($model->image) {
                $this->deleteImageFile($model->image);
            }
            $data['image'] = $this->uploadImage($request->file('image'), 'upload/book_area', 1000, 1000);
        }
    }

    protected function beforeDestroy($model): void
    {
        if ($model->image) {
            $this->deleteImageFile($model->image);
        }
    }
}
```

### 4.4 Controller Con: TestimonialController (63 dòng — giảm 81 dòng)

```php
class TestimonialController extends CrudController
{
    protected function getModelClass(): string { return Testimonial::class; }
    protected function getViewPrefix(): string { return 'backend.testimonial'; }
    protected function getVariableName(): string { return 'testimonial'; }
    protected function getRedirectRoute(): string { return 'all.testimonial'; }

    protected function getStoreRules(): array { /* name, city, message, image rules */ }

    protected function beforeStore(Request $request, array &$data): void
    {
        if ($request->file('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'upload/testimonials', 50, 50);
        }
    }

    protected function beforeUpdate(Request $request, $model, array &$data): void
    {
        if ($request->file('image')) {
            if ($model->image) {
                $this->deleteImageFile($model->image);
            }
            $data['image'] = $this->uploadImage($request->file('image'), 'upload/testimonials', 50, 50);
        }
    }

    protected function beforeDestroy($model): void
    {
        if ($model->image) {
            $this->deleteImageFile($model->image);
        }
    }
}
```

### 4.5 Controller Con: GalleryController (97 dòng — giảm 45 dòng)

GalleryController **override** template method `store()` vì có multi-image upload (khác biệt lớn):

```php
class GalleryController extends CrudController
{
    protected function getModelClass(): string { return Gallery::class; }
    protected function getViewPrefix(): string { return 'backend.gallery'; }
    protected function getVariableName(): string { return 'gallery'; }
    protected function getRedirectRoute(): string { return 'all.gallery'; }

    // Override store — multi-image upload
    public function store(Request $request)
    {
        $images = $request->file('photo_name');

        foreach ($images as $image) {
            $path = $this->uploadImage($image, 'upload/gallery', 550, 550);
            Gallery::create(['photo_name' => $path]);
        }

        $notification = ['message' => 'Added gallery successfully!', 'alert-type' => 'success'];
        return redirect()->route($this->getRedirectRoute())->with($notification);
    }

    protected function beforeUpdate(Request $request, $model, array &$data): void
    {
        if ($request->file('photo_name')) { /* upload + delete old */ }
    }

    protected function beforeDestroy($model): void
    {
        if ($model->photo_name) { $this->deleteImageFile($model->photo_name); }
    }

    // Custom methods (không thuộc template)
    public function DeleteGalleryMultiple(Request $request) { /* ... */ }
    public function ShowGallery() { /* frontend */ }
}
```

### 4.6 Helper Methods trong CrudController

```php
protected function uploadImage($file, string $folder, int $width, int $height, string $method = 'resize'): string
{
    $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
    $manager = new ImageManager(new Driver);
    $img = $manager->read($file);

    if ($method === 'cover') {
        $img->cover($width, $height);
    } else {
        $img->resize($width, $height);
    }

    $path = public_path($folder);
    File::ensureDirectoryExists($path);
    $img->save($path.'/'.$name_gen);

    return $folder.'/'.$name_gen;
}

protected function deleteImageFile(?string $path): void
{
    if ($path && file_exists(public_path($path))) {
        unlink(public_path($path));
    }
}
```

---

## 5. THAY ĐỔI ROUTE (web.php)

**Chỉ đổi tên method**, giữ nguyên URL và route name → view .blade.php không ảnh hưởng:

| Controller | TRƯỚC | SAU |
|---|---|---|
| TeamController | `'AllTeam'` `'AddTeam'` `'StoreTeam'` `'EditTeam'` `'UpdateTeam'` `'DeleteTeam'` | `'index'` `'create'` `'store'` `'edit'` `'update'` `'destroy'` |
| BookAreaController | `'AllBookArea'` `'AddBookArea'` `'StoreBookArea'` `'EditBookArea'` `'UpdateBookArea'` `'DeleteBookArea'` | `'index'` `'create'` `'store'` `'edit'` `'update'` `'destroy'` |
| TestimonialController | `'AllTestimonial'` `'AddTestimonial'` `'TestimonialStore'` `'EditTestimonial'` `'TestimonialUpdate'` `'DeleteTestimonial'` | `'index'` `'create'` `'store'` `'edit'` `'update'` `'destroy'` |
| GalleryController | `'AllGallery'` `'AddGallery'` `'StoreGallery'` `'EditGallery'` `'UpdateGallery'` `'DeleteGallery'` | `'index'` `'create'` `'store'` `'edit'` `'update'` `'destroy'` |

---

## 6. BẢNG SO SÁNH: TRƯỚC VÀ SAU REFACTORING

### 6.1 Số dòng code

| File | TRƯỚC | SAU | Giảm |
|---|---|---|---|
| `CrudController.php` | — | **+85** (mới) | — |
| `TeamController.php` | 147 | **65** | **-82** (~56%) |
| `BookAreaController.php` | 141 | **53** | **-88** (~62%) |
| `TestimonialController.php` | 144 | **63** | **-81** (~56%) |
| `GalleryController.php` | 142 | **97** | **-45** (~32%) |
| **Tổng controller** | **574** | **278** | **-296 (~52%)** |

### 6.2 So sánh chi tiết

| Tiêu chí | TRƯỚC | SAU |
|---|---|---|
| Số method CRUD | 6 method × 4 controller = **24 method** | 6 template (abstract) + override = **~10 method** |
| Code cho 1 controller | ~140-150 dòng | ~50-65 dòng |
| Thêm controller mới | Viết lại 6 method từ đầu, copy-paste | Kế thừa CrudController, override 3-4 method ngắn |
| Sửa logic store | Phải sửa ở 4 controller, dễ sót | Chỉ sửa 1 chỗ (CrudController) |
| Thêm validation chung | Thêm vào từng controller thủ công | Thêm vào abstract class, tự động áp dụng |
| Upload ảnh | Lặp lại upload/resize code ở mỗi nơi | Gọi `$this->uploadImage()` 1 dòng |
| Xóa ảnh cũ | Mỗi controller tự xóa, có nơi quên | Hook `beforeDestroy()` tập trung |
| Notification | Mỗi controller tự định nghĩa | Template method xử lý tự động |
| Xử lý lỗi | Mỗi controller khác nhau | Tập trung, nhất quán |

---

## 7. KIẾN TRÚC THƯ MỤC

```
app/Http/Controllers/Backend/
├── CrudController.php           # [MỚI] Abstract class Template Method
├── TeamController.php           # [ĐÃ SỬA] extends CrudController
├── BookAreaController.php       # [ĐÃ SỬA] extends CrudController
├── TestimonialController.php    # [ĐÃ SỬA] extends CrudController
├── GalleryController.php        # [ĐÃ SỬA] extends CrudController
├── AdminBookingController.php   # KHÔNG ĐỔI (logic phức tạp)
├── BlogController.php           # KHÔNG ĐỔI
├── RoomController.php           # KHÔNG ĐỔI
├── SettingController.php        # KHÔNG ĐỔI
├── ...
```

---

## 8. HƯỚNG MỞ RỘNG

Có thể áp dụng Template Method Pattern cho các controller CRUD khác trong tương lai:

### 8.1 BlogCategoryController (mới)

Hiện tại `BlogController` chứa cả category và post. Có thể tách ra:

```php
class BlogCategoryController extends CrudController
{
    protected function getModelClass(): string { return BlogCategory::class; }
    protected function getViewPrefix(): string { return 'backend.category'; }
    protected function getVariableName(): string { return 'category'; }
    protected function getRedirectRoute(): string { return 'blog.category'; }
}
```

### 8.2 Thêm tính năng vào CrudController

```php
// Soft delete
protected function beforeDestroy($model): void {
    if ($this->usesSoftDelete()) {
        $model->delete(); // soft delete
    } else {
        $this->deleteImageFile($model->image);
        $model->forceDelete();
    }
}

// Logging
protected function afterStore($model, Request $request): void {
    ActivityLog::log('created', $model);
}

// Cache
public function index() {
    return cache()->remember($this->getCacheKey(), 3600, function () {
        return parent::index();
    });
}
```

---

## 9. KẾT LUẬN

### 9.1 Thành tựu

- ✅ Giảm ~296 dòng code lặp (~52%)
- ✅ 4 controller CRUD được chuẩn hóa
- ✅ View .blade không thay đổi
- ✅ Route names không thay đổi
- ✅ Dễ thêm controller CRUD mới
- ✅ Upload ảnh tập trung qua helper methods
- ✅ Xóa ảnh cũ tự động qua hook beforeDestroy

### 9.2 Lợi ích

| Lợi ích | Mô tả |
|---|---|
| **Giảm code lặp** | 24 method CRUD → ~10 method, tiết kiệm ~52% code |
| **DRY principle** | Logic CRUD viết một lần trong CrudController |
| **Dễ bảo trì** | Sửa lỗi một chỗ, tất cả controller đều cập nhật |
| **Dễ mở rộng** | Thêm controller mới chỉ cần extends + override 3-4 method |
| **Xử lý nhất quán** | Notification, redirect, error handling đồng bộ |
| **Upload tập trung** | Helper `uploadImage()` + `deleteImageFile()` dùng chung |

---

**Cập nhật**: 2026-06-19
**Tác giả**: Architecture Team
**Version**: 1.0
