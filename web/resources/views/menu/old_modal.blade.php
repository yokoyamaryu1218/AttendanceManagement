<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white-100">
        @if(auth('admin')->user())
        @include('layouts.admin-navigation')
        @elseif(auth('employee')->user())
        @include('layouts.employee-navigation')
        @elseif(auth('users')->user())
        @include('layouts.user-navigation')
        @endif

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-2 px-1 sm:px-2 lg:px-3">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>

<!-- 参照先：https://tailwindcomponents.com/component/modal -->
<div id="inputModal" aria-labelledby="inputModalLabel" class="main-modal fixed w-full h-300 inset-0 z-150 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
    <div class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <!-- Modal content -->
            <div class="relative">
                <!-- ここは×ボタン部分 -->
                <div class="flex justify-between">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{ date('n', strtotime($ym)) }}/<span id="modal_day">{{ $format->time_format_dw(date('Y-m-d')) }}</span>
                    </label>
                    <button type="button" class="modal-close bg-transparent ml-auto">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- ×ボタンここまで -->
                <!--ここから出勤退勤表示部分-->
                <div class="my-5">
                    <div class="flex mb-5">
                        <div class="flex-grow w-24 pr-5">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・出勤時間</label>
                            <input type="text" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="出勤時間">
                        </div>
                        <div class="flex-grow w-24">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・退勤時間</label>
                            <input type="text" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="退勤時間">
                        </div>
                    </div>
                    <!-- 出勤退勤部分ここまで -->
                    <!-- ここに日報が入る -->
                    <!-- textareaの枠はh-〇で調節ができる -->
                    <div class="relative">
                        <textarea id="message" name="message" cols="40" rows="10" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ここに日報が入る"></textarea>
                    </div>

                    <!-- 日報部分ここまで -->
                </div>
                <!--Footer-->
                <!-- ここからボタン表示 -->
                <div class="flex justify-center">
                    <button class="focus:outline-none flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">更新</button>
                    <button class="focus:outline-none flex mx-auto modal-close text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">閉じる</button>
                </div>
                <!-- ボタン表示ここまで -->
            </div>
        </div>
    </div>

    <!-- 参照：https://getbootstrap.jp/docs/5.0/components/modal/ -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex mb-3">
                    <div class="modal-start_time flex-grow w-24 pr-5">
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・出勤時間</label>
                        <input type="text" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="出勤時間">
                    </div>
                    <div class="modal-end_time flex-grow w-24">
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・退勤時間</label>
                        <input type="text" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="退勤時間">
                    </div>
                </div>
                <textarea cols="40" rows="10" class="modal-daily w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ここに日報が入る"></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
