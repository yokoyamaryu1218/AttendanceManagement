let $pending_button = document.getElementById("pending-button");
let $done_button = document.getElementById("done-button");
let $pending_content = document.getElementById("pending-content");
let $done_content = document.getElementById("done-content");

reset_styles = function() {
  $pending_button.classList.remove("active");
  $done_button.classList.remove("active");
  $pending_content.classList.remove("active");
  $done_content.classList.remove("active");
};

$pending_button.addEventListener("click", function() {
  reset_styles();
  if (this.classList.toggle("active")) {
    $pending_content.classList.toggle("active");
  }
})
$done_button.addEventListener("click", function() {
  reset_styles();
  if (this.classList.toggle("active")) {
    $done_content.classList.toggle("active");
  }
});

  // デフォルトで未完了のみ表示
$pending_content.classList.toggle("active");
$pending_button.classList.toggle("active")