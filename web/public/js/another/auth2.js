window.addEventListener('DOMContentLoaded', function () {

    // (1)パスワード入力欄とボタンのHTMLを取得
    let btn_passview2 = document.getElementById("btn_passview2");
    let password_confirmation = document.getElementById("password_confirmation");

    // (2)ボタンのイベントリスナーを設定
    btn_passview2.addEventListener("click", (e) => {

        // (4)パスワード入力欄のtype属性を確認
        if (password_confirmation === 'password') {
            // (5)パスワードを表示する
            password_confirmation = 'text';
            btn_passview2.textContent = '非表示';
        } else {
            // (6)パスワードを非表示にする
            password_confirmation = 'password';
            btn_passview2.textContent = '表示';
        }
    });

});