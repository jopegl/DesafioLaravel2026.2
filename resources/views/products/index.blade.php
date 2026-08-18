<x-app-layout>

    <div class="flex flex-col lg:flex-row min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col" x-data="crudModals">

            <main class="flex-1 px-4 sm:px-8 py-8">

                <x-alerts />

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

                    <h2 class="text-xl font-semibold text-white">
                        Produtos cadastrados
                    </h2>

                    {{-- Filtros --}}
                    <div class="relative">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <x-product-filter :action="route('products.index')" :categories="$categories" />

                            <div class="relative flex-1 sm:max-w-xs">
                                <form method="GET" action="{{ route('products.index') }}" class="w-full">
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Buscar produtos..."
                                        class="w-full bg-gray-800 border border-gray-700 rounded-full px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-primary-500">

                                    <button type="submit"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if(!auth()->user()->is_admin)
                    <button @click="showCreate = true"
                        class="w-full sm:w-auto bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                        Cadastrar produto
                    </button>
                    @endif

                </div>

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 overflow-x-auto">

                    <table class="w-full min-w-[760px] text-sm text-left">

                        <thead>
                            <tr class="text-gray-400 border-b border-gray-800/60">
                                <th class="px-5 py-4 font-medium w-20"></th>
                                <th class="px-5 py-4 font-medium">Nome</th>
                                <th class="px-5 py-4 font-medium">Descrição</th>
                                <th class="px-5 py-4 font-medium">Preço</th>
                                <th class="px-5 py-4 font-medium">Usuário</th>
                                <th class="px-5 py-4 font-medium">Data de criação</th>
                                <th class="px-5 py-4 font-medium text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-200">

                            @forelse ($products as $product)
                            <tr class="border-b border-gray-800/40 last:border-0 hover:bg-white/[0.02]">

                                <td class="px-5 py-4 w-20">
                                    <img src="{{ productPhotoUrl($product->photo) }}" alt="{{ $product->name }}"
                                        class="w-10 h-10 shrink-0 min-w-[2.5rem] min-h-[2.5rem] rounded object-cover bg-gray-700 block">
                                </td>

                                <td class="px-5 py-4">{{ $product->name }}</td>

                                <td class="px-5 py-4 text-gray-400 max-w-[160px] truncate">
                                    {{ $product->description }}
                                </td>

                                <td class="px-5 py-4">{{ formatPrice($product->price) }}</td>

                                <td class="px-5 py-4 text-gray-400">{{ $product->user->name ?? 'nome' }}</td>

                                <td class="px-5 py-4 text-gray-400">{{ $product->created_at->format('d-M-Y') }}</td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-3 text-cyan-400">

                                        <button
                                            @click='openView(@json(array_merge($product->toArray(), ["photo_url" => productPhotoUrl($product->photo)])))'
                                            title="Visualizar" class="hover:text-cyan-300">
                                            <x-icons.eye />
                                        </button>

                                        <button
                                            @click='openEdit(@json(array_merge($product->toArray(), ["photo_url" => productPhotoUrl($product->photo)])))'
                                            title="Editar" class="hover:text-cyan-300">
                                            <x-icons.pencil />
                                        </button>

                                        <button @click='openDelete(@json($product))' title="Excluir" class="hover:text-red-400">
                                            <x-icons.trash />
                                        </button>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                    Nenhum produto cadastrado até o momento.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>

                @if(auth()->user()->is_admin)
                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 p-6 mb-6">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-white">
                                Produtos cadastrados
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Quantidade de produtos cadastrados por mês
                            </p>
                        </div>
                    </div>

                    <div class="w-full">
                        {!! $graphic->renderHtml() !!}
                        {!! $graphic->renderChartJsLibrary() !!}
                        {!! $graphic->renderJs() !!}
                    </div>

                </div>
                @endif


            </main>

            @include('products.modals.create')
            @include('products.modals.view')
            @include('products.modals.edit')
            @include('products.modals.delete')

        </div>

    </div>

</x-app-layout>