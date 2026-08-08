<x-app-layout>

    <div class="flex min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col"
            x-data="{
                showCreate: false,
                showView: false,
                showEdit: false,
                showDelete: false,
                selected: null,
                openView(p)   { this.selected = p; this.showView = true; },
                openEdit(p)   { this.selected = p; this.showEdit = true; },
                openDelete(p) { this.selected = p; this.showDelete = true; },
             }">


            <header class="flex items-center justify-end gap-4 px-8 py-5 border-b border-gray-800/60">
                <form method="GET" action="{{ route('products.index') }}" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search..."
                        class="w-64 bg-[#1c1f2a] border border-gray-700 text-sm text-white rounded-lg pl-4 pr-9 py-2
                                  focus:outline-none focus:ring-1 focus:ring-cyan-400 placeholder-gray-500">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </button>
                </form>
            </header>

            <main class="flex-1 px-8 py-8">

                @if (session('success'))
                <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/40 text-emerald-300 text-sm px-4 py-3">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-300 text-sm px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white">Vendas realizadas</h2>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('sales.pdf', request()->query()) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg shadow border border-red-500/50 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exportar PDF
                        </a>
                        @can('exportXlsx', App\Models\Sale::class)
                        <a href="{{ route('sales.xlsx', request()->query()) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-lg shadow border border-emerald-500/50 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exportar Excel
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="bg-[#1c1f2a] rounded-xl overflow-hidden border border-gray-800/60">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-800/60">
                                <th class="px-5 py-4 font-medium w-20"></th>
                                <th class="px-5 py-4 font-medium">Nome</th>
                                <th class="px-5 py-4 font-medium">Vendedor</th>
                                <th class="px-5 py-4 font-medium">Comprador</th>
                                <th class="px-5 py-4 font-medium">Preço</th>
                                <th class="px-5 py-4 font-medium">Data de venda</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-200">
                            @forelse ($sales as $sale)
                            <tr class="border-b border-gray-800/40 last:border-0 hover:bg-white/[0.02]">
                                <td class="px-5 py-4">
                                    <img src="{{ urlFotoProduto($sale->foto) }}"
                                        alt="{{ $sale->nome }}"
                                        class="w-10 h-10 rounded object-cover bg-gray-700">
                                </td>
                                <td class="px-5 py-4">{{ $sale->product->nome }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $sale->user->name ?? 'nome' }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $sale->buyer->name ?? '—' }}</td>
                                <td class="px-5 py-4">{{ formatarPreco($sale->preco) }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $sale->sold_at?->format('d-M-Y') ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                    Nenhum produto cadastrado até o momento.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $sales->links() }}
                </div>
            </main>

        </div>
    </div>
</x-app-layout>