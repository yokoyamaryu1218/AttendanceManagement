// 上司側モーダル
// https://bootstrap-guide.com/components/modal
var inputModal = document.getElementById("inputModal");
inputModal.addEventListener("show.bs.modal", function (event) {
    /* 編集ボタンが押された対象日の表データを取得 */
    var button = event.relatedTarget;
    var name = button.getAttribute("data-bs-name");
    var day = button.getAttribute("data-bs-day");
    var emplo_id = button.getAttribute("data-bs-id");
    var start = button.getAttribute("data-bs-start");
    var closing = button.getAttribute("data-bs-closing");
    var daily = button.getAttribute("data-bs-daily");
    var updated = button.getAttribute("data-bs-updated");
    var modifier = button.getAttribute("data-bs-modifier");
    /* タイトル部分に日付を表示するため取得 */
    var month = button.getAttribute("data-bs-month");

    /* 取得したデータをモーダルの各欄に設定 */
    $("#modal_start_time").val(start);
    $("#modal_closing_time").val(closing);
    $("#modal_daily").val(daily);
    $("#modal_day").val(day);
    $("#modal_name").val(name);
    $("#modal_id").val(emplo_id);

    // 日付をタイトルとして表示
    var modalTitle = inputModal.querySelector('.modal-title')
    modalTitle.textContent = `${month}`

    // 最終更新日時と最終変更者を表示
    var modalUpdated = document.getElementById('modal_updated');
    var modalModifier = document.getElementById('modal_modifier');
    modalUpdated.textContent = updated;
    modalModifier.textContent = modifier;
});
