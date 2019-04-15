
DROP DATABASE IF EXISTS Compostage;

CREATE DATABASE Compostage;

USE Compostage;


CREATE TABLE permissions(
    permission_name VARCHAR(64) NOT NULL PRIMARY KEY ,
    permission_description VARCHAR(512) NOT NULL
);

CREATE TABLE user_type (
    user_type_name VARCHAR(64) NOT NULL PRIMARY KEY ,
    user_type_description VARCHAR(256)
);

CREATE TABLE users (
    username VARCHAR(64) NOT NULL PRIMARY KEY,
    user_type_id VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(user_type_id) REFERENCES user_type(user_type_name)
);

CREATE TABLE bed(
    bed_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bed_name VARCHAR(64) NOT NULL
);

CREATE TABLE zone (
    zone_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bed_id INT NOT NULL,
    zone_name VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(bed_id) REFERENCES bed(bed_id)
);

CREATE TABLE update_state (
    update_state_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    update_state VARCHAR(64) NOT NULL,
    update_state_description VARCHAR(255) NOT NULL
);

CREATE TABLE `update` (
    update_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    update_state_id INT NOT NULL,
    update_name VARCHAR(64) NOT NULL,
    update_date DATETIME NOT NULL,
    CONSTRAINT FOREIGN KEY(update_state_id) REFERENCES update_state(update_state_id)
);

CREATE TABLE raspberry_pi_type (
    raspberry_pi_type VARCHAR(64) NOT NULL PRIMARY KEY,
    raspberry_pi_type_description VARCHAR(255) NOT NULL
);

CREATE TABLE raspberry_pi (
    raspberry_pi_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    zone_id INT NOT NULL,
    user_id VARCHAR(64) NOT NULL,
    raspberry_pi_type VARCHAR(64) NOT NULL,
    raspberry_pi_aquisition_date DATE NOT NULL,
    raspberry_pi_capacity INT NOT NULL,
    CONSTRAINT FOREIGN KEY(zone_id) REFERENCES zone(zone_id),
    CONSTRAINT FOREIGN KEY(raspberry_pi_type) REFERENCES raspberry_pi_type(raspberry_pi_type),
    CONSTRAINT FOREIGN KEY(user_id) REFERENCES users(username)
);


CREATE TABLE alert_configuration (
    alert_configuration_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    alert_configuration_message VARCHAR(64) NOT NULL,
    alert_configuration_min_value FLOAT,
    alert_configuration_max_value FLOAT
);

CREATE TABLE sensor_state (
    sensor_state_id INT NOT NULL PRIMARY KEY,
    sensor_state VARCHAR(64) NOT NULL
);

CREATE TABLE sensor_type (
  sensor_type_id INT NOT NULL PRIMARY KEY,
  sensor_type_name VARCHAR(64) NOT NULL
);

CREATE TABLE alert_type (
  alert_type_id INT NOT NULL PRIMARY KEY,
  alert_type_name VARCHAR(255) NOT NULL
);

CREATE TABLE measure_type (
  measure_type_id INT NOT NULL PRIMARY KEY  AUTO_INCREMENT,
  measure_type_name VARCHAR(255) NOT NULL
);

CREATE TABLE sensor (
    sensor_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sensor_type_id INT NOT NULL,
    sensor_state_id INT NOT NULL,
    raspberry_pi_id INT NOT NULL,
    sensor_aquisition_date DATE NOT NULL,
    sensor_serial_number VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(sensor_type_id) REFERENCES sensor_type(sensor_type_id),
    CONSTRAINT FOREIGN KEY(sensor_state_id) REFERENCES sensor_state(sensor_state_id),
    CONSTRAINT FOREIGN KEY(raspberry_pi_id) REFERENCES raspberry_pi(raspberry_pi_id)
);

CREATE TABLE measures(
    measure_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sensor_id INT NOT NULL,
    measure_timestamp DATETIME NOT NULL,
    CONSTRAINT FOREIGN KEY(sensor_id) REFERENCES sensor(sensor_id)
);
CREATE TABLE alert_event (
  alert_event_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  alert_type_id INT NOT NULL,
  measure_id INT NOT NULL,
  CONSTRAINT FOREIGN KEY(alert_type_id) REFERENCES alert_type(alert_type_id),
  CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measures(measure_id)
);

CREATE TABLE ta_sensor_alerts(
  alert_configuration_id INT NOT NULL,
  sensor_id INT NOT NULL,
  CONSTRAINT FOREIGN KEY(alert_configuration_id) REFERENCES alert_configuration(alert_configuration_id),
  CONSTRAINT FOREIGN KEY(sensor_id) REFERENCES sensor(sensor_id),
  CONSTRAINT PRIMARY KEY(alert_configuration_id, sensor_id)
);

CREATE TABLE ta_measure_type (
  measure_id INT NOT NULL,
  measure_type_id INT NOT NULL,
  measure_value FLOAT NOT NULL,
  CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measures(measure_id),
  CONSTRAINT FOREIGN KEY(measure_type_id) REFERENCES measure_type(measure_type_id),
  CONSTRAINT PRIMARY KEY(measure_id, measure_type_id)

);

CREATE TABLE update_completed (
    update_id INT NOT NULL,
    raspberry_pi_id INT NOT NULL,
    CONSTRAINT FOREIGN KEY(update_id) REFERENCES `update`(update_id),
    CONSTRAINT FOREIGN KEY(raspberry_pi_id) REFERENCES raspberry_pi(raspberry_pi_id),
    CONSTRAINT PRIMARY KEY(update_id, raspberry_pi_id)
);

CREATE TABLE ta_users_permissions (
    permission VARCHAR(64) NOT NULL,
    user_type VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(permission) REFERENCES permissions(permission_name),
    CONSTRAINT FOREIGN KEY(user_type) REFERENCES user_type(user_type_name),
    CONSTRAINT PRIMARY KEY(permission, user_type)
);

INSERT INTO permissions(permission_name, permission_description) VALUES ("read", "read data from the system");
INSERT INTO permissions(permission_name, permission_description) VALUES ("write", "write data in the system");
INSERT INTO permissions(permission_name, permission_description) VALUES ("manage", "can edit what he wants");

INSERT INTO user_type(user_type_name, user_type_description) VALUES ("admin", "This user can do what he please");
INSERT INTO user_type(user_type_name, user_type_description) VALUES ("visitor", "This user can only see data");
INSERT INTO user_type(user_type_name, user_type_description) VALUES ("normal", "This user can do more than a visitor but less than an admin");
INSERT INTO user_type(user_type_name, user_type_description) VALUES ("raspberry_pi", "this user can only write data");

INSERT INTO ta_users_permissions(permission, user_type) VALUES ("manage", "admin"), ("read", "visitor"), ("read", "normal"), ("write", "normal"), ("write", "raspberry_pi");

INSERT INTO users(username, user_type_id, password, email) VALUES ("admin", "admin",
                                                                   "12ABCCS$92e47e0d0452c988e715c774193a307eaa13dedcb03110613ffe400c2c69daf2",
                                                                   "test@gmail.com"); -- password is : test (sha256, passwd + salt)

INSERT INTO alert_configuration(alert_configuration_message, alert_configuration_min_value, alert_configuration_max_value)
VALUES ("Oh noo! Looks like Bed#%i is below the normal amount of ph!", 5.5, NULL);

INSERT INTO alert_configuration(alert_configuration_message, alert_configuration_min_value, alert_configuration_max_value)
VALUES ("Oh noo! Looks like Bed#%i is below the normal tempature!", 15, NULL);

INSERT INTO alert_configuration(alert_configuration_message, alert_configuration_min_value, alert_configuration_max_value)
VALUES ("Oh noo! Looks like Bed#%i is has a high amount of humidity!", NULL, 0.40);