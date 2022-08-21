DROP DATABASE dazala;
CREATE DATABASE dazala;
USE dazala;

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

CREATE USER 'shipper'@'localhost' IDENTIFIED BY 'shipper';
CREATE ROLE shipper;
GRANT SELECT, INSERT ON dazala.shipper TO shipper;
GRANT shipper TO 'shipper'@'localhost';

#----- CREATE TABLE -----#
#----- VENDOR -----#

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

DELIMITER $$
CREATE TRIGGER tg_vendor_insert
BEFORE INSERT ON vendor
FOR EACH ROW
BEGIN
  INSERT INTO vendor_seq VALUES (NULL);
  SET NEW.id = CONCAT('VD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- PRODUCT -----#

CREATE TABLE product_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE product
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	name VARCHAR(30) NOT NULL,
	price DECIMAL(14, 2) NOT NULL,
    quantity INT NOT NULL,
    ven_id VARCHAR(10) NOT NULL
);
    
DELIMITER $$
CREATE TRIGGER tg_product_insert
BEFORE INSERT ON product
FOR EACH ROW
BEGIN
  INSERT INTO product_seq VALUES (NULL);
  SET NEW.id = CONCAT('PD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- CUSTOMER -----#

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

DELIMITER $$
CREATE TRIGGER tg_customer_insert
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
  INSERT INTO customer_seq VALUES (NULL);
  SET NEW.id = CONCAT('CS', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- ORDERS -----#

CREATE TABLE orders_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE orders
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	orders_status VARCHAR(30) NOT NULL,
	bill DECIMAL(14, 2),
    cus_id VARCHAR(10) NOT NULL,
    hub_id VARCHAR(10) NOT NULL
);

DELIMITER $$
CREATE TRIGGER tg_orders_insert
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
  DECLARE random_time TIME;
  SELECT random_secs() into random_time;
  DO SLEEP(random_time);
  INSERT INTO orders_seq VALUES (NULL);
  SET NEW.id = CONCAT('OR', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- ORDERS DETAIL -----#
CREATE TABLE orders_detail_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE orders_detail
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	quantity INT NOT NULL,
	total_price DECIMAL(14, 2),
    prod_id VARCHAR(10) NOT NULL,
    orders_id VARCHAR(10) NOT NULL
);

DELIMITER $$
CREATE TRIGGER tg_orders_detail_insert
BEFORE INSERT ON orders_detail
FOR EACH ROW
BEGIN
  INSERT INTO orders_detail_seq VALUES (NULL);
  SET NEW.id = CONCAT('OD', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- DISTRIBUTION HUB -----#

CREATE TABLE hub_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE hub
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	name VARCHAR(30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    latitude DECIMAL(10, 4) NOT NULL,
    longtitude DECIMAL(10, 4) NOT NULL
);

DELIMITER $$
CREATE TRIGGER tg_hub_insert
BEFORE INSERT ON hub
FOR EACH ROW
BEGIN
  INSERT INTO hub_seq VALUES (NULL);
  SET NEW.id = CONCAT('HB', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

#----- SHIPPER -----#
CREATE TABLE shipper_seq 
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE shipper
(
	id VARCHAR(10) NOT NULL PRIMARY KEY DEFAULT '0',
	name VARCHAR(30) NOT NULL,
    username VARCHAR(16) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    hub_id VARCHAR(10)
);

DELIMITER $$
CREATE TRIGGER tg_shipper_insert
BEFORE INSERT ON shipper
FOR EACH ROW
BEGIN
  INSERT INTO shipper_seq VALUES (NULL);
  SET NEW.id = CONCAT('SP', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;


#----- ALTER TABLE -----#
ALTER TABLE vendor 
ADD CONSTRAINT UQ_Lad_Long UNIQUE (latitude, longtitude);

ALTER TABLE vendor
ADD CONSTRAINT VEN_CHK_LAT CHECK (latitude between -90 and 90);

ALTER TABLE vendor
ADD CONSTRAINT VEN_CHK_LONG CHECK (longtitude between -180 and 180);

ALTER TABLE product
ADD CONSTRAINT FK_product_ven_id 
FOREIGN KEY (ven_id) REFERENCES vendor(id);

ALTER TABLE customer 
ADD CONSTRAINT CS_Lad_Long UNIQUE (latitude, longtitude);

ALTER TABLE customer
ADD CONSTRAINT CUS_CHK_LAT CHECK (latitude between -90 and 90);

ALTER TABLE customer
ADD CONSTRAINT CUS_CHK_LONG CHECK (longtitude between -180 and 180);

ALTER TABLE orders
ADD CONSTRAINT FK_orders_hub_id 
FOREIGN KEY (hub_id) REFERENCES hub(id);

ALTER TABLE orders
ADD CONSTRAINT FK_orders_cus_id
FOREIGN KEY (cus_id) REFERENCES customer(id);

ALTER TABLE orders_detail
ADD CONSTRAINT FK_orders_detail_prod_id
FOREIGN KEY (prod_id) REFERENCES product(id);

ALTER TABLE orders_detail
ADD CONSTRAINT FK_orders_detail_prders_id
FOREIGN KEY (orders_id) REFERENCES orders(id);

ALTER TABLE hub 
ADD CONSTRAINT DH_Lad_Long UNIQUE (latitude, longtitude);

ALTER TABLE hub
ADD CONSTRAINT HUB_CHK_LAT CHECK (latitude between -90 and 90);

ALTER TABLE hub
ADD CONSTRAINT HUB_CHK_LONG CHECK (longtitude between -180 and 180);

ALTER TABLE shipper
ADD CONSTRAINT FK_shipper_hub_id 
FOREIGN KEY (hub_id) REFERENCES hub(id);

#-------- GENERAL COMMAND ----------#

#----- SELECT COMMAND ----#
select * from customer;
select * from vendor;
select * from product;
select * from shipper;
select * from hub;

#----- INSERT COMMAND -----#
insert into vendor(name, address, latitude, longtitude, username, password) values 
('Phuc', 'Ho Chi Minh City', 12, 10, 'phuc123', '123'),
('Dung', 'Hanoi', 15, 101, 'dung123', 'abc'),
('Tri Dang', 'New York', -80, -10, 'tri123', 'ilovecs');

insert into product (name, price, quantity, ven_id) values 
('Iphone X', 300, 5, 'VD001'),
('Iphone 11', 350, 10, 'VD001'),
('Iphone 11 Pro Max', 400, 5, 'VD001'),
('Iphone 12 Pro', 450, 10, 'VD001'),
('Iphone 12 Pro Max', 500, 5, 'VD001'),
('Macbook Air M1', 1500, 10, 'VD001'),
('Macbook Pro M1', 2000, 10, 'VD001'),
('Airpod', 100, 10, 'VD001'),
('Airpod Max', 250, 10, 'VD001'),
('Apple', 10, 100, 'VD002'),
('Banana', 15, 50, 'VD002'),
('Passion Fruit', 17, 80, 'VD002'),
('Raspbery', 5, 50, 'VD002'),
('Grapefruit', 12, 100, 'VD002'),
('Tangerine', 7, 150, 'VD002'),
('Coconut', 20, 100, 'VD002'),
('Pear', 15, 50, 'VD002'),
('Guava', 13, 100, 'VD002'),
('Papaya', 25, 50, 'VD002'),
('Superstar Shoes', 70, 20, 'VD003'),
('Stan Smith Shoes', 75, 50, 'VD003'),
('Ultraboost 2022', 90, 10, 'VD003'),
('Air Max Shoes', 120, 30, 'VD003'),
('Jordan Slipper', 55, 20, 'VD003'),
('Nike Mag', 5000, 5, 'VD003'),
('Jordan 1', 150, 15, 'VD003');


insert into customer(name, address, latitude, longtitude, username, password) values
('Binh', 'Thanh Hoa', 65, 121, 'binh123', '12345'),
('Linh', 'Cu Ba', 50, -100, 'linh123', 'abc123'),
('Hung', 'Thailand', -35, 0, 'hung123', 'hung123');

insert into hub(name, address, latitude, longtitude) values
('Grab', 'Nha Trang', 10, 50),
('Uber', 'My Tho', -10, -20),
('GHTK', 'Ha Noi', 20, -30);

insert into shipper(name, username, password, hub_id) values
('Long', 'long123', 'nguvcl', 'HB001'),
('Tuan', 'tuan123', 'ditme', 'HB002'),
('Ship', 'ship123', 'vailon', 'HB003');

#----- DETELE COMMAND -----#
delete from customer where id = 'CS003';

#----- DISPLAY PRODUCT (NEW TO OLD), LIMIT 2 PER PAGE COMMAND -----#
select * from product order by id desc limit 2;

#----- Function calculate distance based on Lat and Lon ------#
DELIMITER $$
CREATE FUNCTION cal_distance(lat_1 DECIMAL(10,4), lon_1 DECIMAL(10,4), lat_2 DECIMAL(10,4), lon_2 DECIMAL(10,4))
RETURNS DECIMAL(10,4) deterministic
BEGIN
	DECLARE distance DECIMAL(10,4);
    SELECT(111.111 *
    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(lat_1))
	* COS(RADIANS(lat_2))
	* COS(RADIANS(lon_1 - lon_2))
	+ SIN(RADIANS(lat_1))
	* SIN(RADIANS(lat_2)))))) INTO distance;
    RETURN distance;
END $$
DELIMITER ;

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
	WHERE ((select cal_distance(user_lat, user_lon, v.latitude, v.longtitude)) <= input_distance);
END $$
DELIMITER ;

CALL search_vendor_based_on_distance(111.2, 11, 10);

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

#----- trigger alert if order's quantity > stock's quantity ------#
DELIMITER $$
CREATE TRIGGER tg_add_products_on_orders_detail
BEFORE INSERT ON orders_detail
FOR EACH ROW
BEGIN
	DECLARE quantity_in_stock int;
    DECLARE quantity_orders int;
    SELECT quantity into quantity_in_stock from product where id = new.prod_id;
    SELECT new.quantity into quantity_orders;
    IF( quantity_in_stock < quantity_orders) THEN
    SIGNAL SQLSTATE '45000' SET message_text = 'Cannot purchase this orders since it reaches out of quantity in stocks';
    END IF;
END $$
DELIMITER ;

#---- trigger to update price in orders----#
DELIMITER $$
CREATE TRIGGER tg_update_bill
AFTER INSERT ON orders_detail
FOR EACH ROW
BEGIN
	UPDATE orders
    SET bill = (select sum(total_price) from orders_detail where orders_id = NEW.orders_id group by orders_id)
    WHERE id = NEW.orders_id;
END $$
DELIMITER ;


#----- trigger to add product -----#
DELIMITER $$
CREATE TRIGGER tg_add_products
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
	DECLARE ROW_NUM int;
    SELECT count(*) into ROW_NUM from orders;
END $$
DELIMITER ;

#----- Generate random second from 10 to 30 ----#
SELECT SEC_TO_TIME(
	FLOOR(
	TIME_TO_SEC('00:00:10') + RAND() * (
	TIME_TO_SEC(TIMEDIFF('00:00:20', '00:00:00')))));
    
#------ Funtion returns random 10 - 30 seconds -----#
SET GLOBAL log_bin_trust_function_creators = 1;
DELIMITER $$
CREATE FUNCTION random_secs()
RETURNS TIME
BEGIN
	DECLARE rand_secs TIME;
    SELECT SEC_TO_TIME(
	FLOOR(
	TIME_TO_SEC('00:00:10') + RAND() * (
	TIME_TO_SEC(TIMEDIFF('00:00:20', '00:00:00'))))) INTO rand_secs;
    RETURN rand_secs;
END $$
DELIMITER ;

SELECT random_secs(); #---- test function ---#

select cal_distance(11,10,12,10);
