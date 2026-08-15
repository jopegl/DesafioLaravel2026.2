<x-app-layout>

    <div class="flex min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col"
            x-data="{
            showAddAddress: false,
            showEditAddress: false,
            showDeleteAccount: false,
            selectedAddress: null,

            openEditAddress(a) {
                this.selectedAddress = a;
                this.showEditAddress = true;
            },
        }">

            <main class="flex-1 px-8 py-8 max-w-3xl">

                <h2 class="text-xl font-semibold text-white mb-6">
                    Meu perfil
                </h2>

                @if (session('status') === 'profile-updated')
                <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/40 text-emerald-300 text-sm px-4 py-3">
                    Perfil atualizado com sucesso.
                </div>
                @endif

                @if (session('status') === 'password-updated')
                <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/40 text-emerald-300 text-sm px-4 py-3">
                    Senha atualizada com sucesso.
                </div>
                @endif

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


                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 p-6 mb-6">

                    <h3 class="text-white text-lg font-semibold mb-5">
                        Dados pessoais
                    </h3>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">

                        @csrf
                        @method('PATCH')

                        <div class="flex items-center gap-4"
                            x-data="{ preview: null }">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-700 shrink-0 ring-2 ring-gray-700">
                                <img :src="preview ?? '{{ userPhotoUrl($user->photo) }}'" class="w-full h-full object-cover">
                            </div>
                            <label class="text-sm text-cyan-400 hover:text-cyan-300 cursor-pointer">
                                Alterar foto
                                <input type="file" name="photo" accept="image/*" class="hidden"
                                    @change="preview = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>

                        <div>
                            <label class="block text-gray-400 text-xs mb-1">Nome</label>
                            <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>

                        <div>
                            <label class="block text-gray-400 text-xs mb-1">E-mail</label>
                            <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <p class="text-xs text-amber-400 mt-2">
                                Seu e-mail não está verificado.
                                <button form="send-verification" class="underline hover:text-amber-300">
                                    Reenviar e-mail de verificação.
                                </button>
                            </p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-gray-400 text-xs mb-1">CPF (somente números)</label>
                            <input type="text" name="cpf" maxlength="11" required value="{{ old('cpf', $user->cpf) }}"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="block text-gray-400 text-xs mb-1">Telefone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            </div>
                            <div class="flex-1">
                                <label class="block text-gray-400 text-xs mb-1">Nascimento</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                            Salvar
                        </button>

                    </form>

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>
                    @endif

                </div>

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 p-6 mb-6">

                    <h3 class="text-white text-lg font-semibold mb-1">
                        Alterar senha
                    </h3>
                    <p class="text-gray-500 text-xs mb-5">
                        Use uma senha longa e única para manter sua conta segura.
                    </p>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">

                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-gray-400 text-xs mb-1">Senha atual</label>
                            <input type="password" name="current_password"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            @error('current_password', 'updatePassword')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="block text-gray-400 text-xs mb-1">Nova senha</label>
                                <input type="password" name="password"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                                @error('password', 'updatePassword')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label class="block text-gray-400 text-xs mb-1">Confirmar nova senha</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                            Atualizar senha
                        </button>

                    </form>

                </div>

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 p-6 mb-6">

                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-white text-lg font-semibold">
                            Endereços
                        </h3>
                        <button @click="showAddAddress = true"
                            class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">
                            + Adicionar endereço
                        </button>
                    </div>

                    <div class="space-y-3">

                        @forelse ($addresses as $address)

                        <div class="flex items-start justify-between bg-[#15171e] border border-gray-800 rounded-lg px-4 py-3">

                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-white text-sm">
                                        {{ $address->street }}, {{ $address->number }}
                                    </span>
                                    @if ($address->is_default)
                                    <span class="text-[10px] uppercase tracking-wide bg-cyan-500/20 text-cyan-300 px-2 py-0.5 rounded-full">
                                        Padrão
                                    </span>
                                    @endif
                                </div>
                                <p class="text-gray-400 text-xs">
                                    {{ $address->neighborhood }}, {{ $address->city }}/{{ $address->state }} — CEP {{ $address->zip_code }}
                                </p>
                                @if ($address->complement)
                                <p class="text-gray-500 text-xs mt-0.5">{{ $address->complement }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 text-cyan-400 shrink-0 ml-4">

                                <button @click='openEditAddress(@json($address))' title="Editar" class="hover:text-cyan-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                    </svg>
                                </button>

                                <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                                    onsubmit="return confirm('Remover este endereço?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Excluir" class="hover:text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>

                            </div>

                        </div>

                        @empty

                        <p class="text-gray-500 text-sm">
                            Nenhum endereço cadastrado.
                        </p>

                        @endforelse

                    </div>

                </div>

                {{-- ===================== EXCLUIR CONTA ===================== --}}

                <div class="bg-[#1c1f2a] rounded-xl border border-red-900/40 p-6">

                    <h3 class="text-white text-lg font-semibold mb-1">
                        Excluir conta
                    </h3>
                    <p class="text-gray-500 text-xs mb-5">
                        Uma vez excluída, todos os seus dados serão permanentemente removidos.
                    </p>

                    <button @click="showDeleteAccount = true"
                        class="bg-red-500 hover:bg-red-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                        Excluir conta
                    </button>

                </div>

            </main>

            {{-- ===================== MODAL: ADICIONAR ENDEREÇO ===================== --}}

            <div x-show="showAddAddress" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showAddAddress = false" class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Adicionar endereço
                    </h3>

                    <form method="POST" action="{{ route('addresses.store') }}"
                        class="space-y-4"
                        x-data="{
                            cepLoading: false,
                            cepError: '',
                            addr: { zip_code: '', street: '', number: '', neighborhood: '', city: '', state: '', complement: '' },
                            buscarCep() {
                                if (this.addr.zip_code.length !== 8) return;
                                this.cepLoading = true;
                                this.cepError = '';
                                fetch(`{{ route('cep.search', ['zipCode' => '__CEP__']) }}`.replace('__CEP__', this.addr.zip_code))
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

                        @csrf

                        <div>
                            <label class="block text-gray-400 text-xs mb-1">CEP</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="zip_code" maxlength="8" required
                                    x-model="addr.zip_code"
                                    @input="
                                        addr.zip_code = addr.zip_code.replace(/\D/g, '');
                                        if (addr.zip_code.length === 8) buscarCep();
                                    "
                                    placeholder="Somente números"
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

                </div>

            </div>

            {{-- ===================== MODAL: EDITAR ENDEREÇO ===================== --}}

            <div x-show="showEditAddress" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showEditAddress = false" class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto" x-show="selectedAddress">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Editar endereço
                    </h3>

                    <template x-if="selectedAddress">
                        <form method="POST" :action="`{{ url('/addresses') }}/${selectedAddress.id}`"
                            class="space-y-4"
                            x-data="{
                                cepLoading: false,
                                cepError: '',
                                addr: {
                                    zip_code: selectedAddress.zip_code,
                                    street: selectedAddress.street,
                                    number: selectedAddress.number,
                                    neighborhood: selectedAddress.neighborhood,
                                    city: selectedAddress.city,
                                    state: selectedAddress.state,
                                    complement: selectedAddress.complement,
                                },
                                buscarCep() {
                                    if (this.addr.zip_code.length !== 8) return;
                                    this.cepLoading = true;
                                    this.cepError = '';
                                    fetch(`{{ route('cep.search', ['zipCode' => '__CEP__']) }}`.replace('__CEP__', this.addr.zip_code))
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

                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-gray-400 text-xs mb-1">CEP</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="zip_code" maxlength="8" required
                                        x-model="addr.zip_code"
                                        @input="
                                                addr.zip_code = addr.zip_code.replace(/\D/g, '');
                                                if (addr.zip_code.length === 8) buscarCep();
                                            "
                                        placeholder="Somente números"
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

                </div>

            </div>

            {{-- ===================== MODAL: EXCLUIR CONTA ===================== --}}

            <div x-show="showDeleteAccount" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4" x-transition.opacity>

                <div @click.outside="showDeleteAccount = false" class="bg-[#1c1f2a] w-full max-w-sm rounded-xl border border-gray-800 p-6">

                    <div class="text-center space-y-5">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>

                        <p class="text-white text-sm">
                            Tem certeza que deseja excluir sua conta? Essa ação não pode ser desfeita.
                        </p>

                        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-3">

                            @csrf
                            @method('DELETE')

                            <input type="password" name="password" placeholder="Confirme sua senha" required
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm text-center focus:outline-none focus:ring-1 focus:ring-red-400">
                            @error('password', 'userDeletion')
                            <p class="text-red-400 text-xs">{{ $message }}</p>
                            @enderror

                            <div class="flex gap-3">
                                <button type="submit"
                                    class="flex-1 bg-red-500 hover:bg-red-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                                    Excluir conta
                                </button>
                                <button type="button" @click="showDeleteAccount = false"
                                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                                    Cancelar
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>