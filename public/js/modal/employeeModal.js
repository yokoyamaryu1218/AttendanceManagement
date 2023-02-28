//従業員側モーダルJS
var exampleModal = document.getElementById("exampleModal");
exampleModal.addEventListener("show.bs.modal", function (event) {
    /* 編集ボタンが押された対象日の表データを取得 */
    var button = event.relatedTarget;
    var day = button.getAttribute("data-bs-day");
    var month = button.getAttribute("data-bs-month");
    var daily = button.getAttribute("data-bs-daily");
    var updated = button.getAttribute("data-bs-updated");
    var modifier = button.getAttribute("data-bs-modifier");

    /* 取得したデータをモーダルの各欄に設定 */
    $("#modal_daily").val(daily);

    // 日付をタイトルとして表示
    var modalTitle = exampleModal.querySelector(".modal-title");
    modalTitle.textContent = `${month}/${day}`;

    // 最終更新日時と最終変更者を表示
    var modalUpdated = document.getElementById('modal_updated');
    var modalModifier = document.getElementById('modal_modifier');
    modalUpdated.textContent = updated;
    modalModifier.textContent = modifier;
});
