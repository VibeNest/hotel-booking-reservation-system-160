<?php

namespace App\Http\Controllers\Backend;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends CrudController
{
    protected function getModelClass(): string
    {
        return Gallery::class;
    }

    protected function getViewPrefix(): string
    {
        return 'backend.gallery';
    }

    protected function getVariableName(): string
    {
        return 'gallery';
    }

    protected function getRedirectRoute(): string
    {
        return 'all.gallery';
    }

    // ---- Override store for multi-image upload ----

    public function store(Request $request)
    {
        $images = $request->file('photo_name');

        foreach ($images as $image) {
            $path = $this->uploadImage($image, 'upload/gallery', 550, 550);
            Gallery::create(['photo_name' => $path]);
        }

        $notification = [
            'message' => 'Added gallery successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route($this->getRedirectRoute())->with($notification);
    }

    // ----

    protected function beforeUpdate(Request $request, $model, array &$data): void
    {
        if ($request->file('photo_name')) {
            if ($model->photo_name) {
                $this->deleteImageFile($model->photo_name);
            }
            $data['photo_name'] = $this->uploadImage($request->file('photo_name'), 'upload/gallery', 550, 550);
        }
    }

    protected function beforeDestroy($model): void
    {
        if ($model->photo_name) {
            $this->deleteImageFile($model->photo_name);
        }
    }

    // ---- Custom methods (non-CRUD) ----

    public function DeleteGalleryMultiple(Request $request)
    {
        $selectedItems = $request->input('selectedItem', []);

        foreach ($selectedItems as $itemId) {
            $item = Gallery::find($itemId);

            if ($item) {
                $this->deleteImageFile($item->photo_name);
                $item->delete();
            }
        }

        $notification = [
            'message' => 'Deleted image selected successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function ShowGallery()
    {
        $gallery = Gallery::latest()->paginate(6);

        return view('frontend.gallery.show_gallery', compact('gallery'));
    }
}
