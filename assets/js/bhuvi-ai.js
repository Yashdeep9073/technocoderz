/* ============================================================
   Bhuvi AI — floating assistant (Techno Coderz)
   Layout / behaviour mirrored from techcaddmohali.com Bhuvi AI,
   re-themed to Techno Coderz (orange) with our own knowledge base.
   Reads config from window.BHUVI_CONFIG (injected by includes/bhuvi-ai.php).
   ============================================================ */
(function () {
  'use strict';

  var CFG = window.BHUVI_CONFIG || {};
  var SITE    = CFG.site || 'Techno Coderz';
  var PHONE   = CFG.phone || '+91 98765 43210';
  var PHONE2  = CFG.phone2 || '';
  var EMAIL   = CFG.email || 'info@technocoderz.com';
  var ADDRESS = CFG.address || 'Mohali, Punjab, India';
  var URLS = CFG.urls || {};
  var CATS = CFG.categories || [];
  var COURSE_COUNT = CFG.courseCount || 0;
  var TOP = CFG.topCourses || [];

  function link(href, label) { return { label: label, href: href }; }
  function U(key, fallback) { return URLS[key] || fallback; }

  /* ---------- Knowledge base ---------- */
  var TOPICS = [
    {
      keys: ['best course', 'best courses', 'which course', 'recommend', 'suggest', 'popular', 'trending'],
      reply: function () {
        var t = TOP.join(', ');
        return {
          text: 'Great question! The most in-demand tracks at ' + SITE + ' right now are Full Stack Development (MERN / PHP), Artificial Intelligence & Data Science, Cyber Security, Cloud & DevOps and Digital Marketing.\n\n' +
                (t ? 'A few top picks: ' + t + '.\n\n' : '') +
                'Tell me your background (student / graduate / working professional) and I will point you to the right track.',
          actions: [link(U('courses', 'courses.php'), 'Browse all ' + (COURSE_COUNT || '') + ' courses'), link(U('contact', 'contact.php'), 'Book a free demo')]
        };
      }
    },
    {
      keys: ['freelanc', 'side income', 'own clients'],
      reply: function () {
        return {
          text: 'To start freelancing, pick one stack and get genuinely good at it — Web Development (PHP / MERN) and Digital Marketing are the fastest to monetise.\n\n' +
                'Our project-first training means you finish with real portfolio work, which is exactly what clients look for. You also get mentorship on pitching and pricing.',
          actions: [link(U('courses', 'courses.php'), 'See web development courses'), link(U('contact', 'contact.php'), 'Talk to a mentor')]
        };
      }
    },
    {
      keys: ['after 12th', '12th', '12 pass', 'intermediate', 'after +2', 'stream'],
      reply: function () {
        return {
          text: 'After 12th you can absolutely start a tech career. We run dedicated After-12th tracks in 6-month and 1-year formats across Full Stack, AI, Data Science, Cyber Security, Digital Marketing and CAD (Civil / Architecture / Mechanical).\n\n' +
                'Most beginner tracks assume zero coding experience, so you start from the fundamentals.',
          actions: [link(U('courses', 'courses.php'), 'Explore After-12th courses'), link(U('contact', 'contact.php'), 'Free career counselling')]
        };
      }
    },
    {
      keys: ['ai career', 'artificial intelligence', 'ai course', 'machine learning', 'data science', 'ai job', 'generative'],
      reply: function () {
        return {
          text: 'AI is the fastest-growing hiring area in Mohali and the tricity. We offer AI, Machine Learning, Data Science and Generative-AI oriented modules — taught with live projects so you build deployed models, not just theory.\n\n' +
                'These are a great fit if you already enjoy maths / logic or want to move into analytics and ML roles.',
          actions: [link(U('courses', 'courses.php'), 'View AI & Data courses'), link(U('contact', 'contact.php'), 'Ask a counsellor')]
        };
      }
    },
    {
      keys: ['fees', 'fee', 'price', 'cost', 'charge', 'duration', 'how long', 'how many months', 'months', 'emi', 'installment'],
      reply: function () {
        return {
          text: 'Fees depend on the track and duration. Our programmes run from short 45-day / 6-week modules up to 6-month and 9-month professional tracks.\n\n' +
                'We keep it transparent — no hidden charges, and flexible payment options are available. The exact fee for your chosen course is confirmed on the free counselling call.',
          actions: [link(U('contact', 'contact.php'), 'Get exact fees'), link(U('courses', 'courses.php'), 'Compare courses')]
        };
      }
    },
    {
      keys: ['placement', 'job', 'placement cell', 'hiring', 'salary', 'package', 'lpa', 'interview', 'drive', 'recruit'],
      reply: function () {
        return {
          text: 'Our placement cell supports you until you are placed — resume & LinkedIn rebuilding, mock technical and HR interviews, aptitude practice, and hiring drives with partner companies across Mohali, Chandigarh and beyond.\n\n' +
                'We have a growing network of 450+ hiring partners and a strong placement record.',
          actions: [link(U('placement', 'career.php'), 'See placements'), link(U('contact', 'contact.php'), 'Talk to placement team')]
        };
      }
    },
    {
      keys: ['career switch', 'switch', 'change career', 'non it', 'commerce', 'bcom', 'working professional', 'job change'],
      reply: function () {
        return {
          text: 'Switching careers into tech is very doable here. We have worked with commerce grads, BCA/BSc students, working professionals and complete beginners.\n\n' +
                'Evening and weekend batches let you learn without leaving your current job. We start from the basics and build up to a job-ready portfolio.',
          actions: [link(U('courses', 'courses.php'), 'Find your track'), link(U('contact', 'contact.php'), 'Free counselling')]
        };
      }
    },
    {
      keys: ['admission', 'admissions', 'enroll', 'enrol', 'join', 'register', 'apply', 'batch', 'timing', 'demo'],
      reply: function () {
        return {
          text: 'Admissions are open and seats are limited per batch (we keep batches small on purpose).\n\n' +
                'The process is simple: book a free demo → attend a counselling session → confirm your batch.\n\n' +
                'Call ' + PHONE + (PHONE2 ? ' / ' + PHONE2 : '') + ' or email ' + EMAIL + ' to reserve a seat.',
          actions: [link(U('contact', 'contact.php'), 'Book a free demo'), link('tel:' + (CFG.phoneRaw || PHONE.replace(/\s+/g, '')), 'Call now')]
        };
      }
    },
    {
      keys: ['contact', 'phone', 'call', 'email', 'address', 'location', 'where', 'reach', 'visit', 'map'],
      reply: function () {
        return {
          text: 'You can reach us here:\n' +
                '📍 ' + ADDRESS + '\n' +
                '📞 ' + PHONE + (PHONE2 ? ' / ' + PHONE2 : '') + '\n' +
                '✉️ ' + EMAIL + '\n\n' +
                'Walk-ins are welcome — just book a slot so a counsellor is free when you arrive.',
          actions: [link(U('contact', 'contact.php'), 'Contact page'), link('tel:' + (CFG.phoneRaw || PHONE.replace(/\s+/g, '')), 'Call now')]
        };
      }
    },
    {
      keys: ['certificate', 'verification', 'verify', 'credential', 'iso'],
      reply: function () {
        return {
          text: 'Every course ends with a certificate you can show employers. We also provide an online certificate verification page, so anyone can confirm a ' + SITE + ' certificate is genuine using its certificate number.',
          actions: [link(U('verify', 'certificate-verification.php'), 'Verify a certificate')]
        };
      }
    },
    {
      keys: ['project', 'portfolio', 'capstone', 'internship'],
      reply: function () {
        return {
          text: 'You will build real, portfolio-ready projects — not just watch tutorials. Interviewers love that you can talk through code you actually wrote.\n\n' +
                'You can browse some of the work built by our team and students.',
          actions: [link(U('projects', 'projects.php'), 'See projects')]
        };
      }
    },
    {
      keys: ['online', 'offline', 'hybrid', 'remote', 'weekend', 'evening', 'part time', 'college'],
      reply: function () {
        return {
          text: 'We offer weekday, evening, weekend and online/hybrid options so you can learn alongside college or a job. Batch timings are confirmed at enrolment.',
          actions: [link(U('contact', 'contact.php'), 'Check batch timings')]
        };
      }
    },
  ];

  function greet() {
    return {
      text: 'Hi! I am Bhuvi, the ' + SITE + ' assistant. 👋\n\nAsk me about courses, fees & duration, placements, After-12th options or admissions — or tap a quick option below.',
      actions: []
    };
  }

  function respond(input) {
    var q = String(input || '').toLowerCase().trim();
    if (/^(hi+|hey+|hello+|namaste|help|good (morning|evening|afternoon))\b/.test(q)) return greet();
    for (var i = 0; i < TOPICS.length; i++) {
      var t = TOPICS[i];
      for (var k = 0; k < t.keys.length; k++) {
        if (q.indexOf(t.keys[k]) !== -1) return t.reply();
      }
    }
    // Fallback
    return {
      text: 'Good question! I can help with course selection, fees & duration, placements, After-12th tracks, career switching, certificates and admissions.\n\n' +
            'For anything specific, our counsellors will give you an exact answer.',
      actions: [link(U('courses', 'courses.php'), 'Browse courses'), link(U('contact', 'contact.php'), 'Talk to a counsellor')]
    };
  }

  /* ---------- DOM ---------- */
  var root = document.getElementById('bhuviRoot');
  if (!root) return;
  var panel = document.getElementById('bhuviPanel');
  var launcher = document.getElementById('bhuviLauncher');
  var closeBtn = root.querySelector('.bhui-close');
  var body = document.getElementById('bhuviBody');
  var input = document.getElementById('bhuviInput');
  var send = document.getElementById('bhuviSend');
  var chipsWrap = document.getElementById('bhuviChips');
  var opened = false;
  var greeted = false;

  function scrollDown() { body.scrollTop = body.scrollHeight; }

  function addBubble(html, who) {
    var wrap = document.createElement('div');
    wrap.className = 'bhui-msg bhui-msg--' + who;
    var b = document.createElement('div');
    b.className = 'bhui-bubble';
    b.innerHTML = html;
    wrap.appendChild(b);
    body.appendChild(wrap);
    scrollDown();
    return b;
  }

  function esc(s) {
    return String(s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function renderBot(res) {
    var html = esc(res.text).replace(/\n/g, '<br>');
    var bubble = addBubble(html, 'bot');
    if (res.actions && res.actions.length) {
      var row = document.createElement('div');
      row.className = 'bhui-actions';
      res.actions.forEach(function (a) {
        var el = document.createElement('a');
        el.className = 'bhui-action';
        el.href = a.href;
        el.textContent = a.label;
        el.addEventListener('click', function () {
          if (/^tel:/.test(a.href)) return;
        });
        row.appendChild(el);
      });
      bubble.appendChild(row);
      scrollDown();
    }
  }

  function typing(on) {
    var existing = body.querySelector('.bhui-typing-msg');
    if (on) {
      if (existing) return;
      var wrap = document.createElement('div');
      wrap.className = 'bhui-msg bhui-msg--bot bhui-typing-msg';
      wrap.innerHTML = '<div class="bhui-bubble"><span class="bhui-typing"><span></span><span></span><span></span></span></div>';
      body.appendChild(wrap);
      scrollDown();
    } else if (existing) {
      existing.parentNode.removeChild(existing);
    }
  }

  function sendText(text) {
    var msg = String(text || '').trim();
    if (!msg) return;
    addBubble(esc(msg).replace(/\n/g, '<br>'), 'user');
    typing(true);
    var delay = Math.min(1100, 380 + msg.length * 18);
    window.setTimeout(function () {
      typing(false);
      renderBot(respond(msg));
    }, delay);
  }

  function open() {
    if (!panel || opened) return;
    opened = true;
    panel.classList.add('is-open');
    launcher.setAttribute('aria-expanded', 'true');
    if (!greeted) {
      greeted = true;
      window.setTimeout(function () {
        renderBot({
          text: 'Hi! I am Bhuvi, the ' + SITE + ' AI assistant. 🤖\nAsk me anything about courses, fees, placements or admissions — or tap a quick option below.',
          actions: []
        });
      }, 260);
    }
    window.setTimeout(function () { if (input) input.focus(); }, 320);
  }

  function close() {
    if (!panel || !opened) return;
    opened = false;
    panel.classList.remove('is-open');
    launcher.setAttribute('aria-expanded', 'false');
    launcher.focus();
  }

  launcher.addEventListener('click', function () { opened ? close() : open(); });
  if (closeBtn) closeBtn.addEventListener('click', close);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && opened) close(); });

  if (chipsWrap) {
    chipsWrap.addEventListener('click', function (e) {
      var chip = e.target.closest('.bhui-chip');
      if (!chip) return;
      sendText(chip.getAttribute('data-q') || chip.textContent);
    });
  }

  function autoGrow() {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    send.disabled = !input.value.trim();
  }
  input.addEventListener('input', autoGrow);
  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendText(input.value); input.value = ''; autoGrow(); }
  });
  send.addEventListener('click', function () { sendText(input.value); input.value = ''; autoGrow(); });

  autoGrow();
})();
