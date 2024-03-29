<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="data:image/png;base64,{{Config::get('base64.file')}}" class="block h-10 w-auto fill-current text-gray-600">
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex justify-between h-16">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('HOME') }}
                    </x-nav-link>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.emplo_create')">
                        {{ __('新規登録') }}
                    </x-nav-link>
                </div>

                <!-- Navigation Links -->
                @if (Auth::guard('admin')->user()->admin_authority == "1")
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.management')">
                        {{ __('管理画面') }}
                    </x-nav-link>
                </div>
                @endif

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.change_password')">
                        {{ __('パスワード変更') }}
                    </x-nav-link>
                </div>

                <!-- Navigation Links -->
                <form method="POST" action="{{ route('admin.logout') }}" class="hidden space-x-8 sm:-my-px sm:flex">
                    @csrf
                    <x-nav-link :href="route('admin.logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('ログアウト') }}
                    </x-nav-link>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>


        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800">名前：{{ Auth::guard('admin')->user()->name }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')">

                        {{ __('HOME') }}
                    </x-responsive-nav-link>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.emplo_create')">
                        {{ __('新規登録') }}
                    </x-responsive-nav-link>
                </div>

                @if (Auth::guard('admin')->user()->admin_authority == "1")
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.management')">
                        {{ __('管理画面') }}
                    </x-responsive-nav-link>
                </div>
                @endif

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.change_password')">
                        {{ __('パスワード変更') }}
                    </x-responsive-nav-link>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('admin.logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('ログアウト') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
</nav>