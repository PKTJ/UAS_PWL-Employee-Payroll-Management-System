-- CREATE DATABASE gaji_db;
-- USE gaji_db;

-- tabel gaji
CREATE TABLE gaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pokok DECIMAL(12,2) NOT NULL,
    lembur DECIMAL(12,2) DEFAULT 0,
    pajak DECIMAL(12,2) DEFAULT 0,
    asuransi DECIMAL(12,2) DEFAULT 0
);

-- tabel Karyawan
CREATE TABLE karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelamin VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(100) NOT NULL,
    gaji INT,
    FOREIGN KEY (gaji) REFERENCES gaji(id)
);

-- tabel user
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    confirm VARCHAR(100) NOT NULL
);
