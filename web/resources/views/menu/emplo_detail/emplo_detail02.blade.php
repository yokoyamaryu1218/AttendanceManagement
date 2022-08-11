<!-- admin側 従業員の一覧を表示する共通用blade -->
@if($employee_lists->all())
<!-- 検索機能 -->
<div class="text-right">
    <form action="{{ route('admin.search', [$retirement_authority])}}" method="post">
        @csrf
        @method('post')
        @if(!empty($_POST['search']))
        <input type="search" name="search" class="top" maxlength="32" placeholder="人員検索" value="{{ $_POST['search'] }}">
        @else
        <input type="search" name="search" class="top" maxlength="32" placeholder="人員検索">
        @endif
        <button class="main_button_style" data-toggle="tooltip" type="submit">
            <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索">
        </button>
    </form>
</div>
<!-- 検索機能ここまで -->
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
            <!-- 社員番号 -->
            <td class="align-middle">{{$emplo->emplo_id}}</td>
            <!-- 従業員名 -->
            <td class="align-middle">{{$emplo->name}}</td>
            <!-- 詳細画面 -->
            <td class="align-middle button">
                <form method="POST" action="{{ route('admin.emplo_details', [$emplo->emplo_id,$emplo->retirement_authority]) }}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                </form>
            </td>
            <!-- 勤怠一覧 -->
            <td class="align-middle button">
                <form method="POST" action="{{ route('admin.monthly')}}">
                    @csrf
                    <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{$emplo->emplo_id}}">
                    <input type="hidden" class="form-control" id="name" name="name" value="{{$emplo->name}}">
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                </form>
            </td>
            <!-- パスワード変更 -->
            <td class="align-middle button">
                <form method="POST" action="{{ route('admin.emplo_change_password', [ 'emplo_id'=> $emplo->emplo_id , 'name'=> $emplo->name ] )}}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">開く</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$employee_lists->links('components.pagenation')}}
@else
該当する社員がいません。
@endif
