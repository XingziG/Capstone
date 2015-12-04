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
                || $param_name == "day2" || $param_name == "dday") { // ignore these parameter
            } else {
                // split the string by "-"
                $attribute = explode("-", $param_name);

                $act_id = $attribute[0];
                $act_day = $attribute[1];
                $role_id = $attribute[2];
                if ($attribute[3] == "time") {
                    $time_dur = $param_val;
                    $q = "UPDATE reports SET time_duration=$time_dur WHERE patient_id=$patient_id AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                if ($attribute[3] == "freq") {
                    $frequency = $param_val;
                    $q = "UPDATE reports SET freq=$frequency WHERE patient_id=$patient_id AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                if ($attribute[3] == "perf") {
                    $performer = $param_val;
                    $q = "UPDATE reports SET performer='$performer' WHERE patient_id=$patient_id AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                }
                // update in the database:
                $r = @mysqli_query($dbc, $q); // Run the query.
                if ($r) { // If it ran OK.
                    $success_update = "SUCCESS";
                } else {
                    $success_update = "FAIL";
                    echo "$q";
                }
                echo "$success_update";
            }
            echo "Param: $param_name; Value: $param_val<br />\n";
        }
    }



        if (isset($_POST['surgery'])) {
            foreach ($_POST as $param_name => $param_val) {

                if ($param_name == "pid") {
                    $patient_id = $param_val;
                } elseif ($param_name == "surgery") {//ignore these parameter
                } elseif ($param_name == "dmcost") {
                } elseif ($param_name == "ohcost") {
                } else {
                    // split the string by "-"
                    $attribute = explode("-", $param_name);

                    $act_id = $attribute[0];
                    $act_day = $attribute[1];
                    $role_id = $attribute[2];
                    if ($attribute[3] == "t") {
                        $time_dur = $param_val;
                        $q = "UPDATE reports SET freq=1, time_duration=$time_dur WHERE patient_id=$patient_id AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                    }
                    if ($attribute[3] == "p") {
                        $performer = $param_val;
                        $q = "UPDATE reports SET freq=1, performer='$performer' WHERE patient_id=$patient_id AND activity_id=$act_id AND activity_day='$act_day' AND role_id=$role_id";
                    }
                }
                // update in the database:
                $r = @mysqli_query($dbc, $q); // Run the query.
                if ($r) { // If it ran OK.
                    $success_update = true;
                } else {
                    $success_update = false;
                }
            }
        }
    }