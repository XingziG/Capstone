<?php
function redirect_user($page)
{
    // Start defining the URL...
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    // Redirect the user: 
    header("Location: $url");
    exit(); // Quit the script.
}

if (!isset($_COOKIE['email'])) { // If no cookie is present, redirect:
    redirect_user('login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require('../mysqli_connect.php'); // Connect to the db.

    $id = mysqli_real_escape_string($dbc, trim($_POST['id']));

    $fn = mysqli_real_escape_string($dbc, trim($_POST['fname']));

    $ln = mysqli_real_escape_string($dbc, trim($_POST['lname']));

    $bd = mysqli_real_escape_string($dbc, trim($_POST['bday']));

    $cd = mysqli_real_escape_string($dbc, trim($_POST['cday']));

    $sex = mysqli_real_escape_string($dbc, trim($_POST['sex']));

    $diab = mysqli_real_escape_string($dbc, trim($_POST['diabetes']));

    $insur = mysqli_real_escape_string($dbc, trim($_POST['insurance']));

    //make a query:
    $q = "INSERT INTO patients (patient_id, patient_fname, patient_lname, birthdate, checkin, gender, diabetes, insurance) VALUES ('$id', '$fn', '$ln', STR_TO_DATE('$bd', '%Y-%m-%d'), STR_TO_DATE('$cd','%Y-%m-%d'), '$sex', '$diab', '$insur')";

    $r = @mysqli_query($dbc, $q); // Run the query.

    if ($r) { // If it ran OK.
        $success = true;
        $message = "Patient Successfully Added!";
        echo "<script type='text/javascript'>
            alert('$message'); window.location.replace(\"main.php\");</script>";
        redirect_user('main.php');
    } else {
        $success = false;
        // Public message:
        $message = '<h1>System Error</h1>
        <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
        // Debugging message:
        $message = $message . '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
    }
    mysqli_close($dbc); // Close the database connection.
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <title> Patient Registration </title>
</head>
<body>
<!-- Displays the Registration Page -->
<div class="container-fluid">
    <div class="row content">
        <!-- Sidebar -->
        <div class="col-sm-2 sidenav">
            <!-- Home button -->
            <a href="main.php" class="btn btn-info btn-lg btn-block">
                <span class="glyphicon glyphicon-home"></span> Home
            </a><br/>
            <!-- User -->
            <div class="well well">
                <h4>Welcome, <br/> <?php echo "{$_COOKIE['name']}" ?>!</h4>
            </div>
            <!-- Logout -->
            <a href="logout.php" class="btn btn-info btn-lg btn-block">
                <span class="glyphicon glyphicon-log-out"></span> Log out
            </a>
        </div>
        <!-- Main Content -->
        <div class="col-sm-10 main">
            <!-- Header -->
            <img src="head.jpg" alt="Allegheny Health Network">

            <h1 class="head">Forbes Regional Hospital <br/> CABG Expense Analyzer </h1>
            <hr>
            <!-- Page Information -->
            <p class="error" style="margin-left: 6em">
                <?php if (isset($success) && !$success) echo "$message" ?></p>

            <div class="panel panel-default">
                <div class="panel-heading"> Please fill in the patient information below.</div>
            </div>
            <!-- Patient Registration fields -->
            <form class="form-horizontal" id="patientForm" method="POST" action="patient_register.php">
                <div class="form-group">
                    <label class="control-label col-sm-4"> Patient ID </label>

                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="id" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> First Name </label>

                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="fname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> Last Name </label>

                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="lname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> Birth Date </label>

                    <div class="col-sm-6">
                        <input class="form-control" type="text" id="datepicker" name="bday" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> Check-In Date </label>

                    <div class="col-sm-6">
                        <input class="form-control" type="text" id="datepicker2" name="cday" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> Gender </label>
                    <label class="radio-inline">
                        <input type="radio" name="sex" value="M" checked="checked"> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="sex" value="F"> Female
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> Have diabetes? </label>
                    <label class="radio-inline">
                        <input type="radio" name="diabetes" value="N" checked="checked"> No
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="diabetes" value="Y"> Yes
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4"> Insurance </label>
                    <select class="form-control" name="insurance" style="width:300px" required>
                        <option value="highmark">Highmark Inc.</option>
                        <option value="ibc">Independence Blue Cross</option>
                        <option value="cbc">Capital Blue Cross</option>
                        <option value="aetna">Aetna Health</option>
                        <option value="upmc"> UPMC Health Plan</option>
                        <option value="other"> Others</option>
                    </select>
                </div>
                <button method="POST" type="submit" class="btn btn-info btn-lg center-block">Submit</button>
            </form>
            <br/>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // add datepicker
        $("#datepicker, #datepicker2").each(function () {
            $(this).datepicker({
                dateFormat: "yy-mm-dd",
                yearRange: "-100:+0",
                changeMonth: true,
                changeYear: true,
                maxDate: 0
            });
        });
        // validate form input
        $('form#patientForm :input').blur(function () {
            if (!($(this).attr('id') == 'datepicker' || $(this).attr('id') == 'datepicker2')) {
                if ($(this).val().length == 0) { // input is empty
                    $(this).after($("<span class='error'> Please fill this in </span>"));
                }
            }
        });
        // remove warning message when on focus
        $('form#patientForm :input').focus(function () {
            $(this).next("span").empty();
        });
    });
</script>
</body>
</html>