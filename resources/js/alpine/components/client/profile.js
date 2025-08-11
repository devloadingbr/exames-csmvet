/**
 * Client Area Profile Components
 * Profile management, notifications settings, statistics
 */

import Alpine from 'alpinejs';

// Profile Handler - Main Component
Alpine.data('clientProfile', () => ({
    // Main profile state - can be extended
}));

// Notification Settings Component
Alpine.data('clientNotificationSettings', (initialSettings = {}) => ({
    emailNotifications: initialSettings.email || false,
    smsNotifications: initialSettings.sms || false,
    updating: false,
    
    /**
     * Update notification preferences
     * @param {string} type - Type of notification (email, sms)
     * @param {boolean} value - New value
     */
    async updateNotification(type, value) {
        this.updating = true;
        
        try {
            const response = await fetch('/client/api/profile/notifications', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    receive_email_notifications: this.emailNotifications,
                    receive_sms_notifications: this.smsNotifications
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                Alpine.store('toast').success('Preferências atualizadas com sucesso!');
            } else {
                throw new Error('Erro na resposta do servidor');
            }
        } catch (error) {
            console.error('Notification update error:', error);
            Alpine.store('toast').error('Erro ao atualizar preferências');
            
            // Revert the change on error
            if (type === 'email') {
                this.emailNotifications = !value;
            } else {
                this.smsNotifications = !value;
            }
        } finally {
            this.updating = false;
        }
    }
}));

// Animated Statistics Component
Alpine.data('clientAnimatedStats', (initialStats = {}) => ({
    counters: {},
    
    init() {
        // Initialize counters
        Object.keys(initialStats).forEach(key => {
            this.counters[key] = 0;
        });
        
        // Start animations after a short delay
        setTimeout(() => {
            this.animateCounters(initialStats);
        }, 300);
    },
    
    /**
     * Animate counters with smooth transitions
     * @param {Object} targets - Target values for counters
     */
    animateCounters(targets) {
        Object.entries(targets).forEach(([key, target], index) => {
            if (target === 0) {return;}
            
            const duration = 1500;
            const increment = target / (duration / 50);
            
            setTimeout(() => {
                const timer = setInterval(() => {
                    this.counters[key] += increment;
                    
                    if (this.counters[key] >= target) {
                        this.counters[key] = target;
                        clearInterval(timer);
                    }
                }, 50);
            }, index * 100); // Stagger animation start times
        });
    }
}));

// Chart Animation Component
Alpine.data('clientChartAnimation', () => ({
    bars: [],
    
    init() {
        // Initialize bars array
        this.bars = new Array(document.querySelectorAll('[data-percentage]').length).fill(0);
    },
    
    /**
     * Animate chart bars with staggered timing
     */
    animateCharts() {
        document.querySelectorAll('[data-percentage]').forEach((bar, index) => {
            const percentage = parseFloat(bar.dataset.percentage);
            
            setTimeout(() => {
                this.bars[index] = percentage;
            }, index * 200);
        });
    }
}));