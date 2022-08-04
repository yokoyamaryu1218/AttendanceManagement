<!-- 勤怠一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <!-- レスポンシブはhttps://tailwindcss.jp/docs/marginを参照にする -->
            <div class="pt-20 ml-64">
                <!-- 月度プルダウン部分 -->
                <label>
                    <!-- プルダウンの月度を変更すれば、下の一覧も変わる -->
                    <form method="POST" action="{{ route('admin.monthly_change')}}" name="monthly_change">
                        @csrf
                        <input type="hidden" class="form-control" id="emplo_id" name="emplo_id" value="{{$emplo_id}}">
                        <input type="hidden" class="form-control" id="name" name="name" value="{{$name}}">
                        <select class="rounded-pill mb-1" name="monthly_change" onchange="submit(this.form)">
                            <option value="{{ date('Y-m') }}">
                                {{ date('Y年m月') }}
                            </option>
                            <!-- $i<12の12を変えることで表示する月数を変更することができる -->
                            <!-- strtotimeの+で設定することで当月以降1年、-で当月以前1年の表示になる -->
                            @for ($i = 1; $i < 12; $i++) {{ $target_ym = strtotime("- {$i}months"); }} <option value="{{ date('Y-m', $target_ym) }}" @if ($ym==date('Y-m', $target_ym)) selected @endif>
                                {{ date('Y年m月', $target_ym) }}
                                </option>
                                @endfor
                        </select>
                        <!-- 名前表示部分 -->
                        {{ $name }}さん
                        <!-- 名前表示部分ここまで -->
                    </form>
                </label>
                <!-- 月度プルダウン部分ここまで -->
            </div>
            <!-- ここから月別勤怠一覧部分 -->
            <div class="container px-5 py-4 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <!-- フラッシュメッセージの表示 -->
                    @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="alert alert-info">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    @include('menu.monthly.daily2')
                </div>
            </div>
            <!-- 月別勤怠一覧部分ここまで -->
            <!-- ここからモーダル -->
            @include('menu.admin.daily-change')
            <!-- モーダルここまで -->

        </section>
    </body>
</x-app-layout>
