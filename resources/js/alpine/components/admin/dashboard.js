/**
 * Admin Dashboard Components
 * Dashboard-specific Alpine.js components
 */

import Alpine from 'alpinejs';

Alpine.data('adminDashboard', () => ({
    // Admin dashboard specific functionality
    refreshing: false,
    
    /**
     * Refresh dashboard data
     */
    async refreshData() {
        this.refreshing = true;
        Alpine.store('loading').setGlobal(true);
        
        try {
            // Simulate data refresh
            await new Promise(resolve => setTimeout(resolve, 1000));
            Alpine.store('toast').success('Dashboard atualizado com sucesso!');
            
            // Refresh page or update data
            window.location.reload();
        } catch (error) {
            console.error('Dashboard refresh error:', error);
            Alpine.store('toast').error('Erro ao atualizar dashboard');
        } finally {
            this.refreshing = false;
            Alpine.store('loading').setGlobal(false);
        }
    }
}));