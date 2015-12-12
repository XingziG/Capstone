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

/**
 * Get result from DB and present it in the activity page
 *
 * @param $field
 * @param $aid
 * @param $ad
 * @param $rid
 * @return mixed
 */
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

function get_table_value($type)
{
    require "../mysqli_connect.php"; // Connect to the db.

    if ($type=='sg') {
        $q = get_sg_cost_query();
    } else if ($type=='po') {
        $q = get_po_cost_query();
    } else {
        $q = get_total_cost_query();
    }
    $r = @mysqli_query($dbc, $q);  // run query
    while ($row = mysqli_fetch_assoc($r)) {
        $output = "<tr><td>" . $row['role'] . "</td><td><span class=\"" . $type . "\" name=\"" . $row['role'] . "\">" . $row['cost'] . "</span></td></tr>";
        echo $output;
    }
    mysqli_close($dbc);
}

function get_sg_cost_query() {
    $pid = $_GET["id"];
    $q = "SELECT ro.role_name AS 'role',
              TRUNCATE(SUM((ro.salary/124800) * r.freq * r.time_duration *
              (CASE r.activity_day
                    WHEN 'd' THEN DATEDIFF(p.checkout, p.checkin)-2
                    ELSE 1
               END)),2) AS 'cost'
               FROM patients p, reports r, roles ro
               WHERE p.patient_id = '$pid'
               AND p.patient_id = r.patient_id
               AND ro.role_id = r.role_id
               AND r.activity_id<=6       
               GROUP BY ro.role_name";
    return $q;
}

function get_po_cost_query() {$pid = $_GET["id"];
    
    $q = "SELECT ro.role_name AS 'role',
              TRUNCATE(SUM((ro.salary/124800) * r.freq * r.time_duration *
              (CASE r.activity_day
                    WHEN 'd' THEN DATEDIFF(p.checkout, p.checkin)-2
                    ELSE 1
               END)),2) AS 'cost'
               FROM patients p, reports r, roles ro
               WHERE p.patient_id = '$pid'
               AND ro.role_id = r.role_id
               AND r.activity_id>6       
               AND p.patient_id = r.patient_id
               GROUP BY ro.role_name";
    return $q;
}

function get_total_cost_query() {
    $pid = $_GET["id"];
    $q = "SELECT ro.role_name AS 'role',
              TRUNCATE(SUM((ro.salary/124800) * r.freq * r.time_duration *
              (CASE r.activity_day
                    WHEN 'd' THEN DATEDIFF(p.checkout, p.checkin)-2
                    ELSE 1
               END)),2) AS 'cost'
               FROM patients p, reports r, roles ro
               WHERE p.patient_id = '$pid'
               AND p.patient_id = r.patient_id
               AND ro.role_id = r.role_id
               GROUP BY ro.role_name";
    return $q;
}


function get_barchart_value($graph, $input) {
    require ('../mysqli_connect.php'); // Connect to the db.

    $pid = $_GET["id"];
    if ($graph == "cost") { // cost
        if ($input == "hospital") { // get hospital wide cost
            $q = "SELECT AVG(IFNULL(total_labor_cost,0) + IFNULL(over_head,0) + IFNULL(direct_material,0)) as 'result' 
                  FROM patients WHERE checkout IS NOT NULL";
        } else { // get reimbursement
            
        }
    } else { // stay
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