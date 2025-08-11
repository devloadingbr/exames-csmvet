<?php

/**
 * Content Security Policy Configuration
 * Enterprise-grade security headers for VetExams SaaS
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Content Security Policy Directives
    |--------------------------------------------------------------------------
    |
    | These directives control which resources can be loaded by the browser.
    | Each directive accepts an array of sources.
    |
    */

    'default-src' => [
        "'self'",
    ],

    'script-src' => [
        "'self'",
        "'unsafe-inline'", // Required for Alpine.js inline scripts
        "'unsafe-eval'",   // Required for Vite HMR in development
    ],

    'style-src' => [
        "'self'",
        "'unsafe-inline'", // Required for Tailwind CSS and dynamic styles
        'fonts.googleapis.com',
    ],

    'font-src' => [
        "'self'",
        'fonts.gstatic.com',
        'data:', // For base64 encoded fonts
    ],

    'img-src' => [
        "'self'",
        'data:', // For base64 encoded images
        'https:', // Allow HTTPS images (for external pet photos, etc)
    ],

    'connect-src' => [
        "'self'",
        'ws:', // WebSocket connections for Vite HMR
        'wss:', // Secure WebSocket connections
    ],

    'media-src' => [
        "'self'",
    ],

    'object-src' => [
        "'none'", // Disable object/embed for security
    ],

    'frame-src' => [
        "'none'", // Disable frames for security
    ],

    'frame-ancestors' => [
        "'none'", // Prevent clickjacking
    ],

    'base-uri' => [
        "'self'", // Restrict base tag
    ],

    'form-action' => [
        "'self'", // Only allow forms to submit to same origin
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment-specific Overrides
    |--------------------------------------------------------------------------
    |
    | Different CSP settings for development vs production
    |
    */

    'development' => [
        'script-src' => [
            "'self'",
            "'unsafe-inline'",
            "'unsafe-eval'", // Vite HMR
            'localhost:*',   // Vite dev server
            '127.0.0.1:*',   // Local development
        ],
        'connect-src' => [
            "'self'",
            'ws://localhost:*',   // Vite HMR WebSocket
            'ws://127.0.0.1:*',   // Local WebSocket
            'http://localhost:*', // Local API calls
            'http://127.0.0.1:*', // Local API calls
        ],
    ],

    'production' => [
        'script-src' => [
            "'self'",
            "'unsafe-inline'", // Keep for Alpine.js
            // Remove unsafe-eval in production
        ],
        'upgrade-insecure-requests' => true, // Force HTTPS
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Configuration
    |--------------------------------------------------------------------------
    |
    | CSP violation reporting
    |
    */

    'report-uri' => env('CSP_REPORT_URI'),
    'report-to' => env('CSP_REPORT_TO'),

    /*
    |--------------------------------------------------------------------------
    | Additional Security Headers
    |--------------------------------------------------------------------------
    |
    | Other security headers to include
    |
    */

    'additional_headers' => [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'DENY',
        'X-XSS-Protection' => '1; mode=block',
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'geolocation=(), microphone=(), camera=(), payment=()',
    ],
];