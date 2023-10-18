export function setToday() {
    const dateInput = document.querySelector('#date');
    const today = new Date();
    dateInput.value = formatDate(today);
    dateInput.form.submit();
}

export function setNextDay() {
    const dateInput = document.querySelector('#date');
    const day = new Date(dateInput.value);
    const tomorrow = new Date(day.getFullYear(), day.getMonth(), day.getDate() + 1);
    dateInput.value = formatDate(tomorrow);
    dateInput.form.submit();
}

export function setPreviousDay() {
    const dateInput = document.querySelector('#date');
    const day = new Date(dateInput.value);
    const yesterday = new Date(day.getFullYear(), day.getMonth(), day.getDate() - 1);
    dateInput.value = formatDate(yesterday);
    dateInput.form.submit();
}

export function setStartOfMonth() {
    const dateInput = document.querySelector('#start_date');
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    dateInput.value = formatDate(firstDayOfMonth);
}

export function setEndOfMonth() {
    const dateInput = document.querySelector('#end_date');
    const today = new Date();
    const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    dateInput.value = formatDate(lastDayOfMonth);
}

function formatDate(date) {
    let year = date.getFullYear();
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');

    return `${year}-${month}-${day}`;
}
