document.addEventListener('DOMContentLoaded', function() {
  // The header is fixed; this marks it once the page has scrolled under it
  const stuck = document.querySelectorAll('.dp-header');

  function markStuck() {
    const isStuck = window.scrollY > 8;
    stuck.forEach(function(header) {
      header.classList.toggle('is-stuck', isStuck);
    });
  }

  window.addEventListener('scroll', markStuck, { passive: true });
  markStuck();

  // Logged in, on phones: WordPress's toolbar scrolls away with the page there, so
  // the header follows its bottom edge up to the top of the screen instead of
  // leaving a gap where the toolbar was
  const adminBar = document.getElementById('wpadminbar');

  if (adminBar) {
    function followAdminBar() {
      const scrollsAway = window.getComputedStyle(adminBar).position !== 'fixed';
      const top = scrollsAway ? Math.max(0, adminBar.getBoundingClientRect().bottom) + 'px' : '';
      stuck.forEach(function(header) {
        header.style.top = top;
      });
    }

    window.addEventListener('scroll', followAdminBar, { passive: true });
    window.addEventListener('resize', followAdminBar);
    followAdminBar();
  }

  // Mobile menu: a full-screen panel under the header, links at the top and the
  // button at the foot. The panel's slide and fade are in style.css; this opens and
  // closes it and keeps it easy to use.
  const smallScreen = window.matchMedia('(max-width: 991px)');

  document.querySelectorAll('.dp-header').forEach(function(header) {
    const toggleBtn = header.querySelector('.dp-mobile-toggle');
    const navWrap = toggleBtn && document.getElementById(toggleBtn.getAttribute('aria-controls'));
    if (!navWrap) return;

    const isOpen = function() { return navWrap.classList.contains('is-open'); };

    // The panel starts wherever the header ends (lower when WordPress's toolbar shows)
    function placePanel() {
      header.style.setProperty('--dp-drawer-top', Math.round(header.getBoundingClientRect().bottom) + 'px');
    }

    // fromKeyboard: opened with Enter or Space, so focus moves into the menu (not on a tap)
    function setOpen(open, returnFocus, fromKeyboard) {
      if (open) placePanel();
      toggleBtn.setAttribute('aria-expanded', String(open));
      toggleBtn.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      toggleBtn.classList.toggle('is-active', open);
      navWrap.classList.toggle('is-open', open);

      // The page underneath stays put while the menu is open
      document.documentElement.classList.toggle('dp-menu-open', open);

      if (open && fromKeyboard) {
        // Into the menu for keyboard users, once it has started to appear
        const first = navWrap.querySelector('a');
        if (first) window.setTimeout(function() { first.focus({ preventScroll: true }); }, 120);
      } else if (returnFocus) {
        toggleBtn.focus();
      }
    }

    toggleBtn.setAttribute('aria-label', 'Open menu');
    toggleBtn.addEventListener('click', function(e) {
      // A click from Enter or Space has no pointer position (detail is 0)
      setOpen(!isOpen(), false, e.detail === 0);
    });

    // Choosing a link closes the menu (matters most for links within the same page)
    navWrap.addEventListener('click', function(e) {
      if (e.target.closest('a') && smallScreen.matches) setOpen(false, false);
    });

    // A click anywhere else on the page closes it too
    document.addEventListener('click', function(e) {
      if (isOpen() && !header.contains(e.target)) setOpen(false, false);
    });

    // Escape closes it and returns focus to the toggle
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && isOpen()) setOpen(false, true);
    });

    // Turning a tablet or widening the window past the menu's size closes it
    smallScreen.addEventListener('change', function(e) {
      if (!e.matches && isOpen()) setOpen(false, false);
    });

    window.addEventListener('resize', function() {
      if (isOpen()) placePanel();
    });
  });
});
