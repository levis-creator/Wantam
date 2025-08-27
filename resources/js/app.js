
import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Register Alpine plugins
Alpine.plugin(persist);

// Dark mode functionality
Alpine.data('darkMode', () => ({
    darkMode: Alpine.$persist(false),
    
    init() {
        // Check system preference if no saved preference
        if (this.darkMode === null) {
            this.darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        
        this.updateTheme();
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (this.darkMode === null) {
                this.darkMode = e.matches;
                this.updateTheme();
            }
        });
    },
    
    toggle() {
        this.darkMode = !this.darkMode;
        this.updateTheme();
    },
    
    updateTheme() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}));

window.Alpine = Alpine;
Alpine.start();
