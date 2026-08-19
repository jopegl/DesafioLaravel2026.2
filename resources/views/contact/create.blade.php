<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Fale Conosco
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-sm rounded-lg p-6">

                @if (session('success'))
                <div class="mb-4 bg-green-900/50 border border-green-700 text-green-300 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm text-gray-400 mb-1">Nome</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', auth()->user()->name ?? '') }}"
                            class="w-full rounded-md bg-gray-900 border-gray-700 text-gray-200">
                        @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm text-gray-400 mb-1">E-mail</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', auth()->user()->email ?? '') }}"
                            class="w-full rounded-md bg-gray-900 border-gray-700 text-gray-200">
                        @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm text-gray-400 mb-1">Mensagem</label>
                        <textarea
                            name="message"
                            id="message"
                            rows="6"
                            class="w-full rounded-md bg-gray-900 border-gray-700 text-gray-200"
                            placeholder="Escreva sua mensagem...">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-md">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>