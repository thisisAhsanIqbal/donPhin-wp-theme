/**
 * Count-up numbers
 *
 * Any .dp-count with a data-count holds its final figure in the markup. Once its group
 * comes near the screen, it counts up to that figure from zero, easing in to land. It
 * counts once. Groups are the nearest <section>, so a row of numbers counts together.
 *
 * Checked on scroll rather than with an IntersectionObserver, which can miss the change
 * on these pages (see reveal.js). Visitors who prefer less motion see the figures as they are.
 */
(function() {
  const numbers = Array.prototype.slice.call(document.querySelectorAll('.dp-count[data-count]'));
  if (!numbers.length) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const DURATION = 1800;
  const format = new Intl.NumberFormat();

  // One group per section, each counted once
  const groups = [];
  numbers.forEach(function(el) {
    const box = el.closest('section') || el.parentElement;
    let group = groups.find(function(g) { return g.box === box; });
    if (!group) {
      group = { box: box, items: [], done: false };
      groups.push(group);
    }
    group.items.push(el);
  });

  function run(group) {
    group.done = true;
    const start = performance.now();
    const targets = group.items.map(function(el) { return parseInt(el.getAttribute('data-count'), 10) || 0; });

    function frame(now) {
      const t = Math.min(1, (now - start) / DURATION);
      const eased = 1 - Math.pow(1 - t, 3); // ease out: quick at first, settling on the figure
      group.items.forEach(function(el, i) {
        el.textContent = format.format(Math.round(targets[i] * eased));
      });
      if (t < 1) window.requestAnimationFrame(frame);
    }
    window.requestAnimationFrame(frame);
  }

  // Near the screen: its top within the bottom 15% of the view, or already above it
  function check() {
    const view = window.innerHeight || document.documentElement.clientHeight;
    groups.forEach(function(group) {
      if (group.done) return;
      const top = group.box.getBoundingClientRect().top;
      if (top < view * 0.85) run(group);
    });
    // Once every group has counted, stop listening
    if (groups.every(function(g) { return g.done; })) {
      window.removeEventListener('scroll', check);
      window.removeEventListener('resize', check);
    }
  }

  // Numbers still ahead start at zero; any already on screen count up straight away
  groups.forEach(function(group) {
    group.items.forEach(function(el) { el.textContent = '0'; });
  });

  // The check only reads one position per group, so it runs straight from the scroll
  window.addEventListener('scroll', check, { passive: true });
  window.addEventListener('resize', check);
  check();
})();
