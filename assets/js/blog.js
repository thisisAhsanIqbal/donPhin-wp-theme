/**
 * A blog post's page (single-blog.php): the bar along the top showing how far through
 * the post the reader is, "In this post" marking the heading being read, "Copy the
 * link", and folding "In this post" away on smaller screens. Without this script the page
 * reads the same; only these are missing.
 */
(function () {
  'use strict';

  var article = document.querySelector('.dp-blog-single');
  if (!article) {
    return;
  }

  var bar = document.querySelector('.dp-blog-progress-bar');
  var words = article.querySelector('.dp-blog-content');

  // "In this post": each link with the heading it leads to
  var toc = [];
  article.querySelectorAll('.dp-blog-toc a').forEach(function (link) {
    var heading = document.getElementById(decodeURIComponent(link.getAttribute('href').slice(1)));
    if (heading) {
      toc.push({ link: link, heading: heading });
    }
  });

  var ticking = false;
  var update = function () {
    ticking = false;

    // 1. How far through the words
    if (bar && words) {
      var rect = words.getBoundingClientRect();
      var total = rect.height - window.innerHeight * 0.6;
      var done = total > 0 ? Math.min(1, Math.max(0, -rect.top / total)) : 1;
      bar.style.transform = 'scaleX(' + done.toFixed(4) + ')';
    }

    // 2. The heading being read: the last one past the upper third of the window
    var current = null;
    toc.forEach(function (entry) {
      if (entry.heading.getBoundingClientRect().top < window.innerHeight * 0.33) {
        current = entry;
      }
    });
    toc.forEach(function (entry) {
      if (entry === current) {
        entry.link.setAttribute('aria-current', 'true');
      } else {
        entry.link.removeAttribute('aria-current');
      }
    });
  };

  window.addEventListener('scroll', function () {
    if (!ticking) {
      ticking = true;
      window.requestAnimationFrame(update);
    }
  }, { passive: true });
  window.addEventListener('resize', update);
  update();

  // 3. "In this post" on smaller screens: its heading folds the list away, and a heading
  //    chosen from it is scrolled to smoothly (the list folds after, out of the way)
  var toggle = article.querySelector('.dp-blog-toc-toggle');
  var list = article.querySelector('.dp-blog-toc');
  var small = window.matchMedia('(max-width: 1199px)');
  var calm = window.matchMedia('(prefers-reduced-motion: reduce)');
  var setOpen = function (open) {
    if (!toggle || !list) {
      return;
    }
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    list.hidden = !open;
  };
  if (toggle && list) {
    toggle.hidden = false;
    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });
    // The wide-screen rail always shows the list
    var fit = function () {
      if (!small.matches) {
        setOpen(true);
      }
    };
    if (small.addEventListener) {
      small.addEventListener('change', fit);
    }
  }
  toc.forEach(function (entry) {
    entry.link.addEventListener('click', function (event) {
      event.preventDefault();
      entry.heading.scrollIntoView({ behavior: calm.matches ? 'auto' : 'smooth', block: 'start' });
      if (window.history && window.history.replaceState) {
        window.history.replaceState(null, '', '#' + entry.heading.id);
      }
      if (small.matches) {
        setOpen(false);
      }
    });
  });

  // 4. Copy the link
  article.querySelectorAll('.dp-blog-copy').forEach(function (button) {
    button.addEventListener('click', function () {
      if (!navigator.clipboard || !navigator.clipboard.writeText) {
        return;
      }
      var status = button.querySelector('.dp-blog-copy-done');
      navigator.clipboard.writeText(button.getAttribute('data-url')).then(function () {
        button.classList.add('is-copied');
        if (status) {
          status.textContent = 'Link copied';
        }
        window.setTimeout(function () {
          button.classList.remove('is-copied');
          if (status) {
            status.textContent = '';
          }
        }, 2000);
      }, function () {});
    });
  });
})();
