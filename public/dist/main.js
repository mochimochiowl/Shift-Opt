function u(){let t=new Date,e=String(t.getHours()).padStart(2,"0"),n=String(t.getMinutes()).padStart(2,"0"),a=String(t.getSeconds()).padStart(2,"0"),r=e+":"+n+":"+a;document.querySelector("#realTimer").innerHTML=r}function l(){const t=document.querySelector("#date"),e=new Date(t.value),n=new Date(e.getFullYear(),e.getMonth(),e.getDate()+1);t.value=o(n),t.form.submit()}function s(){const t=document.querySelector("#date"),e=new Date(t.value),n=new Date(e.getFullYear(),e.getMonth(),e.getDate()-1);t.value=o(n),t.form.submit()}function c(){const t=document.querySelector("#start_date"),e=new Date,n=new Date(e.getFullYear(),e.getMonth(),1);t.value=o(n)}function d(){const t=document.querySelector("#end_date"),e=new Date,n=new Date(e.getFullYear(),e.getMonth()+1,0);t.value=o(n)}function o(t){let e=t.getFullYear(),n=(1+t.getMonth()).toString().padStart(2,"0"),a=t.getDate().toString().padStart(2,"0");return`${e}-${n}-${a}`}function i(){window.history.back()}function g(){document.querySelector("#openBtn").classList.toggle("hidden"),document.querySelector("#closeBtn").classList.toggle("hidden"),document.querySelector("#menu").classList.toggle("translate-x-full")}document.addEventListener("DOMContentLoaded",function(){document.querySelector("#realTimer")&&setInterval(u,1e3)});window.setNextDay=l;window.setPreviousDay=s;window.setStartOfMonth=c;window.setEndOfMonth=d;window.movePreviousPage=i;window.toggleMenu=g;