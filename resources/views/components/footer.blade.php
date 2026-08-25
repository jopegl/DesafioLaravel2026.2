<footer class="bg-gray-800 text-white mt-auto border-t border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="space-y-3">
                <h3 class="text-lg font-bold text-cyan-400">EmporiO</h3>
                <p class="text-gray-400 text-xs leading-relaxed">
                    Sua plataforma completa para compras e vendas com rapidez e segurança.
                </p>
            </div>


            <div>
                <h4 class="text-sm font-semibold text-gray-200 mb-3 uppercase tracking-wider">Navegação</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Início</a></li>
                    <li><a href="{{ route('contact.create') }}" class="hover:text-white transition">Contato</a></li>
                    <li><a href="{{ route('home') }}#categorias" class="hover:text-white transition">Categorias</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-200 mb-3 uppercase tracking-wider">Minha Conta</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @auth
                    <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Meu Painel</a></li>
                    @if(!auth()->user()->is_admin)
                    <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Carrinho</a></li>
                    @endif
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition">Perfil</a></li>
                    @else
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Entrar</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Cadastrar-se</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-200 mb-3 uppercase tracking-wider">Formas de Pagamento</h4>
                <p class="text-xs text-gray-400 mb-3">Aceitamos os principais meios de pagamento através de:</p>
                <div class="flex items-center space-x-4 bg-gray-900/60 p-3 rounded-lg border border-gray-700/50 w-fit">
                    <img src="https://http2.mlstatic.com/frontend-assets/ui-navigation/5.19.1/mercadopago/logo__small.png"
                        alt="Mercado Pago"
                        class="h-6 object-contain"
                        title="Mercado Pago">

                    <span class="text-gray-600">|</span>

                    <img src="https://play-lh.googleusercontent.com/KzzfrHFiz-RlJyF4L35qYr_3vLhOQJFxCp_v-ac31MDtpm6YpXZCaONqPvHvoiCO1g=w600-h300-pc0xffffff-pd"
                        alt="PagBank"
                        class="h-5 object-contain"
                        title="PagBank">
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-700/60 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 gap-4">
            <div>
                &copy; {{ date('Y') }} EmporiO. Todos os direitos reservados.
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition">Termos de Uso</a>
                <a href="#" class="hover:text-white transition">Política de Privacidade</a>
            </div>
        </div>
    </div>
</footer>