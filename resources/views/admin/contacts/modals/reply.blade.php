    <x-modal-panel show="showReply">

        <template x-if="selected">

            <form
                method="POST"
                :action="`/admin/contacts/${selected.id}/reply`"
                class="p-6 space-y-4">

                @csrf

                <h3 class="text-lg font-medium text-gray-200">
                    Responder para
                    <span x-text="selected.name"></span>
                </h3>

                <textarea
                    name="reply"
                    rows="5"
                    class="w-full rounded-md bg-gray-900 border-gray-700 text-gray-200"
                    placeholder="Digite sua resposta..."></textarea>

                @error('reply')
                <p class="text-red-400 text-sm">
                    {{ $message }}
                </p>
                @enderror

                <div class="flex justify-end gap-3">

                    <button
                        type="button"
                        @click="showReply = false"
                        class="px-4 py-2 text-gray-400 hover:text-gray-200">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-md">
                        Enviar resposta
                    </button>

                </div>

            </form>

        </template>

    </x-modal-panel>