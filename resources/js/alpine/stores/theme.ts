/**
 * Theme Management Store
 * Global dark/light theme management
 */

import type { ThemeStore } from '../../types/alpine';

const themeStore: ThemeStore = {
    // State
    darkMode: localStorage.getItem('darkMode') === 'true' || 
              (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    /**
     * Toggle dark mode
     */
    toggle(): void {
        this.darkMode = !this.darkMode;
        this.apply();
        this.save();
    },

    /**
     * Set specific theme
     * @param {boolean} isDark - Whether to enable dark mode
     */
    set(isDark: boolean): void {
        this.darkMode = isDark;
        this.apply();
        this.save();
    },

    /**
     * Apply theme to document
     */
    apply(): void {
        document.documentElement.classList.toggle('dark', this.darkMode);
    },

    /**
     * Save theme preference to localStorage
     */
    save(): void {
        localStorage.setItem('darkMode', this.darkMode);
    },

    /**
     * Initialize theme system
     */
    init(): void {
        this.apply();
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            // Only auto-switch if no explicit preference is saved
            if (localStorage.getItem('darkMode') === null) {
                this.darkMode = e.matches;
                this.apply();
            }
        });
    },

    /**
     * Check if dark mode is enabled
     */
    get isDark(): boolean {
        return this.darkMode;
    },

    /**
     * Check if light mode is enabled
     */
    get isLight(): boolean {
        return !this.darkMode;
    }
};

export default themeStore;