import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import persist from '@alpinejs/persist'

// Add the persist plugin
Alpine.plugin(persist)

// Make Alpine available globally to avoid multiple instances
window.Alpine = Alpine

Livewire.start();