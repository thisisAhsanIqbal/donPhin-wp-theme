document.addEventListener('DOMContentLoaded', function() {
  // Page content only, so the header and footer never fade
  const main = document.getElementById('inner-wrap') || document.querySelector('main');
  if (!main) return;

  // Respect the visitor's motion setting: everything stays where it is
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  // Content elements, not the sections that hold them. A card, a photo block or a
  // form card counts as one element, so its insides don't fade separately.
  const SELECTOR = [
    'h1', 'h2', 'h3', 'h4',
    'p', 'img', 'figure', 'blockquote', 'li',
    '.dp-arrow-link', '.dp-dark-button', '.dp-light-button',
    '.dp-pillar-media', '.dp-tools-card',
    '.dp-testimonial-tabs', '.dp-home-cta-ring'
  ].join(', ');

  let pending = [];

  main.querySelectorAll(SELECTOR).forEach(function(el) {
    // Keep only the outermost match, so nothing fades twice
    if (el.parentElement && el.parentElement.closest('.dp-reveal')) return;

    // Leave anything already on screen alone, so the first view paints straight away
    if (el.getBoundingClientRect().top < window.innerHeight) return;

    el.classList.add('dp-reveal');
    pending.push(el);
  });

  if (!pending.length) return;

  function reveal(el) {
    el.classList.add('is-visible');
  }

  // Preferred path: the browser tells us when an element comes into view
  let observer = null;
  if ('IntersectionObserver' in window) {
    observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        reveal(entry.target);
        observer.unobserve(entry.target);
        pending = pending.filter(function(el) { return el !== entry.target; });
      });
    }, {
      // Any part of the element showing counts, once it is a little way in
      rootMargin: '0px 0px -10% 0px',
      threshold: 0
    });

    pending.forEach(function(el) {
      observer.observe(el);
    });
  }

  // Fallback sweep, so nothing can stay invisible if the observer misses it
  let queued = false;

  function sweep() {
    queued = false;
    const limit = window.innerHeight * 0.92;

    pending = pending.filter(function(el) {
      if (el.getBoundingClientRect().top > limit) return true;
      reveal(el);
      if (observer) observer.unobserve(el);
      return false;
    });

    if (!pending.length) {
      window.removeEventListener('scroll', onScroll);
      window.removeEventListener('resize', onScroll);
    }
  }

  // Timer rather than an animation frame, so the fallback still runs where frames are throttled
  function onScroll() {
    if (queued) return;
    queued = true;
    window.setTimeout(sweep, 100);
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);

  // Covers pages opened part-way down, at an anchor or after a reload
  sweep();
});
