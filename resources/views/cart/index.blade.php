<x-app-layout>
    <div class="min-h-screen bg-neutral-900 text-white px-8 py-10">
        <h1 class="text-sm text-neutral-400 mb-6">Carrinho</h1>

        @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-600/20 text-green-400 px-4 py-2 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-600/20 text-red-400 px-4 py-2 text-sm">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Lista de itens --}}
            <div class="lg:col-span-2 bg-neutral-900">
                <h2 class="text-2xl font-bold mb-6">Carrinho</h2>

                @forelse ($cartItems as $item)
                <div class="flex items-center justify-between border-b border-neutral-800 py-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ productPhotoUrl($item->product->photo) }}"
                            alt="{{ $item->product->name }}"
                            class="w-14 h-14 object-cover rounded-lg bg-neutral-800">

                        <div>
                            <p class="font-medium">{{ $item->product->name }}</p>
                            <p class="text-xs text-neutral-500">#{{ $item->product->id }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <form action="{{ route('cart-items.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                name="quantity"
                                value="{{ max(1, $item->quantity - 1) }}"
                                class="w-6 h-6 flex items-center justify-center rounded bg-neutral-800 hover:bg-neutral-700">
                                −
                            </button>

                            <span class="w-8 text-center border border-neutral-700 rounded py-1 text-sm">
                                {{ $item->quantity }}
                            </span>

                            <button type="submit"
                                name="quantity"
                                value="{{ $item->quantity + 1 }}"
                                class="w-6 h-6 flex items-center justify-center rounded bg-neutral-800 hover:bg-neutral-700">
                                +
                            </button>
                        </form>

                        <p class="w-16 text-right font-medium">R$ {{ number_format($item->product->price, 2, ',', '.') }}</p>

                        <form action="{{ route('cart-items.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-neutral-500 hover:text-red-500">
                                ✕
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 py-8">Seu carrinho está vazio.</p>
                @endforelse
            </div>

            <div class="bg-neutral-800/50 rounded-2xl p-6 h-fit">
                <h3 class="text-blue-400 font-semibold mb-6">Sumário</h3>

                <div class="flex justify-between text-sm text-neutral-400 mb-2">
                    <span>Itens no carrinho</span>
                    <span>{{ $nProducts }}</span>
                </div>

                <div class="flex justify-between font-semibold text-lg border-t border-neutral-700 mt-4 pt-4">
                    <span>Total</span>
                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>

                <div class="space-y-3 mt-6">

                    <form action="{{ route('mercadopago.process') }}" method="POST"
                        x-data="{ loading: false }"
                        @submit="loading = true">
                        @csrf
                        <button type="submit"
                            :disabled="loading || {{ $cartItems->isEmpty() ? 'true' : 'false' }}"
                            class="w-full bg-blue-500 hover:bg-blue-600 disabled:bg-neutral-700 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl transition inline-flex items-center justify-center gap-2">
                            <svg x-show="loading" x-cloak class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span x-text="loading ? 'Redirecionando...' : 'Pagar com Mercado Pago'"></span>
                        </button>
                    </form>

                    <form action="{{ route('pagbank.process') }}" method="POST"
                        x-data="{ loading: false }"
                        @submit="loading = true">
                        @csrf
                        <button type="submit"
                            :disabled="loading || {{ $cartItems->isEmpty() ? 'true' : 'false' }}"
                            class="w-full bg-green-500 hover:bg-green-600 disabled:bg-neutral-700 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl transition inline-flex items-center justify-center gap-2">
                            <svg x-show="loading" x-cloak class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span x-text="loading ? 'Redirecionando...' : 'Pagar com PagBank'"></span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>