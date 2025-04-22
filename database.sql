CREATE DATABASE IF NOT EXISTS student_registration;
USE student_registration;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    seat_number VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    national_id VARCHAR(20) UNIQUE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    age INT NOT NULL,
    residence TEXT NOT NULL,
    qualification VARCHAR(100) NOT NULL,
    education_type ENUM('regular', 'distance') NOT NULL,
    job VARCHAR(100),
    workplace VARCHAR(100),
    college VARCHAR(100),
    grade VARCHAR(50),
    current_stage ENUM('preparatory', 'intermediate', 'specialized') NOT NULL,
    preparatory_stage BOOLEAN DEFAULT FALSE,
    intermediate_stage BOOLEAN DEFAULT FALSE,
    specialized_stage BOOLEAN DEFAULT FALSE,
    specialization VARCHAR(100),
    sect ENUM('hanafi', 'shafi', 'maliki', 'hanbali') NOT NULL,
    attendance_system ENUM('regular', 'irregular') NOT NULL,
    special_needs BOOLEAN DEFAULT FALSE,
    qualification_image VARCHAR(255),
    id_card_image VARCHAR(255),
    payment_receipt_image VARCHAR(255),
    payment_reference VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create admin user with password 'admin123'
INSERT INTO users (username, password, is_admin) 
VALUES ('admin', '$2y$10$YourHashedPasswordHere', TRUE); 