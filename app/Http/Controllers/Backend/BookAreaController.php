<?php

namespace App\Http\Controllers\Backend;

use App\Models\BookArea;
use Illuminate\Http\Request;

class BookAreaController extends CrudController
{
    protected function getModelClass(): string
    {
        return BookArea::class;
    }

    protected function getViewPrefix(): string
    {
        return 'backend.book_area';
    }

    protected function getVariableName(): string
    {
        return 'bookArea';
    }

    protected function getRedirectRoute(): string
    {
        return 'all.book.area';
    }

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
