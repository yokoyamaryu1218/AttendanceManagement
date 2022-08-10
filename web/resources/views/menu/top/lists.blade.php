<!-- admin側 従業員一覧のblade -->
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
            <div class="text-right">
                <!-- 新規登録ボタンへ -->
                <form method="get" action="{{ route('admin.emplo_create')}}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">新規登録</button>
                </form>
                <!-- 新規登録ボタンここまで -->
            </div>
            @if(!(empty($employee_lists[0])))
            <!-- 従業員の一覧を表示する共通用bladeへ -->
            @include('menu.emplo_detail.emplo_detail02')
            @else
            <!-- 在職者がいない場合は何も出さない -->
            <div class="text-center">
                <h5>現在、在職者はいないようです。</h5></BR>
            </div>
            @endif
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