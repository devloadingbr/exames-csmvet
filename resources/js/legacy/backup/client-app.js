/**
 * Client Area Alpine.js Components & Stores
 * Centralized JavaScript for VetExams Client Area
 */

document.addEventListener('alpine:init', () => {
    
    // ===== GLOBAL STORES =====
    
    // Client Theme Management Store
    Alpine.store('clientTheme', {
        darkMode: localStorage.getItem('clientDarkMode') === 'true',
        
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('clientDarkMode', this.darkMode);
            document.documentElement.classList.toggle('dark', this.darkMode);
        },
        
        init() {
            document.documentElement.classList.toggle('dark', this.darkMode);
        }
    });
    
    // Centralized Toast Notification Store
    Alpine.store('toast', {
        show: false,
        message: '',
        type: 'success',
        
        showToast(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
            
            setTimeout(() => {
                this.show = false;
            }, 4000);
        },
        
        hide() {
            this.show = false;
        }
    });
    
    // Client Data Management Store
    Alpine.store('clientData', {
        user: null,
        stats: {},
        preferences: {},
        
        updateUser(userData) {
            this.user = userData;
        },
        
        updateStats(statsData) {
            this.stats = { ...this.stats, ...statsData };
        },
        
        updatePreferences(prefs) {
            this.preferences = { ...this.preferences, ...prefs };
        }
    });
    
    // Global Loading States Store
    Alpine.store('loading', {
        global: false,
        downloads: {},
        forms: {},
        
        setGlobal(state) {
            this.global = state;
        },
        
        setDownload(examId, state) {
            this.downloads[examId] = state;
        },
        
        setForm(formId, state) {
            this.forms[formId] = state;
        }
    });
    
    // ===== REUSABLE COMPONENTS =====
    
    // Centralized Download Handler
    Alpine.data('downloadHandler', () => ({
        downloading: false,
        progress: 0,
        
        async downloadExam(examCode, downloadUrl = null) {
            this.downloading = true;
            this.progress = 0;
            
            try {
                // Simulate progress for UX
                const progressInterval = setInterval(() => {
                    if (this.progress < 90) {
                        this.progress += 15;
                    }
                }, 200);
                
                // Create download link
                const link = document.createElement('a');
                link.href = downloadUrl || `/client/exams/${examCode}/download`;
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                
                // Complete progress
                setTimeout(() => {
                    clearInterval(progressInterval);
                    this.progress = 100;
                    
                    Alpine.store('toast').showToast('Download iniciado com sucesso!', 'success');
                    
                    // Reset state
                    setTimeout(() => {
                        this.downloading = false;
                        this.progress = 0;
                        document.body.removeChild(link);
                    }, 1000);
                }, 1500);
                
            } catch (error) {
                console.error('Download error:', error);
                Alpine.store('toast').showToast('Erro ao fazer download do exame', 'error');
                this.downloading = false;
                this.progress = 0;
            }
        }
    })),
    
    // Advanced Filter Handler for Exam Lists
    Alpine.data('examFilter', () => ({
        search: '',
        petFilter: '',
        typeFilter: '',
        dateFrom: '',
        dateTo: '',
        sortBy: 'exam_date',
        sortDirection: 'desc',
        
        get filteredExams() {
            return this.exams.filter(exam => {
                const matchesSearch = !this.search || 
                    exam.codigo.toLowerCase().includes(this.search.toLowerCase()) ||
                    (exam.description && exam.description.toLowerCase().includes(this.search.toLowerCase()));
                
                const matchesPet = !this.petFilter || exam.pet_id == this.petFilter;
                const matchesType = !this.typeFilter || exam.exam_type_id == this.typeFilter;
                
                return matchesSearch && matchesPet && matchesType;
            });
        },
        
        clearFilters() {
            this.search = '';
            this.petFilter = '';
            this.typeFilter = '';
            this.dateFrom = '';
            this.dateTo = '';
        },
        
        toggleSort(field) {
            if (this.sortBy === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = field;
                this.sortDirection = 'desc';
            }
        }
    })),
    
    // Profile Management Component
    Alpine.data('profileManager', () => ({
        editing: false,
        saving: false,
        formData: {},
        
        startEdit() {
            this.editing = true;
            this.formData = { ...this.clientData };
        },
        
        cancelEdit() {
            this.editing = false;
            this.formData = {};
        },
        
        async saveProfile() {
            this.saving = true;
            
            try {
                const response = await fetch('/client/profile', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.formData)
                });
                
                if (response.ok) {
                    Alpine.store('toast').showToast('Perfil atualizado com sucesso!', 'success');
                    this.editing = false;
                    // Refresh page data if needed
                } else {
                    throw new Error('Erro ao salvar perfil');
                }
                
            } catch (error) {
                console.error('Profile save error:', error);
                Alpine.store('toast').showToast('Erro ao atualizar perfil', 'error');
            } finally {
                this.saving = false;
            }
        }
    })),
    
    // Notification Settings Component
    Alpine.data('notificationSettings', () => ({
        emailNotifications: true,
        smsNotifications: false,
        updating: false,
        
        init() {
            // Initialize from server data if available
            if (window.clientNotificationSettings) {
                this.emailNotifications = window.clientNotificationSettings.email;
                this.smsNotifications = window.clientNotificationSettings.sms;
            }
        },
        
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
                    Alpine.store('toast').showToast('Preferências atualizadas!', 'success');
                } else {
                    throw new Error('Erro na resposta do servidor');
                }
            } catch (error) {
                console.error('Notification update error:', error);
                Alpine.store('toast').showToast('Erro ao atualizar preferências', 'error');
                
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
    })),
    
    // Statistics with Animated Counters
    Alpine.data('animatedStats', (initialStats = {}) => ({
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
        
        animateCounters(targets) {
            Object.entries(targets).forEach(([key, target], index) => {
                if (target === 0) return;
                
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
    })),
    
    // Chart Animation Component
    Alpine.data('chartAnimation', () => ({
        bars: [],
        
        init() {
            // Initialize bars array
            this.bars = new Array(document.querySelectorAll('[data-percentage]').length).fill(0);
        },
        
        animateCharts() {
            document.querySelectorAll('[data-percentage]').forEach((bar, index) => {
                const percentage = parseFloat(bar.dataset.percentage);
                
                setTimeout(() => {
                    this.bars[index] = percentage;
                }, index * 200);
            });
        }
    })),
    
    // Global Toast System Component
    Alpine.data('toastSystem', () => ({
        init() {
            // Watch for global toast changes
            this.$watch(() => Alpine.store('toast').show, (show) => {
                // Additional toast handling if needed
            });
        }
    })),
    
    // Mobile Menu Handler
    Alpine.data('mobileMenu', () => ({
        open: false,
        
        toggle() {
            this.open = !this.open;
            document.body.classList.toggle('overflow-hidden', this.open);
        },
        
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        }
    }))
});

// ===== PERFORMANCE OPTIMIZATIONS =====

// Lazy loading setup for images
function setupLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Prefetch important client routes
function setupClientPrefetch() {
    const importantLinks = document.querySelectorAll('a[href*="/client/dashboard"], a[href*="/client/profile"], a[href*="/client/exams"]');
    
    importantLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            const prefetchLink = document.createElement('link');
            prefetchLink.rel = 'prefetch';
            prefetchLink.href = link.href;
            document.head.appendChild(prefetchLink);
        }, { once: true });
    });
}

// Initialize client-specific optimizations
function initializeClientApp() {
    setupLazyLoading();
    setupClientPrefetch();
    
    // Initialize client theme
    Alpine.store('clientTheme').init();
    
    console.log('🚀 VetExams Client App initialized');
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeClientApp);