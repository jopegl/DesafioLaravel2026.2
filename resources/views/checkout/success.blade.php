<x-app-layout>
    <div class="min-h-screen bg-neutral-900 text-white px-8 py-10 flex items-center justify-center">
        <div class="w-full max-w-xl">
            <h1 class="text-sm text-neutral-400 mb-6">Confirmação de compra</h1>

            <div class="bg-black rounded-2xl py-16 flex flex-col items-center justify-center text-center">
                <div class="w-24 h-24 rounded-full bg-green-500 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <p class="font-semibold text-lg mb-8">Compra efetuada com sucesso!</p>

                <a href="{{ route('home') }}"
                    class="bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 px-10 rounded-xl transition">
                    Continuar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>