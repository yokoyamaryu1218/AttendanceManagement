<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <img src="data:image/png;base64,{{Config::get('base64.file_login')}}" class="w-20 h-20 fill-current text-gray-500">
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <!-- 社員ID -->
            <div>
                <x-label for="id" :value="__('社員ID')" />

                <x-input id="emplo_id" class="form-style block mt-1 w-full" type="text" name="emplo_id" :value="old('emplo_id')" required autocomplete="on" autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4 form-item">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="form-style block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <span class="auth-field-icon"><i id="eye" class="fa-solid fa-eye toggle-password" style="color:#8a8a8a"></i></span>
            </div>
            <script src="{{ asset('/js/another/auth.js') }}"></script>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('employee.login'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('employee.login') }}">
                    {{ __('出退勤画面へ') }}
                </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
