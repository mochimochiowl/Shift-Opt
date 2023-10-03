export default function showClock() {
    let nowTime = new Date();
    let nowHour = nowTime.getHours();
    let nowMin = nowTime.getMinutes();
    let nowSec = nowTime.getSeconds();
    let msg = "現在時刻：" + nowHour + ":" + nowMin + ":" + nowSec;
    document.querySelector('#realTimer').innerHTML = msg;
}
alert('JSファイル 読み込みｷﾀ━━━━(ﾟ∀ﾟ)━━━━!!');