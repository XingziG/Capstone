drop trigger add_new_patients_report;
drop table reports;
drop table activ_role;
drop table roles;
drop table activities;
drop table patients;
drop table users;

CREATE TABLE users (
user_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
name VARCHAR(100) NOT NULL,
email VARCHAR(60) NOT NULL,
pass CHAR(40) NOT NULL,
PRIMARY KEY (user_id)
);

CREATE TABLE patients (
patient_id VARCHAR(100) NOT NULL,
patient_fname VARCHAR(50) NOT NULL,
patient_lname VARCHAR(50) NOT NULL,
birthdate DATETIME NOT NULL,
checkin DATETIME NOT NULL,
checkout DATETIME,
gender VARCHAR(6) NOT NULL,
diabetes VARCHAR(3) NOT NULL,
insurance VARCHAR(25) NOT NULL,
direct_material INT UNSIGNED,
over_head INT UNSIGNED,
PRIMARY KEY (patient_id)
);

CREATE TABLE activities (
activity_id SMALLINT UNSIGNED NOT NULL,
acticity_name VARCHAR(100) NOT NULL,
/*'s' or 'po'*/
activity_category CHAR(7) NOT NULL,
PRIMARY KEY (activity_id)
);

CREATE TABLE roles (
role_id SMALLINT UNSIGNED NOT NULL,
role_name VARCHAR(100) NOT NULL,
salary INT UNSIGNED NOT NULL,
PRIMARY KEY (role_id)
);

CREATE TABLE activ_role (
activity_id SMALLINT UNSIGNED NOT NULL,
role_id SMALLINT UNSIGNED NOT NULL,
activity_default_time MEDIUMINT UNSIGNED NOT NULL,
/*the activity day is '0', '1', 'n' or 'd'*/
activity_day CHAR(1) NOT NULL,
PRIMARY KEY (activity_id, role_id, activity_day),
FOREIGN KEY (activity_id) REFERENCES activities (activity_id) 
ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (role_id) REFERENCES roles (role_id) 
ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE reports (
report_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
freq INT UNSIGNED NOT NULL,
time_duration MEDIUMINT UNSIGNED NOT NULL,
performer VARCHAR(100) NOT NULL,
patient_id VARCHAR(100) NOT NULL,
activity_id SMALLINT UNSIGNED NOT NULL,
activity_day CHAR(1) NOT NULL,
role_id SMALLINT UNSIGNED NOT NULL,
PRIMARY KEY (report_id),
FOREIGN KEY (patient_id) REFERENCES patients (patient_id) 
ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (activity_id) REFERENCES activities (activity_id) 
ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (role_id) REFERENCES roles (role_id) 
ON DELETE NO ACTION ON UPDATE NO ACTION
);

/* trigger begin */
delimiter //
CREATE TRIGGER add_new_patients_report
AFTER INSERT ON patients FOR EACH ROW
BEGIN 
    DECLARE aid  SMALLINT UNSIGNED;
    DECLARE done INT DEFAULT 0;
    DECLARE rid  SMALLINT UNSIGNED;
    DECLARE aday CHAR(1);
    DECLARE tdr  MEDIUMINT UNSIGNED;
    DECLARE c1   CURSOR for 
        SELECT activity_id, role_id, activity_default_time, activity_day FROM activ_role;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    OPEN c1;
    read_loop: LOOP
        FETCH c1 INTO aid, rid, tdr, aday;
        IF done THEN
            LEAVE read_loop;
        END IF;
        INSERT INTO reports (patient_id, activity_id, role_id, time_duration, freq, activity_day, performer) 
        VALUES (NEW.patient_id, aid, rid, tdr, 0, aday ,'');
        END LOOP;
        CLOSE c1;
END;
//
delimiter ;
/* trigger end */

