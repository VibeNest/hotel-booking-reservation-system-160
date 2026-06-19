<?php

namespace App\Http\Controllers\Backend;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends CrudController
{
    protected function getModelClass(): string
    {
        return Testimonial::class;
    }

    protected function getViewPrefix(): string
    {
        return 'backend.testimonial';
    }

    protected function getVariableName(): string
    {
        return 'testimonial';
    }

    protected function getRedirectRoute(): string
    {
        return 'all.testimonial';
    }

    protected function getStoreRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

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
