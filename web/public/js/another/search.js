// 社員詳細の管理者の検索機能
function search() {
  //
  var name = document.getElementById("search-list").value;

  //optionの個数を判断する
  const count = document.getElementById('search-list').list.options;

  for (i = 0; i < count.length; i++) {
    if (name == document.getElementById('search-list').list.options[i].value) {
      label = document.getElementById('search-list').list.options[i].getAttribute('label');
      mangement = document.getElementById('search-list').list.options[i].getAttribute('managment');
    }
  }

  document.getElementById("management_emplo_id").defaultValue = label;
  document.getElementById("high_name").innerText = name;

}

document.getElementById("search-list").onchange = search;


