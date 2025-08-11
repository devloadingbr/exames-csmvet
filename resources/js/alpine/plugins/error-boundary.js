/**
 * Alpine.js Error Boundary Plugin
 * Enterprise error handling and monitoring
 */

import { reportError } from '@/utils/error-reporter';

/**
 * Error boundary plugin for Alpine.js
 * Catches and reports Alpine.js errors
 */
const ErrorBoundaryPlugin = (Alpine) => {
    // Store original error handler if it exists
    const originalErrorHandler = Alpine.onError || (() => {});

    // Setup error handler
    Alpine.onError = (error, expression, component) => {
        // Call original handler first
        originalErrorHandler(error, expression, component);

        // Use enterprise error reporter
        reportError(error, {
            type: 'alpine_error',
            expression,
            component: component?.$el?.tagName || 'Unknown',
            componentId: component?.$el?.id || null,
            componentClass: component?.$el?.className || null,
            elementHTML: component?.$el?.outerHTML?.substring(0, 200) || null,
            severity: 'error',
            source: 'alpinejs',
            alpineVersion: 'NPM',
            hasAlpineStore: !!window.Alpine?.store
        });

        // Show user-friendly notification
        try {
            if (Alpine.store && Alpine.store('toast')) {
                const store = Alpine.store('toast');
                if (typeof store.error === 'function') {
                    store.error('Ocorreu um erro inesperado. Tente recarregar a página se o problema persistir.');
                }
            }
        } catch (toastError) {
            // Fallback to simple alert if toast fails
            console.warn('Toast notification failed:', toastError);
        }
    };
};

// Global error handlers for additional coverage
export const setupGlobalErrorHandlers = () => {
    // Catch unhandled JavaScript errors
    window.addEventListener('error', (event) => {
        reportError(event.error || new Error(event.message), {
            type: 'global_error',
            filename: event.filename,
            lineno: event.lineno,
            colno: event.colno,
            severity: 'error',
            source: 'global'
        });
    });

    // Catch unhandled promise rejections
    window.addEventListener('unhandledrejection', (event) => {
        const error = event.reason instanceof Error ? event.reason : new Error(String(event.reason));
        
        reportError(error, {
            type: 'unhandled_promise',
            reason: String(event.reason),
            severity: 'error',
            source: 'promise'
        });
    });

    // Catch resource loading errors
    window.addEventListener('error', (event) => {
        if (event.target && event.target !== window) {
            const element = event.target;
            reportError(new Error(`Resource failed to load: ${element.src || element.href}`), {
                type: 'resource_error',
                tagName: element.tagName,
                src: element.src || element.href,
                severity: 'warning',
                source: 'resource'
            });
        }
    }, true);
};

export default ErrorBoundaryPlugin;