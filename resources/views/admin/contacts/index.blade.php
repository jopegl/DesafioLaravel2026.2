<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Mensagens de Contato
        </h2>
    </x-slot>

    <div class="py-8" x-data="contactModals">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
            <div class="bg-green-900/50 border border-green-700 text-green-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-gray-800 shadow-sm rounded-lg divide-y divide-gray-700">
                @forelse ($msgs as $msg)
                <div class="p-6 flex flex-col gap-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-200 font-medium">{{ $msg->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $msg->email }}</p>
                        </div>

                        @if ($msg->replied_at)
                        <span class="text-xs bg-green-900/50 text-green-300 px-2 py-1 rounded-full">
                            Respondida em {{ $msg->replied_at->format('d/m/Y H:i') }}
                        </span>
                        @else
                        <span class="text-xs bg-yellow-900/50 text-yellow-300 px-2 py-1 rounded-full">
                            Pendente
                        </span>
                        @endif
                    </div>

                    <p class="text-gray-300 text-sm whitespace-pre-line">{{ $msg->message }}</p>

                    @if ($msg->reply)
                    <div class="mt-2 pl-4 border-l-2 border-gray-600">
                        <p class="text-xs text-gray-500 mb-1">
                            Resposta de {{ $msg->repliedBy?->name ?? 'Admin' }}:
                        </p>
                        <p class="text-gray-300 text-sm whitespace-pre-line">{{ $msg->reply }}</p>
                    </div>
                    @else
                    <button
                        @click='openReply(@json($msg->only(["id", "name", "email"])))'
                        class="self-start text-sm text-indigo-400 hover:text-indigo-300">
                        Responder
                    </button>
                    @endif
                </div>
                @empty
                <p class="p-6 text-gray-400 text-center">Nenhuma mensagem recebida ainda.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $msgs->links() }}
            </div>
        </div>

        <x-modal-panel show="showReply">
            <template x-if="selected">
                <form method="POST" :action="`/admin/contacts/${selected.id}/reply`" class="p-6 space-y-4">
                    @csrf
                    <h3 class="text-lg font-medium text-gray-200">
                        Responder para <span x-text="selected.name"></span>
                    </h3>

                    <textarea
                        name="reply"
                        rows="5"
                        class="w-full rounded-md bg-gray-900 border-gray-700 text-gray-200"
                        placeholder="Digite sua resposta..."></textarea>
                    @error('reply')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
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
    </div>
</x-app-layout>