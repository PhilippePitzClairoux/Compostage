
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
    auth_question VARCHAR(1024) NOT NULL,
    auth_answer VARCHAR(255) NOT NULL,
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
    sensor_state_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sensor_state VARCHAR(64) NOT NULL
);

CREATE TABLE sensor_type (
  sensor_type_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  sensor_type_name VARCHAR(64) NOT NULL
);

CREATE TABLE alert_type (
  alert_type_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  alert_type_name VARCHAR(255) NOT NULL
);

CREATE TABLE measure_type (
  measure_type_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
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

CREATE TABLE ta_alert_event (
  alert_type_id INT NOT NULL,
  measure_id INT NOT NULL,
  alert_timestamp TIMESTAMP NOT NULL,
  CONSTRAINT FOREIGN KEY(alert_type_id) REFERENCES alert_type(alert_type_id),
  CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measures(measure_id),
  CONSTRAINT PRIMARY KEY(alert_type_id, measure_id)
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

INSERT INTO users(username, user_type_id, password, email, auth_question, auth_answer)
VALUES ("admin", "admin", "$2y$10$ZIaeQm9egZQLh0h7u2WUpuMSbUZprck3/sWFkyuFLDfpc9OpTv.ia", "test@gmail.com", "hehe?", "$2y$10$Mrv.jrNC6NNNyFaa5OBwWeAuGmd7XLvNXWSxMs0k8CVQV5NLs1FEC"), -- password is : test (blowfish + salt)
       ("raspberry_pi", "raspberry_pi", "$2y$10$ZIaeQm9egZQLh0h7u2WUpuMSbUZprck3/sWFkyuFLDfpc9OpTv.ia", "raspberry@test.com", "hehe?", "$2y$10$Mrv.jrNC6NNNyFaa5OBwWeAuGmd7XLvNXWSxMs0k8CVQV5NLs1FEC"); -- answer is : hehexd


INSERT INTO bed(bed_name) VALUES ("ALPHA"), ("BRAVO"), ("BOB"), ("ANTOINE");
INSERT INTO zone(bed_id, zone_name) VALUES (1, "UNO"), (1, "DOS"), (1, "TRES"), (2, "UNO"), (2, "DOS"), (3, "TRES");

INSERT INTO raspberry_pi_type(raspberry_pi_type, raspberry_pi_type_description)
VALUE ("MODEL_3", "This is the current last gen of raspberry pi's.");

INSERT INTO raspberry_pi(zone_id, user_id, raspberry_pi_type, raspberry_pi_aquisition_date, raspberry_pi_capacity)
VALUES (1, "raspberry_pi", "MODEL_3", "2019-04-24", 32);


INSERT INTO alert_configuration(alert_configuration_message, alert_configuration_min_value, alert_configuration_max_value)
VALUES ("Oh noo! Looks like Bed#%i is below the normal amount of ph!", 5.5, NULL);

INSERT INTO alert_configuration(alert_configuration_message, alert_configuration_min_value, alert_configuration_max_value)
VALUES ("Oh noo! Looks like Bed#%i is below the normal tempature!", 15, NULL);

INSERT INTO alert_configuration(alert_configuration_message, alert_configuration_min_value, alert_configuration_max_value)
VALUES ("Oh noo! Looks like Bed#%i has a high amount of humidity!", NULL, 0.40);

INSERT INTO sensor_type(sensor_type_name) VALUES ("PH_SENOSR"), ("HUMIDITY_SENSOR"), ("TEMPATURE_SENSOR");
INSERT INTO sensor_state(sensor_state) VALUES ("WORKING"), ("BROKEN"), ("NEEDS_CHECKUP");

INSERT INTO measure_type(measure_type_name) VALUES ("PH"), ("HUMIDITY"), ("TEMPATURE");

INSERT INTO sensor(sensor_type_id, sensor_state_id, raspberry_pi_id, sensor_aquisition_date, sensor_serial_number)
VALUES (1, 1, 1, "2019-04-24 11:06:23", "666-696969-666");

INSERT INTO update_state(update_state, update_state_description) VALUES ("pending", "Not ready to be deployed"), ("done", "update is completely deployed");
INSERT INTO `update`(update_state_id, update_name, update_date) VALUES (2, "LmaoXD", "2019-05-06");
INSERT INTO `update`(update_state_id, update_name, update_date) VALUES (1, "OOF", "2019-02-22");

INSERT INTO update_completed(update_id, raspberry_pi_id) VALUES (1, 1);
INSERT INTO update_completed(update_id, raspberry_pi_id) VALUES (2, 1);