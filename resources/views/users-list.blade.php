<x-app-layout>

    <div class="flex min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col"
            x-data="{
            showCreate: false,
            showView: false,
            showEdit: false,
            showDelete: false,
            selected: null,

            openView(u) {
                this.selected = u;
                this.showView = true;
            },

            openEdit(u) {
                this.selected = u;
                this.showEdit = true;
            },

            openDelete(u) {
                this.selected = u;
                this.showDelete = true;
            },
        }">

            <main class="flex-1 px-8 py-8">

                @if (session('success'))
                <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/40 text-emerald-300 text-sm px-4 py-3">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-300 text-sm px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex items-center justify-between mb-6">

                    <h2 class="text-xl font-semibold text-white">
                        Usuários cadastrados
                    </h2>

                    <div class="flex items-center gap-3">

                        <form method="GET" action="{{ route('users.index') }}">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar por nome ou e-mail..."
                                class="bg-gray-800 border border-gray-700 rounded-full px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500 w-64">
                        </form>

                        <button @click="showCreate = true"
                            class="bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition whitespace-nowrap">
                            Cadastrar usuário
                        </button>

                    </div>

                </div>

                <div class="bg-[#1c1f2a] rounded-xl overflow-hidden border border-gray-800/60">

                    <table class="w-full text-sm text-left">

                        <thead>
                            <tr class="text-gray-400 border-b border-gray-800/60">
                                <th class="px-5 py-4 font-medium w-20"></th>
                                <th class="px-5 py-4 font-medium">Nome</th>
                                <th class="px-5 py-4 font-medium">E-mail</th>
                                <th class="px-5 py-4 font-medium">Telefone</th>
                                <th class="px-5 py-4 font-medium">Endereço</th>
                                <th class="px-5 py-4 font-medium">Cadastrado em</th>
                                <th class="px-5 py-4 font-medium text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-200">

                            @forelse ($users as $user)

                            <tr class="border-b border-gray-800/40 last:border-0 hover:bg-white/[0.02]">

                                <td class="px-5 py-4">
                                    <img src="{{ userPhotoUrl($user->photo) }}"
                                        alt="{{ $user->name }}"
                                        class="w-10 h-10 rounded-full object-cover bg-gray-700">
                                </td>

                                <td class="px-5 py-4">
                                    {{ $user->name }}
                                </td>

                                <td class="px-5 py-4 text-gray-400">
                                    {{ $user->email }}
                                </td>

                                <td class="px-5 py-4 text-gray-400">
                                    {{ $user->phone ?? '—' }}
                                </td>

                                <td class="px-5 py-4 text-gray-400">
                                    @if($user->defaultAddress)
                                    {{ $user->defaultAddress->city }}/{{ $user->defaultAddress->state }}
                                    @else
                                    <span class="text-gray-600">Não cadastrado</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-gray-400">
                                    {{ $user->created_at->format('d-M-Y') }}
                                </td>

                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-3 text-cyan-400">

                                        <button
                                            @click='openView(@json(array_merge($user->toArray(), ["photo_url" => userPhotoUrl($user->photo)])))'
                                            title="Visualizar"
                                            class="hover:text-cyan-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>

                                        <button
                                            @click='openEdit(@json(array_merge($user->toArray(), ["photo_url" => userPhotoUrl($user->photo)])))'
                                            title="Editar"
                                            class="hover:text-cyan-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                            </svg>
                                        </button>

                                        <button
                                            @click='openDelete(@json($user))'
                                            title="Excluir"
                                            class="hover:text-red-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                    Nenhum usuário cadastrado até o momento.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            </main>

            {{-- modal criar--}}

            <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showCreate = false" class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Criar usuário
                    </h3>

                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-4">

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
                            <label class="block text-gray-400 text-xs mb-1">CPF (somente números)</label>
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

                        {{-- Endereço: seção opcional. Se o CEP for preenchido, os campos
                             viajam junto no mesmo POST sob address[...] e o controller
                             cria o endereço logo depois do usuário. --}}
                        <div class="border-t border-gray-800 pt-4"
                            x-data="{
                                showAddress: false,
                                cepLoading: false,
                                cepError: '',
                                addr: { zip_code: '', street: '', number: '', neighborhood: '', city: '', state: '', complement: '' },
                                buscarCep() {
                                    if (this.addr.zip_code.length !== 8) return;
                                    this.cepLoading = true;
                                    this.cepError = '';
                                    fetch(`/cep/${this.addr.zip_code}`)
                                        .then(r => r.json())
                                        .then(d => {
                                            if (d.error) { this.cepError = d.error; return; }
                                            this.addr.street = d.logradouro || '';
                                            this.addr.neighborhood = d.bairro || '';
                                            this.addr.city = d.localidade || '';
                                            this.addr.state = d.uf || '';
                                            this.addr.complement = d.complemento || '';
                                        })
                                        .catch(() => this.cepError = 'Erro ao buscar CEP.')
                                        .finally(() => this.cepLoading = false);
                                }
                            }">

                            <button type="button" @click="showAddress = !showAddress"
                                class="text-cyan-400 hover:text-cyan-300 text-sm font-medium flex items-center gap-1">
                                <span x-text="showAddress ? '− Remover endereço' : '+ Adicionar endereço agora'"></span>
                            </button>

                            <template x-if="showAddress">
                                <div class="space-y-3 mt-3">

                                    <div>
                                        <label class="block text-gray-400 text-xs mb-1">CEP</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="address[zip_code]" maxlength="8"
                                                x-model="addr.zip_code"
                                                @input="addr.zip_code = addr.zip_code.replace(/\D/g, '')"
                                                @blur="buscarCep()"
                                                placeholder="Somente números"
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                            <span x-show="cepLoading" class="text-xs text-gray-400 whitespace-nowrap">buscando...</span>
                                        </div>
                                        <p x-show="cepError" x-text="cepError" class="text-red-400 text-xs mt-1"></p>
                                    </div>

                                    <div>
                                        <label class="block text-gray-400 text-xs mb-1">Rua</label>
                                        <input type="text" name="address[street]" x-model="addr.street"
                                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <label class="block text-gray-400 text-xs mb-1">Número</label>
                                            <input type="text" name="address[number]" x-model="addr.number"
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-400 text-xs mb-1">Bairro</label>
                                            <input type="text" name="address[neighborhood]" x-model="addr.neighborhood"
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <label class="block text-gray-400 text-xs mb-1">Cidade</label>
                                            <input type="text" name="address[city]" x-model="addr.city"
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                        <div class="w-20">
                                            <label class="block text-gray-400 text-xs mb-1">UF</label>
                                            <input type="text" name="address[state]" maxlength="2" x-model="addr.state"
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-gray-400 text-xs mb-1">Complemento</label>
                                        <input type="text" name="address[complement]" x-model="addr.complement"
                                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                    </div>

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

                </div>

            </div>

            {{-- modal view --}}

            <div x-show="showView" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showView = false" class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto" x-show="selected">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Detalhes do usuário
                    </h3>

                    <template x-if="selected">
                        <div class="space-y-4">

                            <img :src="selected.photo_url" x-show="selected.photo_url" :alt="selected.name"
                                class="w-20 h-20 mx-auto object-cover rounded-full border border-gray-700">

                            <div>
                                <p class="text-gray-400 text-xs mb-1">Nome</p>
                                <p class="text-white text-sm" x-text="selected.name"></p>
                            </div>

                            <div>
                                <p class="text-gray-400 text-xs mb-1">E-mail</p>
                                <p class="text-white text-sm" x-text="selected.email"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-400 text-xs mb-1">Telefone</p>
                                    <p class="text-white text-sm" x-text="selected.phone || '—'"></p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-xs mb-1">Nascimento</p>
                                    <p class="text-white text-sm" x-text="selected.birth_date || '—'"></p>
                                </div>
                            </div>

                            <div>
                                <p class="text-gray-400 text-xs mb-1">Endereço padrão</p>
                                <template x-if="selected.default_address">
                                    <p class="text-white text-sm"
                                        x-text="`${selected.default_address.street}, ${selected.default_address.number} - ${selected.default_address.neighborhood}, ${selected.default_address.city}/${selected.default_address.state}`">
                                    </p>
                                </template>
                                <template x-if="!selected.default_address">
                                    <p class="text-gray-500 text-sm">Nenhum endereço cadastrado.</p>
                                </template>
                            </div>

                            <button type="button" @click="showView = false"
                                class="w-full border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition mt-2">
                                Fechar
                            </button>

                        </div>
                    </template>

                </div>

            </div>

            {{-- modal editar--}}

            <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showEdit = false" class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto" x-show="selected">

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

                            {{-- ---- Aba: Dados ---- --}}
                            <div x-show="tab === 'dados'">
                                <form method="POST" :action="`{{ url('/admin/users') }}/${selected.id}`" enctype="multipart/form-data" class="space-y-4">

                                    @csrf
                                    @method('PUT')

                                    <label class="block border-2 border-dashed border-gray-700 rounded-lg h-28 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden">
                                        <img :src="selected.photo_url" x-show="selected.photo_url" :alt="selected.name" class="absolute inset-0 w-full h-full object-cover">
                                        <input type="file" name="photo" accept="image/*" class="hidden">
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
                                        <label class="block text-gray-400 text-xs mb-1">CPF</label>
                                        <input type="text" name="cpf" maxlength="11" required :value="selected.cpf"
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

                            {{-- ---- Aba: Endereço (usa AddressController diretamente) ---- --}}
                            <div x-show="tab === 'endereco'"
                                x-data="{
                                    cepLoading: false,
                                    cepError: '',
                                    addr: {
                                        zip_code: selected.default_address?.zip_code ?? '',
                                        street: selected.default_address?.street ?? '',
                                        number: selected.default_address?.number ?? '',
                                        neighborhood: selected.default_address?.neighborhood ?? '',
                                        city: selected.default_address?.city ?? '',
                                        state: selected.default_address?.state ?? '',
                                        complement: selected.default_address?.complement ?? '',
                                    },
                                    buscarCep() {
                                        if (this.addr.zip_code.length !== 8) return;
                                        this.cepLoading = true;
                                        this.cepError = '';
                                        fetch(`/cep/${this.addr.zip_code}`)
                                            .then(r => r.json())
                                            .then(d => {
                                                if (d.error) { this.cepError = d.error; return; }
                                                this.addr.street = d.logradouro || '';
                                                this.addr.neighborhood = d.bairro || '';
                                                this.addr.city = d.localidade || '';
                                                this.addr.state = d.uf || '';
                                                this.addr.complement = d.complemento || '';
                                            })
                                            .catch(() => this.cepError = 'Erro ao buscar CEP.')
                                            .finally(() => this.cepLoading = false);
                                    }
                                }">

                                <form method="POST"
                                    :action="selected.default_address ? `{{ url('/addresses') }}/${selected.default_address.id}` : `{{ route('addresses.store') }}`"
                                    class="space-y-3">

                                    @csrf
                                    <template x-if="selected.default_address">
                                        <input type="hidden" name="_method" value="PUT">
                                    </template>

                                    <input type="hidden" name="user_id" :value="selected.id">
                                    <input type="hidden" name="is_default" value="1">

                                    <div>
                                        <label class="block text-gray-400 text-xs mb-1">CEP</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="zip_code" maxlength="8"
                                                x-model="addr.zip_code"
                                                @input="addr.zip_code = addr.zip_code.replace(/\D/g, '')"
                                                @blur="buscarCep()"
                                                required
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                            <span x-show="cepLoading" class="text-xs text-gray-400 whitespace-nowrap">buscando...</span>
                                        </div>
                                        <p x-show="cepError" x-text="cepError" class="text-red-400 text-xs mt-1"></p>
                                    </div>

                                    <div>
                                        <label class="block text-gray-400 text-xs mb-1">Rua</label>
                                        <input type="text" name="street" x-model="addr.street" required
                                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <label class="block text-gray-400 text-xs mb-1">Número</label>
                                            <input type="text" name="number" x-model="addr.number" required
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-400 text-xs mb-1">Bairro</label>
                                            <input type="text" name="neighborhood" x-model="addr.neighborhood" required
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <label class="block text-gray-400 text-xs mb-1">Cidade</label>
                                            <input type="text" name="city" x-model="addr.city" required
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                        <div class="w-20">
                                            <label class="block text-gray-400 text-xs mb-1">UF</label>
                                            <input type="text" name="state" maxlength="2" x-model="addr.state" required
                                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-gray-400 text-xs mb-1">Complemento</label>
                                        <input type="text" name="complement" x-model="addr.complement"
                                            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                    </div>

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

                </div>

            </div>

            {{-- modal excluir--}}

            <div x-show="showDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showDelete = false" class="bg-[#1c1f2a] w-full max-w-sm rounded-xl border border-gray-800 p-6" x-show="selected">

                    <template x-if="selected">
                        <div class="text-center space-y-5">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>

                            <p class="text-white text-sm">
                                Tem certeza que deseja excluir
                                <span class="font-semibold" x-text="selected.name"></span>?
                                Essa ação não pode ser desfeita.
                            </p>

                            <form method="POST" :action="`{{ url('/admin/users') }}/${selected.id}`" class="flex gap-3">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="flex-1 bg-red-500 hover:bg-red-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                                    Excluir
                                </button>

                                <button type="button" @click="showDelete = false"
                                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                                    Cancelar
                                </button>

                            </form>

                        </div>
                    </template>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>