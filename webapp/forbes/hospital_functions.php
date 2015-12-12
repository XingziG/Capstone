<?php
/**
 * Get cost for hospital report
 * @param $type
 */
function get_cost($type)
{
    require "../mysqli_connect.php"; // Connect to the db.

    if ($type=='sg') {
        $q = "SELECT role_name AS 'role', TRUNCATE(AVG(per_hour_salary * total),2) AS 'cost' FROM
                  ((SELECT
                      (CASE
                            WHEN activity_day = 'd' THEN total_time * d
                            ELSE total_time
                       END) AS total,role_id FROM
                    (SELECT (freq*time_duration) as total_time, role_id, patient_id, activity_day FROM reports WHERE activity_id<=6) AS R
                    INNER JOIN
                    (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as d FROM patients WHERE checkout IS NOT NULL) AS cPatients ON R.patient_id = cPatients.patient_id) AS Rep
                    INNER JOIN
                    (SELECT role_id, role_name, (salary/124800) AS per_hour_salary FROM `roles`) AS phSalary ON Rep.role_id = phSalary.role_id)
                GROUP BY role_name";
    } else if ($type=='po') {
        $q = "SELECT role_name AS 'role', TRUNCATE(AVG(per_hour_salary * total),2) AS 'cost' FROM
                  ((SELECT
                      (CASE
                            WHEN activity_day = 'd' THEN total_time * d
                            ELSE total_time
                       END) AS total,role_id FROM
                    (SELECT (freq*time_duration) as total_time, role_id, patient_id, activity_day FROM reports WHERE activity_id>6) AS R
                    INNER JOIN
                    (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as d FROM patients WHERE checkout IS NOT NULL) AS cPatients ON R.patient_id = cPatients.patient_id) AS Rep
                    INNER JOIN
                    (SELECT role_id, role_name, (salary/124800) AS per_hour_salary FROM `roles`) AS phSalary ON Rep.role_id = phSalary.role_id)
                GROUP BY role_name";
    } else {
        $q = "SELECT role_name AS 'role', TRUNCATE(AVG(per_hour_salary * total),2) AS 'cost' FROM
                  ((SELECT
                      (CASE
                            WHEN activity_day = 'd' THEN total_time * d
                            ELSE total_time
                       END) AS total,role_id FROM
                    (SELECT (freq*time_duration) as total_time, role_id, patient_id, activity_day FROM reports) AS R
                    INNER JOIN
                    (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as d FROM patients WHERE checkout IS NOT NULL) AS cPatients ON R.patient_id = cPatients.patient_id) AS Rep
                    INNER JOIN
                    (SELECT role_id, role_name, (salary/124800) AS per_hour_salary FROM `roles`) AS phSalary ON Rep.role_id = phSalary.role_id)
                GROUP BY role_name";
    }
    $r = @mysqli_query($dbc, $q);  // run query
    while ($row = mysqli_fetch_assoc($r)) {
        $output = "<tr><td>" . $row['role'] . "</td><td><span class=\"" . $type . "\" name=\"" . $row['role'] . "\">" . $row['cost'] . "</span></td></tr>";
        echo $output;
    }
    mysqli_close($dbc);
}

/**
 * Get value for hospital report
 * @param $graph: cost or stay
 * @param $input: hospital, diabetes, insurance or age
 * @param $bar: different bars for each category
 * @return string: average cost value or duration
 */
function get_value($graph, $input, $bar) {
    require ('../mysqli_connect.php'); // Connect to the db.

    if ($graph == "cost") {
        if ($input == "avg") { // get hospital wide cost
            if ($bar == "hospital") {
                $q = "SELECT AVG(d.total) AS 'result' FROM
                    (SELECT a.patient_id, SUM(a.freq * a.time_duration * b.salary / 124800 *
		                    (CASE
			                     WHEN a.activity_day = 'd' THEN c.d
			                     ELSE 1
                             END)) AS 'total'
                     FROM   reports a
		             INNER JOIN (SELECT role_id, salary FROM roles) b ON a.role_id=b.role_id
                     INNER JOIN (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as 'd' FROM patients WHERE checkout IS NOT NULL) c ON a.patient_id=c.patient_id
                     GROUP BY patient_id) d";
            } else { // get reimbursement

            }
        } else if ($input == "diabetes") {
            $q = "SELECT AVG(d.total) AS 'result' FROM
                    (SELECT a.patient_id, SUM(a.freq * a.time_duration * b.salary / 124800 *
		                    (CASE
			                     WHEN a.activity_day = 'd' THEN c.d
			                     ELSE 1
                             END)) AS 'total'
                     FROM   reports a
		             INNER JOIN (SELECT role_id, salary FROM roles) b ON a.role_id=b.role_id
                     INNER JOIN (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as 'd' FROM patients WHERE checkout IS NOT NULL AND diabetes='$bar') c ON a.patient_id=c.patient_id
                     GROUP BY patient_id) d";
        } else if ($input == "insurance") {
            $q = "SELECT AVG(d.total) AS 'result' FROM
                (SELECT a.patient_id, SUM(a.freq * a.time_duration * b.salary / 124800 *
                        (CASE
                             WHEN a.activity_day = 'd' THEN c.d
                             ELSE 1
                         END)) AS 'total'
                 FROM   reports a
                 INNER JOIN (SELECT role_id, salary FROM roles ) b ON a.role_id=b.role_id
                 INNER JOIN (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as 'd' FROM patients
                             WHERE checkout IS NOT NULL AND insurance='$bar') c ON a.patient_id=c.patient_id
                 GROUP BY patient_id) d";
        } else { // age
            switch($bar){
                case "1":
                    $start = 0; $end = 35; break;
                case "2":
                    $start = 35; $end = 65; break;
                default:
                    $start = 65; $end = 200; break;
            }
            $q = "SELECT IFNULL(AVG(d.total),0) AS 'result' FROM
                (SELECT a.patient_id, SUM(a.freq * a.time_duration * b.salary / 124800 *
                        (CASE
                             WHEN a.activity_day = 'd' THEN c.d
                             ELSE 1
                         END)) AS 'total' 
                 FROM   reports a
                 INNER JOIN (SELECT role_id, salary FROM roles ) b ON a.role_id=b.role_id
                 INNER JOIN (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as 'd' FROM patients 
                             WHERE checkout IS NOT NULL AND TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN $start AND $end) c ON a.patient_id=c.patient_id
                 GROUP BY patient_id) d";  
        }
    } else { // stay
        if ($input == "avg") { // get stay
            if ($bar == "hospital") { // hospital stay
                $q = "SELECT AVG(DATEDIFF(checkout, checkin)) as 'result' FROM patients WHERE checkout IS NOT NULL";
            } else { // national stay

            }
        } else if ($input == "diabetes") { // diabetes
            $q = "SELECT AVG(DATEDIFF(checkout, checkin)) as 'result' FROM patients WHERE checkout IS NOT NULL AND diabetes='$bar'";
        } else if ($input == "insurance") {
            $q = "SELECT AVG(DATEDIFF(checkout, checkin)) as 'result' FROM patients WHERE checkout IS NOT NULL AND insurance='$bar'";
        } else { // age
            switch($bar){
                case "1":
                    $start = 0; $end = 35; break;
                case "2":
                    $start = 35; $end = 65; break;
                default:
                    $start = 65; $end = 200; break;
            }
            $q = "SELECT IFNULL(AVG(DATEDIFF(checkout, checkin)),0) as 'result' FROM patients 
                  WHERE checkout IS NOT NULL AND TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN $start AND $end";
        }
    }
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) == 1) { // ok
        $row = mysqli_fetch_array($r);
        $result = $row['result'];
        return $result;
    } else {
        return "error:";
    }
    mysqli_close($dbc);
}

function get_all_dm() {
    require ('../mysqli_connect.php'); // Connect to the db.
    $q = "SELECT SUM(direct_material) AS 'result' FROM patients";
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) == 1) { // ok
        $row = mysqli_fetch_array($r);
        $result = $row['result'];
        return $result;
    } else {
        return "error:";
    }
    mysqli_close($dbc);
}

function get_all_oh() {
    require ('../mysqli_connect.php'); // Connect to the db.
    $q = "SELECT SUM(over_head) AS 'result' FROM patients";
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) == 1) { // ok
        $row = mysqli_fetch_array($r);
        $result = $row['result'];
        return $result;
    } else {
        return "error:";
    }
    mysqli_close($dbc);
}