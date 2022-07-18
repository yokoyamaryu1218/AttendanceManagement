document.getElementById("leaving").style.display = "none";

function toggle_onclick_inline() {
    const p1 = document.getElementById("leaving");

    if (leaving.style.display == "block") {
        // noneで非表示
        attend.style.display = "block";
        leaving.style.display = "none";
    } else {
        // blockで表示
        attend.style.display = "none";
        leaving.style.display = "block";
    }
}
