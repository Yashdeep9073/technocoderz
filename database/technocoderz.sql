-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260913.70d713dc39
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 19, 2026 at 08:26 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `technocoderz`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--
CREATE TABLE `blogs` (
  `id` int NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Techno Coderz',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `views` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `author`, `category`, `tags`, `status`, `views`, `created_at`) VALUES
(1, 'Top 10 Programming Languages to Learn in 2025', 'top-10-programming-languages-2025', 'Discover which programming languages are most in-demand in 2025 and which ones can boost your career the most.', NULL, NULL, 'Techno Coderz Team', 'Career', 'programming,career,2025', 1, 52, '2026-10-06 08:14:07'),
(2, 'Why PHP is Still Relevant for Web Development', 'why-php-still-relevant-2025', 'Despite newer frameworks, PHP powers over 75% of websites. Here is why learning PHP is still one of the best decisions for a web dev career.', NULL, NULL, 'Techno Coderz Team', 'Web Development', 'php,web development,backend', 1, 4, '2026-10-06 08:14:07'),
(3, 'Bootstrap 5 vs Tailwind CSS: Which Should You Learn First?', 'bootstrap-5-vs-tailwind-css', 'A detailed comparison of Bootstrap 5 and Tailwind CSS for beginners ÔÇö features, learning curve, job demand, and best use cases.', NULL, NULL, 'Techno Coderz Team', 'Frontend', 'bootstrap,tailwind,css,frontend', 1, 2, '2026-10-06 08:14:07'),
(4, 'Understanding MySQL Joins: A Complete Beginner Guide', 'mysql-joins-beginner-guide', 'INNER JOIN, LEFT JOIN, RIGHT JOIN, FULL JOIN ÔÇö explained with practical examples and SQL queries you can run right away.', NULL, NULL, 'Techno Coderz Team', 'Database', 'mysql,database,sql,joins', 1, 2, '2026-10-06 08:14:07'),
(5, 'How to Build Your First PHP CRUD Application', 'build-php-crud-application', 'Step-by-step tutorial to build a Create, Read, Update, Delete application using Core PHP, MySQL and Bootstrap 5.', NULL, NULL, 'Techno Coderz Team', 'Tutorial', 'php,mysql,crud,tutorial', 1, 5, '2026-10-06 08:14:07'),
(6, 'JavaScript ES6 Features Every Developer Must Know', 'javascript-es6-features', 'Arrow functions, destructuring, template literals, spread/rest operators, async/await ÔÇö master ES6 to write modern JS.', NULL, NULL, 'Techno Coderz Team', 'JavaScript', 'javascript,es6,frontend', 1, 3, '2026-10-06 08:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--
CREATE TABLE `certificates` (
  `id` int UNSIGNED NOT NULL,
  `cert_no` varchar(60) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `course_title` varchar(200) NOT NULL,
  `course_slug` varchar(220) DEFAULT NULL,
  `issue_date` date NOT NULL,
  `grade` varchar(40) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `cert_no`, `student_name`, `course_title`, `course_slug`, `issue_date`, `grade`, `duration`, `status`, `created_at`) VALUES
(1, 'TC-2025-0001', 'Aarav Sharma', 'Artificial Intelligence, Machine Learning & Data Science', 'artificial-intelligence-machine-learning-data-science', '2026-10-07', 'A+', '6 Months', 1, '2026-10-16 05:41:06'),
(2, 'TC-2025-0002', 'Simran Kaur', 'Full Stack Development (MERN & MEAN Stack)', 'full-stack-development-mern-mean-stack', '2026-09-28', 'A', '6 Months', 1, '2026-10-16 05:41:06'),
(3, 'TC-2025-0003', 'Rohit Verma', 'DevSecOps / Cyber Security', 'devsecops-cyber-security', '2026-09-19', 'A', '3 to 6 Months', 1, '2026-10-16 05:41:06'),
(4, 'TC-2025-0004', 'Neha Gupta', 'DevOps | CI/CD', 'devops-ci-cd', '2026-09-10', 'B+', '3 Months', 1, '2026-10-16 05:41:06'),
(5, 'TC-2025-0005', 'Karan Singh', 'Python Course', 'python-course', '2026-09-01', 'A', '3 Months', 1, '2026-10-16 05:41:06'),
(6, 'TC-2025-0006', 'Priya Nair', 'Java Course', 'java-course', '2026-08-23', 'A+', '3 Months', 1, '2026-10-16 05:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--
CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--
CREATE TABLE `courses` (
  `id` int NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `duration` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lessons` int UNSIGNED NOT NULL DEFAULT '0',
  `level` enum('Beginner','Intermediate','Advanced','All Levels') COLLATE utf8mb4_unicode_ci DEFAULT 'Beginner',
  `category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Software Development',
  `price` decimal(10,2) DEFAULT '0.00',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technologies` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `highlights` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `short_description`, `description`, `duration`, `lessons`, `level`, `category`, `price`, `image`, `icon`, `technologies`, `highlights`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Full Stack Web Development', 'full-stack-web-development', 'Master both frontend and backend web development with HTML, CSS, JS, PHP and MySQL.', 'A comprehensive program covering HTML5, CSS3, JavaScript, Bootstrap, PHP OOP, MySQL, and deployment. You will build real-world projects.', '6 Months', 0, 'Beginner', 'Software Development', 0.00, NULL, 'bi bi-layers-fill', '', '', 0, 1, '2026-10-06 08:14:07'),
(2, 'Core Java Development', 'core-java-development', 'Build a strong foundation in Java programming with OOP concepts, collections and projects.', 'Learn Core Java from scratch ÔÇö data types, loops, OOP, inheritance, interfaces, exception handling, collections, and project work.', '3 Months', 0, 'Beginner', 'Software Development', 0.00, NULL, 'bi bi-cup-hot-fill', '', '', 0, 2, '2026-10-06 08:14:07'),
(3, 'PHP & MySQL', 'php-mysql', 'Learn server-side web development with PHP and MySQL databases using real projects.', 'Covers PHP fundamentals, OOP, form handling, sessions, CRUD operations with MySQL, and security best practices.', '2 Months', 0, 'Beginner', 'Software Development', 0.00, NULL, 'bi bi-database-fill', '', '', 0, 3, '2026-10-06 08:14:07'),
(4, 'PHP & Laravel Framework', 'php-laravel', 'Go beyond Core PHP and master the powerful Laravel framework for rapid application development.', 'MVC architecture, Eloquent ORM, Blade templating, middleware, authentication, REST APIs, and deployment.', '3 Months', 0, 'Intermediate', 'Software Development', 0.00, NULL, 'bi bi-box-fill', '', '', 0, 4, '2026-10-06 08:14:07'),
(5, 'Frontend Development', 'frontend-development', 'Create stunning, responsive websites using HTML5, CSS3, JavaScript and Bootstrap 5.', 'Covers semantic HTML, Flexbox, CSS Grid, animations, Bootstrap components, JavaScript DOM, AJAX and modern UX.', '2 Months', 0, 'Beginner', 'Software Development', 0.00, NULL, 'bi bi-palette-fill', '', '', 0, 5, '2026-10-06 08:14:07'),
(6, 'JavaScript Mastery', 'javascript-mastery', 'From fundamentals to advanced JS concepts including ES6+, async programming and DOM.', 'Variables, functions, closures, promises, async/await, fetch API, modules, OOP in JS, and practical projects.', '2 Months', 0, 'Intermediate', 'Software Development', 0.00, NULL, 'bi bi-lightning-fill', '', '', 0, 6, '2026-10-06 08:14:07'),
(7, 'React Basics & Beyond', 'react-basics', 'Learn modern frontend development with React ÔÇö components, hooks, state management and APIs.', 'JSX, components, props, state, hooks (useState, useEffect), React Router, API integration, and building SPAs.', '2 Months', 0, 'Intermediate', 'Software Development', 0.00, NULL, 'bi bi-arrow-repeat', '', '', 0, 7, '2026-10-06 08:14:07'),
(8, 'MySQL & Database Design', 'mysql-database-design', 'Master relational database design, SQL queries, optimization and integration with PHP.', 'Database concepts, ER diagrams, normalization, SQL DML/DDL, joins, subqueries, stored procedures, indexing.', '1.5 Months', 0, 'Beginner', 'Software Development', 0.00, NULL, 'bi bi-server', '', '', 0, 8, '2026-10-06 08:14:07'),
(13, 'Artificial Intelligence, Machine Learning & Data Science', 'artificial-intelligence-machine-learning-data-science', 'Master AI, ML and Data Science with Python, deep learning, NLP and generative AI through 130+ industry-led lessons.', 'Module 1 — Python Programming for Data Science\nModule 2 — Statistics, Mathematics & Exploratory Data Analysis\nModule 3 — Data Analysis with NumPy & Pandas\nModule 4 — Data Visualization with Matplotlib, Seaborn & Power BI\nModule 5 — Machine Learning Algorithms & Model Deployment\nModule 6 — Deep Learning, Neural Networks & Computer Vision\nModule 7 — NLP & Generative AI Applications\nModule 8 — Capstone: End-to-End AI/ML Projects', '6 Months', 130, 'All Levels', 'Data Science', 0.00, 'ai-ml-data-science.jpg', 'bi bi-robot', 'Python,NumPy & Pandas,TensorFlow,Scikit-learn,SQL,Power BI', 'Hands-on Learning,Real-World Projects,1-on-1 Mentorship,Placement Assistance', 1, 1, '2026-10-08 07:10:15'),
(14, 'Full Stack Development (MERN & MEAN Stack)', 'full-stack-development-mern-mean-stack', 'Build complete web applications with MongoDB, Express, React, Node.js and Angular across 120+ hands-on lessons.', 'Module 1 — HTML5, CSS3, Tailwind CSS & Responsive UI\nModule 2 — JavaScript & TypeScript Fundamentals\nModule 3 — React.js: Hooks, Routing & State Management\nModule 4 — Node.js, Express.js & REST API Development\nModule 5 — MongoDB, Mongoose & Database Modeling\nModule 6 — Angular Framework & MEAN Stack Integration\nModule 7 — Authentication, Testing, Deployment & DevOps Basics\nModule 8 — Capstone: Production-Ready Full Stack Projects', '6 Months', 120, 'All Levels', 'Software Development', 0.00, 'full-stack-development.jpg', 'bi bi-code-slash', 'HTML & CSS,JavaScript,React,Node.js,MongoDB,Angular', 'Hands-on Learning,Real-World Projects,1-on-1 Mentorship,Placement Assistance', 1, 2, '2026-10-08 07:10:15'),
(15, 'DevSecOps / Cyber Security', 'devsecops-cyber-security', 'Learn ethical hacking, cloud security and secure CI/CD pipelines with 90+ practical lessons and live labs.', 'Module 1 — Networking & Linux Fundamentals\nModule 2 — Ethical Hacking, Reconnaissance & Footprinting\nModule 3 — Web Application Security (OWASP Top 10)\nModule 4 — Network Security, Vulnerability Assessment & Penetration Testing\nModule 5 — Cloud Security, IAM & Hardening\nModule 6 — DevSecOps: Shifting Security into CI/CD\nModule 7 — SOC Operations, Incident Response & Compliance\nModule 8 — Capstone: Security Assessment & Automation Project', '3 to 6 Months', 90, 'All Levels', 'Cyber Security', 0.00, 'devsecops-cyber-security.jpg', 'bi bi-shield-shaded', 'Kali Linux,Burp Suite,Wireshark,AWS,Docker,Jenkins', 'Hands-on Learning,Real-World Projects,1-on-1 Mentorship,Placement Assistance', 1, 3, '2026-10-08 07:10:15'),
(16, 'DevOps | CI/CD', 'devops-ci-cd', 'Automate delivery with Git, Docker, Kubernetes, Jenkins and Terraform in a focused 3-month, project-driven program.', 'Module 1 — Linux & Networking Foundations\nModule 2 — Version Control with Git & GitHub\nModule 3 — CI/CD Pipelines with Jenkins & GitHub Actions\nModule 4 — Docker & Containerization\nModule 5 — Kubernetes Orchestration & Scaling\nModule 6 — Infrastructure as Code with Terraform & Ansible\nModule 7 — Cloud Deployment (AWS) & Monitoring with Prometheus/Grafana\nModule 8 — Capstone: Production-Grade Delivery Pipeline', '3 Months', 80, 'All Levels', 'Software Development', 0.00, 'devops-cicd.svg', 'bi bi-gear-wide-connected', 'Git,Docker,Kubernetes,Jenkins,Terraform,AWS', 'Hands-on Learning,2-Month & 6-Month Programs,Real-World Projects,Placement Assistance', 1, 4, '2026-10-08 07:10:15'),
(17, 'Python Course', 'python-course', 'Master Python from core fundamentals to advanced development with hands-on projects, automation and web apps.', 'Python Basics & Setup\nData Types & Operators\nControl Flow & Loops\nFunctions & Modules\nObject Oriented Programming\nFile Handling & Exceptions\nWorking with Libraries (NumPy, Pandas)\nWeb Development with Django/Flask\nREST APIs & Databases\nCapstone Project', '3 Months', 60, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-filetype-py', 'Python, OOP, Django, Flask', 'Live Projects, Expert Trainers, Placement Support', 1, 9, '2026-10-15 07:24:59'),
(18, 'Java Course', 'java-course', 'Learn Core Java, OOP, collections, JDBC and Spring Boot to build enterprise-grade applications.', 'Java Basics\nOOP Concepts\nCollections & Generics\nException Handling\nMultithreading\nJDBC & Databases\nSpring Boot Basics\nREST APIs\nMini Projects', '3 Months', 65, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-cup-hot', 'Core Java, OOP, JDBC, Spring Boot', 'Live Projects, Expert Trainers, Interview Prep', 1, 10, '2026-10-15 07:24:59'),
(19, 'C Course', 'c-course', 'Build rock-solid programming fundamentals with C — the ideal starting point for every developer.', 'Introduction to C\nOperators & Expressions\nControl Statements\nFunctions\nArrays & Strings\nPointers\nStructures & Unions\nFile Handling\nData Structures Basics', '2 Months', 45, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-braces', 'C, Pointers, Data Structures', 'Strong Fundamentals, Logic Building, Practice Sets', 1, 11, '2026-10-15 07:24:59'),
(20, 'Kotlin Course', 'kotlin-course', 'Build modern Android apps with Kotlin — null safety, coroutines, Jetpack and clean architecture.', 'Kotlin Basics\nOOP in Kotlin\nNull Safety\nCollections\nCoroutines\nAndroid UI\nJetpack Components\nNetworking\nApp Project', '2 Months', 45, 'Intermediate', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-code-slash', 'Kotlin, Android, Coroutines', 'Android Apps, Live Projects, Expert Mentors', 1, 12, '2026-10-15 07:24:59'),
(21, 'Web Designing Course', 'web-designing-course', 'Design beautiful, responsive websites using HTML5, CSS3, Bootstrap and modern UI principles.', 'HTML5 Structure\nCSS3 Styling\nFlexbox & Grid\nBootstrap 5\nResponsive Design\nJavaScript Basics\nAnimations\nLanding Page Project', '2 Months', 40, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-palette', 'HTML5, CSS3, Bootstrap, JavaScript', 'Responsive Layouts, Real Templates, Portfolio', 1, 13, '2026-10-15 07:24:59'),
(22, 'Web Development Course', 'web-development-course', 'Go from static pages to dynamic, database-driven websites with front-end and back-end skills.', 'Front-End Basics\nJavaScript Essentials\nPHP Fundamentals\nMySQL Databases\nCRUD Applications\nAuthentication\nSessions & Cookies\nDeployment\nLive Project', '3 Months', 70, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-code-square', 'HTML, CSS, JavaScript, PHP, MySQL', 'Full Websites, Databases, Hosting', 1, 14, '2026-10-15 07:24:59'),
(23, 'Mern Stack Course', 'mern-stack-course', 'Become a full-stack JavaScript developer with MongoDB, Express, React and Node.js.', 'JavaScript ES6+\nNode.js & npm\nExpress.js\nMongoDB & Mongoose\nReact Fundamentals\nHooks & Routing\nREST APIs\nAuthentication\nDeployment\nCapstone Project', '4 Months', 90, 'Intermediate', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-stack', 'MongoDB, Express, React, Node.js', 'Full Stack Apps, GitHub, Placement Support', 1, 15, '2026-10-15 07:24:59'),
(24, 'Mean Stack Course', 'mean-stack-course', 'Build scalable enterprise applications with MongoDB, Express, Angular and Node.js.', 'TypeScript\nNode.js & Express\nMongoDB\nAngular Basics\nComponents & Services\nRouting & Forms\nREST Integration\nState Management\nDeployment\nCapstone Project', '4 Months', 90, 'Intermediate', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-stack', 'MongoDB, Express, Angular, Node.js', 'Enterprise Apps, TypeScript, Placement Support', 1, 16, '2026-10-15 07:24:59'),
(25, 'Php full Stack Course', 'php-full-stack-course', 'Master PHP full-stack development — from core PHP and MySQL to Laravel and modern front-end.', 'PHP Basics\nArrays & Functions\nMySQL & PDO\nOOP in PHP\nMVC Pattern\nLaravel Framework\nREST APIs\nAuthentication\nDeployment\nLive Project', '3 Months', 80, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-server', 'PHP, MySQL, Laravel, JavaScript', 'Live Projects, CMS, Placement Support', 1, 17, '2026-10-15 07:24:59'),
(26, 'Digital Marketing Course', 'digital-marketing-course', 'Learn complete digital marketing — SEO, paid ads, social media, content and analytics with live campaigns.', 'Digital Marketing Overview\nSEO On-Page & Off-Page\nGoogle Ads\nSocial Media Marketing\nContent Marketing\nEmail Marketing\nGoogle Analytics\nLive Campaign Project', '3 Months', 55, 'Beginner', 'Digital Marketing', 0.00, NULL, 'bi bi-megaphone', 'SEO, Google Ads, Social Media, Analytics', 'Live Campaigns, Certifications, Placement Support', 1, 18, '2026-10-15 07:24:59'),
(27, 'Social Media Marketing course', 'social-media-marketing-course', 'Grow brands on Facebook, Instagram, LinkedIn and YouTube with proven content and ad strategies.', 'SMM Fundamentals\nFacebook & Instagram Ads\nContent Calendar\nReels & Creatives\nLinkedIn Marketing\nCommunity Building\nAnalytics\nCampaign Project', '2 Months', 40, 'Beginner', 'Digital Marketing', 0.00, NULL, 'bi bi-share', 'Facebook, Instagram, LinkedIn, Content', 'Content Strategy, Ads Manager, Live Pages', 1, 19, '2026-10-15 07:24:59'),
(28, 'Google Ads course', 'google-ads-course', 'Run profitable Google Ads campaigns across Search, Display, Shopping and YouTube.', 'Google Ads Basics\nKeyword Research\nSearch Campaigns\nDisplay & YouTube\nShopping Ads\nBidding Strategies\nConversion Tracking\nOptimisation', '1.5 Months', 30, 'Intermediate', 'Digital Marketing', 0.00, NULL, 'bi bi-google', 'Search Ads, Display, Shopping, YouTube', 'Real Ad Accounts, Bidding, Certifications', 1, 20, '2026-10-15 07:24:59'),
(29, 'WordPress course', 'wordpress-course', 'Build professional websites and online stores with WordPress, Elementor and WooCommerce.', 'WordPress Setup\nThemes & Customisation\nElementor Page Builder\nPlugins\nWooCommerce Stores\nOn-Page SEO\nSecurity & Speed\nLive Website', '2 Months', 35, 'Beginner', 'Digital Marketing', 0.00, NULL, 'bi bi-wordpress', 'WordPress, Elementor, WooCommerce', 'Live Websites, Themes, SEO Ready', 1, 21, '2026-10-15 07:24:59'),
(30, 'Shopify course', 'shopify-course', 'Launch and scale e-commerce stores with Shopify — from product research to paid traffic.', 'Shopify Basics\nStore Design\nProduct Research\nPayments & Shipping\nApps & Automation\nDropshipping\nMarketing Integration\nLive Store Project', '2 Months', 35, 'Beginner', 'Digital Marketing', 0.00, NULL, 'bi bi-bag', 'Shopify, Dropshipping, Store Design', 'Live Store Setup, Product Research, Apps', 1, 22, '2026-10-15 07:24:59'),
(31, 'Search Engine Optimization course', 'search-engine-optimization-course', 'Rank websites on Google with on-page, off-page and technical SEO plus keyword research.', 'SEO Fundamentals\nKeyword Research\nOn-Page SEO\nOff-Page & Backlinks\nTechnical SEO\nLocal SEO\nSEO Tools\nLive Ranking Project', '2 Months', 40, 'Beginner', 'Digital Marketing', 0.00, NULL, 'bi bi-graph-up-arrow', 'SEO, Keyword Research, Link Building', 'Ranking Projects, Tools, Certifications', 1, 23, '2026-10-15 07:24:59'),
(32, 'Power Bi course', 'power-bi-course', 'Turn raw data into interactive business dashboards using Power BI and DAX.', 'Power BI Basics\nData Import & Cleanup\nData Modelling\nDAX\nVisualisations\nInteractive Dashboards\nPublishing\nCapstone Dashboard', '1.5 Months', 30, 'Beginner', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-bar-chart-line', 'Power BI, DAX, Data Modelling', 'Dashboards, Real Datasets, Certifications', 1, 24, '2026-10-15 07:24:59'),
(33, 'Tableau course', 'tableau-course', 'Create stunning, interactive data visualisations and dashboards with Tableau.', 'Tableau Basics\nConnecting Data\nCharts & Graphs\nCalculated Fields\nFilters & Parameters\nDashboards & Stories\nPublishing\nCapstone Project', '1.5 Months', 30, 'Beginner', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-bar-chart-steps', 'Tableau, Visual Analytics, Storytelling', 'Interactive Dashboards, Real Data, Certifications', 1, 25, '2026-10-15 07:24:59'),
(34, 'Data Science Course', 'data-science-course', 'Become a data scientist — statistics, Python, data wrangling and machine learning with real datasets.', 'Python for Data Science\nStatistics & Probability\nNumPy & Pandas\nData Visualisation\nSQL for Analytics\nMachine Learning\nModel Evaluation\nCapstone Project', '4 Months', 85, 'Intermediate', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-database', 'Python, Pandas, NumPy, Scikit-learn, SQL', 'Real Datasets, ML Projects, Placement Support', 1, 26, '2026-10-15 07:24:59'),
(35, 'Data Analytics Course', 'data-analytics-course', 'Analyse business data with Excel, SQL, Python and Power BI to drive real decisions.', 'Analytics Fundamentals\nAdvanced Excel\nSQL for Analytics\nPython for Analysis\nData Visualisation\nPower BI Dashboards\nBusiness Cases\nCapstone Project', '3 Months', 60, 'Beginner', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-graph-up', 'Excel, SQL, Python, Power BI', 'Dashboards, Business Insights, Placement Support', 1, 27, '2026-10-15 07:24:59'),
(36, 'Machine Learning Course', 'machine-learning-course', 'Build and deploy machine learning models covering regression, classification and clustering.', 'ML Fundamentals\nPython Libraries\nRegression\nClassification\nClustering\nModel Evaluation\nFeature Engineering\nDeployment\nCapstone Project', '3 Months', 70, 'Intermediate', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-cpu', 'Python, Scikit-learn, Regression, Classification', 'Hands-on Models, Real Datasets, Placement Support', 1, 28, '2026-10-15 07:24:59'),
(37, 'Deep Learning Course', 'deep-learning-course', 'Master neural networks with TensorFlow and Keras — CNNs, RNNs and modern deep learning.', 'Deep Learning Basics\nNeural Networks\nTensorFlow & Keras\nCNN\nRNN & LSTM\nTransfer Learning\nModel Tuning\nDeployment\nCapstone Project', '3 Months', 70, 'Advanced', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-diagram-3', 'TensorFlow, Keras, CNN, RNN', 'Neural Networks, Real Datasets, Placement Support', 1, 29, '2026-10-15 07:24:59'),
(38, 'Artificial Intelligence Course', 'artificial-intelligence-course', 'Go from AI fundamentals to Generative AI, NLP and computer vision with real-world projects.', 'AI Fundamentals\nMachine Learning\nDeep Learning\nNLP\nComputer Vision\nGenerative AI & LLMs\nPrompt Engineering\nAI Project Deployment\nCapstone Project', '4 Months', 90, 'Advanced', 'AI Courses', 0.00, 'ai-ml-data-science.jpg', 'bi bi-robot', 'Python, ML, Deep Learning, NLP, GenAI', 'AI Projects, GenAI Tools, Placement Support', 1, 30, '2026-10-15 07:24:59'),
(39, 'Cyber Security Course', 'cyber-security-course', 'Defend systems and networks with hands-on cyber security, threat detection and security operations.', 'Security Fundamentals\nNetworking Basics\nLinux & Windows Security\nCryptography\nWeb Security\nSIEM & Monitoring\nIncident Response\nCapstone Lab', '4 Months', 80, 'Intermediate', 'Cyber Courses', 0.00, 'devsecops-cyber-security.jpg', 'bi bi-shield-lock', 'Networking, Security, SIEM, Kali Linux', 'Live Labs, Certifications, Placement Support', 1, 31, '2026-10-15 07:24:59'),
(40, 'Cloud Computing Course', 'cloud-computing-course', 'Design and deploy scalable cloud solutions on AWS and Azure with Docker and Kubernetes.', 'Cloud Fundamentals\nAWS Core Services\nAzure Basics\nVirtual Networking\nDocker\nKubernetes\nCI/CD on Cloud\nCapstone Project', '3 Months', 60, 'Intermediate', 'Cyber Courses', 0.00, 'devops-cicd.svg', 'bi bi-cloud', 'AWS, Azure, Docker, Kubernetes', 'Cloud Labs, Certifications, Placement Support', 1, 32, '2026-10-15 07:24:59'),
(41, 'Linux Course', 'linux-course', 'Master the Linux command line, shell scripting and system administration for real-world servers.', 'Linux Basics\nFile System & Permissions\nUsers & Groups\nPackage Management\nShell Scripting\nProcess Management\nNetworking\nServer Administration', '2 Months', 45, 'Beginner', 'Cyber Courses', 0.00, 'devops-cicd.svg', 'bi bi-terminal', 'Linux, Shell Scripting, Administration', 'Live Servers, Shell Scripting, Certifications', 1, 33, '2026-10-15 07:24:59'),
(42, 'Ethical Hacking Course', 'ethical-hacking-course', 'Learn ethical hacking and penetration testing with Kali Linux, Burp Suite and Metasploit.', 'Ethical Hacking Basics\nReconnaissance\nScanning & Enumeration\nVulnerability Analysis\nWeb App Hacking\nSystem Hacking\nMetasploit & Burp Suite\nReporting\nCapstone Lab', '3 Months', 65, 'Intermediate', 'Cyber Courses', 0.00, 'devsecops-cyber-security.jpg', 'bi bi-bug', 'Kali Linux, Pen Testing, Burp Suite, Metasploit', 'Live CTFs, Real Labs, Certifications', 1, 34, '2026-10-15 07:24:59'),
(43, 'C++ Course', 'cpp-course', 'Master C++ with object-oriented programming, STL and data structures for competitive programming.', 'C++ Basics\nClasses & Objects\nInheritance & Polymorphism\nTemplates\nSTL\nPointers & References\nFile I/O\nDSA with C++\nProjects', '2 Months', 50, 'Beginner', 'Programming', 0.00, 'full-stack-development.jpg', 'bi bi-braces-asterisk', 'C++, OOP, STL, DSA', 'OOP Mastery, DSA Foundation, Live Coding', 1, 35, '2026-10-15 07:25:34'),
(44, 'Advanced Certificate in Digital Marketing and Communication', 'advanced-certificate-in-digital-marketing-and-communication', 'After 12th 6 Months certificate in Digital Marketing with live campaigns.', 'Digital Marketing Basics\nSEO\nGoogle Ads\nSocial Media\nAnalytics\nLive Campaign\nProject', '6 Months', 70, 'Beginner', 'After 12th - 6 Months', 0.00, NULL, 'bi bi-megaphone', 'SEO, Google Ads, SMM, Analytics', 'After 12th 6 Months certificate in Digital Marketing with live campaigns.', 1, 36, '2026-10-15 07:40:34'),
(45, 'Professional Certificate Python Programming Course', 'professional-certificate-python-programming-course', 'After 12th Python 6 Months professional certificate for career in software.', 'Python Basics\nOOP\nLibraries\nFile Handling\nWeb Apps\nProjects', '6 Months', 70, 'Beginner', 'After 12th - 6 Months', 0.00, 'full-stack-development.jpg', 'bi bi-filetype-py', 'Python, Django/Flask', 'After 12th Python 6 Months professional certificate for career in software.', 1, 37, '2026-10-15 07:40:34'),
(46, 'Certificate Course Program in ML & AI', 'certificate-course-program-in-ml-ai', 'After 12th ML & AI 6 Months certificate with hands-on projects.', 'Python Basics\nML Basics\nClassification\nRegression\nClustering\nProjects', '6 Months', 70, 'Beginner', 'After 12th - 6 Months', 0.00, 'ai-ml-data-science.jpg', 'bi bi-cpu', 'Python, Scikit-learn, ML', 'After 12th ML & AI 6 Months certificate with hands-on projects.', 1, 38, '2026-10-15 07:40:34'),
(47, 'Certificate course in cybersecurity', 'certificate-course-in-cyber-security', 'After 12th Cyber Security 6 Months certificate with practical labs.', 'Networking\nSecurity Basics\nLinux Security\nCryptography\nLab Work', '6 Months', 70, 'Beginner', 'After 12th - 6 Months', 0.00, 'devsecops-cyber-security.jpg', 'bi bi-shield-lock', 'Networking, Security, Linux', 'After 12th Cyber Security 6 Months certificate with practical labs.', 1, 39, '2026-10-15 07:40:34'),
(48, 'Advanced Certificate Program in Generative AI', 'advance-certificate-programme-in-generative-ai', 'After 12th 1 Year GenAI programme with real projects.', 'AI Fundamentals\nDeep Learning\nNLP\nGenAI\nLLMs\nProjects', '1 Year', 110, 'Intermediate', 'After 12th - 1 Year', 0.00, 'ai-ml-data-science.jpg', 'bi bi-robot', 'Python, TensorFlow/Keras, GenAI', 'After 12th 1 Year GenAI programme with real projects.', 1, 40, '2026-10-15 07:40:34'),
(49, 'Professional Certificate Program in Cloud Computing and DevOps', 'professional-certificate-program-in-cloud-computing-and-devops', 'After 12th 1 Year Cloud & DevOps programme with live labs.', 'Cloud Basics\nAWS\nDocker\nKubernetes\nCI/CD\nProjects', '1 Year', 110, 'Intermediate', 'After 12th - 1 Year', 0.00, 'devops-cicd.svg', 'bi bi-cloud', 'AWS, Docker, Kubernetes, CI/CD', 'After 12th 1 Year Cloud & DevOps programme with live labs.', 1, 41, '2026-10-15 07:40:34'),
(50, 'Advanced Certificate in Artificial Intelligence and Data Science', 'advance-certificate-course-in-artificial-intelligence-and-data-science', 'After 12th 1 Year AI & Data Science advanced certificate.', 'Python\nStats\nML\nDL\nData Analysis\nProjects', '1 Year', 110, 'Intermediate', 'After 12th - 1 Year', 0.00, 'ai-ml-data-science.jpg', 'bi bi-database', 'Python, ML, DL, Analytics', 'After 12th 1 Year AI & Data Science advanced certificate.', 1, 42, '2026-10-15 07:40:34'),
(51, 'Certificate Course in Machine Learning and Deep Learning', 'certificate-course-in-machine-learning-and-deep-learning', 'After 12th 1 Year ML & Deep Learning certificate with hands-on work.', 'ML\nDL\nTensorFlow\nCNN\nRNN\nProjects', '1 Year', 100, 'Intermediate', 'After 12th - 1 Year', 0.00, 'ai-ml-data-science.jpg', 'bi bi-cpu', 'Scikit-learn, TensorFlow, Keras', 'After 12th 1 Year ML & Deep Learning certificate with hands-on work.', 1, 43, '2026-10-15 07:40:34'),
(52, 'Advanced program in cybersecurity and ethical hacking', 'advanced-program-in-cybersecurity-and-ethical-hacking', 'After 12th 1 Year advanced cybersecurity & ethical hacking.', 'Networking\nEthical Hacking\nSIEM\nPentesting\nLabs\nProjects', '1 Year', 110, 'Intermediate', 'After 12th - 1 Year', 0.00, 'devsecops-cyber-security.jpg', 'bi bi-shield-lock', 'Kali Linux, Metasploit, Burp Suite', 'After 12th 1 Year advanced cybersecurity & ethical hacking.', 1, 44, '2026-10-15 07:40:34'),
(53, 'AutoCad', 'best-autocad-course-in-mohali', 'After 12th AutoCAD course for Civil/Arch/Mechanical students.', '2D Drawings\nModelling\nAnnotations\nLayouts\nProjects', '3 Months', 40, 'Beginner', 'After 12th - Civil / Architecture / Mechanical', 0.00, NULL, 'bi bi-pencil-square', 'AutoCAD 2D/3D', 'After 12th AutoCAD course for Civil/Arch/Mechanical students.', 1, 45, '2026-10-15 07:40:34'),
(54, 'Solid Works', 'best-solid-works-course-in-mohali', 'After 12th SolidWorks course with practical modelling.', 'Sketching\nPart Modelling\nAssemblies\nDrawings\nProjects', '3 Months', 40, 'Beginner', 'After 12th - Civil / Architecture / Mechanical', 0.00, NULL, 'bi bi-box', 'SolidWorks', 'After 12th SolidWorks course with practical modelling.', 1, 46, '2026-10-15 07:40:34'),
(55, '3Ds Max', 'best-3d-s-max-course-in-mohali', 'After 12th 3Ds Max for architecture and interior design.', 'Modelling\nTexturing\nLighting\nRendering\nProjects', '3 Months', 40, 'Beginner', 'After 12th - Civil / Architecture / Mechanical', 0.00, NULL, 'bi bi-box-seam', '3Ds Max', 'After 12th 3Ds Max for architecture and interior design.', 1, 47, '2026-10-15 07:40:34'),
(56, 'Revit', 'best-revit-course-in-mohali', 'After 12th Revit BIM course for Civil/Architecture students.', 'BIM Basics\nWalls/Doors/Windows\nStructural\nSheets\nProjects', '3 Months', 40, 'Beginner', 'After 12th - Civil / Architecture / Mechanical', 0.00, NULL, 'bi bi-buildings', 'Autodesk Revit', 'After 12th Revit BIM course for Civil/Architecture students.', 1, 48, '2026-10-15 07:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--
CREATE TABLE `enquiries` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('new','in_progress','resolved') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `email`, `phone`, `course`, `message`, `status`, `created_at`) VALUES
(10, 'Balwinder Kaur', 'balwinderghangas99@gmail.com', '7528996242', 'Full Stack Development (MERN & MEAN Stack)', 'Brochure / curriculum PDF downloaded from brochure.php', 'new', '2026-10-09 16:15:46'),
(11, 'Balwinder Kaur', 'balwinderghangas99@gmail.com', '7528996242', 'Artificial Intelligence, Machine Learning & Data Science', '', 'new', '2026-10-09 16:16:51'),
(12, 'Test User', 'brochuretest+1243833180@example.com', '9876543210', 'Full Stack MERN & MEAN', 'Brochure / curriculum PDF downloaded from brochure.php', 'new', '2026-10-13 04:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--
CREATE TABLE `projects` (
  `id` int NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `technology` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `technology`, `image`, `project_url`, `status`, `sort_order`, `created_at`) VALUES
(1, 'EduTrack LMS', 'A full-featured Learning Management System with student enrollment, progress tracking, and admin dashboards.', 'PHP, MySQL, Bootstrap, JavaScript', NULL, NULL, 1, 1, '2026-10-06 08:14:07'),
(2, 'SwiftCart E-Commerce', 'A complete e-commerce platform with multi-vendor support, inventory management, and Razorpay integration.', 'PHP OOP, MySQL, Bootstrap, AJAX', NULL, NULL, 1, 2, '2026-10-06 08:14:07'),
(3, 'MedConnect Clinic', 'Doctor appointment booking system with patient management, OPD scheduling, and billing module.', 'PHP, MySQL, JavaScript, CSS', NULL, NULL, 1, 3, '2026-10-06 08:14:07'),
(4, 'InventoryPro', 'Real-time inventory management system for retail businesses with barcode scanning and reports.', 'PHP, MySQL, Chart.js, Bootstrap', NULL, NULL, 1, 4, '2026-10-06 08:14:07'),
(5, 'HireHub Job Portal', 'Job portal with employer/jobseeker roles, resume upload, job posting, and application tracking.', 'PHP OOP, MySQL, Bootstrap, jQuery', NULL, NULL, 1, 5, '2026-10-06 08:14:07'),
(6, 'RealNest Property Portal', 'Property listing portal with location filters, agent profiles, and inquiry management system.', 'PHP, MySQL, Google Maps API, Bootstrap', NULL, NULL, 1, 6, '2026-10-06 08:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--
CREATE TABLE `services` (
  `id` int NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `short_description`, `description`, `icon`, `image`, `status`, `sort_order`) VALUES
(1, 'Website Development', 'We build fast, responsive, and SEO-optimized websites tailored for your business goals.', NULL, 'bi bi-globe2', NULL, 1, 1),
(2, 'Web Application Development', 'Custom web applications built with scalable architecture using Core PHP, Laravel, and MySQL.', NULL, 'bi bi-window-stack', NULL, 1, 2),
(3, 'Software Development', 'End-to-end software solutions for businesses ÔÇö desktop, web, and hybrid applications.', NULL, 'bi bi-code-slash', NULL, 1, 3),
(4, 'UI/UX Design', 'Pixel-perfect, user-centered interface design that looks beautiful and converts visitors.', NULL, 'bi bi-vector-pen', NULL, 1, 4),
(5, 'E-Commerce Development', 'Feature-rich online stores with product management, payment gateways, and dashboards.', NULL, 'bi bi-cart4', NULL, 1, 5),
(6, 'Website Maintenance', 'Ongoing support, updates, security patches, and performance monitoring for your website.', NULL, 'bi bi-tools', NULL, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--
CREATE TABLE `site_settings` (
  `id` int NOT NULL,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'site_name', 'Techno Coderz'),
(2, 'tagline', 'Build Skills. Create Projects. Grow Your Tech Career.'),
(3, 'email', 'info@technocoderz.com'),
(4, 'phone', '+91 98765 43210'),
(5, 'address', 'Office No. 36, Second Floor, D-185, Phase 8B, Sector 74, Sahibzada Ajit Singh Nagar, Mohali, Punjab 160055'),
(6, 'facebook', 'https://facebook.com/technocoderz'),
(7, 'instagram', 'https://instagram.com/technocoderz'),
(8, 'linkedin', 'https://linkedin.com/company/technocoderz'),
(9, 'youtube', 'https://youtube.com/@technocoderz'),
(10, 'twitter', 'https://twitter.com/technocoderz'),
(11, 'email2', 'hr@technocoderz.com'),
(12, 'phone2', '+91 98704 43528'),
(13, 'location', 'Mohali, Punjab');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--
CREATE TABLE `testimonials` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint DEFAULT '5',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `message`, `image`, `rating`, `status`) VALUES
(1, 'Rahul Sharma', 'Junior PHP Developer, Infosys', 'Techno Coderz completely transformed my career. The Full Stack course was practical, project-driven, and the mentors were always supportive. I landed my first job within 2 months of completing the course!', NULL, 5, 1),
(2, 'Priya Nair', 'Frontend Engineer, TCS', 'The Frontend Development course at Techno Coderz was exceptional. I learned Bootstrap, JavaScript and CSS animations that I now use daily in my job. Highly recommended for anyone serious about web development.', NULL, 5, 1),
(3, 'Amit Patel', 'Software Developer, Wipro', 'I had zero coding knowledge when I joined. After 6 months of the Full Stack program, I built 3 complete projects and got placed at Wipro. The teaching methodology is industry-focused and truly effective.', NULL, 5, 1),
(4, 'Sneha Gupta', 'Web Developer, Freelancer', 'What sets Techno Coderz apart is the real-world project experience. I built an actual e-commerce website during the PHP course ÔÇö that project became my portfolio and got me multiple clients.', NULL, 5, 1),
(5, 'Karan Mehta', 'Java Developer, Cognizant', 'The Core Java course was thorough and well-structured. From basics to collections and projects ÔÇö everything was covered. The doubt-clearing sessions after each module were extremely helpful.', NULL, 5, 1),
(6, 'Divya Krishnan', 'UI Developer, Accenture', 'Excellent training facility with hands-on labs. The mentors at Techno Coderz have real industry experience and they show you how things actually work in a company. Worth every penny!', NULL, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin', 'admin@technocoderz.com', '$2y$12$kBXr/CSN3SDER3ZNp2Eq4.B.RdwFAIpt8TYtOtqZFlFwg0X3UgR26', 'admin', 1, '2026-10-06 08:14:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cert_no` (`cert_no`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
