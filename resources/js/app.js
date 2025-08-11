/**
 * VetExams SaaS - Main Application Entry Point
 * Unified JavaScript bundle with Alpine.js via NPM
 */

// Import HTTP utilities with CSRF support
import './utils/http.js';

// Import performance monitoring
import { initPerformanceMonitoring } from './utils/performance.js';

// Import error reporting
import { initErrorReporting } from './utils/error-reporter.js';

// Import security manager
import { initSecurityManager } from './utils/security.js';

// Import and initialize Alpine.js with all components and stores
import './alpine/index.js';

// Legacy support - make axios available globally
import axios from 'axios';
window.axios = axios;

// Legacy compatibility - unified toast system
window.showToast = function(message, type = 'success') {
    if (window.Alpine?.store('toast')) {
        window.Alpine.store('toast').showToast(message, type);
    } else {
        // Fallback for early initialization
        console.warn('Toast system not ready, queueing:', message);
        setTimeout(() => window.showToast(message, type), 100);
    }
};

// Initialize theme on load
document.addEventListener('DOMContentLoaded', () => {
    // Initialize theme system
    if (window.Alpine?.store('theme')) {
        window.Alpine.store('theme').init();
    }
    
    // Initialize performance monitoring
    initPerformanceMonitoring({
        enableLogging: window.location.hostname === 'localhost',
        enableReporting: true
    });
    
    // Initialize error reporting
    initErrorReporting({
        enableConsoleLogging: window.location.hostname === 'localhost',
        enableSentryIntegration: true
    });
    
    // Initialize security manager
    initSecurityManager({
        enableCSPReporting: true,
        enableXSSProtection: true,
        enableInputSanitization: true
    });
    
    console.log('🚀 VetExams SaaS initialized with Alpine.js via NPM');
});
