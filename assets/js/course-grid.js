/* ============================================================
   Techno Coderz — Courses page (DreamsLMS course-grid layout)
   Filter / search / sort / grid-list toggle / wishlist
   ============================================================ */
(function () {
  'use strict';

  function init() {
    var grid = document.getElementById('courseGrid');
    if (!grid) return;

    var page      = document.querySelector('.tc-lms-page');
    var items     = Array.prototype.slice.call(grid.querySelectorAll('.course-item-wrap'));
    var empty     = document.getElementById('courseEmpty');
    var resultTxt = document.getElementById('courseResultText');
    var search    = document.getElementById('courseSearchBox');
    var sortSel   = document.getElementById('courseSort');
    var clearBtn  = document.getElementById('courseClear');
    var catBoxes  = Array.prototype.slice.call(document.querySelectorAll('.js-filter-cat'));
    var lvlBoxes  = Array.prototype.slice.call(document.querySelectorAll('.js-filter-level'));
    var priceBoxes= Array.prototype.slice.call(document.querySelectorAll('.js-filter-price'));
    var viewBtns  = Array.prototype.slice.call(document.querySelectorAll('.view-icons a[data-view]'));

    function checkedValues(boxes) {
      return boxes.filter(function (b) { return b.checked; }).map(function (b) { return b.value; });
    }

    function apply() {
      var q     = (search && search.value ? search.value : '').trim().toLowerCase();
      var cats  = checkedValues(catBoxes);
      var lvls  = checkedValues(lvlBoxes);
      var price = checkedValues(priceBoxes);

      var visible = 0;
      items.forEach(function (item) {
        var ok = true;

        if (cats.length && cats.indexOf(item.dataset.cat) === -1) ok = false;
        if (lvls.length && lvls.indexOf(item.dataset.level) === -1) ok = false;

        if (price.length && price.indexOf('all') === -1) {
          var isFree = item.dataset.free === '1';
          var okPrice = (price.indexOf('free') !== -1 && isFree) ||
                        (price.indexOf('paid') !== -1 && !isFree);
          if (!okPrice) ok = false;
        }

        if (ok && q && (item.dataset.search || '').indexOf(q) === -1) ok = false;

        item.style.display = ok ? '' : 'none';
        if (ok) visible++;
      });

      if (empty) empty.style.display = visible ? 'none' : 'block';
      if (resultTxt) {
        resultTxt.textContent = visible
          ? 'Showing ' + visible + ' of ' + items.length + ' results'
          : 'No results found';
      }
    }

    function sort() {
      if (!sortSel) return;
      var val = sortSel.value;
      var sorted = items.slice();
      if (val === 'title')      sorted.sort(function (a, b) { return a.dataset.title.localeCompare(b.dataset.title); });
      else if (val === 'title-desc') sorted.sort(function (a, b) { return b.dataset.title.localeCompare(a.dataset.title); });
      else                       sorted.sort(function (a, b) { return (+a.dataset.order) - (+b.dataset.order); });
      sorted.forEach(function (item) { grid.appendChild(item); });
    }

    catBoxes.concat(lvlBoxes, priceBoxes).forEach(function (b) { b.addEventListener('change', apply); });
    if (search)  search.addEventListener('input', apply);
    if (sortSel) sortSel.addEventListener('change', function () { sort(); apply(); });

    if (clearBtn) {
      clearBtn.addEventListener('click', function (e) {
        e.preventDefault();
        catBoxes.concat(lvlBoxes, priceBoxes).forEach(function (b) { b.checked = false; });
        if (search) search.value = '';
        if (sortSel) sortSel.value = 'default';
        sort();
        apply();
      });
    }

    viewBtns.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        viewBtns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        grid.classList.toggle('is-list', btn.dataset.view === 'list');
      });
    });

    // Wishlist toggle
    document.querySelectorAll('.tc-lms-page .fav-icon').forEach(function (btn) {
      btn.addEventListener('click', function () {
        btn.classList.toggle('selected');
        var i = btn.querySelector('i');
        if (i) {
          i.classList.toggle('fa-regular');
          i.classList.toggle('fa-solid');
          i.classList.toggle('bi-heart');
          i.classList.toggle('bi-heart-fill');
        }
      });
    });

    // Price range slider (optional — only if noUiSlider is present)
    if (typeof noUiSlider !== 'undefined') {
      document.querySelectorAll('.tc-lms-page .input-range').forEach(function (el) {
        if (el.noUiSlider) return;
        var min = parseFloat(el.dataset.min || 0);
        var max = parseFloat(el.dataset.max || 100);
        noUiSlider.create(el, {
          start: [min, max],
          connect: true,
          range: { min: min, max: max }
        });
      });
    }

    // Apply search term passed via ?q=
    if ((search && search.value.trim()) || catBoxes.some(function (b) { return b.checked; })) apply();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
