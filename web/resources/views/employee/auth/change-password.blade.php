<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <form method="POST" action="{{ route('employee.password.update') }}">
        @csrf

        <body>
            <section class="text-gray-600 body-font relative">
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                        <p class="sm:text-4xl text-2xl font-medium title-font mb-2">パスワード変更画面</p>
                        <!-- フラッシュメッセージの表示 -->
                        @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                        @endif
                        @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if ($errors->has('password'))
                        <div class="alert text-center alert-warning">
                            {{ $errors->first('password') }}
                        </div>
                        @endif

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="old_password" :value="__('現在のパスワード')" />
                            <x-input id="old_password" class="mt-1 w-auto bg-gray-100" type="password" name="old_password" placeholder="現在のパスワード" autocomplete="off" required /></br>
                            <input type="checkbox" id="password-check3">パスワードを表示する 
                        </div>
                        <!--  new Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('新パスワード')" />
                            <x-input id="password" class="mt-1 w-auto bg-gray-100" type="password" name="password" placeholder="新しいパスワード" autocomplete="off" required /></br>
                            <input type="checkbox" id="password-check">パスワードを表示する 
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-input id="password_confirmation" class="mt-1 w-auto bg-gray-100" type="password" name="password_confirmation" placeholder="新パスワードの確認用" autocomplete="off" required /></br>
                            <input type="checkbox" id="password-check2">パスワードを表示する
                        </div>
                        <script src="{{ asset('/js/another/auth.js') }}"></script>

                        <div class="flex justify-center mt-3">
                            <button class="flex text-white mx-2 bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">変更</button>
                            <input id="myButton" class="flex text-white mx-2 bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg" type="button" value="戻る">
                        </div>
                    </div>
                </div>
            </section>
        </body>
    </form>
    <!-- 戻るボタンの遷移先 -->
    <script type="text/javascript">
        document.getElementById("myButton").onclick = function() {
            location.href = "{{ route('employee.dashboard') }}";
        };
    </script>
</x-app-layout>