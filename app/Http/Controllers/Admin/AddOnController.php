<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddOn;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
    // Danh sách Add-ons
    public function index()
    {
        $addons = AddOn::all();
        return view('backend.addons.index', compact('addons'));
    }

    // Form thêm mới
    public function create()
    {
        return view('backend.addons.create');
    }

    // Lưu Add-on mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        AddOn::create($request->only(['name', 'price', 'description']));

        return redirect()->route('all.addons')->with('success', 'Add-on created successfully.');
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $addon = AddOn::findOrFail($id);
        return view('backend.addons.edit', compact('addon'));
    }

    // Cập nhật Add-on
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $addon = AddOn::findOrFail($id);
        $addon->update($request->only(['name', 'price', 'description']));

        return redirect()->route('all.addons')->with('success', 'Add-on updated successfully.');
    }

    // Xoá Add-on
    public function destroy($id)
    {
        $addon = AddOn::findOrFail($id);
        $addon->delete();

        return redirect()->route('all.addons')->with('success', 'Add-on deleted successfully.');
    }
}