function r(){let e=new Date,o=String(e.getHours()).padStart(2,"0"),t=String(e.getMinutes()).padStart(2,"0"),n=String(e.getSeconds()).padStart(2,"0"),c=o+":"+t+":"+n;document.querySelector("#realTimer").innerHTML=c}function a(e){const o=document.querySelector(e),t=new Date;o.value=u(t)}function s(e){const o=document.querySelector(e),t=new Date(o.value),n=new Date(t.getFullYear(),t.getMonth(),t.getDate()+1);o.value=u(n)}function l(e){const o=document.querySelector(e),t=new Date(o.value),n=new Date(t.getFullYear(),t.getMonth(),t.getDate()-1);o.value=u(n)}function d(e){const o=document.querySelector(e),t=new Date,n=new Date(t.getFullYear(),t.getMonth(),1);o.value=u(n)}function i(e){const o=document.querySelector(e),t=new Date,n=new Date(t.getFullYear(),t.getMonth()+1,0);o.value=u(n)}function h(e){const o=document.querySelector(e),t=new Date,n=new Date(t.getFullYear(),t.getMonth()-1,1);o.value=u(n)}function y(e){const o=document.querySelector(e),t=new Date,n=new Date(t.getFullYear(),t.getMonth(),0);o.value=u(n)}function u(e){let o=e.getFullYear(),t=(1+e.getMonth()).toString().padStart(2,"0"),n=e.getDate().toString().padStart(2,"0");return`${o}-${t}-${n}`}function g(){window.history.back()}function S(){document.querySelector("#openBtn").classList.toggle("hidden"),document.querySelector("#closeBtn").classList.toggle("hidden"),document.querySelector("#menu").classList.toggle("translate-x-full")}document.addEventListener("DOMContentLoaded",function(){if(document.querySelector("#realTimer")&&setInterval(r,1e3),document.querySelector("#explain_section")){let e=[];e.push(document.querySelector("#summary")),e.push(document.querySelector("#function")),e.push(document.querySelector("#function-1")),e.push(document.querySelector("#function-2")),e.push(document.querySelector("#function-3")),e.push(document.querySelector("#function-4")),e.push(document.querySelector("#purpose")),e.push(document.querySelector("#tech-1")),e.push(document.querySelector("#tech-2")),e.push(document.querySelector("#tech-3")),e.push(document.querySelector("#tech-4")),e.push(document.querySelector("#tech-5")),e.push(document.querySelector("#duration")),console.log(document.querySelector("#guide")),console.log(e.length);const o=new IntersectionObserver(function(t){t.forEach(n=>{n.isIntersecting&&(n.target.classList.remove("opacity-0"),n.target.classList.add("opacity-100"))})},{threshold:.4});e.forEach(t=>{o.observe(t)})}});window.setToday=a;window.setNextDay=s;window.setPreviousDay=l;window.setStartOfThisMonth=d;window.setEndOfThisMonth=i;window.setStartOfLastMonth=h;window.setEndOfLastMonth=y;window.movePreviousPage=g;window.toggleMenu=S;
