<x-modal-panel show="showCreate">

    <h3 class="text-white text-lg font-semibold text-center mb-5">
        Criar {{ $singular }}
    </h3>

    <form method="POST" action="{{ route("{$prefix}.store") }}" enctype="multipart/form-data" class="space-y-4">

        @csrf

        <label class="block border-2 border-dashed border-gray-700 rounded-lg h-32 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden"
            x-data="{ preview: null }">
            <template x-if="!preview">
                <span>Clique para adicionar uma foto</span>
            </template>
            <img :src="preview" x-show="preview" class="absolute inset-0 w-full h-full object-cover">
            <input type="file" name="photo" accept="image/*" class="hidden"
                @change="preview = URL.createObjectURL($event.target.files[0])">
        </label>

        <div>
            <label class="block text-gray-400 text-xs mb-1">Nome</label>
            <input type="text" name="name" required
                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>

        <div>
            <label class="block text-gray-400 text-xs mb-1">E-mail</label>
            <input type="email" name="email" required
                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>

        <div>
            <label class="block text-gray-400 required text-xs mb-1">CPF (somente números)</label>
            <input type="text" name="cpf" maxlength="11" required
                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-gray-400 text-xs mb-1">Telefone</label>
                <input type="text" name="phone"
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
            <div class="flex-1">
                <label class="block text-gray-400 text-xs mb-1">Nascimento</label>
                <input type="date" name="birth_date"
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-gray-400 text-xs mb-1">Senha</label>
                <input type="password" name="password" required
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
            <div class="flex-1">
                <label class="block text-gray-400 text-xs mb-1">Confirmar senha</label>
                <input type="password" name="password_confirmation" required
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
        </div>

        <div class="border-t border-gray-800 pt-4" x-data="cepAddressForm('{{ route('cep.search', ['zipCode' => '__CEP__']) }}')">

            <button type="button" @click="showAddress = !showAddress"
                class="text-cyan-400 hover:text-cyan-300 text-sm font-medium flex items-center gap-1">
                <span x-text="showAddress ? '− Remover endereço' : '+ Adicionar endereço agora'"></span>
            </button>

            <template x-if="showAddress">
                <div class="space-y-3 mt-3">
                    <x-address-fields name-prefix="address" />
                </div>
            </template>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                Salvar
            </button>
            <button type="button" @click="showCreate = false"
                class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                Cancelar
            </button>
        </div>

    </form>

</x-modal-panel>