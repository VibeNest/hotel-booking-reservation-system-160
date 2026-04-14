<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    //All Team Method
    public function AllTeam()
    {
        $team = Team::latest()->get();
        return view('backend.team.all_team', compact('team'));
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
