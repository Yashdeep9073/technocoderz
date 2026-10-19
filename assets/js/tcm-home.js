/* ============================================================
   Techno Coderz — homepage behaviour (techcadd-style)
   Reveal-on-scroll, counters, FAQ accordion, capabilities rail,
   technology filter and the closing CTA form.
   ============================================================ */
(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- Reveal on scroll ---- */
  function reveal() {
    var els = document.querySelectorAll('[data-anim],[data-underline]');
    if (!els.length) return;
    window.__tcmArmed = true;
    if (!('IntersectionObserver' in window) || reduce) {
      els.forEach(function (el) { el.classList.add('is-in'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target;
        var delay = parseFloat(el.getAttribute('data-anim-delay') || '0') * 1000;
        setTimeout(function () { el.classList.add('is-in'); }, delay);
        io.unobserve(el);
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
    els.forEach(function (el) { io.observe(el); });
  }

  /* ---- Number counters ---- */
  function counters() {
    var els = document.querySelectorAll('[data-count]');
    if (!els.length || !('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.textContent = el.getAttribute('data-count'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target; io.unobserve(el);
        var end = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (reduce) { el.textContent = end.toLocaleString('en-IN'); return; }
        var start = null, dur = 1400;
        function step(ts) {
          if (!start) start = ts;
          var p = Math.min((ts - start) / dur, 1);
          var e = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.round(end * e).toLocaleString('en-IN');
          if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      });
    }, { threshold: 0.4 });
    els.forEach(function (el) { io.observe(el); });
  }

  /* ---- FAQ accordion (single open) ---- */
  function faqs() {
    var groups = document.querySelectorAll('[data-faq-group]');
    groups.forEach(function (group) {
      group.querySelectorAll('.tcm-faq').forEach(function (item) {
        var btn = item.querySelector('button');
        if (!btn) return;
        btn.addEventListener('click', function () {
          var isOpen = item.classList.contains('open');
          group.querySelectorAll('.tcm-faq').forEach(function (i) {
            i.classList.remove('open');
            var b = i.querySelector('button');
            if (b) b.setAttribute('aria-expanded', 'false');
          });
          if (!isOpen) { item.classList.add('open'); btn.setAttribute('aria-expanded', 'true'); }
        });
      });
    });
  }

  /* ---- Capabilities rail ---- */
  function rails() {
    var root = document.querySelector('[data-cap-root]');
    if (!root) return;
    var btns = root.querySelectorAll('[data-cap-btn]');
    var panel = root.querySelector('[data-cap-panel]');
    var data = window.TCM_CAPS || [];
    function render(i) {
      var d = data[i];
      if (!d || !panel) return;
      btns.forEach(function (b, bi) {
        var on = bi === i;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-current', on ? 'true' : 'false');
      });
      panel.querySelector('[data-cap-num]').textContent = '0' + (i + 1);
      panel.querySelector('[data-cap-title]').textContent = d.title;
      panel.querySelector('[data-cap-sub]').textContent = d.sub;
      panel.querySelector('[data-cap-count]').textContent = d.tools.length + ' tools';
      var grid = panel.querySelector('[data-cap-tools]');
      grid.innerHTML = d.tools.map(function (t) {
        var icon = t.logo
          ? '<span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white shadow-[0_6px_16px_-8px_rgba(15,23,42,0.45)]"><img src="' + t.logo + '" alt="' + t.name + '" class="h-6 w-6" loading="lazy"></span>'
          : '<span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white shadow-[0_6px_16px_-8px_rgba(15,23,42,0.45)]"><span style="background-color:' + (t.color || '#ff6b00') + ';color:#fff" class="grid h-7 w-7 place-items-center rounded-[0.5rem] font-display text-[0.6rem] font-extrabold leading-none tracking-tight">' + t.short + '</span></span>';
        return '<div class="cap-tool glass relative flex items-center gap-3.5 rounded-2xl p-3.5 transition-all duration-300 hover:-translate-y-0.5">'
          + icon
          + '<span class="flex min-w-0 flex-col leading-tight"><span class="truncate text-[0.85rem] font-bold text-up-ink">' + t.name + '</span><span class="truncate text-[0.7rem] text-up-muted">' + t.sub + '</span></span></div>';
      }).join('');
      var link = panel.querySelector('[data-cap-link]');
      if (link) link.setAttribute('href', d.href || 'courses.php');
      var label = panel.querySelector('[data-cap-link-label]');
      if (label) label.textContent = d.title;
    }
    btns.forEach(function (b, i) { b.addEventListener('click', function () { render(i); }); });
    render(0);
  }

  /* ---- Technology orbit + filter ----
     Port of techcadd's GSAP orbital field to vanilla rAF:
     nodes sit on the bottom-centre origin and are swept along 4 concentric
     arcs (18deg..162deg) at ring-specific speeds and alternating directions. */
  function stacks() {
    var wrap = document.querySelector('[data-stack]');
    if (!wrap) return;
    var btns = wrap.querySelectorAll('[data-stack-btn]');
    var groups = wrap.querySelectorAll('[data-stack-group]');
    var stage = wrap.querySelector('[data-orbit-stage]');
    var nodes = stage ? Array.prototype.slice.call(stage.querySelectorAll('[data-node]')) : [];
    if (!nodes.length) return;

    var RING_RADII = { 1: [.75], 2: [.55, .93], 3: [.42, .68, .93], 4: [.3, .53, .74, .93] };
    var SPEED = [64, 78, 92, 108];

    var slots = new Map();         // node -> { ring, base }
    var radii = RING_RADII[4];
    var elapsed = 0, mult = 1, last = null;
    var filter = 'all', running = false, raf = null;

    function assign(items) {
      var ringCount = Math.min(4, Math.max(1, Math.ceil(items.length / 4)));
      var rad = RING_RADII[ringCount];
      var total = rad.reduce(function (a, b) { return a + b; }, 0);
      var counts = rad.map(function (x) { return Math.floor(x / total * items.length); });
      var used = counts.reduce(function (a, b) { return a + b; }, 0);
      rad.map(function (x, i) { return { rem: x / total * items.length - counts[i], i: i }; })
         .sort(function (a, b) { return b.rem - a.rem; })
         .slice(0, items.length - used)
         .forEach(function (o) { counts[o.i]++; });
      var map = new Map(), d = 0;
      counts.forEach(function (cnt, ring) {
        for (var a = 0; a < cnt; a++) { var it = items[d++]; if (it) map.set(it, { ring: ring, base: a / cnt }); }
      });
      slots = map; radii = rad;
    }

    function visible() {
      return filter === 'all' ? nodes : nodes.filter(function (n) { return n.getAttribute('data-node') === filter; });
    }

    function render() {
      var h = stage.clientHeight;
      if (!h) return;
      for (var k = 0; k < nodes.length; k++) {
        var n = nodes[k], s = slots.get(n);
        if (!s) { n.style.opacity = '0'; n.style.pointerEvents = 'none'; continue; }
        var r = radii[s.ring] * h;
        var dir = (s.ring % 2) ? -1 : 1;
        var frac = ((s.base + elapsed / SPEED[s.ring] * dir) % 1 + 1) % 1;
        var ang = 18 + frac * 144;
        var c = ang * Math.PI / 180;
        var edge = Math.min(ang - 18, 162 - ang);
        var x = r * Math.cos(c), y = -r * Math.sin(c);
        n.style.transform = 'translate(-50%,-50%) translate(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px)';
        n.style.opacity = (Math.max(0, Math.min(1, edge / 16)) * mult).toFixed(3);
        n.style.pointerEvents = 'auto';
      }
    }

    function tick(ts) {
      if (last == null) last = ts;
      elapsed += (ts - last) / 1000; last = ts;
      render();
      if (running) raf = requestAnimationFrame(tick);
    }
    function start() { if (running) return; running = true; last = null; raf = requestAnimationFrame(tick); }
    function stop() { running = false; if (raf) cancelAnimationFrame(raf); raf = null; }

    function apply() {
      assign(visible());
      render();
    }

    function setFilter(f) {
      filter = f;
      groups.forEach(function (g) {
        g.style.display = (f === 'all' || g.getAttribute('data-stack-group') === f) ? '' : 'none';
      });
      if (reduce || !stage.clientHeight) { apply(); render(); return; }
      var from = mult, t0 = performance.now();
      (function out(ts) {
        var p = Math.min((ts - t0) / 220, 1);
        mult = from * (1 - p); render();
        if (p < 1) requestAnimationFrame(out);
        else {
          assign(visible());
          var t1 = performance.now();
          (function inn(ts2) { var q = Math.min((ts2 - t1) / 220, 1); mult = q; render(); if (q < 1) requestAnimationFrame(inn); })(performance.now());
        }
      })(performance.now());
    }

    btns.forEach(function (b) {
      b.addEventListener('click', function () {
        btns.forEach(function (x) { x.classList.remove('is-active'); x.setAttribute('aria-pressed', 'false'); });
        b.classList.add('is-active'); b.setAttribute('aria-pressed', 'true');
        setFilter(b.getAttribute('data-stack-btn'));
      });
    });

    apply();

    function onVisible() {
      if (stage.clientHeight > 0) { apply(); start(); }
    }

    if (reduce) { render(); return; }

    start();

    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) { if (en.isIntersecting) onVisible(); else stop(); });
      }, { threshold: 0 });
      io.observe(stage);
    }
    if ('ResizeObserver' in window) {
      new ResizeObserver(function () { if (stage.clientHeight > 0) { apply(); if (!running) start(); } }).observe(stage);
    }
    window.addEventListener('load', onVisible);
    window.addEventListener('resize', render);

    wrap.querySelectorAll('.orbit-arc').forEach(function (path) {
      try {
        var L = path.getTotalLength();
        path.style.strokeDasharray = L; path.style.strokeDashoffset = L;
        path.getBoundingClientRect();
        path.style.transition = 'stroke-dashoffset 1.1s ease';
        path.style.strokeDashoffset = '0';
      } catch (err) { /* ignore */ }
    });
  }

  /* ---- Button click ripple (techcadd-style expanding circle) ---- */
  function ripple() {
    if (reduce) return;
    var style = document.createElement('style');
    style.textContent =
      '.tc-ripple-host{position:relative;overflow:hidden;}' +
      '.tc-ripple{position:absolute;border-radius:9999px;pointer-events:none;' +
        'transform:scale(0);background:currentColor;opacity:.32;' +
        'animation:tcRipple .62s cubic-bezier(.22,.61,.36,1) forwards;}' +
      '@keyframes tcRipple{to{transform:scale(2.6);opacity:0;}}';
    document.head.appendChild(style);

    var sel = 'button, a.brand-fill, a.accent-fill, a.rounded-full, .ripple';
    document.addEventListener('pointerdown', function (e) {
      var el = e.target && e.target.closest ? e.target.closest(sel) : null;
      if (!el || el.disabled) return;
      var r = el.getBoundingClientRect();
      if (!r.width || !r.height) return;
      var size = Math.max(r.width, r.height);
      var span = document.createElement('span');
      span.className = 'tc-ripple';
      span.style.width = span.style.height = size + 'px';
      span.style.left = (e.clientX - r.left - size / 2) + 'px';
      span.style.top = (e.clientY - r.top - size / 2) + 'px';
      el.classList.add('tc-ripple-host');
      el.appendChild(span);
      span.addEventListener('animationend', function () { span.remove(); });
    }, { passive: true });
  }

  document.addEventListener('DOMContentLoaded', function () {
    reveal(); counters(); faqs(); rails(); stacks(); ripple();
  });
})();
