<aside class="w-64 min-h-screen bg-[#0d0f14] text-white flex flex-col border-r border-gray-800/60 shrink-0">

    <div class="px-6 py-6 flex items-center gap-2">
        <span class="text-cyan-400 text-2xl font-light leading-none">|</span>
        <h1 class="text-xl font-semibold tracking-wide">empori<span class="text-cyan-400">O</span></h1>
    </div>

    <div class="flex flex-col items-center py-6 border-b border-gray-800/60">
        <img src="{{ userPhotoUrl(auth()->user()->photo) }}"
            alt="{{ auth()->user()->name }}"
            class="w-20 h-20 rounded-full object-cover mb-3 ring-2 ring-gray-700">
        <span class="font-semibold text-sm">{{ auth()->user()->name }}</span>
        <span class="text-xs text-cyan-400 uppercase tracking-wide mt-1">
            {{ auth()->user()->is_admin ?? false ? 'Admin' : 'Usuário' }}
        </span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1">

        <a href="#"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs('admins.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2h8z" />
            </svg>
            Admins
        </a>

        <a href="#"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs('usuarios.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm8 3a4 4 0 10-4-4" />
            </svg>
            Usuários
        </a>

        <a href="{{route('profile.edit')}}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs('profile.edit') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Perfil
        </a>

        <a href="{{route('products.index')}}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs('products.index') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Produtos
        </a>

        <a href="{{ route('sales.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
           {{ request()->routeIs('sales.index') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18.75 8.25h.008v.008h-.008V8.25ZM5.25 15.75h.008v.008H5.25v-.008Z" />
            </svg>

            Vendas
        </a>

    </nav>
</aside>