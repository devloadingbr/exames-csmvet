/**
 * ESLint Configuration for VetExams SaaS
 * Enterprise-grade linting setup
 */

import js from '@eslint/js';
import typescript from '@typescript-eslint/eslint-plugin';
import typescriptParser from '@typescript-eslint/parser';

export default [
    js.configs.recommended,
    {
        files: ['resources/js/**/*.{js,ts}'],
        languageOptions: {
            parser: typescriptParser,
            parserOptions: {
                ecmaVersion: 2020,
                sourceType: 'module',
            },
            globals: {
                Alpine: 'readonly',
                axios: 'readonly',
                window: 'readonly',
                document: 'readonly',
                console: 'readonly',
                process: 'readonly',
                navigator: 'readonly',
                localStorage: 'readonly',
                sessionStorage: 'readonly',
                fetch: 'readonly',
                setTimeout: 'readonly',
                clearTimeout: 'readonly',
                setInterval: 'readonly',
                clearInterval: 'readonly',
                gtag: 'readonly',
                analytics: 'readonly',
                // Browser APIs that were causing errors
                URLSearchParams: 'readonly',
                performance: 'readonly',
                PerformanceObserver: 'readonly',
                screen: 'readonly',
                // Additional browser globals
                location: 'readonly',
                history: 'readonly',
                requestAnimationFrame: 'readonly',
                cancelAnimationFrame: 'readonly',
                IntersectionObserver: 'readonly',
                MutationObserver: 'readonly'
            }
        },
        plugins: {
            '@typescript-eslint': typescript
        },
        rules: {
            // Error Prevention
            'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'warn',
            'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'warn',
            'no-unused-vars': 'error',
            'no-undef': 'error',
            'no-unreachable': 'error',
            'no-duplicate-imports': 'error',
            
            // Code Quality
            'prefer-const': 'error',
            'no-var': 'error',
            'eqeqeq': ['error', 'always'],
            'curly': ['error', 'all'],
            'no-eval': 'error',
            'no-implied-eval': 'error',
            
            // Style Consistency  
            'indent': ['error', 4],
            'quotes': ['error', 'single', { 'allowTemplateLiterals': true }],
            'semi': ['error', 'always'],
            'comma-dangle': ['error', 'never'],
            'object-curly-spacing': ['error', 'always'],
            'array-bracket-spacing': ['error', 'never'],
            
            // Alpine.js specific
            'no-unused-expressions': ['error', { 
                'allowShortCircuit': true, 
                'allowTernary': true 
            }],
            
            // Modern JavaScript
            'prefer-arrow-callback': 'error',
            'prefer-template': 'error',
            'template-curly-spacing': ['error', 'never'],
            
            // Error Handling
            'no-throw-literal': 'error',
            'prefer-promise-reject-errors': 'error',
            
            // Performance
            'no-loop-func': 'error',
            'no-inner-declarations': 'error'
        }
    },
    {
        // TypeScript definition files have different rules
        files: ['**/*.d.ts'],
        rules: {
            'no-unused-vars': 'off', // Type definitions often have unused parameters
            '@typescript-eslint/no-unused-vars': 'off',
            'no-undef': 'off', // Type definitions reference global types
            'no-console': 'off'
        }
    },
    {
        files: ['tests/**/*.{js,ts}'],
        languageOptions: {
            globals: {
                jest: 'readonly',
                describe: 'readonly',
                test: 'readonly',
                expect: 'readonly',
                beforeEach: 'readonly',
                afterEach: 'readonly',
                beforeAll: 'readonly',
                afterAll: 'readonly'
            }
        },
        rules: {
            // Relax some rules for tests
            'no-console': 'off',
            'prefer-arrow-callback': 'off'
        }
    },
    {
        files: ['*.config.js', 'vite.config.js', 'jest.config.js'],
        languageOptions: {
            globals: {
                module: 'readonly',
                require: 'readonly',
                __dirname: 'readonly',
                process: 'readonly'
            }
        },
        rules: {
            // Config files can be more relaxed
            'no-console': 'off'
        }
    },
    {
        ignores: [
            'public/**',
            'vendor/**',
            'node_modules/**',
            'storage/**',
            'bootstrap/cache/**',
            'resources/js/legacy/**' // Ignore legacy files
        ]
    }
];