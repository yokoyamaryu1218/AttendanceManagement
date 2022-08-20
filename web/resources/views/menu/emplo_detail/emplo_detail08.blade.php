<!-- admin側 時短社員一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-20 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <div class="flex flex-col text-center w-full mb-20">
                        <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">時短社員一覧</h1>
                    </div>
                    @if($short_worker_lists->all())
                    <table class="tbl-r05 table table-striped text-center table-hover table-sm my-2">
                        <tr class="thead">
                            <th width="100">社員番号</th>
                            <th width="100">名前</th>
                            <th width="100">詳細</th>
                            <th width="100">勤怠一覧</th>
                            <th width="100">パスワード</th>
                        </tr>
                        <tbody>
                            @foreach($short_worker_lists as $emplo)
                            <tr>
                                <!-- 社員番号 -->
                                <td class="text-right" data-label="社員番号" width="100">{{$emplo->emplo_id}}</td>
                                <!-- 従業員名 -->
                                <td class="text-left" data-label="名　　前" width="100">{{$emplo->name}}</td>
                                <!-- 詳細画面 -->
                                <td data-label="詳　　細" width="100" class="align-middle button">
                                    <form method="POST" action="{{ route('admin.emplo_details', [$emplo->emplo_id, $emplo->retirement_authority]) }}">
                                        @csrf
                                        <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、選択した社員の詳細画面へ移動します。">開く</button>
                                    </form>
                                </td>
                                <!-- 勤怠一覧 -->
                                <td data-label="勤怠一覧" width="100" class="align-middle button">
                                    <form method="POST" action="{{ route('admin.monthly',[$emplo->emplo_id, $emplo->name]) }}">
                                        @csrf
                                        <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、選択した社員の勤怠一覧へ移動します。">開く</button>
                                    </form>
                                </td>
                                <!-- パスワード変更 -->
                                <td data-label="パスワード" width="100" class="align-middle button">
                                    <form method="POST" action="{{ route('admin.emplo_change_password', [ 'emplo_id'=> $emplo->emplo_id , 'name'=> $emplo->name ] )}}">
                                        @csrf
                                        <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、選択した社員のパスワード変更画面へ移動します。">開く</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $short_worker_lists->links('components.pagenation')}}
                    @else
                    該当する社員がいません。
                    @endif
                    <!-- 通常はこちらのclassが適用される -->
                    <div class="none text-right">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.dashboard') }}">
                            {{ __('従業員一覧へ') }}
                        </a>
                    </div>
                    <!-- レスポンシブはこちらのclassが適用される -->
                    <div class="sma text-right">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.dashboard') }}">
                            {{ __('従業員一覧へ') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>