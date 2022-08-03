<!-- dashoboardに表示する従業員一覧のblade -->
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
            <div class="text-right">
                <form method="get" action="{{ route('admin.emplo_create')}}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn-success border-0 py-2 px-8 focus:outline-none rounded text-lg">新規登録</button>
                </form>
            </div>
            @include('menu.admin.emplo_list')
            <div class="text-right">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.retirement') }}">
                    {{ __('退職者一覧へ') }}
                </a>
            </div>
        </div>
    </div>
</section>