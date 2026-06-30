<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends CrudController
{
    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function getViewPrefix(): string
    {
        return 'backend.customer';
    }

    protected function getVariableName(): string
    {
        return 'customer';
    }

    protected function getRedirectRoute(): string
    {
        return 'all.customer';
    }

    protected function getStoreRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:8',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . request()->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'nullable|string|min:8',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function index()
    {
        $customers = User::where('role', 'user')->latest()->get();

        return view('backend.customer.all_customer', compact('customers'));
    }

    public function create()
    {
        return view('backend.customer.add_customer');
    }

    public function store(Request $request)
    {
        $request->validate($this->getStoreRules());

        $data = $request->except('_token', 'password_confirmation');
        $data['role'] = 'user';
        $data['status'] = '1';
        $data['password'] = Hash::make($request->password);

        if ($request->file('photo')) {
            $data['photo'] = $this->uploadImage($request->file('photo'), 'upload/user_images', 150, 150, 'cover');
        }

        User::create($data);

        $notification = [
            'message' => 'Customer created successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.customer')->with($notification);
    }

    public function edit($id)
    {
        $customer = User::findOrFail($id);

        return view('backend.customer.edit_customer', compact('customer'));
    }

    public function update(Request $request)
    {
        $request->validate($this->getUpdateRules());

        $customer = User::findOrFail($request->id);

        $data = $request->except('_token', '_method', 'id', 'password_confirmation');
        $data['role'] = 'user';
        $data['status'] = '1';

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->file('photo')) {
            if (!empty($customer->photo)) {
                $this->deleteImageFile($customer->photo);
            }
            $data['photo'] = $this->uploadImage($request->file('photo'), 'upload/user_images', 150, 150, 'cover');
        }

        $customer->update($data);

        $notification = [
            'message' => 'Customer updated successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.customer')->with($notification);
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        if (!empty($customer->photo)) {
            $this->deleteImageFile($customer->photo);
        }

        $customer->delete();

        $notification = [
            'message' => 'Customer deleted successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
