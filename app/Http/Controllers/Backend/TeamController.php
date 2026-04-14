<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TeamController extends Controller
{
    //All Team Method
    public function AllTeam()
    {
        $team = Team::latest()->get();
        return view('backend.team.all_team', compact('team'));
    }
    //Edit Team
    public function EditTeam($id)
    {
        $team = Team::findOrFail($id);
        return view('backend.team.edit_team', compact('team'));
    }
    // Update Team
    public function UpdateTeam(Request $request)
    {
        $team = Team::findOrFail($request->id);

        if ($request->file('image')) {

            // Xóa ảnh cũ
            if (!empty($team->image) && file_exists(public_path($team->image))) {
                unlink(public_path($team->image));
            }

            // Upload + resize ảnh mới
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->cover(550, 670)->save(public_path('upload/team/' . $name_gen));

            $save_url = 'upload/team/' . $name_gen;

            $team->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'tiktok' => $request->tiktok,
                'instagram' => $request->instagram,
                'image' => $save_url,
            ]);
        } else {

            $team->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'tiktok' => $request->tiktok,
                'instagram' => $request->instagram,
            ]);
        }

        return redirect()->route('all.team')->with([
            'message' => 'Update Team Successfully',
            'alert-type' => 'success'
        ]);
    }
    // Delete Team
    public function DeleteTeam($id)
    {
        $team = Team::findOrFail($id);

        // Xóa ảnh nếu tồn tại
        if (!empty($team->image) && File::exists(public_path($team->image))) {
            File::delete(public_path($team->image));
        }

        // Xóa db
        $team->delete();

        $notification = array(
            'message' => 'Deleted team successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
