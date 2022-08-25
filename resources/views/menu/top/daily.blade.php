<!-- employee側 日報のblade -->
<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto ">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
                <!-- 当日の日報のデータが未登録の場合は新規登録し、すでにデータがある場合は更新処理を行う -->
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

                            @if ($errors->has('daily'))
                            <div class="alert text-center alert-warning">
                                {{ $errors->first('daily') }}
                            </div>
                            @endif
                            <!-- フラッシュメッセージここまで -->
                            <!-- 日報表示部分 -->
                            <textarea id="daily" name="daily" cols="40" rows="10" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" title="日報を入力できます。（1,024文字まで）" placeholder="日報の入力は任意です">@if($daily_data == NULL)@else{{ $daily_data[0]->daily }}@endif</textarea>
                            <!-- 日報表示ここまで -->
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <!-- 日報の新規登録の場合は「登録ボタン」を出し、更新の場合は「更新」ボタンを出す -->
                        @if(!(isset($daily_data[0])))
                        <!-- 登録ボタン -->
                        <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、登録されます。">登録</button>
                        <!-- 登録ボタンここまで -->
                        @else
                        @if($daily_data[0]->daily == NULL)
                        <!-- 登録ボタン -->
                        <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、登録されます。">登録</button>
                        <!-- 登録ボタンここまで -->
                        @else
                        <!-- 更新ボタン -->
                        <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、更新されます。">更新</button>
                        <!-- 更新ボタンここまで -->
                        @endif
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
