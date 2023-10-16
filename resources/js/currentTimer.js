export default function showClock() {
    let nowTime = new Date();
    let nowHour = String(nowTime.getHours()).padStart(2, '0');
    let nowMin = String(nowTime.getMinutes()).padStart(2, '0');
    let nowSec = String(nowTime.getSeconds()).padStart(2, '0');
    let msg = nowHour + ":" + nowMin + ":" + nowSec;
    document.querySelector('#realTimer').innerHTML = msg;
}
if (document.querySelector('#realTimer')) {
    setInterval(showClock, 1000);
}