-- ============================================================
-- Techno Coderz - Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS technocoderz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE technocoderz;

-- ------------------------------------------------------------
-- Table: users (Admin & Staff)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
    status TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin: admin@technocoderz.com / Admin@123
INSERT INTO users (name, email, password, role, status) VALUES
('Admin', 'admin@technocoderz.com', '$2y$12$kBXr/CSN3SDER3ZNp2Eq4.B.RdwFAIpt8TYtOtqZFlFwg0X3UgR26', 'admin', 1);
-- Note: The above hash is for 'Admin@123' — CHANGE IN PRODUCTION

-- ------------------------------------------------------------
-- Table: courses
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    short_description VARCHAR(300),
    description TEXT,
    duration VARCHAR(100),
    level ENUM('Beginner','Intermediate','Advanced','All Levels') DEFAULT 'Beginner',
    price DECIMAL(10,2) DEFAULT 0.00,
    image VARCHAR(255),
    icon VARCHAR(100),
    status TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO courses (title, slug, short_description, description, duration, level, price, icon, status, sort_order) VALUES
('Full Stack Web Development', 'full-stack-web-development', 'Master both frontend and backend web development with HTML, CSS, JS, PHP and MySQL.', 'A comprehensive program covering HTML5, CSS3, JavaScript, Bootstrap, PHP OOP, MySQL, and deployment. You will build real-world projects.', '6 Months', 'Beginner', 0.00, 'bi bi-layers-fill', 1, 1),
('Core Java Development', 'core-java-development', 'Build a strong foundation in Java programming with OOP concepts, collections and projects.', 'Learn Core Java from scratch — data types, loops, OOP, inheritance, interfaces, exception handling, collections, and project work.', '3 Months', 'Beginner', 0.00, 'bi bi-cup-hot-fill', 1, 2),
('PHP & MySQL', 'php-mysql', 'Learn server-side web development with PHP and MySQL databases using real projects.', 'Covers PHP fundamentals, OOP, form handling, sessions, CRUD operations with MySQL, and security best practices.', '2 Months', 'Beginner', 0.00, 'bi bi-database-fill', 1, 3),
('PHP & Laravel Framework', 'php-laravel', 'Go beyond Core PHP and master the powerful Laravel framework for rapid application development.', 'MVC architecture, Eloquent ORM, Blade templating, middleware, authentication, REST APIs, and deployment.', '3 Months', 'Intermediate', 0.00, 'bi bi-box-fill', 1, 4),
('Frontend Development', 'frontend-development', 'Create stunning, responsive websites using HTML5, CSS3, JavaScript and Bootstrap 5.', 'Covers semantic HTML, Flexbox, CSS Grid, animations, Bootstrap components, JavaScript DOM, AJAX and modern UX.', '2 Months', 'Beginner', 0.00, 'bi bi-palette-fill', 1, 5),
('JavaScript Mastery', 'javascript-mastery', 'From fundamentals to advanced JS concepts including ES6+, async programming and DOM.', 'Variables, functions, closures, promises, async/await, fetch API, modules, OOP in JS, and practical projects.', '2 Months', 'Intermediate', 0.00, 'bi bi-lightning-fill', 1, 6),
('React Basics & Beyond', 'react-basics', 'Learn modern frontend development with React — components, hooks, state management and APIs.', 'JSX, components, props, state, hooks (useState, useEffect), React Router, API integration, and building SPAs.', '2 Months', 'Intermediate', 0.00, 'bi bi-arrow-repeat', 1, 7),
('MySQL & Database Design', 'mysql-database-design', 'Master relational database design, SQL queries, optimization and integration with PHP.', 'Database concepts, ER diagrams, normalization, SQL DML/DDL, joins, subqueries, stored procedures, indexing.', '1.5 Months', 'Beginner', 0.00, 'bi bi-server', 1, 8);

-- ------------------------------------------------------------
-- Table: services
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    short_description VARCHAR(300),
    description TEXT,
    icon VARCHAR(100),
    image VARCHAR(255),
    status TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO services (title, short_description, icon, status, sort_order) VALUES
('Website Development', 'We build fast, responsive, and SEO-optimized websites tailored for your business goals.', 'bi bi-globe2', 1, 1),
('Web Application Development', 'Custom web applications built with scalable architecture using Core PHP, Laravel, and MySQL.', 'bi bi-window-stack', 1, 2),
('Software Development', 'End-to-end software solutions for businesses — desktop, web, and hybrid applications.', 'bi bi-code-slash', 1, 3),
('UI/UX Design', 'Pixel-perfect, user-centered interface design that looks beautiful and converts visitors.', 'bi bi-vector-pen', 1, 4),
('E-Commerce Development', 'Feature-rich online stores with product management, payment gateways, and dashboards.', 'bi bi-cart4', 1, 5),
('Website Maintenance', 'Ongoing support, updates, security patches, and performance monitoring for your website.', 'bi bi-tools', 1, 6);

-- ------------------------------------------------------------
-- Table: projects
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    technology VARCHAR(300),
    image VARCHAR(255),
    project_url VARCHAR(300),
    status TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO projects (title, description, technology, status, sort_order) VALUES
('EduTrack LMS', 'A full-featured Learning Management System with student enrollment, progress tracking, and admin dashboards.', 'PHP, MySQL, Bootstrap, JavaScript', 1, 1),
('SwiftCart E-Commerce', 'A complete e-commerce platform with multi-vendor support, inventory management, and Razorpay integration.', 'PHP OOP, MySQL, Bootstrap, AJAX', 1, 2),
('MedConnect Clinic', 'Doctor appointment booking system with patient management, OPD scheduling, and billing module.', 'PHP, MySQL, JavaScript, CSS', 1, 3),
('InventoryPro', 'Real-time inventory management system for retail businesses with barcode scanning and reports.', 'PHP, MySQL, Chart.js, Bootstrap', 1, 4),
('HireHub Job Portal', 'Job portal with employer/jobseeker roles, resume upload, job posting, and application tracking.', 'PHP OOP, MySQL, Bootstrap, jQuery', 1, 5),
('RealNest Property Portal', 'Property listing portal with location filters, agent profiles, and inquiry management system.', 'PHP, MySQL, Google Maps API, Bootstrap', 1, 6);

-- ------------------------------------------------------------
-- Table: testimonials
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(150),
    message TEXT NOT NULL,
    image VARCHAR(255),
    rating TINYINT DEFAULT 5,
    status TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

INSERT INTO testimonials (name, designation, message, rating, status) VALUES
('Rahul Sharma', 'Junior PHP Developer, Infosys', 'Techno Coderz completely transformed my career. The Full Stack course was practical, project-driven, and the mentors were always supportive. I landed my first job within 2 months of completing the course!', 5, 1),
('Priya Nair', 'Frontend Engineer, TCS', 'The Frontend Development course at Techno Coderz was exceptional. I learned Bootstrap, JavaScript and CSS animations that I now use daily in my job. Highly recommended for anyone serious about web development.', 5, 1),
('Amit Patel', 'Software Developer, Wipro', 'I had zero coding knowledge when I joined. After 6 months of the Full Stack program, I built 3 complete projects and got placed at Wipro. The teaching methodology is industry-focused and truly effective.', 5, 1),
('Sneha Gupta', 'Web Developer, Freelancer', 'What sets Techno Coderz apart is the real-world project experience. I built an actual e-commerce website during the PHP course — that project became my portfolio and got me multiple clients.', 5, 1),
('Karan Mehta', 'Java Developer, Cognizant', 'The Core Java course was thorough and well-structured. From basics to collections and projects — everything was covered. The doubt-clearing sessions after each module were extremely helpful.', 5, 1),
('Divya Krishnan', 'UI Developer, Accenture', 'Excellent training facility with hands-on labs. The mentors at Techno Coderz have real industry experience and they show you how things actually work in a company. Worth every penny!', 4, 1);

-- ------------------------------------------------------------
-- Table: blogs
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(300) NOT NULL,
    slug VARCHAR(320) NOT NULL UNIQUE,
    excerpt VARCHAR(400),
    content LONGTEXT,
    image VARCHAR(255),
    author VARCHAR(100) DEFAULT 'Techno Coderz',
    category VARCHAR(100),
    tags VARCHAR(300),
    status TINYINT(1) NOT NULL DEFAULT 1,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO blogs (title, slug, excerpt, author, category, tags, status) VALUES
('Top 10 Programming Languages to Learn in 2025', 'top-10-programming-languages-2025', 'Discover which programming languages are most in-demand in 2025 and which ones can boost your career the most.', 'Techno Coderz Team', 'Career', 'programming,career,2025', 1),
('Why PHP is Still Relevant for Web Development', 'why-php-still-relevant-2025', 'Despite newer frameworks, PHP powers over 75% of websites. Here is why learning PHP is still one of the best decisions for a web dev career.', 'Techno Coderz Team', 'Web Development', 'php,web development,backend', 1),
('Bootstrap 5 vs Tailwind CSS: Which Should You Learn First?', 'bootstrap-5-vs-tailwind-css', 'A detailed comparison of Bootstrap 5 and Tailwind CSS for beginners — features, learning curve, job demand, and best use cases.', 'Techno Coderz Team', 'Frontend', 'bootstrap,tailwind,css,frontend', 1),
('Understanding MySQL Joins: A Complete Beginner Guide', 'mysql-joins-beginner-guide', 'INNER JOIN, LEFT JOIN, RIGHT JOIN, FULL JOIN — explained with practical examples and SQL queries you can run right away.', 'Techno Coderz Team', 'Database', 'mysql,database,sql,joins', 1),
('How to Build Your First PHP CRUD Application', 'build-php-crud-application', 'Step-by-step tutorial to build a Create, Read, Update, Delete application using Core PHP, MySQL and Bootstrap 5.', 'Techno Coderz Team', 'Tutorial', 'php,mysql,crud,tutorial', 1),
('JavaScript ES6 Features Every Developer Must Know', 'javascript-es6-features', 'Arrow functions, destructuring, template literals, spread/rest operators, async/await — master ES6 to write modern JS.', 'Techno Coderz Team', 'JavaScript', 'javascript,es6,frontend', 1);

-- ------------------------------------------------------------
-- Table: enquiries
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    course VARCHAR(200),
    message TEXT,
    status ENUM('new','in_progress','resolved') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Table: contact_messages
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(300),
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Table: site_settings
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT
) ENGINE=InnoDB;

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'Techno Coderz'),
('tagline', 'Build Skills. Create Projects. Grow Your Tech Career.'),
('email', 'info@technocoderz.com'),
('phone', '+91 98765 43210'),
('address', '2nd Floor, Tech Hub, MG Road, Bengaluru - 560001, Karnataka, India'),
('facebook', 'https://facebook.com/technocoderz'),
('instagram', 'https://instagram.com/technocoderz'),
('linkedin', 'https://linkedin.com/company/technocoderz'),
('youtube', 'https://youtube.com/@technocoderz'),
('twitter', 'https://twitter.com/technocoderz');
