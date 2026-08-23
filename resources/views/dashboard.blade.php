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
                    Gerencie sua conta, produtos e compras/vendas em um só lugar.
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
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2h8z" />
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
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm8 3a4 4 0 10-4-4" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Usuários
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Gerenciar usuários
                        </span>
                    </a>

                    {{-- CONTATOS (MENSAGENS) --}}
                    <a href="{{ route('contacts.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Mensagens de Contato
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Responder suporte
                        </span>
                    </a>

                    {{-- DISPARAR E-MAIL --}}
                    <a href="{{ route('admin.email.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Enviar E-mail
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Disparar comunicados
                        </span>
                    </a>

                </div>
            </section>
            @endif


            {{-- CONTA & ATENDIMENTO --}}
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Conta & Suporte
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    {{-- PERFIL --}}
                    <a href="{{ route('profile.edit') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Meu Perfil
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Dados pessoais e senha
                        </span>
                    </a>

                    {{-- CONTATE-NOS (Disponível para qualquer auth) --}}
                    <a href="{{ route('contact.create') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Contate-nos
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Enviar uma mensagem
                        </span>
                    </a>

                </div>
            </section>


            {{-- PRODUTOS --}}
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Catálogo
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('products.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Produtos
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Gerenciar catálogo e estoque
                        </span>
                    </a>

                </div>
            </section>


            {{-- VENDAS E COMPRAS --}}
            <section class="mb-12">

                <div class="flex items-center gap-3 mb-5">
                    <h2 class="text-xs font-semibold text-gray-400 tracking-widest uppercase">
                        Pedidos & Transações
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <a href="{{ route('sales.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            @if(!auth()->user()->is_admin)
                            Minhas Vendas
                            @else
                            Vendas
                            @endif
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Histórico de vendas efetuadas
                        </span>
                    </a>

                    {{-- MINHAS COMPRAS E CARRINHO (Apenas Usuários - Middleware user.only) --}}
                    @if(!auth()->user()->is_admin)

                    <a href="{{ route('purchases.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Minhas Compras
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Histórico de pedidos comprados
                        </span>
                    </a>

                    <a href="{{ route('cart.index') }}"
                        class="group relative bg-gray-800/60 backdrop-blur border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:shadow-xl hover:shadow-primary-500/10">

                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/0 to-primary-500/0 group-hover:from-primary-500/10 group-hover:to-transparent transition-all duration-300"></div>

                        <div class="relative w-14 h-14 rounded-full bg-primary-500/10 flex items-center justify-center mb-4 ring-1 ring-primary-500/20 group-hover:bg-primary-500/20 group-hover:ring-primary-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>

                        <span class="relative text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                            Meu Carrinho
                        </span>

                        <span class="relative text-xs text-gray-500 mt-1">
                            Visualizar itens selecionados
                        </span>
                    </a>

                    @endif

                </div>
            </section>

        </div>
    </div>
</x-app-layout>