/* This trigger automatically generates new records
into reports table for each newly generated patient */

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