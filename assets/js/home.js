document.addEventListener('DOMContentLoaded', function() {
  // Photo slider: moves one picture at a time, on its own and by the arrows
  document.querySelectorAll('.dp-slider').forEach(function(slider) {
    const track = slider.querySelector('.dp-slider-track');
    const controls = slider.querySelector('.dp-slider-controls');
    const prev = slider.querySelector('.dp-slider-prev');
    const next = slider.querySelector('.dp-slider-next');
    const pause = slider.querySelector('.dp-slider-pause');
    if (!track || !controls || !prev || !next || !pause || track.children.length < 2) return;

    const DELAY = 4500;
    const calm = window.matchMedia('(prefers-reduced-motion: reduce)');
    let timer = null;
    let settle = null;
    let paused = false;

    function slideWidth() {
      const first = track.firstElementChild;
      return first ? first.getBoundingClientRect().width : 0;
    }

    function behaviour() {
      return calm.matches ? 'auto' : 'smooth';
    }

    // Once a picture has scrolled off the left, move it to the end. The strip
    // never runs out in either direction and the page keeps the same pictures.
    function rotate() {
      const width = slideWidth();
      if (!width) return;

      let guard = track.children.length;
      while (track.scrollLeft >= width - 1 && guard--) {
        track.appendChild(track.firstElementChild);
        track.scrollLeft -= width;
      }
    }

    function goNext() {
      track.scrollBy({ left: slideWidth(), behavior: behaviour() });
    }

    function goPrev() {
      const width = slideWidth();
      if (!width) return;

      // Bring the last picture round to the front, then step back onto it
      track.insertBefore(track.lastElementChild, track.firstElementChild);
      track.scrollLeft += width;
      track.scrollBy({ left: -width, behavior: behaviour() });
    }

    function start() {
      if (timer || paused || calm.matches || document.hidden) return;
      timer = window.setInterval(goNext, DELAY);
    }

    function stop() {
      window.clearInterval(timer);
      timer = null;
    }

    function setPaused(state) {
      paused = state;
      pause.setAttribute('aria-pressed', String(state));
      pause.setAttribute('aria-label', state ? 'Play the photos' : 'Pause the photos');
      if (state) {
        stop();
      } else {
        start();
      }
    }

    prev.addEventListener('click', goPrev);
    next.addEventListener('click', goNext);
    pause.addEventListener('click', function() {
      setPaused(!paused);
    });

    // Tidy up the order once the scrolling has come to rest
    track.addEventListener('scroll', function() {
      window.clearTimeout(settle);
      settle = window.setTimeout(rotate, 150);
    }, { passive: true });

    // Hold still while someone is looking at it, or reading it with a keyboard
    slider.addEventListener('pointerenter', stop);
    slider.addEventListener('pointerleave', start);
    slider.addEventListener('focusin', stop);
    slider.addEventListener('focusout', function(e) {
      if (!slider.contains(e.relatedTarget)) start();
    });

    // Nothing moves in a background tab
    document.addEventListener('visibilitychange', function() {
      if (document.hidden) {
        stop();
      } else {
        start();
      }
    });

    calm.addEventListener('change', function() {
      stop();
      start();
    });

    controls.hidden = false;
    start();
  });

  // Testimonials: arrows and dots for the sideways-scrolling row of quotes
  document.querySelectorAll('.dp-testimonials').forEach(function(section) {
    const track = section.querySelector('.dp-testimonials-track');
    const controls = section.querySelector('.dp-testimonials-controls');
    const dotsWrap = section.querySelector('.dp-testimonials-dots');
    const prev = section.querySelector('.dp-testimonials-prev');
    const next = section.querySelector('.dp-testimonials-next');
    if (!track || !controls || !dotsWrap || !prev || !next) return;

    let dots = [];

    function pageCount() {
      return Math.max(1, Math.round(track.scrollWidth / track.clientWidth));
    }

    function currentPage() {
      return Math.round(track.scrollLeft / track.clientWidth);
    }

    function goTo(page) {
      track.scrollTo({ left: page * track.clientWidth, behavior: 'smooth' });
    }

    function buildDots() {
      const pages = pageCount();
      dotsWrap.textContent = '';
      dots = [];

      // One dot per screenful; pointless when everything already fits
      if (pages < 2) return;

      for (let i = 0; i < pages; i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'dp-testimonials-dot';
        dot.setAttribute('aria-label', 'Testimonials ' + (i + 1) + ' of ' + pages);
        dot.addEventListener('click', function() {
          goTo(i);
        });
        dotsWrap.appendChild(dot);
        dots.push(dot);
      }
    }

    function update() {
      const page = currentPage();
      const pages = pageCount();

      dots.forEach(function(dot, i) {
        dot.classList.toggle('is-active', i === page);
        dot.setAttribute('aria-current', i === page ? 'true' : 'false');
      });

      prev.disabled = page <= 0;
      next.disabled = page >= pages - 1;
    }

    prev.addEventListener('click', function() {
      goTo(Math.max(0, currentPage() - 1));
    });

    next.addEventListener('click', function() {
      goTo(Math.min(pageCount() - 1, currentPage() + 1));
    });

    let queued = false;
    track.addEventListener('scroll', function() {
      if (queued) return;
      queued = true;
      window.setTimeout(function() {
        queued = false;
        update();
      }, 100);
    }, { passive: true });

    let resizeTimer = null;
    window.addEventListener('resize', function() {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(function() {
        buildDots();
        update();
      }, 200);
    });

    controls.hidden = false;
    buildDots();
    update();
  });

  // Credibility figures: each number counts up once, as it comes into view. The markup
  // holds the final figures, so they show as they are without this, for anyone who has
  // asked for less motion, and for figures too small to count (1M+).
  const figures = Array.prototype.filter.call(
    document.querySelectorAll('.dp-cred-number[data-count]'),
    function(el) { return parseInt(el.dataset.count, 10) >= 10; }
  );
  const still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (figures.length && !still && 'IntersectionObserver' in window) {
    const DURATION = 1600;

    function show(el, value) {
      el.textContent = value + (el.dataset.suffix || '');
    }

    function countUp(el) {
      const target = parseInt(el.dataset.count, 10);
      const start = performance.now();

      function frame(now) {
        const progress = Math.min(1, (now - start) / DURATION);
        // Fast at first, settling onto the figure
        show(el, Math.round(target * (1 - Math.pow(1 - progress, 3))));
        if (progress < 1) window.requestAnimationFrame(frame);
      }

      window.requestAnimationFrame(frame);
    }

    const counter = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        counter.unobserve(entry.target);
        countUp(entry.target);
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0 });

    figures.forEach(function(el) {
      show(el, 0);
      counter.observe(el);
    });
  }
});
