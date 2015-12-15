<?php
/**
 * Get average cost for hospital report
 * @param $type
 */
function get_cost($type)
{
    require "../mysqli_connect.php"; // Connect to the db.

    if ($type=='sg') {
        $q = get_avg_sg_cost_query();
    } else if ($type=='po') {
        $q = get_avg_po_cost_query();
    } else {
        $q = get_avg_total_cost_query();
    }
    $r = @mysqli_query($dbc, $q);  // run query
    while ($row = mysqli_fetch_assoc($r)) {
        $output = "<tr><td>" . $row['role'] . "</td><td><span class=\"" . $type . "\" name=\"" . $row['role'] . "\">" . $row['cost'] . "</span></td></tr>";
        echo $output;
    }
    mysqli_close($dbc);
}

function get_avg_sg_cost_query() {
    $q = "SELECT ro.role_name AS 'role',
              TRUNCATE(SUM((ro.salary / 124800) * r.freq * r.time_duration *
              (CASE r.activity_day
                  WHEN 'd' THEN DATEDIFF(p.checkout, p.checkin) - 2
                  ELSE 1
               END))/COUNT(DISTINCT p.patient_id),2) AS 'cost'
               FROM patients p, reports r, roles ro
               WHERE r.activity_id<=6
               AND p.checkout IS NOT NULL
               AND p.patient_id = r.patient_id
               AND r.role_id = ro.role_id
               GROUP BY ro.role_name";
    return $q;
}

function get_avg_po_cost_query() {
    $q = "SELECT ro.role_name AS 'role',
              TRUNCATE(SUM((ro.salary/124800) * r.freq * r.time_duration *
              (CASE r.activity_day
                    WHEN 'd' THEN DATEDIFF(p.checkout, p.checkin)-2
                    ELSE 1
               END))/COUNT(DISTINCT p.patient_id),2) AS 'cost'
               FROM patients p, reports r, roles ro
               WHERE r.activity_id > 6
               AND p.checkout IS NOT NULL
               AND p.patient_id = r.patient_id
               AND r.role_id = ro.role_id
               GROUP BY ro.role_name";
    return $q;
}

function get_avg_total_cost_query() {
    $q = "SELECT ro.role_name AS 'role',
              TRUNCATE(SUM((ro.salary/124800) * r.freq * r.time_duration *
              (CASE r.activity_day
                    WHEN 'd' THEN DATEDIFF(p.checkout, p.checkin)-2
                    ELSE 1
               END))/COUNT(DISTINCT p.patient_id),2) AS 'cost'
               FROM patients p, reports r, roles ro
               WHERE p.checkout IS NOT NULL
               AND p.patient_id = r.patient_id
               AND r.role_id = ro.role_id
               GROUP BY ro.role_name";
    return $q;
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
                $q = "SELECT AVG(IFNULL(total_labor_cost,0) + IFNULL(over_head,0) + IFNULL(direct_material,0)) as 'result' 
                      FROM patients WHERE checkout IS NOT NULL";
            } 
        } else if ($input == "diabetes") {
            $q = "SELECT AVG(IFNULL(total_labor_cost,0) + IFNULL(over_head,0) + IFNULL(direct_material,0)) as 'result' 
                  FROM patients WHERE checkout IS NOT NULL AND diabetes='$bar'";
        } else if ($input == "gender") {
            $q = "SELECT AVG(IFNULL(total_labor_cost,0) + IFNULL(over_head,0) + IFNULL(direct_material,0)) as 'result' 
                  FROM patients WHERE checkout IS NOT NULL AND gender='$bar'";
        } else if ($input == "insurance") {
            $q = "SELECT AVG(IFNULL(total_labor_cost,0) + IFNULL(over_head,0) + IFNULL(direct_material,0)) as 'result' 
                  FROM patients WHERE checkout IS NOT NULL AND insurance='$bar'";
        } else { // age
            switch($bar){
                case "1":
                    $start = 0; $end = 35; break;
                case "2":
                    $start = 35; $end = 65; break;
                default:
                    $start = 65; $end = 200; break;
            }
            $q = "SELECT AVG(IFNULL(total_labor_cost,0) + IFNULL(over_head,0) + IFNULL(direct_material,0)) as 'result' 
                  FROM patients WHERE checkout IS NOT NULL AND TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN $start AND $end";  
        }
    } else if ($graph == "stay") { // stay
        if ($input == "avg") { // get stay
            if ($bar == "hospital") { // hospital stay
                $q = "SELECT AVG(DATEDIFF(checkout, checkin)) as 'result' FROM patients WHERE checkout IS NOT NULL";
            } 
        } else if ($input == "diabetes") { // diabetes
            $q = "SELECT IFNULL(AVG(DATEDIFF(checkout, checkin)),0) as 'result' FROM patients WHERE checkout IS NOT NULL AND diabetes='$bar'";
        } else if ($input == "gender") {
            $q = "SELECT IFNULL(AVG(DATEDIFF(checkout, checkin)),0) as 'result' FROM patients WHERE checkout IS NOT NULL AND gender='$bar'";
        } else if ($input == "insurance") {
            $q = "SELECT IFNULL(AVG(DATEDIFF(checkout, checkin)),0) as 'result' FROM patients WHERE checkout IS NOT NULL AND insurance='$bar'";
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
    } else { // number of patients
        if ($input == "diabetes") {
            $q = "SELECT COUNT(DISTINCT patient_id) as 'result' FROM patients WHERE checkout IS NOT NULL AND diabetes='$bar'";
        } else if ($input == "gender") {
            $q = "SELECT COUNT(DISTINCT patient_id) as 'result' FROM patients WHERE checkout IS NOT NULL AND gender='$bar'";
        } else if ($input == "insurance") {
            $q = "SELECT COUNT(DISTINCT patient_id) as 'result' FROM patients WHERE checkout IS NOT NULL AND insurance='$bar'";
        } else { // age
            switch($bar){
                case "1":
                    $start = 0; $end = 35; break;
                case "2":
                    $start = 35; $end = 65; break;
                default:
                    $start = 65; $end = 200; break;
            }
            $q = "SELECT COUNT(DISTINCT patient_id) as 'result' FROM patients 
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