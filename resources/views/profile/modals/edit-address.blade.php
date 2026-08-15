<x-modal-panel show="showEditAddress" :require-selected="true" selected-expr="selectedAddress">

    <h3 class="text-white text-lg font-semibold text-center mb-5">
        Editar endereço
    </h3>

    <template x-if="selectedAddress">
        <form method="POST" :action="`{{ url('/addresses') }}/${selectedAddress.id}`"
            class="space-y-4"
            x-data="cepAddressForm('{{ route('cep.search', ['zipCode' => '__CEP__']) }}', {
                zip_code: selectedAddress.zip_code,
                street: selectedAddress.street,
                number: selectedAddress.number,
                neighborhood: selectedAddress.neighborhood,
                city: selectedAddress.city,
                state: selectedAddress.state,
                complement: selectedAddress.complement,
            })">

            @csrf
            @method('PUT')

            <x-address-fields />

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_default" id="is_default_edit" value="1"
                    :checked="selectedAddress.is_default"
                    class="rounded border-gray-600 text-cyan-500 focus:ring-cyan-500">
                <label for="is_default_edit" class="text-sm text-gray-300">Marcar como endereço padrão</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Salvar
                </button>
                <button type="button" @click="showEditAddress = false"
                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                    Cancelar
                </button>
            </div>

        </form>
    </template>

</x-modal-panel>
