/**
 * Loading Store Tests
 * Testing global loading state management
 */

import loadingStore from '../../../resources/js/alpine/stores/loading.js';

describe('Loading Store', () => {
    beforeEach(() => {
        // Reset store state before each test
        loadingStore.global = false;
        loadingStore.downloads = {};
        loadingStore.forms = {};
        loadingStore.requests = {};
    });

    describe('global loading state', () => {
        test('should set global loading state to true', () => {
            loadingStore.setGlobal(true);
            
            expect(loadingStore.global).toBe(true);
        });

        test('should set global loading state to false', () => {
            loadingStore.global = true;
            loadingStore.setGlobal(false);
            
            expect(loadingStore.global).toBe(false);
        });
    });

    describe('download loading states', () => {
        test('should set download loading state', () => {
            loadingStore.setDownload('exam123', true);
            
            expect(loadingStore.downloads['exam123']).toBe(true);
        });

        test('should remove download loading state when set to false', () => {
            loadingStore.downloads['exam123'] = true;
            
            loadingStore.setDownload('exam123', false);
            
            expect(loadingStore.downloads['exam123']).toBeUndefined();
        });

        test('should check if specific download is loading', () => {
            loadingStore.downloads['exam123'] = true;
            
            expect(loadingStore.isDownloading('exam123')).toBe(true);
            expect(loadingStore.isDownloading('exam456')).toBe(false);
        });

        test('should handle numeric exam IDs', () => {
            loadingStore.setDownload(123, true);
            
            expect(loadingStore.isDownloading(123)).toBe(true);
            expect(loadingStore.downloads[123]).toBe(true);
        });
    });

    describe('form loading states', () => {
        test('should set form loading state', () => {
            loadingStore.setForm('loginForm', true);
            
            expect(loadingStore.forms['loginForm']).toBe(true);
        });

        test('should remove form loading state when set to false', () => {
            loadingStore.forms['loginForm'] = true;
            
            loadingStore.setForm('loginForm', false);
            
            expect(loadingStore.forms['loginForm']).toBeUndefined();
        });

        test('should check if specific form is loading', () => {
            loadingStore.forms['loginForm'] = true;
            
            expect(loadingStore.isFormLoading('loginForm')).toBe(true);
            expect(loadingStore.isFormLoading('registerForm')).toBe(false);
        });
    });

    describe('request loading states', () => {
        test('should set request loading state', () => {
            loadingStore.setRequest('userProfile', true);
            
            expect(loadingStore.requests['userProfile']).toBe(true);
        });

        test('should remove request loading state when set to false', () => {
            loadingStore.requests['userProfile'] = true;
            
            loadingStore.setRequest('userProfile', false);
            
            expect(loadingStore.requests['userProfile']).toBeUndefined();
        });

        test('should check if specific request is loading', () => {
            loadingStore.requests['userProfile'] = true;
            
            expect(loadingStore.isRequestLoading('userProfile')).toBe(true);
            expect(loadingStore.isRequestLoading('dashboard')).toBe(false);
        });
    });

    describe('hasAnyLoading getter', () => {
        test('should return true when global loading is active', () => {
            loadingStore.global = true;
            
            expect(loadingStore.hasAnyLoading).toBe(true);
        });

        test('should return true when any download is loading', () => {
            loadingStore.downloads['exam123'] = true;
            
            expect(loadingStore.hasAnyLoading).toBe(true);
        });

        test('should return true when any form is loading', () => {
            loadingStore.forms['loginForm'] = true;
            
            expect(loadingStore.hasAnyLoading).toBe(true);
        });

        test('should return true when any request is loading', () => {
            loadingStore.requests['userProfile'] = true;
            
            expect(loadingStore.hasAnyLoading).toBe(true);
        });

        test('should return false when nothing is loading', () => {
            expect(loadingStore.hasAnyLoading).toBe(false);
        });

        test('should return true when multiple things are loading', () => {
            loadingStore.global = true;
            loadingStore.downloads['exam123'] = true;
            loadingStore.forms['loginForm'] = true;
            
            expect(loadingStore.hasAnyLoading).toBe(true);
        });
    });

    describe('clearAll method', () => {
        test('should clear all loading states', () => {
            // Set up various loading states
            loadingStore.global = true;
            loadingStore.downloads['exam123'] = true;
            loadingStore.downloads['exam456'] = true;
            loadingStore.forms['loginForm'] = true;
            loadingStore.requests['userProfile'] = true;
            
            loadingStore.clearAll();
            
            expect(loadingStore.global).toBe(false);
            expect(loadingStore.downloads).toEqual({});
            expect(loadingStore.forms).toEqual({});
            expect(loadingStore.requests).toEqual({});
            expect(loadingStore.hasAnyLoading).toBe(false);
        });

        test('should work when nothing is loading', () => {
            expect(() => loadingStore.clearAll()).not.toThrow();
            expect(loadingStore.hasAnyLoading).toBe(false);
        });
    });

    describe('integration scenarios', () => {
        test('should handle multiple downloads simultaneously', () => {
            loadingStore.setDownload('exam1', true);
            loadingStore.setDownload('exam2', true);
            loadingStore.setDownload('exam3', true);
            
            expect(loadingStore.isDownloading('exam1')).toBe(true);
            expect(loadingStore.isDownloading('exam2')).toBe(true);
            expect(loadingStore.isDownloading('exam3')).toBe(true);
            expect(loadingStore.hasAnyLoading).toBe(true);
            
            // Complete one download
            loadingStore.setDownload('exam1', false);
            
            expect(loadingStore.isDownloading('exam1')).toBe(false);
            expect(loadingStore.hasAnyLoading).toBe(true); // Others still loading
        });

        test('should handle mixed loading types', () => {
            loadingStore.setDownload('exam123', true);
            loadingStore.setForm('profileForm', true);
            loadingStore.setRequest('dashboard', true);
            
            expect(loadingStore.hasAnyLoading).toBe(true);
            
            // Clear downloads
            loadingStore.setDownload('exam123', false);
            expect(loadingStore.hasAnyLoading).toBe(true); // Form and request still loading
            
            // Clear form
            loadingStore.setForm('profileForm', false);
            expect(loadingStore.hasAnyLoading).toBe(true); // Request still loading
            
            // Clear request
            loadingStore.setRequest('dashboard', false);
            expect(loadingStore.hasAnyLoading).toBe(false); // Nothing loading
        });
    });
});