<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

    // Import Permission Method
    public function ImportPermission()
    {
        return view('backend.pages.permission.import_permission');
    }

    // Export Permission Method
    public function ExportPermission()
    {
        return Excel::download(new PermissionExport(), 'permission.xlsx');
    }

    // Import Method
    public function Import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new PermissionImport(), $request->file('import_file'));

        $notification = [
            'message' => 'Imported permission successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.permission')->with($notification);
    }

    // All Roles Method
    public function AllRoles()
    {
        $roles = Role::latest()->get();

        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    // Add Roles Method
    public function AddRoles()
    {
        return view('backend.pages.roles.add_roles');
    }

    // Store Roles Method
    public function StoreRoles(Request $request)
    {
        Role::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Added roles successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.roles')->with($notification);
    }

    // Edit Roles Method
    public function EditRoles($id)
    {
        $roles = Role::find($id);

        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    // Update Roles Method
    public function UpdateRoles(Request $request)
    {
        $roles_id = $request->id;

        Role::find($roles_id)->update([
            'name' => $request->name,
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Updated roles successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.roles')->with($notification);
    }

    // Delete Roles Method
    public function DeleteRoles($id)
    {
        Role::find($id)->delete();

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Deleted roles successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // All Roles Permission Method
    public function AllRolesPermission()
    {
        $roles = Role::all();

        return view('backend.pages.roles_setup.all_roles_permission', compact('roles'));
    }

    // Add Roles Permission Method
    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroup();

        return view('backend.pages.roles_setup.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    // Roles Permission Store Method
    public function RolesPermissionStore(Request $request)
    {
        // Validate role and permissions
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ], [
            'role_id.required' => 'Please select a role!',
            'role_id.exists' => 'The selected role does not exist!',
            'permission.required' => 'Please select at least one permission!',
            'permission.*.exists' => 'One or more selected permissions are invalid!',
        ]);

        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Added role permission successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.roles.permission')->with($notification);
    }
}
