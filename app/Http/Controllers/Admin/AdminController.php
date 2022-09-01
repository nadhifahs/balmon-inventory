<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainPageTitle = 'Admin Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home Admin';

        if($request->ajax())
        {
            $admin = Admin::select();
            return datatables()->of($admin)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query);
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.admin.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainPageTitle = 'Admin Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Create Admin';

        return view('admin.admin.create-edit', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
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
            'username' => 'required|unique:admins,username',
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:8',
            'name' => 'required|min:5',
            'avatar' => 'required|max:1024|mimes:jpg,jpeg,png'
        ]);

        $admin = Admin::create(array_merge($request->all(), [
            'password' => bcrypt($request->password),
            'avatar' => $request->hasFile('avatar') ? 'storage/' . $request->file('avatar')->storePublicly('avatar') : 'storage/placeholder/avatar/default-profile.png'
        ]));

        return redirect()->route('admin.admin.index')->with('status', 'Successfully Create Admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $mainPageTitle = 'Admin Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Update Admin';

        return view('admin.admin.create-edit', compact('user', 'mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $this->validate($request, [
            'username' => 'required|unique:admins,username,'.$admin->id,
            'email' => 'required|unique:admins,email,'.$admin->id,
            'password' => 'nullable|min:8',
            'name' => 'required|min:5',
        ]);

        $admin->update(array_merge($request->all(), [
            'password' => $request->password ? bcrypt($request->password) : $admin->password,
            'avatar' => $request->hasFile('avatar') ? 'storage/' . $request->file('avatar')->storePublicly('avatar') : $admin->avatar
        ]));

        return redirect()->route('admin.admin.index')->with('status', 'Successfully Update Admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        try {
            $admin->delete();
            return redirect()->route('admin.admin.index')->with('status', 'Successfully Delete Admin');
        } catch (\Throwable $th) {
            return redirect()->route('admin.admin.index')->with('error', 'Failed Delete Admin');
        }
    }

    public function getActionColumn($data)
    {
        $editBtn = route('admin.admin.edit', $data->id);
        $deleteBtn = route('admin.admin.destroy', $data->id);
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
