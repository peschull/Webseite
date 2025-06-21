/**
 * Navigation JavaScript - Mobile-First & Accessibility Optimized
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 * @version 2.0.0
 * @author WordPress Development Team
 * @description Handles mobile navigation, dropdowns, search, and accessibility features
 */

(function(window, document) {
    'use strict';
    
    // Configuration constants
    const CONFIG = {
        BREAKPOINT_MOBILE: 768,
        ANIMATION_DURATION: 300,
        TOUCH_THRESHOLD: 50,
        FOCUS_TIMEOUT: 300,
        SELECTORS: {
            mobileToggle: '.mobile-nav-toggle, .mobile-menu-toggle',
            mobileMenu: '.mobile-menu, .main-navigation',
            searchToggle: '.search-toggle',
            searchForm: '.search-form',
            searchInput: '.search-input, .search-field',
            siteHeader: '.site-header',
            dropdownParents: '.menu-item-has-children > a',
            focusableElements: 'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], input[type="email"], input[type="search"], select, [tabindex]:not([tabindex="-1"])'
        },
        CLASSES: {
            active: 'active',
            open: 'open',
            sticky: 'sticky',
            hidden: 'header-hidden',
            menuOpen: 'mobile-menu-open',
            dropdownOpen: 'dropdown-open'
        },
        ARIA: {
            expanded: 'aria-expanded',
            controls: 'aria-controls',
            label: 'aria-label',
            hidden: 'aria-hidden'
        }
    };
    
    // Utility functions
    const utils = {
        // Debug logging
        log: function(message, data = null) {
            if (window.console && window.console.log) {
                console.log('[Navigation] ' + message, data || '');
            }
        },
        
        // Error logging
        error: function(message, error = null) {
            if (window.console && window.console.error) {
                console.error('[Navigation Error] ' + message, error || '');
            }
        },
        
        // Check if element exists and is visible
        isElementVisible: function(element) {
            if (!element) return false;
            const style = window.getComputedStyle(element);
            return style.display !== 'none' && style.visibility !== 'hidden' && style.opacity !== '0';
        },
        
        // Safely add event listener
        addEvent: function(element, event, handler, options = false) {
            if (element && typeof handler === 'function') {
                try {
                    element.addEventListener(event, handler, options);
                    return true;
                } catch (e) {
                    utils.error('Failed to add event listener: ' + event, e);
                    return false;
                }
            }
            return false;
        },
        
        // Safely remove event listener
        removeEvent: function(element, event, handler, options = false) {
            if (element && typeof handler === 'function') {
                try {
                    element.removeEventListener(event, handler, options);
                    return true;
                } catch (e) {
                    utils.error('Failed to remove event listener: ' + event, e);
                    return false;
                }
            }
            return false;
        },
        
        // Throttle function for performance
        throttle: function(func, limit) {
            let inThrottle;
            return function(...args) {
                if (!inThrottle) {
                    func.apply(this, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },
        
        // Debounce function for performance
        debounce: function(func, wait, immediate) {
            let timeout;
            return function(...args) {
                const later = () => {
                    timeout = null;
                    if (!immediate) func.apply(this, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(this, args);
            };
        }
    };
    // Mobile Navigation Class
    class MobileNavigation {
        constructor() {
            this.isInitialized = false;
            this.isOpen = false;
            this.focusTrap = null;
            this.touchStart = { x: 0, y: 0 };
            
            // Find elements
            this.toggle = document.querySelector(CONFIG.SELECTORS.mobileToggle);
            this.menu = document.querySelector(CONFIG.SELECTORS.mobileMenu);
            this.body = document.body;
            
            // Bind methods
            this.handleToggleClick = this.handleToggleClick.bind(this);
            this.handleKeydown = this.handleKeydown.bind(this);
            this.handleOutsideClick = this.handleOutsideClick.bind(this);
            this.handleResize = this.handleResize.bind(this);
            this.handleTouchStart = this.handleTouchStart.bind(this);
            this.handleTouchMove = this.handleTouchMove.bind(this);
            
            this.init();
        }
        
        init() {
            if (this.isInitialized || !this.toggle || !this.menu) {
                if (!this.toggle) utils.error('Mobile toggle not found');
                if (!this.menu) utils.error('Mobile menu not found');
                return false;
            }
            
            try {
                this.setupToggle();
                this.setupMenu();
                this.bindEvents();
                this.isInitialized = true;
                utils.log('Mobile navigation initialized successfully');
                return true;
            } catch (error) {
                utils.error('Failed to initialize mobile navigation', error);
                return false;
            }
        }
        
        setupToggle() {
            // Set ARIA attributes
            this.toggle.setAttribute(CONFIG.ARIA.expanded, 'false');
            this.toggle.setAttribute(CONFIG.ARIA.controls, 'mobile-menu');
            this.toggle.setAttribute(CONFIG.ARIA.label, 'Hauptmenü öffnen');
            
            // Ensure hamburger icon exists
            if (!this.toggle.querySelector('span')) {
                this.toggle.innerHTML = '<span></span><span></span><span></span>';
            }
            
            // Add role if not present
            if (!this.toggle.getAttribute('role')) {
                this.toggle.setAttribute('role', 'button');
            }
        }
        
        setupMenu() {
            // Set ID for ARIA
            if (!this.menu.id) {
                this.menu.setAttribute('id', 'mobile-menu');
            }
            
            // Set initial ARIA state
            this.menu.setAttribute(CONFIG.ARIA.hidden, 'true');
            
            // Ensure menu has proper role
            if (!this.menu.getAttribute('role')) {
                this.menu.setAttribute('role', 'navigation');
            }
        }
        
        bindEvents() {
            // Toggle click
            utils.addEvent(this.toggle, 'click', this.handleToggleClick);
            
            // Keyboard navigation
            utils.addEvent(document, 'keydown', this.handleKeydown);
            
            // Outside click
            utils.addEvent(document, 'click', this.handleOutsideClick);
            
            // Window resize
            utils.addEvent(window, 'resize', utils.debounce(this.handleResize, 250));
            
            // Touch events for mobile
            if ('ontouchstart' in window) {
                utils.addEvent(this.menu, 'touchstart', this.handleTouchStart, { passive: true });
                utils.addEvent(this.menu, 'touchmove', this.handleTouchMove, { passive: false });
            }
        }
        
        handleToggleClick(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        }
        
        handleKeydown(e) {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
                this.toggle.focus();
            }
        }
        
        handleOutsideClick(e) {
            if (this.isOpen && 
                !this.menu.contains(e.target) && 
                !this.toggle.contains(e.target)) {
                this.close();
            }
        }
        
        handleResize() {
            if (window.innerWidth > CONFIG.BREAKPOINT_MOBILE && this.isOpen) {
                this.close();
            }
        }
        
        handleTouchStart(e) {
            this.touchStart.x = e.touches[0].clientX;
            this.touchStart.y = e.touches[0].clientY;
        }
        
        handleTouchMove(e) {
            if (!this.isOpen) return;
            
            const touchEnd = {
                x: e.touches[0].clientX,
                y: e.touches[0].clientY
            };
            
            const deltaX = touchEnd.x - this.touchStart.x;
            const deltaY = touchEnd.y - this.touchStart.y;
            
            // Close menu on swipe up
            if (deltaY < -CONFIG.TOUCH_THRESHOLD && Math.abs(deltaX) < CONFIG.TOUCH_THRESHOLD) {
                e.preventDefault();
                this.close();
            }
        }
        
        open() {
            try {
                this.menu.classList.add(CONFIG.CLASSES.active);
                this.toggle.classList.add(CONFIG.CLASSES.active);
                this.body.classList.add(CONFIG.CLASSES.menuOpen);
                
                // Update ARIA attributes
                this.toggle.setAttribute(CONFIG.ARIA.expanded, 'true');
                this.toggle.setAttribute(CONFIG.ARIA.label, 'Hauptmenü schließen');
                this.menu.setAttribute(CONFIG.ARIA.hidden, 'false');
                
                // Prevent body scroll
                this.body.style.overflow = 'hidden';
                
                // Focus management
                setTimeout(() => {
                    const firstMenuItem = this.menu.querySelector('a');
                    if (firstMenuItem) {
                        firstMenuItem.focus();
                    }
                }, CONFIG.FOCUS_TIMEOUT);
                
                // Setup focus trap
                this.setupFocusTrap();
                
                this.isOpen = true;
                utils.log('Mobile menu opened');
                
            } catch (error) {
                utils.error('Failed to open mobile menu', error);
            }
        }
        
        close() {
            try {
                this.menu.classList.remove(CONFIG.CLASSES.active);
                this.toggle.classList.remove(CONFIG.CLASSES.active);
                this.body.classList.remove(CONFIG.CLASSES.menuOpen);
                
                // Update ARIA attributes
                this.toggle.setAttribute(CONFIG.ARIA.expanded, 'false');
                this.toggle.setAttribute(CONFIG.ARIA.label, 'Hauptmenü öffnen');
                this.menu.setAttribute(CONFIG.ARIA.hidden, 'true');
                
                // Restore body scroll
                this.body.style.overflow = '';
                
                // Remove focus trap
                this.removeFocusTrap();
                
                this.isOpen = false;
                utils.log('Mobile menu closed');
                
            } catch (error) {
                utils.error('Failed to close mobile menu', error);
            }
        }
        
        setupFocusTrap() {
            const focusableElements = this.menu.querySelectorAll(CONFIG.SELECTORS.focusableElements);
            
            if (focusableElements.length === 0) return;
            
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            this.focusTrap = (e) => {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstElement) {
                            lastElement.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastElement) {
                            firstElement.focus();
                            e.preventDefault();
                        }
                    }
                }
            };
            
            utils.addEvent(this.menu, 'keydown', this.focusTrap);
        }
        
        removeFocusTrap() {
            if (this.focusTrap) {
                utils.removeEvent(this.menu, 'keydown', this.focusTrap);
                this.focusTrap = null;
            }
        }
        
        destroy() {
            if (!this.isInitialized) return;
            
            // Remove event listeners
            utils.removeEvent(this.toggle, 'click', this.handleToggleClick);
            utils.removeEvent(document, 'keydown', this.handleKeydown);
            utils.removeEvent(document, 'click', this.handleOutsideClick);
            utils.removeEvent(window, 'resize', this.handleResize);
            
            if ('ontouchstart' in window) {
                utils.removeEvent(this.menu, 'touchstart', this.handleTouchStart);
                utils.removeEvent(this.menu, 'touchmove', this.handleTouchMove);
            }
            
            // Close menu if open
            if (this.isOpen) {
                this.close();
            }
            
            // Remove focus trap
            this.removeFocusTrap();
            
            this.isInitialized = false;
            utils.log('Mobile navigation destroyed');
        }
    }
    // Dropdown Menu Class
    class DropdownMenu {
        constructor() {
            this.isInitialized = false;
            this.dropdowns = [];
            
            this.handleDropdownClick = this.handleDropdownClick.bind(this);
            this.handleKeydown = this.handleKeydown.bind(this);
            this.handleOutsideClick = this.handleOutsideClick.bind(this);
            
            this.init();
        }
        
        init() {
            if (this.isInitialized) return false;
            
            try {
                this.setupDropdowns();
                this.bindEvents();
                this.isInitialized = true;
                utils.log('Dropdown menus initialized successfully');
                return true;
            } catch (error) {
                utils.error('Failed to initialize dropdown menus', error);
                return false;
            }
        }
        
        setupDropdowns() {
            const dropdownToggles = document.querySelectorAll(CONFIG.SELECTORS.dropdownParents);
            
            dropdownToggles.forEach((toggle) => {
                const parentItem = toggle.parentElement;
                const submenu = parentItem.querySelector('.sub-menu');
                
                if (!submenu) return;
                
                // Create dropdown button
                const dropdownButton = document.createElement('button');
                dropdownButton.className = 'dropdown-toggle';
                dropdownButton.type = 'button';
                dropdownButton.setAttribute(CONFIG.ARIA.expanded, 'false');
                dropdownButton.setAttribute(CONFIG.ARIA.label, 'Untermenü öffnen');
                dropdownButton.innerHTML = '<span class="dropdown-icon" aria-hidden="true">⌄</span>';
                
                // Insert button after the link
                toggle.parentNode.insertBefore(dropdownButton, toggle.nextSibling);
                
                // Store dropdown data
                this.dropdowns.push({
                    parent: parentItem,
                    button: dropdownButton,
                    submenu: submenu,
                    toggle: toggle,
                    isOpen: false
                });
                
                // Set initial ARIA state
                submenu.setAttribute(CONFIG.ARIA.hidden, 'true');
                submenu.setAttribute('role', 'menu');
                
                // Set submenu items role
                const submenuItems = submenu.querySelectorAll('a');
                submenuItems.forEach(item => {
                    item.setAttribute('role', 'menuitem');
                });
            });
        }
        
        bindEvents() {
            // Click events for dropdown buttons
            this.dropdowns.forEach(dropdown => {
                utils.addEvent(dropdown.button, 'click', (e) => {
                    this.handleDropdownClick(e, dropdown);
                });
                
                utils.addEvent(dropdown.parent, 'keydown', (e) => {
                    this.handleKeydown(e, dropdown);
                });
            });
            
            // Outside click
            utils.addEvent(document, 'click', this.handleOutsideClick);
        }
        
        handleDropdownClick(e, dropdown) {
            e.preventDefault();
            e.stopPropagation();
            
            if (dropdown.isOpen) {
                this.closeDropdown(dropdown);
            } else {
                this.openDropdown(dropdown);
            }
        }
        
        handleKeydown(e, dropdown) {
            switch (e.key) {
                case 'Escape':
                    if (dropdown.isOpen) {
                        this.closeDropdown(dropdown);
                        dropdown.button.focus();
                    }
                    break;
                case 'ArrowDown':
                    if (!dropdown.isOpen) {
                        e.preventDefault();
                        this.openDropdown(dropdown);
                    } else {
                        e.preventDefault();
                        this.focusNextMenuItem(dropdown);
                    }
                    break;
                case 'ArrowUp':
                    if (dropdown.isOpen) {
                        e.preventDefault();
                        this.focusPrevMenuItem(dropdown);
                    }
                    break;
                case 'Enter':
                case ' ':
                    if (e.target === dropdown.button) {
                        e.preventDefault();
                        this.handleDropdownClick(e, dropdown);
                    }
                    break;
            }
        }
        
        handleOutsideClick(e) {
            if (!e.target.closest('.menu-item-has-children')) {
                this.closeAllDropdowns();
            }
        }
        
        openDropdown(dropdown) {
            try {
                // Close other dropdowns first
                this.closeAllDropdowns();
                
                dropdown.parent.classList.add(CONFIG.CLASSES.dropdownOpen);
                dropdown.button.setAttribute(CONFIG.ARIA.expanded, 'true');
                dropdown.button.setAttribute(CONFIG.ARIA.label, 'Untermenü schließen');
                dropdown.submenu.setAttribute(CONFIG.ARIA.hidden, 'false');
                dropdown.isOpen = true;
                
                // Focus first submenu item
                const firstItem = dropdown.submenu.querySelector('a');
                if (firstItem) {
                    setTimeout(() => {
                        firstItem.focus();
                    }, CONFIG.FOCUS_TIMEOUT);
                }
                
                utils.log('Dropdown opened');
                
            } catch (error) {
                utils.error('Failed to open dropdown', error);
            }
        }
        
        closeDropdown(dropdown) {
            try {
                dropdown.parent.classList.remove(CONFIG.CLASSES.dropdownOpen);
                dropdown.button.setAttribute(CONFIG.ARIA.expanded, 'false');
                dropdown.button.setAttribute(CONFIG.ARIA.label, 'Untermenü öffnen');
                dropdown.submenu.setAttribute(CONFIG.ARIA.hidden, 'true');
                dropdown.isOpen = false;
                
                utils.log('Dropdown closed');
                
            } catch (error) {
                utils.error('Failed to close dropdown', error);
            }
        }
        
        closeAllDropdowns() {
            this.dropdowns.forEach(dropdown => {
                if (dropdown.isOpen) {
                    this.closeDropdown(dropdown);
                }
            });
        }
        
        focusNextMenuItem(dropdown) {
            const menuItems = dropdown.submenu.querySelectorAll('a');
            const currentIndex = Array.from(menuItems).indexOf(document.activeElement);
            const nextIndex = (currentIndex + 1) % menuItems.length;
            menuItems[nextIndex].focus();
        }
        
        focusPrevMenuItem(dropdown) {
            const menuItems = dropdown.submenu.querySelectorAll('a');
            const currentIndex = Array.from(menuItems).indexOf(document.activeElement);
            const prevIndex = currentIndex <= 0 ? menuItems.length - 1 : currentIndex - 1;
            menuItems[prevIndex].focus();
        }
        
        destroy() {
            if (!this.isInitialized) return;
            
            // Remove all dropdown buttons and event listeners
            this.dropdowns.forEach(dropdown => {
                utils.removeEvent(dropdown.button, 'click', this.handleDropdownClick);
                utils.removeEvent(dropdown.parent, 'keydown', this.handleKeydown);
                
                if (dropdown.button.parentNode) {
                    dropdown.button.parentNode.removeChild(dropdown.button);
                }
            });
            
            utils.removeEvent(document, 'click', this.handleOutsideClick);
            
            this.dropdowns = [];
            this.isInitialized = false;
            utils.log('Dropdown menus destroyed');
        }
    }
    // Sticky Navigation Class
    class StickyNavigation {
        constructor() {
            this.isInitialized = false;
            this.isSticky = false;
            this.lastScrollTop = 0;
            this.headerHeight = 0;
            
            this.header = document.querySelector(CONFIG.SELECTORS.siteHeader);
            
            this.handleScroll = utils.throttle(this.handleScroll.bind(this), 16); // ~60fps
            
            this.init();
        }
        
        init() {
            if (!this.header || this.isInitialized) {
                if (!this.header) utils.log('Site header not found for sticky navigation');
                return false;
            }
            
            try {
                this.headerHeight = this.header.offsetHeight;
                utils.addEvent(window, 'scroll', this.handleScroll, { passive: true });
                utils.addEvent(window, 'resize', utils.debounce(() => {
                    this.headerHeight = this.header.offsetHeight;
                }, 250));
                
                this.isInitialized = true;
                utils.log('Sticky navigation initialized successfully');
                return true;
            } catch (error) {
                utils.error('Failed to initialize sticky navigation', error);
                return false;
            }
        }
        
        handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            try {
                if (scrollTop > this.headerHeight) {
                    if (!this.isSticky) {
                        this.header.classList.add(CONFIG.CLASSES.sticky);
                        this.isSticky = true;
                    }
                    
                    // Hide/show header based on scroll direction
                    if (scrollTop > this.lastScrollTop && scrollTop > this.headerHeight * 2) {
                        // Scrolling down - hide header
                        this.header.classList.add(CONFIG.CLASSES.hidden);
                    } else {
                        // Scrolling up - show header
                        this.header.classList.remove(CONFIG.CLASSES.hidden);
                    }
                } else {
                    if (this.isSticky) {
                        this.header.classList.remove(CONFIG.CLASSES.sticky, CONFIG.CLASSES.hidden);
                        this.isSticky = false;
                    }
                }
                
                this.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Prevent negative values
                
            } catch (error) {
                utils.error('Error in scroll handler', error);
            }
        }
        
        destroy() {
            if (!this.isInitialized) return;
            
            utils.removeEvent(window, 'scroll', this.handleScroll);
            
            if (this.header) {
                this.header.classList.remove(CONFIG.CLASSES.sticky, CONFIG.CLASSES.hidden);
            }
            
            this.isInitialized = false;
            utils.log('Sticky navigation destroyed');
        }
    }
    
    // Search Toggle Class
    class SearchToggle {
        constructor() {
            this.isInitialized = false;
            this.isOpen = false;
            
            this.toggle = document.querySelector(CONFIG.SELECTORS.searchToggle);
            this.form = document.querySelector(CONFIG.SELECTORS.searchForm);
            this.input = document.querySelector(CONFIG.SELECTORS.searchInput);
            
            this.handleToggleClick = this.handleToggleClick.bind(this);
            this.handleKeydown = this.handleKeydown.bind(this);
            this.handleOutsideClick = this.handleOutsideClick.bind(this);
            
            this.init();
        }
        
        init() {
            if (!this.toggle || !this.form || this.isInitialized) {
                if (!this.toggle) utils.log('Search toggle not found');
                if (!this.form) utils.log('Search form not found');
                return false;
            }
            
            try {
                this.setupToggle();
                this.bindEvents();
                this.isInitialized = true;
                utils.log('Search toggle initialized successfully');
                return true;
            } catch (error) {
                utils.error('Failed to initialize search toggle', error);
                return false;
            }
        }
        
        setupToggle() {
            this.toggle.setAttribute(CONFIG.ARIA.expanded, 'false');
            this.toggle.setAttribute(CONFIG.ARIA.controls, 'search-form');
            
            if (!this.toggle.getAttribute('role')) {
                this.toggle.setAttribute('role', 'button');
            }
            
            if (!this.form.id) {
                this.form.setAttribute('id', 'search-form');
            }
        }
        
        bindEvents() {
            utils.addEvent(this.toggle, 'click', this.handleToggleClick);
            utils.addEvent(document, 'keydown', this.handleKeydown);
            utils.addEvent(document, 'click', this.handleOutsideClick);
        }
        
        handleToggleClick(e) {
            e.preventDefault();
            
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        }
        
        handleKeydown(e) {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
                this.toggle.focus();
            }
        }
        
        handleOutsideClick(e) {
            if (this.isOpen && 
                !this.form.contains(e.target) && 
                !this.toggle.contains(e.target)) {
                this.close();
            }
        }
        
        open() {
            try {
                this.form.classList.add(CONFIG.CLASSES.active);
                this.toggle.setAttribute(CONFIG.ARIA.expanded, 'true');
                this.isOpen = true;
                
                if (this.input) {
                    setTimeout(() => {
                        this.input.focus();
                    }, CONFIG.FOCUS_TIMEOUT);
                }
                
                utils.log('Search opened');
                
            } catch (error) {
                utils.error('Failed to open search', error);
            }
        }
        
        close() {
            try {
                this.form.classList.remove(CONFIG.CLASSES.active);
                this.toggle.setAttribute(CONFIG.ARIA.expanded, 'false');
                this.isOpen = false;
                
                utils.log('Search closed');
                
            } catch (error) {
                utils.error('Failed to close search', error);
            }
        }
        
        destroy() {
            if (!this.isInitialized) return;
            
            utils.removeEvent(this.toggle, 'click', this.handleToggleClick);
            utils.removeEvent(document, 'keydown', this.handleKeydown);
            utils.removeEvent(document, 'click', this.handleOutsideClick);
            
            if (this.isOpen) {
                this.close();
            }
            
            this.isInitialized = false;
            utils.log('Search toggle destroyed');
        }
    }
    // Main Navigation Manager
    class NavigationManager {
        constructor() {
            this.components = {};
            this.isInitialized = false;
        }
        
        init() {
            if (this.isInitialized) {
                utils.log('Navigation already initialized');
                return false;
            }
            
            try {
                utils.log('Initializing navigation components...');
                
                // Initialize components
                this.components.mobileNav = new MobileNavigation();
                this.components.dropdownMenu = new DropdownMenu();
                this.components.stickyNav = new StickyNavigation();
                this.components.searchToggle = new SearchToggle();
                
                // Setup global event listeners
                this.setupGlobalEvents();
                
                this.isInitialized = true;
                utils.log('Navigation system initialized successfully');
                
                // Fire custom event
                this.dispatchEvent('navigationInit');
                
                return true;
            } catch (error) {
                utils.error('Failed to initialize navigation system', error);
                return false;
            }
        }
        
        setupGlobalEvents() {
            // Handle page visibility changes
            utils.addEvent(document, 'visibilitychange', () => {
                if (document.hidden) {
                    // Close all open menus when page becomes hidden
                    this.closeAllMenus();
                }
            });
            
            // Handle orientation changes on mobile
            utils.addEvent(window, 'orientationchange', utils.debounce(() => {
                this.closeAllMenus();
                // Recalculate positions after orientation change
                setTimeout(() => {
                    if (this.components.stickyNav) {
                        this.components.stickyNav.headerHeight = 
                            document.querySelector(CONFIG.SELECTORS.siteHeader)?.offsetHeight || 0;
                    }
                }, 500);
            }, 250));
            
            // Handle reduced motion preference
            if (window.matchMedia) {
                const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
                if (mediaQuery.matches) {
                    document.documentElement.style.setProperty('--animation-duration', '0ms');
                }
                
                mediaQuery.addEventListener('change', (e) => {
                    if (e.matches) {
                        document.documentElement.style.setProperty('--animation-duration', '0ms');
                    } else {
                        document.documentElement.style.removeProperty('--animation-duration');
                    }
                });
            }
        }
        
        closeAllMenus() {
            try {
                if (this.components.mobileNav && this.components.mobileNav.isOpen) {
                    this.components.mobileNav.close();
                }
                
                if (this.components.dropdownMenu) {
                    this.components.dropdownMenu.closeAllDropdowns();
                }
                
                if (this.components.searchToggle && this.components.searchToggle.isOpen) {
                    this.components.searchToggle.close();
                }
            } catch (error) {
                utils.error('Error closing menus', error);
            }
        }
        
        dispatchEvent(eventName, detail = {}) {
            try {
                const event = new CustomEvent(`navigation:${eventName}`, {
                    detail: detail,
                    bubbles: true,
                    cancelable: true
                });
                document.dispatchEvent(event);
            } catch (error) {
                utils.error('Failed to dispatch event: ' + eventName, error);
            }
        }
        
        destroy() {
            if (!this.isInitialized) return;
            
            utils.log('Destroying navigation system...');
            
            // Destroy all components
            Object.values(this.components).forEach(component => {
                if (component && typeof component.destroy === 'function') {
                    component.destroy();
                }
            });
            
            this.components = {};
            this.isInitialized = false;
            
            // Fire custom event
            this.dispatchEvent('navigationDestroy');
            
            utils.log('Navigation system destroyed');
        }
        
        // Public API methods
        getComponent(name) {
            return this.components[name] || null;
        }
        
        isComponentInitialized(name) {
            const component = this.components[name];
            return component ? component.isInitialized : false;
        }
        
        reinitialize() {
            this.destroy();
            return this.init();
        }
    }
    
    // Create global instance
    let navigationManager = null;
    
    // Initialize function
    function init() {
        if (navigationManager) {
            utils.log('Navigation already exists, skipping initialization');
            return navigationManager;
        }
        
        try {
            navigationManager = new NavigationManager();
            navigationManager.init();
            
            // Expose to global scope for debugging
            if (window.console) {
                window.VereinMenschlichkeitNavigation = navigationManager;
            }
            
            return navigationManager;
        } catch (error) {
            utils.error('Failed to create navigation manager', error);
            return null;
        }
    }
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        utils.addEvent(document, 'DOMContentLoaded', init);
    } else {
        // DOM is already ready
        init();
    }
    
    // Handle page unload
    utils.addEvent(window, 'beforeunload', () => {
        if (navigationManager) {
            navigationManager.destroy();
        }
    });
    
    // Export for module systems
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = { NavigationManager, init };
    } else if (typeof define === 'function' && define.amd) {
        define([], () => ({ NavigationManager, init }));
    }
    
})(window, document);
