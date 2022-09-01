<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainPageTitle = 'User Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home User';

        if($request->ajax())
        {
            $user = User::select();
            return datatables()->of($user)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query);
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.user.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainPageTitle = 'User Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Create User';

        return view('admin.user.create-edit', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|min:5',
            'avatar' => 'required|max:1024|mimes:jpg,jpeg,png'
        ]);

        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password),
            'avatar' => $request->hasFile('avatar') ? 'storage/' . $request->file('avatar')->storePublicly('avatar') : 'storage/placeholder/avatar/default-profile.png'
        ]));

        return redirect()->route('admin.user.index')->with('status', 'Successfully Create User');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $mainPageTitle = 'User Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Update User';

        return view('admin.user.create-edit', compact('user', 'mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8',
            'name' => 'required|min:5',
        ]);

        $user->update(array_merge($request->all(), [
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'avatar' => $request->hasFile('avatar') ? 'storage/' . $request->file('avatar')->storePublicly('avatar') : $user->avatar
        ]));

        return redirect()->route('admin.user.index')->with('status', 'Successfully Update User');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.user.index')->with('status', 'Successfully Delete User');
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.index')->with('error', 'Failed Delete User');
        }
    }

    public function getActionColumn($data)
    {
        $editBtn = route('admin.user.edit', $data->id);
        $deleteBtn = route('admin.user.destroy', $data->id);
        $ident = Str::random(10);
        return
        '<a href="'.$editBtn.'" class="btn mx-1 my-1 btn-sm btn-success">Edit</a>'
        . '<input form="form'.$ident .'" type="submit" value="Delete" class="mx-1 my-1 btn btn-sm btn-danger">
        <form id="form'.$ident .'" action="'.$deleteBtn.'" method="post">
        <input type="hidden" name="_token" value="'.csrf_token().'" />
        <input type="hidden" name="_method" value="DELETE">
        </form>';
    }
}
