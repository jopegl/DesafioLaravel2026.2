<x-app-layout>
    <div class="min-h-screen bg-neutral-900 text-white px-8 py-10 flex items-center justify-center">
        <div class="w-full max-w-xl">
            <h1 class="text-sm text-neutral-400 mb-6">Confirmação de compra</h1>

            <div class="bg-black rounded-2xl py-16 flex flex-col items-center justify-center text-center">
                <div class="w-24 h-24 rounded-full bg-yellow-500 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <p class="font-semibold text-lg mb-2">Pagamento pendente</p>
                <p class="text-sm text-neutral-400 mb-8 max-w-sm">
                    Estamos aguardando a confirmação do pagamento. Assim que for aprovado, seu pedido será processado.
                </p>

                <a href="{{ route('home') }}"
                    class="bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 px-10 rounded-xl transition">
                    Continuar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>