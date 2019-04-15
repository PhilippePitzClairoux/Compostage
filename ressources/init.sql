
DROP DATABASE IF EXISTS Compostage;

CREATE DATABASE Compostage;

USE Compostage;


CREATE TABLE permissions(
    permission_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    permission_name VARCHAR(64) NOT NULL,
    description VARCHAR(512) NOT NULL
);

CREATE TABLE user_type (
    user_type_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_type_name VARCHAR(64) NOT NULL,
    user_type_description VARCHAR(256)
);

CREATE TABLE users (
    username VARCHAR(64) NOT NULL PRIMARY KEY,
    user_type_id INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(user_type_id) REFERENCES user_type(user_type_id)
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
    bed_id INT NOT NULL,
    raspberry_pi_type VARCHAR(64) NOT NULL,
    raspberry_pi_aquisition_date DATETIME NOT NULL,
    raspberry_pi_capacity INT NOT NULL,
    CONSTRAINT FOREIGN KEY(zone_id) REFERENCES zone(zone_id),
    CONSTRAINT FOREIGN KEY(bed_id) REFERENCES bed(bed_id),
    CONSTRAINT FOREIGN KEY(raspberry_pi_type) REFERENCES raspberry_pi_type(raspberry_pi_type)
);


CREATE TABLE alert_configuration (
    alert_configuration_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    alert_configuration_message VARCHAR(64) NOT NULL,
    alert_configuration_min_value INT NOT NULL,
    alert_configuration_max_value INT NOT NULL
);

CREATE TABLE senosr_state (
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
    sensor_alert_configuration_id INT NOT NULL,
    sensor_aquisition_date DATE NOT NULL,
    sensor_serial_number VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(sensor_type_id) REFERENCES sensor_type(sensor_type_id),
    CONSTRAINT FOREIGN KEY(sensor_state_id) REFERENCES sensor_type(sensor_type_id),
    CONSTRAINT FOREIGN KEY(sensor_alert_configuration_id) REFERENCES  alert_configuration(alert_configuration_id)
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
    permission_id INT NOT NULL,
    username VARCHAR(64) NOT NULL,
    CONSTRAINT FOREIGN KEY(permission_id) REFERENCES permissions(permission_id),
    CONSTRAINT FOREIGN KEY(username) REFERENCES users(username),
    CONSTRAINT PRIMARY KEY(permission_id, username)
);