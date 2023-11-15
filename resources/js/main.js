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

    if (document.querySelector('#explain_section')) {
        let div_array = [];
        // div_array.push(document.querySelector('#top_image'));
        div_array.push(document.querySelector('#summary'));
        div_array.push(document.querySelector('#function'));
        div_array.push(document.querySelector('#function-1'));
        div_array.push(document.querySelector('#function-2'));
        div_array.push(document.querySelector('#function-3'));
        div_array.push(document.querySelector('#function-4'));
        div_array.push(document.querySelector('#function-5'));
        div_array.push(document.querySelector('#purpose'));
        div_array.push(document.querySelector('#tech-1'));
        div_array.push(document.querySelector('#tech-2'));
        div_array.push(document.querySelector('#tech-3'));
        div_array.push(document.querySelector('#tech-4'));
        div_array.push(document.querySelector('#tech-5'));
        div_array.push(document.querySelector('#duration'));
        div_array.push(document.querySelector('#menu-below'));

        console.log(document.querySelector('#guide'));
        console.log(div_array.length);

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0');
                    entry.target.classList.add('opacity-100');
                }
            });
        }, { threshold: 0.4 });

        div_array.forEach(div => {
            observer.observe(div);
        });
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