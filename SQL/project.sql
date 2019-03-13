SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create Database -- 

CREATE DATABASE IF NOT EXISTS project DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE project;

-- Add Table --

DROP TABLE IF EXISTS product;
CREATE TABLE product (
  PID 			INT 			NOT NULL	AUTO_INCREMENT,
  Pname 		VARCHAR(45) 	NOT NULL,
  Pdesc 		VARCHAR(1000)	NOT NULL,
  price 		DECIMAL(10,2) 	NOT NULL,
  availability 	INT(11) 		NOT NULL,
  category 		VARCHAR(45) 	NOT NULL,
  
  PRIMARY KEY (PID)
);

DROP TABLE IF EXISTS cart;
CREATE TABLE cart (
  CID 			INT 			NOT NULL	AUTO_INCREMENT,
  Pname 		VARCHAR(45) 	NOT NULL,
  Pdesc 		VARCHAR(1000)	NOT NULL,
  price 		DECIMAL(10,2) 	NOT NULL,
  availability 	INT(11) 		NOT NULL,
  qty			INT				NOT NULL,
  category 		VARCHAR(45) 	NOT NULL,
  
  PRIMARY KEY (CID)
);

DROP TABLE IF EXISTS corder;
CREATE TABLE corder (
  OID 			INT 			NOT NULL	AUTO_INCREMENT,
  Pname 		VARCHAR(45) 	NOT NULL,
  Pdesc 		VARCHAR(1000)	NOT NULL,
  price 		DECIMAL(10,2) 	NOT NULL,
  availability 	INT(11) 		NOT NULL,
  qty			INT				NOT NULL,
  category 		VARCHAR(45) 	NOT NULL,
  Pstatus		VARCHAR(20),
  CID			INT 			NOT NULL,
  
  PRIMARY KEY (OID),
  FOREIGN KEY (CID) REFERENCES cart(CID)
);

DROP TABLE IF EXISTS payment;
CREATE TABLE payment (
  PayID 		INT 			NOT NULL	AUTO_INCREMENT,
  Pstatus		VARCHAR(20)		NOT NULL,
  price 		DECIMAL(10,2) 	NOT NULL,
  qty			INT				NOT NULL,
  OID			INT				NOT NULL,
  
  PRIMARY KEY (PayID),
  FOREIGN KEY (OID) REFERENCES corder(OID)
);

DROP TABLE IF EXISTS notification;
CREATE TABLE notification (
  NID			INT 			NOT NULL AUTO_INCREMENT,
  OID			INT				NOT NULL,
  VOID			INT				NOT NULL,
  Pstatus		VARCHAR(20)		NOT NULL,
  
  PRIMARY KEY (NID),
  FOREIGN KEY (OID) REFERENCES corder(OID)
);

-- Add Data --

INSERT INTO product(Pname, Pdesc, price, availability, category)
VALUES 
('The Shining', 'The Torrance Family slowly go insane in the Overlook Hotel', 5.99, 3, 'books'),
('The Kite Runner', 'The cruelties of living in Afghanistan', 12.99, 4, 'books'),
('Zoo', 'Animals turn haywire and turn on humans', 6.99, 10, 'books'),
('Samsung S10', 'Same phone different design', 1200.00, 25, 'phones');

