<x-modal-panel show="showEdit" :require-selected="true">

    <h3 class="text-white text-lg font-semibold text-center mb-4">
        Editar usuário
    </h3>

    <template x-if="selected">
        <div x-data="{ tab: 'dados' }">

            <div class="flex gap-1 mb-5 bg-[#15171e] rounded-lg p-1">
                <button type="button" @click="tab = 'dados'"
                    :class="tab === 'dados' ? 'bg-cyan-500 text-white' : 'text-gray-400 hover:text-white'"
                    class="flex-1 text-sm font-medium py-2 rounded-md transition">
                    Dados
                </button>
                <button type="button" @click="tab = 'endereco'"
                    :class="tab === 'endereco' ? 'bg-cyan-500 text-white' : 'text-gray-400 hover:text-white'"
                    class="flex-1 text-sm font-medium py-2 rounded-md transition">
                    Endereço
                </button>
            </div>

            <div x-show="tab === 'dados'">
                <form method="POST" :action="`{{ $urlBase }}/${selected.id}`" enctype="multipart/form-data" class="space-y-4">

                    @csrf
                    @method('PUT')

                    <label class="block border-2 border-dashed border-gray-700 rounded-lg h-28 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden">

                        <img
                            :src="selected.photo_url"
                            x-show="selected.photo_url"
                            :alt="selected.name"
                            class="absolute inset-0 w-full h-full object-cover">

                        <div
                            x-show="!selected.photo_url"
                            class="text-gray-500 text-sm">
                            Clique para selecionar uma imagem
                        </div>

                        <input
                            type="file"
                            name="photo"
                            accept="image/*"
                            class="hidden"
                            @change="
            const file = $event.target.files[0];

            if (file) {
                selected.photo_url = URL.createObjectURL(file);
            }
        ">
                    </label>

                    <div>
                        <label class="block text-gray-400 text-xs mb-1">Nome</label>
                        <input type="text" name="name" required :value="selected.name"
                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                    </div>

                    <div>
                        <label class="block text-gray-400 text-xs mb-1">E-mail</label>
                        <input type="email" name="email" required :value="selected.email"
                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                    </div>

                    <div>
                        <label class="block text-gray-400 required text-xs mb-1">CPF (somente números)</label>
                        <input type="text" name="cpf" maxlength="11" :value="selected.cpf"
                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-gray-400 text-xs mb-1">Telefone</label>
                            <input type="text" name="phone" :value="selected.phone"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-400 text-xs mb-1">Nascimento</label>
                            <input type="date" name="birth_date" :value="selected.birth_date"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-gray-400 text-xs mb-1">Nova senha (opcional)</label>
                            <input type="password" name="password"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-400 text-xs mb-1">Confirmar senha</label>
                            <input type="password" name="password_confirmation"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                            Salvar
                        </button>
                        <button type="button" @click="showEdit = false"
                            class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                            Cancelar
                        </button>
                    </div>

                </form>
            </div>

            <div x-show="tab === 'endereco'"
                x-data="cepAddressForm('{{ route('cep.search', ['zipCode' => '__CEP__']) }}', {
                    zip_code: selected.default_address?.zip_code ?? '',
                    street: selected.default_address?.street ?? '',
                    number: selected.default_address?.number ?? '',
                    neighborhood: selected.default_address?.neighborhood ?? '',
                    city: selected.default_address?.city ?? '',
                    state: selected.default_address?.state ?? '',
                    complement: selected.default_address?.complement ?? '',
                })">

                <form method="POST"
                    :action="selected.default_address ? `{{ url('/addresses') }}/${selected.default_address.id}` : `{{ route('addresses.store') }}`"
                    class="space-y-3">

                    @csrf
                    <template x-if="selected.default_address">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <input type="hidden" name="user_id" :value="selected.id">
                    <input type="hidden" name="is_default" value="1">

                    <x-address-fields />

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                            <span x-text="selected.default_address ? 'Atualizar endereço' : 'Cadastrar endereço'"></span>
                        </button>
                        <button type="button" @click="showEdit = false"
                            class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                            Fechar
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </template>

</x-modal-panel>