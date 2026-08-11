<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('accessAdminsList', User::class);
        $admins = User::withDetails()->admins()->paginate(10);
        return view('users-list', compact('admins'));
    }

    public function store(StoreAdminRequest $request)
    {

        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['is_admin'] = true;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('admins.index')->with('success', 'Usuário criado.');
    }

    public function update(UpdateAdminRequest $request, User $user)
    {

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admins.index')->with('success', 'Usuário criado.');
    }

    public function destroy(User $user)
    {
        $this->authorize('manageAdmins', $user);
        $user->delete();
        return redirect()->route('admins.index')->with('success', 'Usuário criado.');
    }
}
