/**
 * Client Area Filters Component
 * Handles exam filtering functionality
 */

import Alpine from 'alpinejs';

Alpine.data('clientFilters', () => ({
    // State
    filtersOpen: false,
    search: '',
    petFilter: '',
    typeFilter: '',
    dateFrom: '',
    dateTo: '',
    sortBy: 'exam_date',
    sortDirection: 'desc',

    /**
     * Initialize filters
     */
    init() {
        // Check if filters should be open by default (if any filters are active)
        const hasActiveFilters = this.hasActiveFilters();
        this.filtersOpen = hasActiveFilters;

        // Initialize from URL parameters if available
        this.initFromURL();
    },

    /**
     * Toggle filters visibility
     */
    toggleFilters() {
        this.filtersOpen = !this.filtersOpen;
    },

    /**
     * Check if any filters are active
     * @returns {boolean}
     */
    hasActiveFilters() {
        return !!(this.search || this.petFilter || this.typeFilter || 
                 this.dateFrom || this.dateTo);
    },

    /**
     * Clear all filters
     */
    clearFilters() {
        this.search = '';
        this.petFilter = '';
        this.typeFilter = '';
        this.dateFrom = '';
        this.dateTo = '';
        this.sortBy = 'exam_date';
        this.sortDirection = 'desc';
        
        // Submit the form to apply cleared filters
        this.submitFilters();
    },

    /**
     * Apply filters by submitting the form
     */
    submitFilters() {
        const form = document.getElementById('filtersForm');
        if (form) {
            form.submit();
        }
    },

    /**
     * Handle sort column click
     * @param {string} column - Column to sort by
     */
    toggleSort(column) {
        if (this.sortBy === column) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortBy = column;
            this.sortDirection = 'desc';
        }
        
        // Update hidden form fields
        this.updateSortFields();
    },

    /**
     * Update sort fields in the form
     */
    updateSortFields() {
        const form = document.getElementById('filtersForm');
        if (form) {
            const sortByField = form.querySelector('select[name="sort_by"]');
            const sortDirectionField = form.querySelector('input[name="sort_direction"]');
            
            if (sortByField) {
                sortByField.value = this.sortBy;
            }
            
            if (sortDirectionField) {
                sortDirectionField.value = this.sortDirection;
            }
        }
    },

    /**
     * Initialize filters from URL parameters
     */
    initFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        
        this.search = urlParams.get('search') || '';
        this.petFilter = urlParams.get('pet_id') || '';
        this.typeFilter = urlParams.get('exam_type_id') || '';
        this.dateFrom = urlParams.get('date_from') || '';
        this.dateTo = urlParams.get('date_to') || '';
        this.sortBy = urlParams.get('sort_by') || 'exam_date';
        this.sortDirection = urlParams.get('sort_direction') || 'desc';
    },

    /**
     * Get active filters count
     * @returns {number}
     */
    get activeFiltersCount() {
        let count = 0;
        if (this.search) {count++;}
        if (this.petFilter) {count++;}
        if (this.typeFilter) {count++;}
        if (this.dateFrom) {count++;}
        if (this.dateTo) {count++;}
        return count;
    },

    /**
     * Get sort arrow class for a column
     * @param {string} column - Column name
     * @returns {string}
     */
    getSortArrowClass(column) {
        if (this.sortBy !== column) {return '';}
        return this.sortDirection === 'asc' ? 'rotate-180' : '';
    }
}));