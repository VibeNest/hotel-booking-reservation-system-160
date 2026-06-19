<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends CrudController
{
    protected function getModelClass(): string
    {
        return Team::class;
    }

    protected function getViewPrefix(): string
    {
        return 'backend.team';
    }

    protected function getVariableName(): string
    {
        return 'team';
    }

    protected function getRedirectRoute(): string
    {
        return 'all.team';
    }

    protected function getStoreRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'facebook' => 'required|url',
            'tiktok' => 'required|url',
            'instagram' => 'required|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

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
