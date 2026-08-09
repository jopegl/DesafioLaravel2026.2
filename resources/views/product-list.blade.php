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

            openView(p) {
                this.selected = p;
                this.showView = true;
            },

            openEdit(p) {
                this.selected = p;
                this.showEdit = true;
            },

            openDelete(p) {
                this.selected = p;
                this.showDelete = true;
            },
        }">

            <header class="flex items-center justify-end gap-4 px-8 py-5 border-b border-gray-800/60">
                <form method="GET" action="{{ route('products.index') }}" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search..."
                        class="w-64 bg-[#1c1f2a] border border-gray-700 text-sm text-white rounded-lg pl-4 pr-9 py-2
                              focus:outline-none focus:ring-1 focus:ring-cyan-400 placeholder-gray-500">

                    <button type="submit"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />

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

                    <h2 class="text-xl font-semibold text-white">
                        Produtos cadastrados
                    </h2>

                    @if(!auth()->user()->is_admin)
                    <button @click="showCreate = true"
                        class="bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                        Cadastrar produto
                    </button>
                    @endif

                </div>


                <div class="bg-[#1c1f2a] rounded-xl overflow-hidden border border-gray-800/60">

                    <table class="w-full text-sm text-left">

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

                                <td class="px-5 py-4">

                                    <img src="{{ productPhotoUrl($product->photo) }}"
                                        alt="{{ $product->name }}"
                                        class="w-10 h-10 rounded object-cover bg-gray-700">

                                </td>


                                <td class="px-5 py-4">
                                    {{ $product->name }}
                                </td>


                                <td class="px-5 py-4 text-gray-400 max-w-[160px] truncate">
                                    {{ $product->description }}
                                </td>


                                <td class="px-5 py-4">
                                    {{ formatPrice($product->price) }}
                                </td>


                                <td class="px-5 py-4 text-gray-400">
                                    {{ $product->user->name ?? 'nome' }}
                                </td>


                                <td class="px-5 py-4 text-gray-400">
                                    {{ $product->created_at->format('d-M-Y') }}
                                </td>


                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-3 text-cyan-400">

                                        {{-- VISUALIZAR --}}
                                        <button
                                            @click='openView(@json(array_merge($product->toArray(), ["photo_url" => productPhotoUrl($product->photo)])))'
                                            title="Visualizar"
                                            class="hover:text-cyan-300">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                            </svg>

                                        </button>


                                        {{-- EDITAR --}}
                                        <button
                                            @click='openEdit(@json(array_merge($product->toArray(), ["photo_url" => productPhotoUrl($product->photo)])))'
                                            title="Editar"
                                            class="hover:text-cyan-300">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />

                                            </svg>

                                        </button>


                                        {{-- EXCLUIR --}}
                                        <button
                                            @click='openDelete(@json($product))'
                                            title="Excluir"
                                            class="hover:text-red-400">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />

                                            </svg>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="7"
                                    class="px-5 py-10 text-center text-gray-500">

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

            </main>


            {{-- ==================== CRIAR ==================== --}}

            <div x-show="showCreate"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
                x-transition.opacity>

                <div @click.outside="showCreate = false"
                    class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Criar produto
                    </h3>


                    <form method="POST"
                        action="{{ route('products.store') }}"
                        enctype="multipart/form-data"
                        class="space-y-4">

                        @csrf


                        <label
                            class="block border-2 border-dashed border-gray-700 rounded-lg h-40 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden"
                            x-data="{ preview: null }">

                            <template x-if="!preview">
                                <span>Clique para adicionar uma foto</span>
                            </template>

                            <img :src="preview"
                                x-show="preview"
                                class="absolute inset-0 w-full h-full object-cover">

                            <input type="file"
                                name="photo"
                                accept="image/*"
                                class="hidden"
                                @change="preview = URL.createObjectURL($event.target.files[0])">

                        </label>


                        <div>

                            <label class="block text-gray-400 text-xs mb-1">
                                Nome
                            </label>

                            <input type="text"
                                name="name"
                                required
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">

                        </div>


                        <div>

                            <label class="block text-gray-400 text-xs mb-1">
                                Categoria
                            </label>

                            <select name="category_id"
                                required
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">

                                <option value="">
                                    Selecione uma categoria
                                </option>

                                @foreach($categories as $category)

                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="flex gap-4">

                            <div class="flex-1">

                                <label class="block text-gray-400 text-xs mb-1">
                                    Preço
                                </label>

                                <div class="flex items-center bg-[#15171e] border border-gray-700 rounded-lg px-3">

                                    <span class="text-gray-400 text-sm mr-1">
                                        R$
                                    </span>

                                    <input type="number"
                                        step="0.01"
                                        min="0"
                                        name="price"
                                        required
                                        class="w-full bg-transparent py-2 text-white text-sm focus:outline-none">

                                </div>

                            </div>


                            <div class="flex-1">

                                <label class="block text-gray-400 text-xs mb-1">
                                    Quantidade
                                </label>

                                <input type="number"
                                    min="0"
                                    step="1"
                                    name="quantity"
                                    required
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">

                            </div>

                        </div>


                        <div>

                            <label class="block text-gray-400 text-xs mb-1">
                                Descrição
                            </label>

                            <textarea name="description"
                                rows="3"
                                required
                                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400"></textarea>

                        </div>


                        <div class="flex gap-3 pt-2">

                            <button type="submit"
                                class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                                Salvar
                            </button>

                            <button type="button"
                                @click="showCreate = false"
                                class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                                Cancelar
                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ==================== VISUALIZAR ==================== --}}

            <div x-show="showView"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
                x-transition.opacity>

                <div @click.outside="showView = false"
                    class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto"
                    x-show="selected">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Detalhes do produto
                    </h3>


                    <template x-if="selected">

                        <div class="space-y-4">

                            {{-- FOTO DO PRODUTO --}}
                            <img :src="selected.photo_url"
                                x-show="selected.photo_url"
                                :alt="selected.name"
                                class="w-full h-40 object-cover rounded-lg border border-gray-700">


                            <div>

                                <p class="text-gray-400 text-xs mb-1">
                                    Nome
                                </p>

                                <p class="text-white text-sm"
                                    x-text="selected.name">
                                </p>

                            </div>


                            <div>

                                <p class="text-gray-400 text-xs mb-1">
                                    Categoria
                                </p>

                                <p class="text-white text-sm"
                                    x-text="selected.category?.name ?? selected.category_id">
                                </p>

                            </div>


                            <div class="grid grid-cols-2 gap-4">

                                <div>

                                    <p class="text-gray-400 text-xs mb-1">
                                        Preço
                                    </p>

                                    <p class="text-white text-sm"
                                        x-text="'R$' + Number(selected.price).toFixed(2).replace('.', ',')">
                                    </p>

                                </div>


                                <div>

                                    <p class="text-gray-400 text-xs mb-1">
                                        Quantidade
                                    </p>

                                    <p class="text-white text-sm"
                                        x-text="selected.quantity">
                                    </p>

                                </div>

                            </div>


                            <div>

                                <p class="text-gray-400 text-xs mb-1">
                                    Descrição
                                </p>

                                <p class="text-white text-sm"
                                    x-text="selected.description">
                                </p>

                            </div>


                            <button type="button"
                                @click="showView = false"
                                class="w-full border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition mt-2">

                                Fechar

                            </button>

                        </div>

                    </template>

                </div>

            </div>


            {{-- ==================== EDITAR ==================== --}}

            <div x-show="showEdit"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
                x-transition.opacity>

                <div @click.outside="showEdit = false"
                    class="bg-[#1c1f2a] w-full max-w-md rounded-xl border border-gray-800 p-6 max-h-[90vh] overflow-y-auto"
                    x-show="selected">

                    <h3 class="text-white text-lg font-semibold text-center mb-5">
                        Editar produto
                    </h3>


                    <template x-if="selected">

                        <form method="POST"
                            :action="`{{ url('/dashboard/products') }}/${selected.id}`"
                            enctype="multipart/form-data"
                            class="space-y-4">

                            @csrf
                            @method('PUT')


                            {{-- FOTO ATUAL --}}
                            <label
                                class="block border-2 border-dashed border-gray-700 rounded-lg h-40 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden">

                                <img :src="selected.photo_url"
                                    x-show="selected.photo_url"
                                    :alt="selected.name"
                                    class="absolute inset-0 w-full h-full object-cover">

                                <input type="file"
                                    name="photo"
                                    accept="image/*"
                                    class="hidden">

                            </label>


                            <div>

                                <label class="block text-gray-400 text-xs mb-1">
                                    Nome
                                </label>

                                <input type="text"
                                    name="name"
                                    required
                                    :value="selected.name"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">

                            </div>


                            <div>

                                <label class="block text-gray-400 text-xs mb-1">
                                    Categoria
                                </label>

                                <select name="category_id"
                                    required
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400"
                                    x-init="$el.value = selected.category_id">

                                    <option value="">
                                        Selecione uma categoria
                                    </option>

                                    @foreach($categories as $category)

                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="flex gap-4">

                                <div class="flex-1">

                                    <label class="block text-gray-400 text-xs mb-1">
                                        Preço
                                    </label>

                                    <div class="flex items-center bg-[#15171e] border border-gray-700 rounded-lg px-3">

                                        <span class="text-gray-400 text-sm mr-1">
                                            R$
                                        </span>

                                        <input type="number"
                                            step="0.01"
                                            min="0"
                                            name="price"
                                            required
                                            :value="selected.price"
                                            class="w-full bg-transparent py-2 text-white text-sm focus:outline-none">

                                    </div>

                                </div>


                                <div class="flex-1">

                                    <label class="block text-gray-400 text-xs mb-1">
                                        Quantidade
                                    </label>

                                    <input type="number"
                                        min="0"
                                        step="1"
                                        name="quantity"
                                        required
                                        :value="selected.quantity"
                                        class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">

                                </div>

                            </div>


                            <div>

                                <label class="block text-gray-400 text-xs mb-1">
                                    Descrição
                                </label>

                                <textarea name="description"
                                    rows="3"
                                    required
                                    x-text="selected.description"
                                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400"></textarea>

                            </div>


                            <div class="flex gap-3 pt-2">

                                <button type="submit"
                                    class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                                    Salvar
                                </button>

                                <button type="button"
                                    @click="showEdit = false"
                                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                                    Cancelar
                                </button>

                            </div>

                        </form>

                    </template>

                </div>

            </div>


            {{-- ==================== EXCLUIR ==================== --}}

            <div x-show="showDelete"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
                x-transition.opacity>

                <div @click.outside="showDelete = false"
                    class="bg-[#1c1f2a] w-full max-w-sm rounded-xl border border-gray-800 p-6"
                    x-show="selected">

                    <template x-if="selected">

                        <div class="text-center space-y-5">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 mx-auto text-red-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />

                            </svg>


                            <p class="text-white text-sm">

                                Tem certeza que deseja excluir

                                <span class="font-semibold"
                                    x-text="selected.name">
                                </span>?

                                Essa ação não pode ser desfeita.

                            </p>


                            <form method="POST"
                                :action="`{{ url('/dashboard/products') }}/${selected.id}`"
                                class="flex gap-3">

                                @csrf
                                @method('DELETE')


                                <button type="submit"
                                    class="flex-1 bg-red-500 hover:bg-red-400 text-white text-sm font-medium py-2.5 rounded-lg transition">

                                    Excluir

                                </button>


                                <button type="button"
                                    @click="showDelete = false"
                                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">

                                    Cancelar

                                </button>

                            </form>

                        </div>

                    </template>

                </div>

            </div>

        </div>

    </div>


</x-app-layout>