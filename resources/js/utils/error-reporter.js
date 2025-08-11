/**
 * Enterprise Error Reporting Utility
 * Centralized error reporting with retry logic and batching
 */

export class ErrorReporter {
    constructor(options = {}) {
        this.options = {
            endpoint: options.endpoint || '/api/errors/frontend',
            batchSize: options.batchSize || 10,
            flushInterval: options.flushInterval || 30000, // 30 seconds
            maxRetries: options.maxRetries || 3,
            enableConsoleLogging: options.enableConsoleLogging !== false,
            enableSentryIntegration: options.enableSentryIntegration !== false,
            ...options
        };

        this.errorQueue = [];
        this.retryQueue = [];
        this.flushTimer = null;
        this.isOnline = navigator.onLine;
        
        this.init();
    }

    /**
     * Initialize error reporter
     */
    init() {
        // Setup auto-flush timer
        this.setupFlushTimer();

        // Monitor network status
        window.addEventListener('online', () => {
            this.isOnline = true;
            this.flushErrorQueue();
        });

        window.addEventListener('offline', () => {
            this.isOnline = false;
        });

        // Flush on page unload
        window.addEventListener('beforeunload', () => {
            this.flushErrorQueue(true);
        });

        // Flush on visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                this.flushErrorQueue(true);
            }
        });
    }

    /**
     * Report an error
     */
    reportError(error, context = {}) {
        const errorData = this.formatError(error, context);
        
        // Add to queue
        this.errorQueue.push(errorData);

        // Log to console in development
        if (this.options.enableConsoleLogging && 
            (process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost')) {
            console.group('🚨 Error Reporter');
            console.error('Error:', error);
            console.log('Context:', context);
            console.log('Formatted:', errorData);
            console.groupEnd();
        }

        // Send to Sentry if available
        if (this.options.enableSentryIntegration && window.Sentry) {
            this.sendToSentry(error, errorData);
        }

        // Immediate flush for critical errors
        if (context.severity === 'critical' || this.errorQueue.length >= this.options.batchSize) {
            this.flushErrorQueue();
        }
    }

    /**
     * Format error for reporting
     */
    formatError(error, context = {}) {
        const baseError = {
            message: error.message || String(error),
            stack: error.stack || null,
            timestamp: new Date().toISOString(),
            url: window.location.href,
            pathname: window.location.pathname,
            userAgent: navigator.userAgent,
            referrer: document.referrer,
            
            // Browser context
            viewport: {
                width: window.innerWidth,
                height: window.innerHeight
            },
            screen: {
                width: screen.width,
                height: screen.height,
                colorDepth: screen.colorDepth
            },
            connection: this.getConnectionInfo(),
            
            // Performance context
            memory: this.getMemoryInfo(),
            timing: this.getTimingInfo(),
            
            // Custom context
            ...context
        };

        // Add error type classification
        baseError.errorType = this.classifyError(error);
        
        // Add session info
        baseError.session = {
            timeOnPage: Date.now() - (window.performanceStartTime || Date.now()),
            userInteractions: window.userInteractionCount || 0,
            scrollDepth: this.getScrollDepth(),
            darkMode: document.documentElement.classList.contains('dark')
        };

        return baseError;
    }

    /**
     * Classify error type
     */
    classifyError(error) {
        if (error instanceof TypeError) {return 'type_error';}
        if (error instanceof ReferenceError) {return 'reference_error';}
        if (error instanceof SyntaxError) {return 'syntax_error';}
        if (error instanceof RangeError) {return 'range_error';}
        if (error.name === 'ChunkLoadError') {return 'chunk_load_error';}
        if (error.name === 'NetworkError') {return 'network_error';}
        if (error.message.includes('Alpine')) {return 'alpine_error';}
        if (error.message.includes('fetch')) {return 'fetch_error';}
        return 'generic_error';
    }

    /**
     * Get connection information
     */
    getConnectionInfo() {
        if ('connection' in navigator) {
            const conn = navigator.connection;
            return {
                effectiveType: conn.effectiveType,
                downlink: conn.downlink,
                rtt: conn.rtt,
                saveData: conn.saveData
            };
        }
        return { online: this.isOnline };
    }

    /**
     * Get memory information
     */
    getMemoryInfo() {
        if (performance.memory) {
            return {
                used: performance.memory.usedJSHeapSize,
                total: performance.memory.totalJSHeapSize,
                limit: performance.memory.jsHeapSizeLimit
            };
        }
        return null;
    }

    /**
     * Get timing information
     */
    getTimingInfo() {
        const navigation = performance.getEntriesByType('navigation')[0];
        if (navigation) {
            return {
                domContentLoaded: Math.round(navigation.domContentLoadedEventEnd - navigation.navigationStart),
                loadComplete: Math.round(navigation.loadEventEnd - navigation.navigationStart),
                firstPaint: this.getFirstPaint()
            };
        }
        return null;
    }

    /**
     * Get first paint timing
     */
    getFirstPaint() {
        const paintEntries = performance.getEntriesByType('paint');
        const fcp = paintEntries.find(entry => entry.name === 'first-contentful-paint');
        return fcp ? Math.round(fcp.startTime) : null;
    }

    /**
     * Get scroll depth percentage
     */
    getScrollDepth() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const documentHeight = document.documentElement.scrollHeight - window.innerHeight;
        return Math.round((scrollTop / documentHeight) * 100) || 0;
    }

    /**
     * Send to Sentry
     */
    sendToSentry(error, errorData) {
        try {
            window.Sentry.captureException(error, {
                tags: {
                    source: 'error-reporter',
                    errorType: errorData.errorType,
                    severity: errorData.severity || 'error'
                },
                extra: {
                    context: errorData,
                    session: errorData.session,
                    timing: errorData.timing
                },
                fingerprint: [
                    errorData.message,
                    errorData.pathname,
                    errorData.errorType
                ]
            });
        } catch (sentryError) {
            console.warn('Failed to send to Sentry:', sentryError);
        }
    }

    /**
     * Setup flush timer
     */
    setupFlushTimer() {
        if (this.flushTimer) {
            clearInterval(this.flushTimer);
        }

        this.flushTimer = setInterval(() => {
            if (this.errorQueue.length > 0) {
                this.flushErrorQueue();
            }
        }, this.options.flushInterval);
    }

    /**
     * Flush error queue
     */
    async flushErrorQueue(immediate = false) {
        if (this.errorQueue.length === 0) {return;}

        const errors = this.errorQueue.splice(0);
        
        try {
            await this.sendErrors(errors, immediate);
        } catch {
            // Add back to retry queue
            this.retryQueue.push(...errors.map(err => ({
                ...err,
                retryCount: (err.retryCount || 0) + 1
            })));

            // Retry failed errors with exponential backoff
            setTimeout(() => {
                this.retryFailedErrors();
            }, Math.min(1000 * Math.pow(2, errors[0]?.retryCount || 0), 30000));
        }
    }

    /**
     * Send errors to server
     */
    async sendErrors(errors, immediate = false) {
        if (!this.isOnline) {
            throw new Error('Offline - will retry when online');
        }

        const payload = {
            errors,
            meta: {
                timestamp: new Date().toISOString(),
                batch_size: errors.length,
                user_agent: navigator.userAgent,
                page: window.location.pathname
            }
        };

        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            body: JSON.stringify(payload)
        };

        // Use keepalive for immediate sends (page unload)
        if (immediate) {
            options.keepalive = true;
        }

        const response = await fetch(this.options.endpoint, options);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        return response.json();
    }

    /**
     * Retry failed errors
     */
    async retryFailedErrors() {
        if (this.retryQueue.length === 0) {return;}

        const errorsToRetry = this.retryQueue.filter(
            error => error.retryCount < this.options.maxRetries
        );

        if (errorsToRetry.length === 0) {
            // Drop errors that exceeded max retries
            this.retryQueue = [];
            return;
        }

        // Remove from retry queue
        this.retryQueue = this.retryQueue.filter(
            error => error.retryCount >= this.options.maxRetries
        );

        try {
            await this.sendErrors(errorsToRetry);
        } catch {
            // Add back to retry queue with incremented count
            this.retryQueue.push(...errorsToRetry.map(err => ({
                ...err,
                retryCount: err.retryCount + 1
            })));
        }
    }

    /**
     * Get queue status
     */
    getStatus() {
        return {
            queueSize: this.errorQueue.length,
            retryQueueSize: this.retryQueue.length,
            isOnline: this.isOnline,
            endpoint: this.options.endpoint
        };
    }

    /**
     * Clear all queues
     */
    clearQueues() {
        this.errorQueue = [];
        this.retryQueue = [];
    }

    /**
     * Destroy reporter
     */
    destroy() {
        if (this.flushTimer) {
            clearInterval(this.flushTimer);
            this.flushTimer = null;
        }
        
        // Final flush
        this.flushErrorQueue(true);
    }
}

// Singleton instance
let errorReporter = null;

/**
 * Get or create error reporter instance
 */
export const getErrorReporter = (options = {}) => {
    if (!errorReporter) {
        errorReporter = new ErrorReporter(options);
    }
    return errorReporter;
};

/**
 * Quick error reporting function
 */
export const reportError = (error, context = {}) => {
    const reporter = getErrorReporter();
    reporter.reportError(error, context);
};

/**
 * Initialize error reporting with default settings
 */
export const initErrorReporting = (options = {}) => {
    return getErrorReporter({
        enableConsoleLogging: process.env.NODE_ENV === 'development',
        enableSentryIntegration: true,
        ...options
    });
};