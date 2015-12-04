<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $param_name => $param_val) {
        echo "Param: $param_name; Value: $param_val<br />\n";
    }
}