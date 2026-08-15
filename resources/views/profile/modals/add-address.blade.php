<x-modal-panel show="showAddAddress">

    <h3 class="text-white text-lg font-semibold text-center mb-5">
        Adicionar endereço
    </h3>

    <form method="POST" action="{{ route('addresses.store') }}" class="space-y-4"
        x-data="cepAddressForm('{{ route('cep.search', ['zipCode' => '__CEP__']) }}')">

        @csrf

        <x-address-fields />

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_default" id="is_default_new" value="1"
                {{ $addresses->isEmpty() ? 'checked' : '' }}
                class="rounded border-gray-600 text-cyan-500 focus:ring-cyan-500">
            <label for="is_default_new" class="text-sm text-gray-300">Marcar como endereço padrão</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                Salvar
            </button>
            <button type="button" @click="showAddAddress = false"
                class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                Cancelar
            </button>
        </div>

    </form>

</x-modal-panel>
