<!-- admin側 従業員一覧のblade -->
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
            <!-- 従業員の一覧を表示する共通用bladeへ -->
            @include('menu.emplo_detail.emplo_detail02')
            <!-- 通常はこちらのclassが適用される -->
            <div class="none text-right">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.short_worker') }}">
                    {{ __('時短社員を表示') }}
                </a>
                　
                <!-- 退職者リストにデータがある場合は退職者一覧のリンクを出す -->
                @if(!(empty($retirement_lists)))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.retirement') }}">
                    {{ __('退職者一覧へ') }}
                </a>
            </div>
            <!-- レスポンシブはこちらのclassが適用される -->
            <div class="sma text-right mt-2">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.short_worker') }}"> {{ __('時短社員を表示') }}
                </a>
                <BR class="sma">
                <div class="mt-2">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.retirement') }}">
                        {{ __('退職者一覧へ') }}
                    </a>
                </div>
            </div>
            @endif
            <!-- 退職者一覧のリンクここまで -->
        </div>
    </div>
</section>
