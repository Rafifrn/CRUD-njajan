import './bootstrap';

// Navbar: mobile menu + user dropdown (shared by every layout)
document.addEventListener('DOMContentLoaded', () => {
    const $ = (id) => document.getElementById(id);
    const burger = $('mobile-menu-button'), mobile = $('mobile-menu');
    burger?.addEventListener('click', () => {
        const open = mobile.classList.toggle('hidden') === false;
        burger.setAttribute('aria-expanded', open);
    });
    const toggle = $('userDropdownToggle'), menu = $('userDropdownMenu');
    toggle?.addEventListener('click', () => {
        const open = menu.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', open);
    });
    window.addEventListener('click', (e) => {
        if (menu && !toggle.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
    });
});
