<!-- パスワード変更画面の共通blade -->

<body>
    <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
        <div class="flex flex-col text-center w-full mb-20">
            <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">パスワード変更画面</h1>
        </div>
        <section class="text-gray-600 text-center body-font relative">
            <!-- フラッシュメッセージの表示 -->
            @include('menu.attendance.validation')

            <!-- フラッシュメッセージここまで -->
            <!-- パスワードを変更する社員の名前 -->
            <div class="mt-4">
                社員名：{{ $name }}さん
                <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{ $emplo_id }}">
                <input type="hidden" class="form-control" id="name" name="name" value="{{ $name }}">
            </div>

            <!--  new Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('新パスワード')" />
                <x-input id="password" class="mt-1 w-auto" type="password" name="password" placeholder="新しいパスワード" autocomplete="off" title="新しいパスワードを英数混合8文字以上で設定します。" required /></br>
                <input type="checkbox" id="password-check">パスワードを表示する
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-input id="password_confirmation" class="mt-1 w-auto" type="password" name="password_confirmation" placeholder="新パスワードの確認用" autocomplete="off" title="新しいパスワードをもう一度入力します。" required /></br>
                <input type="checkbox" id="password-check2">パスワードを表示する
            </div>
            <script src="{{ asset('/js/another/auth.js') }}"></script>

            <div class="flex justify-center mt-4">
                <button class="flex text-white mx-2 bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、変更が確定します。">変更</button>
                <!-- 戻るボタン配置 -->
                <div class="text-right mb-1">
                    <input id="myButton" class="text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg" type="button" value="戻る" title="前のに戻ります。">
                    <!-- 出退勤画面からのアクセスの場合は、部下一覧に戻る -->
                    @if (Auth::guard('employee')->check())
                    <script type="text/javascript">
                        document.getElementById("myButton").onclick = function() {
                            location.href = "{{ route('employee.subord') }}";
                        };
                    </script>
                    @elseif (Auth::guard('admin')->check())
                    <!-- 管理画面からのアクセスの場合は、HOME画面に戻る -->
                    <script type="text/javascript">
                        document.getElementById("myButton").onclick = function() {
                            location.href = "{{ route('admin.dashboard') }}";
                        };
                    </script>
                    @endif
                </div>
                <!-- 戻るボタンここまで -->
            </div>
        </section>
    </div>
</body>
