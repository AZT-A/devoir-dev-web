CREATE DATABASE IF NOT EXISTS taskflow_db;
USE taskflow_db;

CREATE TABLE IF NOT EXISTS tasks (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  title      VARCHAR(100) NOT NULL,
  priority   ENUM('high', 'medium', 'low') DEFAULT 'medium',
  completed  TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
