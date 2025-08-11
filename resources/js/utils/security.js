/**
 * Security Utilities
 * Client-side security helpers and validation
 */

export class SecurityManager {
    constructor(options = {}) {
        this.options = {
            enableCSPReporting: options.enableCSPReporting !== false,
            enableXSSProtection: options.enableXSSProtection !== false,
            enableInputSanitization: options.enableInputSanitization !== false,
            allowedOrigins: options.allowedOrigins || [window.location.origin],
            maxInputLength: options.maxInputLength || 10000,
            ...options
        };

        this.init();
    }

    /**
     * Initialize security manager
     */
    init() {
        if (this.options.enableCSPReporting) {
            this.setupCSPReporting();
        }

        if (this.options.enableXSSProtection) {
            this.setupXSSProtection();
        }

        this.setupSecurityEventListeners();
    }

    /**
     * Setup CSP violation reporting
     */
    setupCSPReporting() {
        document.addEventListener('securitypolicyviolation', (event) => {
            const violation = {
                blockedURI: event.blockedURI,
                violatedDirective: event.violatedDirective,
                originalPolicy: event.originalPolicy,
                documentURI: event.documentURI,
                lineNumber: event.lineNumber,
                columnNumber: event.columnNumber,
                sourceFile: event.sourceFile,
                timestamp: new Date().toISOString()
            };

            // Log in development
            if (process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost') {
                console.warn('🛡️ CSP Violation:', violation);
            }

            // Report to server
            this.reportSecurityEvent('csp_violation', violation);
        });
    }

    /**
     * Setup XSS protection mechanisms
     */
    setupXSSProtection() {
        // Monitor for suspicious script execution
        this.monitorDOMModifications();
        this.validateInlineScripts();
        this.protectAgainstPrototypePollution();
    }

    /**
     * Monitor DOM modifications for suspicious content
     */
    monitorDOMModifications() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) { // Node.ELEMENT_NODE
                        this.validateElement(node);
                    }
                });
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Validate element for security issues
     */
    validateElement(element) {
        // Check for suspicious attributes
        const dangerousAttributes = ['onload', 'onerror', 'onclick', 'onmouseover', 'onfocus'];
        
        dangerousAttributes.forEach(attr => {
            if (element.hasAttribute && element.hasAttribute(attr)) {
                this.reportSecurityEvent('suspicious_element', {
                    tagName: element.tagName,
                    attribute: attr,
                    value: element.getAttribute(attr),
                    outerHTML: element.outerHTML.substring(0, 200)
                });
            }
        });

        // Check for inline JavaScript URLs
        if (element.href && element.href.startsWith('javascript:')) {
            this.reportSecurityEvent('javascript_url', {
                tagName: element.tagName,
                href: element.href
            });
        }

        // Check for suspicious content
        if (element.innerHTML && this.containsSuspiciousContent(element.innerHTML)) {
            this.reportSecurityEvent('suspicious_content', {
                tagName: element.tagName,
                content: element.innerHTML.substring(0, 200)
            });
        }
    }

    /**
     * Check for suspicious content patterns
     */
    containsSuspiciousContent(content) {
        const suspiciousPatterns = [
            /<script[^>]*>.*?<\/script>/gi,
            /javascript:/gi,
            /vbscript:/gi,
            /on\w+\s*=/gi,
            /<iframe[^>]*src=["']?data:/gi,
            /<object[^>]*data=["']?data:/gi
        ];

        return suspiciousPatterns.some(pattern => pattern.test(content));
    }

    /**
     * Validate inline scripts
     */
    validateInlineScripts() {
        const scripts = document.querySelectorAll('script:not([src])');
        scripts.forEach(script => {
            if (!script.hasAttribute('nonce') && !script.dataset.securityApproved) {
                this.reportSecurityEvent('inline_script', {
                    content: script.textContent.substring(0, 200),
                    location: script.src || 'inline'
                });
            }
        });
    }

    /**
     * Protect against prototype pollution
     */
    protectAgainstPrototypePollution() {
        const originalDefineProperty = Object.defineProperty;
        Object.defineProperty = function(obj, prop, descriptor) {
            // Block attempts to modify Object.prototype
            if (obj === Object.prototype || obj === Array.prototype) {
                console.warn('🛡️ Blocked prototype pollution attempt:', prop);
                return obj;
            }
            return originalDefineProperty.call(this, obj, prop, descriptor);
        };

        // Monitor for common prototype pollution vectors
        const dangerousKeys = ['__proto__', 'constructor', 'prototype'];
        const originalParse = JSON.parse;
        JSON.parse = function(text, reviver) {
            const result = originalParse.call(this, text, reviver);
            
            if (typeof result === 'object' && result !== null) {
                for (const key of dangerousKeys) {
                    if (key in result) {
                        console.warn('🛡️ Potential prototype pollution in JSON:', key);
                        delete result[key];
                    }
                }
            }
            
            return result;
        };
    }

    /**
     * Setup security event listeners
     */
    setupSecurityEventListeners() {
        // Monitor for postMessage security
        window.addEventListener('message', (event) => {
            if (!this.isAllowedOrigin(event.origin)) {
                this.reportSecurityEvent('untrusted_postmessage', {
                    origin: event.origin,
                    data: typeof event.data === 'string' ? event.data.substring(0, 100) : 'non-string'
                });
                return;
            }
        });

        // Monitor for suspicious navigation
        window.addEventListener('beforeunload', () => {
            // Check if navigation is to a suspicious URL
            if (document.activeElement && document.activeElement.href) {
                const url = document.activeElement.href;
                if (this.isSuspiciousURL(url)) {
                    this.reportSecurityEvent('suspicious_navigation', {
                        url: url,
                        triggered: 'beforeunload'
                    });
                }
            }
        });
    }

    /**
     * Check if origin is allowed
     */
    isAllowedOrigin(origin) {
        return this.options.allowedOrigins.includes(origin);
    }

    /**
     * Check if URL is suspicious
     */
    isSuspiciousURL(url) {
        try {
            const urlObj = new window.URL(url);
            
            // Check for suspicious protocols
            if (['javascript:', 'data:', 'vbscript:'].includes(urlObj.protocol)) {
                return true;
            }

            // Check for suspicious domains (basic check)
            const suspiciousDomains = ['bit.ly', 'tinyurl.com', 'goo.gl'];
            if (suspiciousDomains.some(domain => urlObj.hostname.includes(domain))) {
                return true;
            }

            return false;
        } catch {
            return true; // Invalid URL is suspicious
        }
    }

    /**
     * Sanitize user input
     */
    sanitizeInput(input, options = {}) {
        if (!this.options.enableInputSanitization) {
            return input;
        }

        if (typeof input !== 'string') {
            return input;
        }

        // Check input length
        if (input.length > this.options.maxInputLength) {
            this.reportSecurityEvent('oversized_input', {
                length: input.length,
                maxLength: this.options.maxInputLength
            });
            return input.substring(0, this.options.maxInputLength);
        }

        let sanitized = input;

        // Remove HTML tags if not allowed
        if (!options.allowHTML) {
            sanitized = sanitized.replace(/<[^>]*>/g, '');
        }

        // Remove JavaScript URLs
        sanitized = sanitized.replace(/javascript:/gi, '');

        // Remove event handlers
        sanitized = sanitized.replace(/on\w+\s*=/gi, '');

        // Remove dangerous protocols
        sanitized = sanitized.replace(/(vbscript|data|javascript):/gi, '');

        return sanitized;
    }

    /**
     * Validate CSRF token
     */
    validateCSRFToken(token) {
        const metaToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!metaToken) {
            this.reportSecurityEvent('missing_csrf_token', {
                page: window.location.pathname
            });
            return false;
        }

        if (token !== metaToken) {
            this.reportSecurityEvent('invalid_csrf_token', {
                provided: token ? 'present' : 'missing',
                page: window.location.pathname
            });
            return false;
        }

        return true;
    }

    /**
     * Secure fetch wrapper
     */
    async secureFetch(url, options = {}) {
        // Ensure CSRF token is included
        if (!options.headers) {
            options.headers = {};
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken && !options.headers['X-CSRF-TOKEN']) {
            options.headers['X-CSRF-TOKEN'] = csrfToken;
        }

        // Validate URL
        try {
            const urlObj = new window.URL(url, window.location.origin);
            if (this.isSuspiciousURL(urlObj.href)) {
                throw new Error('Suspicious URL blocked');
            }
        } catch (error) {
            this.reportSecurityEvent('blocked_fetch', {
                url: url,
                reason: error.message
            });
            throw error;
        }

        // Add security headers
        options.headers = {
            'X-Requested-With': 'XMLHttpRequest',
            ...options.headers
        };

        return fetch(url, options);
    }

    /**
     * Report security event
     */
    async reportSecurityEvent(type, details) {
        const event = {
            type,
            details,
            timestamp: new Date().toISOString(),
            url: window.location.href,
            userAgent: navigator.userAgent
        };

        // Log in development
        if (process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost') {
            console.warn(`🛡️ Security Event [${type}]:`, details);
        }

        // Report to server
        try {
            await fetch('/api/security/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(event)
            });
        } catch (error) {
            console.warn('Failed to report security event:', error);
        }
    }

    /**
     * Get security status
     */
    getSecurityStatus() {
        return {
            cspEnabled: !!document.querySelector('meta[http-equiv="Content-Security-Policy"]'),
            csrfToken: !!document.querySelector('meta[name="csrf-token"]'),
            httpsEnabled: location.protocol === 'https:',
            securityOptions: this.options
        };
    }
}

// Singleton instance
let securityManager = null;

/**
 * Get or create security manager instance
 */
export const getSecurityManager = (options = {}) => {
    if (!securityManager) {
        securityManager = new SecurityManager(options);
    }
    return securityManager;
};

/**
 * Quick input sanitization
 */
export const sanitizeInput = (input, options = {}) => {
    const manager = getSecurityManager();
    return manager.sanitizeInput(input, options);
};

/**
 * Secure fetch wrapper
 */
export const secureFetch = async (url, options = {}) => {
    const manager = getSecurityManager();
    return manager.secureFetch(url, options);
};

/**
 * Initialize security manager with default settings
 */
export const initSecurityManager = (options = {}) => {
    return getSecurityManager({
        enableCSPReporting: true,
        enableXSSProtection: true,
        enableInputSanitization: true,
        ...options
    });
};