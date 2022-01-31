<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreAdmin;
use App\Http\Requests\Admin\UpdateAdmin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::query()
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('admin.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\StoreAdmin $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreAdmin $request)
    {
        $admin = new Admin([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'active' => $request->get('active'),
            'password' => Hash::make($request->get('password')),
        ]);

        if ($admin->save()) {
            flash('The admin has been saved.')->success();

            return redirect(route('admin.admins.index'));
        }

        flash('The admin could not been saved. Please, try again.')->error();

        return back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('admin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdmin $request, Admin $admin)
    {
        $admin->name = $request->get('name');
        $admin->email = $request->get('email');
        $admin->active = $request->get('active');
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->get('password'));
        }

        if ($admin->save()) {
            flash('The admin has been saved.')->success();

            return redirect(route('admin.admins.index'));
        }

        flash('The admin could not been saved. Please, try again.')->error();

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if ($admin->delete()) {
            flash('The admin has been deleted.')->success();

            return redirect(route('admin.admins.index'));
        }

        flash('The admin could not be deleted.')->error();

        return back();
    }
}
