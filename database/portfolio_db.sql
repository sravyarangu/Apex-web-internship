-- ========================================
-- PORTFOLIO DATABASE SCHEMA
-- MySQL Database Setup for Contact Messages
-- ========================================

-- Create Database
CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- ========================================
-- CONTACT MESSAGES TABLE
-- Stores all contact form submissions
-- ========================================

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    reply_message LONGTEXT NULL,
    replied_at TIMESTAMP NULL
);

-- Create indexes for better query performance
CREATE INDEX idx_email ON contact_messages(email);
CREATE INDEX idx_created_at ON contact_messages(created_at);

-- ========================================
-- PROJECTS TABLE
-- Dynamically display projects on portfolio
-- ========================================

CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description LONGTEXT NOT NULL,
    technologies VARCHAR(255) NOT NULL,
    project_url VARCHAR(255),
    github_url VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- ========================================
-- SKILLS TABLE
-- Manage and display skillsets
-- ========================================

CREATE TABLE IF NOT EXISTS skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    skill_name VARCHAR(150) NOT NULL,
    proficiency_level ENUM('Beginner', 'Intermediate', 'Advanced', 'Expert') DEFAULT 'Intermediate',
    display_order INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- SAMPLE DATA INSERTION
-- Insert sample projects
-- ========================================

INSERT INTO projects (title, description, technologies, project_url, image_url, is_active) VALUES
('Personal Portfolio Website', 
 'Fully responsive portfolio built with HTML5, CSS3, JavaScript, PHP, and MySQL. Features dynamic content management, contact forms with database integration, and mobile-first responsive design.',
 'HTML5, CSS3, JavaScript, PHP, MySQL',
 'https://github.com/username/portfolio',
 'assets/portfolio-project.jpg',
 TRUE),

('E-Commerce Product Catalog',
 'Dynamic product listing system powered by MySQL database. Includes search functionality, filtering by category, and responsive grid layout. Built with PHP backend for server-side rendering.',
 'HTML5, CSS3, PHP, MySQL',
 'https://github.com/username/ecommerce-catalog',
 'assets/ecommerce-project.jpg',
 TRUE),

('Interactive JavaScript Games',
 'Collection of fun, interactive games demonstrating vanilla JavaScript capabilities. Includes DOM manipulation, event handling, game logic, and responsive animations.',
 'HTML5, CSS3, JavaScript',
 'https://github.com/username/javascript-games',
 'assets/games-project.jpg',
 TRUE);

-- Insert sample skills
INSERT INTO skills (category, skill_name, proficiency_level, display_order) VALUES
('Frontend', 'HTML5 Semantic Tags', 'Advanced', 1),
('Frontend', 'CSS3 Flexbox & Grid', 'Advanced', 2),
('Frontend', 'JavaScript DOM Manipulation', 'Advanced', 3),
('Frontend', 'Responsive Design', 'Advanced', 4),
('Frontend', 'CSS Animations & Transitions', 'Intermediate', 5),

('Backend', 'PHP 7.x+', 'Intermediate', 6),
('Backend', 'Form Handling ($_GET, $_POST)', 'Intermediate', 7),
('Backend', 'Server-side Validation', 'Intermediate', 8),
('Backend', 'File Upload Processing', 'Beginner', 9),
('Backend', 'Session Management', 'Beginner', 10),

('Database', 'MySQL Database Design', 'Intermediate', 11),
('Database', 'CRUD Operations', 'Intermediate', 12),
('Database', 'JOIN Queries & Relationships', 'Intermediate', 13),
('Database', 'Primary & Foreign Keys', 'Intermediate', 14),
('Database', 'phpMyAdmin', 'Advanced', 15),

('Tools & Workflow', 'Git Version Control', 'Advanced', 16),
('Tools & Workflow', 'GitHub Repository', 'Advanced', 17),
('Tools & Workflow', 'XAMPP Development Environment', 'Advanced', 18),
('Tools & Workflow', 'VS Code Editor', 'Advanced', 19),
('Tools & Workflow', 'Responsive Testing', 'Intermediate', 20);

-- ========================================
-- QUERIES FOR PORTFOLIO FUNCTIONALITY
-- ========================================

-- Query: Get all unread messages
-- SELECT * FROM contact_messages WHERE is_read = FALSE ORDER BY created_at DESC;

-- Query: Get messages from last 7 days
-- SELECT * FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC;

-- Query: Update message as read
-- UPDATE contact_messages SET is_read = TRUE WHERE id = ?;

-- Query: Get all active projects
-- SELECT * FROM projects WHERE is_active = TRUE ORDER BY created_at DESC;

-- Query: Get skills grouped by category
-- SELECT category, GROUP_CONCAT(skill_name) as skills FROM skills GROUP BY category;

-- ========================================
-- SAMPLE SELECT QUERIES (for testing)
-- ========================================

-- View all contact messages
-- SELECT id, name, email, subject, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as sent_time FROM contact_messages;

-- View all projects
-- SELECT title, technologies, project_url FROM projects WHERE is_active = TRUE;

-- View all skills by category
-- SELECT category, skill_name, proficiency_level FROM skills ORDER BY category, display_order;
