document.addEventListener('DOMContentLoaded', function() {
  // Testimonials: the wall of quotes becomes a spotlight slider, one quote at a
  // time, with the names along the bottom as the way through them. Everything
  // here is added on top of the wall, so without this the page still reads.
  document.querySelectorAll('.dp-book-praise').forEach(function(section) {
    const wall = section.querySelector('.dp-book-praise-wall');
    const stage = section.querySelector('.dp-book-praise-stage');
    const nav = section.querySelector('.dp-book-praise-nav');
    const rail = section.querySelector('.dp-book-praise-rail');
    const bar = section.querySelector('.dp-book-praise-progress span');
    const now = section.querySelector('.dp-book-praise-now');
    const prev = section.querySelector('.dp-book-praise-prev');
    const next = section.querySelector('.dp-book-praise-next');
    if (!wall || !stage || !nav || !rail || !prev || !next) return;

    const quotes = Array.prototype.slice.call(wall.querySelectorAll('.dp-book-quote'));
    const names = Array.prototype.slice.call(rail.querySelectorAll('.dp-book-praise-name'));
    if (quotes.length < 2 || names.length !== quotes.length) return;

    const SLIDE = 600; // a shade longer than the CSS transition
    const calm = window.matchMedia('(prefers-reduced-motion: reduce)');
    let index = 0;
    let timer = null;
    let startedAt = 0;
    let remaining = 0;
    let held = false;
    let hovering = false;
    let focused = false;
    let settle = null;

    // Kept in the stylesheet so the bar and the wait are the same length
    function delay() {
      const value = getComputedStyle(section).getPropertyValue('--dp-praise-delay').trim();
      const ms = value.indexOf('ms') > -1 ? parseFloat(value) : parseFloat(value) * 1000;
      return ms > 0 ? ms : 7000;
    }

    // Tie each name to the quote it brings up, for people using a screen reader
    quotes.forEach(function(quote, i) {
      quote.id = quote.id || 'dp-praise-quote-' + i;
      names[i].id = names[i].id || 'dp-praise-name-' + i;
      quote.setAttribute('role', 'tabpanel');
      quote.setAttribute('aria-labelledby', names[i].id);
      names[i].setAttribute('aria-controls', quote.id);
    });

    function measure() {
      const height = quotes[index].offsetHeight;
      if (height) wall.style.height = height + 'px';
    }

    function paint() {
      quotes.forEach(function(quote, i) {
        quote.setAttribute('aria-hidden', i === index ? 'false' : 'true');
      });

      names.forEach(function(name, i) {
        name.setAttribute('aria-selected', i === index ? 'true' : 'false');
        name.setAttribute('tabindex', i === index ? '0' : '-1');
      });

      if (now) now.textContent = ('0' + (index + 1)).slice(-2);

      names[index].scrollIntoView({
        behavior: calm.matches ? 'auto' : 'smooth',
        inline: 'center',
        block: 'nearest',
      });
    }

    // Wind the bar back to nothing and let it fill again from the start
    function restartBar() {
      if (!bar || calm.matches) return;
      section.classList.remove('is-running');
      void bar.offsetWidth;
      if (!held) section.classList.add('is-running');
    }

    function stopTimer() {
      if (!timer) return;
      window.clearTimeout(timer);
      timer = null;
      remaining = Math.max(0, remaining - (Date.now() - startedAt));
    }

    function startTimer(ms) {
      stopTimer();
      if (calm.matches || held || document.hidden) return;
      remaining = typeof ms === 'number' ? ms : remaining;
      startedAt = Date.now();
      timer = window.setTimeout(function() {
        go(index + 1);
      }, remaining);
    }

    function go(to) {
      const total = quotes.length;
      const target = ((to % total) + total) % total;
      if (target === index) return;

      const forwards = to > index;
      const leaving = quotes[index];

      section.setAttribute('data-direction', forwards ? 'next' : 'prev');

      // Press the arrows quickly and several quotes can be on their way out at
      // once. Only the last one gets tidied up by the timer below, so drop the
      // class from all of them here: a quote must never arrive still carrying
      // the class that fades it away, or the card comes up empty.
      window.clearTimeout(settle);
      quotes.forEach(function(quote) {
        quote.classList.remove('is-leaving');
      });

      leaving.classList.remove('is-active');
      leaving.classList.add('is-leaving');
      quotes[target].classList.add('is-active');

      index = target;
      measure();
      paint();

      settle = window.setTimeout(function() {
        leaving.classList.remove('is-leaving');
      }, SLIDE);

      restartBar();
      startTimer(delay());
    }

    // Paused while the pointer is on it or a button in it has the focus, so
    // clicking an arrow does not set it running again the moment you move away
    function hold() {
      const state = hovering || focused;
      if (held === state) return;
      held = state;
      section.classList.toggle('is-held', state);
      if (state) {
        stopTimer();
      } else {
        startTimer();
      }
    }

    prev.addEventListener('click', function() {
      go(index - 1);
    });

    next.addEventListener('click', function() {
      go(index + 1);
    });

    names.forEach(function(name, i) {
      name.addEventListener('click', function() {
        go(i);
      });
    });

    // Left and right walk the names, as a row of tabs is expected to
    rail.addEventListener('keydown', function(e) {
      if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
      e.preventDefault();
      go(index + (e.key === 'ArrowRight' ? 1 : -1));
      names[index].focus();
    });

    // A swipe across the quote itself, for phones
    let swipeFrom = null;
    stage.addEventListener('pointerdown', function(e) {
      swipeFrom = e.pointerType === 'mouse' ? null : e.clientX;
    });

    stage.addEventListener('pointerup', function(e) {
      if (swipeFrom === null) return;
      const moved = e.clientX - swipeFrom;
      swipeFrom = null;
      if (Math.abs(moved) > 45) go(index + (moved < 0 ? 1 : -1));
    });

    // Hold still while someone is reading it, or moving through it by keyboard
    section.addEventListener('pointerenter', function() {
      hovering = true;
      hold();
    });

    section.addEventListener('pointerleave', function() {
      hovering = false;
      hold();
    });

    section.addEventListener('focusin', function() {
      focused = true;
      hold();
    });

    section.addEventListener('focusout', function(e) {
      if (section.contains(e.relatedTarget)) return;
      focused = false;
      hold();
    });

    // Nothing moves in a background tab
    document.addEventListener('visibilitychange', function() {
      if (document.hidden) {
        stopTimer();
      } else {
        startTimer();
      }
    });

    // The quote is as tall as the words in it, so remeasure when they rewrap
    let resizeTimer = null;
    window.addEventListener('resize', function() {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(measure, 150);
    });

    // Only a change of width rewraps the words; watching the height as well
    // would just chase the height this very function sets
    if (window.ResizeObserver) {
      let lastWidth = 0;
      new ResizeObserver(function(entries) {
        const width = entries[0].contentRect.width;
        if (width === lastWidth) return;
        lastWidth = width;
        measure();
      }).observe(stage);
    }

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(measure);
    }

    calm.addEventListener('change', function() {
      stopTimer();
      section.classList.remove('is-running');
      startTimer(delay());
    });

    // reveal.js fades content in as it scrolls up, quote cards included. The
    // slider works the same two properties on the same elements, so it takes
    // them off reveal's hands rather than have the two argue over them.
    quotes.forEach(function(quote) {
      quote.classList.remove('dp-reveal', 'is-visible');
    });

    // Take the wall over: first quote up, at its own height, with no movement
    section.classList.add('is-slider');
    section.setAttribute('data-direction', 'next');
    quotes[0].classList.add('is-active');

    wall.style.transition = 'none';
    measure();
    paint();
    window.requestAnimationFrame(function() {
      wall.style.transition = '';
    });

    nav.hidden = false;
    rail.hidden = false;
    restartBar();
    startTimer(delay());
  });
});
