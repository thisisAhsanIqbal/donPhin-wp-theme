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
