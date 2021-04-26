CREATE DATABASE ijdb;

CREATE TABLE `joke` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`text` LONGTEXT NOT NULL,
	`timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`author_id` INT NOT NULL
);

ALTER TABLE `joke` ADD INDEX(`author_id`);

CREATE TABLE `author` (
	`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`permissions` INT(64) DEFAULT 0
);

CREATE TABLE `category` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL
);

CREATE TABLE `joke__category` (
	`joke_id` INT NOT NULL,
	`category_id` INT NOT NULL,
	PRIMARY KEY (`joke_id`, `category_id`)
);
