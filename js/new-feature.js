/* ==========================================================================
   VRM SHARE BROKING PVT. LTD. - ACCESSIBILITY ENGINE (WCAG 2.2 LEVEL AA)
   ========================================================================== */

let currentFontSize = 16;
let isCarouselPaused = false;

// 1. Font Resizer
function changeFont(sizeChange) {
  currentFontSize = Math.min(Math.max(currentFontSize + sizeChange, 12), 24);
  const content = document.getElementById("main-content");
  if (content) {
    content.style.fontSize = currentFontSize + "px";
    content.querySelectorAll("*").forEach(el => {
      if (!el.closest("#t01") && !el.closest(".inner-banner") && !el.closest(".no-theme")) {
        el.style.fontSize = currentFontSize + "px";
      }
    });
  }
  announceToScreenReader("Font size changed to " + currentFontSize + " pixels");
}

function resetFont() {
  currentFontSize = 16;
  const content = document.getElementById("main-content");
  if (content) {
    content.style.fontSize = "16px";
    content.querySelectorAll("*").forEach(el => {
      el.style.fontSize = "";
    });
  }
  announceToScreenReader("Font size reset to default");
}

// 2. High Contrast Theme Switcher (Header Upper, Navigation & Main Content)
function changeTheme(bgColor, textColor) {
  document.body.style.backgroundColor = bgColor;
  document.body.style.color = textColor;

  const pageWrapper = document.querySelector('.page-wrapper');
  if (pageWrapper) {
    pageWrapper.style.backgroundColor = bgColor;
  }

  // Keep .header-top (top bar) default white background
  const headerTop = document.querySelector('.header-top');
  if (headerTop) {
    headerTop.style.backgroundColor = '#ffffff';
  }

  // Apply Theme to Header Upper, Sticky Header & Main Header Container
  document.querySelectorAll('.header-upper, .sticky-header').forEach(headerEl => {
    headerEl.style.backgroundColor = bgColor;
  });

  // Navigation Links & Dropdowns
  document.querySelectorAll('.main-menu .navigation > li > a, .main-menu .navigation > li > ul, .main-menu .navigation > li > ul > li > a').forEach(navEl => {
    navEl.style.backgroundColor = bgColor;
    navEl.style.color = textColor;
  });

  // Main Content & Text Blocks
  const content = document.getElementById("main-content");
  if (content) {
    content.style.backgroundColor = bgColor;
    content.querySelectorAll("*").forEach(el => {
      if (
        !el.closest("#t01") &&
        !el.closest(".inner-banner") &&
        !el.closest(".banner-section") &&
        !el.closest(".header-top") &&
        !el.closest(".no-theme")
      ) {
        el.style.color = textColor;
        el.style.backgroundColor = bgColor;
      }
    });

    document.querySelectorAll('.text-content, .text-content *').forEach(el => {
      el.style.color = textColor;
      el.style.backgroundColor = bgColor;
    });
  }

  // Preserve top toolbar text contrast
  document.querySelectorAll('.toolbar, .toolbar a, .toolbar button').forEach(el => {
    el.style.color = '#000000';
    el.style.backgroundColor = 'transparent';
  });

  announceToScreenReader("Color theme updated");
}

// 3. Screen Reader Announcement Utility
function announceToScreenReader(message) {
  let liveRegion = document.getElementById('a11y-live-region');
  if (!liveRegion) {
    liveRegion = document.createElement('div');
    liveRegion.id = 'a11y-live-region';
    liveRegion.setAttribute('aria-live', 'polite');
    liveRegion.setAttribute('aria-atomic', 'true');
    liveRegion.style.position = 'absolute';
    liveRegion.style.width = '1px';
    liveRegion.style.height = '1px';
    liveRegion.style.overflow = 'hidden';
    liveRegion.style.clip = 'rect(0, 0, 0, 0)';
    document.body.appendChild(liveRegion);
  }
  liveRegion.textContent = message;
}

// DOM Loaded Initializations
$(document).ready(function () {
  initModalAccessibility();
  initMobileMenuAccessibility();
  initDropdownAccessibility();
  initCarouselAccessibility();
});

/* ==========================================================================
   4. MODAL FOCUS MANAGEMENT (WCAG SC 2.4.3 / 2.1.1 / RULE #3 & #19)
   ========================================================================== */
function initModalAccessibility() {
  const $modal = $('#myModal');
  if (!$modal.length) return;

  let lastFocusedElement = null;

  $modal.on('shown.bs.modal', function () {
    lastFocusedElement = document.activeElement;
    const $firstFocusable = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').first();
    if ($firstFocusable.length) {
      $firstFocusable.focus();
    } else {
      $modal.find('.modal-title').attr('tabindex', '-1').focus();
    }

    // Trap focus inside modal
    $(document).on('keydown.modalTrap', function (e) {
      if (e.key === 'Tab') {
        const focusables = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])').filter(':visible');
        if (!focusables.length) return;

        const first = focusables.first()[0];
        const last = focusables.last()[0];

        if (e.shiftKey) {
          if (document.activeElement === first) {
            last.focus();
            e.preventDefault();
          }
        } else {
          if (document.activeElement === last) {
            first.focus();
            e.preventDefault();
          }
        }
      }
    });
  });

  $modal.on('hidden.bs.modal', function () {
    $(document).off('keydown.modalTrap');
    if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
      lastFocusedElement.focus();
    }
  });
}

/* ==========================================================================
   5. MOBILE MENU ACCESSIBILITY (WCAG 4.1.2 / RULE #4)
   ========================================================================== */
function initMobileMenuAccessibility() {
  const $toggler = $('.mobile-nav-toggler');
  const $mobileMenu = $('.mobile-menu');

  if ($toggler.length) {
    $toggler.on('click', function () {
      const isExpanded = $(this).attr('aria-expanded') === 'true';
      $(this).attr('aria-expanded', !isExpanded);
      if (!isExpanded) {
        $mobileMenu.find('.close-btn').focus();
      }
    });
  }

  $('.mobile-menu .close-btn, .mobile-menu .menu-backdrop').on('click', function () {
    $toggler.attr('aria-expanded', 'false').focus();
  });
}

/* ==========================================================================
   6. DROPDOWN MENU ACCESSIBILITY (WCAG 4.1.2 / RULE #5)
   ========================================================================== */
function initDropdownAccessibility() {
  $('.main-menu .navigation > li.dropdown > a').each(function () {
    const $link = $(this);
    const $parentLi = $link.parent('li');
    $link.attr('aria-haspopup', 'true');
    $link.attr('aria-expanded', 'false');

    $parentLi.on('mouseenter focusin', function () {
      $link.attr('aria-expanded', 'true');
    });

    $parentLi.on('mouseleave focusout', function () {
      setTimeout(function () {
        if (!$parentLi.find(':focus').length) {
          $link.attr('aria-expanded', 'false');
        }
      }, 100);
    });

    $link.on('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
        e.preventDefault();
        $link.attr('aria-expanded', 'true');
        $parentLi.find('ul li a').first().focus();
      }
    });
  });
}

/* ==========================================================================
   7. CAROUSEL ACCESSIBILITY & PAUSE/PLAY ICONS (WCAG SC 2.2.2 / RULE #6)
   ========================================================================== */
function initCarouselAccessibility() {
  $(document).on('click', '#carousel-pause-play', function (e) {
    e.preventDefault();
    const $slider = $('.banner-carousel, .theme-carousel');
    const $btn = $(this);

    if (isCarouselPaused) {
      $slider.trigger('play.owl.autoplay', [6000]);
      $btn.html('<span class="fa fa-pause" aria-hidden="true"></span>').attr('aria-label', 'Pause banner slider rotation');
      isCarouselPaused = false;
      announceToScreenReader('Carousel playback resumed');
    } else {
      $slider.trigger('stop.owl.autoplay');
      $btn.html('<span class="fa fa-play" aria-hidden="true"></span>').attr('aria-label', 'Resume banner slider rotation');
      isCarouselPaused = true;
      announceToScreenReader('Carousel playback paused');
    }
  });

  // Keyboard Arrow key navigation
  $(document).on('keydown', '.banner-carousel, .theme-carousel', function (e) {
    const $slider = $(this);
    if (e.key === 'ArrowLeft') {
      $slider.trigger('prev.owl.carousel');
    } else if (e.key === 'ArrowRight') {
      $slider.trigger('next.owl.carousel');
    }
  });
}