<x-modal-panel show="showDelete" max-width="max-w-sm" :require-selected="true">

    <template x-if="selected">
        <div class="text-center space-y-5">

            <x-icons.warning />

            <p class="text-white text-sm">
                Tem certeza que deseja excluir
                <span class="font-semibold" x-text="selected.name"></span>?
                Essa ação não pode ser desfeita.
            </p>

            <form method="POST" :action="`{{ url('/dashboard/products') }}/${selected.id}`" class="flex gap-3">

                @csrf
                @method('DELETE')

                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Excluir
                </button>

                <button type="button" @click="showDelete = false"
                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                    Cancelar
                </button>

            </form>

        </div>
    </template>

</x-modal-panel>
