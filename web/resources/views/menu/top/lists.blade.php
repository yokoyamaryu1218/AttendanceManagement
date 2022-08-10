<!-- admin側 従業員一覧のblade -->
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
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
            <!-- 従業員の一覧を表示する共通用bladeへ -->
            @include('menu.emplo_detail.emplo_detail02')
            <!-- 退職者リストにデータがある場合は退職者一覧のリンクを出す -->
            @if(!(empty($retirement_lists)))
            <div class="text-right">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.retirement') }}">
                    {{ __('退職者一覧へ') }}
                </a>
            </div>
            @endif
            <!-- 退職者一覧のリンクここまで -->
        </div>
    </div>
</section>