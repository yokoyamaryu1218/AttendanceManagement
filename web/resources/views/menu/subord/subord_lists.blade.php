<!-- employee側 部下一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <p class="sm:text-4xl text-2xl font-medium title-font mb-2">部下一覧</p>
                </div>
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
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
                                <td data-label="社員番号" width="100">{{$subord->subord_id}}</td>
                                <!-- 従業員名 -->
                                <td data-label="名前" width="100">{{$subord->subord_name}}</td>
                                <!-- 勤怠一覧 -->
                                <td data-label="勤怠一覧" width="100" class="align-middle button">
                                    <form method="POST" action="{{ route('employee.subord_monthly',[$subord->subord_id, $subord->subord_name]) }}">
                                        @csrf
                                        <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                                    </form>
                                </td>
                                <!-- パスワード変更 -->
                                <td data-label="パスワード" width="100" class="align-middle button">
                                    <form method="POST" action="{{ route('employee.subord.change_password', [ 'emplo_id'=> $subord->subord_id , 'name'=> $subord->subord_name ] )}}">
                                        @csrf
                                        <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$subord_data->links('components.pagenation')}}
                </div>
            </div>
        </section>
    </body>
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</x-app-layout>