document.getElementById("end_btn").style.display = "none";

function toggle_onclick_inline() {
    const p1 = document.getElementById("end_btn");

    if (end_btn.style.display == "block") {
        // noneで非表示
        start_btn.style.display = "block";
        end_btn.style.display = "none";
    } else {
        // blockで表示
        start_btn.style.display = "none";
        end_btn.style.display = "block";
    }
}
