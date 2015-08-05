drop database cms;
CREATE DATABASE cms;
use cms;

CREATE TABLE users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	userType ENUM('public','author','admin'),
	username VARCHAR(30) NOT NULL,
	email VARCHAR(40) NOT NULL,
	pass CHAR(40) NOT NULL,
	dateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	UNIQUE (username),
	UNIQUE (email),
	INDEX login (email, pass)
);

CREATE TABLE pages (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	creatorId INT UNSIGNED NOT NULL,
	title VARCHAR(100) NOT NULL,
	content TEXT NOT NULL,
	dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	dateAdded TIMESTAMP NOT NULL,
	PRIMARY KEY (id),
	INDEX (creatorId),
	INDEX (dateUpdated)
);

INSERT INTO users VALUES
(NULL, 'public', 'publicUser','public@example.com',SHA1('publicPass'), NULL),
(NULL, 'author', 'authorUser','author@example.com',SHA1('authorPass'), NULL),
(NULL, 'admin', 'adminUser','admin@example.com',SHA1('adminPass'), NULL);

INSERT INTO pages VALUES
(NULL, 2, 'this is a post', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit,sed do eisumod tempor incididunt ut labore et dolore magna aliqua</p>', NULL, NOW()),