CREATE DATABASE IF NOT EXISTS fieldlabs;

USE fieldlabs;

CREATE TABLE IF NOT EXISTS users (
    uid INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    PRIMARY KEY (uid)
);

REPLACE INTO users (uid, username, email, role, token)
VALUES 
(1, 'admin', 'admin@admin', 'Docent', 'mamjebentjarig'),
(2, 'Onno', 'Onno@onno', 'Docent', '8763gjdget37gh'),
(3, 'Jeffry', 'Jeffry@jeffry', 'Docent', '98757892ghjgfghjh'),
(4, 'Docent', 'Docent@docent', 'Docent', '8767972876');


CREATE TABLE `posts` (
  `location` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `product_owner_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL,
  PRIMARY KEY (`post_id`)
);

CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `product_owner_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `request_complete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `product_owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `student_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);