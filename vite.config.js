import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '@/alpine': '/resources/js/alpine',
            '@/utils': '/resources/js/utils',
            '@/components': '/resources/js/alpine/components',
            '@/stores': '/resources/js/alpine/stores',
            '@/types': '/resources/js/types'
        }
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    // Alpine.js and related components
                    if (id.includes('alpinejs')) {
                        return 'alpine';
                    }
                    
                    // Vendor libraries
                    if (id.includes('axios')) {
                        return 'vendor';
                    }
                    
                    // Alpine stores (small but frequent)
                    if (id.includes('/stores/')) {
                        return 'stores';
                    }
                    
                    // Alpine components by area
                    if (id.includes('/components/admin/')) {
                        return 'admin-components';
                    }
                    
                    if (id.includes('/components/client/')) {
                        return 'client-components';
                    }
                    
                    if (id.includes('/components/shared/')) {
                        return 'shared-components';
                    }
                    
                    // Utilities
                    if (id.includes('/utils/')) {
                        return 'utils';
                    }
                    
                    // Node modules
                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }
                }
            }
        },
        target: 'es2020',
        minify: 'terser',
        sourcemap: process.env.NODE_ENV === 'development',
        reportCompressedSize: true,
        chunkSizeWarningLimit: 1000,
        cssCodeSplit: true,
        assetsInlineLimit: 4096, // Inline assets smaller than 4kb
        terserOptions: {
            compress: {
                drop_console: process.env.NODE_ENV === 'production',
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.debug']
            },
            format: {
                comments: false
            }
        }
    },
    optimizeDeps: {
        include: ['alpinejs', 'axios'],
        force: false
    },
    esbuild: {
        // Enable TypeScript support
        target: 'es2020',
        keepNames: true,
        legalComments: 'none'
    },
    server: {
        hmr: {
            overlay: true
        },
        fs: {
            strict: false
        }
    },
    preview: {
        port: 4173,
        strictPort: true
    },
    define: {
        __DEV__: process.env.NODE_ENV === 'development'
    }
});