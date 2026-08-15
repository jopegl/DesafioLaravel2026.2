@props(['action', 'categories'])

<div class="relative" x-data="{ open: false }">
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

    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute z-20 mt-2 w-80 bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-5"
        style="display: none;">

        <form method="GET" action="{{ $action }}" class="space-y-4">

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
                <a href="{{ $action }}{{ request('search') ? '?search=' . urlencode(request('search')) : '' }}"
                    class="text-xs text-gray-400 hover:text-white transition px-2">
                    Limpar
                </a>
                @endif
            </div>
        </form>
    </div>
</div>