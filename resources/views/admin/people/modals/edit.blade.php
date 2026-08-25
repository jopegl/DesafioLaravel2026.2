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

                    <label class="block border-2 border-dashed border-gray-700 rounded-lg h-64 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden">

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
                            <label class="block text-gray-400 text-xs mb-1">Telefone *</label>
                            <input type="text" name="phone" required :value="selected.phone"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-400 text-xs mb-1">Nascimento *</label>
                            <input type="date" name="birth_date" required :value="selected.birth_date ? selected.birth_date.slice(0, 10) : ''"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <!-- Editar Nova Senha -->
                        <div class="flex-1" x-data="{ showEditPass: false }">
                            <label class="block text-gray-400 text-xs mb-1">Nova senha (opcional)</label>
                            <div class="relative">
                                <input :type="showEditPass ? 'text' : 'password'" name="password"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg pl-3 pr-10 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                <button type="button" @click="showEditPass = !showEditPass"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                                    <span x-show="!showEditPass" class="block">
                                        <x-icons.eye />
                                    </span>
                                    <svg x-show="showEditPass" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Editar Confirmar Senha -->
                        <div class="flex-1" x-data="{ showEditPassConfirm: false }">
                            <label class="block text-gray-400 text-xs mb-1">Confirmar senha</label>
                            <div class="relative">
                                <input :type="showEditPassConfirm ? 'text' : 'password'" name="password_confirmation"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg pl-3 pr-10 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                <button type="button" @click="showEditPassConfirm = !showEditPassConfirm"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                                    <span x-show="!showEditPassConfirm" class="block">
                                        <x-icons.eye />
                                    </span>
                                    <svg x-show="showEditPassConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
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