<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // All Permission Method
    public function AllPermission()
    {
        $permissions = Permission::latest()->get();

        return view('backend.pages.permission.all_permission', compact('permissions'));
    }

    // Add Permission Method
    public function AddPermission()
    {
        return view('backend.pages.permission.add_permission');
    }

    // Store Permission Method
    public function StorePermission(Request $request) 
    {
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'created_at' => Carbon::now(),
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Added permission successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.permission')->with($notification);
    }
}
