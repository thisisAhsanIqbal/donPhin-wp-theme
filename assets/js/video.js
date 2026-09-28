/**
 * Video facade
 *
 * A .dp-video shows a still image and only loads the YouTube player once
 * someone presses play, so the page costs nothing for people who never watch.
 * Without JavaScript the still stays a plain link to YouTube.
 */
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.dp-video').forEach(function(wrapper) {
    const link = wrapper.querySelector('.dp-video-play');
    const id = wrapper.getAttribute('data-video');
    if (!link || !id) return;

    link.addEventListener('click', function(e) {
      // Let people open it on YouTube with a modifier key or middle click
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;

      e.preventDefault();

      const frame = document.createElement('iframe');
      frame.src = 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&mute=0&playsinline=1&rel=0';
      frame.title = wrapper.getAttribute('data-title') || 'Video';
      frame.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
      frame.allowFullscreen = true;
      frame.className = 'dp-video-frame';

      wrapper.replaceChild(frame, link);
      frame.focus();
    });
  });
});
