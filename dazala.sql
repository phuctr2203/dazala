CREATE DATABASE dazala;

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
    password VARCHAR(16) NOT NULL
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
value ('aa', 'Ho Chi Minh City', 10, 10, 'phuc123', '123');


select * from vendor;
