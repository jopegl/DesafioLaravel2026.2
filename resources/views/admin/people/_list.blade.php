<x-app-layout>

    <div class="flex flex-col lg:flex-row min-h-screen bg-[#15171e]">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col" x-data="crudModals">

            <main class="flex-1 px-4 sm:px-8 py-8">

                <x-alerts />

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                    <h2 class="text-xl font-semibold text-white">
                        {{ $pluralTitle }}
                    </h2>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                        <form method="GET" action="{{ route("{$prefix}.index") }}" class="w-full sm:w-auto">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar por nome ou e-mail..."
                                class="w-full sm:w-64 bg-gray-800 border border-gray-700 rounded-full px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500">
                        </form>

                        <button @click="showCreate = true"
                            class="w-full sm:w-auto bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition whitespace-nowrap">
                            Cadastrar {{ $singular }}
                        </button>

                    </div>

                </div>

                <div class="bg-[#1c1f2a] rounded-xl border border-gray-800/60 overflow-x-auto [-webkit-overflow-scrolling:touch]">

                    <table class="w-full min-w-[840px] text-sm text-left">

                        <thead>
                            <tr class="text-gray-400 border-b border-gray-800/60">
                                <th class="px-5 py-4 font-medium w-20"></th>
                                <th class="px-5 py-4 font-medium">Nome</th>
                                <th class="px-5 py-4 font-medium">E-mail</th>
                                <th class="px-5 py-4 font-medium">Telefone</th>
                                <th class="px-5 py-4 font-medium">Endereço</th>
                                <th class="px-5 py-4 font-medium">Cadastrado em</th>
                                <th class="px-5 py-4 font-medium text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-200">

                            @forelse ($people as $user)

                            <tr class="border-b border-gray-800/40 last:border-0 hover:bg-white/[0.02]">

                                <td class="px-5 py-4">
                                    <img src="{{ userPhotoUrl($user->photo) }}" alt="{{ $user->name }}"
                                        class="w-10 h-10 shrink-0 min-w-[2.5rem] min-h-[2.5rem] rounded-full object-cover bg-gray-700 block">
                                </td>

                                <td class="px-5 py-4">{{ $user->name }}</td>

                                <td class="px-5 py-4 text-gray-400">{{ $user->email }}</td>

                                <td class="px-5 py-4 text-gray-400">{{ $user->phone ?? '—' }}</td>

                                <td class="px-5 py-4 text-gray-400">
                                    @if($user->defaultAddress)
                                    {{ $user->defaultAddress->city }}/{{ $user->defaultAddress->state }}
                                    @else
                                    <span class="text-gray-600">Não cadastrado</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-gray-400">{{ $user->created_at->format('d-M-Y') }}</td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-3 text-cyan-400">

                                        <button
                                            @click='openView(@json(array_merge($user->toArray(), ["photo_url" => userPhotoUrl($user->photo)])))'
                                            title="Visualizar" class="hover:text-cyan-300">
                                            <x-icons.eye />
                                        </button>

                                        <button
                                            @click='openEdit(@json(array_merge($user->toArray(), ["photo_url" => userPhotoUrl($user->photo)])))'
                                            title="Editar" class="hover:text-cyan-300">
                                            <x-icons.pencil />
                                        </button>

                                        <button @click='openDelete(@json($user))' title="Excluir" class="hover:text-red-400">
                                            <x-icons.trash />
                                        </button>

                                    </div>
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                    Nenhum {{ $singular }} cadastrado até o momento.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-6">
                    {{ $people->links() }}
                </div>

            </main>

            @include('admin.people.modals.create', ['prefix' => $prefix, 'singular' => $singular])
            @include('admin.people.modals.view')
            @include('admin.people.modals.edit', ['urlBase' => $urlBase])
            @include('admin.people.modals.delete', ['urlBase' => $urlBase])

        </div>

    </div>

</x-app-layout>