<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('accessAdminsList', User::class);
        $admins = User::withDetails()->admins(auth()->id())->search($request->search)->paginate(10);
        return view('admins-list', compact('admins'));
    }

    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['is_admin'] = true;

        $addressData = $data['address'] ?? null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $admin = User::create($data);

        if (! empty($addressData['zip_code'])) {
            $addressData['is_default'] = true;
            $admin->addresses()->create($addressData);
        }

        return redirect()->route('admins.index')->with('success', 'Administrador criado.');
    }

    public function update(UpdateAdminRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admins.index')->with('success', 'Administrador atualizado.');
    }

    public function destroy(User $user)
    {
        $this->authorize('manageAdmins', $user);
        $user->delete();
        return redirect()->route('admins.index')->with('success', 'Administrador removido.');
    }
}
