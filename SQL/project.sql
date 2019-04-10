SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create Database -- 

DROP DATABASE IF EXISTS project_product;
CREATE DATABASE IF NOT EXISTS project_product DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE project_product;

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

-- Add Data --

INSERT INTO product(Pname, Pdesc, price, availability, category)
VALUES 
('Sekiro', 'One Handed Samurai goes on a mission to save prince', 69.99, 3, 'games'),
('Air Max 1', 'Cool Shoes', 249.99, 4, 'shoes'),
('Iphone X', 'Steve Jobs is disappointed', 1249.99, 10, 'phones'),
('Samsung S10', 'Same phone different design', 1200.00, 25, 'phones');

-- Create Database -- 

DROP DATABASE IF EXISTS project_corder;
CREATE DATABASE IF NOT EXISTS project_corder DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE project_corder;

-- Add Table --

DROP TABLE IF EXISTS corder;
CREATE TABLE corder (
  OID 			INT 			NOT NULL	AUTO_INCREMENT,
  CID           VARCHAR(30)     NOT NULL,
  totalprice    DECIMAL(10,2)   NOT NULL,
  Pstatus		VARCHAR(20),
  timestamp     timestamp       NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (OID)
);

-- Add Data --

INSERT INTO corder(OID, CID, totalprice, Pstatus, timestamp)
VALUES 
(1, 'James Tan', 100.00, '', '2018-11-14 14:42:31'),
(2, 'James Tan', 100.00, '', '2018-11-15 20:42:31'),
(3, 'James Tan', 100.00, '', '2018-11-16 21:42:31'),
(4, 'James Tan', 100.00, '', '2018-11-17 22:42:31');

-- Add Table --

DROP TABLE IF EXISTS order_items;
CREATE TABLE IF NOT EXISTS order_items (
  IID           INT             NOT NULL AUTO_INCREMENT,
  PID           INT             NOT NULL,
  Pname 		VARCHAR(45) 	NOT NULL,
  price 		DECIMAL(10,2) 	NOT NULL,
  qty			INT				NOT NULL,
  OID           INT             NOT NULL,

  PRIMARY KEY (IID),
  FOREIGN KEY (OID) REFERENCES corder (OID)
);

-- Add Data --

INSERT INTO order_items(PID, Pname, price, qty, OID)
VALUES 
(1, 'Sekiro', 5.99, 3, 1),
(2, 'Air Max 1', 12.99, 4, 2),
(3, 'IPhone X', 6.99, 10, 3),
(4, 'Samsung S10', 1200.00, 25, 4);

-- Create Database -- 

DROP DATABASE IF EXISTS project_payment;
CREATE DATABASE IF NOT EXISTS project_payment DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE project_payment;

-- Add Table --

DROP TABLE IF EXISTS payment;
CREATE TABLE payment (
  PayID 		INT 			NOT NULL	AUTO_INCREMENT,
  OID           INT             NOT NULL,
  Pstatus		VARCHAR(20)		NOT NULL,
  price 		DECIMAL(10,2) 	NOT NULL,
  
  PRIMARY KEY (PayID)
);