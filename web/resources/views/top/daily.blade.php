<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto ">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
                <form method="POST" action="@if($daily_data == NULL){{ route('employee.daily.store')}}@else{{ route('employee.daily.update')}}@endif" name="daily_change">
                    @csrf
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="daily" class="leading-7 text-sm text-gray-600">日報</label>
                            <!-- フラッシュメッセージの表示 -->
                            @if (session('status'))
                            <div class="alert alert-info">
                                {{ session('status') }}
                            </div>
                            @endif
                            <!-- フラッシュメッセージここまで -->
                            <!-- 日報表示部分 -->
                            <textarea id="daily" name="daily" cols="40" rows="10" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="日報の入力は任意です">@if($daily_data == NULL)@else{{ $daily_data[0]->daily }}@endif</textarea>
                            <!-- 日報表示ここまで -->
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <!-- 登録ボタン -->
                        <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                        <!-- 登録ボタンここまで -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>