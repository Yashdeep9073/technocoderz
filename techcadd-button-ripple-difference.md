# Techcadd Button Ripple – Exact Difference vs Our Code

## Dekhna hai kya difference hai

Jab tu button pe touch karta hai techcadd.com pe, circle bilkul clear nazar aata hai. 
Tere code pe pehle circle nahi dikh raha tha kyunki **ripple content ke neeche chala ja raha tha** ya **button ka background cover kar raha tha**.

## Root Cause

- **Tere pehle wale fix me**: `.ripple-circle { z-index: -1; }` de rakha tha.
  - Ripple button ke background layer ke neeche chala jata hai.
  - Agar button pe solid background color hai (jaise fill button) to ripple kabhi dikh hi nahi pata.
  - Content (text/icon) uske upar tha lekin ripple khud hi hide ho raha tha.

- **Techcadd pe jo actual hai**:
  - Ripple ko `z-index: 1` pe rakha gaya hai.
  - Button ke andar jo saara content hai (text, span, svg) usko `z-index: 2` de rakha hai.
  - Taki circle **background pe** dikhaye, lekin **text ke neeche kabhi na jaye**.

## Sahi Fix (Bilkul Site Jaisa)

Bas ye CSS replace kro, JS wahi reh sakta hai bas check kar lo.

### CSS

```css
.btn,
button,
a.btn,
a.button,
.cta,
.cta-btn,
.nav-btn {
  position: relative;
  overflow: hidden;
  cursor: pointer;
  -webkit-tap-highlight-color: transparent;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  transform: translateZ(0);
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  transition: transform 50ms cubic-bezier(0.25, 0.1, 0.25, 1);
  will-change: transform;
  isolation: isolate;
}

.btn > *,
button > *,
a.btn > *,
a.button > *,
.cta > *,
.cta-btn > *,
.nav-btn > * {
  position: relative;
  z-index: 2;
}

.btn:active,
button:active,
a.btn:active,
a.button:active,
.cta:active,
.cta-btn:active,
.nav-btn:active {
  transform: scale(0.995) translateZ(0);
}

.ripple-circle {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
  background: rgba(255, 255, 255, 0.26);
  transform: scale(0) translateZ(0);
  opacity: 0.95;
  z-index: 1;
  will-change: transform, opacity;
  animation: btn-ripple 0.38s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
}

@keyframes btn-ripple {
  0% {
    transform: scale(0) translateZ(0);
    opacity: 0.95;
  }
  100% {
    transform: scale(2.25) translateZ(0);
    opacity: 0;
  }
}
```

### JS

```js
document.addEventListener("DOMContentLoaded", function () {
  const rippleEls = document.querySelectorAll(
    ".btn, button, a.btn, a.button, .cta, .cta-btn, .nav-btn"
  );

  rippleEls.forEach((el) => {
    el.addEventListener(
      "pointerdown",
      function (e) {
        const rect = el.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height) * 1.08;

        const ripple = document.createElement("span");
        ripple.classList.add("ripple-circle");

        ripple.style.width = size + "px";
        ripple.style.height = size + "px";

        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        ripple.style.left = x + "px";
        ripple.style.top = y + "px";

        el.appendChild(ripple);

        setTimeout(() => {
          ripple.remove();
        }, 380);
      },
      { passive: true }
    );
  });
});
```

## Main Takeaway

- **z-index: -1 hatao** aur **z-index: 1** lagao ripple ko
- **Button ke andar wale elements ko z-index: 2** do taaki text hamesha upar rahe
- **isolation: isolate** rakh lo taaki stacking context clean rahe

Bas ye teen cheez add/karo aur circle dikhega bilkul site jaisa.
