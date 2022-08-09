CREATE DATABASE dazala;
DROP DATABASE dazala;
USE dazala;

#----- CREATE TABLE VENDOR -----#

CREATE TABLE vendor_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE vendor
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	name VARCHAR(30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    latitude DECIMAL(10, 4) NOT NULL,
    longtitude DECIMAL(10, 4) NOT NULL,
    username VARCHAR(16) NOT NULL,
    password VARCHAR(255) NOT NULL
);

ALTER TABLE vendor 
ADD CONSTRAINT UQ_Lad_Long UNIQUE (latitude, longtitude);

DELIMITER $$
CREATE TRIGGER tg_vendor_insert
BEFORE INSERT ON vendor
FOR EACH ROW
BEGIN
  INSERT INTO vendor_seq VALUES (NULL);
  SET NEW.id = CONCAT('VD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

insert into vendor(name, address, latitude, longtitude, username, password)
value ('phuc', 'Ho Chi Minh City', 12, 10, 'phuc123', '123');

#----- CREATE TABLE PRODUCT -----#

CREATE TABLE product_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE product
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	name VARCHAR(30) NOT NULL,
	price DECIMAL(14, 2) NOT NULL,
    ven_id VARCHAR(10) NOT NULL
);

ALTER TABLE product
ADD CONSTRAINT FK_product_ven_id 
FOREIGN KEY (ven_id) REFERENCES vendor(id);
    
DELIMITER $$
CREATE TRIGGER tg_product_insert
BEFORE INSERT ON product
FOR EACH ROW
BEGIN
  INSERT INTO product_seq VALUES (NULL);
  SET NEW.id = CONCAT('PD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

insert into product (name, price, ven_id) values ('iphone', 200, 'VD001');

#----- CREATE TABLE CUSTOMER -----#

CREATE TABLE customer_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE customer
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	name VARCHAR(30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    latitude DECIMAL(10, 4) NOT NULL,
    longtitude DECIMAL(10, 4) NOT NULL,
    username VARCHAR(16) NOT NULL,
    password VARCHAR(255) NOT NULL
);

ALTER TABLE customer 
ADD CONSTRAINT CS_Lad_Long UNIQUE (latitude, longtitude);

DELIMITER $$
CREATE TRIGGER tg_customer_insert
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
  INSERT INTO customer_seq VALUES (NULL);
  SET NEW.id = CONCAT('CS', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

insert into customer(name, address, latitude, longtitude, username, password)
value ('binh', 'Thanh Hoa', 11, 10, 'binh123', '12345');

insert into customer(name, address, latitude, longtitude, username, password)
value ('linh', 'Cu Ba', 151, 11, 'linh123', 'abc123');

select * from customer;

#----- CREATE TABLE ORDER -----#

CREATE TABLE orders_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE orders
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	order_status VARCHAR(30) NOT NULL,
	total_price DECIMAL(14, 2) NOT NULL,
    prod_id VARCHAR(10) NOT NULL,
    cus_id VARCHAR(10) NOT NULL
);

ALTER TABLE orders
ADD CONSTRAINT FK_order_prod_id 
FOREIGN KEY (prod_id) REFERENCES product(id);

ALTER TABLE orders
ADD CONSTRAINT FK_order_cus_id
FOREIGN KEY (cus_id) REFERENCES customer(id);

DELIMITER $$
CREATE TRIGGER tg_order_insert
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
  INSERT INTO order_seq VALUES (NULL);
  SET NEW.id = CONCAT('OD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- DISPLAY PRODUCT (NEW TO OLD), LIMIT 2 PER PAGE -----#

select * from product order by id desc limit 2;

#----- CREATE USER AND ROLE -----#

CREATE USER 'vendor'@'localhost' IDENTIFIED BY 'vendor';
CREATE ROLE vendor;
GRANT SELECT, INSERT, UPDATE, DELETE ON dazala.product TO vendor;
GRANT SELECT ON dazala.vendor TO vendor;
GRANT vendor TO 'vendor'@'localhost';

CREATE USER 'customer'@'localhost' IDENTIFIED BY 'customer';
CREATE ROLE customer;
GRANT SELECT ON dazala.customer TO customer;
GRANT SELECT ON dazala.product TO customer;
GRANT customer TO 'customer'@'localhost';
