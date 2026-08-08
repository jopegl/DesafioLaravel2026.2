<x-app-layout>
    <div class="bg-primary-900 min-h-screen text-white">

        @if(!request('search'))
        {{-- Banner Hero (topo) --}}
        <div class="relative bg-gradient-to-r from-gray-900 to-gray-800 overflow-hidden">
            <img src="{{ asset('images/hero-iphone.png') }}" alt="Produto em destaque" class="w-full h-64 md:h-96 object-cover">
        </div>
        @endif

        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Filtros --}}
            <div class="mb-8 relative" x-data="{ open: false }">
                <div class="flex items-center gap-3">
                    <button @click="open = !open" type="button"
                        class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm px-4 py-2 rounded-full transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrar
                        @if(request('category') || request('price_min') || request('price_max') || request('in_stock') || (request('sort') && request('sort') != 'recent'))
                        <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                        @endif
                    </button>
                    <!-- Busca -->
                    <div class="flex-1 flex justify-center sm:justify-start max-w-xs">
                        <form method="GET" action="{{ route('home') }}" class="w-full">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar produtos..."
                                class="w-full bg-gray-800 border border-gray-700 rounded-full px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-primary-500">
                        </form>
                    </div>
                </div>

                {{-- Dropdown --}}
                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute z-20 mt-2 w-80 bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-5"
                    style="display: none;">

                    <form method="GET" action="{{ route('home') }}" class="space-y-4">

                        {{-- Preserva busca ativa --}}
                        @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div>
                            <label class="block text-xs text-gray-400 mb-2">Categoria</label>
                            <select name="category"
                                class="bg-gray-700 text-white text-sm rounded-md border-gray-600 w-full focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Todas</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-gray-400 mb-2">Faixa de preço</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="price_min" value="{{ request('price_min') }}"
                                    placeholder="Min"
                                    class="bg-gray-700 text-white text-sm rounded-md border-gray-600 w-full focus:border-primary-500 focus:ring-primary-500">
                                <span class="text-gray-500">—</span>
                                <input type="number" name="price_max" value="{{ request('price_max') }}"
                                    placeholder="Max"
                                    class="bg-gray-700 text-white text-sm rounded-md border-gray-600 w-full focus:border-primary-500 focus:ring-primary-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs text-gray-400 mb-2">Ordenar por</label>
                            <select name="sort"
                                class="bg-gray-700 text-white text-sm rounded-md border-gray-600 w-full focus:border-primary-500 focus:ring-primary-500">
                                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Mais recentes</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Menor preço</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Maior preço</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="in_stock" id="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                class="rounded border-gray-600 text-primary-500 focus:ring-primary-500">
                            <label for="in_stock" class="text-sm text-gray-300">Apenas em estoque</label>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                            <button type="submit"
                                class="flex-1 bg-primary-500 hover:opacity-90 text-white text-sm py-2 rounded-full transition">
                                Aplicar
                            </button>
                            @if(request('category') || request('price_min') || request('price_max') || request('in_stock') || request('sort'))
                            <a href="{{ route('home', array_filter(['search' => request('search')])) }}"
                                class="text-xs text-gray-400 hover:text-white transition px-2">
                                Limpar
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if (request('search'))
            <p class="text-2xl font-bold text-white mb-4">Você buscou por: "{{ request('search') }}"</p>
            @endif

            {{-- Produtos + Busca --}}
            <div id="products">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg text-gray-400">Produtos</h2>

                </div>

                {{-- Grid de produtos --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                    <a href="{{ route('product.page', $product) }}">
                        <div class="group bg-gray-800 rounded-xl p-4 flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-primary-500/20 hover:bg-gray-700">
                            <div class="block mb-3 overflow-hidden rounded-lg">
                                <img
                                    src="{{ productPhotoUrl($product->photo) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-32 object-contain transition-transform duration-300 group-hover:scale-110">
                            </div>

                            <h3 class="text-sm text-gray-300 line-clamp-2">
                                {{ $product->name }}
                            </h3>

                            <p class="text-lg font-bold text-white mt-2">
                                {{ formatPrice($product->price)}}
                            </p>

                            <span class="block w-full bg-primary-500 group-hover:bg-primary-400 text-white text-sm py-2 rounded-full transition-colors duration-300 mt-3 text-center">
                                Comprar
                            </span>
                        </div>
                    </a>
                    @empty
                    <p class="col-span-4 text-center text-gray-500 py-10">
                        Nenhum produto encontrado.
                    </p>
                    @endforelse
                </div>

                {{-- Paginação --}}
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>


            <!--   @if(!request('search'))
            {{-- Banner 2 / Promoções (carrossel) --}}
            <div class="mt-16" x-data="{ slide: 0, slides: 3 }" x-init="setInterval(() => slide = (slide + 1) % slides, 4000)">
                <h2 class="text-lg text-gray-400 mb-4">Banner 2</h2>

                <div class="relative bg-gray-800 rounded-xl overflow-hidden">
                    <div class="flex transition-transform duration-700 ease-in-out" :style="`transform: translateX(-${slide * 100}%)`">

                        {{-- Slide 1 --}}
                        <div class="w-full flex-shrink-0 flex items-center justify-between px-10 py-12">
                            <div class="text-center flex-1">
                                <h3 class="text-3xl font-bold">Promoções</h3>
                                <p class="text-gray-400 mt-2">Confira as melhores promoções do site</p>
                                <a href="#products" class="inline-block mt-4 px-6 py-2 bg-primary-500 hover:opacity-90 rounded-full text-sm transition">
                                    Ir agora
                                </a>
                            </div>
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
            @endif -->

        </div>
    </div>
</x-app-layout>