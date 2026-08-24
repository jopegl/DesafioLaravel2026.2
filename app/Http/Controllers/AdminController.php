<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('accessAdminsList', User::class);
        $admins = User::withDetails()->admins(auth()->id())->search($request->search)->paginate(10);
        $admins->getCollection()->transform(function (User $admin) {
            $admin->canManage = auth()->user()->can('manageAdmins', $admin);
            return $admin;
        });

        return view('admin.admins.index', compact('admins'));
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

    public function update(UpdateAdminRequest $request, User $admin)
    {
        $this->authorize('manageAdmins', $admin);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $admin->update($data);

        return redirect()->route('admins.index')->with('success', 'Administrador atualizado.');
    }

    public function destroy(User $admin)
    {
        $this->authorize('manageAdmins', $admin);

        if ($admin->id === auth()->id()) {
            return redirect()->back()->with('error', 'Para excluir seu usuário, acesse a página de edição de perfil');
        }

        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'Administrador removido.');
    }
}
