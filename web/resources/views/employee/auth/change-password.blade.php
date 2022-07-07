<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">パスワード変更画面</h1>
                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('現在のパスワード')" />

                        <x-input id="password" class="mt-1 w-4/12 bg-gray-100" type="password" name="password" placeholder="現在のパスワード" required />
                    </div>
                    <!--  new Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('新パスワード')" />

                        <x-input id="password" class="mt-1 w-4/12 bg-gray-100" type="password" name="password" placeholder="新しいパスワード" required />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="mt-1 w-4/12 bg-gray-100" type="password" name="password_confirmation" placeholder="新パスワードの確認用" required />
                    </div>

                    <div class="p-2 w-full">
                        <button class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">変更</button>
                    </div>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>