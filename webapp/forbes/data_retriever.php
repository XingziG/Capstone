<?php
function get_dm() {
    require "../mysqli_connect.php"; // Connect to the db.
    $pid = $_GET["id"];
    $q = "SELECT direct_material AS 'result' FROM patients WHERE patient_id='$pid'";
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) > 0) { // ok
        $row = mysqli_fetch_assoc($r);
        return $row['result'];
    }
    mysqli_close($dbc);
}

function get_oh() {
    require "../mysqli_connect.php"; // Connect to the db.
    $pid = $_GET["id"];
    $q = "SELECT over_head AS 'result' FROM patients WHERE patient_id='$pid'";
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) > 0) { // ok
        $row = mysqli_fetch_assoc($r);
        return $row['result'];
    }
    mysqli_close($dbc);
}


function get_result($field, $aid, $ad, $rid) {
    require "../mysqli_connect.php"; // Connect to the db.
    $pid = $_GET["id"];
    $q = "SELECT $field AS 'result' FROM reports WHERE (patient_id='$pid' AND activity_id=$aid) AND (activity_day='$ad' AND role_id=$rid)";
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) > 0) { // ok
        $row = mysqli_fetch_assoc($r);
        return $row['result'];
    }
    mysqli_close($dbc);
}


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
 * @param $graph
 * @param $input
 * @param $bar
 * @return string
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
                             WHERE checkout IS NOT NULL AND insurance=$bar) c ON a.patient_id=c.patient_id
                 GROUP BY patient_id) d";
        } else { // age

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

function get_patient_cost($type, $rid)
{
    require "../mysqli_connect.php"; // Connect to the db.

    $pid = $_GET["id"];
    // get days in day2-x
    $qDay = "SELECT DATEDIFF(IFNULL(DATE_SUB(checkout, INTERVAL 1 DAY), CURDATE()), checkin) as 'day' FROM patients WHERE patient_id='$pid'";
    $rDay = @mysqli_query($dbc, $qDay);  // run query
    if (mysqli_num_rows($rDay) == 1) { // ok
        $rowDay = mysqli_fetch_assoc($rDay);
        $day = $rowDay['day'];
        if($day > 1) {
            $day -= 1;
        } else {
            $day = 0;
        }
    } else {
        return "error";
    }

    // get time spent
    if ($type=='sg') {
        $qTime = "SELECT SUM(freq * time_duration) as 'total' FROM reports WHERE (patient_id='$pid' AND role_id=$rid AND activity_id<=6)";
    } else if ($type=='po') {
        $qTime = "SELECT
                    (SELECT SUM(freq * time_duration) as 't' FROM reports WHERE patient_id='$pid' AND role_id=$rid AND activity_id>6 AND activity_day!='d') +
                    (SELECT $day*SUM(freq * time_duration) as 't' FROM reports WHERE patient_id='$pid' AND role_id=$rid AND activity_id>6 AND activity_day='d')
                  AS 'total';";
    } else {
        $qTime = "SELECT
                    (SELECT SUM(freq * time_duration) as 't' FROM reports WHERE patient_id='$pid' AND role_id=$rid AND activity_day!='d') +
                    (SELECT IFNULL($day*SUM(freq * time_duration),0) as 't' FROM reports WHERE patient_id='$pid' AND role_id=$rid AND activity_day='d')
                  AS 'total';";
    }
    $rTime = @mysqli_query($dbc, $qTime);  // run query
    // get salary
    $qPay = "SELECT salary FROM roles WHERE role_id=$rid";
    $rPay = @mysqli_query($dbc, $qPay);  // run query
    if (mysqli_num_rows($rTime) == 1 & mysqli_num_rows($rPay) == 1) { // ok
        $rowTime = mysqli_fetch_assoc($rTime);
        $rowPay = mysqli_fetch_assoc($rPay);
        $result = $rowTime['total'] * $rowPay['salary'] / 124800; // 52 week * 40 hours * 60 minuts
        return number_format($result,0);
    } else {
        return "error";
    }
    mysqli_close($dbc);
}


function get_patient_value($graph, $input) {
    require ('../mysqli_connect.php'); // Connect to the db.

    $pid = $_GET["id"];
    if ($graph == "cost") {
        if ($input == "hospital") { // get hospital wide cost
            $q = "SELECT AVG(d.total) AS 'result' FROM
                    (SELECT a.patient_id, SUM(a.freq * a.time_duration * b.salary / 124800 *
		                    (CASE
			                     WHEN a.activity_day = 'd' THEN c.d
			                     ELSE 1
                             END)) AS 'total'
                     FROM   reports a
		             INNER JOIN (SELECT role_id, salary FROM roles ) b ON a.role_id=b.role_id
                     INNER JOIN (SELECT patient_id, DATEDIFF(checkout, checkin)-2 as 'd' FROM patients WHERE checkout IS NOT NULL) c ON a.patient_id=c.patient_id
                     GROUP BY patient_id) d";
        } else { // get reimbursement

        }
    } else {
        if ($input == "patient") { // get patient stay
            $q = "SELECT DATEDIFF(IFNULL(checkout, CURDATE()), checkin) as 'result' FROM patients WHERE patient_id='$pid'";
        } else if ($input == "hospital") { // get hospital wide stay
            $q = "SELECT AVG(DATEDIFF(checkout, checkin)) as 'result' FROM patients WHERE checkout IS NOT NULL";
        } else { // get national

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

