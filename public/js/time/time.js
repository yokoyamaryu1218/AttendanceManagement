// 参照：https://www.nishishi.com/javascript-tips/realtime-clock-setinterval.html
function set2fig(num) {
    // 桁数が1桁だったら先頭に0を加えて2桁に調整する
    var ret;
    if( num < 10 ) { ret = "0" + num; }
    else { ret = num; }
    return ret;
 }
 function showClock2() {
    var nowTime = new Date();
    var nowHour = set2fig( nowTime.getHours() );
    var nowMin  = set2fig( nowTime.getMinutes() );
    var nowSec  = set2fig( nowTime.getSeconds() );
    var msg = nowHour + "時" + nowMin + "分" + nowSec + "秒";
    document.getElementById("RealtimeClockArea2").innerHTML = msg;
 }
 setInterval('showClock2()',1000);