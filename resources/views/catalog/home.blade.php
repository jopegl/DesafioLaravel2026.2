<x-app-layout>
    <div class="bg-primary-900 min-h-screen text-white">

        @if(!request('search'))
        {{-- Banner Hero (topo) --}}
        <div class="relative bg-gradient-to-r from-gray-900 to-gray-800 overflow-hidden">
            <img src="{{ asset('images/hero-iphone.png') }}" alt="Produto em destaque" class="w-full h-64 md:h-96 object-cover">
        </div>
        @endif

        <div class="max-w-7xl mx-auto px-6 py-10">

            <div class="mb-8">
                <div class="flex items-center gap-3">
                    <x-product-filter :action="route('home')" :categories="$categories" />

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

        </div>
    </div>
</x-app-layout>
