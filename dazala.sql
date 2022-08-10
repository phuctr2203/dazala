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
    username VARCHAR(16) NOT NULL UNIQUE,
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

insert into vendor(name, address, latitude, longtitude, username, password)
value ('dung', 'Hanoi', 15, 101, 'dung123', 'abc');

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
insert into product (name, price, ven_id) values ('laptop', 1000, 'VD001');
insert into product (name, price, ven_id) values ('apple', 50, 'VD002');
insert into product (name, price, ven_id) values ('banana', 70, 'VD002');

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
    username VARCHAR(16) NOT NULL UNIQUE,
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

#----- wait time trigger -----#
DELIMITER $$
CREATE TRIGGER tg_order_insert
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
  DECLARE random_time TIME;
  SET random_time = (SELECT SEC_TO_TIME(
	FLOOR(
	TIME_TO_SEC('00:00:10') + RAND() * (
	TIME_TO_SEC(TIMEDIFF('00:00:20', '00:00:00'))))));
  DO SLEEP(random_time);
  INSERT INTO orders_seq VALUES (NULL);
  SET NEW.id = CONCAT('OD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- CREATE USER AND ROLE -----#
CREATE USER 'vendor'@'localhost' IDENTIFIED BY 'vendor';
CREATE ROLE vendor;
GRANT SELECT, INSERT, UPDATE, DELETE ON dazala.product TO vendor;
GRANT SELECT, INSERT ON dazala.vendor TO vendor;
GRANT vendor TO 'vendor'@'localhost';

CREATE USER 'customer'@'localhost' IDENTIFIED BY 'customer';
CREATE ROLE customer;
GRANT SELECT, INSERT, DELETE ON dazala.customer TO customer;
GRANT SELECT ON dazala.product TO customer;
GRANT customer TO 'customer'@'localhost';


#----------- GENERAL COMMAND ----------#

#----- SELECT COMMAND ----#
select * from customer;
select * from vendor;
select * from product;

delete from customer where id = 'CS003';

#----- DISPLAY PRODUCT (NEW TO OLD), LIMIT 2 PER PAGE COMMAND -----#
select * from product order by id desc limit 2;

#----- SEARCH PRODCUT BASED ON NAME AND PRICE -----#
DELIMITER $$
CREATE PROCEDURE search_product_based_on_name(IN input_product_name varchar(30))
BEGIN
    SELECT * FROM PRODUCT
    WHERE NAME LIKE CONCAT(input_product_name,'%');
END $$
DELIMITER ;

CALL search_product_based_on_name('iph');

DELIMITER $$
CREATE PROCEDURE search_product_based_on_price(IN input_product_price_start decimal(14,2), IN input_product_price_end decimal(14,2))
BEGIN
    SELECT * FROM PRODUCT WHERE PRICE BETWEEN input_product_price_start AND input_product_price_end;
END $$
DELIMITER ;

CALL search_product_based_on_price(10, 200);

#------- Search vendor based on distance ------#
DELIMITER $$
CREATE PROCEDURE search_vendor_based_on_distance(IN input_distance decimal(10,4), IN user_lat decimal(10,4), IN user_lon decimal(10,4))
BEGIN
	SELECT * FROM vendor v
	WHERE ((SELECT(111.111 *
    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(user_lat))
	* COS(RADIANS(v.latitude))
	* COS(RADIANS(user_lon - v.longtitude))
	+ SIN(RADIANS(user_lat))
	* SIN(RADIANS(v.latitude))))) )) <= input_distance);
END $$
DELIMITER ;

drop procedure search_vendor_based_on_distance;

CALL search_vendor_based_on_distance(111.1110, 11, 10);

SELECT (111.111 *
    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(11))
	* COS(RADIANS(12))
	* COS(RADIANS(10 - 10))
	+ SIN(RADIANS(11))
	* SIN(RADIANS(12))))));
    
#---- Display Product of Particular Vendor ------#
DELIMITER $$
CREATE PROCEDURE show_product_of_particular_vendor(IN selected_vendor VARCHAR(30))
BEGIN
    SELECT * FROM PRODUCT WHERE VEN_ID = (SELECT ID FROM VENDOR
    WHERE NAME = selected_vendor);
END $$
DELIMITER ;

CALL show_product_of_particular_vendor('phuc');

#----- Generate random second from 10 to 30 ----#
SELECT SEC_TO_TIME(
	FLOOR(
	TIME_TO_SEC('00:00:10') + RAND() * (
	TIME_TO_SEC(TIMEDIFF('00:00:20', '00:00:00')))));

#----- Test Create orders with with time(seconds from 10 to 30) -----#
insert into orders(order_status, total_price, prod_id, cus_id)
values ('ready', 1000, 'PD002', 'CS002');

SELECT * FROM ORDERS;
