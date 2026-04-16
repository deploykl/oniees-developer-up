import './bootstrap';

// No importes Alpine ni llames a Alpine.start()
// Livewire lo gestiona por ti.

import focus from '@alpinejs/focus';

document.addEventListener('livewire:init', () => {
    window.Alpine.plugin(focus);
});