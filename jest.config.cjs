/**
 * Jest Configuration for VetExams SaaS
 * Enterprise-grade testing setup
 */

module.exports = {
    testEnvironment: 'jsdom',
    testEnvironmentOptions: {
        url: 'http://localhost:3000',
        resources: 'usable'
    },
    setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
    
    // Module mapping for path aliases
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/js/$1',
        '^@/alpine/(.*)$': '<rootDir>/resources/js/alpine/$1',
        '^@/utils/(.*)$': '<rootDir>/resources/js/utils/$1',
        '^@/stores/(.*)$': '<rootDir>/resources/js/alpine/stores/$1',
        '^@/components/(.*)$': '<rootDir>/resources/js/alpine/components/$1'
    },
    
    // Test file patterns
    testMatch: [
        '<rootDir>/tests/javascript/**/*.test.js',
        '<rootDir>/tests/javascript/**/*.spec.js'
    ],
    
    // Coverage configuration
    collectCoverageFrom: [
        'resources/js/**/*.{js,ts}',
        '!resources/js/legacy/**',
        '!resources/js/types/**'
    ],
    
    // Coverage thresholds - Relaxed for now, will increase gradually
    coverageThreshold: {
        global: {
            branches: 60,
            functions: 60,
            lines: 60,
            statements: 60
        }
    },
    
    // Coverage reporting
    coverageReporters: ['text', 'html', 'lcov'],
    
    // Transform ES modules
    transform: {
        '^.+\\.js$': 'babel-jest'
    },
    
    // Verbose output for better debugging
    verbose: true,
    
    // Clear mocks between tests
    clearMocks: true,
    
    // Timeout for long-running tests
    testTimeout: 10000
};