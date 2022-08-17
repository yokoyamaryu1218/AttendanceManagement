<!-- admin側　勤怠一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-4 mt-20 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <!-- 月度プルダウン部分 -->
                    <!-- プルダウンの月度を変更すれば、下の一覧も変わる -->
                    <form method="POST" action="{{ route('admin.monthly_change',[$emplo_id, $name])}}" name="monthly_change">
                        @csrf
                        <select class="rounded-pill mb-1" name="monthly_change" onchange="submit(this.form)"  title="当月から過去1年分の勤怠一覧をプルダウンから選択できます。">
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
                        <BR class="sma">{{ $name }}さん
                        <!-- 名前表示部分ここまで -->
                    </form>
                    <!-- 月度プルダウン部分ここまで -->
                    <!-- 戻るボタン配置 -->
                    <div class="text-right mb-1">
                        <input class="btn btn-warning" type="button" value="戻る" onclick="window.history.back()" title="1つ前の画面に戻ります。">
                    </div>
                    <!-- 戻るボタンここまで -->
                    <!-- 絞り込み部分 -->
                    @include('menu.attendance.search03')
                    <!-- 絞り込み部分ここまで -->
                    <!-- フラッシュメッセージの表示 -->
                    @include('menu.attendance.validation')
                    <!-- フラッシュメッセージここまで -->

                    <!-- 勤怠一覧の合計表示部分 -->
                    @include('menu.attendance.search02')
                    <!-- 合計表示部分ここまで -->
                    <!-- ここから月別勤怠一覧部分 -->
                    @include('menu.attendance.attend-lists02')
                    <!-- 月別勤怠一覧部分ここまで -->
                </div>
            </div>

            <!-- ここからモーダル -->
            @include('menu.modal.modal02')
            <!-- モーダルここまで -->
        </section>
    </body>
</x-app-layout>

<!-- モーダルのjs -->
<script src="{{ asset('js/modal/modal2.js') }}" defer></script>

<!-- 絞り込みメニューのcssとjs -->
<link rel="stylesheet" href="{{ asset('css/accordion.css') }}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
