CREATE DATABASE dazala;
DROP DATABASE dazala;
USE dazala;

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
ADD CONSTRAINT FK_product_ven_id FOREIGN KEY (ven_id) REFERENCES vendor(id);
    
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

select v.name, p.name, p.price from vendor v join product p on v.id = p.ven_id ;



