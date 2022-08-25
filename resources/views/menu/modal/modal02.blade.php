<!-- admin側 出退勤変更モーダルのblade -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputexamplesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content flex justify-between">
            <!-- タイトル部分と×ボタンの表示 -->
            <div class="modal-header">
                <h5><label class="modal-title" for="modal-title"></label> 勤怠修正画面</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- タイトル部分と×ボタンの表示ここまで -->

            <!-- 勤怠修正を行うモーダルの詳細部分のbladeへ -->
            <form method="POST" action="{{ route('admin.monthly.update') }}" name="monthly.update">
                @csrf
                @include('menu.modal.modal04')
            </form>
            <!-- 詳細部分ここまで -->
            
        </div>
    </div>
</div>
