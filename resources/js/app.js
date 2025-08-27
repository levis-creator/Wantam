import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Register the persist plugin before starting Alpine
Alpine.plugin(persist);

// Make Alpine available globally
window.Alpine = Alpine;

// Start Alpine only once
if (!window.Alpine.version) {
    Alpine.start();
}