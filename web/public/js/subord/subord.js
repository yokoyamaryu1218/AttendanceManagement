//URLから指定したGETパラメータを削除する
//参照：https://gray-code.com/javascript/delete-get-parameter-from-url/

// URLを取得
var url = new URL(window.location.href);

// URLSearchParamsオブジェクトを取得
var params = url.searchParams;

params.delete('username');
params.delete('mode');

console.log(params.get('subord_id')); // null
console.log(params.get('subord_name')); // null

// アドレスバーのURLからGETパラメータを削除
history.replaceState('', '', url.pathname);