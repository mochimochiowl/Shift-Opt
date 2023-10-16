// import './bootstrap';
import showClock from './currentTimer.js';
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector('#realTimer')) {
        setInterval(showClock, 1000);
    }
});