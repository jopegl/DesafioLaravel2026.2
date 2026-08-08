<x-app-layout>
    <div class="min-h-screen bg-zinc-950">
        <div class="max-w-3xl mx-auto pt-10 px-4" x-data="emailForm()">

            <div class="bg-zinc-900 rounded-xl p-8 text-white">

                <h1 class="text-2xl font-semibold text-center mb-8">Enviar email para usuário</h1>

                @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-600/20 border border-green-600 text-green-400 px-4 py-2 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('admin.email.send') }}">
                    @csrf

                    <input type="hidden" name="user_id" x-model="selectedUser.id">

                    <div class="mb-6 relative">
                        <label class="block mb-2 text-sm">Buscar usuário por email:</label>

                        <div class="relative">
                            <input
                                type="text"
                                x-model="query"
                                @input.debounce.400ms="search()"
                                @focus="showResults = true"
                                placeholder="Digite o email do usuário..."
                                autocomplete="off"
                                class="w-full bg-zinc-800 border border-zinc-700 rounded-lg px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-zinc-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <div x-show="showResults && results.length > 0"
                            @click.outside="showResults = false"
                            x-cloak
                            class="absolute z-10 mt-1 w-full bg-zinc-800 border border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <template x-for="user in results" :key="user.id">
                                <button
                                    type="button"
                                    @click="selectUser(user)"
                                    class="w-full text-left px-4 py-2 hover:bg-zinc-700 text-sm flex flex-col">
                                    <span x-text="user.name" class="font-medium"></span>
                                    <span x-text="user.email" class="text-zinc-400 text-xs"></span>
                                </button>
                            </template>
                        </div>

                        <div x-show="selectedUser.id" x-cloak class="mt-2 text-sm text-sky-400">
                            Selecionado: <span x-text="selectedUser.name"></span> (<span x-text="selectedUser.email"></span>)
                        </div>

                        @error('user_id')
                        <p class="text-red-400 text-xs mt-1">Selecione um usuário válido.</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm">Assunto:</label>
                        <input
                            type="text"
                            name="subject"
                            value="{{ old('subject') }}"
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        @error('subject')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block mb-2 text-sm">Texto</label>
                        <textarea
                            name="message"
                            rows="6"
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-sky-500 hover:bg-sky-600 transition rounded-lg py-3 font-medium">
                            Enviar
                        </button>
                        <a href="{{ url()->previous() }}"
                            class="flex-1 border border-zinc-600 hover:bg-zinc-800 transition rounded-lg py-3 font-medium text-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function emailForm() {
            return {
                query: '',
                results: [],
                showResults: false,
                selectedUser: {
                    id: null,
                    name: '',
                    email: ''
                },

                async search() {
                    if (this.query.length < 2) {
                        this.results = [];
                        return;
                    }

                    const response = await fetch(`{{ route('admin.email.search') }}?q=${encodeURIComponent(this.query)}`);
                    this.results = await response.json();
                    this.showResults = true;
                },

                selectUser(user) {
                    this.selectedUser = user;
                    this.query = user.email;
                    this.showResults = false;
                }
            }
        }
    </script>
</x-app-layout>