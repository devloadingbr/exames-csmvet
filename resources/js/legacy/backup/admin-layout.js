/**
 * Admin Layout JavaScript - Funções independentes extraídas
 * Mantém integração com Alpine.js no template inline
 */

// Enhanced Toast notification system
window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    const bgColors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    const icons = {
        success: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
        error: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
        warning: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
        info: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
    };
    
    toast.className = `glass-card px-6 py-4 text-white ${bgColors[type]} transform translate-x-full transition-all duration-500 border-2 shadow-lg backdrop-blur-lg hover-lift`;
    toast.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-3 animate-pulse-glow">
                ${icons[type] || icons.info}
            </div>
            <div class="text-sm font-medium">${message}</div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white/80 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Animate in with enhanced effects
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
        toast.classList.add('animate-shimmer');
    }, 100);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (toast.parentNode) {
                container.removeChild(toast);
            }
        }, 500);
    }, 5000);
};

// Enhanced theme management
window.initTheme = function() {
    const savedTheme = localStorage.getItem('darkMode');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === null) {
        localStorage.setItem('darkMode', prefersDark);
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (localStorage.getItem('darkMode') === null) {
            document.documentElement.classList.toggle('dark', e.matches);
        }
    });
};

// Performance optimizations - Intersection Observer setup
function setupIntersectionObserver() {
    if ('IntersectionObserver' in window) {
        // Lazy load images
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
        
        // Add reveal animations to elements as they come into view
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    scrollObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '50px' });
        
        // Auto-add scroll animations to cards and sections
        document.querySelectorAll('.glass-card, .animate-on-scroll').forEach(el => {
            el.classList.add('animate-on-scroll');
            scrollObserver.observe(el);
        });
    }
}

// Prefetch important pages for performance
function setupPrefetch() {
    const importantLinks = document.querySelectorAll('a[href*="admin/dashboard"], a[href*="admin/exams"], a[href*="admin/clients"]');
    importantLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            const prefetchLink = document.createElement('link');
            prefetchLink.rel = 'prefetch';
            prefetchLink.href = link.href;
            document.head.appendChild(prefetchLink);
        }, { once: true });
    });
}

// Add stagger animations to grid items
function setupStaggerAnimations() {
    document.querySelectorAll('.grid').forEach(grid => {
        if (grid.children.length > 1) {
            grid.classList.add('stagger-animation');
        }
    });
}

// Form loading states
function setupFormLoadingStates() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processando...
                `;
                submitBtn.disabled = true;
            }
        });
    });
}

// Add hover effects to interactive elements
function setupHoverEffects() {
    const interactiveElements = document.querySelectorAll('a, button, [role="button"]');
    interactiveElements.forEach(el => {
        if (!el.classList.contains('no-hover')) {
            el.classList.add('hover-lift');
        }
    });
}

// Advanced keyboard navigation (non-Alpine parts)
function setupKeyboardNavigation() {
    document.addEventListener('keydown', function(e) {
        // Alt + D for Dashboard
        if (e.altKey && e.key === 'd') {
            e.preventDefault();
            window.location.href = '/admin/dashboard';
        }
        
        // Alt + E for Exams
        if (e.altKey && e.key === 'e') {
            e.preventDefault();
            window.location.href = '/admin/exams';
        }
        
        // Alt + C for Clients
        if (e.altKey && e.key === 'c') {
            e.preventDefault();
            window.location.href = '/admin/clients';
        }
    });
}

// Add click ripple effects to buttons (non-Alpine)
function setupRippleEffects() {
    document.addEventListener('click', function(e) {
        const button = e.target.closest('button, .btn, [role="button"]');
        if (button && !button.classList.contains('no-ripple')) {
            button.classList.add('ripple-effect');
        }
    });
}

// Main initialization function
function initializeAdminLayout() {
    // Initialize theme system
    initTheme();
    
    // Setup all performance optimizations
    setupIntersectionObserver();
    setupPrefetch();
    setupStaggerAnimations();
    
    // Setup interactive elements
    setupFormLoadingStates();
    setupHoverEffects();
    setupKeyboardNavigation();
    setupRippleEffects();
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeAdminLayout);

// Initialize additional features when page is fully loaded
window.addEventListener('load', function() {
    // Final setup after all resources loaded
    setupIntersectionObserver();
    setupStaggerAnimations();
});