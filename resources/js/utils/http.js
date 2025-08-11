/**
 * HTTP Utilities
 * Axios configuration with CSRF token support and security enhancements
 */

import axios from 'axios';
import { secureFetch } from './security.js';

// Configure axios defaults
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add CSRF token to all requests
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}

// Request interceptor
axios.interceptors.request.use(
    (config) => {
        // Show loading indicator for requests
        if (config.showLoading !== false) {
            window.Alpine?.store('loading')?.setGlobal(true);
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Response interceptor
axios.interceptors.response.use(
    (response) => {
        // Hide loading indicator
        window.Alpine?.store('loading')?.setGlobal(false);
        return response;
    },
    (error) => {
        // Hide loading indicator
        window.Alpine?.store('loading')?.setGlobal(false);
        
        // Handle common errors
        if (error.response?.status === 419) {
            // CSRF token mismatch
            window.Alpine?.store('toast')?.error('Sessão expirada. Recarregue a página.');
            setTimeout(() => window.location.reload(), 2000);
        } else if (error.response?.status === 403) {
            // Forbidden - possible security issue
            window.Alpine?.store('toast')?.error('Acesso negado.');
        } else if (error.response?.status >= 500) {
            // Server errors
            window.Alpine?.store('toast')?.error('Erro interno do servidor. Tente novamente.');
        }
        
        return Promise.reject(error);
    }
);

// Export secure fetch as alternative
export { secureFetch };

export default axios;