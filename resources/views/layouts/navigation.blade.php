<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo + Navigation -->
            <div class="flex items-center">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8 sm:-my-px sm:ms-10">

                    <!-- Home -->
                    <x-nav-link
                        :href="route('home')"
                        :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <!-- Dashboard -->
                    @if(Auth::check())
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @endif

                </div>

            </div>

            <!-- Busca -->
            <div class="flex-1 flex items-center justify-center sm:justify-start max-w-xs mx-4">
                <form method="GET" action="{{ route('home') }}" class="w-full">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar produtos..."
                        class="w-full bg-gray-800 border border-gray-700 rounded-full px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-primary-500">
                </form>
            </div>

            <!-- User -->
            @if(Auth::check())

            <!-- Carrinho -->
            <div class="hidden sm:flex sm:items-center sm:mr-4">
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center p-2 text-gray-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    @php $cartCount = Auth::user()->cartItemsCount(); @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-cyan-400 text-black text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">
                        {{ $cartCount > 9 ? '9+' : $cartCount }}
                    </span>
                    @endif
                </a>
            </div>

            {{-- Settings Dropdown --}}
            <div class="hidden sm:flex sm:items-center">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center p-1 border border-transparent rounded-full text-sm font-medium text-gray-300 bg-gray-800 hover:ring-2 hover:ring-cyan-400/50 focus:outline-none transition ease-in-out duration-150">

                            <img
                                src="{{ userPhotoUrl(Auth::user()->photo ?? null) }}"
                                alt="{{ Auth::user()->name }}"
                                class="w-9 h-9 rounded-full object-cover">

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        {{-- Profile --}}
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        {{-- Authentication --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault();
                                 this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            @else

            <!-- Guest -->
            <div class="hidden sm:flex items-center text-white">
                Olá visitante!
                <a class="underline ml-1" href="{{ route('login') }}">
                    Logar
                </a>
            </div>

            @endif

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">

                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24">

                        <!-- Menu -->
                        <path
                            :class="{'hidden': open, 'inline-flex': ! open}"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <!-- Close -->
                        <path
                            :class="{'hidden': ! open, 'inline-flex': open}"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div
        :class="{'block': open, 'hidden': ! open}"
        class="hidden sm:hidden">

        <!-- Navigation -->
        <div class="pt-2 pb-3 space-y-1">

            <!-- Home -->
            <x-responsive-nav-link
                :href="route('home')"
                :active="request()->routeIs('home')">

                {{ __('Home') }}

            </x-responsive-nav-link>


            <!-- Dashboard -->
            @if(Auth::check())

            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')">

                {{ __('Dashboard') }}

            </x-responsive-nav-link>

            @endif

        </div>


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">

            <!-- User Information -->
            <div class="px-4">

                @if(Auth::check())

                <div class="font-medium text-base text-white">
                    {{ Auth::user()->name }}
                </div>

                <div class="font-medium text-sm text-gray-400">
                    {{ Auth::user()->email }}
                </div>

                @else

                <div class="font-medium text-base text-white">
                    Olá visitante!
                </div>

                @endif

            </div>


            <!-- User Actions -->
            <div class="mt-3 space-y-1">

                @if(Auth::check())

                <x-responsive-nav-link :href="route('cart.index')">
                    <div class="flex items-center justify-between">
                        <span>Carrinho</span>
                        @php $cartCount = Auth::user()->cartItemsCount(); @endphp
                        @if($cartCount > 0)
                        <span class="bg-cyan-400 text-black text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                        @endif
                    </div>
                </x-responsive-nav-link>

                <!-- Profile -->
                <x-responsive-nav-link
                    :href="route('profile.edit')">

                    {{ __('Perfil') }}

                </x-responsive-nav-link>


                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                                     this.closest('form').submit();">

                        {{ __('Log Out') }}

                    </x-responsive-nav-link>

                </form>

                @else

                <!-- Login -->
                <x-responsive-nav-link
                    :href="route('login')">

                    {{ __('Logar') }}

                </x-responsive-nav-link>

                @endif

            </div>

        </div>

    </div>

</nav>