<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
            @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
            @endif
            <table class="table table-striped table-hover table-sm my-2">
                <thead>
                    <tr>
                        <th scope="col">社員番号</th>
                        <th scope="col">名前</th>
                        <th scope="col">詳細</th>
                        <th scope="col">勤怠一覧</th>
                        <th scope="col">パスワード</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee_lists as $emplo)
                    <tr>
                        <td class="align-middle">{{$emplo->emplo_id}}</td>
                        <td class="align-middle">{{$emplo->name}}</td>
                        <td class="align-middle button">
                            <form method="POST" action="{{ route('admin.emplo_details')}}">
                                @csrf
                                <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{$emplo->emplo_id}}">
                                <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                            </form>
                        </td>
                        <td class="align-middle button">
                            <form method="POST" action="{{ route('employee.subord_monthly')}}">
                                @csrf
                                <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{$emplo->emplo_id}}">
                                <input type="hidden" class="form-control" id="name" name="name" value="{{$emplo->name}}">
                                <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                            </form>
                        </td>
                        <td class="align-middle button">
                            <form method="POST" action="{{ route('employee.subord.change_password' )}}">
                                @csrf
                                <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{$emplo->emplo_id}}">
                                <input type="hidden" class="form-control" id="name" name="name" value="{{$emplo->name}}">
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