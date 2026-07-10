import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Reusable nav component (transparent-over-hero)
Alpine.data('navComponent', () => ({
    scrolled: false,
    mobileOpen: false,
    init() {
        this.scrolled = window.scrollY > 40;
    },
}));

Alpine.start();
