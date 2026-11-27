-- filename: eoi.sql
-- author: Amani Aly
-- description: Creates the eoi (Expression of Interest) table. It has one field for every input on
--              apply.php, plus status (New, Current, Final) with New as the default.
--              process_eoi.php also creates this table in code if it does not exist yet.

USE synapse_db;

CREATE TABLE IF NOT EXISTS eoi (
  EOInumber    INT AUTO_INCREMENT PRIMARY KEY,
  job_ref      VARCHAR(5)   NOT NULL,
  first_name   VARCHAR(20)  NOT NULL,
  last_name    VARCHAR(20)  NOT NULL,
  dob          DATE         NOT NULL,
  gender       VARCHAR(20)  NOT NULL,
  street       VARCHAR(40)  NOT NULL,
  suburb       VARCHAR(40)  NOT NULL,
  state        VARCHAR(3)   NOT NULL,
  postcode     CHAR(4)      NOT NULL,
  email        VARCHAR(100) NOT NULL,
  phone        VARCHAR(12)  NOT NULL,
  skills       VARCHAR(255) NOT NULL,
  other_skills TEXT,
  status       ENUM('New', 'Current', 'Final') NOT NULL DEFAULT 'New'
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;