DROP DATABASE dazala;
CREATE DATABASE dazala;
USE dazala;

#----- CREATE USER AND ROLE -----#
CREATE USER 'vendor'@'localhost' IDENTIFIED BY 'vendor';
CREATE ROLE vendor;
GRANT SELECT, INSERT, UPDATE, DELETE ON dazala.product TO vendor;
GRANT SELECT, INSERT, UPDATE ON dazala.vendor TO vendor;
GRANT EXECUTE ON PROCEDURE ven_edit_product TO vendor;
GRANT vendor TO 'vendor'@'localhost';

CREATE USER 'customer'@'localhost' IDENTIFIED BY 'customer';
CREATE ROLE customer;
GRANT SELECT, INSERT, DELETE, UPDATE ON dazala.customer TO customer;
GRANT SELECT, UPDATE ON dazala.product TO customer;
GRANT SELECT, INSERT ON dazala.orders TO customer;
GRANT EXECUTE ON PROCEDURE search_product_based_on_name TO customer;
GRANT EXECUTE ON PROCEDURE search_product_based_on_price TO customer;
GRANT EXECUTE ON PROCEDURE search_vendor_based_on_distance TO customer;
GRANT EXECUTE ON FUNCTION cal_distance TO customer;
GRANT EXECUTE ON PROCEDURE cal_nearest_distance TO customer;
GRANT EXECUTE ON PROCEDURE cus_buy_product TO customer;
GRANT customer TO 'customer'@'localhost';

CREATE USER 'shipper'@'localhost' IDENTIFIED BY 'shipper';
CREATE ROLE shipper;
GRANT SELECT, INSERT ON dazala.shipper TO shipper;
GRANT SELECT, UPDATE ON dazala.orders TO shipper;
GRANT SELECT ON dazala.hub TO shipper;
GRANT EXECUTE ON PROCEDURE shipped_orders TO shipper;
GRANT EXECUTE ON PROCEDURE cancel_orders TO shipper;
GRANT shipper TO 'shipper'@'localhost';

SET TRANSACTION ISOLATION LEVEL READ COMMITTED;

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
    quantity INT NOT NULL,
    cus_id VARCHAR(10) NOT NULL,
    hub_id VARCHAR(10) NOT NULL,
    prod_id VARCHAR(10) NOT NULL
);

DELIMITER $$
CREATE TRIGGER tg_orders_insert
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
  DECLARE random_time TIME;
  SELECT random_secs() into random_time;
  #DO SLEEP(random_time);
  INSERT INTO orders_seq VALUES (NULL);
  SET NEW.id = CONCAT('OR', LPAD(LAST_INSERT_ID(), 3, '0'));
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

ALTER TABLE orders
ADD CONSTRAINT FK_orders_prod_id
FOREIGN KEY (prod_id) REFERENCES product(id);

ALTER TABLE orders ALTER quantity SET DEFAULT 1;

ALTER TABLE orders ALTER orders_status SET DEFAULT 'Ready';

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
('Phuc', 'Hai Phong', 20.86, 106.70, 'phuc123', '123'),
('Dung', 'Hanoi', 21.02, 105.85, 'dung123', 'abc'),
('Tri Dang', 'Da Nang', 16.05, 108.22, 'tri123', 'ilovecs');

insert into product (name, price, quantity, ven_id) values 
('Iphone X', 300, 5, 'VD001'),
('Iphone 11', 350, 10, 'VD001'),
('Samsung 10', 400, 5, 'VD001'),
('Xiaomi Tommy', 450, 10, 'VD001'),
('Vertu', 5000, 5, 'VD001'),
('Macbook Air M1', 1500, 10, 'VD001'),
('Macbook Pro M1', 2000, 10, 'VD001'),
('MSI', 1200, 10, 'VD001'),
('Predator', 1250, 10, 'VD001'),
('Apple', 10, 10, 'VD002'),
('Banana', 15, 5, 'VD002'),
('Passion Fruit', 17, 80, 'VD002'),
('Jargermeister', 79, 50, 'VD002'),
('Whiskey', 12, 100, 'VD002'),
('Bubble Tea', 7, 22, 'VD002'),
('Dried Squid', 150, 100, 'VD002'),
('Dried Jackfruit', 190, 50, 'VD002'),
('Black Label', 130, 100, 'VD002'),
('B52 Whiskey', 56, 50, 'VD002'),
('Superstar Shoes', 70, 20, 'VD003'),
('Stan Smith Shoes', 75, 50, 'VD003'),
('Jacket', 90, 10, 'VD003'),
('Coat', 120, 30, 'VD003'),
('Skirt', 200, 20, 'VD003'),
('Nike Hat', 54, 5, 'VD003'),
('Adidas Hat', 57, 15, 'VD003');


insert into customer(name, address, latitude, longtitude, username, password) values
('Binh', 'Thanh Hoa', 19.80, 105.80, 'binh123', '12345'),
('Linh', 'Nha Trang', 12.25, 109.20, 'linh123', 'abc123'),
('Hung', 'Buon Ma Thuot', 12.67, 108.04, 'hung123', 'hung123');

insert into hub(name, address, latitude, longtitude) values
('Grab', 'Nam Dinh', 20.43, 106.17),
('Uber', 'Do Son', 20.67, 106.80),
('GHTK', 'Nghe An', 18.68, 105.67);

insert into shipper(name, username, password, hub_id) values
('Long', 'long123', 'nguvcl', 'HB001'),
('Tuan', 'tuan123', 'ditme', 'HB002'),
('Ship', 'ship123', 'vailon', 'HB003');

#----- DETELE COMMAND -----#

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

#--- FUNCTION RETURNS HUB ID NEAREST TO THE CUSTOMER ---#
DELIMITER $$
CREATE PROCEDURE cal_nearest_distance(IN buyer_id varchar(10))
BEGIN
	DECLARE nearest_hub_id VARCHAR(10);
    DECLARE lat_prod_customer DECIMAL(10,4);
	DECLARE lon_prod_customer DECIMAL(10,4);
	SELECT latitude INTO lat_prod_customer FROM customer WHERE id = buyer_id;
    SELECT longtitude INTO lon_prod_customer FROM customer WHERE id = buyer_id;
    SELECT id INTO nearest_hub_id FROM hub WHERE cal_distance(lat_prod_customer,lon_prod_customer, latitude, longtitude) IN (SELECT MIN(cal_distance(lat_prod_customer,lon_prod_customer, latitude, longtitude)) FROM HUB);
    SELECT * FROM hub WHERE id = nearest_hub_id;
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

DELIMITER $$
CREATE PROCEDURE search_product_based_on_price(IN input_product_price_start decimal(14,2), IN input_product_price_end decimal(14,2))
BEGIN
    SELECT * FROM PRODUCT WHERE PRICE BETWEEN input_product_price_start AND input_product_price_end;
END $$
DELIMITER ;

#------- Search vendor based on distance ------#
DELIMITER $$
CREATE PROCEDURE search_vendor_based_on_distance(IN input_distance decimal(10,4), IN user_lat decimal(10,4), IN user_lon decimal(10,4))
BEGIN
	SELECT *, cal_distance(user_lat, user_lon, v.latitude, v.longtitude) as distance FROM vendor v
	WHERE ((select cal_distance(user_lat, user_lon, v.latitude, v.longtitude)) <= input_distance);
END $$
DELIMITER ;

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

#----- trigger to update quantity after buy a product -----#
DELIMITER $$
CREATE TRIGGER tg_update_quantity
AFTER INSERT ON orders
FOR EACH ROW
BEGIN
	DECLARE prod_quantity int;
    SELECT quantity into prod_quantity from product where id = NEW.prod_id;
    UPDATE product 
    SET quantity = prod_quantity - 1 
    WHERE id = NEW.prod_id AND prod_quantity > 0;
END $$
DELIMITER ;

#----- trigger to update quantity after cancel order -----#
DELIMITER $$
CREATE TRIGGER tg_update_quantity_prod_after_cancel
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
	DECLARE prod_quantity int;
    SELECT quantity into prod_quantity from product where id = NEW.prod_id;
    IF(NEW.orders_status = 'Cancelled') THEN
    UPDATE product 
    SET quantity = prod_quantity + 1 
    WHERE id = NEW.prod_id AND prod_quantity > 0;
    END IF;
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

#----- Store procedure for edit product -----#
DELIMITER $$
CREATE PROCEDURE ven_edit_product(IN new_price DECIMAL(14,2), IN new_quantity INT, IN prod_id VARCHAR(10))
BEGIN
	START TRANSACTION;
    UPDATE product SET price = new_price, quantity = new_quantity WHERE id = prod_id;
    COMMIT;
END $$
DELIMITER ;

#----- Store procedure for buy product -----#
DELIMITER $$
CREATE PROCEDURE cus_buy_product(IN new_bill DECIMAL(14,2), IN new_hub_id VARCHAR(10), IN new_cus_id VARCHAR(10), IN new_prod_id VARCHAR(10))
BEGIN
	START TRANSACTION;
    INSERT INTO orders (bill, hub_id, cus_id, prod_id) VALUE (new_bill, new_hub_id, new_cus_id, new_prod_id);
    COMMIT;
END $$
DELIMITER ;

#----- Procedure finish order -----#
DELIMITER $$
CREATE PROCEDURE shipped_orders(IN orders_id VARCHAR(10))
BEGIN
	UPDATE orders SET orders_status = 'Shipped' WHERE id = orders_id;
END $$
DELIMITER ;

#----- Procedure cancel order -----#
DELIMITER $$
CREATE PROCEDURE cancel_orders(IN orders_id VARCHAR(10))
BEGIN
	UPDATE orders SET orders_status = 'Cancelled' WHERE id = orders_id;
END $$
DELIMITER ;
