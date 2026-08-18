<x-app-layout>

    <div class="flex flex-col lg:flex-row min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col" x-data="addressModals">

            <main class="flex-1 px-4 sm:px-8 py-8 w-full max-w-3xl">

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

                <x-alerts />

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 p-6 mb-6">

                    <h3 class="text-white text-lg font-semibold mb-5">
                        Dados pessoais
                    </h3>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">

                        @csrf
                        @method('PATCH')

                        <div class="flex items-center gap-4" x-data="{ preview: null }">
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
                            <input type="text" name="cpf" maxlength="11" value="{{ old('cpf', $user->cpf) }}"
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
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

                        <div class="flex flex-col sm:flex-row gap-4">
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

                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 bg-[#15171e] border border-gray-800 rounded-lg px-4 py-3">

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

                            <div class="flex items-center gap-3 text-cyan-400 shrink-0">

                                <button @click='openEditAddress(@json($address))' title="Editar" class="hover:text-cyan-300">
                                    <x-icons.pencil class="w-4 h-4" />
                                </button>

                                <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                                    onsubmit="return confirm('Remover este endereço?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Excluir" class="hover:text-red-400">
                                        <x-icons.trash class="w-4 h-4" />
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

            @include('profile.modals.add-address')
            @include('profile.modals.edit-address')
            @include('profile.modals.delete-account')

        </div>

    </div>

</x-app-layout>