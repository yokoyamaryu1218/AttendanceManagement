// 上司側モーダル
// https://bootstrap-guide.com/components/modal
var inputModal = document.getElementById("inputModal");
inputModal.addEventListener("show.bs.modal", function (event) {
    /* 編集ボタンが押された対象日の表データを取得 */
    var button = event.relatedTarget;
    var day = button.getAttribute("data-bs-day");
    var month = button.getAttribute("data-bs-month");
    var start = button.getAttribute("data-bs-start");
    var closing = button.getAttribute("data-bs-closing");
    var daily = button.getAttribute("data-bs-daily");

    /* 取得したデータをモーダルの各欄に設定 */
    $("#modal_start_time").val(start);
    $("#modal_closing_time").val(closing);
    $("#modal_daily").val(daily);

    // 日付をタイトルとして表示
    var modalTitle = inputModal.querySelector('.modal-title')
    modalTitle.textContent = `${month}/${day}`

});
