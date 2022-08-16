<!-- admin側 パスワード変更画面のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <form method="POST" action="{{ route('admin.emplo_password.update', [ 'emplo_id'=> $emplo_id , 'name'=> $name ] ) }}">
        @csrf
        <!-- パスワード入力画面を出す共通のbladeへ -->
        @include('menu.password.common')
    </form>
</x-app-layout>