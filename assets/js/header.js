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

  // Mobile menu toggle for each site header on the page
  document.querySelectorAll('.dp-header').forEach(function(header) {
    const toggleBtn = header.querySelector('.dp-mobile-toggle');
    const navWrap = toggleBtn && document.getElementById(toggleBtn.getAttribute('aria-controls'));
    if (!navWrap) return;

    function setOpen(isOpen) {
      toggleBtn.setAttribute('aria-expanded', String(isOpen));
      toggleBtn.classList.toggle('is-active', isOpen);
      navWrap.classList.toggle('is-open', isOpen);
    }

    toggleBtn.addEventListener('click', function() {
      setOpen(!navWrap.classList.contains('is-open'));
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      if (!header.contains(e.target) && navWrap.classList.contains('is-open')) {
        setOpen(false);
      }
    });

    // Close menu on Escape key and return focus to the toggle
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && navWrap.classList.contains('is-open')) {
        setOpen(false);
        toggleBtn.focus();
      }
    });
  });
});
