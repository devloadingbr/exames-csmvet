/**
 * Client Area Downloads Component
 * Handles exam download functionality
 */

import Alpine from 'alpinejs';

Alpine.data('clientDownloads', () => ({
    /**
     * Download an exam
     * @param {string} examCode - Exam code/identifier
     * @param {string} downloadUrl - Optional custom download URL
     */
    async downloadExam(examCode, downloadUrl = null) {
        // Set loading state
        Alpine.store('loading').setDownload(examCode, true);
        
        try {
            // Create download link
            const link = document.createElement('a');
            link.href = downloadUrl || `/client/exams/${examCode}/download`;
            link.target = '_blank';
            link.style.display = 'none';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Show success notification
            Alpine.store('toast').success('Download iniciado com sucesso!');
            
        } catch (error) {
            console.error('Download error:', error);
            Alpine.store('toast').error('Erro ao iniciar download do exame');
        } finally {
            // Clear loading state after delay
            setTimeout(() => {
                Alpine.store('loading').setDownload(examCode, false);
            }, 2000);
        }
    },

    /**
     * View exam details
     * @param {string} examCode - Exam code/identifier
     */
    viewExam(examCode) {
        window.location.href = `/client/exams/${examCode}`;
    },

    /**
     * Check if exam is downloading
     * @param {string} examCode - Exam code/identifier
     * @returns {boolean}
     */
    isDownloading(examCode) {
        return Alpine.store('loading').isDownloading(examCode);
    }
}));