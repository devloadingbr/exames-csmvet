/**
 * Jest Test Setup
 * Global configuration for all tests
 */

import '@testing-library/jest-dom';

// Mock Alpine.js for testing
global.Alpine = {
    data: jest.fn(),
    store: jest.fn(() => ({
        toast: {
            show: false,
            message: '',
            type: 'success',
            showToast: jest.fn(),
            success: jest.fn(),
            error: jest.fn(),
            warning: jest.fn(),
            info: jest.fn(),
            hide: jest.fn()
        },
        theme: {
            darkMode: false,
            toggle: jest.fn(),
            set: jest.fn(),
            init: jest.fn()
        },
        loading: {
            global: false,
            setGlobal: jest.fn(),
            setDownload: jest.fn(),
            isDownloading: jest.fn(() => false),
            clearAll: jest.fn()
        }
    })),
    start: jest.fn(),
    getScope: jest.fn(),
    evaluate: jest.fn()
};

// Mock axios globally
global.axios = {
    defaults: {
        headers: {
            common: {}
        }
    },
    interceptors: {
        request: {
            use: jest.fn()
        },
        response: {
            use: jest.fn()
        }
    },
    get: jest.fn(),
    post: jest.fn(),
    put: jest.fn(),
    delete: jest.fn()
};

// Mock window.location
delete window.location;
window.location = {
    href: 'http://localhost:3000',
    pathname: '/',
    search: '',
    hash: '',
    assign: jest.fn(),
    replace: jest.fn(),
    reload: jest.fn()
};

// Mock window.matchMedia
Object.defineProperty(window, 'matchMedia', {
    writable: true,
    value: jest.fn().mockImplementation(query => ({
        matches: false,
        media: query,
        onchange: null,
        addListener: jest.fn(),
        removeListener: jest.fn(),
        addEventListener: jest.fn(),
        removeEventListener: jest.fn(),
        dispatchEvent: jest.fn(),
    })),
});

// Timer spies are managed per-test by jest.useFakeTimers()

// Mock document.querySelector for CSRF token
const mockCSRFToken = { content: 'mock-csrf-token' };
document.querySelector = jest.fn((selector) => {
    if (selector === 'meta[name="csrf-token"]') {
        return mockCSRFToken;
    }
    return null;
});

// Mock localStorage
const localStorageMock = {
    getItem: jest.fn(),
    setItem: jest.fn(),
    removeItem: jest.fn(),
    clear: jest.fn()
};

Object.defineProperty(window, 'localStorage', {
    value: localStorageMock
});

// Mock console methods in tests (can be overridden per test)
global.console = {
    ...console,
    log: jest.fn(),
    error: jest.fn(),
    warn: jest.fn(),
    info: jest.fn()
};

// Clean up after each test
afterEach(() => {
    jest.clearAllMocks();
    document.body.innerHTML = '';
});