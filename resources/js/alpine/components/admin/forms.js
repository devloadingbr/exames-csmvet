/**
 * Admin Forms Components
 * Form handling and validation
 */

import Alpine from 'alpinejs';

Alpine.data('adminForm', (formId) => ({
    submitting: false,
    
    /**
     * Handle form submission
     */
    async submit() {
        const form = document.getElementById(formId);
        if (!form) {return;}
        
        this.submitting = true;
        Alpine.store('loading').setForm(formId, true);
        
        try {
            // Let the form submit naturally
            form.submit();
        } catch (error) {
            console.error('Form submission error:', error);
            Alpine.store('toast').error('Erro ao enviar formulário');
            this.submitting = false;
            Alpine.store('loading').setForm(formId, false);
        }
    },
    
    /**
     * Check if form is submitting
     */
    get isSubmitting() {
        return this.submitting || Alpine.store('loading').isFormLoading(formId);
    }
}));