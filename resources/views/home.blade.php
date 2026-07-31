<x-app-layout>
    <div class="bg-gray-900 min-h-screen text-white">

        {{-- Banner Hero (topo) --}}
        <div class="relative bg-gradient-to-r from-gray-900 to-gray-800 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-16 flex items-center justify-between">
                <div class="hidden md:block">
                    {{-- Substitua pela imagem do produto em destaque --}}
                    <img src="{{ asset('images/hero-iphone.png') }}" alt="Produto em destaque" class="h-64 object-contain">
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Categorias --}}
            <div class="mb-8">
                <h2 class="text-lg text-gray-400 mb-4">Category</h2>

                <div class="bg-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-sm text-gray-400">
                            Filtrar por <span class="text-blue-400">categoria</span>
                        </p>
                    </div>

                    <div class="flex items-center justify-between gap-4 overflow-x-auto pb-2">
                        <a href="{{ route('home') }}"
                            class="flex flex-col items-center gap-2 text-xs {{ !request('categoria') ? 'text-blue-400' : 'text-gray-400' }} hover:text-blue-400 transition">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </div>
                            Todos
                        </a>

                        @foreach ($categorias as $categoria)
                        <a href="{{ route('home', ['categoria' => $categoria->id]) }}"
                            class="flex flex-col items-center gap-2 text-xs {{ request('categoria') == $categoria->id ? 'text-blue-400' : 'text-gray-400' }} hover:text-blue-400 transition whitespace-nowrap">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            {{ $categoria->nome }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Produtos + Busca --}}
            <div id="produtos">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg text-gray-400">Products</h2>

                    <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2">
                        @if (request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                        @endif

                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                name="busca"
                                value="{{ request('busca') }}"
                                placeholder="Filtrar produtos..."
                                class="bg-gray-800 border border-gray-700 rounded-full pl-9 pr-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                        </div>
                    </form>
                </div>

                {{-- Grid de produtos --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @forelse ($produtos as $produto)
                    <div class="bg-gray-800 rounded-xl p-4 flex flex-col">
                        <a href="{{ route('products.show', $produto) }}" class="block mb-3">
                            <img
                                src="{{ $produto->foto ? asset('storage/' . $produto->foto) : asset('images/placeholder.png') }}"
                                alt="{{ $produto->nome }}"
                                class="w-full h-32 object-contain">
                        </a>

                        <a href="{{ route('products.show', $produto) }}">
                            <h3 class="text-sm text-gray-300 hover:text-white transition line-clamp-2">
                                {{ $produto->nome }}
                            </h3>
                        </a>

                        <p class="text-lg font-bold text-white mt-2">
                            R${{ number_format($produto->preco, 0, ',', '.') }}
                        </p>

                        @auth
                        @if (auth()->user()->is_admin ?? false)
                        {{-- Admin não vê botão de comprar --}}
                        @else
                        <form method="POST" action="{{ route('cart.store', $produto) }}" class="mt-3">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 rounded-full transition">
                                Comprar agora
                            </button>
                        </form>
                        @endif
                        @endauth
                    </div>
                    @empty
                    <p class="col-span-4 text-center text-gray-500 py-10">
                        Nenhum produto encontrado.
                    </p>
                    @endforelse
                </div>

                {{-- Paginação --}}
                <div class="mt-8">
                    {{ $produtos->links() }}
                </div>
            </div>

            {{-- Banner 2 / Promoções (carrossel) --}}
            <div class="mt-16" x-data="{ slide: 0, slides: 3 }" x-init="setInterval(() => slide = (slide + 1) % slides, 4000)">
                <h2 class="text-lg text-gray-400 mb-4">Banner 2</h2>

                <div class="relative bg-gray-800 rounded-xl overflow-hidden">
                    <div class="flex transition-transform duration-700 ease-in-out" :style="`transform: translateX(-${slide * 100}%)`">

                        {{-- Slide 1 --}}
                        <div class="w-full flex-shrink-0 flex items-center justify-between px-10 py-12">
                            <img src="{{ asset('images/promo-tablet.png') }}" alt="Promoção tablet" class="h-32 hidden md:block">
                            <div class="text-center flex-1">
                                <h3 class="text-3xl font-bold">Promoções</h3>
                                <p class="text-gray-400 mt-2">Confira as melhores promoções do site</p>
                                <a href="#produtos" class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-full text-sm transition">
                                    Ir agora
                                </a>
                            </div>
                            <img src="{{ asset('images/promo-watch.png') }}" alt="Promoção relógio" class="h-32 hidden md:block">
                        </div>

                        {{-- Slide 2 --}}
                        <div class="w-full flex-shrink-0 flex items-center justify-center px-10 py-12">
                            <div class="text-center">
                                <h3 class="text-3xl font-bold">Frete grátis</h3>
                                <p class="text-gray-400 mt-2">Em compras acima de R$300</p>
                            </div>
                        </div>

                        {{-- Slide 3 --}}
                        <div class="w-full flex-shrink-0 flex items-center justify-center px-10 py-12">
                            <div class="text-center">
                                <h3 class="text-3xl font-bold">Novidades toda semana</h3>
                                <p class="text-gray-400 mt-2">Fique de olho nos lançamentos</p>
                            </div>
                        </div>
                    </div>

                    {{-- Indicadores --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                        <template x-for="i in slides">
                            <button
                                @click="slide = i - 1"
                                class="w-2 h-2 rounded-full"
                                :class="slide === i - 1 ? 'bg-white' : 'bg-gray-600'"></button>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>