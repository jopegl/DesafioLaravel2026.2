<x-modal-panel show="showView" :require-selected="true">

    <h3 class="text-white text-lg font-semibold text-center mb-5">
        Detalhes do produto
    </h3>

    <template x-if="selected">
        <div class="space-y-4">

            <img :src="selected.photo_url" x-show="selected.photo_url" :alt="selected.name"
                class="w-full h-40 object-cover rounded-lg border border-gray-700">

            <div>
                <p class="text-gray-400 text-xs mb-1">Nome</p>
                <p class="text-white text-sm" x-text="selected.name"></p>
            </div>

            <div>
                <p class="text-gray-400 text-xs mb-1">Categoria</p>
                <p class="text-white text-sm" x-text="selected.category?.name ?? selected.category_id"></p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-400 text-xs mb-1">Preço</p>
                    <p class="text-white text-sm" x-text="'R$' + Number(selected.price).toFixed(2).replace('.', ',')"></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs mb-1">Quantidade</p>
                    <p class="text-white text-sm" x-text="selected.quantity"></p>
                </div>
            </div>

            <div>
                <p class="text-gray-400 text-xs mb-1">Descrição</p>
                <p class="text-white text-sm" x-text="selected.description"></p>
            </div>

            <button type="button" @click="showView = false"
                class="w-full border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition mt-2">
                Fechar
            </button>

        </div>
    </template>

</x-modal-panel>
