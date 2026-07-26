/**
 * VRM SHARE BROKING PVT. LTD. - ACCESSIBILITY & INTERACTIVITY ENGINE
 * WCAG 2.2 Level AA Standard Compliant
 */

(function () {
  'use strict';

  // State Variables
  let currentFontScale = 100;
  let activeModalTrigger = null;

  document.addEventListener('DOMContentLoaded', function () {
    initAccessibilityToolbar();
    initModalDialog();
    initDropdownNavigation();
    initMobileMenu();
    initKeyboardUtilities();
  });

  /* ==========================================================================
     1. ACCESSIBILITY TOOLBAR (FONT RESIZER & HIGH CONTRAST THEMES)
     ========================================================================== */
  function initAccessibilityToolbar() {
    const fontIncreaseBtn = document.getElementById('font-increase');
    const fontResetBtn = document.getElementById('font-reset');
    const fontDecreaseBtn = document.getElementById('font-decrease');
    const themeButtons = document.querySelectorAll('[data-theme-set]');

    if (fontIncreaseBtn) {
      fontIncreaseBtn.addEventListener('click', function () {
        changeFontSize(10);
      });
    }

    if (fontResetBtn) {
      fontResetBtn.addEventListener('click', function () {
        setFontSize(100);
      });
    }

    if (fontDecreaseBtn) {
      fontDecreaseBtn.addEventListener('click', function () {
        changeFontSize(-10);
      });
    }

    // Theme Switchers
    themeButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        const theme = this.getAttribute('data-theme-set');
        setTheme(theme, this);
      });
    });
  }

  function changeFontSize(delta) {
    currentFontScale = Math.min(Math.max(currentFontScale + delta, 90), 140);
    setFontSize(currentFontScale);
  }

  function setFontSize(sizePercent) {
    currentFontScale = sizePercent;
    document.documentElement.style.setProperty('--base-font-size', currentFontScale + '%');
    
    // Announce font change to screen readers via aria-live region if available
    announceToScreenReader(`Font size changed to ${currentFontScale} percent`);
  }

  function setTheme(themeName, activeBtn) {
    if (themeName === 'default') {
      document.documentElement.removeAttribute('data-theme');
    } else {
      document.documentElement.setAttribute('data-theme', themeName);
    }

    // Update aria-pressed states on theme buttons
    const themeButtons = document.querySelectorAll('[data-theme-set]');
    themeButtons.forEach(function (btn) {
      btn.setAttribute('aria-pressed', 'false');
    });

    if (activeBtn) {
      activeBtn.setAttribute('aria-pressed', 'true');
    }

    announceToScreenReader(`Theme changed to ${themeName}`);
  }

  /* ==========================================================================
     2. ACCESSIBLE MODAL DIALOG (RULE #26)
     ========================================================================== */
  function initModalDialog() {
    const modalOverlay = document.getElementById('risk-modal');
    const openModalBtn = document.getElementById('open-risk-modal');
    const closeModalBtn = document.getElementById('close-risk-modal');
    const dismissModalBtn = document.getElementById('dismiss-risk-modal');

    if (!modalOverlay) return;

    if (openModalBtn) {
      openModalBtn.addEventListener('click', function () {
        openModal(modalOverlay, openModalBtn);
      });
    }

    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', function () {
        closeModal(modalOverlay);
      });
    }

    if (dismissModalBtn) {
      dismissModalBtn.addEventListener('click', function () {
        closeModal(modalOverlay);
      });
    }

    // Auto open modal on load if not previously dismissed
    if (!sessionStorage.getItem('vrm_risk_disclosure_dismissed')) {
      setTimeout(function () {
        openModal(modalOverlay, null);
      }, 500);
    }
  }

  function openModal(modalOverlay, triggerElement) {
    activeModalTrigger = triggerElement || document.activeElement;
    modalOverlay.classList.add('is-active');
    modalOverlay.setAttribute('aria-hidden', 'false');

    // Trap focus inside modal
    const focusableElements = getFocusableElements(modalOverlay);
    if (focusableElements.length > 0) {
      focusableElements[0].focus();
    }

    document.addEventListener('keydown', handleModalKeyDown);
    document.body.style.overflow = 'hidden';
  }

  function closeModal(modalOverlay) {
    modalOverlay.classList.remove('is-active');
    modalOverlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    document.removeEventListener('keydown', handleModalKeyDown);

    sessionStorage.setItem('vrm_risk_disclosure_dismissed', 'true');

    if (activeModalTrigger && typeof activeModalTrigger.focus === 'function') {
      activeModalTrigger.focus();
    }
  }

  function handleModalKeyDown(e) {
    const modalOverlay = document.getElementById('risk-modal');
    if (!modalOverlay || !modalOverlay.classList.contains('is-active')) return;

    if (e.key === 'Escape') {
      closeModal(modalOverlay);
      return;
    }

    if (e.key === 'Tab') {
      const focusable = getFocusableElements(modalOverlay);
      if (focusable.length === 0) return;

      const firstFocusable = focusable[0];
      const lastFocusable = focusable[focusable.length - 1];

      if (e.shiftKey) {
        if (document.activeElement === firstFocusable) {
          lastFocusable.focus();
          e.preventDefault();
        }
      } else {
        if (document.activeElement === lastFocusable) {
          firstFocusable.focus();
          e.preventDefault();
        }
      }
    }
  }

  /* ==========================================================================
     3. KEYBOARD ACCESSIBLE DROPDOWN NAVIGATION (RULE #2, #27)
     ========================================================================== */
  function initDropdownNavigation() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(function (toggle) {
      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        const expanded = this.getAttribute('aria-expanded') === 'true';
        toggleDropdown(this, !expanded);
      });

      toggle.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggleDropdown(this, true);
          const menu = document.getElementById(this.getAttribute('aria-controls'));
          if (menu) {
            const firstItem = menu.querySelector('a, button');
            if (firstItem) firstItem.focus();
          }
        }
      });
    });

    // Global click and Escape listener to close dropdowns
    document.addEventListener('click', function (e) {
      if (!e.target.closest('.nav-item')) {
        closeAllDropdowns();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeAllDropdowns();
      }
    });
  }

  function toggleDropdown(toggleBtn, show) {
    closeAllDropdowns();
    const menuId = toggleBtn.getAttribute('aria-controls');
    const menu = document.getElementById(menuId);

    if (menu) {
      if (show) {
        menu.classList.add('show');
        toggleBtn.setAttribute('aria-expanded', 'true');
      } else {
        menu.classList.remove('show');
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    }
  }

  function closeAllDropdowns() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');

    dropdownToggles.forEach(function (t) {
      t.setAttribute('aria-expanded', 'false');
    });

    dropdownMenus.forEach(function (m) {
      m.classList.remove('show');
    });
  }

  /* ==========================================================================
     4. MOBILE MENU DRAWER TOGGLE
     ========================================================================== */
  function initMobileMenu() {
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mainNav = document.getElementById('main-nav');

    if (!mobileToggle || !mainNav) return;

    mobileToggle.addEventListener('click', function () {
      const isExpanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', !isExpanded);
      mainNav.classList.toggle('is-open');

      if (!isExpanded) {
        const firstNavLink = mainNav.querySelector('a');
        if (firstNavLink) firstNavLink.focus();
      }
    });
  }

  /* ==========================================================================
     5. UTILITY FUNCTIONS
     ========================================================================== */
  function getFocusableElements(container) {
    return Array.from(
      container.querySelectorAll(
        'a[href], button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )
    ).filter(function (el) {
      return el.offsetWidth > 0 || el.offsetHeight > 0 || el.tagName === 'A';
    });
  }

  function announceToScreenReader(message) {
    let liveRegion = document.getElementById('a11y-live-region');
    if (!liveRegion) {
      liveRegion = document.createElement('div');
      liveRegion.id = 'a11y-live-region';
      liveRegion.setAttribute('aria-live', 'polite');
      liveRegion.setAttribute('aria-atomic', 'true');
      liveRegion.className = 'sr-only';
      liveRegion.style.position = 'absolute';
      liveRegion.style.width = '1px';
      liveRegion.style.height = '1px';
      liveRegion.style.overflow = 'hidden';
      liveRegion.style.clip = 'rect(0, 0, 0, 0)';
      document.body.appendChild(liveRegion);
    }
    liveRegion.textContent = message;
  }

  function initKeyboardUtilities() {
    // Adds sr-only class helper dynamically if needed
  }
})();
