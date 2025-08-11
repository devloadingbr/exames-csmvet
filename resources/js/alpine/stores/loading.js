/**
 * Loading States Store
 * Global loading state management
 */

export default {
    // Global loading state
    global: false,
    
    // Specific loading states for different operations
    downloads: {},
    forms: {},
    requests: {},

    /**
     * Set global loading state
     * @param {boolean} state - Loading state
     */
    setGlobal(state) {
        this.global = state;
    },

    /**
     * Set download loading state
     * @param {string|number} examId - Exam identifier
     * @param {boolean} state - Loading state
     */
    setDownload(examId, state) {
        if (state) {
            this.downloads[examId] = true;
        } else {
            delete this.downloads[examId];
        }
    },

    /**
     * Check if a specific download is loading
     * @param {string|number} examId - Exam identifier
     * @returns {boolean}
     */
    isDownloading(examId) {
        return !!this.downloads[examId];
    },

    /**
     * Set form loading state
     * @param {string} formId - Form identifier
     * @param {boolean} state - Loading state
     */
    setForm(formId, state) {
        if (state) {
            this.forms[formId] = true;
        } else {
            delete this.forms[formId];
        }
    },

    /**
     * Check if a specific form is loading
     * @param {string} formId - Form identifier
     * @returns {boolean}
     */
    isFormLoading(formId) {
        return !!this.forms[formId];
    },

    /**
     * Set request loading state
     * @param {string} requestId - Request identifier
     * @param {boolean} state - Loading state
     */
    setRequest(requestId, state) {
        if (state) {
            this.requests[requestId] = true;
        } else {
            delete this.requests[requestId];
        }
    },

    /**
     * Check if a specific request is loading
     * @param {string} requestId - Request identifier
     * @returns {boolean}
     */
    isRequestLoading(requestId) {
        return !!this.requests[requestId];
    },

    /**
     * Check if any loading is active
     * @returns {boolean}
     */
    get hasAnyLoading() {
        return this.global || 
               Object.keys(this.downloads).length > 0 ||
               Object.keys(this.forms).length > 0 ||
               Object.keys(this.requests).length > 0;
    },

    /**
     * Clear all loading states
     */
    clearAll() {
        this.global = false;
        this.downloads = {};
        this.forms = {};
        this.requests = {};
    }
};