CREATE SCHEMA `project` ;

CREATE TABLE `project`.`products` (
  `pid` INT(11) NOT NULL,
  `product_name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `availability` INT(11) NULL DEFAULT NULL,
  `category` VARCHAR(45) NOT NULL,
  primary key (pid));

INSERT INTO products(pid, product_name, description, price, availability, category)
VALUES 
(1, 'The Shining', 'The Torrance Family slowly go insane in the Overlook Hotel', 5.99, 3, 'books'),
(2, 'The Kite Runner', 'The cruelties of living in Afghanistan', 12.99, 4, 'books'),
(3, 'Zoo', 'Animals turn haywire and turn on humans', 6.99, 10, 'books'),
(4, 'Samsung S10', 'Same phone different design', 1200.00, 25, 'phones');

