CREATE DATABASE WatchList;
USE WatchList;
CREATE TABLE `username` (
	`UserName` VARCHAR(50) NOT NULL,
	`UserHash` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`UserName`),
	INDEX `userhash` (`UserHash`)
);
CREATE TABLE `password` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`UserHash` VARCHAR(255) NOT NULL,
	`PasswordHash` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`ID`),
	INDEX `userhash` (`UserHash`),
	CONSTRAINT `userhash` FOREIGN KEY (`UserHash`) REFERENCES `username` (`UserHash`)
);
CREATE TABLE `userprofile` (
	`UserName` VARCHAR(50) NOT NULL,
	`Info` TINYTEXT NULL,
	`ProfilePic` VARCHAR(50) NULL DEFAULT NULL,
	`RegDate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`UserName`),
	CONSTRAINT `userprofile` FOREIGN KEY (`UserName`) REFERENCES `username` (`UserName`)
);
CREATE TABLE `userlists` (
	`UserName` VARCHAR(50) NOT NULL,
	`Watched` MEDIUMTEXT NULL,
	`Favourite` MEDIUMTEXT NULL,
	`Planned` MEDIUMTEXT NULL,
	`Watching` MEDIUMTEXT NULL,
	PRIMARY KEY (`UserName`),
	CONSTRAINT `userlist` FOREIGN KEY (`UserName`) REFERENCES `username` (`UserName`) ON DELETE CASCADE
);
