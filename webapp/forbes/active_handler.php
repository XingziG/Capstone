<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('../mysqli_connect.php'); // Connect to the db.
    // for post-op: activity id, activity day, role id, freq
    //              activity id, activity day, role id, time duration
    if (isset($_POST['day0']) || isset($_POST['day1']) || isset($_POST['day2']) || isset($_POST['dday'])) {
        foreach ($_POST as $param_name => $param_val) {
            if ($param_name == "pid") {
                $patient_id = $param_val;
            } elseif ($param_name == "day0" || $param_name == "day1"
                || $param_name == "day2" || $param_name == "dday") { // ignore these parameters

            } elseif ($param_name == "cday") {
                //update discharge date:
                $checkout_date = $param_val;
                $q = "UPDATE patients SET checkout=STR_TO_DATE('$checkout_date', '%Y-%m-%d') WHERE patient_id='$patient_id'";
                $r = @mysqli_query($dbc, $q); // Run the query.
                if ($r) { // If it ran OK.
                    $success_update = "Activities Successfully Added!";
                } else {
                    $success_update = "FAIL";
                    echo "$q";
                }

            } else {
                // split the string by "-"
                $attribute = explode("-", $param_name);

                $act_id = $attribute[0];
                $act_day = $attribute[1];
                $role_id = $attribute[2];
                if ($attribute[3] == "time") {
                    $time_dur = $param_val;
                    $q = "UPDATE reports SET time_duration=$time_dur WHERE patient_id='$patient_id' AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                if ($attribute[3] == "freq") {
                    $frequency = $param_val;
                    $q = "UPDATE reports SET freq=$frequency WHERE patient_id='$patient_id' AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                if ($attribute[3] == "perf") {
                    $performer = $param_val;
                    $q = "UPDATE reports SET performer='$performer' WHERE patient_id='$patient_id' AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                // update in the database:
                $r = @mysqli_query($dbc, $q); // Run the query.
                if ($r) { // If it ran OK.
                    $success_update = "Activities Successfully Added!";
                    
                } else {
                    $success_update = "FAIL";
                    echo "$q";
                }
            }
            //echo "Param: $param_name; Value: $param_val<br />\n";
        }
    }

    if (isset($_POST['surgery'])) {
        foreach ($_POST as $param_name => $param_val) {

            if ($param_name == "pid") {
                $patient_id = $param_val;
            } elseif ($param_name == "surgery") {//ignore these parameter
            } elseif ($param_name == "dmcost") {
                $direct_material = $param_val;
                $q = "UPDATE patients SET direct_material = $direct_material WHERE patient_id='$patient_id'";
            } else {
                // split the string by "-"
                $attribute = explode("-", $param_name);

                $act_id = $attribute[0];
                $act_day = $attribute[1];
                $role_id = $attribute[2];
                if ($attribute[3] == "t") {
                    $time_dur = $param_val;
                    $q = "UPDATE reports SET freq=1, time_duration=$time_dur WHERE patient_id='$patient_id' AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                if ($attribute[3] == "p") {
                    $performer = $param_val;
                    $q = "UPDATE reports SET freq=1, performer='$performer' WHERE patient_id='$patient_id' AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
            }
            // update in the database:
            $r = @mysqli_query($dbc, $q); // Run the query.
            if ($r) { // If it ran OK.
                $success_update = "Activities Successfully Added!";
            } else {
                $success_update = "FAIL";
            }
        }
    }
    // redirect
    $q = "SELECT patient_id, patient_fname, patient_lname, gender FROM patients WHERE patient_id='$patient_id'";
    $r = @mysqli_query($dbc, $q); // Run the query.
    $row = mysqli_fetch_assoc($r);
    $link = "activity.php?id=" . $row["patient_id"] . "&fname=" . $row["patient_fname"] . "&lname=" . $row["patient_lname"] . "&sex=" . $row["gender"];
    echo "<script type='text/javascript'>alert('$success_update');window.location.replace('$link');</script>"; 
}