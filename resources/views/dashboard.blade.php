<x-app-layout>
    <div class="bg-primary-900 min-h-screen text-white">

        <div class="max-w-7xl mx-auto px-6 py-12">

            <div class="mb-12 pb-8 border-b border-white/10">
                <p class="text-sm font-medium text-primary-500 tracking-wide uppercase mb-2">
                    Painel de controle
                </p>

                <h1 class="text-3xl sm:text-4xl font-bold text-white">
                    Olá, {{ auth()->user()->name ?? 'bem-vindo' }} 👋
                </h1>

                <p class="text-gray-400 mt-2">
                    Gerencie sua conta, produtos e vendas em um só lugar.
                </p>
            </div>

            {{-- ADMINISTRAÇÃO --}}
            @if(auth()->user()->is_admin)
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Administração
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    {{-- ADMINS --}}
                    <a href="{{ route('admins.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2h8z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Administradores
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Gerenciar administradores
                        </span>
                    </a>


                    {{-- USUÁRIOS --}}
                    <a href="{{ route('users.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm8 3a4 4 0 10-4-4" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Usuários
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Gerenciar usuários
                        </span>
                    </a>

                </div>
            </section>
            @endif


            {{-- CONTA --}}
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Conta
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    {{-- PERFIL --}}
                    <a href="{{ route('profile.edit') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Meu Perfil
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Dados pessoais e senha
                        </span>
                    </a>

                </div>
            </section>


            {{-- PRODUTOS --}}
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Produtos
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('products.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Produtos
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Catálogo e estoque
                        </span>
                    </a>

                </div>
            </section>


            {{-- VENDAS --}}
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Vendas
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('sales.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.75 8.25h.008v.008h-.008V8.25ZM5.25 15.75h.008v.008H5.25v-.008Z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Vendas
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Histórico e relatórios
                        </span>
                    </a>

                </div>
            </section>


            {{-- CONTATOS --}}
            @if(auth()->user()->is_admin)
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Administração
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('contacts.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25Z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Contatos
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Mensagens de contato
                        </span>
                    </a>

                </div>
            </section>
            @endif

        </div>
    </div>
</x-app-layout>