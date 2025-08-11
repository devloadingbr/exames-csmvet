/**
 * Alpine.js Type Definitions for VetExams SaaS
 * Extends Alpine.js with custom stores and components
 */

import { Alpine } from 'alpinejs';

declare global {
    interface Window {
        Alpine: typeof Alpine;
        axios: any;
    }
}

// Toast Store Interface
export interface ToastStore {
    show: boolean;
    message: string;
    type: 'success' | 'error' | 'warning' | 'info';
    queue: Array<{ message: string; type: string; autoHide: boolean }>;
    autoHide: boolean;
    timeout: number | null;
    
    showToast(message: string, type?: string, autoHide?: boolean): void;
    hide(): void;
    success(message: string): void;
    error(message: string): void;
    warning(message: string): void;
    info(message: string): void;
    clearQueue(): void;
}

// Theme Store Interface
export interface ThemeStore {
    darkMode: boolean;
    
    toggle(): void;
    set(isDark: boolean): void;
    apply(): void;
    save(): void;
    init(): void;
    
    readonly isDark: boolean;
    readonly isLight: boolean;
}

// Loading Store Interface
export interface LoadingStore {
    global: boolean;
    downloads: Record<string | number, boolean>;
    forms: Record<string, boolean>;
    requests: Record<string, boolean>;
    
    setGlobal(state: boolean): void;
    setDownload(examId: string | number, state: boolean): void;
    setForm(formId: string, state: boolean): void;
    setRequest(requestId: string, state: boolean): void;
    
    isDownloading(examId: string | number): boolean;
    isFormLoading(formId: string): boolean;
    isRequestLoading(requestId: string): boolean;
    
    readonly hasAnyLoading: boolean;
    clearAll(): void;
}

// Alpine Stores Interface
export interface AlpineStores {
    toast: ToastStore;
    theme: ThemeStore;
    loading: LoadingStore;
}

// Extend Alpine.js with our stores
declare module 'alpinejs' {
    interface Alpine {
        store<T extends keyof AlpineStores>(name: T): AlpineStores[T];
        store<T>(name: string): T;
    }
}

// Client Components Interfaces
export interface ClientFiltersData {
    filtersOpen: boolean;
    search: string;
    petFilter: string;
    typeFilter: string;
    dateFrom: string;
    dateTo: string;
    sortBy: string;
    sortDirection: string;
    
    init(): void;
    toggleFilters(): void;
    hasActiveFilters(): boolean;
    clearFilters(): void;
    submitFilters(): void;
    toggleSort(column: string): void;
    updateSortFields(): void;
    initFromURL(): void;
    
    readonly activeFiltersCount: number;
    getSortArrowClass(column: string): string;
}

export interface ClientDownloadsData {
    downloadExam(examCode: string, downloadUrl?: string | null): Promise<void>;
    viewExam(examCode: string): void;
    isDownloading(examCode: string): boolean;
}

export interface ClientProfileData {
    // Base profile component - extensible
}

export interface ClientNotificationSettingsData {
    emailNotifications: boolean;
    smsNotifications: boolean;
    updating: boolean;
    
    updateNotification(type: 'email' | 'sms', value: boolean): Promise<void>;
}

export interface ClientAnimatedStatsData {
    counters: Record<string, number>;
    
    init(): void;
    animateCounters(targets: Record<string, number>): void;
}

export interface ClientChartAnimationData {
    bars: number[];
    
    init(): void;
    animateCharts(): void;
}

// Admin Components Interfaces
export interface AdminDashboardData {
    refreshing: boolean;
    
    refreshData(): Promise<void>;
}

export interface AdminFormData {
    submitting: boolean;
    
    submit(): Promise<void>;
    readonly isSubmitting: boolean;
}

// Shared Components Interfaces
export interface SharedModalData {
    show: boolean;
    
    open(): void;
    close(): void;
    handleEscape(): void;
    handleBackdrop(): void;
}

export interface SharedDropdownData {
    open: boolean;
    
    toggle(): void;
    close(): void;
    handleClickAway(): void;
}

// Performance & Error Monitoring Interfaces
export interface PerformanceMetrics {
    LCP?: number;
    FID?: number;
    CLS?: number;
    TTFB?: number;
}

export interface ErrorBoundaryData {
    hasError: boolean;
    errorMessage: string;
    errorDetails: any;
    
    reportError(error: Error, componentInfo?: any): void;
    clearError(): void;
}

// HTTP Utility Interfaces
export interface HttpClientConfig {
    baseURL?: string;
    timeout?: number;
    headers?: Record<string, string>;
}

export interface HttpResponse<T = any> {
    data: T;
    status: number;
    statusText: string;
    headers: Record<string, string>;
}

// Storage Utility Interfaces
export interface StorageService {
    set(key: string, value: any, expires?: number): boolean;
    get(key: string, defaultValue?: any): any;
    remove(key: string): void;
    clear(): void;
    isAvailable(): boolean;
}

// Logger Utility Interfaces
export interface LoggerService {
    debug(message: string, ...args: any[]): void;
    info(message: string, ...args: any[]): void;
    warn(message: string, ...args: any[]): void;
    error(message: string, ...args: any[]): void;
    time(label: string): void;
    timeEnd(label: string): void;
    component(componentName: string, action: string, data?: any): void;
    api(method: string, url: string, data?: any): void;
}