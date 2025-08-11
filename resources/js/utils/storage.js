/**
 * Storage Utilities
 * LocalStorage helpers with error handling
 */

export const storage = {
    /**
     * Get item from localStorage
     * @param {string} key - Storage key
     * @param {any} defaultValue - Default value if key doesn't exist
     * @returns {any}
     */
    get(key, defaultValue = null) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (error) {
            console.warn('Storage get error:', error);
            return defaultValue;
        }
    },

    /**
     * Set item in localStorage
     * @param {string} key - Storage key
     * @param {any} value - Value to store
     * @returns {boolean} Success status
     */
    set(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (error) {
            console.warn('Storage set error:', error);
            return false;
        }
    },

    /**
     * Remove item from localStorage
     * @param {string} key - Storage key
     * @returns {boolean} Success status
     */
    remove(key) {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (error) {
            console.warn('Storage remove error:', error);
            return false;
        }
    },

    /**
     * Clear all localStorage
     * @returns {boolean} Success status
     */
    clear() {
        try {
            localStorage.clear();
            return true;
        } catch (error) {
            console.warn('Storage clear error:', error);
            return false;
        }
    },

    /**
     * Check if localStorage is available
     * @returns {boolean}
     */
    isAvailable() {
        try {
            const test = '__storage_test__';
            localStorage.setItem(test, 'test');
            localStorage.removeItem(test);
            return true;
        } catch {
            return false;
        }
    }
};

export default storage;