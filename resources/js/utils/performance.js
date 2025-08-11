/**
 * Performance Monitoring Utilities
 * Core Web Vitals tracking and performance monitoring
 */

export class PerformanceMonitor {
    constructor(options = {}) {
        this.metrics = {};
        this.options = {
            enableLogging: options.enableLogging || process.env.NODE_ENV === 'development',
            enableReporting: options.enableReporting !== false, // Default true
            reportingEndpoint: options.reportingEndpoint || '/api/metrics/performance',
            debug: options.debug || false,
            batchSize: options.batchSize || 10,
            batchTimeout: options.batchTimeout || 5000,
            enableBundleAnalysis: options.enableBundleAnalysis || true,
            enableMemoryTracking: options.enableMemoryTracking || true,
            thresholds: {
                LCP: 2500,    // Good: <2.5s
                FID: 100,     // Good: <100ms
                CLS: 0.1,     // Good: <0.1
                TTFB: 800,    // Good: <800ms
                ...options.thresholds
            },
            ...options
        };
        
        // Batch reporting queue
        this.reportingQueue = [];
        this.reportingTimer = null;

        this.init();
    }

    /**
     * Initialize performance monitoring
     */
    init() {
        if (!this.isSupported()) {
            console.warn('Performance monitoring not supported in this browser');
            return;
        }

        this.initWebVitals();
        this.initNavigationTiming();
        this.initResourceTiming();
        this.setupPerformanceObserver();

        // Report metrics when page becomes hidden
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                this.reportMetrics();
            }
        });

        // Also report on page unload
        window.addEventListener('beforeunload', () => {
            this.reportMetrics();
        });
    }

    /**
     * Check if Performance API is supported
     */
    isSupported() {
        return 'performance' in window && 
               'PerformanceObserver' in window;
    }

    /**
     * Initialize Core Web Vitals monitoring
     */
    initWebVitals() {
        // Largest Contentful Paint (LCP)
        this.observePerformanceEntry('largest-contentful-paint', (entries) => {
            const lcp = entries[entries.length - 1];
            this.metrics.lcp = Math.round(lcp.startTime);
            this.logMetric('LCP', this.metrics.lcp, 'ms');
            this.sendMetric('LCP', this.metrics.lcp);
        });

        // First Input Delay (FID)
        this.observePerformanceEntry('first-input', (entries) => {
            const fid = entries[0];
            this.metrics.fid = Math.round(fid.processingStart - fid.startTime);
            this.logMetric('FID', this.metrics.fid, 'ms');
            this.sendMetric('FID', this.metrics.fid);
        });

        // Cumulative Layout Shift (CLS)
        this.observePerformanceEntry('layout-shift', (entries) => {
            let cls = 0;
            for (const entry of entries) {
                if (!entry.hadRecentInput) {
                    cls += entry.value;
                }
            }
            this.metrics.cls = Math.round(cls * 1000) / 1000;
            this.logMetric('CLS', this.metrics.cls);
            this.sendMetric('CLS', this.metrics.cls);
        });

        // First Contentful Paint (FCP)
        this.observePerformanceEntry('paint', (entries) => {
            const fcp = entries.find(entry => entry.name === 'first-contentful-paint');
            if (fcp) {
                this.metrics.fcp = Math.round(fcp.startTime);
                this.logMetric('FCP', this.metrics.fcp, 'ms');
                this.sendMetric('FCP', this.metrics.fcp);
            }
        });
    }

    /**
     * Initialize navigation timing
     */
    initNavigationTiming() {
        window.addEventListener('load', () => {
            setTimeout(() => {
                const navigation = performance.getEntriesByType('navigation')[0];
                if (navigation) {
                    this.metrics.navigationTiming = {
                        dns: Math.round(navigation.domainLookupEnd - navigation.domainLookupStart),
                        connection: Math.round(navigation.connectEnd - navigation.connectStart),
                        request: Math.round(navigation.responseStart - navigation.requestStart),
                        response: Math.round(navigation.responseEnd - navigation.responseStart),
                        domLoading: Math.round(navigation.domContentLoadedEventEnd - navigation.navigationStart),
                        domReady: Math.round(navigation.domContentLoadedEventEnd - navigation.navigationStart),
                        pageLoad: Math.round(navigation.loadEventEnd - navigation.navigationStart)
                    };

                    this.logMetric('Navigation Timing', this.metrics.navigationTiming);
                    this.sendMetric('Navigation', this.metrics.navigationTiming);
                }
            }, 0);
        });
    }

    /**
     * Initialize resource timing monitoring
     */
    initResourceTiming() {
        window.addEventListener('load', () => {
            setTimeout(() => {
                const resources = performance.getEntriesByType('resource');
                const resourceMetrics = {
                    totalResources: resources.length,
                    scripts: resources.filter(r => r.initiatorType === 'script').length,
                    stylesheets: resources.filter(r => r.initiatorType === 'link' || r.initiatorType === 'css').length,
                    images: resources.filter(r => r.initiatorType === 'img').length,
                    fonts: resources.filter(r => r.name.includes('font') || r.name.includes('.woff')).length,
                    slowResources: resources.filter(r => r.duration > 1000).length
                };

                this.metrics.resources = resourceMetrics;
                this.logMetric('Resource Timing', resourceMetrics);
                this.sendMetric('Resources', resourceMetrics);
            }, 1000);
        });
    }

    /**
     * Setup generic performance observer
     */
    setupPerformanceObserver() {
        try {
            // Monitor long tasks (> 50ms)
            this.observePerformanceEntry('longtask', (entries) => {
                const longTasks = entries.map(entry => ({
                    duration: Math.round(entry.duration),
                    startTime: Math.round(entry.startTime)
                }));

                this.metrics.longTasks = (this.metrics.longTasks || []).concat(longTasks);
                this.logMetric('Long Tasks', longTasks);
            });
        } catch (error) {
            console.warn('Long task monitoring not supported:', error);
        }
    }

    /**
     * Observe performance entries by type
     */
    observePerformanceEntry(type, callback) {
        try {
            const observer = new PerformanceObserver((list) => {
                callback(list.getEntries());
            });
            observer.observe({ entryTypes: [type] });
        } catch (error) {
            console.warn(`Performance observer for ${type} not supported:`, error);
        }
    }

    /**
     * Log metric to console (development only)
     */
    logMetric(name, value, unit = '') {
        if (this.options.enableLogging) {
            console.log(`📊 ${name}:`, value, unit);
        }
    }

    /**
     * Send metric to analytics/monitoring service
     */
    sendMetric(name, value) {
        if (!this.options.enableReporting) {return;}

        // Send to Google Analytics if available
        if (typeof gtag === 'function') {
            gtag('event', 'web_vitals', {
                name,
                value: typeof value === 'object' ? JSON.stringify(value) : value,
                custom_parameter: window.location.pathname
            });
        }

        // Send to custom analytics if available
        if (typeof analytics !== 'undefined' && analytics.track) {
            analytics.track('Performance Metric', {
                metric: name,
                value,
                page: window.location.pathname,
                timestamp: Date.now()
            });
        }
    }

    /**
     * Get current metrics
     */
    getMetrics() {
        return { ...this.metrics };
    }

    /**
     * Report all metrics to server
     */
    async reportMetrics() {
        if (!this.options.enableReporting || Object.keys(this.metrics).length === 0) {
            return;
        }

        try {
            const payload = {
                metrics: this.getMetrics(),
                page: window.location.pathname,
                timestamp: Date.now(),
                userAgent: navigator.userAgent,
                viewport: {
                    width: window.innerWidth,
                    height: window.innerHeight
                },
                connection: this.getConnectionInfo()
            };

            // Use sendBeacon for reliability when page is unloading
            if (navigator.sendBeacon) {
                navigator.sendBeacon(
                    this.options.reportingEndpoint,
                    JSON.stringify(payload)
                );
            } else {
                // Fallback to fetch
                fetch(this.options.reportingEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify(payload),
                    keepalive: true
                });
            }
        } catch (error) {
            console.warn('Failed to report metrics:', error);
        }
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
        return null;
    }

    /**
     * Mark a custom performance metric
     */
    mark(name, value) {
        this.metrics[name] = value;
        this.logMetric(name, value);
        this.sendMetric(name, value);
    }

    /**
     * Time a function execution
     */
    async timeFunction(name, fn) {
        const startTime = performance.now();
        try {
            const result = await fn();
            const duration = Math.round(performance.now() - startTime);
            this.mark(`${name}_duration`, duration);
            return result;
        } catch (error) {
            const duration = Math.round(performance.now() - startTime);
            this.mark(`${name}_error_duration`, duration);
            throw error;
        }
    }

    /**
     * Analyze and report bundle performance
     */
    analyzeBundlePerformance() {
        if (!this.options.enableBundleAnalysis) {return;}

        // Analyze loaded resources
        const resources = performance.getEntriesByType('resource');
        const jsResources = resources.filter(r => r.name.includes('.js'));
        const cssResources = resources.filter(r => r.name.includes('.css'));

        const bundleMetrics = {
            totalJSSize: jsResources.reduce((sum, r) => sum + (r.transferSize || 0), 0),
            totalCSSSize: cssResources.reduce((sum, r) => sum + (r.transferSize || 0), 0),
            jsCount: jsResources.length,
            cssCount: cssResources.length,
            largestJS: Math.max(...jsResources.map(r => r.transferSize || 0)),
            largestCSS: Math.max(...cssResources.map(r => r.transferSize || 0))
        };

        this.logMetric('bundle_analysis', bundleMetrics);
        return bundleMetrics;
    }

    /**
     * Monitor memory usage (if available)
     */
    monitorMemory() {
        if (!this.options.enableMemoryTracking || !performance.memory) {return;}

        const memInfo = {
            usedJSHeapSize: performance.memory.usedJSHeapSize,
            totalJSHeapSize: performance.memory.totalJSHeapSize,
            jsHeapSizeLimit: performance.memory.jsHeapSizeLimit
        };

        this.mark('memory_usage', memInfo);
        return memInfo;
    }
}

// Singleton instance
let performanceMonitor = null;

/**
 * Get or create performance monitor instance
 */
export const getPerformanceMonitor = (options = {}) => {
    if (!performanceMonitor) {
        performanceMonitor = new PerformanceMonitor(options);
    }
    return performanceMonitor;
};

/**
 * Quick performance mark function
 */
export const markPerformance = (name, value) => {
    const monitor = getPerformanceMonitor();
    monitor.mark(name, value);
};

/**
 * Initialize performance monitoring with default settings
 */
export const initPerformanceMonitoring = (options = {}) => {
    return getPerformanceMonitor({
        enableLogging: process.env.NODE_ENV === 'development',
        enableReporting: true,
        debug: false,
        ...options
    });
};