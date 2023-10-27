/**
 * 日付選択欄に今日の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setToday(selector) {
    const dateInput = document.querySelector(selector);
    const today = new Date();
    dateInput.value = formatDate(today);
}

/**
 * 日付選択欄に入力されている日付の次の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setNextDay(selector) {
    const dateInput = document.querySelector(selector);
    const day = new Date(dateInput.value);
    const tomorrow = new Date(day.getFullYear(), day.getMonth(), day.getDate() + 1);
    dateInput.value = formatDate(tomorrow);
}

/**
 * 日付選択欄に入力されている日付の前の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setPreviousDay(selector) {
    const dateInput = document.querySelector(selector);
    const day = new Date(dateInput.value);
    const yesterday = new Date(day.getFullYear(), day.getMonth(), day.getDate() - 1);
    dateInput.value = formatDate(yesterday);
}

/**
 * 日付選択欄に今月の最初の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setStartOfThisMonth(selector) {
    const dateInput = document.querySelector(selector);
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    dateInput.value = formatDate(firstDayOfMonth);
}

/**
 * 日付選択欄に今月末日の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setEndOfThisMonth(selector) {
    const dateInput = document.querySelector(selector);
    const today = new Date();
    const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    dateInput.value = formatDate(lastDayOfMonth);
}

/**
 * 日付選択欄に先月の最初の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setStartOfLastMonth(selector) {
    const dateInput = document.querySelector(selector);
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
    dateInput.value = formatDate(firstDayOfMonth);
}

/**
 * 日付選択欄に先月末日の日付を入れる
 * @param {string} selector - 入力対象のinput要素のID
 */
export function setEndOfLastMonth(selector) {
    const dateInput = document.querySelector(selector);
    const today = new Date();
    const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 0);
    dateInput.value = formatDate(lastDayOfMonth);
}

/**
 * 日付のフォーマットを整える
 * @param {Date} date - 対象のDateオブジェクト
 * @return {string} - YYYY-MM-DD形式の日付
 */
function formatDate(date) {
    let year = date.getFullYear();
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');

    return `${year}-${month}-${day}`;
}
