<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('accessUsersList', User::class);
        $users = User::withDetails()->notAdmins()->search($request->search)->latest()->paginate(10);
        $users->getCollection()->transform(function (User $user) {
            $user->canManage = true;
            return $user;
        });
        return view('admin.users.index', compact('users'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $addressData = $data['address'] ?? null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user = User::create($data);


        if (! empty($addressData['zip_code'])) {
            $addressData['is_default'] = true;
            $user->addresses()->create($addressData);
        }

        return redirect()->route('users.index')->with('success', 'Usuário criado.');
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário removido.');
    }
}
