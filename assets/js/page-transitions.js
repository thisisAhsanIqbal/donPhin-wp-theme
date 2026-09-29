/**
 * Page transitions: a soft fade on arrival
 *
 * Links work as normal, so the old page stays on screen until the new one is ready and
 * there is never a blank moment. The new page's content arrives slightly faded
 * (inc/page-transitions.php adds .dp-fade to <html> before it is drawn) and settles to
 * full strength here. The fade itself is in style.css, section 11.
 *
 * Nothing happens for visitors who prefer less motion: .dp-fade is never added.
 */
(function() {
  const root = document.documentElement;
  if (!root.classList.contains('dp-fade')) return;

  function fadeIn() {
    // On the next frame, so the browser has drawn the faded state to fade from
    window.requestAnimationFrame(function() {
      root.classList.add('dp-fade-in');
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fadeIn);
  } else {
    fadeIn();
  }

  // Coming back with the Back or Forward button restores the page as it was: already in
  window.addEventListener('pageshow', function(e) {
    if (e.persisted) root.classList.add('dp-fade-in');
  });
})();
