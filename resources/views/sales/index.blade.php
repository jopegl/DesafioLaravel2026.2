<x-app-layout>

    <div class="flex flex-col lg:flex-row min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">


            <header class="flex flex-col gap-4 px-4 sm:px-8 py-5 border-b border-gray-800/60">
                <form method="GET" action="{{ route('sales.index') }}"
                    class="flex flex-col sm:flex-row sm:flex-wrap sm:items-end sm:justify-end gap-3">

                    <div class="flex flex-col gap-1">
                        <label for="start" class="text-xs text-gray-400">De</label>
                        <input type="date" id="start" name="start" value="{{ request('start') }}"
                            class="w-full sm:w-auto bg-[#1c1f2a] border border-gray-700 text-sm text-white rounded-lg px-3 py-2
                       focus:outline-none focus:ring-1 focus:ring-cyan-400">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="end" class="text-xs text-gray-400">Até</label>
                        <input type="date" id="end" name="end" value="{{ request('end') }}"
                            class="w-full sm:w-auto bg-[#1c1f2a] border border-gray-700 text-sm text-white rounded-lg px-3 py-2
                       focus:outline-none focus:ring-1 focus:ring-cyan-400">
                    </div>

                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white
                   bg-cyan-600 hover:bg-cyan-700 active:bg-cyan-800 rounded-lg shadow
                   border border-cyan-500/50 transition-all duration-200">
                        Filtrar
                    </button>

                    @if (request('start') || request('end'))
                    <a href="{{ route('sales.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 text-sm text-gray-400 hover:text-white
                   border border-gray-700 rounded-lg transition-all duration-200">
                        Limpar
                    </a>
                    @endif
                </form>
            </header>

            <main class="flex-1 px-4 sm:px-8 py-8">

                <x-alerts />

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white">Vendas realizadas</h2>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <a href="{{ route('sales.pdf', request()->query()) }}" target="_blank"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg shadow border border-red-500/50 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exportar PDF
                        </a>
                        @can('exportXlsx', App\Models\Sale::class)
                        <a href="{{ route('sales.xlsx', request()->query()) }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-lg shadow border border-emerald-500/50 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exportar Excel
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 overflow-x-auto">
                    <table class="w-full min-w-[640px] text-sm text-left">
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
                                    <img src="{{ productPhotoUrl($sale->product->photo) }}"
                                        alt="{{ $sale->product->name }}"
                                        class="w-10 h-10 rounded object-cover bg-gray-700">
                                </td>
                                <td class="px-5 py-4">{{ $sale->product->name }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $sale->seller->name ?? '—' }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $sale->buyer->name ?? '—' }}</td>
                                <td class="px-5 py-4">{{ formatPrice($sale->total_price) }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $sale->purchase_date?->format('d-M-Y') ?? '—' }}</td>
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
                    {{ $sales->appends(request()->query())->links() }}
                </div>
            </main>

        </div>
    </div>
</x-app-layout>