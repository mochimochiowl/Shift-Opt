// jsファイルのとりまとめ
import showClock from './currentTimer.js';
import {
    setToday,
    setNextDay,
    setPreviousDay,
    setStartOfThisMonth,
    setEndOfThisMonth,
    setStartOfLastMonth,
    setEndOfLastMonth,
} from './calendarButton.js';
import { movePreviousPage, } from './sceneMoveAssist.js';
import { toggleMenu, } from './toggler.js';

document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector('#realTimer')) {
        setInterval(showClock, 1000);
    }
});

window.setToday = setToday;
window.setNextDay = setNextDay;
window.setPreviousDay = setPreviousDay;
window.setStartOfThisMonth = setStartOfThisMonth;
window.setEndOfThisMonth = setEndOfThisMonth;
window.setStartOfLastMonth = setStartOfLastMonth;
window.setEndOfLastMonth = setEndOfLastMonth;

window.movePreviousPage = movePreviousPage;

window.toggleMenu = toggleMenu;