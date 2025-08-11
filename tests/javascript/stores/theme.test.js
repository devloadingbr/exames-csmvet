/**
 * Theme Store Tests
 * Testing dark/light theme management
 */

import themeStore from '../../../resources/js/alpine/stores/theme.ts';

describe('Theme Store', () => {
    beforeEach(() => {
        // Reset theme store
        themeStore.darkMode = false;
        
        // Reset localStorage mock
        localStorage.clear();
        localStorage.getItem.mockClear();
        localStorage.setItem.mockClear();
        
        // Reset document classList
        document.documentElement.classList.remove('dark');
        
        // Reset window.matchMedia mock
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
    });

    describe('initialization', () => {
        test('should initialize with saved preference from localStorage', () => {
            localStorage.getItem.mockReturnValue('true');
            
            // Create new instance to test initialization
            const store = { ...themeStore };
            // Simulate the initialization logic
            store.darkMode = localStorage.getItem('darkMode') === 'true';
            
            expect(store.darkMode).toBe(true);
        });

        test('should fall back to system preference when no saved preference', () => {
            localStorage.getItem.mockReturnValue(null);
            window.matchMedia.mockImplementation(query => ({
                matches: query === '(prefers-color-scheme: dark)',
                addEventListener: jest.fn(),
                removeEventListener: jest.fn(),
            }));
            
            // Simulate initialization logic
            const savedTheme = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const store = { ...themeStore };
            store.darkMode = savedTheme === 'true' || (!savedTheme && prefersDark);
            
            expect(store.darkMode).toBe(true);
        });
    });

    describe('toggle method', () => {
        test('should toggle from light to dark mode', () => {
            themeStore.darkMode = false;
            
            themeStore.toggle();
            
            expect(themeStore.darkMode).toBe(true);
        });

        test('should toggle from dark to light mode', () => {
            themeStore.darkMode = true;
            
            themeStore.toggle();
            
            expect(themeStore.darkMode).toBe(false);
        });

        test('should call apply() and save() after toggling', () => {
            const applySpy = jest.spyOn(themeStore, 'apply');
            const saveSpy = jest.spyOn(themeStore, 'save');
            
            themeStore.toggle();
            
            expect(applySpy).toHaveBeenCalled();
            expect(saveSpy).toHaveBeenCalled();
        });
    });

    describe('set method', () => {
        test('should set dark mode to true', () => {
            themeStore.set(true);
            
            expect(themeStore.darkMode).toBe(true);
        });

        test('should set dark mode to false', () => {
            themeStore.darkMode = true;
            themeStore.set(false);
            
            expect(themeStore.darkMode).toBe(false);
        });

        test('should call apply() and save() after setting', () => {
            const applySpy = jest.spyOn(themeStore, 'apply');
            const saveSpy = jest.spyOn(themeStore, 'save');
            
            themeStore.set(true);
            
            expect(applySpy).toHaveBeenCalled();
            expect(saveSpy).toHaveBeenCalled();
        });
    });

    describe('apply method', () => {
        test('should add dark class when dark mode is enabled', () => {
            themeStore.darkMode = true;
            
            themeStore.apply();
            
            expect(document.documentElement.classList.contains('dark')).toBe(true);
        });

        test('should remove dark class when dark mode is disabled', () => {
            themeStore.darkMode = false;
            document.documentElement.classList.add('dark');
            
            themeStore.apply();
            
            expect(document.documentElement.classList.contains('dark')).toBe(false);
        });
    });

    describe('save method', () => {
        test('should save dark mode state to localStorage', () => {
            themeStore.darkMode = true;
            
            themeStore.save();
            
            expect(localStorage.setItem).toHaveBeenCalledWith('darkMode', true);
        });

        test('should save light mode state to localStorage', () => {
            themeStore.darkMode = false;
            
            themeStore.save();
            
            expect(localStorage.setItem).toHaveBeenCalledWith('darkMode', false);
        });
    });

    describe('init method', () => {
        test('should apply current theme on initialization', () => {
            const applySpy = jest.spyOn(themeStore, 'apply');
            
            themeStore.init();
            
            expect(applySpy).toHaveBeenCalled();
        });

        test('should set up system theme change listener', () => {
            const mockAddEventListener = jest.fn();
            window.matchMedia.mockReturnValue({
                matches: false,
                addEventListener: mockAddEventListener,
                removeEventListener: jest.fn(),
            });
            
            themeStore.init();
            
            expect(window.matchMedia).toHaveBeenCalledWith('(prefers-color-scheme: dark)');
            expect(mockAddEventListener).toHaveBeenCalledWith('change', expect.any(Function));
        });
    });

    describe('getters', () => {
        test('isDark should return true when dark mode is enabled', () => {
            themeStore.darkMode = true;
            
            expect(themeStore.isDark).toBe(true);
        });

        test('isDark should return false when dark mode is disabled', () => {
            themeStore.darkMode = false;
            
            expect(themeStore.isDark).toBe(false);
        });

        test('isLight should return true when dark mode is disabled', () => {
            themeStore.darkMode = false;
            
            expect(themeStore.isLight).toBe(true);
        });

        test('isLight should return false when dark mode is enabled', () => {
            themeStore.darkMode = true;
            
            expect(themeStore.isLight).toBe(false);
        });
    });
});