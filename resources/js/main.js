// import './bootstrap';
import showClock from './currentTimer.js';
import { setNextDay, setPreviousDay, setStartOfMonth, setEndOfMonth, } from './calendarButton.js';

document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector('#realTimer')) {
        setInterval(showClock, 1000);
    }
});

window.setNextDay = setNextDay;
window.setPreviousDay = setPreviousDay;
window.setStartOfMonth = setStartOfMonth;
window.setEndOfMonth = setEndOfMonth;