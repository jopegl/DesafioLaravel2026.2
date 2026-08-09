<x-app-layout>
    <div class="bg-primary-900 min-h-screen text-white">

        <div class="max-w-7xl mx-auto px-6 py-12">

            <div class="mb-12 pb-8 border-b border-white/10">
                <p class="text-sm font-medium text-primary-500 tracking-wide uppercase mb-2">Painel de controle</p>
                <h1 class="text-3xl sm:text-4xl font-bold text-white">
                    Olá, {{ auth()->user()->name ?? 'bem-vindo' }} 👋
                </h1>
                <p class="text-gray-400 mt-2">Gerencie sua conta, produtos e vendas em um só lugar.</p>
            </div>

            <section class="mb-12">
                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">Conta</h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('profile.edit') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>
                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Meu Perfil</span>
                        <span class="relative text-xs text-gray-500 mt-1">Dados pessoais e senha</span>
                    </a>

                </div>
            </section>

            <section class="mb-12">
                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">Produtos</h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('products.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>
                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Gerenciar Produtos</span>
                        <span class="relative text-xs text-gray-500 mt-1">Catálogo e estoque</span>
                    </a>

                </div>
            </section>

            <section class="mb-12">
                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">Vendas</h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('sales.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>
                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6m-6 0H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h2l2 2h4a2 2 0 012 2v10a2 2 0 01-2 2h-2" />
                            </svg>
                        </div>
                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Ver Vendas</span>
                        <span class="relative text-xs text-gray-500 mt-1">Histórico e relatórios</span>
                    </a>

                </div>
            </section>

            {{-- somente admin --}}
            @if(auth()->user()->is_admin)
            <section class="mb-12">
                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">Administração</h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('admin.email.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>
                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Enviar E-mail</span>
                        <span class="relative text-xs text-gray-500 mt-1">Comunicação com usuários</span>
                    </a>

                </div>
            </section>
            @endif

        </div>
    </div>
</x-app-layout>