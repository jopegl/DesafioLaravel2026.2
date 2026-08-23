<div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

    <div class="lg:hidden flex items-center justify-between px-4 py-4 bg-[#0d0f14] text-white border-b border-gray-800/60">

        <div class="flex items-center gap-2">
            <span class="text-cyan-400 text-2xl font-light leading-none">|</span>
            <h1 class="text-lg font-semibold tracking-wide">empori<span class="text-cyan-400">O</span></h1>
        </div>

        <button @click="sidebarOpen = true" aria-label="Abrir menu"
            class="p-2 text-gray-300 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
            </svg>
        </button>

    </div>

    <aside class="hidden lg:flex w-64 h-screen sticky top-0 bg-[#0d0f14] text-white flex-col border-r border-gray-800/60 shrink-0">

        <div class="px-6 py-6 flex items-center gap-2">
            <span class="text-cyan-400 text-2xl font-light leading-none">|</span>
            <h1 class="text-xl font-semibold tracking-wide">empori<span class="text-cyan-400">O</span></h1>
        </div>

        <div class="flex flex-col items-center py-6 border-b border-gray-800/60">
            <img src="{{ userPhotoUrl(auth()->user()->photo) }}"
                alt="{{ auth()->user()->name }}"
                class="w-20 h-20 rounded-full object-cover mb-3 ring-2 ring-gray-700">
            <span class="font-semibold text-sm truncate max-w-[180px] block text-center" title="{{ auth()->user()->name }}">
                {{ auth()->user()->name }}
            </span>
            <span class="text-xs text-cyan-400 uppercase tracking-wide mt-1">
                {{ auth()->user()->is_admin ?? false ? 'Admin' : 'Usuário' }}
            </span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">

            @if(auth()->user()->is_admin)

            <a href="{{ route('admins.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admins.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2h8z" />
                </svg>
                Admins
            </a>

            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('users.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm8 3a4 4 0 10-4-4" />
                </svg>
                Usuários
            </a>

            <a href="{{ route('admin.email.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
          {{ request()->routeIs('admin.email.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                Enviar E-mail
            </a>

            @endif

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

            @if(!auth()->user()->is_admin)

            <a href="{{ route('purchases.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
        {{ request()->routeIs('purchases.index') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.94-4.706 2.436-7.183.075-.37-.216-.717-.594-.717H5.106M7.5 14.25L5.106 5.25M7.5 14.25L5.25 18M18.75 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM9 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>

                Minhas Compras
            </a>

            @endif

            @if(auth()->user()->is_admin)

            <a href="{{ route('contacts.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
           {{ request()->routeIs('contacts.index') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>

                Contatos
            </a>

            @endif

        </nav>
    </aside>

    <div x-show="sidebarOpen" x-cloak
        class="fixed inset-0 z-50 bg-black/60 lg:hidden"
        x-transition.opacity
        @click="sidebarOpen = false">
    </div>

    <aside x-show="sidebarOpen" x-cloak @click.stop
        class="fixed inset-y-0 left-0 z-50 w-64 min-h-screen bg-[#0d0f14] text-white flex flex-col border-r border-gray-800/60 lg:hidden"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full">

        <div class="px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-cyan-400 text-2xl font-light leading-none">|</span>
                <h1 class="text-xl font-semibold tracking-wide">empori<span class="text-cyan-400">O</span></h1>
            </div>
            <button @click="sidebarOpen = false" aria-label="Fechar menu" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
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

            @if(auth()->user()->is_admin)

            <a href="{{ route('admins.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admins.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2h8z" />
                </svg>
                Admins
            </a>

            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('users.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm8 3a4 4 0 10-4-4" />
                </svg>
                Usuários
            </a>

            <a href="{{ route('admin.email.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
          {{ request()->routeIs('admin.email.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                Enviar E-mail
            </a>

            @endif

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

            @if(!auth()->user()->is_admin)

            <a href="{{ route('purchases.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                    {{ request()->routeIs('purchases.index') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.94-4.706 2.436-7.183.075-.37-.216-.717-.594-.717H5.106M7.5 14.25L5.106 5.25M7.5 14.25L5.25 18M18.75 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM9 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>

                Minhas Compras
            </a>

            @endif

            @if(auth()->user()->is_admin)

            <a href="{{ route('contacts.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->routeIs('contacts.index') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-800/70' }}">

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

                Contatos
            </a>

            @endif

        </nav>
    </aside>

</div>