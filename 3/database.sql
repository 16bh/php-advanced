CREATE TABLE sessions (
  id CHAR(32) NOT NULL,
  data TEXT,
  last_accessed TIMESTAMP NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE distance_demo(
  id INT(32) NOT NULL AUTO_INCREMENT,
  longitude double DEFAULT NULL COMMENT '经度',
  atitude double DEFAULT NULL COMMENT '纬度',
  PRIMARY KEY (id)
);

USE cms;
DELIMITER $$
CREATE FUNCTION return_distance(lat_a DOUBLE, long_a DOUBLE, lat_b DOUBLE, long_b DOUBLE) RETURNS DOUBLE
BEGIN
DECLARE distance DOUBLE;
SET distance = SIN(RADIANS(lat_a))*SIN(RADIANS(lat_b))+COS(RADIANS(lat_a))*COS(RADIANS(lat_b))*COS(RADIANS(long_a - long_b));
RETURN ((DEGREES(ACOS(distance)))*69.09);
END $$
DELIMITER ;

SELECT return_distance(32.898131, 120.568189, 31.967509, 120.560454);