<!-- admin側 従業員の一覧を表示する共通用blade -->
@if($employee_lists->all())
<!-- 検索機能 -->
<div class="text-right">
    <form action="{{ route('admin.search', [$retirement_authority])}}" method="post" title="社員番号、もしくは社員名を入力することで、社員検索ができます。">
        @csrf
        @method('post')
        @if(!empty($_POST['search']))
        <input type="search" name="search" class="top" size="15" placeholder="人員検索" value="{{ $_POST['search'] }}">
        @else
        <input type="search" name="search" class="top" size="15" placeholder="人員検索">
        @endif
        <button class="main_button_style" data-toggle="tooltip" type="submit">
            <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索">
        </button>
    </form>
</div>
<!-- 検索機能ここまで -->
<table class="tbl-r05 table table-striped table-hover table-sm my-2">
    <tr class="thead">
        <th width="100">社員番号</th>
        <th width="100">名前</th>
        <th width="100">詳細</th>
        <th width="100">勤怠一覧</th>
        <th width="100">パスワード</th>
    </tr>
    <tbody>
        @foreach($employee_lists as $emplo)
        <tr>
            <!-- 社員番号 -->
            <td data-label="社員番号"  width="100">{{$emplo->emplo_id}}</td>
            <!-- 従業員名 -->
            <td data-label="名前"  width="100">{{$emplo->name}}</td>
            <!-- 詳細画面 -->
            <td data-label="詳細"  width="100" class="align-middle button">
                <form method="POST" action="{{ route('admin.emplo_details', [$emplo->emplo_id, $emplo->retirement_authority]) }}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg" title="ボタンをクリックすることで、選択した社員の詳細画面へ移動します。">開く</button>
                </form>
            </td>
            <!-- 勤怠一覧 -->
            <td data-label="勤怠一覧"  width="100" class="align-middle button">
                <form method="POST" action="{{ route('admin.monthly',[$emplo->emplo_id, $emplo->name]) }}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg" title="ボタンをクリックすることで、選択した社員の勤怠一覧へ移動します。">開く</button>
                </form>
            </td>
            <!-- パスワード変更 -->
            <td data-label="パスワード"  width="100" class="align-middle button">
                <form method="POST" action="{{ route('admin.emplo_change_password', [ 'emplo_id'=> $emplo->emplo_id , 'name'=> $emplo->name ] )}}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg" title="ボタンをクリックすることで、選択した社員のパスワード変更画面へ移動します。">開く</button>
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
