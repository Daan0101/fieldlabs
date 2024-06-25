CREATE DATABASE IF NOT EXISTS fieldlabs;

USE fieldlabs;

CREATE TABLE IF NOT EXISTS users (
    uid INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    PRIMARY KEY (uid)
);

REPLACE INTO users (uid, username, email, token)
VALUES (1, 'admin', 'admin@admin', 'mamjebentjarig');
