<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <!-- レスポンシブはhttps://tailwindcss.jp/docs/marginを参照にする -->
            <div class="pt-20 xl:ml-64 sm:py-6">
                <!-- 月度プルダウン部分 -->
                <label>
                    <!-- プルダウンの月度を変更すれば、下の一覧も変わる -->
                    <form method="POST" action="{{ route('employee.monthly_change')}}" name="monthly_change">
                        @csrf
                        <select class="form-control rounded-pill mb-3" name="monthly_change" onchange="submit(this.form)">
                            <option value="{{ date('Y-m') }}">
                                {{ date('Y年m月') }}
                            </option>
                            <!-- $i<12の12を変えることで表示する月数を変更することができる -->
                            <!-- strtotimeの+で設定することで当月以降1年、-で当月以前1年の表示になる -->
                            @for ($i = 1; $i < 12; $i++) {{ $target_ym = strtotime("- {$i}months"); }}
                            <option value="{{ date('Y-m', $target_ym) }}" @if ($ym==date('Y-m', $target_ym)) selected @endif>
                                {{ date('Y年m月', $target_ym) }}
                            </option>
                            @endfor
                        </select>
                        <!-- 名前表示部分 -->
                        {{ Auth::guard('employee')->user()->name }}
                        <!-- 名前表示部分ここまで -->
                    </form>
                </label>
                <!-- 月度プルダウン部分ここまで -->

            </div>
            <div class="container px-5 py-5 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    @include('menu.daily')
                </div>
            </div>
        </section>
    </body>
</x-app-layout>
