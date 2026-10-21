<?php
// ============================================================
// Techno Coderz — Homepage
// Layout & visual structure replicated section-by-section from
// the techcaddmohali.com homepage (all 14 sections, same design
// system), re-themed to the Techno Coderz orange palette and
// filled only with content already present in this project / DB.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Techno Coderz | IT Training & Software Development Institute, Mohali';
$pageDescription = 'Techno Coderz is Mohali\'s technology partner for AI, software and career-ready skills — live projects, expert mentors and placement support. Build real systems and get hired.';
$currentPage     = 'home';
$csrf            = generateCsrfToken();

$pdo = getDB();

$courses = $testimonials = $settings = [];
try {
    $courses      = $pdo->query("SELECT * FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
    $testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 1 ORDER BY id ASC LIMIT 8")->fetchAll();
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Throwable $e) {
    error_log('Homepage data: ' . $e->getMessage());
}

$siteName = $settings['site_name'] ?? 'Techno Coderz';
$phone    = $settings['phone'] ?? '+91 98765 43210';
$phoneRaw = preg_replace('/\D+/', '', $phone);
$email    = $settings['email'] ?? 'info@technocoderz.com';
$addr     = $settings['address'] ?? 'Mohali, Punjab 160055';
$loc      = $settings['location'] ?? 'Mohali, Punjab';

// ---- Group courses by category (data-driven) ----
$byCat = [];
foreach ($courses as $c) {
    $cat = trim($c['category'] ?? '');
    if ($cat === '') continue;
    $byCat[$cat][] = $c;
}

// ---- Six fields / tracks ----
$fieldDefs = [
    [
        'cat' => 'Programming', 'name' => 'Core Programming', 'tag' => 'Programming',
        'desc' => 'C, C++, Java, Python and DSA — the fundamentals every interview is built on.',
        'short' => 'CODE', 'badge' => ['New', 'bg-brand-100 text-up-accent'],
        'grad' => 'from-hero-glow to-brand-700',
        'icon' => '<path d="m4 7 5 5-5 5M12 17h8"/>',
    ],
    [
        'cat' => 'AI Courses', 'name' => 'Artificial Intelligence & Data', 'tag' => 'AI & Data',
        'desc' => 'Generative AI, machine learning, analytics and the tooling that ships models to production.',
        'short' => 'AI', 'badge' => ['Hot', 'bg-accent-yellow text-hero-950'],
        'grad' => 'from-accent-glow to-hero-glow',
        'icon' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4"/><path d="M12 7.5 13.6 11l3.4 1-3.4 1-1.6 3.5L10.4 13 7 12l3.4-1L12 7.5Z"/>',
    ],
    [
        'cat' => 'Digital Marketing', 'name' => 'Digital Marketing', 'tag' => 'Digital Marketing',
        'desc' => 'SEO, paid ads, social, analytics and AI-assisted campaigns that actually convert.',
        'short' => 'GROWTH', 'badge' => ['Hot', 'bg-accent-yellow text-hero-950'],
        'grad' => 'from-accent-yellow to-hero-glow',
        'icon' => '<path d="M3 11v2a1 1 0 0 0 1 1h3l6 4V6L7 10H4a1 1 0 0 0-1 1Z"/><path d="M17 9a4 4 0 0 1 0 6M20 6a8 8 0 0 1 0 12"/>',
    ],
    [
        'cat' => 'Cyber Courses', 'name' => 'Cyber Security & Cloud', 'tag' => 'Cyber & Cloud',
        'desc' => 'Ethical hacking, network defence, Linux and cloud infrastructure on AWS and Azure.',
        'short' => 'CYBER', 'badge' => ['Hot', 'bg-accent-yellow text-hero-950'],
        'grad' => 'from-up-soft to-hero-600',
        'icon' => '<path d="M12 3 4 6v6c0 5 3.4 8.4 8 9.5 4.6-1.1 8-4.5 8-9.5V6l-8-3Z"/>',
    ],
    [
        'cat' => 'Software Development', 'name' => 'Full-Stack Development', 'tag' => 'Development',
        'desc' => 'MERN, MEAN and PHP stacks — build, test and deploy real applications end to end.',
        'short' => 'DEV', 'badge' => ['Hot', 'bg-accent-yellow text-hero-950'],
        'grad' => 'from-brand-400 to-hero-900',
        'icon' => '<path d="m8 6-6 6 6 6M16 6l6 6-6 6M14 4l-4 16"/>',
    ],
    [
        'cat' => 'Data Science', 'name' => 'Data Science & Analytics', 'tag' => 'Data',
        'desc' => 'Python, statistics, dashboards and machine learning for data-driven roles.',
        'short' => 'DATA', 'badge' => ['New', 'bg-brand-100 text-up-accent'],
        'grad' => 'from-accent-400 to-hero-800',
        'icon' => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
    ],
];

$fields = [];
foreach ($fieldDefs as $f) {
    $list = $byCat[$f['cat']] ?? [];
    $f['count']   = count($list);
    $f['bullets'] = array_slice(array_column($list, 'title'), 0, 3);
    $f['href']    = 'courses.php?cat=' . rawurlencode($f['cat']);
    $fields[] = $f;
}
$totalCourses = count($courses);

// ---- Average rating ----
$avgRating = 4.8;
$ratings = array_filter(array_map(fn($t) => (float) ($t['rating'] ?? 0), $testimonials));
if ($ratings) $avgRating = round(array_sum($ratings) / count($ratings), 1);

// ---- Stats ----
$stats = [
    ['count' => 15000, 'suffix' => '+', 'label' => 'Students trained',   'icon' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/>'],
    ['count' => 450,   'suffix' => '+', 'label' => 'Hiring partners',   'icon' => '<rect x="3" y="7.5" width="18" height="12" rx="2"/><path d="M9 7.5V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1.5M3 12.5h18"/>'],
    ['count' => 98,    'suffix' => '%', 'label' => 'Placement success','icon' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.6"/>'],
    ['count' => 15,    'suffix' => '+', 'label' => 'Years of excellence','icon' => '<circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1 7 4.5-2.5 4.5 2.5-1-7"/>'],
];

// ---- Durations / programmes ----
$durations = [
    ['dur' => '45 Days', 'title' => 'Summer & Winter Industrial Training', 'desc' => 'A fast, focused sprint on one technology with a working project and a certificate.', 'features' => ['One core technology', 'Guided mini project', 'Training certificate', 'Weekday or weekend sessions'], 'featured' => false, 'link' => 'industrial-training-45-days.php'],
    ['dur' => '6 Weeks', 'title' => 'University-Mandated Training', 'desc' => 'Meets AICTE / university requirements with documentation your college accepts.', 'features' => ['Syllabus-aligned modules', 'Project report & viva prep', 'Attendance records', 'Verified certificate'], 'featured' => false, 'link' => 'industrial-training-6-weeks.php'],
    ['dur' => '6 Months', 'title' => 'Industrial Training with Internship', 'desc' => 'Full technology stack plus a live client-style project and placement drives.', 'features' => ['Complete stack coverage', 'Live project experience', 'Internship letter', 'Placement assistance'], 'featured' => true, 'link' => 'industrial-training-6-months.php'],
    ['dur' => '9 Months', 'title' => 'Expert Track', 'desc' => 'Our deepest programme — client-level projects, advanced modules and dedicated mentoring.', 'features' => ['Two specialisations', 'Client-level projects', 'Dedicated mentor', 'Priority placement support'], 'featured' => false, 'link' => 'industrial-training.php'],
];

// ---- AI band cards ----
$aiCards = [
    ['label' => 'For beginners', 'title' => 'AI Fundamentals', 'desc' => 'Python, mathematics, machine learning and the vocabulary you need before anything else makes sense.'],
    ['label' => 'For developers', 'title' => 'AI Development', 'desc' => 'Deep learning, LLM applications, RAG pipelines and agents — built, evaluated and deployed.'],
    ['label' => 'For professionals', 'title' => 'AI for Business', 'desc' => 'Prompt engineering, AI-assisted marketing and analytics workflows that save teams real hours.'],
];

// ---- Why / outcome cards ----
$whyCards = [
    ['stat' => '15+ yrs', 'sub' => 'average centre experience', 'title' => 'Trainers who still build', 'desc' => 'Every instructor is a practising engineer or marketer. You learn current tooling and the judgement calls that come with it — not a syllabus written five years ago.'],
    ['stat' => '4+', 'sub' => 'portfolio projects per track', 'title' => 'Live projects, not exercises', 'desc' => 'From week three you work on project code with requirements, reviews and deadlines. That is what fills a portfolio and what interviewers ask about.'],
    ['stat' => '450+', 'sub' => 'hiring partners', 'title' => 'Placement machinery that runs', 'desc' => 'A dedicated cell handles resumes, mock interviews and a hiring-partner network across Mohali, Chandigarh and beyond. Support continues until you are placed.'],
    ['stat' => '98%', 'sub' => 'course completion rate', 'title' => 'Sessions built around your life', 'desc' => 'Morning, evening, weekend and online sessions, all recorded. Students, working professionals and career-changers train in the same programme on their own schedule.'],
];
$included = ['1:1 personalised sessions', 'Live project experience', 'Internship letter', 'ISO-certified certificate', 'Interview & resume prep', 'Recorded sessions for life'];

// ---- Capabilities (tabbed rail) ----
$caps = [
    ['title' => 'AI & Machine Learning', 'sub' => 'Models trained, tuned and shipped — not notebooks that only run once.', 'href' => 'courses.php?cat=' . rawurlencode('AI Courses'), 'tools' => [
        ['name' => 'TensorFlow', 'sub' => 'Model training', 'short' => 'TF', 'color' => '#FF6F00'],
        ['name' => 'PyTorch', 'sub' => 'Deep learning', 'short' => 'PT', 'color' => '#EE4C2C'],
        ['name' => 'scikit-learn', 'sub' => 'Classical ML', 'short' => 'sk', 'color' => '#F7931E'],
        ['name' => 'pandas', 'sub' => 'Data wrangling', 'short' => 'pd', 'color' => '#130654'],
        ['name' => 'NumPy', 'sub' => 'Arrays', 'short' => 'np', 'color' => '#4D77CF'],
        ['name' => 'Keras', 'sub' => 'Neural nets', 'short' => 'K', 'color' => '#D00000'],
        ['name' => 'Jupyter', 'sub' => 'Experiments', 'short' => 'Jp', 'color' => '#F37626'],
        ['name' => 'OpenAI', 'sub' => 'LLM APIs', 'short' => 'AI', 'color' => '#10A37F'],
    ]],
    ['title' => 'Full-Stack Engineering', 'sub' => 'Web applications built, tested and deployed end to end.', 'href' => 'courses.php?cat=' . rawurlencode('Software Development'), 'tools' => [
        ['name' => 'React', 'sub' => 'UI', 'short' => 'Re', 'color' => '#61DAFB'],
        ['name' => 'Node.js', 'sub' => 'Servers', 'short' => 'No', 'color' => '#3C873A'],
        ['name' => 'Express', 'sub' => 'APIs', 'short' => 'Ex', 'color' => '#111827'],
        ['name' => 'MongoDB', 'sub' => 'Database', 'short' => 'Mo', 'color' => '#13AA52'],
        ['name' => 'MySQL', 'sub' => 'RDBMS', 'short' => 'My', 'color' => '#00758F'],
        ['name' => 'PHP', 'sub' => 'Backend', 'short' => 'PHP', 'color' => '#777BB3'],
        ['name' => 'JavaScript', 'sub' => 'Language', 'short' => 'JS', 'color' => '#C9A800'],
        ['name' => 'Git', 'sub' => 'Version control', 'short' => 'Git', 'color' => '#F05032'],
    ]],
    ['title' => 'Data & Analytics', 'sub' => 'From raw data to dashboards people actually use.', 'href' => 'courses.php?cat=' . rawurlencode('Data Science'), 'tools' => [
        ['name' => 'Python', 'sub' => 'Language', 'short' => 'Py', 'color' => '#3776AB'],
        ['name' => 'SQL', 'sub' => 'Queries', 'short' => 'SQL', 'color' => '#336791'],
        ['name' => 'Power BI', 'sub' => 'BI', 'short' => 'BI', 'color' => '#B58B00'],
        ['name' => 'Tableau', 'sub' => 'Visualisation', 'short' => 'Tb', 'color' => '#E97627'],
        ['name' => 'Excel', 'sub' => 'Sheets', 'short' => 'Xl', 'color' => '#217346'],
        ['name' => 'pandas', 'sub' => 'Wrangling', 'short' => 'pd', 'color' => '#130654'],
    ]],
    ['title' => 'Cloud & DevOps', 'sub' => 'Infrastructure automated, monitored and shipped on every commit.', 'href' => 'courses.php?cat=' . rawurlencode('Programming'), 'tools' => [
        ['name' => 'AWS', 'sub' => 'Cloud', 'short' => 'AWS', 'color' => '#FF9900'],
        ['name' => 'Azure', 'sub' => 'Cloud', 'short' => 'Az', 'color' => '#0078D4'],
        ['name' => 'Docker', 'sub' => 'Containers', 'short' => 'Do', 'color' => '#2496ED'],
        ['name' => 'Kubernetes', 'sub' => 'Orchestration', 'short' => 'K8', 'color' => '#326CE5'],
        ['name' => 'Terraform', 'sub' => 'IaC', 'short' => 'Tf', 'color' => '#7B42BC'],
        ['name' => 'Jenkins', 'sub' => 'CI/CD', 'short' => 'Jk', 'color' => '#D33833'],
        ['name' => 'Linux', 'sub' => 'Systems', 'short' => 'Lx', 'color' => '#1B1B1B'],
    ]],
    ['title' => 'Cyber Security', 'sub' => 'Offence and defence on real networks and systems.', 'href' => 'courses.php?cat=' . rawurlencode('Cyber Courses'), 'tools' => [
        ['name' => 'Kali Linux', 'sub' => 'Pentesting', 'short' => 'KL', 'color' => '#268BD2'],
        ['name' => 'Wireshark', 'sub' => 'Analysis', 'short' => 'Ws', 'color' => '#1679A7'],
        ['name' => 'Burp Suite', 'sub' => 'Web security', 'short' => 'Bp', 'color' => '#FF6633'],
        ['name' => 'Metasploit', 'sub' => 'Exploit', 'short' => 'Ms', 'color' => '#2596CD'],
        ['name' => 'Nmap', 'sub' => 'Scanning', 'short' => 'Nm', 'color' => '#4682B4'],
    ]],
    ['title' => 'Digital Marketing', 'sub' => 'Campaigns that rank, convert and report cleanly.', 'href' => 'courses.php?cat=' . rawurlencode('Digital Marketing'), 'tools' => [
        ['name' => 'SEO', 'sub' => 'Search', 'short' => 'SEO', 'color' => '#34A853'],
        ['name' => 'Google Ads', 'sub' => 'PPC', 'short' => 'Ads', 'color' => '#4285F4'],
        ['name' => 'Meta Ads', 'sub' => 'Social', 'short' => 'Meta', 'color' => '#0866FF'],
        ['name' => 'Analytics', 'sub' => 'Analytics', 'short' => 'GA', 'color' => '#E37400'],
        ['name' => 'Canva', 'sub' => 'Creative', 'short' => 'Cv', 'color' => '#00C4CC'],
        ['name' => 'WordPress', 'sub' => 'CMS', 'short' => 'Wp', 'color' => '#21759B'],
    ]],
];

// ---- Technology stack (filterable) ----
// Each chip: [Name, monogram, brand hex, simpleicons slug ('' = no logo, use monogram)]
$stackGroups = [
    ['id' => 'programming', 'label' => 'Programming', 'dot' => 'bg-accent-glow', 'chips' => [
        ['Python', 'py', '#3776AB', 'python'], ['Java', 'Ja', '#E76F00', 'openjdk'], ['C++', 'C++', '#00599C', 'cplusplus'], ['JavaScript', 'JS', '#C9A800', 'javascript'],
        ['TypeScript', 'TS', '#3178C6', 'typescript'], ['PHP', 'PHP', '#777BB3', 'php'], ['C', 'C', '#5C6B7A', 'c'], ['Go', 'Go', '#00ADD8', 'go'],
    ]],
    ['id' => 'frameworks', 'label' => 'Frameworks', 'dot' => 'bg-hero-glow', 'chips' => [
        ['React', 'Re', '#61DAFB', 'react'], ['Angular', 'Ng', '#DD0031', 'angular'], ['Next.js', 'Nx', '#111827', 'nextdotjs'], ['Node.js', 'No', '#3C873A', 'nodedotjs'],
        ['Django', 'Dj', '#092E20', 'django'], ['Laravel', 'Lv', '#FF2D20', 'laravel'], ['Spring Boot', 'Sb', '#6DB33F', 'springboot'], ['.NET', '.N', '#512BD4', 'dotnet'],
    ]],
    ['id' => 'ai-ml', 'label' => 'AI & ML', 'dot' => 'bg-up-soft', 'chips' => [
        ['TensorFlow', 'TF', '#FF6F00', 'tensorflow'], ['PyTorch', 'PT', '#EE4C2C', 'pytorch'], ['scikit-learn', 'sk', '#F7931E', 'scikitlearn'], ['Keras', 'K', '#D00000', 'keras'],
        ['pandas', 'pd', '#130654', 'pandas'], ['NumPy', 'np', '#4D77CF', 'numpy'], ['OpenAI', 'AI', '#10A37F', ''], ['LangChain', 'LC', '#1C3C3C', 'langchain'],
    ]],
    ['id' => 'cad-cam', 'label' => 'CAD / CAM', 'dot' => 'bg-accent-yellow', 'chips' => [
        ['AutoCAD', 'AC', '#E51050', 'autocad'], ['SolidWorks', 'SW', '#D6001C', ''], ['Revit', 'Rv', '#186BFF', 'autodeskrevit'], ['3ds Max', '3ds', '#00A0E4', ''],
        ['CATIA', 'Ca', '#005386', 'dassaultsystemes'], ['SketchUp', 'SU', '#005F9E', 'sketchup'],
    ]],
    ['id' => 'databases', 'label' => 'Databases', 'dot' => 'bg-accent-400', 'chips' => [
        ['MySQL', 'My', '#00758F', 'mysql'], ['PostgreSQL', 'PG', '#336791', 'postgresql'], ['MongoDB', 'Mo', '#13AA52', 'mongodb'], ['SQL Server', 'Ms', '#CC2927', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/microsoftsqlserver/microsoftsqlserver-original.svg'],
        ['Oracle', 'Or', '#F80000', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/oracle/oracle-original.svg'], ['Redis', 'Rd', '#DC382D', 'redis'],
    ]],
    ['id' => 'devops', 'label' => 'DevOps', 'dot' => 'bg-brand-400', 'chips' => [
        ['Docker', 'Do', '#2496ED', 'docker'], ['Kubernetes', 'K8', '#326CE5', 'kubernetes'], ['Jenkins', 'Jk', '#D33833', 'jenkins'], ['Terraform', 'Tf', '#7B42BC', 'terraform'],
        ['GitHub Actions', 'GH', '#2088FF', 'githubactions'], ['Ansible', 'An', '#1A1918', 'ansible'], ['Nginx', 'Ng', '#009639', 'nginx'], ['Linux', 'Lx', '#1B1B1B', 'linux'],
    ]],
    ['id' => 'cloud', 'label' => 'Cloud', 'dot' => 'bg-up-gold', 'chips' => [
        ['AWS', 'AWS', '#FF9900', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/amazonwebservices/amazonwebservices-original-wordmark.svg'], ['Azure', 'Az', '#0078D4', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/azure/azure-original.svg'], ['Google Cloud', 'GC', '#4285F4', 'googlecloud'], ['Vercel', 'Vc', '#111827', 'vercel'],
        ['Netlify', 'Nt', '#00C7B7', 'netlify'], ['Cloudflare', 'Cf', '#F38020', 'cloudflare'], ['DigitalOcean', 'DO', '#0080FF', 'digitalocean'],
    ]],
];

// Tech logo: Simple Icons slug OR a full URL (devicon), with monogram fallback
$techLogo = function ($slug, $mono, $color, $name, $imgClass, $monoClass) {
    $monoFallback = '<span style="background-color:' . e($color) . ';color:#fff" class="' . $monoClass . '">' . e($mono) . '</span>';
    if ($slug === '') {
        return str_replace('display:none', 'display:grid', $monoFallback);
    }
    $src = (strpos($slug, 'http') === 0) ? $slug : 'https://cdn.simpleicons.org/' . $slug;
    return '<img src="' . e($src) . '" alt="' . e($name) . '" width="24" height="24" loading="lazy" class="' . $imgClass . '" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'grid\';">'
        . '<span style="display:none;background-color:' . e($color) . ';color:#fff" class="' . $monoClass . '">' . e($mono) . '</span>';
};

// ---- FAQs ----
$faqs = [
    ['Why is Techno Coderz recognized as a top IT training institute in Mohali and Chandigarh?', 'Techno Coderz (Office No. 36, Second Floor, D-185, Phase 8B, Sector 74, Mohali) is rated among the best for IT and industrial software training, with 15,000+ alumni and a 98% placement record. We stand out through certified curriculum, practising industry mentors, live enterprise capstone projects, modern AI-integrated syllabi (Generative AI, Full Stack MERN, Cloud & DevOps, Cyber Security), and year-round recruitment drives with 450+ hiring partners across the Tricity and Pan-India.'],
    ['What is the average placement salary package for Techno Coderz students?', 'Graduates secure starting packages typically ranging from ₹3.5 LPA to ₹6.5 LPA for entry-level developers, data analysts and digital marketers, and up to ₹8 LPA to ₹14 LPA for specialised tracks in AI, Cloud & DevOps and Cyber Security across leading tech MNCs and funded startups in Mohali and Chandigarh.'],
    ['Are Techno Coderz certificates valid and verifiable?', 'Yes. Every student who successfully completes their program receives a verifiable certificate with a credential reference. On 6-month and industrial cohorts, students also receive an official Capstone Project Defence Certificate and an Internship Experience Letter recognised by leading IT employers and universities.'],
    ['Do I need a technical background or coding degree to join?', 'No. Most of our beginner tracks — Python, Web Designing, Data Analytics, Digital Marketing and Basic Computer Office Skills — assume zero prior programming experience. Our counsellors guide you into the right cohort based on your career goals, and mentors teach every concept step-by-step from fundamentals to deployment.'],
    ['What does Techno Coderz\'s 100% placement assistance include?', 'Our dedicated Corporate Relations Cell provides end-to-end career-launch support: resume engineering, LinkedIn profile optimisation, GitHub portfolio curation, mock technical and HR interview rounds, and direct interview scheduling with our network of 450+ hiring partners until you are placed.'],
    ['Are classes available both offline at the Mohali campus and live online?', 'Yes. You can attend hands-on practical lab sessions in-person at our Sector 74 campus in Mohali, join the same session live online from anywhere, or choose a hybrid schedule. Every class is recorded and accessible inside your student learning portal along with code repositories and lecture notes.'],
    ['Can I attend classes alongside my college degree or a full-time job?', 'Yes. We run flexible early-morning batches, evening batches and dedicated weekend-only cohorts. Batch timings are locked at enrolment to comfortably accommodate college timetables, working professionals and remote learners.'],
    ['Are flexible installment plans and EMI options available?', 'Yes. Course fees can be split into comfortable monthly installments over the training period, and we can guide you to educational finance providers offering interest-free EMI options, along with merit scholarships for eligible candidates.'],
    ['What real-world live industrial projects will I build?', 'All Techno Coderz programs are project-first. Depending on your specialisation you will design and deploy enterprise web apps, Agentic AI workflows, RAG pipelines, predictive machine-learning models, cloud CI/CD infrastructure on AWS, network-defence architectures, or full 3D BIM structural designs that serve as portfolio centrepieces.'],
    ['How do I reach the Techno Coderz campus from Chandigarh, Panchkula or Kharar?', 'We are located at ' . $addr . ', conveniently situated near major tech hubs with easy access from Chandigarh, Panchkula and Kharar. Ample parking and direct local transit connections are available on-site.'],
    ['Can 12th pass students and non-engineering graduates get IT jobs through Techno Coderz?', 'Yes. We run specialised After-12th Career Tracks and Diploma Programs in Full Stack Development, Cloud Computing, Cyber Security and Digital Marketing designed to bridge school education directly into high-paying corporate roles without needing a 4-year engineering degree.'],
    ['How is the curriculum kept current with 2025-2026 industry requirements?', 'Our syllabus is reviewed quarterly in collaboration with industry tech leads and hiring managers. We integrate modern tooling including Agentic AI workflows, Generative AI (LLMs, LangChain), modern JavaScript frameworks, Cloud DevOps (Docker, Kubernetes) and SOC cyber defence into all relevant curricula.'],
];

// ---- Extra <head> : Tailwind (remapped to Techno Coderz orange) + homepage CSS ----
$extraHead = <<<'HTML'
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      corePlugins: { preflight: true },
      theme: { extend: {
        colors: {
          subtle: '#f8fafc',
          line: '#e2e8f0',
          panel: '#0b1220',
          logo: '#c2410c',
          brand: { 50:'#fff4ec', 100:'#ffe6d5', 200:'#ffccab', 300:'#ffb077', 400:'#ff9143', 500:'#ff7a1a', 600:'#ff6b00', 700:'#e55f00', 900:'#7a3200' },
          hero:  { 950:'#0b1220', 900:'#131c2e', 800:'#3a2410', 600:'#c2410c', glow:'#ff6b00' },
          accent:{ 400:'#ffa94d', 500:'#ff7a00', glow:'#ff8a3d', yellow:'#ffc23d' },
          up:    { ink:'#0f172a', muted:'#475569', line:'#e2e8f0', accent:'#ff6b00', bright:'#ff8533', soft:'#ffd9bf', gold:'#ffb020' }
        },
        fontFamily: { display: ['"Plus Jakarta Sans"','ui-sans-serif','system-ui','sans-serif'] }
      }}
    };
  </script>
  <link rel="stylesheet" href="__SITE__/assets/css/tcm-home.css?v=1">
HTML;
$extraHead = str_replace('__SITE__', SITE_URL, $extraHead);
$extraScripts = '<script src="' . SITE_URL . '/assets/js/tcm-home.js?v=2"></script>';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>window.TCM_CAPS = <?= json_encode($caps, JSON_UNESCAPED_SLASHES) ?>;</script>
<script>document.addEventListener('DOMContentLoaded', function () { var c = document.getElementById('enquiryCsrf'); if (c) c.value = '<?= e($csrf) ?>'; });</script>

<main class="tcm-page overflow-x-hidden">

<!-- ============ 1. HERO ============ -->
<section class="relative isolate overflow-hidden bg-hero-950 text-white">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_45%_at_50%_92%,rgba(255,107,0,0.22),transparent_66%)]"></div>
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_45%_at_50%_0%,rgba(194,65,12,0.34),transparent_70%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="relative z-10 pb-20 pt-[7.5rem] lg:pb-24 lg:pt-[12rem]">
    <div class="container-x hero-copy text-center">
      <a href="courses.php" class="hero-badge mb-5 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-[0.72rem] font-semibold uppercase tracking-[0.14em] text-up-soft backdrop-blur-sm transition-all hover:border-accent-yellow/40 hover:bg-white/10 hover:text-white">
        <span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>★ <?= $avgRating ?> on Google · 1:1 Live Training · 100% Placement Support
      </a>
      <h1 class="mx-auto max-w-5xl font-display text-[2rem] font-extrabold uppercase leading-[1.05] tracking-[-0.025em] sm:text-5xl lg:text-[3.9rem]">
        <span class="hero-line block overflow-hidden pb-[0.1em]">
          <span class="inline-block bg-gradient-to-r from-up-soft/60 via-white to-up-soft/60 bg-clip-text text-transparent">Engineer <span class="mx-[0.22em] inline-grid h-[0.82em] w-[0.72em] translate-y-[0.08em] place-items-center bg-gradient-to-br from-accent-glow to-hero-600 align-baseline [clip-path:polygon(50%_0%,100%_25%,100%_75%,50%_100%,0%_75%,0%_25%)]"><svg viewBox="0 0 24 24" class="h-[0.4em] w-[0.4em] text-hero-950" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 8-4 4 4 4M17 8l4 4-4 4M14 5l-4 14"/></svg></span>your future in</span>
        </span>
        <span class="hero-line block overflow-hidden pb-[0.1em]">
          <span class="inline-block bg-gradient-to-r from-up-soft/60 via-white to-up-soft/60 bg-clip-text text-transparent">AI and software</span>
        </span>
      </h1>
      <p class="hero-sub mx-auto mt-6 max-w-xl text-[0.9rem] leading-relaxed text-up-soft/60 sm:text-[0.95rem]">Mohali &amp; Chandigarh's technology partner for AI, software and career-ready skills. Build real systems with live projects, expert mentors and placement support until you are hired.</p>
      <div class="hero-cta mt-8 flex flex-wrap items-center justify-center gap-3">
        <a class="accent-fill group inline-flex items-center gap-2 rounded-full px-6 py-3 text-[0.88rem] font-bold transition-all hover:-translate-y-0.5" href="contact.php">Book a free demo<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
        <a class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3 text-[0.88rem] font-semibold text-white/85 backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:border-white/45 hover:text-white" href="courses.php">Explore courses</a>
      </div>
    </div>

    <div class="mt-12 px-5 lg:mt-4 lg:px-8">
      <div class="hero-circuit relative w-full">
        <!-- Desktop constellation -->
        <div class="relative mx-auto hidden aspect-[10/3] w-full max-w-[86rem] lg:block">
          <svg viewBox="0 0 1000 300" class="absolute inset-0 h-full w-full" aria-hidden="true">
            <defs>
              <radialGradient id="hubGlow"><stop offset="0%" stop-color="#ff8a3d" stop-opacity="0.45"/><stop offset="55%" stop-color="#ff6b00" stop-opacity="0.14"/><stop offset="100%" stop-color="#ff6b00" stop-opacity="0"/></radialGradient>
              <linearGradient id="hubFill" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#3a2410"/><stop offset="100%" stop-color="#0b1220"/></linearGradient>
              <linearGradient id="nodeFill" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#131c2e"/><stop offset="100%" stop-color="#0b1220"/></linearGradient>
            </defs>
            <circle cx="500" cy="150" r="150" fill="url(#hubGlow)"></circle>
            <g fill="none" stroke="rgba(255,138,61,0.20)" stroke-width="1.1">
              <path d="M244 110 H356 L380 134 H444"></path><path d="M244 130 H380 L392 142 H444"></path><path d="M244 150 H444"></path><path d="M244 170 H380 L392 158 H444"></path><path d="M244 190 H356 L380 166 H444"></path>
              <path d="M756 110 H644 L620 134 H556"></path><path d="M756 130 H620 L608 142 H556"></path><path d="M756 150 H556"></path><path d="M756 170 H620 L608 158 H556"></path><path d="M756 190 H644 L620 166 H556"></path>
              <path d="M292 97 V123 L315 146 H444"></path><path d="M708 97 V123 L685 146 H556"></path><path d="M330 203 V177 L353 154 H444"></path><path d="M670 203 V177 L647 154 H556"></path><path d="M292 23 V10 H708 V23"></path><path d="M330 277 V290 H670 V277"></path>
            </g>
            <g fill="none" stroke-linecap="round">
              <path d="M244 110 H356 L380 134 H444" pathLength="1" stroke="#ff8a3d" stroke-width="1.6" class="circuit-pulse" style="animation-duration:3.8s;animation-delay:0s"></path>
              <path d="M244 150 H444" pathLength="1" stroke="#ff8a3d" stroke-width="1.6" class="circuit-pulse" style="animation-duration:2.9s;animation-delay:-0.55s"></path>
              <path d="M244 190 H356 L380 166 H444" pathLength="1" stroke="#ff8a3d" stroke-width="1.6" class="circuit-pulse" style="animation-duration:4.4s;animation-delay:-1.1s"></path>
              <path d="M756 110 H644 L620 134 H556" pathLength="1" stroke="#ff8a3d" stroke-width="1.6" class="circuit-pulse" style="animation-duration:4.1s;animation-delay:-1.65s"></path>
              <path d="M756 150 H556" pathLength="1" stroke="#ff8a3d" stroke-width="1.6" class="circuit-pulse" style="animation-duration:3.2s;animation-delay:-2.2s"></path>
              <path d="M756 190 H644 L620 166 H556" pathLength="1" stroke="#ff8a3d" stroke-width="1.6" class="circuit-pulse" style="animation-duration:3.6s;animation-delay:-2.75s"></path>
            </g>
            <g fill="#ff8a3d" fill-opacity="0.5">
              <rect x="241.5" y="107.5" width="5" height="5" rx="1"/><rect x="753.5" y="107.5" width="5" height="5" rx="1"/><rect x="241.5" y="147.5" width="5" height="5" rx="1"/><rect x="753.5" y="147.5" width="5" height="5" rx="1"/><rect x="241.5" y="187.5" width="5" height="5" rx="1"/><rect x="753.5" y="187.5" width="5" height="5" rx="1"/>
            </g>
            <g stroke-linejoin="round">
              <path d="M292 23.05 L324 41.52 L324 78.48 L292 96.95 L260 78.48 L260 41.52 Z" fill="url(#nodeFill)" stroke="rgba(255,138,61,0.35)" stroke-width="1.4"/>
              <path d="M708 23.05 L740 41.52 L740 78.48 L708 96.95 L676 78.48 L676 41.52 Z" fill="url(#nodeFill)" stroke="rgba(255,138,61,0.35)" stroke-width="1.4"/>
              <path d="M330 203.05 L362 221.52 L362 258.48 L330 276.95 L298 258.48 L298 221.52 Z" fill="url(#nodeFill)" stroke="rgba(255,138,61,0.35)" stroke-width="1.4"/>
              <path d="M670 203.05 L702 221.52 L702 258.48 L670 276.95 L638 258.48 L638 221.52 Z" fill="url(#nodeFill)" stroke="rgba(255,138,61,0.35)" stroke-width="1.4"/>
            </g>
            <path d="M500 70.33 L569 110.16 L569 189.84 L500 229.67 L431 189.84 L431 110.16 Z" fill="none" stroke="rgba(255,138,61,0.4)" stroke-width="1.2" stroke-dasharray="2 5" stroke-linejoin="round"/>
            <path d="M500 85.34 L556 117.67 L556 182.33 L500 214.66 L444 182.33 L444 117.67 Z" fill="url(#hubFill)" stroke="#ff8a3d" stroke-width="1.8" stroke-linejoin="round"/>
          </svg>
          <span style="left:29.2%;top:20%" class="absolute grid h-12 w-12 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border border-white/10 bg-white/[0.06] font-display text-[0.6rem] font-extrabold text-white/85">Py</span>
          <span style="left:70.8%;top:20%" class="absolute grid h-12 w-12 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border border-white/10 bg-white/[0.06] font-display text-[0.6rem] font-extrabold text-white/85">TF</span>
          <span style="left:33%;top:80%" class="absolute grid h-12 w-12 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border border-white/10 bg-white/[0.06] font-display text-[0.6rem] font-extrabold text-white/85">Re</span>
          <span style="left:67%;top:80%" class="absolute grid h-12 w-12 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border border-white/10 bg-white/[0.06] font-display text-[0.6rem] font-extrabold text-white/85">Do</span>
          <span style="left:50%;top:50%" class="absolute flex -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-1">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 8-4 4 4 4M17 8l4 4-4 4M14 5l-4 14"/></svg>
            <span class="font-display text-[0.72rem] font-extrabold tracking-tight text-white">Techno Coderz</span>
          </span>

          <!-- Floating card: course demand -->
          <div class="absolute left-[2%] top-[30%] w-[22%]">
            <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.08] to-white/[0.02] p-4 shadow-[0_24px_60px_-28px_rgba(0,0,0,0.9)] backdrop-blur-xl">
              <div class="flex items-start justify-between gap-2">
                <p class="text-[0.82rem] font-semibold text-white">Course demand</p>
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0 text-up-soft/50"><path d="M7 17 17 7M9 7h8v8"/></svg>
              </div>
              <p class="mt-0.5 text-[0.68rem] text-up-soft/55">Enrolments are up <span class="inline-flex items-center gap-0.5 font-semibold text-accent-glow"><svg viewBox="0 0 24 24" class="h-2.5 w-2.5" fill="currentColor" aria-hidden="true"><path d="M12 4 20 16H4Z"/></svg>2.39%</span></p>
              <div class="mt-3 grid grid-cols-3 gap-2 border-t border-white/10 pt-3">
                <div><p class="text-[0.82rem] font-bold text-white">128</p><p class="mt-0.5 truncate text-[0.58rem] text-up-soft/50">AI &amp; Data</p><div class="mt-2 h-7 overflow-hidden rounded-[0.3rem]"><div class="h-full w-full bg-gradient-to-b from-accent-glow to-accent-500"></div></div></div>
                <div><p class="text-[0.82rem] font-bold text-white">96</p><p class="mt-0.5 truncate text-[0.58rem] text-up-soft/50">Full Stack</p><div class="mt-2 h-7 overflow-hidden rounded-[0.3rem]"><div class="h-full w-full bg-gradient-to-b from-hero-glow to-hero-600"></div></div></div>
                <div><p class="text-[0.82rem] font-bold text-white">74</p><p class="mt-0.5 truncate text-[0.58rem] text-up-soft/50">Cyber</p><div class="mt-2 h-7 overflow-hidden rounded-[0.3rem]"><div class="flex h-full items-end gap-[1.5px]"><span style="height:40%" class="flex-1 rounded-[1px] bg-up-soft/60"></span><span style="height:62%" class="flex-1 rounded-[1px] bg-up-soft/60"></span><span style="height:48%" class="flex-1 rounded-[1px] bg-up-soft/60"></span><span style="height:78%" class="flex-1 rounded-[1px] bg-up-soft/60"></span><span style="height:55%" class="flex-1 rounded-[1px] bg-up-soft/60"></span><span style="height:88%" class="flex-1 rounded-[1px] bg-up-soft/60"></span></div></div></div>
              </div>
            </div>
          </div>

          <!-- Floating card: students placed -->
          <div class="absolute right-[2%] top-[30%] w-[22%]">
            <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.08] to-white/[0.02] p-4 shadow-[0_24px_60px_-28px_rgba(0,0,0,0.9)] backdrop-blur-xl">
              <div class="flex items-start justify-between gap-2">
                <p class="text-[0.82rem] font-semibold text-white">Students placed</p>
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0 text-up-soft/50"><path d="M7 17 17 7M9 7h8v8"/></svg>
              </div>
              <p class="mt-1 flex items-baseline gap-1.5"><span class="font-display text-[1.15rem] font-extrabold text-white">1,240</span><span class="text-[0.62rem]"><span class="inline-flex items-center gap-0.5 font-semibold text-accent-glow"><svg viewBox="0 0 24 24" class="h-2.5 w-2.5" fill="currentColor" aria-hidden="true"><path d="M12 4 20 16H4Z"/></svg>8.6%</span></span></p>
              <div class="mt-2.5 flex gap-2">
                <div class="flex flex-col justify-between py-0.5 text-[0.5rem] text-up-soft/40"><span>400</span><span>300</span><span>200</span><span>100</span></div>
                <div class="relative flex-1">
                  <svg viewBox="0 0 160 60" class="h-[3.6rem] w-full" preserveAspectRatio="none"><defs><linearGradient id="placedFill" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#ff8a3d" stop-opacity="0.42"/><stop offset="100%" stop-color="#ff8a3d" stop-opacity="0"/></linearGradient></defs><path d="M0 46 C 14 45, 22 42, 34 40 S 54 37, 66 33 S 86 24, 98 22 S 118 27, 130 25 S 150 13, 160 9 L160 60 L0 60 Z" fill="url(#placedFill)"/><path d="M0 46 C 14 45, 22 42, 34 40 S 54 37, 66 33 S 86 24, 98 22 S 118 27, 130 25 S 150 13, 160 9" fill="none" stroke="#ff8a3d" stroke-width="2" vector-effect="non-scaling-stroke" stroke-linecap="round"/></svg>
                  <span class="absolute left-[81.25%] top-[41.6%] block h-2 w-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-[0_0_0_3px_rgba(255,138,61,0.35),0_0_14px_4px_rgba(255,138,61,0.55)]"></span>
                  <span class="absolute left-[81.25%] top-[41.6%] -translate-x-1/2 -translate-y-[190%] whitespace-nowrap rounded-md bg-white px-1.5 py-0.5 text-[0.55rem] font-bold text-hero-950 shadow-lg">312</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Mobile fallback -->
        <div class="lg:hidden">
          <div class="mb-8 flex items-center justify-center gap-4">
            <?php foreach ([['Py', 'from-hero-600 to-hero-glow'], ['TF', 'from-accent-glow to-accent-500'], ['Re', 'from-brand-400 to-brand-700'], ['Do', 'from-hero-glow to-hero-600']] as $t): ?>
            <span class="grid h-14 w-14 place-items-center border border-white/10 bg-white/[0.06] [clip-path:polygon(50%_0%,100%_25%,100%_75%,50%_100%,0%_75%,0%_25%)]"><span class="font-display text-[0.7rem] font-extrabold text-white/90"><?= $t[0] ?></span></span>
            <?php endforeach; ?>
          </div>
          <div class="mx-auto grid max-w-xl gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.08] to-white/[0.02] p-4 backdrop-blur-xl">
              <p class="text-[0.82rem] font-semibold text-white">Course demand</p>
              <p class="mt-0.5 text-[0.68rem] text-up-soft/55">Enrolments are up <span class="font-semibold text-accent-glow">2.39%</span></p>
              <div class="mt-3 grid grid-cols-3 gap-2 border-t border-white/10 pt-3">
                <div><p class="text-[0.82rem] font-bold text-white">128</p><p class="mt-0.5 text-[0.58rem] text-up-soft/50">AI &amp; Data</p><div class="mt-2 h-7 overflow-hidden rounded-[0.3rem]"><div class="h-full w-full bg-gradient-to-b from-accent-glow to-accent-500"></div></div></div>
                <div><p class="text-[0.82rem] font-bold text-white">96</p><p class="mt-0.5 text-[0.58rem] text-up-soft/50">Full Stack</p><div class="mt-2 h-7 overflow-hidden rounded-[0.3rem]"><div class="h-full w-full bg-gradient-to-b from-hero-glow to-hero-600"></div></div></div>
                <div><p class="text-[0.82rem] font-bold text-white">74</p><p class="mt-0.5 text-[0.58rem] text-up-soft/50">Cyber</p><div class="mt-2 h-7 overflow-hidden rounded-[0.3rem]"><div class="h-full w-full bg-gradient-to-b from-up-soft to-brand-400"></div></div></div>
              </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/[0.08] to-white/[0.02] p-4 backdrop-blur-xl">
              <p class="text-[0.82rem] font-semibold text-white">Students placed</p>
              <p class="mt-1 flex items-baseline gap-1.5"><span class="font-display text-[1.15rem] font-extrabold text-white">1,240</span><span class="text-[0.62rem] font-semibold text-accent-glow">8.6%</span></p>
              <div class="mt-3 h-14 overflow-hidden rounded-lg"><div class="h-full w-full bg-gradient-to-t from-hero-glow/20 via-hero-glow/50 to-accent-glow"></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 2. STATS ============ -->
<section class="relative z-10 -mt-14 lg:-mt-16">
  <div class="container-x">
    <div data-anim="up" class="relative grid overflow-hidden rounded-3xl border border-line bg-white shadow-[0_28px_60px_-28px_rgba(15,23,42,0.45)] sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($stats as $s): ?>
      <div class="group relative border-line px-7 py-8 transition-colors hover:bg-subtle sm:[&:nth-child(odd)]:border-r lg:border-r lg:last:border-r-0">
        <span class="absolute inset-x-0 top-0 h-0.5 origin-left scale-x-0 bg-gradient-to-r from-hero-600 to-accent-glow transition-transform duration-500 group-hover:scale-x-100"></span>
        <span class="mb-4 grid h-11 w-11 place-items-center rounded-xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white"><svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $s['icon'] ?></svg></span>
        <p class="font-display text-3xl font-extrabold text-up-ink lg:text-4xl"><span data-count="<?= (int) $s['count'] ?>">0</span><span class="text-up-accent"><?= e($s['suffix']) ?></span></p>
        <p class="mt-1.5 text-sm text-up-muted"><?= e($s['label']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 3. AI BAND ============ -->
<section class="relative overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_20%_10%,#3a2410_0%,transparent_60%),radial-gradient(ellipse_60%_50%_at_90%_80%,#c2410c_0%,transparent_55%)]"></div>
  <div class="absolute inset-0 grid-lines"></div>
  <div class="glow-blob left-[-5%] top-[20%] h-[400px] w-[400px] animate-pulse-glow bg-accent-glow/20"></div>
  <div class="container-x relative">
    <div class="grid gap-14 lg:grid-cols-[1fr_1.05fr] lg:items-center">
      <div>
        <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-white/15 bg-white/5 text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>AI at Techno Coderz</div>
        <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-white">The skills every job description now asks for</h2>
        <div data-underline class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
        <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-soft/80">Artificial intelligence stopped being a specialisation — it is becoming baseline literacy. Our AI tracks are rebuilt every quarter so what you learn matches what is shipping right now.</p>
        <div data-anim="up" data-anim-delay="0.15" class="mt-9 flex flex-wrap gap-4">
          <a class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-accent-glow to-hero-glow px-7 py-3.5 text-sm font-bold text-hero-950 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-accent-glow/30" href="best-artificial-intelligence-course-in-mohali.php">Explore AI courses<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
          <a class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:border-white/40 hover:bg-white/10" href="contact.php">Talk to a counsellor</a>
        </div>
      </div>
      <div data-anim="right" class="space-y-4">
        <?php foreach ($aiCards as $i => $c): ?>
        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] p-7 backdrop-blur-sm transition-all duration-500 hover:border-accent-glow/40 hover:bg-white/[0.08]">
          <span class="absolute left-0 top-0 h-full w-1 origin-top scale-y-0 bg-gradient-to-b from-accent-glow to-hero-glow transition-transform duration-500 group-hover:scale-y-100"></span>
          <div class="flex items-start justify-between gap-4">
            <div>
              <p class="text-[0.65rem] font-bold uppercase tracking-[0.16em] text-accent-yellow"><?= e($c['label']) ?></p>
              <h3 class="mt-2 text-lg font-bold text-white"><?= e($c['title']) ?></h3>
              <p class="mt-2.5 text-sm leading-relaxed text-up-soft/70"><?= e($c['desc']) ?></p>
            </div>
            <span class="font-display text-3xl font-extrabold text-white/10 transition-colors group-hover:text-accent-glow/30">0<?= $i + 1 ?></span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ 4. VISION / MISSION ============ -->
<section id="vision" class="relative scroll-mt-32 overflow-hidden bg-gradient-to-b from-white via-subtle to-white py-16 lg:py-24">
  <div class="pointer-events-none absolute inset-0">
    <div class="glow-blob left-[2%] top-[12%] h-[24rem] w-[24rem] bg-brand-300/45"></div>
    <div class="glow-blob right-[10%] bottom-[8%] h-[22rem] w-[22rem] bg-accent-400/35"></div>
  </div>
  <div class="pointer-events-none absolute inset-0 grid-lines-light opacity-60"></div>
  <div class="container-x relative grid items-center gap-14 lg:grid-cols-[1fr_minmax(0,30rem)] lg:gap-20">
    <div>
      <div class="space-y-14 lg:space-y-16">
        <div data-anim="up" data-anim-delay="0">
          <span class="glass inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-[0.65rem] font-bold uppercase tracking-[0.18em] text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>Where we are going</span>
          <h2 class="mt-5 font-display text-[2.1rem] font-extrabold leading-[1.08] tracking-tight text-up-ink sm:text-[2.6rem]">Our Vision</h2>
          <p class="mt-4 max-w-xl text-[0.98rem] leading-relaxed text-up-muted">To be the centre Punjab's employers name first — where someone can walk in without a line of code to their name and walk out an engineer a company is glad to have hired. Not a certificate mill; a place a career actually starts.</p>
        </div>
        <div data-anim="up" data-anim-delay="0.12">
          <span class="glass inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-[0.65rem] font-bold uppercase tracking-[0.18em] text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>What we do daily</span>
          <h2 class="mt-5 font-display text-[2.1rem] font-extrabold leading-[1.08] tracking-tight text-up-ink sm:text-[2.6rem]">Our Mission</h2>
          <p class="mt-4 max-w-xl text-[0.98rem] leading-relaxed text-up-muted">To teach what the industry genuinely runs on, in sessions small enough that a trainer notices when you are stuck, on projects with real requirements and real deadlines — and to stay with every student until the offer letter arrives.</p>
        </div>
      </div>
      <a data-anim="fade" class="accent-fill group mt-12 inline-flex items-center gap-2 rounded-full px-7 py-3.5 text-sm font-bold transition-all hover:-translate-y-0.5" href="about.php">More about us<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
    </div>
    <div data-anim="right" class="relative mx-auto hidden aspect-[5/6] w-full max-w-md lg:block">
      <?php
      $vfigs = [
          ['left:24%;top:0%;width:54%;height:74%;z-index:10', 'from-hero-800 via-hero-600 to-accent-glow', 'Sector 74 campus', '<path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>'],
          ['left:0%;top:16%;width:26%;height:22%;z-index:20', 'from-hero-900 to-hero-600', 'Live projects', '<path d="m8 6-6 6 6 6M16 6l6 6-6 6M14 4l-4 16"/>'],
          ['left:2%;top:56%;width:28%;height:24%;z-index:20', 'from-brand-700 to-accent-500', '1:1 sessions', '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/>'],
          ['left:80%;top:10%;width:18%;height:16%;z-index:20', 'from-hero-600 to-accent-glow', 'Hiring drives', '<rect x="3" y="7.5" width="18" height="12" rx="2"/><path d="M9 7.5V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1.5M3 12.5h18"/>'],
          ['left:62%;top:76%;width:30%;height:22%;z-index:20', 'from-hero-950 to-hero-800', 'ISO certified', '<circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1 7 4.5-2.5 4.5 2.5-1-7"/>'],
      ];
      foreach ($vfigs as $fb): ?>
      <figure style="<?= $fb[0] ?>" class="absolute overflow-hidden rounded-[1.5rem] border-2 border-white/80 shadow-[0_30px_70px_-30px_rgba(15,23,42,0.6)]">
        <div class="absolute inset-0 bg-gradient-to-br <?= $fb[1] ?>"></div>
        <div class="absolute inset-0 grid-lines opacity-60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-hero-950/85 via-hero-950/20 to-transparent"></div>
        <figcaption class="absolute inset-x-0 bottom-0 flex items-center gap-2 p-3.5">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0 text-accent-glow"><?= $fb[2] ?></svg>
          <span class="truncate text-[0.68rem] font-semibold text-white"><?= e($fb[2]) ?></span>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <div data-anim="up" class="grid grid-cols-2 gap-4 lg:hidden">
      <figure class="relative col-span-2 aspect-[16/10] overflow-hidden rounded-2xl border-2 border-white/80 shadow-[0_20px_50px_-24px_rgba(15,23,42,0.55)]">
        <div class="absolute inset-0 bg-gradient-to-br from-hero-800 via-hero-600 to-accent-glow"></div><div class="absolute inset-0 grid-lines opacity-60"></div><div class="absolute inset-0 bg-gradient-to-t from-hero-950/85 via-hero-950/20 to-transparent"></div>
        <figcaption class="absolute inset-x-0 bottom-0 flex items-center gap-2 p-3"><span class="truncate text-[0.66rem] font-semibold text-white">Sector 74 campus</span></figcaption>
      </figure>
      <?php foreach ([['from-hero-900 to-hero-600', 'Live projects'], ['from-brand-700 to-accent-500', '1:1 sessions'], ['from-hero-600 to-accent-glow', 'Hiring drives'], ['from-hero-950 to-hero-800', 'ISO certified']] as $fb): ?>
      <figure class="relative aspect-square overflow-hidden rounded-2xl border-2 border-white/80 shadow-[0_20px_50px_-24px_rgba(15,23,42,0.55)]">
        <div class="absolute inset-0 bg-gradient-to-br <?= $fb[0] ?>"></div><div class="absolute inset-0 grid-lines opacity-60"></div><div class="absolute inset-0 bg-gradient-to-t from-hero-950/85 via-hero-950/20 to-transparent"></div>
        <figcaption class="absolute inset-x-0 bottom-0 flex items-center gap-2 p-3"><span class="truncate text-[0.66rem] font-semibold text-white"><?= e($fb[1]) ?></span></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 5. DURATIONS ============ -->
<section id="durations" class="relative scroll-mt-32 overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_50%_at_50%_0%,rgba(194,65,12,0.35),transparent_68%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-white/15 bg-white/5 text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>Training programmes</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-white">Pick the length that fits your year</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-soft/80">Summer training, a university requirement, or a full career switch — the same trainers and the same live-project method, scaled to your time.</p>
    </div>
    <div data-anim="up" class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
      <?php foreach ($durations as $d): ?>
      <div class="card-hover glass-sheen group relative flex flex-col overflow-hidden rounded-3xl p-8 <?= $d['featured'] ? 'border border-accent-glow/40 bg-gradient-to-br from-hero-800 via-hero-600 to-hero-glow' : 'glass-dark' ?>">
        <?php if ($d['featured']): ?><span class="absolute right-6 top-6 z-10 rounded-full bg-accent-yellow px-2.5 py-1 text-[0.6rem] font-bold uppercase tracking-wider text-hero-950">Most popular</span><?php endif; ?>
        <p class="relative font-display text-4xl font-extrabold <?= $d['featured'] ? 'text-white' : 'text-accent-glow' ?>"><?= e($d['dur']) ?></p>
        <h3 class="relative mt-3 text-base font-bold leading-snug text-white"><?= e($d['title']) ?></h3>
        <p class="relative mt-3 text-sm leading-relaxed text-up-soft/70"><?= e($d['desc']) ?></p>
        <ul class="relative mt-6 space-y-2.5">
          <?php foreach ($d['features'] as $f): ?>
          <li class="flex items-start gap-2.5 text-sm text-up-soft/85"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0 text-accent-glow"><path d="m4 12 5 5L20 6"/></svg><?= e($f) ?></li>
          <?php endforeach; ?>
        </ul>
        <a class="relative mt-8 inline-flex items-center gap-2 text-sm font-semibold text-accent-glow" href="<?= e($d['link']) ?>">Programme details<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 6. PROCESS ============ -->
<section class="relative overflow-hidden bg-gradient-to-b from-white via-subtle to-white py-16 lg:py-24">
  <div class="pointer-events-none absolute inset-0">
    <div class="absolute left-1/4 top-0 h-[500px] w-[500px] rounded-full bg-[#ff6b00]/[0.06] blur-[120px]"></div>
    <div class="absolute bottom-0 right-1/4 h-[400px] w-[400px] rounded-full bg-[#ff8a3d]/[0.05] blur-[100px]"></div>
  </div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>How it works</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink">From first phone call to first offer letter</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">A deliberately simple path. No hidden steps, no upsells halfway through — you always know what the next four weeks look like.</p>
    </div>
    <div class="relative mt-16 hidden lg:block lg:mt-20">
      <div class="absolute left-[12.5%] right-[12.5%] top-[42px] h-px bg-line"><div class="process-connector"></div></div>
    </div>
    <div class="relative mt-8 grid gap-6 sm:grid-cols-2 lg:mt-0 lg:grid-cols-4 lg:gap-8">
      <?php
      $steps = [
          ['01', 'Free counselling', 'Tell us your background and where you want to be. We map that to a specific track, session and timeline — no generic brochure.', 'Day 0', 'from-[#ff6b00] to-[#ff8a3d]', '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/>'],
          ['02', 'Learn by building', 'Concepts in the morning, code in the afternoon. Each module ends in something that runs, gets reviewed and goes into your portfolio.', 'Weeks 1-8', 'from-[#c2410c] to-[#ff6b00]', '<path d="m8 6-6 6 6 6M16 6l6 6-6 6M14 4l-4 16"/>'],
          ['03', 'Live project & internship', 'Join a project team with real requirements and deadlines, mentored by a working engineer, and earn an internship letter.', 'Weeks 9-12', 'from-[#ffb020] to-[#ff6b00]', '<path d="M12 3c3.5 2 5.5 5.5 5.5 9.5L15 15H9l-2.5-2.5C6.5 8.5 8.5 5 12 3Z"/><path d="M9 15l-2 4 3-1M15 15l2 4-3-1"/><circle cx="12" cy="10" r="1.6"/>'],
          ['04', 'Interview & placement', 'Resume rebuild, mock interviews, aptitude practice, then introductions to hiring partners and continuous placement drives.', 'Week 12+', 'from-[#ff8a3d] to-[#ffc23d]', '<rect x="3" y="7.5" width="18" height="12" rx="2"/><path d="M9 7.5V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1.5M3 12.5h18"/>'],
      ];
      foreach ($steps as $st): ?>
      <div class="group relative flex h-full flex-col">
        <div class="relative z-10 mx-auto mb-6 hidden lg:flex lg:justify-center">
          <div class="grid h-[84px] w-[84px] place-items-center rounded-full bg-gradient-to-br <?= $st[4] ?> shadow-[0_14px_34px_-14px_rgba(15,23,42,0.55)] ring-4 ring-white"><span class="text-2xl font-extrabold text-white"><?= $st[0] ?></span></div>
        </div>
        <div class="relative flex-1 rounded-2xl border border-line bg-white p-6 shadow-[0_18px_50px_-32px_rgba(15,23,42,0.5)] transition-all duration-300 hover:-translate-y-1 hover:border-up-line">
          <div class="mb-4 flex items-center gap-3 lg:hidden"><span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br <?= $st[4] ?> text-sm font-bold text-white"><?= $st[0] ?></span><span class="text-[0.68rem] font-semibold uppercase tracking-[0.16em] text-up-muted">Step <?= $st[0] ?></span></div>
          <span class="mb-4 inline-grid h-12 w-12 place-items-center rounded-xl bg-gradient-to-br <?= $st[4] ?> text-white shadow-lg"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $st[5] ?></svg></span>
          <h3 class="mb-2 text-lg font-bold text-up-ink"><?= e($st[1]) ?></h3>
          <p class="mb-4 text-sm leading-relaxed text-up-muted"><?= e($st[2]) ?></p>
          <span class="inline-block rounded-full border border-up-line bg-brand-50 px-3 py-1.5 text-[0.68rem] font-semibold uppercase tracking-[0.12em] text-up-accent"><?= e($st[3]) ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 7. SIX FIELDS ============ -->
<section class="relative overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_50%_at_50%_15%,rgba(194,65,12,0.35),transparent_68%)]"></div>
  <div class="absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between lg:gap-8">
      <div class="max-w-3xl">
        <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-white/15 bg-white/5 text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>What you can learn</div>
        <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-white">Six fields, one campus in <span class="text-accent-glow">Mohali</span></h2>
        <div data-underline class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
        <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-soft/80">Every track is taught by working professionals, built around live projects, and backed by the same placement cell.</p>
      </div>
      <a data-anim="fade" class="group hidden shrink-0 items-center gap-2 rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:border-white/45 hover:bg-white/5 lg:inline-flex" href="courses.php">Browse all courses<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
    </div>
    <div data-anim="up" class="mt-12 grid gap-5 sm:grid-cols-2 lg:mt-16 lg:grid-cols-3 lg:gap-6">
      <?php foreach ($fields as $i => $f): ?>
      <a class="card-hover group relative flex flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/[0.04] p-7 backdrop-blur-sm transition-all hover:border-white/20 hover:bg-white/[0.08] lg:p-9" href="<?= e($f['href']) ?>">
        <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-gradient-to-br <?= $f['grad'] ?> opacity-20 blur-3xl transition-all duration-700 group-hover:scale-[1.8] group-hover:opacity-40"></div>
        <span class="absolute right-6 top-5 font-display text-[3.5rem] font-extrabold leading-none text-white/[0.04] lg:right-8 lg:top-6 lg:text-[4.5rem]">0<?= $i + 1 ?></span>
        <span class="relative grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br <?= $f['grad'] ?> text-hero-950 shadow-lg transition-transform duration-500 group-hover:-rotate-6 group-hover:scale-110 lg:h-14 lg:w-14"><svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $f['icon'] ?></svg></span>
        <h3 class="relative mt-6 font-display text-xl font-bold text-white transition-colors group-hover:text-accent-glow lg:text-[1.35rem]"><?= e($f['name']) ?></h3>
        <p class="relative mt-3 flex-1 text-sm leading-relaxed text-up-soft/60"><?= e($f['desc']) ?></p>
        <span class="relative mt-6 inline-flex items-center gap-2 text-sm font-semibold text-accent-glow">Explore track<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1.5"><path d="M4 12h16M14 6l6 6-6 6"/></svg></span>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="mt-10 text-center lg:hidden">
      <a class="group inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:border-white/45 hover:bg-white/5" href="courses.php">Browse all courses<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
    </div>
  </div>
</section>

<!-- ============ 8. COURSE CATEGORIES ============ -->
<section class="relative overflow-hidden bg-gradient-to-b from-white via-subtle to-white py-16 lg:py-24">
  <div class="pointer-events-none absolute inset-0">
    <div class="glow-blob left-[4%] top-[14%] h-[26rem] w-[26rem] bg-brand-300/50"></div>
    <div class="glow-blob right-[6%] top-[6%] h-[22rem] w-[22rem] bg-accent-400/40"></div>
    <div class="glow-blob bottom-[6%] left-[34%] h-[24rem] w-[24rem] bg-hero-glow/25"></div>
    <div class="glow-blob bottom-[16%] right-[3%] h-[20rem] w-[20rem] bg-accent-yellow/30"></div>
  </div>
  <div class="pointer-events-none absolute inset-0 grid-lines-light opacity-60"></div>
  <div class="container-x relative">
    <div class="grid gap-6 lg:grid-cols-2 lg:items-end lg:gap-16">
      <div data-anim="up">
        <p class="text-[0.7rem] font-bold uppercase tracking-[0.2em] text-up-bright">Course categories</p>
        <h2 class="mt-4 font-display text-[2.2rem] font-extrabold leading-[1.08] tracking-tight text-up-ink sm:text-4xl lg:text-[2.9rem]">Find your perfect<br><span class="text-up-accent">course track</span></h2>
      </div>
      <p data-anim="up" data-anim-delay="0.1" class="text-[0.97rem] leading-relaxed text-up-muted lg:pb-2">Six fields, <?= (int) $totalCourses ?> courses between them. Pick the work you want to be doing and the track follows — every one ends with a deployed project, a certificate and a placement file our hiring partners can actually read.</p>
    </div>
    <div data-anim="up" class="mt-14 grid gap-6 sm:grid-cols-2 lg:mt-16 lg:grid-cols-3 lg:gap-7">
      <?php foreach ($fields as $f): ?>
      <a class="group relative flex min-h-[22rem] flex-col overflow-hidden rounded-[1.75rem] border border-white/70 bg-white/50 p-7 shadow-[inset_0_1px_0_rgba(255,255,255,0.95),inset_0_-1px_0_rgba(255,255,255,0.4),0_28px_60px_-28px_rgba(15,23,42,0.4)] backdrop-blur-2xl backdrop-saturate-150 transition-transform duration-500 hover:-translate-y-1.5" href="<?= e($f['href']) ?>">
        <div class="pointer-events-none absolute -right-14 -top-16 h-44 w-44 rounded-full bg-gradient-to-br <?= $f['grad'] ?> opacity-30 blur-2xl transition-all duration-500 group-hover:scale-125 group-hover:opacity-55"></div>
        <div class="pointer-events-none absolute inset-x-0 top-0 h-2/3 bg-gradient-to-b from-white/75 via-white/25 to-transparent"></div>
        <span class="pointer-events-none absolute -top-3 left-4 select-none font-display text-[4.5rem] font-extrabold leading-none tracking-tighter text-up-ink/[0.07]"><?= e($f['short']) ?></span>
        <div class="relative flex items-start justify-between gap-3">
          <span class="rounded-full border border-white/60 bg-white/70 px-3 py-1 text-[0.6rem] font-bold uppercase tracking-[0.14em] text-up-muted"><?= e($f['tag']) ?></span>
          <span class="shrink-0 rounded-full px-2.5 py-1 text-[0.58rem] font-bold uppercase tracking-wide <?= $f['badge'][1] ?>"><?= e($f['badge'][0]) ?></span>
        </div>
        <h3 class="relative mt-6 text-xl font-bold leading-snug text-up-ink transition-colors group-hover:text-up-accent"><?= e($f['name']) ?></h3>
        <p class="relative mt-3 text-sm leading-relaxed text-up-muted"><?= e($f['desc']) ?></p>
        <ul class="relative mt-5 space-y-1.5">
          <?php foreach ($f['bullets'] as $b): ?>
          <li class="flex items-center gap-2 text-[0.82rem] text-up-muted"><span aria-hidden="true" class="h-1 w-1 shrink-0 rounded-full bg-up-accent/60"></span><span class="truncate"><?= e($b) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <div class="relative mt-auto flex items-end justify-between gap-4 pt-7">
          <span class="leading-tight"><span class="block text-[0.66rem] font-bold uppercase tracking-[0.16em] text-up-muted/80">In this field</span><span class="mt-1 block text-sm font-bold text-up-ink"><?= (int) $f['count'] ?> courses</span></span>
          <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/60 bg-up-ink text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_10px_22px_-10px_rgba(15,23,42,0.7)] transition-all duration-300 group-hover:bg-up-accent"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <div data-anim="fade" class="mt-14 flex justify-center">
      <a class="accent-fill group inline-flex items-center gap-2 rounded-full px-8 py-4 text-[0.9rem] font-bold transition-all hover:-translate-y-0.5" href="courses.php">Browse all <?= (int) $totalCourses ?> courses<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
    </div>
  </div>
</section>

<!-- ============ 9. WHY ============ -->
<section id="why" class="relative scroll-mt-32 overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_50%_at_75%_25%,rgba(194,65,12,0.35),transparent_68%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-white/15 bg-white/5 text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>Why Techno Coderz</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-white">Four things that change the outcome</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-soft/80">Any training centre can list a syllabus. These are the parts that decide whether you actually land a job.</p>
    </div>
    <div data-anim="up" class="mt-14 grid gap-6 lg:grid-cols-2">
      <?php foreach ($whyCards as $c): ?>
      <div class="card-hover glass-dark glass-sheen group relative overflow-hidden rounded-3xl p-8 lg:p-10">
        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-hero-glow/20 blur-xl transition-transform duration-700 group-hover:scale-[2.2]"></div>
        <div class="relative flex items-start gap-6">
          <div class="w-28 shrink-0 rounded-2xl bg-gradient-to-br from-hero-600 to-hero-glow px-3 py-3.5 text-center text-white shadow-lg shadow-hero-600/25"><p class="font-display text-xl font-extrabold leading-none"><?= e($c['stat']) ?></p><p class="mt-1 text-[0.55rem] font-medium uppercase leading-tight tracking-wider text-white/70"><?= e($c['sub']) ?></p></div>
          <div><h3 class="text-xl font-bold text-white"><?= e($c['title']) ?></h3><p class="mt-3 text-sm leading-relaxed text-up-soft/70"><?= e($c['desc']) ?></p></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div data-anim="up" class="glass-dark relative mt-8 overflow-hidden rounded-3xl p-8 lg:p-10">
      <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div><p class="text-[0.68rem] font-bold uppercase tracking-[0.16em] text-accent-yellow">Included with every course</p><h3 class="mt-2 font-display text-2xl font-extrabold text-white">No add-ons, no separate fee</h3></div>
        <ul class="flex flex-wrap gap-2.5">
          <?php foreach ($included as $inc): ?>
          <li class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-medium text-up-soft backdrop-blur-sm transition-colors hover:border-accent-glow/40 hover:text-white"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-accent-glow"><path d="m4 12 5 5L20 6"/></svg><?= e($inc) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 10. REVIEWS ============ -->
<section id="reviews" class="relative scroll-mt-32 overflow-hidden bg-gradient-to-b from-white via-subtle to-white py-16 lg:py-24">
  <div class="pointer-events-none absolute inset-0">
    <div class="glow-blob left-[6%] top-[18%] h-[24rem] w-[24rem] bg-brand-300/45"></div>
    <div class="glow-blob right-[8%] bottom-[10%] h-[22rem] w-[22rem] bg-accent-400/35"></div>
  </div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>Student stories</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink">Rated <span class="text-up-accent"><?= $avgRating ?> out of 5</span> by our students</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">The sessions change every few months. What students say about the trainers and the project work does not.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.15" class="mt-9 flex justify-center">
      <a href="<?= e('https://www.google.com/search?q=' . rawurlencode($siteName . ' ' . $loc)) ?>" target="_blank" rel="noreferrer" class="glass glass-sheen group relative inline-flex items-center gap-4 rounded-full py-2.5 pl-5 pr-3 transition-transform duration-300 hover:-translate-y-0.5">
        <span class="relative flex items-center gap-2.5">
          <svg viewBox="0 0 24 24" width="22" height="22" role="img"><title>Google</title><path fill="#4285F4" d="M21.6 12.23c0-.75-.07-1.47-.19-2.16H12v4.09h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.89-1.74 2.98-4.3 2.98-7.45Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.62-2.42l-3.24-2.5c-.9.6-2.05.96-3.38.96-2.6 0-4.8-1.76-5.59-4.12H3.06v2.58A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.41 13.92a5.99 5.99 0 0 1 0-3.84V7.5H3.06a10 10 0 0 0 0 9l3.35-2.58Z"/><path fill="#EA4335" d="M12 5.96c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.95 2.99 14.7 2 12 2A10 10 0 0 0 3.06 7.5l3.35 2.58C7.2 7.72 9.4 5.96 12 5.96Z"/></svg>
          <span class="leading-tight"><span class="block text-[0.86rem] font-bold text-up-ink">Google Reviews</span><span class="block text-[0.68rem] text-up-muted"><?= e($siteName) ?> · <?= e($loc) ?></span></span>
        </span>
        <span aria-hidden="true" class="relative h-8 w-px bg-up-line/80"></span>
        <span class="relative flex items-center gap-2"><span class="font-display text-[1.1rem] font-extrabold leading-none text-up-ink"><?= $avgRating ?></span><span class="flex items-center gap-0.5 text-accent-yellow"><?php for ($i = 0; $i < 5; $i++): ?><svg viewBox="0 0 24 24" width="13" height="13" class="fill-accent-yellow" aria-hidden="true"><path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/></svg><?php endfor; ?></span></span>
        <span class="relative grid h-9 w-9 shrink-0 place-items-center rounded-full bg-up-ink text-white transition-colors group-hover:bg-up-accent"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
      </a>
    </div>
  </div>
  <?php if ($testimonials): ?>
  <?php
    $rowA = array_slice($testimonials, 0, max(1, (int) ceil(count($testimonials) / 2)));
    $rowB = array_slice($testimonials, count($rowA));
    if (!$rowB) $rowB = $testimonials;
    $reviewCard = function ($t) {
        $nm  = $t['name'] ?? 'Student';
        $ini = strtoupper(mb_substr($nm, 0, 1));
        $parts = preg_split('/\s+/', trim($nm));
        if (count($parts) > 1) $ini .= strtoupper(mb_substr(end($parts), 0, 1));
        ob_start(); ?>
          <figure class="glass glass-sheen relative mr-6 w-[21rem] shrink-0 rounded-3xl p-7 sm:w-[24rem]">
            <div class="relative flex items-center justify-between gap-3">
              <span class="flex items-center gap-1 text-accent-yellow"><?php for ($i = 0; $i < 5; $i++): ?><svg viewBox="0 0 24 24" width="15" height="15" class="fill-accent-yellow" aria-hidden="true"><path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/></svg><?php endfor; ?></span>
              <span class="flex items-center gap-1.5 rounded-full bg-white/70 px-2.5 py-1"><svg viewBox="0 0 24 24" width="13" height="13" role="img"><title>Google</title><path fill="#4285F4" d="M21.6 12.23c0-.75-.07-1.47-.19-2.16H12v4.09h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.89-1.74 2.98-4.3 2.98-7.45Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.62-2.42l-3.24-2.5c-.9.6-2.05.96-3.38.96-2.6 0-4.8-1.76-5.59-4.12H3.06v2.58A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.41 13.92a5.99 5.99 0 0 1 0-3.84V7.5H3.06a10 10 0 0 0 0 9l3.35-2.58Z"/><path fill="#EA4335" d="M12 5.96c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.95 2.99 14.7 2 12 2A10 10 0 0 0 3.06 7.5l3.35 2.58C7.2 7.72 9.4 5.96 12 5.96Z"/></svg><span class="text-[0.62rem] font-bold uppercase tracking-[0.1em] text-up-muted">Google</span></span>
            </div>
            <blockquote class="relative mt-4 text-sm leading-relaxed text-up-ink/85">&ldquo;<?= e($t['message'] ?? '') ?>&rdquo;</blockquote>
            <figcaption class="relative mt-6 flex items-center gap-3 border-t border-white/60 pt-5">
              <span class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br from-hero-600 to-hero-glow font-display text-sm font-bold text-white"><?= e($ini) ?></span>
              <span><span class="block text-sm font-bold text-up-ink"><?= e($nm) ?></span><span class="block text-xs text-up-muted"><?= e($t['designation'] ?? '') ?></span></span>
            </figcaption>
          </figure>
        <?php return ob_get_clean();
    };
  ?>
  <div class="relative mt-14">
    <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-gradient-to-r from-subtle to-transparent sm:w-40"></div>
    <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-gradient-to-l from-subtle to-transparent sm:w-40"></div>
    <div class="space-y-6">
      <div class="tcm-marquee group flex overflow-hidden">
        <div class="tcm-track" style="animation-duration:50s">
          <?php for ($k = 0; $k < 2; $k++) { foreach ($rowA as $t) echo $reviewCard($t); } ?>
        </div>
      </div>
      <div class="tcm-marquee group flex overflow-hidden">
        <div class="tcm-track" style="animation-duration:58s;animation-direction:reverse">
          <?php for ($k = 0; $k < 2; $k++) { foreach ($rowB as $t) echo $reviewCard($t); } ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</section>

<!-- ============ 11. TECHNOLOGY STACK ============ -->
<section data-stack class="relative overflow-hidden bg-hero-950 py-16 lg:py-24">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_60%_60%_at_50%_100%,#3a2410_0%,transparent_70%)] opacity-60"></div>
  <div class="container-x relative text-center">
    <p data-anim="fade" class="text-[0.7rem] font-bold uppercase tracking-[0.2em] text-accent-yellow">The stack you will actually touch</p>
    <h2 data-anim="words" class="mt-4 font-display text-3xl font-extrabold text-white sm:text-4xl">100+ technologies taught across our tracks</h2>
    <div class="mt-8 flex flex-wrap items-center justify-center gap-2.5">
      <button type="button" data-stack-btn="all" aria-pressed="true" class="stack-btn is-active rounded-full border px-4 py-2 text-sm font-semibold transition-colors">All</button>
      <?php foreach ($stackGroups as $g): ?>
      <button type="button" data-stack-btn="<?= e($g['id']) ?>" aria-pressed="false" class="stack-btn flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition-colors"><span class="h-2 w-2 rounded-full <?= e($g['dot']) ?>"></span><?= e($g['label']) ?></button>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="container-x relative mt-12 hidden lg:block">
    <div data-orbit-stage class="relative mx-auto aspect-[2/1] w-full max-w-5xl">
      <svg viewBox="0 0 200 100" preserveAspectRatio="none" class="absolute inset-0 h-full w-full" aria-hidden="true">
        <path data-arc="3" class="orbit-arc" d="M 7 100 A 93 93 0 0 1 193 100" fill="rgba(255,255,255,0.028)" stroke="#ffc23d" stroke-opacity="0.3" stroke-width="0.4" vector-effect="non-scaling-stroke"/>
        <path data-arc="2" class="orbit-arc" d="M 26 100 A 74 74 0 0 1 174 100" fill="rgba(255,255,255,0.028)" stroke="#ffd9bf" stroke-opacity="0.3" stroke-width="0.4" vector-effect="non-scaling-stroke"/>
        <path data-arc="1" class="orbit-arc" d="M 47 100 A 53 53 0 0 1 153 100" fill="rgba(255,255,255,0.028)" stroke="#ff6b00" stroke-opacity="0.3" stroke-width="0.4" vector-effect="non-scaling-stroke"/>
        <path data-arc="0" class="orbit-arc" d="M 70 100 A 30 30 0 0 1 130 100" fill="rgba(255,255,255,0.028)" stroke="#ff8a3d" stroke-opacity="0.3" stroke-width="0.4" vector-effect="non-scaling-stroke"/>
      </svg>
      <?php
      // Orbit field: first 5 technologies from every stack group (mirrors the
      // techcadd GSAP orbit). JS distributes them into 4 concentric rings and
      // animates them continuously along the arcs; filtering re-slots them.
      $orbitItems = [];
      foreach ($stackGroups as $g) {
          foreach (array_slice($g['chips'], 0, 5) as $ch) {
              $orbitItems[] = ['cat' => $g['id'], 'name' => $ch[0], 'mono' => $ch[1], 'color' => $ch[2], 'slug' => $ch[3] ?? ''];
          }
      }
      foreach ($orbitItems as $oi): ?>
      <span data-node="<?= e($oi['cat']) ?>" style="left:50%;top:100%" class="absolute -translate-x-1/2 -translate-y-1/2">
        <span title="<?= e($oi['name']) ?>" class="flex h-14 w-14 items-center justify-center rounded-full bg-white text-center shadow-[0_10px_30px_-8px_rgba(0,0,0,0.55)] transition-transform duration-300 hover:scale-110" style="color:<?= e($oi['color']) ?>">
          <?= $techLogo($oi['slug'], $oi['mono'], $oi['color'], $oi['name'], 'mx-auto h-7 w-7 object-contain', 'grid h-7 w-7 place-items-center rounded-[0.5rem] font-display text-[0.6rem] font-extrabold leading-none') ?>
        </span>
      </span>
      <?php endforeach; ?>
    </div>
  </div>
</section>

  <!-- ============ 12. CAPABILITIES ============ -->
<section id="capabilities" class="relative isolate flex min-h-screen items-center overflow-hidden bg-gradient-to-b from-white via-subtle to-white py-20 lg:py-0">
  <div class="pointer-events-none absolute inset-0">
    <div class="glow-blob left-[4%] top-[12%] h-[24rem] w-[24rem] bg-brand-300/45"></div>
    <div class="glow-blob right-[6%] bottom-[8%] h-[22rem] w-[22rem] bg-accent-400/35"></div>
  </div>
  <div class="pointer-events-none absolute inset-0 grid-lines-light opacity-60"></div>
  <div data-cap-root class="container-x relative w-full">
    <div data-anim="up" class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
      <div>
        <p class="text-[0.68rem] font-bold uppercase tracking-[0.22em] text-up-bright">Capabilities</p>
        <h2 class="mt-4 max-w-xl font-display text-[1.9rem] font-extrabold leading-[1.1] tracking-tight text-up-ink sm:text-4xl lg:text-[2.5rem]">Best-in-class technology, <span class="text-up-accent">taught the way it is built</span></h2>
      </div>
      <p class="max-w-sm text-[0.92rem] leading-relaxed text-up-muted lg:pb-1.5">Six tracks, one campus — the tools we train you on are the ones the industry actually ships with.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.1" class="mt-10 grid gap-6 lg:mt-12 lg:grid-cols-[minmax(0,19rem)_1fr]">
      <div class="flex flex-col gap-1.5">
        <?php foreach ($caps as $i => $c): ?>
        <button type="button" data-cap-btn <?= $i === 0 ? 'aria-current="true"' : '' ?> class="cap-rail-btn <?= $i === 0 ? 'is-active' : '' ?>">
          <span class="flex items-center gap-4">
            <span class="cap-rail-num font-mono text-[0.72rem] font-bold tabular-nums">0<?= $i + 1 ?></span>
            <span class="cap-rail-title flex-1 text-[0.95rem] font-bold"><?= e($c['title']) ?></span>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="cap-rail-arrow shrink-0"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
          </span>
        </button>
        <?php endforeach; ?>
      </div>
      <div data-cap-panel class="glass relative rounded-[1.75rem] p-6 lg:p-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
          <div>
            <p class="font-mono text-[0.72rem] font-bold tabular-nums text-up-muted/60"><span data-cap-num>01</span> / 0<?= count($caps) ?></p>
            <h3 data-cap-title class="mt-2 font-display text-[1.45rem] font-extrabold tracking-tight text-up-ink lg:text-[1.7rem]"><?= e($caps[0]['title']) ?></h3>
            <p data-cap-sub class="mt-2 max-w-lg text-[0.9rem] leading-relaxed text-up-muted"><?= e($caps[0]['sub']) ?></p>
          </div>
          <span class="rounded-full border border-up-line bg-white/70 px-3.5 py-1.5 text-[0.68rem] font-bold uppercase tracking-[0.14em] text-up-accent"><span data-cap-count><?= count($caps[0]['tools']) ?> tools</span></span>
        </div>
        <div class="my-6 h-px bg-up-line/70"></div>
        <div data-cap-tools class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4"></div>
        <a data-cap-link class="accent-fill group mt-7 inline-flex items-center gap-2 rounded-full py-2 pl-6 pr-2 text-[0.85rem] font-bold transition-all hover:-translate-y-0.5" href="<?= e($caps[0]['href']) ?>">Explore <span data-cap-link-label><?= e($caps[0]['title']) ?></span><span class="grid h-8 w-8 place-items-center rounded-full bg-hero-950/12"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"><path d="M7 17 17 7M9 7h8v8"/></svg></span></a>
      </div>
    </div>
  </div>
</section>

<!-- ============ 13. FAQS ============ -->
<section id="faqs" class="relative scroll-mt-32 overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_50%_at_25%_20%,rgba(194,65,12,0.32),transparent_68%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="grid gap-14 lg:grid-cols-[0.85fr_1.15fr] lg:gap-20">
      <div class="lg:sticky lg:top-32 lg:self-start">
        <div class="max-w-3xl">
          <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-white/15 bg-white/5 text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>FAQs</div>
          <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-white">Questions we get every week</h2>
          <div data-underline class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
          <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-soft/80">Still unsure? A ten-minute call with a counsellor usually settles it faster than any brochure.</p>
        </div>
        <div data-anim="up" data-anim-delay="0.15" class="glass-dark relative mt-8 rounded-2xl p-6">
          <p class="text-sm font-semibold text-white">Ask us directly</p>
          <div class="mt-4 space-y-2.5 text-sm">
            <a href="tel:<?= e($phoneRaw) ?>" class="flex items-center gap-2.5 text-up-soft/70 transition-colors hover:text-white"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-accent"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg><?= e($phone) ?></a>
            <a href="https://wa.me/<?= e($phoneRaw) ?>" target="_blank" rel="noreferrer" class="flex items-center gap-2.5 text-up-soft/70 transition-colors hover:text-white"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-accent"><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Zm4.6 12.4c-.2.6-1.2 1.1-1.7 1.1-.4 0-1 .1-3-.8a10.6 10.6 0 0 1-4.3-4c-.3-.5-.8-1.4-.8-2.3s.5-1.4.7-1.6a.8.8 0 0 1 .6-.3h.4c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a8 8 0 0 0 3.4 2.9c.3.1.4.1.6-.1l.7-.9c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3v.9Z"/></svg>WhatsApp <?= e($phone) ?></a>
            <a href="mailto:<?= e($email) ?>" class="flex items-center gap-2.5 text-up-soft/70 transition-colors hover:text-white"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-accent"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><?= e($email) ?></a>
          </div>
        </div>
      </div>
      <div data-anim="up" data-faq-group class="space-y-3">
        <?php foreach ($faqs as $i => $q): ?>
        <div class="tcm-faq glass-dark relative overflow-hidden rounded-2xl transition-colors duration-300<?= $i === 0 ? ' open' : '' ?>">
          <button type="button" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" class="flex w-full items-center justify-between gap-6 px-6 py-5 text-left">
            <span class="tcm-faq-q text-base font-semibold transition-colors <?= $i === 0 ? 'text-accent-glow' : 'text-white' ?>"><?= e($q[0]) ?></span>
            <span class="tcm-faq-icon grid h-8 w-8 shrink-0 place-items-center rounded-full transition-all duration-300 <?= $i === 0 ? 'bg-accent-glow text-hero-950' : 'bg-white/10 text-up-soft/70' ?>"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></span>
          </button>
          <div class="tcm-faq-body"><div><p class="px-6 pb-6 text-sm leading-relaxed text-up-soft/70"><?= e($q[1]) ?></p></div></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ 14. CTA ============ -->
<section class="relative overflow-hidden bg-subtle py-16 lg:py-24">
  <div class="pointer-events-none absolute right-[6%] top-1/2 h-16 w-16 -translate-y-1/2 rounded-full border border-up-line"></div>
  <div class="pointer-events-none absolute left-[7%] top-[22%] h-10 w-10 rounded-full border border-up-line"></div>
  <div class="container-x relative text-center">
    <p data-anim="fade" class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-bright">Ready to get started?</p>
    <h2 data-anim="up" data-anim-delay="0.08" class="mx-auto mt-5 max-w-2xl font-display text-[2.4rem] font-extrabold leading-[1.06] tracking-tight text-up-ink sm:text-5xl lg:text-[3.6rem]">Start building your career today.</h2>
    <p data-anim="up" data-anim-delay="0.16" class="mx-auto mt-6 max-w-xl text-[1.02rem] leading-relaxed text-up-muted">Talk to a counsellor today. One call is usually enough to know which track fits your degree, your schedule and the job you want.</p>
    <div data-anim="up" data-anim-delay="0.24" class="mt-10 flex justify-center">
      <form id="tcmCtaForm" class="w-full" onsubmit="return false;">
        <div class="mx-auto flex w-full max-w-xl flex-col items-stretch gap-3 sm:flex-row">
          <label for="cta-phone" class="sr-only">Your mobile number</label>
          <input id="cta-phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Your mobile number" class="min-w-0 flex-1 rounded-full border border-up-line bg-white px-6 py-4 text-[0.95rem] text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent" value="">
          <button type="submit" class="accent-fill shrink-0 rounded-full px-8 py-4 text-[0.9rem] font-bold transition-all hover:-translate-y-0.5">Book Demo</button>
        </div>
      </form>
    </div>
    <a data-anim="up" data-anim-delay="0.3" href="tel:<?= e($phoneRaw) ?>" class="group mt-8 inline-flex items-center gap-3.5 rounded-full bg-hero-600 py-3 pl-3 pr-7 text-left text-white shadow-[0_18px_45px_-16px_rgba(194,65,12,0.85)] transition-all hover:-translate-y-0.5 hover:bg-hero-glow">
      <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-white/20"><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg></span>
      <span class="leading-tight"><span class="block text-[0.62rem] font-bold uppercase tracking-[0.16em] text-white/70">Call now</span><span class="block text-[1.05rem] font-extrabold"><?= e($phone) ?></span></span>
    </a>
    <ul data-anim="fade" data-anim-delay="0.36" class="mt-12 mb-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-4 text-[0.95rem] text-up-muted">
      <?php foreach (['Free career counselling', 'No registration fee', 'Placement support included'] as $li): ?>
      <li class="flex items-center"><span class="inline-flex items-center gap-2"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0 text-up-bright"><circle cx="12" cy="12" r="9"/><path d="m8.4 12.2 2.5 2.5 4.7-5.2"/></svg><?= e($li) ?></span></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

</main>
 <script>
  document.addEventListener('DOMContentLoaded', function () {
    var f = document.getElementById('tcmCtaForm');
    if (!f) return;
    f.addEventListener('submit', function () {
      var p = document.getElementById('cta-phone');
      if (p && p.value && p.value.trim().length >= 10) {
        if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
      }
    });
  });
</script>
<?php
$__popupAuto = true;
require __DIR__ . '/includes/footer.php';
