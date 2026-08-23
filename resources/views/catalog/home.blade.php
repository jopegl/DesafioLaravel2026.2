<x-app-layout>
    <div class="bg-primary-900 min-h-screen text-white">

        @if(!request('search'))
        <section class="hero-carousel relative w-full h-72 md:h-[28rem] overflow-hidden bg-gray-900">
            <div class="hero-track h-full">


                @foreach ($heroSlides as $index => $slide)
                <div class="hero-slide absolute inset-0 {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
                    <div class="hero-bg absolute inset-0">
                        <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="w-full h-full object-cover">
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/40 to-transparent"></div>

                    <div class="relative z-10 h-full flex flex-col justify-center px-8 md:px-16 max-w-xl">
                        <span class="hero-eyebrow inline-block text-primary-400 text-xs md:text-sm font-semibold tracking-widest uppercase mb-3">
                            {{ $slide['eyebrow'] }}
                        </span>
                        <h1 class="hero-title text-3xl md:text-5xl font-extrabold text-white leading-tight mb-3">
                            {{ $slide['title'] }}
                        </h1>
                        <p class="hero-subtitle text-gray-300 text-sm md:text-lg mb-6">
                            {{ $slide['subtitle'] }}
                        </p>
                        <a href="#products" class="hero-cta inline-flex items-center gap-2 w-fit bg-primary-500 hover:bg-primary-400 text-white font-semibold text-sm md:text-base px-6 py-3 rounded-full transition-all duration-300 hover:gap-3 hover:shadow-lg hover:shadow-primary-500/40">
                            Ver produtos
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" class="hero-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button" class="hero-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="hero-dots absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                @foreach ($heroSlides as $index => $slide)
                <button type="button" class="hero-dot h-1.5 rounded-full bg-white/30 transition-all duration-300 {{ $index === 0 ? 'is-active' : '' }}" data-goto="{{ $index }}"></button>
                @endforeach
            </div>
        </section>
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
                    @php
                    $inStock = productInStock($product);
                    @endphp

                    <a href="{{ route('product.page', $product) }}">
                        <div class="group bg-gray-800 rounded-xl p-4 flex flex-col transition-all duration-300
            {{ $inStock
                ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-primary-500/20 hover:bg-gray-700'
                : 'opacity-80 hover:bg-gray-750'
            }}">

                            {{-- Imagem --}}
                            <div class="relative block mb-3 overflow-hidden rounded-lg bg-gray-900">

                                <img
                                    src="{{ productPhotoUrl($product->photo) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-32 object-contain transition-all duration-300
                        {{ $inStock
                            ? 'group-hover:scale-110'
                            : 'grayscale opacity-50'
                        }}">

                                @unless($inStock)
                                {{-- Overlay fora de estoque --}}
                                <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                    <span class="px-3 py-1.5 rounded-full bg-gray-900/90 border border-red-400/30 text-red-300 text-xs font-semibold uppercase tracking-wide shadow-lg">
                                        Fora de estoque
                                    </span>
                                </div>
                                @endunless

                            </div>

                            {{-- Nome --}}
                            <h3 class="text-sm text-gray-300 line-clamp-2">
                                {{ $product->name }}
                            </h3>

                            {{-- Preço --}}
                            <p class="text-lg font-bold text-white mt-2">
                                {{ formatPrice($product->price) }}
                            </p>

                            {{-- Botão --}}
                            @if($inStock)
                            <span class="block w-full bg-primary-500 group-hover:bg-primary-400 text-white text-sm py-2 rounded-full transition-colors duration-300 mt-3 text-center">
                                Comprar
                            </span>
                            @else
                            <span class="flex items-center justify-center gap-2 w-full bg-gray-700 text-gray-400 text-sm py-2 rounded-full mt-3 cursor-not-allowed border border-gray-600/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                                Indisponível
                            </span>
                            @endif

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