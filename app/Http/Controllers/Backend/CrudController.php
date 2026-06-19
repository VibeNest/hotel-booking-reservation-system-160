<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadProxy;
use Illuminate\Http\Request;

abstract class CrudController extends Controller
{
    public function __construct(
        protected ImageUploadProxy $imageUploadProxy
    ) {}

    abstract protected function getModelClass(): string;

    abstract protected function getViewPrefix(): string;

    abstract protected function getVariableName(): string;

    abstract protected function getRedirectRoute(): string;

    protected function getStoreRules(): array
    {
        return [];
    }

    protected function getUpdateRules(): array
    {
        return [];
    }

    // ---- Hook methods (optional) ----

    protected function beforeStore(Request $request, array &$data): void {}

    protected function afterStore($model, Request $request): void {}

    protected function beforeUpdate(Request $request, $model, array &$data): void {}

    protected function afterUpdate($model, Request $request): void {}

    protected function beforeDestroy($model): void {}

    // ---- Template Methods ----

    public function index()
    {
        $modelClass = $this->getModelClass();
        $varName = $this->getVariableName();

        return view($this->getViewPrefix() . '.all_' . $this->getViewSuffix(), [
            $varName => $modelClass::latest()->get(),
        ]);
    }

    public function create()
    {
        return view($this->getViewPrefix() . '.add_' . $this->getViewSuffix());
    }

    public function store(Request $request)
    {
        $rules = $this->getStoreRules();

        if (! empty($rules)) {
            $request->validate($rules);
        }

        $data = $request->except('_token');

        $this->beforeStore($request, $data);

        $modelClass = $this->getModelClass();
        $model = $modelClass::create($data);

        $this->afterStore($model, $request);

        $notification = [
            'message' => 'Created successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route($this->getRedirectRoute())->with($notification);
    }

    public function edit($id)
    {
        $modelClass = $this->getModelClass();
        $varName = $this->getVariableName();

        return view($this->getViewPrefix() . '.edit_' . $this->getViewSuffix(), [
            $varName => $modelClass::findOrFail($id),
        ]);
    }

    public function update(Request $request)
    {
        $rules = $this->getUpdateRules();

        if (! empty($rules)) {
            $request->validate($rules);
        }

        $modelClass = $this->getModelClass();
        $model = $modelClass::findOrFail($request->id);

        $data = $request->except('_token', '_method', 'id');

        $this->beforeUpdate($request, $model, $data);

        $model->update($data);

        $this->afterUpdate($model, $request);

        $notification = [
            'message' => 'Updated successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route($this->getRedirectRoute())->with($notification);
    }

    public function destroy($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::findOrFail($id);

        $this->beforeDestroy($model);

        $model->delete();

        $notification = [
            'message' => 'Deleted successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // ---- Helper Methods ----

    protected function getViewSuffix(): string
    {
        $parts = explode('.', $this->getViewPrefix());

        return end($parts);
    }

    protected function uploadImage($file, string $folder, int $width, int $height, string $method = 'resize'): string
    {
        $filename = $this->imageUploadProxy->upload($file, $folder, $width, $height, $method);

        return $folder . '/' . $filename;
    }

    protected function deleteImageFile(?string $path): void
    {
        $this->imageUploadProxy->delete($path ?? '');
    }
}
