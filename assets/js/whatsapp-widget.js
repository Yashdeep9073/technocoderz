/* ============================================================
   Floating social stack + WhatsApp button (Techno Coderz)
   Behaviour mirrored from techcaddmohali.com bottom-right widget.
   ============================================================ */
(function () {
  'use strict';

  var stack = document.getElementById('tcSocialStack');
  if (!stack) return;
  var toggle = document.getElementById('tcSocialToggle');

  function setOpen(open) {
    stack.classList.toggle('is-open', open);
    if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  function isOpen() { return stack.classList.contains('is-open'); }

  if (toggle) {
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      setOpen(!isOpen());
    });
  }

  document.addEventListener('click', function (e) {
    if (isOpen() && !stack.contains(e.target)) setOpen(false);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isOpen()) setOpen(false);
  });
})();
