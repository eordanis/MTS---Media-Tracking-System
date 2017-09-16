CREATE TABLE users(
userID        		MEDIUMINT UNSIGNED 		NOT NULL 	AUTO_INCREMENT,
firstname 			VARCHAR(20) 			NOT NULL,
lastname   			VARCHAR(40) 			NOT NULL,
username   			VARCHAR(30) 			NOT NULL,
email          		VARCHAR(40) 			NOT NULL,
password       		VARCHAR(50) 			NOT NULL,
age					VARCHAR(3)				NOT NULL,
gender 				VARCHAR(6) 				NOT NULL,
street 				VARCHAR(40)				NOT NULL,
city 				VARCHAR(30)				NOT NULL,
state 				CHAR(2)					NOT NULL,
zipCode				CHAR(5)					NOT NULL,
registrationDate 	DATETIME 				NOT NULL	DEFAULT NOW(),
userType           	CHAR(1) 				NOT NULL	DEFAULT 'r',
userStatus			VARCHAR(20) 			NOT NULL	DEFAULT 'ok',
CONSTRAINT pk_userID PRIMARY KEY (userID)
);

CREATE TABLE media(
mediaID        		MEDIUMINT UNSIGNED 		NOT NULL 	AUTO_INCREMENT,
userID				MEDIUMINT UNSIGNED		NOT NULL,
mType           	VARCHAR(10)				NOT NULL,
title 				VARCHAR(60) 			NOT NULL,
dfirstname 			VARCHAR(30) 			NOT NULL,
dlastname   		VARCHAR(30) 			NOT NULL,
pubyr  				VARCHAR(20) 			NOT NULL,
quantity         	VARCHAR(10)				NOT NULL,
genre          	 	VARCHAR(60) 			NOT NULL,
location	   		VARCHAR(50) 			NOT NULL,
mdhrs		   		VARCHAR(2) 				NOT NULL,
mdmin		   		VARCHAR(2) 				NOT NULL,
CONSTRAINT pk_mediaID PRIMARY KEY (mediaID),
FOREIGN KEY (userID)  REFERENCES users(userID)
);