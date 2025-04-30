-- SQL script to create database schema for freelancing website

CREATE DATABASE IF NOT EXISTS karyasetu;
USE karyasetu;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Projects table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    budget DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Proposals table
CREATE TABLE IF NOT EXISTS proposals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    freelancer_id INT NOT NULL,
    proposal_text TEXT NOT NULL,
    proposed_budget DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (freelancer_id) REFERENCES users(id) ON DELETE CASCADE
);
