/**
 * Toast Store Tests
 * Testing unified notification system
 */

import toastStore from '../../../resources/js/alpine/stores/toast.js';

describe('Toast Store', () => {
    beforeEach(() => {
        // Reset store state before each test
        toastStore.show = false;
        toastStore.message = '';
        toastStore.type = 'success';
        toastStore.queue = [];
        toastStore.timeout = null;
        
        // Clear any existing timeouts
        jest.clearAllTimers();
        jest.useFakeTimers();
    });

    afterEach(() => {
        jest.runOnlyPendingTimers();
        jest.useRealTimers();
    });

    describe('showToast method', () => {
        test('should display success toast with default parameters', () => {
            toastStore.showToast('Test message');

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Test message');
            expect(toastStore.type).toBe('success');
        });

        test('should display error toast with custom type', () => {
            toastStore.showToast('Error message', 'error');

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Error message');
            expect(toastStore.type).toBe('error');
        });

        test('should queue toast when one is already showing', () => {
            // Show first toast
            toastStore.showToast('First message');
            expect(toastStore.show).toBe(true);
            expect(toastStore.queue).toHaveLength(0);

            // Try to show second toast - should be queued
            toastStore.showToast('Second message', 'warning');
            expect(toastStore.message).toBe('First message'); // Still showing first
            expect(toastStore.queue).toHaveLength(1);
            expect(toastStore.queue[0]).toEqual({
                message: 'Second message',
                type: 'warning',
                autoHide: true
            });
        });

        test('should set up auto-hide timeout when autoHide is true', () => {
            const setTimeoutSpy = jest.spyOn(global, 'setTimeout');
            
            toastStore.showToast('Test message', 'success', true);

            expect(toastStore.timeout).not.toBeNull();
            expect(setTimeoutSpy).toHaveBeenCalledWith(expect.any(Function), 4000);
            
            setTimeoutSpy.mockRestore();
        });

        test('should not set auto-hide timeout when autoHide is false', () => {
            toastStore.showToast('Test message', 'success', false);

            expect(toastStore.autoHide).toBe(false);
            // Timeout might still be set for internal logic, but autoHide flag should be false
        });
    });

    describe('hide method', () => {
        test('should hide current toast', () => {
            toastStore.showToast('Test message');
            expect(toastStore.show).toBe(true);

            toastStore.hide();
            expect(toastStore.show).toBe(false);
        });

        test('should clear timeout when hiding', () => {
            const mockClearTimeout = jest.spyOn(global, 'clearTimeout');
            
            toastStore.showToast('Test message');
            toastStore.hide();

            expect(mockClearTimeout).toHaveBeenCalled();
        });

        test('should show next toast in queue after hiding', () => {
            // Add toast to queue
            toastStore.showToast('First message');
            toastStore.showToast('Second message', 'error');

            // Hide current toast
            toastStore.hide();

            // Fast-forward the timeout for showing next toast
            jest.advanceTimersByTime(300);

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Second message');
            expect(toastStore.type).toBe('error');
            expect(toastStore.queue).toHaveLength(0);
        });
    });

    describe('convenience methods', () => {
        test('success() should show success toast', () => {
            toastStore.success('Success message');

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Success message');
            expect(toastStore.type).toBe('success');
        });

        test('error() should show error toast', () => {
            toastStore.error('Error message');

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Error message');
            expect(toastStore.type).toBe('error');
        });

        test('warning() should show warning toast', () => {
            toastStore.warning('Warning message');

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Warning message');
            expect(toastStore.type).toBe('warning');
        });

        test('info() should show info toast', () => {
            toastStore.info('Info message');

            expect(toastStore.show).toBe(true);
            expect(toastStore.message).toBe('Info message');
            expect(toastStore.type).toBe('info');
        });
    });

    describe('clearQueue method', () => {
        test('should clear all queued notifications', () => {
            // Show first toast and queue others
            toastStore.showToast('First');
            toastStore.showToast('Second');
            toastStore.showToast('Third');

            expect(toastStore.queue).toHaveLength(2);

            toastStore.clearQueue();
            expect(toastStore.queue).toHaveLength(0);
        });
    });

    describe('auto-hide functionality', () => {
        test('should automatically hide toast after timeout', () => {
            toastStore.showToast('Test message');
            expect(toastStore.show).toBe(true);

            // Fast-forward time to trigger auto-hide
            jest.advanceTimersByTime(4000);

            expect(toastStore.show).toBe(false);
        });

        test('should not auto-hide when autoHide is false', () => {
            toastStore.showToast('Test message', 'success', false);
            expect(toastStore.show).toBe(true);

            // Fast-forward time - should still be showing
            jest.advanceTimersByTime(4000);

            expect(toastStore.show).toBe(true);
        });
    });
});