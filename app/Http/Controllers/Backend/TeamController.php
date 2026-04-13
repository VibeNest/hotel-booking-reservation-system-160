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

    // Add Team Method
    public function AddTeam()
    {
        return view('backend.team.add_team');
    }

    // Store Team Method
    public function StoreTeam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'facebook' => 'required|url',
            'tiktok' => 'required|url',
            'instagram' => 'required|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $folder = public_path('upload/team_images');
            File::ensureDirectoryExists($folder);

            $imageName = date('YmdHis') . '-' . $image->getClientOriginalName();
            $image->move($folder, $imageName);
            $imagePath = 'upload/team_images/' . $imageName;
        }

        Team::create([
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'tiktok' => $request->tiktok,
            'instagram' => $request->instagram,
            'image' => $imagePath,
        ]);

        $notification = array(
            'message' => 'Team added successfully!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.team')->with($notification);
    }
}
