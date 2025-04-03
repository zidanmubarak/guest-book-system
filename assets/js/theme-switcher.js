/**
 * Theme Switcher
 * Manages the light/dark mode switching
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get theme toggle button
    const themeToggle = document.getElementById('theme-toggle');
    
    // Get current theme from cookie or session
    let currentTheme = getCurrentTheme();
    
    // Set initial icons based on current theme
    updateThemeIcons(currentTheme);
    
    // Add click event to toggle button
    themeToggle.addEventListener('click', function() {
        // Toggle theme
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Update theme
        setTheme(newTheme);
        
        // Update current theme variable
        currentTheme = newTheme;
        
        // Update icons
        updateThemeIcons(newTheme);
    });
    
    /**
     * Get current theme from cookie or session
     * @returns {string} 'light' or 'dark'
     */
    function getCurrentTheme() {
        // Check session storage first (for non-logged in users)
        const sessionTheme = sessionStorage.getItem('theme');
        if (sessionTheme) {
            return sessionTheme;
        }
        
        // Check cookie
        const themeCookie = getCookie('theme');
        if (themeCookie) {
            return themeCookie;
        }
        
        // Check user preference if available
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        
        // Default to light
        return 'light';
    }
    
    /**
     * Set theme and save to cookie and session
     * @param {string} theme 'light' or 'dark'
     */
    function setTheme(theme) {
        // Save theme to session storage
        sessionStorage.setItem('theme', theme);
        
        // Save theme to cookie for 30 days
        const date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = `theme=${theme}; expires=${date.toUTCString()}; path=/`;
        
        // Set dark mode stylesheet
        const darkModeCss = document.getElementById('dark-mode-css');
        
        if (theme === 'dark') {
            if (!darkModeCss) {
                const head = document.head;
                const link = document.createElement('link');
                link.type = 'text/css';
                link.rel = 'stylesheet';
                link.id = 'dark-mode-css';
                link.href = BASE_URL + 'assets/css/dark-mode.css';
                head.appendChild(link);
            }
        } else {
            if (darkModeCss) {
                darkModeCss.remove();
            }
        }
        
        // If user is logged in, update theme preference via AJAX
        if (typeof USER_ID !== 'undefined' && USER_ID) {
            updateUserTheme(theme);
        }
    }
    
    /**
     * Update theme toggle icons based on current theme
     * @param {string} theme 'light' or 'dark'
     */
    function updateThemeIcons(theme) {
        const sunIcon = themeToggle.querySelector('.fa-sun');
        const moonIcon = themeToggle.querySelector('.fa-moon');
        
        if (theme === 'dark') {
            if (sunIcon && moonIcon) {
                sunIcon.classList.remove('d-none');
                moonIcon.classList.add('d-none');
            } else {
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
        } else {
            if (sunIcon && moonIcon) {
                sunIcon.classList.add('d-none');
                moonIcon.classList.remove('d-none');
            } else {
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }
    }
    
    /**
     * Update user theme preference via AJAX
     * @param {string} theme 'light' or 'dark'
     */
    function updateUserTheme(theme) {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Send AJAX request
        fetch(BASE_URL + 'settings/update_theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `theme=${theme}&csrf_token=${csrfToken || ''}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Theme updated:', data);
        })
        .catch(error => {
            console.error('Error updating theme:', error);
        });
    }
    
    /**
     * Get cookie value by name
     * @param {string} name Cookie name
     * @returns {string|null} Cookie value
     */
    function getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }
});

// Set base URL for assets
const BASE_URL = document.querySelector('base')?.getAttribute('href') || '/';

// Set user ID if logged in
const USER_ID = document.querySelector('meta[name="user-id"]')?.getAttribute('content') || null;