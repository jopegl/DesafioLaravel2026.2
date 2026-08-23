<x-modal-panel show="showDeleteAccount" max-width="max-w-sm" x-cloak>

    <div class="text-center space-y-5">

        <x-icons.warning />

        <p class="text-white text-sm">
            Tem certeza que deseja excluir sua conta? Essa ação não pode ser desfeita.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-3">

            @csrf
            @method('DELETE')

            <input type="password" name="password" placeholder="Confirme sua senha" required
                class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm text-center focus:outline-none focus:ring-1 focus:ring-red-400">
            @error('password', 'userDeletion')
            <p class="text-red-400 text-xs">{{ $message }}</p>
            @enderror

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-400 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Excluir conta
                </button>
                <button type="button" @click="showDeleteAccount = false"
                    class="flex-1 border border-gray-600 text-gray-300 hover:bg-gray-800 text-sm font-medium py-2.5 rounded-lg transition">
                    Cancelar
                </button>
            </div>

        </form>

    </div>

</x-modal-panel>