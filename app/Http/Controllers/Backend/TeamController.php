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
        $team = Team::find($id);
        
        // Check tồn tại (tránh crash)
        if (!$team) {
            return redirect()->back()->with('error', 'Không tìm thấy team');
        }

        // Xóa ảnh nếu tồn tại
        if (!empty($team->image) && File::exists(public_path($team->image))) {
            File::delete(public_path($team->image));
        }

        // Xóa db
        $team->delete();

        return redirect()->route('all.team')->with('success', 'Xóa thành công');
    }
}
