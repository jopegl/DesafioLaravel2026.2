<x-app-layout>

    <div class="flex flex-col lg:flex-row min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col" x-data="contactModals">

            <main class="flex-1 px-4 sm:px-8 py-8">

                @if (session('success'))
                <div class="mb-6 bg-green-900/50 border border-green-700 text-green-300 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white">
                        Mensagens de Contato
                    </h2>
                </div>

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 overflow-hidden">

                    @forelse ($msgs as $msg)

                    <div class="p-6 flex flex-col gap-3 border-b border-gray-800/60 last:border-0">

                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                            <div>
                                <p class="text-gray-200 font-medium">
                                    {{ $msg->name }}
                                </p>

                                <p class="text-gray-400 text-sm">
                                    {{ $msg->email }}
                                </p>
                            </div>

                            @if ($msg->replied_at)

                            <span class="self-start text-xs bg-green-900/50 text-green-300 px-2 py-1 rounded-full">
                                Respondida em {{ $msg->replied_at->format('d/m/Y H:i') }}
                            </span>

                            @else

                            <span class="self-start text-xs bg-yellow-900/50 text-yellow-300 px-2 py-1 rounded-full">
                                Pendente
                            </span>

                            @endif

                        </div>

                        <p class="text-gray-300 text-sm whitespace-pre-line">
                            {{ $msg->message }}
                        </p>

                        @if ($msg->reply)

                        <div class="mt-2 pl-4 border-l-2 border-gray-600">

                            <p class="text-xs text-gray-500 mb-1">
                                Resposta de {{ $msg->repliedBy?->name ?? 'Admin' }}:
                            </p>

                            <p class="text-gray-300 text-sm whitespace-pre-line">
                                {{ $msg->reply }}
                            </p>

                        </div>

                        @else

                        <button
                            @click='openReply(@json($msg->only(["id", "name", "email"])))'
                            class="self-start text-sm text-cyan-400 hover:text-cyan-300 transition">
                            Responder
                        </button>

                        @endif

                    </div>

                    @empty

                    <div class="px-5 py-10 text-center text-gray-500">
                        Nenhuma mensagem recebida ainda.
                    </div>

                    @endforelse

                </div>

                <div class="mt-6">
                    {{ $msgs->links() }}
                </div>

            </main>

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

        </div>

    </div>

</x-app-layout>