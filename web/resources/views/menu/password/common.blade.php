<!-- パスワード変更画面の共通blade -->

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

                <!-- パスワードを変更する社員の名前 -->
                <div class="mt-4">
                    社員名：{{ $name }}さん
                    <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{ $emplo_id }}">
                    <input type="hidden" class="form-control" id="name" name="name" value="{{ $name }}">
                </div>

                <!--  new Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('新パスワード')" />

                    <x-input id="password" class="mt-1 w-auto bg-gray-100" type="password" name="password" placeholder="新しいパスワード" required />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" class="mt-1 w-auto bg-gray-100" type="password" name="password_confirmation" placeholder="新パスワードの確認用" required />
                </div>

                <div class="flex justify-center mt-3">
                    <button class="flex text-white mx-2 bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">変更</button>
                    <input class="flex text-white mx-2 bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg" type="button" value="戻る" onclick="window.history.back()">
                </div>
            </div>
        </div>
    </section>
</body>