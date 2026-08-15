<x-app-layout>
    <div class="min-h-screen bg-black text-white">

        @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-6 right-6 z-50 bg-green-600/90 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-6 right-6 z-50 bg-red-600/90 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('error') }}
        </div>
        @endif

        <div class="max-w-6xl mx-auto px-6 pt-12 grid grid-cols-1 md:grid-cols-2 gap-12">

            <div class="flex items-center justify-center">
                <img
                    src="{{ productPhotoUrl($product->photo) }}"
                    alt="{{ $product->name }}"
                    class="max-h-[480px] w-auto object-contain rounded-xl">
            </div>

            <div class="flex flex-col justify-center">
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

                <div class="flex items-center gap-3 mb-2">
                    <span class="text-2xl font-bold text-cyan-400">
                        {{ formatPrice($product->price) }}
                    </span>
                </div>

                <p class="text-sm mb-6 {{ $product->quantity > 0 ? 'text-gray-400' : 'text-red-400' }}">
                    @if($product->quantity > 0)
                    {{ $product->quantity }} em estoque
                    @else
                    Fora de estoque
                    @endif
                </p>

                @if($product->description)
                <p class="text-sm text-gray-400 leading-relaxed mb-6">
                    {{ \Illuminate\Support\Str::limit($product->description, 180) }}
                    @if(strlen($product->description) > 180)
                    <a href="#details" class="text-cyan-400 underline">mais</a>
                    @endif
                </p>
                @endif

                @auth
                <form action="{{ route('cart-items.store') }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div x-data="{ qty: 1 }" class="flex items-center gap-4 mb-6">
                        <div class="flex items-center border border-gray-700 rounded-lg overflow-hidden">
                            <button type="button" @click="qty = qty > 1 ? qty - 1 : 1"
                                class="px-4 py-2 text-lg hover:bg-gray-800">-</button>
                            <input type="number" name="quantity" x-model="qty" min="1"
                                max="{{ $product->quantity }}"
                                class="w-12 text-center bg-black border-x border-gray-700 py-2 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" @click="qty = qty < {{ $product->quantity }} ? qty + 1 : qty"
                                class="px-4 py-2 text-lg hover:bg-gray-800">+</button>
                        </div>
                    </div>

                    <button type="submit"
                        @disabled($product->quantity <= 0)
                            class="w-full md:w-auto px-10 py-3 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300 transition disabled:opacity-40 disabled:cursor-not-allowed">
                            Adicionar ao carrinho
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                    class="inline-block w-full md:w-auto text-center px-10 py-3 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300 transition">
                    Entrar para comprar
                </a>
                @endauth
            </div>
        </div>

        <div id="details" class="max-w-6xl mx-auto px-6 mt-20 pb-20">
            <h2 class="text-2xl font-bold mb-6">Detalhes</h2>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 md:p-8 space-y-6">

                {{-- Anunciante --}}
                <div class="flex items-center gap-4 pb-6 border-b border-gray-800">
                    <div class="w-12 h-12 rounded-full bg-cyan-400/10 border border-cyan-400/30 flex items-center justify-center text-cyan-400 font-semibold text-lg">
                        {{ strtoupper(substr($product->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">
                            {{ $product->user->name ?? 'Usuário' }}
                        </p>
                        <p class="text-xs text-gray-500">Anunciante</p>
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    @if($product->user->phone ?? false)
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $product->user->phone }}
                    </div>
                    @endif

                    @if($product->category->name ?? false)
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $product->category->name }}
                    </div>
                    @endif
                </div>

                @if($product->description)
                <div class="pt-2 border-t border-gray-800">
                    <h3 class="text-sm font-semibold text-white mb-3">Descrição</h3>
                    <p class="text-sm text-gray-400 leading-relaxed whitespace-pre-line">
                        {{ $product->description }}
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>