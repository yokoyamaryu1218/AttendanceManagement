<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        @foreach($employee_lists as $emplo)</BR>
        {{$emplo->emplo_id}}</BR>
        {{$emplo->name}}</BR>
        {{$emplo->subord_authority}}</BR>
        {{$emplo->restraint_start_time}}</BR>
        {{$emplo->restraint_closing_time}}</BR>
        {{$emplo->restraint_total_time}}</BR>
        @endforeach

        <div class="row">
            <div class="col-4">
                <p>管理者番号：<input type="text" id="management_number" name="management_number" maxlength="10" value="{{$emplo->management_emplo_id}}" style="width:100px;" data-toggle="tooltip" title="作業場所情報を修正、抹消できる管理者を変更する場合、ここを修正します。管理者自身とシステム管理者だけが修正できます" readonly></p>
            </div>
            <div class="col-3" style="padding:0px">
                <p>管理者名：{{$emplo->high_name}}</a></p>
            </div>
            <div class="col" style="padding:0px">
                <p>管理者検索：
                    <input type="search" id="search-list" list="keywords" style="width:150px;" autocomplete="on" maxlength="32" placeholder="管理者名を選択" data-toggle="tooltip" title="入力に該当した人員の候補を一覧に表示します。表示された人員を選択した場合、その番号が管理者人員番号に表示されます。">
                    <datalist id="keywords">
                        @foreach($subord_authority_lists as $subord_authority_list)
                        <option value="{{$subord_authority_list->name}}" label="{{$subord_authority_list->emplo_id}}"></option>
                        @endforeach
                    </datalist>
                </p>
            </div>
        </div>
    </body>
</x-app-layout>