<!-- admin側 従業員一覧のblade -->
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
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
