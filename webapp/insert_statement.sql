/* roles table */
INSERT INTO roles (role_id, role_name, salary) VALUES (1,'Anesthesiologist',180000);
INSERT INTO roles (role_id, role_name, salary) VALUES (2,'Cardiologist',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (3,'Cardiovascular Surgeon',600000);
INSERT INTO roles (role_id, role_name, salary) VALUES (4,'Case Manager',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (5,'Endocrinologist',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (6,'Housekeeping',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (7,'IC Doctor',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (8,'Registered Nurse',120000);
INSERT INTO roles (role_id, role_name, salary) VALUES (9,'Occupational Therapist',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (10,'Physician Assistant',72000);
INSERT INTO roles (role_id, role_name, salary) VALUES (11,'Physical Therapist',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (12,'Respiratory Therapist',50000);
INSERT INTO roles (role_id, role_name, salary) VALUES (13,'Scub Tech',42000);
INSERT INTO roles (role_id, role_name, salary) VALUES (14,'Perfusionist',50000);

/* activities table */
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (1,'Transesophaegal Echocardiogram','S');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (2,'Pre-Surgical Procedures','S');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (3,'Scavenging of the Saphenous Vein','S');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (4,'Median Sternotomy','S');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (5,'Grafting','S');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (6,'Surgery Completion to OR Departure','S');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (7,'Sit with the patient','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (8,'Check vitals','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (9,'Administer medication','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (10,'X-Ray and EKG','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (11,'Provide meals','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (12,'Monitor Intake and Output','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (13,'Walk the patient','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (14,'Family education','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (15,'Bathe the patient','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (16,'Place orders for patient\'s medication','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (17,'Check Lab Results','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (18,'Write discharge summary','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (19,'Connect ventilator','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (20,'Extubation process','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (21,'Plan and review patient\'s case','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (22,'Talk to Family/Social Workers','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (23,'Stand patient','PO');
INSERT INTO activities (activity_id, acticity_name, activity_category) VALUES (24,'Talk to patient and nurse','PO');

/* activ_role table */
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (1,1,90,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (1,10,45,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (2,13,90,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (2,10,45,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (2,8,90,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (3,10,90,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (4,3,90,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (4,13,90,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (5,3,180,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (5,10,180,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (5,13,180,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (6,8,60,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (6,10,60,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (6,1,60,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (7,8,960,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (8,8,5,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (8,8,5,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (8,8,5,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (9,8,15,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (9,8,15,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (9,8,10,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (10,8,15,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (10,8,15,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (10,8,15,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (12,8,240,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (12,8,60,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (12,8,20,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (16,10,10,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (17,10,5,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (17,10,5,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (18,10,75,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (20,12,15,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (21,4,20,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (21,4,20,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (22,4,120,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (11,8,15,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (11,8,15,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (11,8,15,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (23,8,30,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (23,8,30,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (23,8,30,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (13,8,20,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (13,8,20,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (13,8,20,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (14,8,15,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (14,8,15,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (14,8,90,'d');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (15,8,60,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (15,8,60,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (16,10,10,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (16,10,10,'n');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (19,12,15,'0');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (24,10,15,'1');
INSERT INTO activ_role (activity_id, role_id, activity_default_time, activity_day) VALUES (24,10,15,'n');

/* patients table */
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(1,'Ayesha','Leona',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-04-07', '%Y-%m-%d'), STR_TO_DATE('2015-08-11', '%Y-%m-%d'),'M','N','others');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(2,'Zetta','Ronny',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2012-07-05', '%Y-%m-%d'), STR_TO_DATE('2012-07-09', '%Y-%m-%d'),'M','N','others');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(3,'Alton','Shad',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2013-10-18', '%Y-%m-%d'), STR_TO_DATE('2013-11-08', '%Y-%m-%d'),'M','N','bluecross');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(4,'Wanda','Taneka',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2013-04-27', '%Y-%m-%d'), STR_TO_DATE('2013-05-06', '%Y-%m-%d'),'M','N','securityblue');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(5,'Tiffany','Phillip',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-09-08', '%Y-%m-%d'), STR_TO_DATE('2015-09-15', '%Y-%m-%d'),'M','N','medicare');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(6,'Marna','Antony',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2014-11-05', '%Y-%m-%d'), STR_TO_DATE('2014-11-11', '%Y-%m-%d'),'M','N','securityblue');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(7,'Dwayne','Smith',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-03-20', '%Y-%m-%d'), STR_TO_DATE('2015-03-26', '%Y-%m-%d'),'M','N','securityblue');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(8,'Talia','Mayme',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-08-06', '%Y-%m-%d'), STR_TO_DATE('2015-08-11', '%Y-%m-%d'),'M','N','adventra');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(9,'Irmgard','Yvette',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2014-10-23', '%Y-%m-%d'), STR_TO_DATE('2014-10-28', '%Y-%m-%d'),'M','N','medicare');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(10,'Eden','Saul',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-08-06', '%Y-%m-%d'), STR_TO_DATE('2015-08-11', '%Y-%m-%d'),'M','N','others');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(11,'Lizzie','Dante',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2014-12-03', '%Y-%m-%d'), STR_TO_DATE('2014-12-20', '%Y-%m-%d'),'M','N','securityblue');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(12,'Zoe','Ignacia',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-08-10', '%Y-%m-%d'), STR_TO_DATE('2015-08-18', '%Y-%m-%d'),'M','N','bluecross');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(13,'Kerrie','Mertie',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-08-06', '%Y-%m-%d'), STR_TO_DATE('2015-08-11', '%Y-%m-%d'),'M','N','adventra');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(14,'Jacquetta', 'Gerald', STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2012-04-25', '%Y-%m-%d'), STR_TO_DATE('2012-05-02', '%Y-%m-%d'),'M','N','medicare');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(15,'Daophine','Velvet',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-05-07', '%Y-%m-%d'), STR_TO_DATE('2015-05-11', '%Y-%m-%d'),'M','N','advantra');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(16,'Leeanna','Irene',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2012-09-30', '%Y-%m-%d'), STR_TO_DATE('2012-10-04', '%Y-%m-%d'),'M','N','securityblue');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(17,'Daina','Lecia',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2012-10-17', '%Y-%m-%d'), STR_TO_DATE('2012-11-04', '%Y-%m-%d'),'M','N','bluecross');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(18,'Anika','Isidro',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-10-17', '%Y-%m-%d'), STR_TO_DATE('2015-10-22', '%Y-%m-%d'),'M','N','securityblue');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(19,'Karey','Rheba',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-08-26', '%Y-%m-%d'), STR_TO_DATE('2015-08-30', '%Y-%m-%d'),'M','N','medicare');
INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, checkout, gender, diabetes, insurance) VALUES(20,'Buster','Adah',STR_TO_DATE('1941-11-08', '%Y-%m-%d'), STR_TO_DATE('2015-03-29', '%Y-%m-%d'), STR_TO_DATE('2015-04-03', '%Y-%m-%d'),'M','N','medicare');