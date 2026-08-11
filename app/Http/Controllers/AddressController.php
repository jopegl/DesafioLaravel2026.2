<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function store(StoreAddressRequest $request)
    {
        $data = $request->validated();
        $wantsDefault = $request->boolean('is_default');

        $address = auth()->user()->addresses()->create($data);

        if ($wantsDefault) {
            $address->markAsDefault();
        }

        return back()->with('success', 'Endereço adicionado.');
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        if ($request->boolean('is_default')) {
            $address->markAsDefault();
        }

        return back()->with('success', 'Endereço atualizado.');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return back()->with('success', 'Endereço removido.');
    }
}
