<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Image;

class HomeController extends Controller
{

    function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role_id = auth()->user()->role_id;
        switch ($role_id) {
            case 3:
            case 4:
                return redirect()->route('work-order.index');
                break;
            case 6:
                return redirect()->route('inventory.index');
                break;
            default:
                return view('dashboard.index');
                break;
        }
    }

    /**
     * Update user profile
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $data = $request->except('avatar');
        $user = $this->user->findOrFail(auth()->user()->id);
        if($request->hasFile('avatar')) {
            if($user->avatar) {
                Storage::delete($user->avatar);
            }
            $image = $request->file('avatar');
            $filename = str_random(28) . '.' . $image->extension();
            $path = 'storage/avatars/' . $filename;
            $file = Image::make($image->getRealPath())->fit(500,500);
            $file->save($path);
            $data['avatar'] = str_replace('storage', 'public', $path);
        }
        $user->update($data);
        return response()->json(['name' => $data['name'], 'avatar' => $request->hasFile('avatar') ? $path : null]);
    }
}
