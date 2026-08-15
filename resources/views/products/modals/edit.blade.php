<x-modal-panel show="showEdit" :require-selected="true">

    <h3 class="text-white text-lg font-semibold text-center mb-5">
        Editar produto
    </h3>

    <template x-if="selected">
        <form method="POST" :action="`{{ url('/dashboard/products') }}/${selected.id}`" enctype="multipart/form-data" class="space-y-4">

            @csrf
            @method('PUT')

            <label class="block border-2 border-dashed border-gray-700 rounded-lg h-40 flex items-center justify-center text-gray-500 text-sm cursor-pointer hover:border-cyan-400 relative overflow-hidden">
                <img :src="selected.photo_url" x-show="selected.photo_url" :alt="selected.name" class="absolute inset-0 w-full h-full object-cover">
                <input type="file" name="photo" accept="image/*" class="hidden">
            </label>

            <div>
                <label class="block text-gray-400 text-xs mb-1">Nome</label>
                <input type="text" name="name" required :value="selected.name"
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>

            <div>
                <label class="block text-gray-400 text-xs mb-1">Categoria</label>
                <select name="category_id" required
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400"
                    x-init="$el.value = selected.category_id">
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-gray-400 text-xs mb-1">Preço</label>
                    <div class="flex items-center bg-[#15171e] border border-gray-700 rounded-lg px-3">
                        <span class="text-gray-400 text-sm mr-1">R$</span>
                        <input type="number" step="0.01" min="0" name="price" required :value="selected.price"
                            class="w-full bg-transparent py-2 text-white text-sm focus:outline-none">
                    </div>
                </div>

                <div class="flex-1">
                    <label class="block text-gray-400 text-xs mb-1">Quantidade</label>
                    <input type="number" min="0" step="1" name="quantity" required :value="selected.quantity"
                        class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
                </div>
            </div>

            <div>
                <label class="block text-gray-400 text-xs mb-1">Descrição</label>
                <textarea name="description" rows="3" required x-text="selected.description"
                    class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Salvar
                </button>
                <button type="button" @click="showEdit = false"
                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                    Cancelar
                </button>
            </div>

        </form>
    </template>

</x-modal-panel>
