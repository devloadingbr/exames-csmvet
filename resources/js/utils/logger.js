/**
 * Enhanced Logging Utility for VetExams SaaS
 * Environment-aware logging with better formatting
 */

const isDevelopment = process.env.NODE_ENV !== 'production';

/**
 * Enhanced logger with environment awareness
 */
const logger = {
    /**
     * Debug level logging - only in development
     */
    debug(message, ...args) {
        if (isDevelopment) {
            console.debug(`🔍 [DEBUG] ${message}`, ...args);
        }
    },

    /**
     * Info level logging
     */
    info(message, ...args) {
        if (isDevelopment) {
            console.info(`ℹ️ [INFO] ${message}`, ...args);
        }
    },

    /**
     * Warning level logging
     */
    warn(message, ...args) {
        if (isDevelopment) {
            console.warn(`⚠️ [WARN] ${message}`, ...args);
        }
    },

    /**
     * Error level logging - always enabled
     */
    error(message, ...args) {
        console.error(`❌ [ERROR] ${message}`, ...args);
    },

    /**
     * Performance timing
     */
    time(label) {
        if (isDevelopment) {
            console.time(`⏱️ [TIMING] ${label}`);
        }
    },

    timeEnd(label) {
        if (isDevelopment) {
            console.timeEnd(`⏱️ [TIMING] ${label}`);
        }
    },

    /**
     * Component lifecycle logging
     */
    component(componentName, action, data = null) {
        if (isDevelopment) {
            const message = `🧩 [COMPONENT] ${componentName} ${action}`;
            if (data) {
                console.log(message, data);
            } else {
                console.log(message);
            }
        }
    },

    /**
     * API request logging
     */
    api(method, url, data = null) {
        if (isDevelopment) {
            const message = `🌐 [API] ${method.toUpperCase()} ${url}`;
            if (data) {
                console.log(message, data);
            } else {
                console.log(message);
            }
        }
    }
};

export default logger;