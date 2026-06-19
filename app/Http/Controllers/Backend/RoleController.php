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

    // Edit Permission Method
    public function EditPermission($id) 
    {
        $permission = Permission::find($id);

        return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    // Update Permission Method
    public function UpdatePermission(Request $request) 
    {
        $per_id = $request->id;

        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Updated permission successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.permission')->with($notification);
    }

    // Delete Permission Method
    public function DeletePermission($id) 
    {
        Permission::find($id)->delete();

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Deleted permission successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
