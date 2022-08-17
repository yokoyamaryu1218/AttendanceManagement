<!-- employee側 部下一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div class="container px-5 py-20 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">部下一覧</h1>
            </div>
            <section class="lg:w-2/3 w-full mx-auto text-center overflow-auto">
                <table class="tbl-r05 table table-striped table-hover table-sm my-2">
                    <tr class="thead">
                        <th width="100">社員番号</th>
                        <th width="100">名前</th>
                        <th width="100">勤怠一覧</th>
                        <th width="100">パスワード</th>
                    </tr>

                    <tbody>
                        @foreach($subord_data as $subord)
                        <tr>
                            <!-- 社員番号 -->
                            <td class="text-right" data-label="社員番号" width="100">{{$subord->subord_id}}</td>
                            <!-- 従業員名 -->
                            <td class="text-left" data-label="名　　前" width="100">{{$subord->subord_name}}</td>
                            <!-- 勤怠一覧 -->
                            <td data-label="勤怠一覧" width="100" class="align-middle button">
                                <form method="POST" action="{{ route('employee.subord_monthly',[$subord->subord_id, $subord->subord_name]) }}">
                                    @csrf
                                    <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、選択した社員のパスワード変更画面へ移動します。">開く</button>
                                </form>
                            </td>
                            <!-- パスワード変更 -->
                            <td data-label="パスワード" width="100" class="align-middle button">
                                <form method="POST" action="{{ route('employee.subord.change_password', [ 'emplo_id'=> $subord->subord_id , 'name'=> $subord->subord_name ] )}}">
                                    @csrf
                                    <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、選択した社員のパスワード変更画面へ移動します。">開く</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$subord_data->links('components.pagenation')}}
            </section>
        </div>
    </body>
</x-app-layout>