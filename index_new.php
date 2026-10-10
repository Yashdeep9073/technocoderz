<?php
/** Techno Coderz homepage. Shared HTML shell is owned by includes/header.php and footer.php. */
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Techno Coderz | Learn, Build & Grow';
$featuredProjects = [];
try {
    $featuredProjects = getDB()->query(
        'SELECT * FROM projects WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 6'
    )->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $exception) {
    error_log('Homepage projects: ' . $exception->getMessage());
}
function homeEscape($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
/* The shared header is assumed to render the opening HTML, head, body, and navigation,
   just as it does on about.php. Load the homepage stylesheet after it to avoid editing shared files. */
require __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="assets/css/home.css?v=1">
<main id="main-content" class="tc-home">
    <section class="home-hero" aria-labelledby="home-hero-heading">
        <div class="container home-hero__grid">
            <div class="home-hero__content">
                <div class="home-eyebrow"><span class="home-eyebrow__dot"></span> Practical learning. Real-world skills.</div>
                <h1 id="home-hero-heading">Build your future with <span>skills that matter.</span></h1>
                <p class="home-hero__intro">Explore career-focused technology training, learn from real projects, and take your next step with confidence at Techno Coderz.</p>
                <div class="home-hero__actions">
                    <a href="courses.php" class="home-btn home-btn--primary">Explore Courses <span aria-hidden="true">↗</span></a>
                    <a href="about.php" class="home-btn home-btn--outline">Get to Know Us <span aria-hidden="true">→</span></a>
                </div>
                <div class="home-hero__trust" aria-label="Learning benefits">
                    <span><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Project-based learning</span>
                    <span><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Practical mentorship</span>
                    <span><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Flexible learning</span>
                </div>
            </div>
            <div class="home-hero__visual">
                <div class="home-hero__halo" aria-hidden="true"></div>
                <div class="home-photo home-photo--main">
                    <img src="assets/images/institute/success-1.jpg" alt="Techno Coderz learners collaborating in a training session" fetchpriority="high" decoding="async">
                </div>
                <div class="home-photo home-photo--secondary">
                    <img src="assets/images/institute/success-2.jpg" alt="Students taking part in hands-on learning" decoding="async">
                </div>
                <div class="home-hero__floating home-hero__floating--top"><span class="home-floating-icon"><i class="bi bi-code-slash" aria-hidden="true"></i></span><span><strong>Learn by doing</strong><small>Practical projects</small></span></div>
                <div class="home-hero__floating home-hero__floating--bottom"><i class="bi bi-stars" aria-hidden="true"></i><span>Build real-world confidence</span></div>
            </div>
        </div>
    </section>

    <section class="home-section home-section--white" aria-labelledby="why-heading">
        <div class="container">
            <div class="home-section__heading"><span class="home-kicker">WHY TECHNO CODERZ</span><h2 id="why-heading">Learn with purpose. Grow with confidence.</h2><p>More than lessons: we focus on the skills, practice, and guidance that help students move forward.</p></div>
            <div class="home-feature-grid">
                <article class="home-feature"><span class="home-feature__icon"><i class="bi bi-laptop" aria-hidden="true"></i></span><h3>Hands-on projects</h3><p>Apply concepts by building, testing, and refining your own work.</p></article>
                <article class="home-feature"><span class="home-feature__icon"><i class="bi bi-people" aria-hidden="true"></i></span><h3>Guided learning</h3><p>Learn with clear direction and practical feedback along the way.</p></article>
                <article class="home-feature"><span class="home-feature__icon"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i></span><h3>Career-ready skills</h3><p>Explore modern technology and strengthen your problem-solving abilities.</p></article>
            </div>
        </div>
    </section>

    <section class="home-section home-section--soft" id="courses" aria-labelledby="courses-heading">
        <div class="container">
            <div class="home-section__heading"><span class="home-kicker">EXPLORE YOUR INTERESTS</span><h2 id="courses-heading">Choose a path you’re excited about</h2><p>Start with a topic that inspires you, then turn your curiosity into practical experience.</p></div>
            <div class="home-course-grid">
                <article class="home-course"><div class="home-course__icon home-course__icon--orange"><i class="bi bi-cpu" aria-hidden="true"></i></div><h3>AI &amp; Data Science</h3><p>Explore intelligent systems, data analysis, and machine learning.</p><a href="courses.php">View courses <span aria-hidden="true">→</span></a></article>
                <article class="home-course"><div class="home-course__icon home-course__icon--blue"><i class="bi bi-window-stack" aria-hidden="true"></i></div><h3>Full Stack Development</h3><p>Understand how modern web applications are built end to end.</p><a href="courses.php">View courses <span aria-hidden="true">→</span></a></article>
                <article class="home-course"><div class="home-course__icon home-course__icon--teal"><i class="bi bi-shield-check" aria-hidden="true"></i></div><h3>Cybersecurity &amp; DevOps</h3><p>Discover secure systems, deployment workflows, and automation.</p><a href="courses.php">View courses <span aria-hidden="true">→</span></a></article>
            </div>
        </div>
    </section>

    <section class="home-section home-section--white" id="projects" aria-labelledby="projects-heading">
        <div class="container">
            <div class="home-section__heading"><span class="home-kicker">WHAT WE BUILD</span><h2 id="projects-heading">Featured projects</h2><p>A look at work featured by the Techno Coderz team.</p></div>
            <?php if ($featuredProjects): ?>
                <div class="home-project-grid">
                    <?php foreach ($featuredProjects as $project):
                        $title = $project['title'] ?? $project['name'] ?? 'Featured project';
                        $description = $project['short_description'] ?? $project['description'] ?? '';
                    ?>
                    <article class="home-project">
                        <div class="home-project__cover"><i class="bi bi-code-square" aria-hidden="true"></i><span>PROJECT SHOWCASE</span></div>
                        <div class="home-project__body"><h3><?= homeEscape($title) ?></h3><?php if ($description !== ''): ?><p><?= homeEscape(mb_strimwidth(strip_tags((string)$description), 0, 145, '…')) ?></p><?php endif; ?></div>
                    </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="home-empty"><i class="bi bi-folder2-open" aria-hidden="true"></i><p>New projects are being added. Explore our courses in the meantime.</p><a href="courses.php" class="home-btn home-btn--primary">Browse Courses <span aria-hidden="true">→</span></a></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="home-section home-story" aria-labelledby="story-heading">
        <div class="container home-story__grid">
            <div class="home-story__image"><img src="assets/images/institute/success-3.jpg" alt="A Techno Coderz workshop session" loading="lazy" decoding="async"></div>
            <div><span class="home-kicker">OUR APPROACH</span><h2 id="story-heading">The best way to learn is to build.</h2><p>Our approach connects learning to hands-on practice. Whether you're exploring your first technology course or developing a new skill, we want every step to feel meaningful.</p><a href="about.php" class="home-btn home-btn--primary">More About Us <span aria-hidden="true">→</span></a></div>
        </div>
    </section>

    <section class="home-section home-contact" id="enquire-form" aria-labelledby="enquire-heading">
        <div class="container home-contact__grid">
            <div class="home-contact__copy"><span class="home-kicker">START YOUR JOURNEY</span><h2 id="enquire-heading">Not sure where to begin?</h2><p>Tell us what you want to learn. Our team can help you find a suitable next step.</p><div class="home-contact__line"><i class="bi bi-chat-dots" aria-hidden="true"></i> Ask about courses and learning options.</div></div>
            <div class="home-enquiry">
                <h3>Enquire Now</h3><p>Send us your details to get started.</p>
                <!-- Submit goes to the existing contact page until the project's real enquiry endpoint is provided. -->
                <form id="hero-enquire-form" action="contact.php" method="post">
                    <div class="home-form-row"><label for="enqFullName">Full name</label><input id="enqFullName" name="name" type="text" autocomplete="name" maxlength="120" required placeholder="Your full name"></div>
                    <div class="home-form-row"><label for="enqEmailHero">Email address</label><input id="enqEmailHero" name="email" type="email" autocomplete="email" maxlength="254" required placeholder="you@example.com"></div>
                    <div class="home-form-row"><label for="enqPhoneHero">Phone number</label><input id="enqPhoneHero" name="phone" type="tel" autocomplete="tel" maxlength="20" required placeholder="Your contact number"></div>
                    <div class="home-form-row"><label for="enqCourseHero">Course interest</label><select id="enqCourseHero" name="course" required><option value="" disabled selected>Choose a course</option><option value="AI and Data Science">AI &amp; Data Science</option><option value="Full Stack Development">Full Stack Development</option><option value="Cybersecurity and DevOps">Cybersecurity &amp; DevOps</option><option value="Other">Other / Not Sure</option></select></div>
                    <fieldset class="home-mode"><legend>Preferred mode</legend><label><input type="radio" name="mode" value="online" checked> Online</label><label><input type="radio" name="mode" value="offline"> Offline</label></fieldset>
                    <button class="home-btn home-btn--primary home-btn--full" type="submit">Continue to Contact <span aria-hidden="true">↗</span></button>
                    <small class="home-enquiry__note">This requires integration with the existing contact.php POST handler before going live.</small>
                </form>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
