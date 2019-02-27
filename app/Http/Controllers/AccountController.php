<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Job;
use App\Models\Role;
use Image;

class AccountController extends Controller
{

    function __construct(User $user, Job $job, Department $department, Role $role) {
        $this->user = $user;
        $this->job = $job;
        $this->department = $department;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->department->all();
        $jobs = $this->job->all();
        $roles = $this->role->where('id', '!=', 1)->get();
        return view('account.index', compact('departments', 'jobs', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'unique:users|alpha_dash',
            'email' => 'unique:users|email'
        ]);
        $data = $request->except('avatar');
        $data['password'] = bcrypt($data['password']);
        if($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = str_random(28) . '.' . $image->extension();
            $path = 'storage/avatars/' . $filename;
            $file = Image::make($image->getRealPath())->fit(500,500);
            $file->save($path);
            $data['avatar'] = str_replace('storage', 'public', $path);
        }
        $this->user->updateOrCreate($data);
        return response()->json(['status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->findOrFail(decrypt($id));
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'alpha_dash',
        ]);
        $data = $request->all();
        $this->user->findOrFail(decrypt($id))->update($data);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->findOrFail(decrypt($id))->delete();
        return response()->json(['status' => 200]);
    }

    /**
     * Handle all AJAX request
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        switch ($request->mode) {
            case 'datatable':
                return $this->user->datatable();
                break;
        }
    }

    /**
     * Change account password
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        $user = $this->user->findOrFail(decrypt($id));
        if($request->has('old_password')) {
            if(!Hash::check($request->old_password, $user->password)) {
                return response()->json(['message' => ' Old password is not match!'], 500);
            }
        }
        $data['password'] = bcrypt($request->password);
        $user->update($data);
        return response()->json(['status' => 200]);
    }
}
