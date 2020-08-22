DROP DATABASE IF EXISTS webaccounts_database;
DROP USER IF EXISTS 'webaccounts_user'@'localhost';

CREATE DATABASE webaccounts_database;
CREATE USER 'webaccounts_user'@'localhost' IDENTIFIED BY 'webaccounts_password';
GRANT ALL PRIVILEGES ON webaccounts_database.* TO 'webaccounts_user'@'localhost'; 
FLUSH PRIVILEGES;

CREATE TABLE webaccounts_database.users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
