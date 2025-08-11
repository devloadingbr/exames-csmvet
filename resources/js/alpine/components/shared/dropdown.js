/**
 * Shared Dropdown Component
 * Reusable dropdown functionality
 */

import Alpine from 'alpinejs';

Alpine.data('sharedDropdown', () => ({
    open: false,
    
    /**
     * Toggle dropdown
     */
    toggle() {
        this.open = !this.open;
    },
    
    /**
     * Close dropdown
     */
    close() {
        this.open = false;
    },
    
    /**
     * Handle click outside
     */
    handleClickAway() {
        this.close();
    }
}));