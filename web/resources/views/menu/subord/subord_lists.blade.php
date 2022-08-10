<!-- employee側 部下一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-20">
                    <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">部下一覧</h1>
                </div>

                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tl rounded-bl">社員番号</th>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">名前</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤怠一覧</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">パスワード変更</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subord_data as $subord)
                            <tr>
                                <!-- 社員番号 -->
                                <th class="fix-col">{{$subord->emplo_id}}</td>
                                    <!-- 従業員名 -->
                                <td class="fix-col">{{$subord->name}}</td>
                                <!-- 勤怠一覧 -->
                                <td class="fix-col">
                                    <form method="POST" action="{{ route('employee.subord_monthly')}}">
                                        @csrf
                                        <input type="hidden" class="form-control" id="subord_id" name="subord_id" value="{{$subord->emplo_id}}">
                                        <input type="hidden" class="form-control" id="subord_name" name="subord_name" value="{{$subord->name}}">
                                        <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                                    </form>
                                </td>
                                <!-- パスワード変更 -->
                                <td class="fix-col">
                                    <form method="POST" action="{{ route('employee.subord.change_password', [ 'emplo_id'=> $subord->emplo_id , 'name'=> $subord->name ] )}}">
                                        @csrf
                                        <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>
