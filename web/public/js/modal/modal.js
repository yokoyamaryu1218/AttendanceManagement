//従業員側モーダルJS
var exampleModal = document.getElementById("exampleModal");
exampleModal.addEventListener("show.bs.modal", function (event) {
    /* 編集ボタンが押された対象日の表データを取得 */
    var button = event.relatedTarget;
    var day = button.getAttribute("data-bs-day");
    var month = button.getAttribute("data-bs-month");
    var daily = button.getAttribute("data-bs-daily");

    /* 取得したデータをモーダルの各欄に設定 */
    $("#modal_daily").val(daily);

    // 日付をタイトルとして表示
    var modalTitle = exampleModal.querySelector(".modal-title");
    modalTitle.textContent = `${month}/${day}`;
});
