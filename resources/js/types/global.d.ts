/**
 * Global Type Definitions for VetExams SaaS
 */

// Laravel Mix/Vite globals
declare const mix: any;

// Laravel CSRF Token
interface HTMLMetaElement {
    content: string;
}

// Global functions that may exist
declare global {
    interface Window {
        // Legacy functions for backward compatibility
        downloadExam?: (codigo: string) => void;
        viewExam?: (codigo: string) => void;
        showNotification?: (message: string, type: string) => void;
        
        // Unified toast system (legacy compatibility)
        showToast: (message: string, type?: 'success' | 'error' | 'warning' | 'info') => void;
        
        // Alpine.js available globally with typed stores
        Alpine: import('alpinejs').Alpine & {
            store(name: 'toast'): import('./alpine').ToastStore;
            store(name: 'theme'): import('./alpine').ThemeStore;  
            store(name: 'loading'): import('./alpine').LoadingStore;
            store<T>(name: string): T;
        };
        
        // Axios available globally
        axios: import('axios').AxiosInstance;
        
        // Performance monitoring
        webVitals?: any;
        performance?: Performance;
    }
}

// Exam data structure (from Laravel backend)
export interface ExamData {
    id: number;
    codigo: string;
    exam_date: string;
    status: 'pending' | 'ready' | 'completed';
    is_active: boolean;
    description?: string;
    pet_id: number;
    exam_type_id: number;
    client_id: number;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}

// Client data structure
export interface ClientData {
    id: number;
    name: string;
    cpf: string;
    email?: string;
    phone?: string;
    birth_date: string;
    address?: string;
    city?: string;
    state?: string;
    zip_code?: string;
    receive_email_notifications: boolean;
    receive_sms_notifications: boolean;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}

// Pet data structure
export interface PetData {
    id: number;
    name: string;
    species: string;
    breed?: string;
    birth_date?: string;
    client_id: number;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}

// Exam Type data structure
export interface ExamTypeData {
    id: number;
    name: string;
    color: string;
    clinic_id: number;
    created_at: string;
    updated_at: string;
}

// HTTP Response types
export interface ApiResponse<T = any> {
    success: boolean;
    data?: T;
    message?: string;
    errors?: Record<string, string[]>;
}

export interface PaginatedResponse<T = any> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

// Form validation types
export interface ValidationErrors {
    [key: string]: string[];
}

export interface FormState {
    submitting: boolean;
    errors: ValidationErrors;
    success: boolean;
}

export {};