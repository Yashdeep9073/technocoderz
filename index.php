<?php
// ============================================================
// Techno Coderz — Homepage (database-driven featured projects)
// Reuses the existing DB layer; no backend logic changed.
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$csrf            = generateCsrfToken();
$featuredProjects = [];
try {
    $pdo = getDB();
    $featuredProjects = $pdo->query("SELECT * FROM projects WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll();
} catch (Throwable $e) {
    $featuredProjects = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technocoderz - Discover Your Path</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Footer typography: Inter + Space Grotesk (synced with includes/footer.php) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons (footer / contact icons — same as includes/footer.php) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            teal: '#084C61',
                            darkTeal: '#05313F',
                            orange: '#FF6B00',
                            redGradStart: '#FF7A00',
                            redGradEnd: '#E53835',
                            creamBg: '#FDFBF7',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDFBF7;
            color: #1A202C;
            overflow-x: hidden;
        }
.hc-wrap {
    position: relative;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    align-items: stretch;
    width: 100%;
    max-width: 640px;
    height: 100%;
    min-height: 560px;
    margin: 0 auto;
    padding: 20px;
}
.hc-wrap > div {
    display: flex;
    flex-direction: column;
    gap: 26px;
    min-width: 0;
}
.hc-wrap::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 70px; height: 110px;
    background-image: radial-gradient(#e8467c 1.5px, transparent 1.5px);
    background-size: 14px 14px;
    opacity: .6;
}
.hc-wrap::after {
    content: '';
    position: absolute;
    bottom: 30px; left: 38%;
    width: 150px; height: 130px;
    background-image: radial-gradient(#a78bfa 1.5px, transparent 1.5px);
    background-size: 14px 14px;
    opacity: .45;
    z-index: 0;
}
.hc-img {
    position: relative;
    z-index: 1;
    overflow: hidden;
    border-radius: 22px;
    transform: skewY(-3deg);
    box-shadow: 0 18px 36px rgba(5, 49, 63, .15);
    transition: transform .45s cubic-bezier(.2,.7,.3,1), box-shadow .45s ease;
    cursor: pointer;
}
.hc-img::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(150deg, rgba(8,76,97,.55), rgba(232,70,124,.35));
    opacity: 0;
    transition: opacity .45s ease;
    pointer-events: none;
    z-index: 2;
}
.hc-img img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: skewY(3deg) scale(1.12);
    transition: transform .6s cubic-bezier(.2,.7,.3,1), filter .45s ease;
}
.hc-img:hover {
    transform: skewY(-3deg) translateY(-10px) scale(1.03);
    box-shadow: 0 30px 55px rgba(5, 49, 63, .3);
    z-index: 5;
}
.hc-img:hover img {
    transform: skewY(3deg) scale(1.24);
    filter: saturate(1.15);
}
.hc-img:hover::after { opacity: 1; }
.hc-img-tall  { height: auto; min-height: 540px; flex: 1; }
.hc-img-small { height: auto; min-height: 300px; flex: 1; }
.hc-badge {
    position: relative;
    z-index: 2;
    flex: 0 0 auto;
    padding: 26px 18px;
    text-align: center;
    color: #fff;
    border-radius: 18px;
    background: linear-gradient(135deg, #ff7a00 0%, #e8467c 60%, #c0267e 100%);
    box-shadow: 0 12px 24px rgba(232, 70, 124, .25);
    transition: transform .4s cubic-bezier(.2,.7,.3,1), box-shadow .4s ease, filter .4s ease;
    cursor: pointer;
}
.hc-badge:hover {
    transform: translateY(-8px) scale(1.04);
    box-shadow: 0 24px 42px rgba(232, 70, 124, .42);
    filter: brightness(1.06);
}
.hc-badge b    { display: block; font-size: 52px; font-weight: 800; line-height: 1; }
.hc-badge span { display: block; margin-top: 8px; font-size: 16px; font-weight: 500; }

@media (max-width: 575.98px) {
    .hc-wrap { gap: 14px; padding: 10px; min-height: 0; height: auto; }
    .hc-wrap > div { gap: 14px; }
    .hc-img-tall  { min-height: 320px; }
    .hc-img-small { min-height: 240px; }
    .hc-badge b { font-size: 36px; }
    .hc-badge span { font-size: 13px; }
}
        /* Hero headline: fluid type, zero horizontal translation */
        .tc-hero-title {
            font-size: clamp(1.75rem, 4vw, 3rem);
            transform: none;
        }

        .tc-hero-lead {
            transform: none;
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .tc-hero-title {
                font-size: clamp(1.75rem, 4vw, 3rem);
                transform: none;
            }

            .tc-hero-lead {
                transform: none;
                margin-left: 0;
            }
        }

        /* Hero illustration — fill & centre the right column */
        .hero-image {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: heroFloat 6s ease-in-out infinite;
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-14px); }
        }

        .hero-vector {
            display: block;
            width: 100%;
            height: auto;
            max-height: 760px;
            object-fit: contain;
            filter: drop-shadow(0 24px 48px rgba(8, 76, 97, 0.18));
            transform: scale(1.18);
            transform-origin: center;
            cursor: pointer;
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), filter 0.4s ease;
        }

        .hero-vector:hover {
            transform: scale(1.28) rotate(-1.5deg);
            filter: drop-shadow(0 34px 64px rgba(8, 76, 97, 0.32));
        }

        @media (max-width: 1023.98px) {
            .hero-image {
                animation-duration: 7s;
            }

            .hero-vector {
                max-height: 520px;
                transform: scale(1.06);
            }

            .hero-vector:hover {
                transform: scale(1.1) rotate(-1deg);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .hero-image {
                animation: none;
            }

            .hero-vector {
                transition: none;
            }
        }

        /* Enquire Form Gradient Box Styling */
        .enquire-card-gradient {
            background: linear-gradient(145deg, #FF7B00 0%, #EE4327 50%, #D8262C 100%);
        }

        /* Custom image hover scale without breaking layout */
        .collage-img-box {
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.35s ease;
            will-change: transform;
        }

        .collage-img-box:hover {
            transform: scale(1.02) translateY(-2px);
            z-index: 25;
        }

        .vr-card-box {
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.35s ease;
        }

        .vr-card-box:hover {
            transform: scale(1.04) rotate(-1deg) translateY(-4px);
        }

        /* Smooth section anchor scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #FDFBF7;
        }

        ::-webkit-scrollbar-thumb {
            background: #084C61;
            border-radius: 4px;
        }
        

        /* ============================================================
           ENQUIRY POPUP — modern LMS white card (spec-locked values)
           IDs / names / handlers untouched — styling only
           ============================================================ */
        #enquireModal {
            animation: enquireFadeIn 0.22s ease;
        }

        #enquireModal .enquire-modal-card {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
            animation: enquirePopIn 0.25s cubic-bezier(0.2, 0.9, 0.3, 1.2);
        }

        @keyframes enquireFadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes enquirePopIn {
            from { opacity: 0; transform: translateY(18px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        #enquireModal .enquire-modal-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        #enquireModal .enquire-modal-close:hover {
            background: #ff6b00;
            color: #fff;
            border-color: #ff6b00;
            transform: rotate(90deg);
        }

        #hero-enquire-form input,
        #hero-enquire-form select {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        #hero-enquire-form input:hover,
        #hero-enquire-form select:hover {
            background-color: #f1f5f9;
        }

        #hero-enquire-form input:focus,
        #hero-enquire-form select:focus {
            background-color: #ffffff;
            border-color: #ff6b00;
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.15);
            outline: none;
        }

        #hero-enquire-form label span {
            transition: color 0.2s ease;
        }

        #hero-enquire-form .peer~span {
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        #hero-enquire-form button[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, #ff6b00 0%, #ff8800 100%);
            border-radius: 999px;
            box-shadow: 0 10px 22px rgba(255, 107, 0, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        #hero-enquire-form button[type="submit"]:hover {
            background: linear-gradient(135deg, #ff7a1a 0%, #ff9426 100%);
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(255, 107, 0, 0.32);
            filter: brightness(1.02);
        }

        #hero-enquire-form button[type="submit"]:active {
            transform: translateY(0);
        }

        /* ============================================================
           FOOTER — synced with includes/footer.php (about.php footer)
           Same palette, typography, spacing and column structure
           ============================================================ */
        .tc-footer {
            position: relative;
            background: #0f1929;
            color: #e6e6e6;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 72px 0 0;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
        }

        .tc-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            opacity: 1;
        }

        .tc-footer-container {
            position: relative;
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 12px;
        }

        .tc-footer-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            margin: 0 -12px;
            row-gap: 40px;
        }

        .tc-footer-col {
            padding: 24px;
            min-width: 0;
        }

        .tc-footer-col-brand,
        .tc-footer-col-contact {
            grid-column: 1 / -1;
        }

        .tc-footer-logo {
            display: inline-block;
            margin-bottom: 20px;
        }

        .tc-footer-logo img {
            height: 45px;
            width: auto;
            display: block;
            filter: brightness(0) invert(1);
        }

        .tc-footer-desc {
            font-size: 0.87rem;
            color: #8b90b0;
            line-height: 1.75;
            margin-bottom: 22px;
            overflow-wrap: anywhere;
        }

        .tc-footer-heading {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 14.4px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.3;
            margin-bottom: 22px;
        }

        .tc-footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tc-footer-links li {
            margin-bottom: 12px;
            line-height: 24px;
        }

        .tc-footer-links a {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-size: 0.87rem;
            line-height: 1.45;
            color: #8b90b0;
            text-decoration: none;
            overflow-wrap: anywhere;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tc-footer-links a::before {
            content: '\203A';
            font-size: 1.1rem;
            line-height: 1;
            color: #ff6b00;
            flex-shrink: 0;
            transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tc-footer-links a:hover {
            color: #ff6b00;
            padding-left: 4px;
        }

        .tc-footer-links a:hover::before {
            color: #00d4aa;
        }

        .tc-social-links {
            display: flex;
            gap: 10px;
        }

        .tc-social-link {
            width: 38px;
            height: 38px;
            background: #181b33;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #8b90b0;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tc-social-link:hover {
            background: #ff6b00;
            border-color: #ff6b00;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .tc-footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #c9c9c9;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .tc-footer-contact-item i {
            color: #ff6b00;
            font-size: 1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .tc-footer-contact-item a {
            color: #8b90b0;
            text-decoration: none;
            transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tc-footer-contact-item a:hover {
            color: #ff6b00;
        }

        .tc-footer-cta {
            margin-top: 16px;
        }

        .tc-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tc-btn-primary {
            background: linear-gradient(135deg, #ff7b00 0%, #e55f00 100%);
            color: #ffffff;
        }

        .tc-btn-primary:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(255, 107, 0, 0.28);
        }

        .tc-btn-sm {
            padding: 9px 20px;
            font-size: 0.82rem;
            border-radius: 100px;
        }

        .tc-footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 22px 0;
            margin-top: 48px;
            color: #c9c9c9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px 28px;
        }

        .tc-footer-bottom p {
            font-size: 0.82rem;
            color: #c9c9c9;
            margin: 0;
        }

        .tc-footer-bottom-links {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .tc-footer-bottom-links a {
            font-size: 0.82rem;
            line-height: 1;
            color: #8b90b0;
            text-decoration: none;
            padding: 0 14px;
            margin-right: 16px;
            border-right: 1px solid rgba(255, 255, 255, 0.16);
            transition: color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tc-footer-bottom-links a:first-child {
            padding-left: 0;
        }

        .tc-footer-bottom-links a:last-child {
            padding-right: 0;
            margin-right: 0;
            border-right: 0;
        }

        .tc-footer-bottom-links a:hover {
            color: #ff6b00;
        }

        /* Footer responsive container widths (mirrors Bootstrap .container) */
        @media (min-width: 576px) {
            .tc-footer-container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .tc-footer-container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .tc-footer-container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .tc-footer-container {
                max-width: 1140px;
            }
        }

        @media (min-width: 1400px) {
            .tc-footer-container {
                max-width: 1320px;
            }
        }

        /* Footer responsive column spans (mirrors Bootstrap col-lg/col-md/col-6) */
        @media (min-width: 768px) {
            .tc-footer-grid {
                grid-template-columns: repeat(12, 1fr);
            }

            .tc-footer-col-brand,
            .tc-footer-col-quick,
            .tc-footer-col-courses,
            .tc-footer-col-contact {
                grid-column: span 6;
            }
        }

        @media (min-width: 992px) {
            .tc-footer-col-brand {
                grid-column: span 4;
            }

            .tc-footer-col-quick {
                grid-column: span 2;
            }

            .tc-footer-col-courses {
                grid-column: span 3;
            }

            .tc-footer-col-contact {
                grid-column: span 3;
            }
        }

        @media (max-width: 767.98px) {
            .tc-footer {
                padding: 56px 0 0;
            }

            .tc-footer-bottom {
                text-align: center;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .tc-footer-grid {
                row-gap: 30px;
            }

            .tc-footer-heading {
                margin-bottom: 18px;
            }

            .tc-footer-bottom {
                flex-direction: column;
                align-items: center;
                text-align: center;
                margin-top: 34px;
            }

            .tc-footer-bottom-links {
                justify-content: center;
            }

            .tc-footer-bottom-links a {
                padding: 0 10px;
            }
        }

        /* ============================================================
           FEATURED PROJECTS (database-driven) — card polish
           ============================================================ */
        .tc-featured-card {
            will-change: transform, box-shadow;
        }

        .tc-featured-card:hover {
            transform: translateY(-6px);
        }

        .tc-featured-cover {
            background:
                radial-gradient(circle at 78% 18%, rgba(27, 114, 232, 0.35) 0%, rgba(27, 114, 232, 0) 55%),
                linear-gradient(150deg, #05313F 0%, #084C61 100%);
        }

        .tc-featured-cover-icon {
            font-size: 2.4rem;
            color: rgba(255, 255, 255, 0.92);
            filter: drop-shadow(0 10px 18px rgba(0, 0, 0, 0.28));
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .tc-featured-card:hover .tc-featured-cover-icon {
            transform: scale(1.08) translateY(-3px);
        }

        .tc-featured-cover-code {
            position: absolute;
            right: 16px;
            bottom: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1;
            color: rgba(255, 255, 255, 0.10);
            letter-spacing: -1px;
            user-select: none;
        }

        /* ============================================================
           OUR SUCCESS STORIES — premium floating image gallery
           ============================================================ */
        .tc-success-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
        }

        .tc-success-item {
            will-change: transform;
            animation: tc-float 6s ease-in-out infinite;
        }

        .tc-success-card {
            position: relative;
            display: block;
            border-radius: 20px;
            overflow: hidden;
            background: #0b2230;
            box-shadow: 0 14px 30px rgba(5, 49, 63, 0.14);
            transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.45s ease;
        }

        .tc-success-card img {
            display: block;
            width: 100%;
            height: 260px;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), filter 0.45s ease;
        }

        .tc-success-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.10);
            box-shadow: inset 0 -60px 70px -40px rgba(5, 49, 63, 0.65);
            pointer-events: none;
        }

        .tc-success-card:hover {
            transform: translateY(-10px) scale(1.035);
            box-shadow: 0 26px 46px rgba(5, 49, 63, 0.28), 0 0 0 3px rgba(255, 107, 0, 0.18);
        }

        .tc-success-card:hover img {
            transform: scale(1.06);
            filter: saturate(1.06) brightness(1.02);
        }

        @keyframes tc-float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-9px);
            }
        }

        @media (max-width: 991.98px) {
            .tc-success-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
            }

            .tc-success-card img {
                height: 220px;
            }
        }

        @media (max-width: 575.98px) {
            .tc-success-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .tc-success-card img {
                height: 230px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .tc-success-item {
                animation: none;
            }

            .tc-success-card,
            .tc-success-card img {
                transition: none;
            }
        }

        /* ============================================================
           LEADERSHIP TEAM — image cards with hover zoom + highlight
           ============================================================ */
        .tc-team-card {
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.35s ease, border-color 0.35s ease;
            will-change: transform;
        }

        .tc-team-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(5, 49, 63, 0.16);
            border-color: rgba(255, 107, 0, 0.55);
        }

        .tc-team-photo {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4 / 4.35;
            min-height: 250px;
        }

        .tc-team-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            transition: transform 0.65s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .tc-team-card:hover .tc-team-photo img {
            transform: scale(1.09);
        }

        .tc-team-photo-overlay {
            opacity: 0.65;
            transition: opacity 0.4s ease;
        }

        .tc-team-card:hover .tc-team-photo-overlay {
            opacity: 1;
        }

        .tc-team-role-badge {
            transition: background-color 0.35s ease, color 0.35s ease;
        }

        .tc-team-card:hover .tc-team-role-badge {
            background-color: #FF6B00;
            color: #ffffff;
        }

        /* ============================================================
           TESTIMONIALS — modern quote cards with hover lift
           ============================================================ */
        .tc-testi-card {
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.35s ease, border-color 0.35s ease;
            will-change: transform;
        }

        .tc-testi-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px rgba(5, 49, 63, 0.14);
            border-color: rgba(255, 107, 0, 0.4);
        }

        .tc-testi-quote {
            transition: background-color 0.35s ease, transform 0.35s ease;
        }

        .tc-testi-card:hover .tc-testi-quote {
            background-color: #FF6B00;
            transform: rotate(-6deg);
        }

        .tc-testi-avatar {
            transition: transform 0.4s ease;
        }

        .tc-testi-card:hover .tc-testi-avatar {
            transform: scale(1.06);
        }

        /* ============================================================
           EMPOWER VISUAL — subtle 3D tilt + feature check highlights
           ============================================================ */
        .tc-empower-visual {
            transition: transform 0.55s cubic-bezier(0.25, 1, 0.5, 1), filter 0.55s ease;
            transform-style: preserve-3d;
        }

        .tc-empower-visual:hover {
            transform: perspective(1400px) rotateY(-4deg) rotateX(2deg) translateY(-6px) scale(1.015);
            filter: drop-shadow(0 30px 50px rgba(5, 49, 63, 0.18));
        }

        .tc-empower-check {
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        .tc-empower-item:hover .tc-empower-check {
            background-color: #FF6B00;
            color: #ffffff;
            transform: scale(1.12);
        }

        /* ============================================================
           HERO MEDIA GALLERY — 2-column staggered image collage
           ============================================================ */
        .tc-gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            border: 3px solid #ffffff;
            box-shadow: 0 16px 32px rgba(5, 49, 63, 0.12);
            transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.45s ease;
        }

        .tc-gallery-item img {
            display: block;
            width: 100%;
            height: 270px;
            object-fit: cover;
            transition: transform 0.65s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .tc-gallery-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 46px rgba(5, 49, 63, 0.2);
        }

        .tc-gallery-item:hover img {
            transform: scale(1.08);
        }

        @media (max-width: 991.98px) {
            .tc-gallery-item img {
                height: 190px;
            }
        }

        @media (max-width: 575.98px) {
            .tc-gallery-item img {
                height: 140px;
            }
        }

        /* ============================================================
           EVENT JOURNEY — Design B (home hero right column)
           ============================================================ */
        .event-journey {
            background: #fbfbfa;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 20px 40px rgba(8, 49, 61, .12);
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 10;
        }

        .ej-top {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
        }

        .ej-top img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        .ej-top-text {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(13, 31, 45, .75);
            color: #fff;
            padding: 10px 14px;
            border-radius: 6px;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .ej-top-subtitle {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            opacity: 0.9;
        }

        .ej-top-title {
            font-size: 1.05rem;
            font-weight: 800;
            margin-top: 2px;
            letter-spacing: .02em;
        }

        .ej-timeline-container {
            position: relative;
            margin-top: 16px;
            padding-bottom: 8px;
        }

        .ej-timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 1.5px;
            background: #cbd5e1;
            transform: translateX(-50%);
            z-index: 1;
        }

        .ej-time-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: center;
            position: relative;
            z-index: 2;
            background: #fbfbfa;
            padding: 4px 10px;
            font-size: .85rem;
            font-weight: 700;
            color: #475569;
            width: max-content;
            margin: 0 auto 16px;
        }

        .ej-time-badge svg {
            color: #64748b;
        }

        .ej-timeline-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            position: relative;
            z-index: 2;
            margin-bottom: 12px;
        }

        .ej-card-wrapper {
            position: relative;
            display: flex;
        }

        .ej-card-wrapper.left {
            justify-content: flex-end;
            padding-right: 18px;
        }

        .ej-card-wrapper.right {
            justify-content: flex-start;
            padding-left: 18px;
        }

        .ej-card {
            width: 100%;
            background: #fff;
            border-radius: 8px;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        }

        .ej-card img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 4px;
            display: block;
        }

        .ej-card-wrapper.left::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 18px;
            height: 1.5px;
            background: #cbd5e1;
        }

        .ej-card-wrapper.right::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 18px;
            height: 1.5px;
            background: #cbd5e1;
        }

        .ej-time-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            position: relative;
            z-index: 2;
            margin: 16px 0;
        }

        .ej-time {
            font-size: .85rem;
            font-weight: 700;
            color: #475569;
        }

        .ej-time.left {
            text-align: right;
            padding-right: 18px;
        }

        .ej-time.right {
            text-align: left;
            padding-left: 18px;
        }

        .ej-time-icon {
            width: 26px;
            height: 26px;
            background: #fbfbfa;
            border: 1.5px solid #cbd5e1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
        }

        .ej-footer {
            background: #1e293b;
            color: #fff;
            border-radius: 8px;
            padding: 18px 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            box-shadow: 0 10px 20px rgba(30, 41, 59, .15);
        }

        .ej-footer-text {
            font-size: .9rem;
            font-weight: 700;
            letter-spacing: .04em;
            line-height: 1.4;
        }

        .ej-footer-logo {
            margin-top: 12px;
            display: inline-flex;
            background: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            align-items: center;
            gap: 6px;
        }

        .ej-footer-logo-text {
            color: #1e3a8a;
            font-size: .85rem;
            font-weight: 800;
        }

        .ej-sparkle {
            position: absolute;
            right: -8px;
            bottom: -8px;
            color: #64748b;
            opacity: 0.2;
        }

        .ej-sparkle svg {
            width: 70px;
            height: 70px;
        }

        @media (max-width: 480px) {
            .ej-card img {
                height: 70px;
            }

            .ej-time {
                font-size: 0.75rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .tc-team-photo img,
            .tc-gallery-item img,
            .tc-empower-visual {
                transition: none;
            }

            .tc-empower-visual:hover {
                transform: none;
            }
        }

        /* ============================================================
           COLLABORATIONS & TIEUPS — dual marquee logo showcase
           ============================================================ */
        .tc-marquee {
            position: relative;
            overflow: hidden;
        }

        .tc-marquee::before,
        .tc-marquee::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 90px;
            z-index: 2;
            pointer-events: none;
        }

        .tc-marquee::before {
            left: 0;
            background: linear-gradient(90deg, #FDFBF7 0%, rgba(253, 251, 247, 0) 100%);
        }

        .tc-marquee::after {
            right: 0;
            background: linear-gradient(270deg, #FDFBF7 0%, rgba(253, 251, 247, 0) 100%);
        }

        .tc-marquee-track {
            display: flex;
            width: max-content;
            padding: 4px 0;
            animation: tc-marquee 46s linear infinite;
        }

        .tc-marquee-group {
            display: flex;
            gap: 16px;
            padding-right: 16px;
        }

        .tc-marquee-track.is-reverse {
            animation-direction: reverse;
            animation-duration: 56s;
        }

        .tc-marquee:hover .tc-marquee-track {
            animation-play-state: paused;
        }

        @keyframes tc-marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .tc-logo-card {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 22px;
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(5, 49, 63, 0.04);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .tc-logo-card:hover {
            transform: translateY(-4px);
            border-color: #FF6B00;
            box-shadow: 0 14px 28px rgba(255, 107, 0, 0.15);
        }

        .tc-logo-mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .tc-logo-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: #05313F;
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {

            .tc-marquee::before,
            .tc-marquee::after {
                width: 40px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .tc-marquee-track {
                animation: none;
            }

            .tc-logo-card {
                transition: none;
            }
        }

        /* ============================================================
           TECHNOLOGIES WE USE — marquee + hover-lift glowing badges
           ============================================================ */
        .tc-tech-marquee .tc-marquee-track {
            animation-duration: 32s;
        }

        .tc-tech-marquee .tc-marquee-group {
            gap: 20px;
            padding-right: 20px;
        }

        .tc-tech-badge {
            position: relative;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 26px 12px 12px;
            background: #ffffff;
            border: 1px solid #eef0f4;
            border-radius: 999px;
            box-shadow: 0 4px 14px rgba(5, 49, 63, 0.05);
            transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1),
                box-shadow 0.35s ease,
                border-color 0.35s ease;
        }

        .tc-tech-badge:hover {
            transform: translateY(-6px);
            border-color: transparent;
            box-shadow: 0 18px 34px rgba(5, 49, 63, 0.12),
                0 0 0 1px var(--tech-color),
                0 0 24px -4px var(--tech-color);
        }

        .tc-tech-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            color: #ffffff;
            background: var(--tech-color);
            box-shadow: 0 8px 18px -6px var(--tech-color);
            transition: transform 0.35s ease;
        }

        .tc-tech-badge:hover .tc-tech-icon {
            transform: scale(1.08) rotate(-6deg);
        }

        .tc-tech-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: #05313F;
            letter-spacing: 0.01em;
            white-space: nowrap;
        }

        @media (prefers-reduced-motion: reduce) {

            .tc-tech-badge,
            .tc-tech-icon {
                transition: none;
            }
        }

        /* ============================================================
           HERO VISUAL STACK — main photo frame + floating stat badges +
           overlapping mini card. Scoped classes only (index.php).
           ============================================================ */
        .hero-visual-stack {
            position: relative;
            width: 100%;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 40px;
        }

        .hero-main-photo {
            position: relative;
            z-index: 1;
            background: #ffffff;
            border: 11px solid #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px -20px rgba(15, 23, 42, .25);
            overflow: hidden;
        }

        .hero-main-photo img {
            display: block;
            width: 100%;
            height: 420px;
            object-fit: cover;
        }

        .hero-badge {
            position: absolute;
            z-index: 3;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px -20px rgba(15, 23, 42, .25);
        }

        .hero-badge-students {
            top: -20px;
            right: -20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
        }

        .hero-badge-students i {
            color: #FF6B00;
            font-size: 2rem;
            line-height: 1;
        }

        .hero-badge-students b {
            display: block;
            color: #0F172A;
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .hero-badge-students span {
            display: block;
            color: #64748B;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .hero-badge-years {
            bottom: 20%;
            right: -30px;
            background: #0F3E45;
            color: #ffffff;
            border-radius: 14px;
            padding: 14px 20px;
        }

        .hero-badge-years b {
            display: block;
            color: #ffffff;
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .hero-badge-years span {
            display: block;
            margin-top: 4px;
            color: #ffffff;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .hero-mini-card {
            position: absolute;
            z-index: 4;
            bottom: -30px;
            left: -30px;
            width: 200px;
            background: #ffffff;
            padding: 8px;
            border-radius: 16px;
            box-shadow: 0 20px 40px -20px rgba(15, 23, 42, .25);
        }

        .hero-mini-card img {
            display: block;
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 10px;
        }

        .hero-mini-caption {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            padding: 8px 10px;
            background: #0F3E45;
            color: #ffffff;
            border-radius: 8px;
        }

        .hero-mini-caption i {
            flex-shrink: 0;
            color: #FF6B00;
            font-size: 1.1rem;
        }

        .hero-mini-caption span {
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            line-height: 1.25;
        }

        @media (max-width: 991.98px) {
            .hero-badge {
                transform: scale(0.85);
            }

            .hero-badge-students {
                transform-origin: top right;
            }

            .hero-badge-years {
                transform-origin: bottom right;
            }

            .hero-mini-card {
                bottom: -20px;
                left: -20px;
            }
        }

        @media (max-width: 575.98px) {
            .hero-main-photo img {
                height: 320px;
            }

            .hero-badge {
                transform: scale(0.75);
            }

            .hero-badge-students {
                top: -14px;
                right: -12px;
                transform-origin: top right;
            }

            .hero-badge-years {
                right: -18px;
                transform-origin: bottom right;
            }

            .hero-mini-card {
                bottom: -16px;
                left: -12px;
                width: 140px;
            }

            .hero-mini-card img {
                height: 92px;
            }
        }

        .tc-hero-img {
            transition: transform .45s ease, box-shadow .45s ease;
        }

        .tc-hero-img:hover {
            transform: scale(1.05);
            box-shadow: 0 18px 40px rgba(5, 49, 63, 0.28);
        }
    </style>
</head>

<body class="antialiased">

    <!-- TOP UTILITY BAR -->
    <div class="bg-[#FF6B00] text-white text-xs py-2 px-4 md:px-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="flex items-center space-x-6">
                <a href="mailto:info@technocoderz.com" class="flex items-center space-x-2 hover:underline transition-colors">
                    <i class="fa-regular fa-envelope"></i>
                    <span>info@technocoderz.com</span>
                </a>
                <a href="tel:+919876543210" class="flex items-center space-x-2 hover:underline transition-colors">
                    <i class="fa-solid fa-phone"></i>
                    <span>+91 98765 43210</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://facebook.com/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 hover:text-[#05313F] hover:bg-white/20 hover:scale-110 active:scale-95"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://instagram.com/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 hover:text-[#05313F] hover:bg-white/20 hover:scale-110 active:scale-95"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://linkedin.com/company/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 hover:text-[#05313F] hover:bg-white/20 hover:scale-110 active:scale-95"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="https://youtube.com/@technocoderz" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 hover:text-[#05313F] hover:bg-white/20 hover:scale-110 active:scale-95"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://twitter.com/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 hover:text-[#05313F] hover:bg-white/20 hover:scale-110 active:scale-95"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-3.5 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="index.php" class="flex items-center space-x-3 group">
                <img src="assets/images/image.png" alt="Techno Coderz" class="h-10 w-auto">
            </a>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-8 font-semibold text-gray-700 text-sm">
                <a href="index.php" class="hover:text-[#084C61] transition-colors">Home</a>
                <a href="about.php" class="hover:text-[#084C61] transition-colors">About</a>
                <a href="courses.php" class="hover:text-[#084C61] transition-colors">Courses</a>
                <a href="blog.php" class="hover:text-[#084C61] transition-colors">Our Blogs</a>
                <a href="brochure.php" class="hover:text-[#084C61] transition-colors">Brochure</a>
                <a href="contact.php" class="hover:text-[#084C61] transition-colors">Contact Us</a>
            </nav>

            <!-- CTA Button -->
            <div class="flex items-center space-x-4">
                <button type="button" onclick="openEnquireModal()" class="bg-[#FF6B00] hover:bg-[#E55F00] text-white font-bold px-6 py-2.5 rounded-full text-sm shadow-md transition-all hover:shadow-lg transform active:scale-95">
                    Register Now
                </button>
                <button class="lg:hidden text-gray-700 text-xl focus:outline-none" id="mobile-menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-gray-200 px-6 py-4 space-y-3">
            <a href="index.php" class="block font-semibold text-gray-700">Home</a>
            <a href="about.php" class="block font-semibold text-gray-700">About</a>
            <a href="courses.php" class="block font-semibold text-gray-700">Courses</a>
            <a href="blog.php" class="block font-semibold text-gray-700">Our Blogs</a>
            <a href="brochure.php" class="block font-semibold text-gray-700">Brochure</a>
            <a href="contact.php" class="block font-semibold text-gray-700">Contact Us</a>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative pt-8 pb-16 md:pt-12 md:pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                <!-- LEFT COLUMN: Headline & Enquire Now CTA -->
                <div class="lg:col-span-6 space-y-6">

                    <!-- Heading Block -->
                    <div class="space-y-4">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#084C61] leading-[1.15] tracking-tight">
                            <span class="text-[#1B72E8]">Discover Your Path:</span><br>
                            Compare &amp; Connect to the Perfect College
                        </h1>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed max-w-xl">
                            Use our innovative, single-solution platform to search over 1000+ top universities. Access virtual tours, contact admissions, and make the right choice for your future.
                        </p>
                    </div>

                    <!-- ENQUIRE NOW - CTA card that opens the popup enquiry form -->
                    <div id="enquire-form" class="enquire-card-gradient text-white rounded-3xl shadow-2xl p-6 md:p-7 max-w-md w-full relative overflow-hidden">

                        <!-- Decorative blobs -->
                        <span class="pointer-events-none absolute -top-10 -right-10 w-36 h-36 rounded-full bg-white/10"></span>
                        <span class="pointer-events-none absolute -bottom-12 -left-8 w-32 h-32 rounded-full bg-white/10"></span>

                        <!-- Header Badge -->
                        <div class="relative mb-4">
                            <span class="inline-block h-1.5 w-12 rounded-full bg-white/80 mb-3"></span>
                            <h2 class="text-2xl font-extrabold tracking-tight">
                                Enquire Now !
                            </h2>
                            <p class="text-sm text-white/90 mt-2 leading-relaxed">
                                Fill a quick form and our team will call you back within 24 hours.
                            </p>
                        </div>

                        <!-- Open Popup Button -->
                        <button type="button" onclick="openEnquireModal()" class="relative w-full bg-white text-[#FF6B00] hover:bg-gray-100 font-extrabold px-6 py-3 rounded-full text-base shadow-lg transition-all flex items-center justify-center space-x-2 active:scale-[0.98]">
                            <span>Open Enquiry Form</span>
                            <i class="fa-solid fa-paper-plane text-sm"></i>
                        </button>

                        <div class="relative flex items-center justify-center gap-2 mt-4 text-xs font-semibold text-white/90">
                            <i class="fa-solid fa-phone"></i>
                            <span>+91 98765 43210</span>
                        </div>
                    </div>
                    <!-- Bottom Action Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="contact.php" class="bg-[#05313F] hover:bg-teal-950 text-white font-bold px-7 py-3 rounded-full text-sm shadow-md transition-all hover:shadow-xl">
                            Connect with Admissions
                        </a>
                        <a href="#testimonials" class="bg-transparent hover:bg-white text-[#05313F] font-bold px-7 py-3 rounded-full text-sm border-2 border-[#05313F] transition-all">
                            Explore Reviews
                        </a>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Hero illustration -->
                <div class="lg:col-span-6 hero-image">
                    <img src="assets/images/vector.png"
                         alt="College discovery illustration"
                         class="hero-vector">
                </div>

            </div> <!-- /grid -->
        </div> <!-- /max-w-7xl -->
    </section>

    <!-- SECTION 2: EMPOWER YOUR STUDENTS WITH TECHNOCODERZ -->
    <section id="about" class="py-16 md:py-24 bg-white border-t border-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                <!-- LEFT: Content -->
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#FF6B00] bg-orange-50 border border-orange-100 rounded-full px-4 py-1.5">
                        <i class="fa-solid fa-handshake-angle"></i> Join Us
                    </span>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-[#05313F] leading-tight">
                        Empower Your Students with <span class="text-[#1B72E8]">TechnoCoderz</span>
                    </h2>

                    <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                        Join us in preparing the next generation of tech leaders. Recommend TechnoCoderz to your students and open the door to industry-aligned programs, live projects, and dedicated placement support.
                    </p>
                    <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                        We bridge the gap between academic knowledge and industry requirements through hands-on learning, mentorship from working professionals, and real-world project experience.
                    </p>

                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <li class="tc-empower-item flex items-center gap-3 text-sm font-semibold text-[#05313F]">
                            <span class="tc-empower-check w-7 h-7 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center shrink-0"><i class="fa-solid fa-check text-xs"></i></span>
                            Industry-Aligned Curriculum
                        </li>
                        <li class="tc-empower-item flex items-center gap-3 text-sm font-semibold text-[#05313F]">
                            <span class="tc-empower-check w-7 h-7 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center shrink-0"><i class="fa-solid fa-check text-xs"></i></span>
                            Hands-On Live Projects
                        </li>
                        <li class="tc-empower-item flex items-center gap-3 text-sm font-semibold text-[#05313F]">
                            <span class="tc-empower-check w-7 h-7 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center shrink-0"><i class="fa-solid fa-check text-xs"></i></span>
                            Expert Mentorship
                        </li>
                        <li class="tc-empower-item flex items-center gap-3 text-sm font-semibold text-[#05313F]">
                            <span class="tc-empower-check w-7 h-7 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center shrink-0"><i class="fa-solid fa-check text-xs"></i></span>
                            Placement Support
                        </li>
                    </ul>

                    <!-- Contact info strip -->
                    <div class="flex flex-wrap items-center gap-4 bg-[#FDFBF7] border border-gray-100 rounded-2xl p-4 md:p-5 shadow-sm">
                        <span class="w-12 h-12 rounded-xl bg-[#05313F] text-white flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone-volume text-lg"></i>
                        </span>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">For More Information:</p>
                            <a href="tel:+919870443528" class="text-lg md:text-xl font-extrabold text-[#05313F] hover:text-[#FF6B00] transition-colors">+91 98704 43528</a>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Floating hero visual stack (main photo + stat badges + mini card) -->
                <div class="hero-visual-stack">
                    <!-- Main photo frame -->
                    <div class="hero-main-photo">
                        <img src="assets/images/institute/success-1.jpg" alt="Students learning at TechnoCoderz">
                    </div>

                    <!-- Top-right floating badge: students trained -->
                    <div class="hero-badge hero-badge-students">
                        <i class="bi bi-mortarboard-fill"></i>
                        <div>
                            <b>5000+</b>
                            <span>STUDENTS TRAINED</span>
                        </div>
                    </div>

                    <!-- Bottom-right floating badge: industry experience -->
                    <div class="hero-badge hero-badge-years">
                        <b>12+ Years</b>
                        <span>INDUSTRY EXPERTISE</span>
                    </div>

                    <!-- Bottom-left overlapping mini card -->
                    <div class="hero-mini-card">
                        <img src="assets/images/institute/success-6.jpeg" alt="TechnoCoderz training session">
                        <div class="hero-mini-caption">
                            <i class="bi bi-patch-check-fill"></i>
                            <span>CAREER<br>TRANSFORMATION</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION 3: FEATURED PROJECTS (database-driven, real project data) -->
    <section id="projects" class="py-16 md:py-24 bg-[#FDFBF7] border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#FF6B00] bg-orange-50 border border-orange-100 rounded-full px-4 py-1.5 mb-4">
                    <i class="fa-solid fa-briefcase"></i> Our Portfolio
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#05313F] mb-3">
                    Featured <span class="text-[#1B72E8]">Projects</span>
                </h2>
                <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                    Real applications designed and developed by the Techno Coderz team — proof that we don't just teach technology, we build with it.
                </p>
            </div>

            <?php if (!empty($featuredProjects)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-7">
                    <?php foreach ($featuredProjects as $proj):
                        $tags = array_values(array_filter(array_map('trim', explode(',', $proj['technology'] ?? ''))));
                        $category = $tags ? $tags[0] : 'Web Application';
                    ?>
                        <article class="tc-featured-card group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                            <div class="tc-featured-cover relative h-44 flex items-center justify-center overflow-hidden">
                                <?php if (!empty($proj['image']) && file_exists(UPLOAD_DIR . 'projects/' . $proj['image'])): ?>
                                    <img src="<?= UPLOAD_URL ?>projects/<?= e($proj['image']) ?>" alt="<?= e($proj['title']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="tc-featured-cover-icon"><i class="fa-solid fa-window-restore"></i></div>
                                    <span class="tc-featured-cover-code">&lt;/&gt;</span>
                                <?php endif; ?>
                                <span class="absolute top-3 left-3 text-[10px] font-extrabold uppercase tracking-wider text-white bg-black/35 backdrop-blur-sm rounded-full px-3 py-1"><?= e($category) ?></span>
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <h3 class="text-base font-extrabold text-[#05313F] mb-2"><?= e($proj['title']) ?></h3>
                                <p class="text-gray-500 text-xs leading-relaxed mb-4 flex-1"><?= e($proj['description']) ?></p>
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    <?php foreach (array_slice($tags, 0, 4) as $tag): ?>
                                        <span class="text-[10px] font-semibold text-[#084C61] bg-slate-100 rounded-md px-2 py-1"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (!empty($proj['project_url'])): ?>
                                    <a href="<?= e($proj['project_url']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#1B72E8] hover:text-[#0d5bc4]">
                                        <span>View Project</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="projects.php" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#1B72E8] hover:text-[#0d5bc4]">
                                        <span>View Project</span>
                                        <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-12">
                    <a href="projects.php" class="inline-flex items-center gap-2 bg-[#05313F] hover:bg-[#084C61] text-white font-bold px-7 py-3 rounded-full text-sm shadow-md transition-all hover:shadow-lg">
                        <i class="fa-solid fa-folder2-open"></i> See All Projects
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <p class="text-gray-500 text-sm">Projects portfolio coming soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- SECTION 4: TECHNOLOGIES WE USE -->
    <section class="py-14 md:py-16 bg-[#FDFBF7] border-t border-b border-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-8 text-center">
            <span class="inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#FF6B00] bg-orange-50 border border-orange-100 rounded-full px-4 py-1.5 mb-4">
                <i class="fa-solid fa-layer-group"></i> Our Tech Stack
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-[#05313F] mb-3">
                Technologies We Use
            </h2>
            <p class="text-gray-500 text-sm md:text-base leading-relaxed max-w-2xl mx-auto mb-10">
                We build with a modern, battle-tested stack that keeps products fast, scalable and future-ready.
            </p>
        </div>

        <?php
        $tcTechnologies = [
            ['name' => 'React',   'icon' => 'fa-brands fa-react',     'color' => '#61DAFB'],
            ['name' => 'Node.js', 'icon' => 'fa-brands fa-node-js',   'color' => '#539E43'],
            ['name' => 'Python',  'icon' => 'fa-brands fa-python',    'color' => '#3776AB'],
            ['name' => 'Flutter', 'icon' => 'fa-brands fa-flutter',   'color' => '#02569B'],
            ['name' => 'AWS',     'icon' => 'fa-brands fa-aws',       'color' => '#FF9900'],
            ['name' => 'Azure',   'icon' => 'fa-brands fa-microsoft', 'color' => '#0078D4'],
        ];
        ?>
        <div class="tc-marquee tc-tech-marquee" aria-label="Technologies we use">
            <div class="tc-marquee-track">
                <?php for ($rep = 0; $rep < 2; $rep++): ?>
                    <div class="tc-marquee-group">
                        <?php foreach ($tcTechnologies as $tech): ?>
                            <div class="tc-tech-badge" style="--tech-color: <?= $tech['color'] ?>;">
                                <span class="tc-tech-icon"><i class="<?= $tech['icon'] ?>"></i></span>
                                <span class="tc-tech-name"><?= e($tech['name']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 5: TESTIMONIALS -->
    <section id="testimonials" class="py-16 md:py-24 bg-[#FDFBF7]">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#FF6B00] bg-orange-50 border border-orange-100 rounded-full px-4 py-1.5 mb-4">
                    <i class="fa-solid fa-comment-dots"></i> Testimonials
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight leading-tight text-[#05313F] mb-3">
                    What Our Clients Say
                </h2>
                <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                    Hear from the institutions and teams who trust TechnoCoderz to deliver.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-7">
                <!-- Testimonial 1 -->
                <article class="tc-testi-card group bg-white p-7 rounded-3xl border border-gray-100 shadow-sm flex flex-col h-full">
                    <div class="flex items-center justify-between mb-5">
                        <span class="tc-testi-quote w-11 h-11 rounded-2xl bg-[#05313F] text-white flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-quote-left"></i>
                        </span>
                        <span class="flex gap-1 text-[#FFB800] text-xs">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">
                        "Technocoderz delivered our web platform on time with unbelievable precision. Their team ensured a seamless educational portal implementation."
                    </p>
                    <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Marnie Harne" class="tc-testi-avatar w-12 h-12 rounded-full object-cover ring-2 ring-orange-100">
                        <div>
                            <h4 class="text-sm font-bold text-[#05313F]">Marnie Harne</h4>
                            <p class="text-[11px] text-gray-500 font-medium">Exec. Director</p>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 2 -->
                <article class="tc-testi-card group bg-white p-7 rounded-3xl border border-gray-100 shadow-sm flex flex-col h-full">
                    <div class="flex items-center justify-between mb-5">
                        <span class="tc-testi-quote w-11 h-11 rounded-2xl bg-[#05313F] text-white flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-quote-left"></i>
                        </span>
                        <span class="flex gap-1 text-[#FFB800] text-xs">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">
                        "The admission search module transformed how students connect with our college programs. Highly recommended!"
                    </p>
                    <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Rawson Morsom" class="tc-testi-avatar w-12 h-12 rounded-full object-cover ring-2 ring-orange-100">
                        <div>
                            <h4 class="text-sm font-bold text-[#05313F]">Rawson Morsom</h4>
                            <p class="text-[11px] text-gray-500 font-medium">CTO, EdTech</p>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 3 -->
                <article class="tc-testi-card group bg-white p-7 rounded-3xl border border-gray-100 shadow-sm flex flex-col h-full">
                    <div class="flex items-center justify-between mb-5">
                        <span class="tc-testi-quote w-11 h-11 rounded-2xl bg-[#05313F] text-white flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-quote-left"></i>
                        </span>
                        <span class="flex gap-1 text-[#FFB800] text-xs">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">
                        "Great agility, clean code standards, and responsive design execution. Our conversion rates increased by 40%."
                    </p>
                    <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80" alt="Lucas Olson" class="tc-testi-avatar w-12 h-12 rounded-full object-cover ring-2 ring-orange-100">
                        <div>
                            <h4 class="text-sm font-bold text-[#05313F]">Lucas Olson</h4>
                            <p class="text-[11px] text-gray-500 font-medium">Developer Lead</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- SECTION 5B: LEADERSHIP TEAM -->
    <section id="leadership" class="py-16 md:py-24 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#FF6B00] bg-orange-50 border border-orange-100 rounded-full px-4 py-1.5 mb-4">
                    <i class="fa-solid fa-people-group"></i> Our Team
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#05313F] mb-3">
                    Meet Our <span class="text-[#1B72E8]">Leadership</span>
                </h2>
                <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                    Experienced mentors and industry practitioners guiding every learner towards a future-ready career.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Member 1 -->
                <article class="tc-team-card group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                    <div class="tc-team-photo">
                        <img src="assets/images/team/jagjit.jpg" alt="Dr. Jagjit Singh Bhamra" loading="lazy" class="w-full h-full object-cover">
                        <div class="tc-team-photo-overlay absolute inset-0 bg-gradient-to-t from-[#05313F]/70 via-[#05313F]/10 to-transparent"></div>
                    </div>
                    <div class="p-6 text-center flex flex-col flex-1">
                        <h3 class="text-sm font-extrabold uppercase tracking-wide text-[#05313F]">Dr. Jagjit Singh Bhamra</h3>
                        <span class="tc-team-role-badge inline-block self-center text-[10px] font-bold uppercase tracking-wide text-[#FF6B00] bg-orange-50 rounded-full px-3 py-1 mt-2 mb-3">Business Analyst</span>
                        <p class="text-xs text-gray-500 leading-relaxed flex-1">With over 18 years of proven experience in education, marketing and institutional development.</p>
                    </div>
                </article>

                <!-- Member 2 -->
                <article class="tc-team-card group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                    <div class="tc-team-photo">
                        <img src="assets/images/team/rakesh.jpg" alt="Rakesh Kumar Rai" loading="lazy" class="w-full h-full object-cover">
                        <div class="tc-team-photo-overlay absolute inset-0 bg-gradient-to-t from-[#05313F]/70 via-[#05313F]/10 to-transparent"></div>
                    </div>
                    <div class="p-6 text-center flex flex-col flex-1">
                        <h3 class="text-sm font-extrabold uppercase tracking-wide text-[#05313F]">Rakesh Kumar Rai</h3>
                        <span class="tc-team-role-badge inline-block self-center text-[10px] font-bold uppercase tracking-wide text-[#FF6B00] bg-orange-50 rounded-full px-3 py-1 mt-2 mb-3">Founder and CEO, Vibrantick</span>
                        <p class="text-xs text-gray-500 leading-relaxed flex-1">10 years of hands-on experience in Data Science, Cyber Security, and Full Stack Development.</p>
                    </div>
                </article>

                <!-- Member 3 -->
                <article class="tc-team-card group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                    <div class="tc-team-photo">
                        <img src="assets/images/team/geetanjali.jpg" alt="Geetanjali Badhan" loading="lazy" class="w-full h-full object-cover">
                        <div class="tc-team-photo-overlay absolute inset-0 bg-gradient-to-t from-[#05313F]/70 via-[#05313F]/10 to-transparent"></div>
                    </div>
                    <div class="p-6 text-center flex flex-col flex-1">
                        <h3 class="text-sm font-extrabold uppercase tracking-wide text-[#05313F]">Geetanjali Badhan</h3>
                        <span class="tc-team-role-badge inline-block self-center text-[10px] font-bold uppercase tracking-wide text-[#FF6B00] bg-orange-50 rounded-full px-3 py-1 mt-2 mb-3">Director Operations, Vibrantick</span>
                        <p class="text-xs text-gray-500 leading-relaxed flex-1">8 Years of experience in Frontend Development, Reactjs, UI/UX design, and Figma.</p>
                    </div>
                </article>

                <!-- Member 4 -->
                <article class="tc-team-card group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                    <div class="tc-team-photo">
                        <img src="assets/images/team/aakanksha.jpg" alt="Aakanksha" loading="lazy" class="w-full h-full object-cover">
                        <div class="tc-team-photo-overlay absolute inset-0 bg-gradient-to-t from-[#05313F]/70 via-[#05313F]/10 to-transparent"></div>
                    </div>
                    <div class="p-6 text-center flex flex-col flex-1">
                        <h3 class="text-sm font-extrabold uppercase tracking-wide text-[#05313F]">Aakanksha</h3>
                        <span class="tc-team-role-badge inline-block self-center text-[10px] font-bold uppercase tracking-wide text-[#FF6B00] bg-orange-50 rounded-full px-3 py-1 mt-2 mb-3">Ex-professor, HR &amp; Business Analyst, Vibrantick</span>
                        <p class="text-xs text-gray-500 leading-relaxed flex-1">8+ years of experience in Data Structures, C/C++, combined with expertise in HR Consulting.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>



    <!-- SECTION 7: COLLABORATIONS & TIEUPS -->
    <section id="collaborations" class="py-16 md:py-24 bg-[#FDFBF7] border-t border-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#FF6B00] bg-orange-50 border border-orange-100 rounded-full px-4 py-1.5 mb-4">
                    <i class="fa-solid fa-handshake"></i> Our Network
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#05313F] mb-3">
                    Collaborations &amp; Tieups
                </h2>
                <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                    Proudly partnered with leading organisations, startups and institutions to create real opportunities for our learners.
                </p>
            </div>
        </div>

        <?php
        $tcPartners = [
            'GrowU',
            'Vibrantick',
            'Anix Systems',
            'Padhai Plus',
            'Franciscan',
            '13 Silver Taxi',
            'Google for Startups',
            'Google Partner',
            'Zoho Partners',
            'Google Workspace Partner',
            'Spice Market',
            'Neural Info Solutions',
            'Flora Cafe',
            'Anix SkillUp',
            'Aqua Prime',
            'Amazon Ads',
            'Meta',
            'Shopify Partners',
            'WordPress',
            'CT Group',
            'Indus International University',
            'Wynk Jobs',
            'NRICare',
            'Sanjay Rungta Group',
            'Arborguard',
            'Flightshub',
        ];
        $tcPartnerPalette = ['#0EA5E9', '#8B5CF6', '#F59E0B', '#10B981', '#EF4444', '#EC4899', '#6366F1', '#14B8A6', '#F97316', '#3B82F6'];
        $tcSplit = (int) ceil(count($tcPartners) / 2);
        $tcRows  = [array_slice($tcPartners, 0, $tcSplit), array_slice($tcPartners, $tcSplit)];
        ?>
        <div class="space-y-5">
            <?php foreach ($tcRows as $rowIndex => $rowPartners): ?>
                <div class="tc-marquee" aria-label="Collaborations and tieups partners">
                    <div class="tc-marquee-track<?= $rowIndex === 1 ? ' is-reverse' : '' ?>">
                        <?php for ($rep = 0; $rep < 2; $rep++): ?>
                            <div class="tc-marquee-group">
                                <?php foreach ($rowPartners as $pi => $partner):
                                    $tcWords = preg_split('/\s+/', $partner);
                                    $tcInitials = '';
                                    foreach (array_slice($tcWords, 0, 2) as $w) {
                                        $tcInitials .= strtoupper(substr($w, 0, 1));
                                    }
                                    $tcColor = $tcPartnerPalette[($rowIndex * 5 + $pi) % count($tcPartnerPalette)];
                                ?>
                                    <div class="tc-logo-card">
                                        <span class="tc-logo-mark" style="background: <?= $tcColor ?>;"><?= e($tcInitials) ?></span>
                                        <span class="tc-logo-name"><?= e($partner) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- FOOTER — synced with includes/footer.php (same design as about.php) -->
    <footer class="tc-footer">
        <div class="tc-footer-container">
            <div class="tc-footer-grid">
                

                <!-- Col 1: Brand Info -->
                <div class="tc-footer-col tc-footer-col-brand">
                    <a href="index.php" class="tc-footer-logo">
                        <img src="assets/images/image.png" alt="Techno Coderz Logo">
                    </a>
                    <p class="tc-footer-desc">
                        Techno Coderz is a premier IT training and software development institute helping learners build industry-ready skills through practical, project-based education.
                    </p>
                    <div class="tc-social-links">
                        <a href="https://facebook.com/technocoderz" class="tc-social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/technocoderz" class="tc-social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://linkedin.com/company/technocoderz" class="tc-social-link" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="https://youtube.com/@technocoderz" class="tc-social-link" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="https://twitter.com/technocoderz" class="tc-social-link" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="tc-footer-col tc-footer-col-quick">
                    <h6 class="tc-footer-heading">Quick Links</h6>
                    <ul class="tc-footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="courses.php">Courses</a></li>
                        <li><a href="brochure.php">Brochure</a></li>
                        <li><a href="blog.php">Our Blogs</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Col 3: Top Courses -->
                <div class="tc-footer-col tc-footer-col-courses">
                    <h6 class="tc-footer-heading">Top Courses</h6>
                    <ul class="tc-footer-links">
                        <li><a href="course-details.php?slug=artificial-intelligence-machine-learning-data-science">Artificial Intelligence, Machine Learning &amp; Data Science</a></li>
                        <li><a href="course-details.php?slug=full-stack-development-mern-mean-stack">Full Stack Development (MERN &amp; MEAN Stack)</a></li>
                        <li><a href="course-details.php?slug=devsecops-cyber-security">DevSecOps / Cyber Security</a></li>
                        <li><a href="course-details.php?slug=devops-ci-cd">DevOps | CI/CD</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact Us -->
                <div class="tc-footer-col tc-footer-col-contact">
                    <h6 class="tc-footer-heading">Contact Us</h6>
                    <div class="tc-footer-contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Office No. 36, Second Floor, D-185, Phase 8B, Sector 74, Sahibzada Ajit Singh Nagar, Mohali, Punjab 160055</span>
                    </div>
                    <div class="tc-footer-contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        <a href="tel:+919876543210">+91 98765 43210</a>
                    </div>
                    <div class="tc-footer-contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:info@technocoderz.com">info@technocoderz.com</a>
                    </div>
                    <div class="tc-footer-cta">
                        <a href="contact.php" class="tc-btn tc-btn-primary tc-btn-sm">
                            <i class="bi bi-chat-dots-fill"></i> Get In Touch
                        </a>
                    </div>
                </div>

            </div><!-- /tc-footer-grid -->

            <!-- Footer Bottom -->
            <div class="tc-footer-bottom">
                <p>&copy; <?= date('Y') ?> <strong style="color:#fff">Techno Coderz</strong>. All rights reserved.</p>
                <p class="tc-footer-bottom-links">
                    <a href="courses.php">Courses</a>
                    <a href="brochure.php">Brochure</a>
                    <a href="blog.php">Blog</a>
                    <a href="faq.php">FAQ</a>
                    <a href="contact.php">Contact</a>
                </p>
            </div>

        </div><!-- /tc-footer-container -->
    </footer>

    <!-- ===================== SCROLL TO TOP ===================== -->
    <button type="button" id="scrollTopBtn" onclick="scrollToTop()" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-[90] w-12 h-12 rounded-full bg-[#FF6B00] text-white shadow-lg shadow-orange-300/50 flex items-center justify-center text-lg opacity-0 invisible translate-y-3 transition-all duration-300 hover:bg-[#E55F00] hover:-translate-y-1 active:scale-95">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- ===================== ENQUIRY POPUP MODAL ===================== -->
    <div id="enquireModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="enquireModalTitle">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEnquireModal()"></div>

        <!-- Modal Card -->
        <div class="enquire-modal-card relative w-full max-w-md max-h-[92vh] overflow-y-auto p-5 md:p-7">
            <!-- Close Button -->
            <button type="button" onclick="closeEnquireModal()" class="enquire-modal-close" aria-label="Close enquiry form">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Header Badge -->
            <div class="text-center mb-5 pr-8">
                <span class="inline-block h-1.5 w-12 rounded-full bg-[#FF6B00] mb-3"></span>
                <h2 id="enquireModalTitle" class="text-2xl font-extrabold text-[#1E293B] tracking-tight">
                    Enquire Now !
                </h2>
                <p class="text-xs font-semibold text-gray-500 mt-1.5">We'll get back to you within 24 hours.</p>
            </div>

            <!-- Form -->
            <form id="hero-enquire-form" onsubmit="event.preventDefault(); handleFormSubmit();" class="space-y-4">
                <input type="hidden" name="csrf_token" id="enquireCsrf" value="<?= e($csrf) ?>">

                <!-- Full Name Input -->
                <div>
                    <label for="enqFullName" class="block text-xs font-bold text-[#1E293B] mb-1.5">Full Name <span class="text-[#FF6B00]">*</span></label>
                    <input id="enqFullName" name="name" type="text" required placeholder="e.g. Rahul Sharma" class="w-full px-4 py-3 text-sm font-medium text-gray-800 placeholder-gray-400 rounded-xl focus:outline-none transition">
                </div>

                <!-- Email Input -->
                <div>
                    <label for="enqEmailHero" class="block text-xs font-bold text-[#1E293B] mb-1.5">Email <span class="text-[#FF6B00]">*</span></label>
                    <input id="enqEmailHero" name="email" type="email" required placeholder="you@example.com" class="w-full px-4 py-3 text-sm font-medium text-gray-800 placeholder-gray-400 rounded-xl focus:outline-none transition">
                </div>

                <!-- Mobile Input -->
                <div>
                    <label for="enqPhoneHero" class="block text-xs font-bold text-[#1E293B] mb-1.5">Mobile Number</label>
                    <input id="enqPhoneHero" name="phone" type="tel" placeholder="+91 98765 43210" class="w-full px-4 py-3 text-sm font-medium text-gray-800 placeholder-gray-400 rounded-xl focus:outline-none transition">
                </div>

                <!-- Course Select -->
                <div>
                    <label for="enqCourseHero" class="block text-xs font-bold text-[#1E293B] mb-1.5">Select Course <span class="text-[#FF6B00]">*</span></label>
                    <select id="enqCourseHero" name="course" required class="w-full px-4 py-3 text-sm font-medium text-gray-800 rounded-xl cursor-pointer focus:outline-none transition">
                        <option value="" disabled selected>Select Course</option>
                        <option value="Artificial Intelligence, Machine Learning &amp; Data Science">Artificial Intelligence, ML &amp; Data Science</option>
                        <option value="Full Stack Development (MERN & MEAN Stack)">Full Stack Development (MERN & MEAN)</option>
                        <option value="DevSecOps / Cyber Security">DevSecOps / Cyber Security</option>
                        <option value="DevOps | CI/CD">DevOps | CI/CD</option>
                        <option value="Other / Not Sure">Other / Not Sure</option>
                    </select>
                </div>

                <!-- Message -->
                <div>
                    <label for="enqMsgHero" class="block text-xs font-bold text-[#1E293B] mb-1.5">Message</label>
                    <textarea id="enqMsgHero" name="message" rows="3" placeholder="Tell us what you want to learn..." class="w-full px-4 py-3 text-sm font-medium text-gray-800 placeholder-gray-400 rounded-xl resize-none focus:outline-none transition"></textarea>
                </div>

                <!-- Radio Group: Online / Offline -->
                <div class="pt-1">
                    <div class="flex items-center gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="mode" value="online" checked class="peer sr-only">
                            <span class="block text-center text-sm font-bold py-2.5 rounded-full border border-gray-200 text-gray-600 bg-white transition peer-checked:bg-[#FF6B00] peer-checked:text-white peer-checked:border-[#FF6B00] peer-checked:shadow-md peer-checked:shadow-orange-200"><i class="fa-solid fa-wifi mr-1.5"></i>Online</span>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="mode" value="offline" class="peer sr-only">
                            <span class="block text-center text-sm font-bold py-2.5 rounded-full border border-gray-200 text-gray-600 bg-white transition peer-checked:bg-[#FF6B00] peer-checked:text-white peer-checked:border-[#FF6B00] peer-checked:shadow-md peer-checked:shadow-orange-200"><i class="fa-solid fa-building mr-1.5"></i>Offline</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-1">
                    <button type="submit" class="w-full bg-[#FF6B00] hover:bg-[#E55F00] text-white font-extrabold px-6 py-3 rounded-full text-base shadow-lg shadow-orange-200 transition-all flex items-center justify-center space-x-2 active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed">
                        <span>Submit</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>
                    </button>
                </div>
            </form>

            <!-- Notification Toast inside form -->
            <div id="form-toast" class="hidden mt-3 p-3 rounded-xl text-xs font-bold text-center shadow">
                Enquiry Submitted Successfully!
            </div>
        </div>
    </div>

    <script>
        // ---------- Enquiry Popup ----------
        function openEnquireModal() {
            const modal = document.getElementById('enquireModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            const first = document.getElementById('enqFullName');
            if (first) setTimeout(() => first.focus(), 250);
        }

        function closeEnquireModal() {
            document.getElementById('enquireModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // ESC closes the popup
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeEnquireModal();
        });

        // Navbar "Register Now" -> index.php#enquire-form opens the popup
        window.addEventListener('load', function () {
            if (location.hash === '#enquire-form') openEnquireModal();
        });

        // ---------- Form submission (AJAX -> ajax/enquiry.php) ----------
        function showToast(success, message) {
            const toast = document.getElementById('form-toast');
            toast.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-100', 'bg-red-50', 'text-red-800', 'border-red-100');
            toast.classList.add(
                success ? 'bg-emerald-50' : 'bg-red-50',
                success ? 'text-emerald-800' : 'text-red-800',
                success ? 'border-emerald-100' : 'border-red-100',
                'border'
            );
            toast.innerHTML = success
                ? '<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> ' + message
                : '<i class="fa-solid fa-circle-exclamation text-red-500 mr-1"></i> ' + message;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3500);
        }

        async function handleFormSubmit() {
            const form = document.getElementById('hero-enquire-form');
            const btn  = form.querySelector('button[type="submit"]');
            const original = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Sending...</span>';

            try {
                const res  = await fetch('ajax/enquiry.php', { method: 'POST', body: new FormData(form) });
                const data = await res.json();

                if (data.success) {
                    form.reset();
                    showToast(true, data.message);
                    setTimeout(closeEnquireModal, 2200);
                } else {
                    showToast(false, data.message || 'Something went wrong. Please try again.');
                }
            } catch (err) {
                showToast(false, 'Network error. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = original;
            }
        }

        // Mobile Menu Toggle logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // ---------- Scroll to top ----------
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        const scrollTopBtn = document.getElementById('scrollTopBtn');
        if (scrollTopBtn) {
            const toggleScrollTop = () => {
                if (window.scrollY > 300) {
                    scrollTopBtn.classList.remove('opacity-0', 'invisible', 'translate-y-3');
                } else {
                    scrollTopBtn.classList.add('opacity-0', 'invisible', 'translate-y-3');
                }
            };
            window.addEventListener('scroll', toggleScrollTop);
            toggleScrollTop();
        }
    </script>
</body>

</html>