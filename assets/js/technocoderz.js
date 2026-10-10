/* ============================================================
   Techno Coderz — Main JavaScript
   ============================================================ */

'use strict';

const TC = {

  // ----------------------------------------------------------
  // INIT
  // ----------------------------------------------------------
  init() {
    TC.preloader();
    TC.navbar();
    TC.mobileNav();
    TC.scrollReveal();
    TC.backToTop();
    TC.faq();
    TC.counters();
    TC.typingHero();
    TC.courseFilter();
  },

  // ----------------------------------------------------------
  // PRELOADER
  // ----------------------------------------------------------
  preloader() {
    const loader = document.getElementById('tc-preloader');
    if (!loader) return;
    window.addEventListener('load', () => {
      setTimeout(() => loader.classList.add('hidden'), 400);
    });
  },

  // ----------------------------------------------------------
  // NAVBAR SCROLL EFFECT
  // ----------------------------------------------------------
  navbar() {
    const nav = document.getElementById('tcNavbar');
    if (!nav) return;
    const onScroll = () => {
      nav.classList.toggle('scrolled', window.scrollY > 50);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  },

  // ----------------------------------------------------------
  // MOBILE NAV — close menu after navigating
  // ----------------------------------------------------------
  mobileNav() {
    const menu = document.getElementById('tcNavMenu');
    if (!menu) return;
    menu.querySelectorAll('a.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        if (window.bootstrap && bootstrap.Collapse.getInstance(menu)) {
          bootstrap.Collapse.getOrCreateInstance(menu).hide();
        }
      });
    });
  },

  // ----------------------------------------------------------
  // SCROLL REVEAL
  // ----------------------------------------------------------
  scrollReveal() {
    const elements = document.querySelectorAll('.reveal');
    if (!elements.length) return;
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12 });
    elements.forEach(el => io.observe(el));
  },

  // ----------------------------------------------------------
  // BACK TO TOP
  // ----------------------------------------------------------
  backToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;
    window.addEventListener('scroll', () => {
      btn.classList.toggle('show', window.scrollY > 400);
    }, { passive: true });
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  },

  // ----------------------------------------------------------
  // FAQ ACCORDION
  // ----------------------------------------------------------
  faq() {
    document.querySelectorAll('.tc-faq-q').forEach(btn => {
      btn.addEventListener('click', () => {
        const item = btn.closest('.tc-faq-item');
        const isOpen = item.classList.contains('open');
        // Close all
        document.querySelectorAll('.tc-faq-item.open').forEach(el => el.classList.remove('open'));
        // Open clicked if was closed
        if (!isOpen) item.classList.add('open');
      });
    });
  },

  // ----------------------------------------------------------
  // ANIMATED COUNTERS
  // ----------------------------------------------------------
  counters() {
    const counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseInt(el.dataset.count);
        const suffix = el.dataset.suffix || '';
        let current = 0;
        const step = Math.ceil(target / 60);
        const interval = setInterval(() => {
          current = Math.min(current + step, target);
          el.textContent = current + suffix;
          if (current >= target) clearInterval(interval);
        }, 25);
        io.unobserve(el);
      });
    }, { threshold: 0.5 });
    counters.forEach(el => io.observe(el));
  },

  // ----------------------------------------------------------
  // HERO TYPING EFFECT
  // ----------------------------------------------------------
  typingHero() {
    const el = document.getElementById('tcTypingText');
    if (!el) return;
    const words = [
      'Full Stack Web Development',
      'Core Java Development',
      'PHP & MySQL',
      'PHP & Laravel Framework',
      'Frontend Development',
      'JavaScript Mastery',
      'React Basics & Beyond'
    ];
    let wi = 0, ci = 0, deleting = false;

    function type() {
      const word = words[wi];
      if (!deleting) {
        el.textContent = word.slice(0, ++ci);
        if (ci === word.length) {
          deleting = true;
          setTimeout(type, 1800);
          return;
        }
      } else {
        el.textContent = word.slice(0, --ci);
        if (ci === 0) {
          deleting = false;
          wi = (wi + 1) % words.length;
        }
      }
      setTimeout(type, deleting ? 35 : 75);
    }
    type();
  },

  // ----------------------------------------------------------
  // COURSES PAGE — level filter + live search
  // ----------------------------------------------------------
  courseFilter() {
    const grid = document.getElementById('courseGrid');
    if (!grid) return;

    const chips = Array.from(document.querySelectorAll('#courseChips .tc-btn, #courseChips .tc-chip'));
    const search = document.getElementById('courseSearch');
    const empty = document.getElementById('courseEmpty');
    const items = Array.from(grid.querySelectorAll('.course-item'));
    let level = 'all';

    const apply = () => {
      const q = (search && search.value ? search.value : '').trim().toLowerCase();
      let visible = 0;
      items.forEach(item => {
        const matchLevel = level === 'all' || (item.dataset.level || '') === level;
        const matchText = !q || (item.dataset.search || '').includes(q);
        const show = matchLevel && matchText;
        item.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      if (empty) empty.style.display = visible ? 'none' : 'block';
    };

    chips.forEach(chip => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        level = chip.dataset.level || 'all';
        apply();
      });
    });

    if (search) search.addEventListener('input', apply);

    // Apply search term that was passed in via URL (e.g. ?q=php)
    if (search && search.value.trim()) apply();
  },

};

// ----------------------------------------------------------
// TOAST NOTIFICATION
// ----------------------------------------------------------
function tcToast(message, type = 'success') {
  const wrap = document.getElementById('tcToastWrap');
  if (!wrap) return;
  const toast = document.createElement('div');
  const icon  = type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill';
  const color = type === 'success' ? 'var(--tc-secondary)' : 'var(--tc-accent)';
  toast.style.cssText = `
    display:flex;align-items:center;gap:12px;
    background:var(--tc-dark-card);border:1px solid var(--tc-border);
    border-radius:12px;padding:14px 18px;margin-bottom:10px;
    box-shadow:var(--tc-shadow-card);font-size:0.87rem;color:#fff;
    animation:toastIn 0.3s ease;min-width:280px;max-width:380px;
  `;
  toast.innerHTML = `<i class="bi bi-${icon}" style="color:${color};font-size:1.1rem;flex-shrink:0"></i><span>${message}</span>`;
  wrap.appendChild(toast);
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s ease';
    setTimeout(() => toast.remove(), 350);
  }, 4000);
}

// Toast animation
const style = document.createElement('style');
style.textContent = `@keyframes toastIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}`;
document.head.appendChild(style);

// ----------------------------------------------------------
// ENQUIRY FORM
// ----------------------------------------------------------
function openEnquiry(courseName = '') {
  const select = document.getElementById('enqCourse');
  if (select && courseName) {
    for (let opt of select.options) {
      if (opt.value === courseName || opt.text === courseName) {
        opt.selected = true;
        break;
      }
    }
  }
  const modal = new bootstrap.Modal(document.getElementById('enquiryModal'));
  modal.show();
}

function submitEnquiry() {
  const btn = document.getElementById('submitEnquiry');
  const msgDiv = document.getElementById('enquiryMsg');

  const name    = document.getElementById('enqName').value.trim();
  const email   = document.getElementById('enqEmail').value.trim();
  const phone   = document.getElementById('enqPhone').value.trim();
  const course  = document.getElementById('enqCourse').value.trim();
  const message = document.getElementById('enqMessage').value.trim();
  const csrf    = document.getElementById('enquiryCsrf').value;

  if (!name || !email || !course) {
    showFormMsg(msgDiv, 'Please fill in Name, Email, and Course.', 'danger');
    return;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showFormMsg(msgDiv, 'Please enter a valid email address.', 'danger');
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';

  const fd = new FormData();
  fd.append('name', name);
  fd.append('email', email);
  fd.append('phone', phone);
  fd.append('course', course);
  fd.append('message', message);
  fd.append('csrf_token', csrf);

  fetch(window.TC_BASE_URL + '/ajax/enquiry.php', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      document.getElementById('enquiryForm').reset();
      bootstrap.Modal.getInstance(document.getElementById('enquiryModal')).hide();
      tcToast('Enquiry submitted successfully! We\'ll contact you soon.', 'success');
    } else {
      showFormMsg(msgDiv, data.message || 'Something went wrong. Please try again.', 'danger');
    }
  })
  .catch(() => {
    showFormMsg(msgDiv, 'Network error. Please check your connection.', 'danger');
  })
  .finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-send-fill"></i> Send Enquiry';
  });
}

// ----------------------------------------------------------
// CONTACT FORM
// ----------------------------------------------------------
function submitContact() {
  const btn = document.getElementById('submitContact');
  const msgDiv = document.getElementById('contactMsg');

  const name    = document.getElementById('ctName').value.trim();
  const email   = document.getElementById('ctEmail').value.trim();
  const phone   = document.getElementById('ctPhone').value.trim();
  const courseEl = document.getElementById('ctCourse');
  const course  = courseEl ? courseEl.value.trim() : '';
  const message = document.getElementById('ctMessage').value.trim();
  const csrf    = document.getElementById('ctCsrf').value;
  const subject = document.getElementById('ctSubject');
  const subjectVal = subject ? subject.value.trim() : '';

  if (!name || !email || !phone || !message) {
    showFormMsg(msgDiv, 'Name, Email, Mobile Number and Message are required.', 'danger');
    return;
  }

  if (courseEl && !course) {
    showFormMsg(msgDiv, 'Please select the course you are interested in.', 'danger');
    return;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showFormMsg(msgDiv, 'Please enter a valid email address.', 'danger');
    return;
  }

  if (phone.replace(/\D/g, '').length < 10) {
    showFormMsg(msgDiv, 'Please enter a valid 10-digit mobile number.', 'danger');
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';

  const fd = new FormData();
  fd.append('name', name);
  fd.append('email', email);
  fd.append('phone', phone);
  fd.append('course', course);
  fd.append('subject', subjectVal);
  fd.append('message', message);
  fd.append('csrf_token', csrf);

  fetch(window.TC_BASE_URL + '/ajax/contact.php', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      document.getElementById('contactForm').reset();
      showFormMsg(msgDiv, '✓ Enquiry sent! We\'ll call you back within 24 hours.', 'success');
      tcToast('Your enquiry has been received!', 'success');
    } else {
      showFormMsg(msgDiv, data.message || 'Something went wrong.', 'danger');
    }
  })
  .catch(() => {
    showFormMsg(msgDiv, 'Network error. Please try again.', 'danger');
  })
  .finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-send-fill"></i> Send Enquiry';
  });
}

// ----------------------------------------------------------
// HELPERS
// ----------------------------------------------------------
function showFormMsg(el, text, type) {
  el.style.display = 'block';
  el.innerHTML = `<div class="alert alert-${type} py-2 px-3 mb-0" style="font-size:0.87rem;border-radius:8px">${text}</div>`;
}

// ----------------------------------------------------------
// DOM READY
// ----------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => TC.init());
