<x-modal-panel show="showView" :require-selected="true">

    <h3 class="text-white text-lg font-semibold text-center mb-5">
        Detalhes do usuário
    </h3>

    <template x-if="selected">
        <div class="space-y-4">

            <img
                :src="selected.photo_url"
                x-show="selected.photo_url"
                :alt="selected.name"
                class="w-32 h-32 mx-auto object-cover rounded-full border-2 border-gray-700">

            <div>
                <p class="text-gray-400 text-xs mb-1">Nome</p>
                <p class="text-white text-sm break-words" x-text="selected.name"></p>
            </div>

            <div>
                <p class="text-gray-400 text-xs mb-1">CPF</p>
                <p class="text-white text-sm" x-text="selected.cpf || '—'"></p>
            </div>

            <div>
                <p class="text-gray-400 text-xs mb-1">E-mail</p>
                <p class="text-white text-sm break-all" x-text="selected.email"></p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-400 text-xs mb-1">Telefone</p>
                    <p class="text-white text-sm" x-text="selected.formatted_phone || '—'"></p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Nascimento</p>
                    <p class="text-white text-sm" x-text="selected.birth_date"></p>
                </div>
            </div>

            <div>
                <p class="text-gray-400 text-xs mb-1">Endereço padrão</p>
                <template x-if="selected.default_address">
                    <p class="text-white text-sm break-words"
                        x-text="`${selected.default_address.street}, ${selected.default_address.number} - ${selected.default_address.neighborhood}, ${selected.default_address.city}/${selected.default_address.state}`">
                    </p>
                </template>
                <template x-if="!selected.default_address">
                    <p class="text-gray-500 text-sm">Nenhum endereço cadastrado.</p>
                </template>
            </div>

            <button type="button" @click="showView = false"
                class="w-full border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition mt-2">
                Fechar
            </button>

        </div>
    </template>

</x-modal-panel>