<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreOrUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrUser $request, User $user)
    {
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        flash('The user has been saved.')->success();

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            flash('The user has been deleted.')->success();
            return redirect(route('admin.users.index'));
        }

        flash('The user could not be deleted.')->error();
        return back();
    }
}
