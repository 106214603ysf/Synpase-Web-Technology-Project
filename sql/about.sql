CREATE DATABASE IF NOT EXISTS synapse_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE synapse_db;

CREATE TABLE about (
  id INT AUTO_INCREMENT PRIMARY KEY,
  member_name VARCHAR(50) NOT NULL,
  student_id VARCHAR(10) NOT NULL,
  part1_contribution TEXT NOT NULL,
  part2_contribution TEXT NOT NULL,
  quote_language VARCHAR(20) NOT NULL,
  lang_code VARCHAR(5) NOT NULL,
  quote TEXT NOT NULL,
  translation TEXT NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO about (member_name, student_id, part1_contribution, part2_contribution, quote_language, lang_code, quote, translation) VALUES
('Amani Aly', '106212283',
 'Group Leader. Developed the Apply page, proposed the overall website design concept, created and assigned Jira tasks, monitored team progress, and reviewed everyone''s work to ensure project requirements were met. Also contributed to the CSS styling.',
 'Built apply.php and process_eoi.php with server-side validation and the application confirmation. Created the eoi table and the code that inserts application records.',
 'Arabic', 'ar', 'ارفع صوتك، قف بثبات، واترك أثراً.', 'Be loud, stand tall, leave a mark.'),
('Abdullah Maithalouni', '106194323',
 'Communication Representative. Developed the About page, contributed significantly to the website''s CSS design and styling, and reviewed other pages to maintain consistency. Also supported communication between team members.',
 'Built the PHP include files, settings.php, about.php, login.php and logout.php. Created the about and users tables, loaded member contributions from the database and implemented secure login verification.',
 'Arabic', 'ar', 'تخشى الطبقة الحاكمة التعليم لأنه يجعل الطاعة مستحيلة.', 'The ruling class fears education because it makes obedience impossible.'),
('Youssof Hussein', '106214603',
 'Group Coordinator. Developed the Jobs page and inclusion statement, created the GitHub repository and Jira project, coordinated group activities, and contributed to the CSS styling.',
 'Built jobs.php, search.php and manage.php for listing, filtering and sorting. Created the jobs table and wrote the SQL search, filtering and sorting queries.',
 'Arabic', 'ar', 'ليس عليك أن ترى السلم كله، فقط خذ الخطوة الأولى.', 'You don''t have to see the whole staircase, just take the first step.'),
('Abrar Salahuddin', '106716811',
 'General Secretary. Developed the Home page and job search feature, designed the company logo, recorded meeting discussions and decisions, maintained meeting notes, and contributed to the CSS styling.',
 'Built index.php, update_eoi.php and delete_eoi.php. Loaded job information on the homepage from the database and wrote the queries to update EOI status and delete EOI records.',
 'Urdu', 'ur', 'جو لوگ کوشش کرتے رہتے ہیں وہ کبھی واقعی ہارتے نہیں۔', 'Those who keep trying are never truly defeated.');

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password_hash)
VALUES ('admin', '$2y$10$thVR0dTrwTFre4fc2DUtWOVcKPGyhMrOcGeN3j8o2s8tljCQx8/q.');