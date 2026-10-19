/* ============================================================
   Cookie & Privacy Consent — behaviour
   Mirrors techcaddmohali.com consent logic:
   - auto-opens ~1.2s after load when no choice is stored
   - "Cookie Settings" (footer) reopens it, expanded
   - 4 categories, stored in localStorage + a 1-year cookie
   - Accept All / Reject Non-Essential / Save Preferences
   Plain JS so it works on every page.
   ============================================================ */
(function () {
  'use strict';

  var VERSION = '1.6.1';
  var STORAGE_KEY = 'techno_coderz_cookie_consent';
  var COOKIE_NAME = 'techno_coderz_cookie_consent';
  var AUTO_DELAY_MS = 1200;
  var CATEGORY_KEYS = ['necessary', 'analytics', 'functional', 'marketing'];

  function defaultConsent() {
    return { necessary: true, analytics: false, functional: false, marketing: false, timestamp: 0, version: VERSION, consentId: '' };
  }

  function $(sel, root) { return (root || document).querySelector(sel); }

  /* ---------- persistence ---------- */
  function getStored() {
    try {
      var raw = window.localStorage.getItem(STORAGE_KEY);
      if (raw) {
        var o = JSON.parse(raw);
        if (o && typeof o.analytics === 'boolean') return o;
      }
    } catch (e) {}
    try {
      var m = document.cookie.match(new RegExp('(?:^|; )' + COOKIE_NAME + '=([^;]*)'));
      if (m) {
        var o2 = JSON.parse(decodeURIComponent(m[1]));
        if (o2 && typeof o2.analytics === 'boolean') return o2;
      }
    } catch (e) {}
    return null;
  }

  function store(consent) {
    consent.necessary = true;
    consent.timestamp = Date.now();
    consent.version = VERSION;
    if (!consent.consentId) consent.consentId = 'tc-cst-' + Math.random().toString(36).slice(2, 10);
    try { window.localStorage.setItem(STORAGE_KEY, JSON.stringify(consent)); } catch (e) {}
    try {
      document.cookie = COOKIE_NAME + '=' + encodeURIComponent(JSON.stringify(consent)) +
        ';path=/;max-age=' + (365 * 24 * 60 * 60) + ';SameSite=Lax';
    } catch (e) {}
    return consent;
  }

  document.addEventListener('DOMContentLoaded', function () {
    var panel = document.getElementById('tccPanel');
    if (!panel) return;

    var list = document.getElementById('tccList');
    var toast = document.getElementById('tccToast');
    var switchEls = panel.querySelectorAll('[data-tcc-key]');
    var saveBtn = panel.querySelector('[data-tcc-act="save"]');
    var manageBtn = panel.querySelector('[data-tcc-act="manage"]');
    var expanded = false;

    /* Reflect a consent object onto the switches + pills */
    function paint(consent) {
      switchEls.forEach(function (el) {
        var key = el.getAttribute('data-tcc-key');
        var on = !!consent[key];
        el.setAttribute('aria-checked', on ? 'true' : 'false');
        var item = el.closest('.tcc-item');
        var pill = item ? item.querySelector('.tcc-pill') : null;
        if (pill && !el.disabled) {
          pill.className = 'tcc-pill ' + (on ? 'tcc-pill--on' : 'tcc-pill--off');
        }
      });
    }

    function readState() {
      var s = defaultConsent();
      switchEls.forEach(function (el) {
        s[el.getAttribute('data-tcc-key')] = el.getAttribute('aria-checked') === 'true';
      });
      s.necessary = true;
      return s;
    }

    function setExpanded(v) {
      expanded = !!v;
      if (list) list.classList.toggle('is-open', expanded);
      if (saveBtn) saveBtn.classList.toggle('is-shown', expanded);
      if (manageBtn) manageBtn.textContent = expanded ? 'Hide Cookie Breakdown \u2192' : 'Manage Preferences \u2192';
    }

    function open(expandList) {
      var stored = getStored();
      paint(stored || defaultConsent());
      setExpanded(expandList);
      panel.classList.add('is-open');
      panel.setAttribute('aria-hidden', 'false');
    }

    function close() {
      panel.classList.remove('is-open');
      panel.setAttribute('aria-hidden', 'true');
    }

    function showToast() {
      if (!toast) return;
      toast.classList.add('is-shown');
      window.setTimeout(function () { toast.classList.remove('is-shown'); }, 2500);
    }

    function save(consent) {
      store(consent);
      paint(consent);
      close();
      showToast();
      try {
        document.dispatchEvent(new CustomEvent('tc:cookie-consent', { detail: consent }));
      } catch (e) {}
    }

    /* Toggle switches */
    switchEls.forEach(function (el) {
      el.addEventListener('click', function () {
        if (el.disabled) return;
        var next = el.getAttribute('aria-checked') !== 'true';
        el.setAttribute('aria-checked', next ? 'true' : 'false');
        var item = el.closest('.tcc-item');
        var pill = item ? item.querySelector('.tcc-pill') : null;
        if (pill) pill.className = 'tcc-pill ' + (next ? 'tcc-pill--on' : 'tcc-pill--off');
      });
    });

    /* Buttons */
    panel.addEventListener('click', function (e) {
      var btn = e.target.closest('[data-tcc-act]');
      if (!btn) return;
      var act = btn.getAttribute('data-tcc-act');
      if (act === 'accept-all') {
        save({ necessary: true, analytics: true, functional: true, marketing: true, timestamp: 0, version: VERSION, consentId: '' });
      } else if (act === 'reject') {
        save({ necessary: true, analytics: false, functional: false, marketing: false, timestamp: 0, version: VERSION, consentId: '' });
      } else if (act === 'save') {
        save(readState());
      } else if (act === 'manage') {
        setExpanded(!expanded);
      } else if (act === 'close') {
        close();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && panel.classList.contains('is-open')) close();
    });

    /* Public opener + footer "Cookie Settings" buttons */
    window.openCookieSettings = function () { open(true); };
    document.addEventListener('click', function (e) {
      if (e.target.closest('[data-cookie-settings]')) {
        e.preventDefault();
        open(true);
      }
    });

    /* Auto-open once, unless a choice is already stored.
       If the homepage demo popup is showing, wait until it closes. */
    if (!getStored()) {
      var demo = document.getElementById('tcdpOverlay');
      window.setTimeout(function () {
        if (panel.classList.contains('is-open')) return;
        if (demo && demo.classList.contains('active')) {
          var iv = window.setInterval(function () {
            if (!demo.classList.contains('active')) { window.clearInterval(iv); open(false); }
          }, 600);
        } else {
          open(false);
        }
      }, AUTO_DELAY_MS);
    }
  });
})();
