/**
 * ハンバーガメニューを開閉する
 */
export function toggleMenu() {
    document.querySelector('#openBtn').classList.toggle('hidden');
    document.querySelector('#closeBtn').classList.toggle('hidden');
    document.querySelector('#menu').classList.toggle('translate-x-full');
}