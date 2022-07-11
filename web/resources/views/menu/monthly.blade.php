<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="pt-20 pl-24">
                <label>
                    <select>
                        <option selected> 月度 </option>
                        <option>6月度</option>
                        <option>7月度</option>
                    </select>
                </label>
                　横山　隆さん
            </div>
            <div class="container px-5 py-5 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tl rounded-bl">日</th>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">出勤</th>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">退勤</th>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">休憩</th>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">実績</th>
                                <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">業務内容</th>
                                <th class="w-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthly_data as $monthly)
                            <tr>
                                <td class="px-1 py-1">{{$monthly->date}}</td>
                                <td class="px-1 py-1">{{$monthly->start_time}}</td>
                                <td class="px-1 py-1">{{$monthly->end_time}}</td>
                                <td class="px-1 py-1">{{$monthly->lest_time}}</td>
                                <td class="px-1 py-1">{{$monthly->achievement_time}}</td>
                                <td class="px-1 py-1">{{$monthly->daily}}</td>
                                <td class="w-1 text-center">
                                    <a href="#">✏</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>