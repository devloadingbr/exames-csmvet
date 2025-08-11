/**
 * Alpine.js Initialization
 * Central entry point for all Alpine.js functionality
 */

import Alpine from 'alpinejs';

// Import plugins
import ErrorBoundaryPlugin, { setupGlobalErrorHandlers } from './plugins/error-boundary.js';

// Import global stores
import toastStore from './stores/toast';
import themeStore from './stores/theme';
import loadingStore from './stores/loading.js';

// Import shared components
import './components/shared/modal.js';
import './components/shared/dropdown.js';

// Import admin-specific components
import './components/admin/dashboard.js';
import './components/admin/forms.js';

// Import client-specific components
import './components/client/filters.js';
import './components/client/downloads.js';
import './components/client/profile.js';

// Register plugins
Alpine.plugin(ErrorBoundaryPlugin);

// Setup global error handlers
setupGlobalErrorHandlers();

// Register global stores
Alpine.store('toast', toastStore);
Alpine.store('theme', themeStore);
Alpine.store('loading', loadingStore);

// Export Alpine for global access
window.Alpine = Alpine;

// Initialize Alpine.js
Alpine.start();

export default Alpine;