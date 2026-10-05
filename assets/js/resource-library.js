/**
 * The resource library (Speaking Resources)
 *
 * Without this script the whole library simply shows, category by category. With it:
 * - each long category shows its first few items, with "Show all" to open the rest
 * - the category buttons show one category (opened in full), or all of them again
 * - the search narrows every category to what matches, as you type, and says how many
 *   match (for screen readers too); if nothing does, it offers to ask Don
 */
(function() {
  const lib = document.querySelector('[data-dp-lib]');
  if (!lib) return;

  const LIMIT = 6; // items shown in a closed category (three rows of two)

  const controls = lib.querySelector('[data-dp-lib-controls]');
  const search = lib.querySelector('[data-dp-lib-search]');
  const chips = Array.prototype.slice.call(lib.querySelectorAll('.dp-lib-chip'));
  const status = lib.querySelector('[data-dp-lib-status]');
  const empty = lib.querySelector('[data-dp-lib-empty]');

  const groups = Array.prototype.slice.call(lib.querySelectorAll('.dp-lib-group')).map(function(el) {
    const items = Array.prototype.slice.call(el.querySelectorAll('.dp-lib-item'));
    return {
      el: el,
      cat: el.getAttribute('data-cat'),
      items: items,
      words: items.map(function(li) { return li.getAttribute('data-search') || ''; }),
      count: el.querySelector('[data-dp-lib-count]'),
      more: el.querySelector('[data-dp-lib-more]'),
      open: false
    };
  });

  const state = { cat: 'all', q: '' };

  function render() {
    let total = 0;

    groups.forEach(function(g) {
      const inCat = state.cat === 'all' || state.cat === g.cat;
      // A single category, or a search, shows everything that qualifies
      const full = g.open || state.cat !== 'all' || state.q !== '';
      let shown = 0;
      let matches = 0;

      g.items.forEach(function(li, i) {
        const match = state.q === '' || g.words[i].indexOf(state.q) !== -1;
        if (match) matches++;
        const show = inCat && match && (full || matches <= LIMIT);
        li.hidden = !show;
        if (show) shown++;
      });

      g.el.hidden = !inCat || matches === 0;
      g.count.textContent = matches;
      if (inCat) total += matches;

      // "Show all" / "Show fewer" only while browsing every category, on the long ones
      g.more.hidden = !(state.cat === 'all' && state.q === '' && g.items.length > LIMIT);
      g.more.textContent = g.open ? 'Show fewer' : 'Show all ' + g.items.length;
      g.more.setAttribute('aria-expanded', g.open ? 'true' : 'false');
    });

    empty.hidden = total !== 0;
    status.textContent = state.q === '' ? '' : (total === 1 ? '1 resource matches' : total + ' resources match');
  }

  chips.forEach(function(chip) {
    chip.addEventListener('click', function() {
      state.cat = chip.getAttribute('data-cat');
      chips.forEach(function(c) { c.setAttribute('aria-pressed', c === chip ? 'true' : 'false'); });
      render();
      // On phones the buttons scroll sideways: keep the chosen one in sight
      const row = chip.parentElement;
      const left = chip.offsetLeft - row.offsetLeft;
      if (left < row.scrollLeft || left + chip.offsetWidth > row.scrollLeft + row.clientWidth) {
        row.scrollLeft = left - 16;
      }
    });
  });

  groups.forEach(function(g) {
    g.more.addEventListener('click', function() {
      g.open = !g.open;
      render();
      // Closing a long list: keep its heading in view rather than leaving the reader far below it
      if (!g.open && g.el.getBoundingClientRect().top < 0) {
        g.el.scrollIntoView({ block: 'start' });
      }
    });
  });

  search.addEventListener('input', function() {
    state.q = search.value.trim().toLowerCase();
    render();
  });

  controls.hidden = false;
  render();
})();
