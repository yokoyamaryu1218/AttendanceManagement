<!-- employee側　勤怠一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <link rel="stylesheet" href="{{ asset('css/accordion.css') }}">

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-4 mt-20 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <!-- 月度プルダウン部分 -->
                    <!-- プルダウンの月度を変更すれば、下の一覧も変わる -->
                    <form method="POST" class="mb-4" action="{{ route('employee.monthly_change')}}" name="monthly_change">
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
                    <!-- 月度プルダウン部分ここまで -->
                    <!-- 戻るボタン配置 -->
                    <div class="text-right mb-1">
                        <button class="title btn btn-secondary">絞り込み</button>
                        <div class="box">
                            <form method="POST" action="{{ route('employee.monthly_search',[$emplo_id] )}}" name="monthly_change">
                                @csrf
                                <small><b>指定期間内の出勤日数・総勤務時間・残業時間を表示します。</b></small></BR>
                                <input type="date" id="first_day" name="first_day" value="{{ old('first_day') }}">
                                ～ <input type="date" id="end_day" name="end_day" value="{{ old('end_day') }}">
                                <button class="main_button_style" data-toggle="tooltip" type="submit">
                                    <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索">
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- 戻るボタンここまで -->
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
                    @if ($errors->has('daily'))
                    <div class="alert text-center alert-warning">
                        {{ $errors->first('daily') }}
                    </div>
                    @endif
                    <!-- フラッシュメッセージここまで -->

                    <!-- ここから月別勤怠一覧部分 -->
                    @include('menu.attendance.attend-lists01')
                    <!-- 月別勤怠一覧部分ここまで -->
                </div>
            </div>
            <!-- ここからモーダル -->
            <!-- 自分自身の勤怠一覧の場合、日報表示のモーダルを表示 -->
            @if (Auth::guard('employee')->user()->emplo_id == $emplo_id)
            @include('menu.modal.modal01')
            @else
            <!-- 部下の勤怠一覧の場合、勤怠修正のモーダル表示 -->
            @include('menu.modal.modal03')
            @endif
            <!-- モーダルここまで -->
        </section>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/accordion.js') }}" defer></script>
    </body>
</x-app-layout>
