<?php // The user is redirected here from login.php.
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title> Main </title>
</head>
<body>
<!-- Displays the main Page -->
<div class="container-fluid">
    <div class="row content">
        <!-- Sidebar -->
        <div class="col-sm-2 sidenav">
            <!-- Home button -->
            <a href="#" class="btn btn-info btn-lg btn-block">
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    Please <strong>search</strong> a patient or
                    <strong>add</strong> a new patient.
                </div>
            </div>
            <!-- Search Patient Button -->
            <div class="col-sm-5 center-block">
                    <button type="button" class="btn btn-primary btn-lg  center-block" data-toggle="collapse" data-target="#search">
                        <span class="glyphicon glyphicon-search"></span> Search For <br/>A Patient
                    </button>
                <br/>
                <center>
                    <div id="search" class="collapse">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label class="sr-only" for="firstname">First Name:</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Enter First Name">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="lastname">Last Name:</label>
                                <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name">
                            </div>
                            <br/><br/>
                            <button method="GET" type="submit" id="searchButton" name="search" class="btn btn-default">Search</button>
                        </form>
                    </div>
                </center>
            </div>
            <!-- Add Patient Button -->
            <div class="col-sm-3 center-block">
                    <a href="patient_register.php" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-plus"></span> Add <br/>A Patient
                    </a>
            </div>
            <!-- Report Button -->
            <div class="col-sm-4 center-block">
                    <a href="#" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-paste"></span> Hospital <br/>Report
                    </a>
            </div>
            <!-- Display search result -->
            <?php
            // when SEARCH button is clicked
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if (isset($_GET['search'])) { // search button clicked
                    require('../mysqli_connect.php'); // Connect to the db.

                    if (isset($_GET["firstname"]) || isset($_GET["lastname"])) {
                        $firstname = $_GET["firstname"];
                        $lastname = $_GET["lastname"];
                        $query = "SELECT patient_id, patient_fname, patient_lname, DATE_FORMAT(birthdate, '%M %d, %Y'),
                              DATE_FORMAT(checkin, '%M %d, %Y'), gender
                              FROM patients WHERE patient_fname='$firstname' OR patient_lname='$lastname'";

                        $result = @mysqli_query($dbc, $query);
                        $rnum = mysqli_num_rows($result);

                        if ($rnum > 0) {
                            $ouput = "<div class=\"col-sm-12 result\">
                                        <h5>You might be interested in these patients.</h5>
                                        <div class=\"panel-body\" style=\"font:1em\">
                                        <table id=\"result\" class=\"table table-striped\" cellspacing=\"0\" width=\"100%\">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>DOB</th>
                                                <th>Check-In Day</th>
                                                <th>Gender</th>
                                                <th>Activities & Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                                $ouput = $ouput . "<tr>" . "<td>" . $row[0] . "</td>"; // id
                                $ouput = $ouput . "<td>" . $row[1] . "</td>"; // first name
                                $ouput = $ouput . "<td>" . $row[2] . "</td>"; // last name
                                $ouput = $ouput . "<td>" . $row[3] . "</td>"; 
                                $ouput = $ouput . "<td>" . $row[4] . "</td>";
                                $ouput = $ouput . "<td>" . $row[5] . "</td>"; // gender
                                $pname = $row[1] . " " . $row[2];
                                $link = "activity.php?id=" . $row[0] . "&fname=" . $row[1] . "&lname=" . $row[2] . "&sex=" . $row[5];
                                $ouput = $ouput . "<td>" . "<a href=\"$link\" class=\"btn btn-default\" role=\"button\">Go To Patient</a>" . "</td></tr>";
                            }
                            $ouput = $ouput . "</tbody></table></div></div>";
                            mysqli_free_result($result);

                        } else {
                            $ouput = "<div class=\"col-sm-12 result\">
                                    <h5>No patients found. Please check the patient name or add a new patient.</h5></div>";
                        }  
                        echo "$ouput";
                    }
                    mysqli_close($dbc);
                }               
                else {
                require('../mysqli_connect.php'); // Connect to the db.

                        $query = "SELECT patient_id, patient_fname, patient_lname, DATE_FORMAT(birthdate, '%M %d, %Y'),
                              DATE_FORMAT(checkin, '%M %d, %Y'), gender
                              FROM patients WHERE checkout IS NULL";

                        $result = @mysqli_query($dbc, $query);
                        $rnum = mysqli_num_rows($result);

                        if ($rnum > 0) {
                            $ouput = "<div class=\"col-sm-12 result\">
                                        <h5>You might be interested in these patients.</h5>
                                        <div class=\"panel-body\" style=\"font:1em\">
                                        <table id=\"result\" class=\"table table-striped\" cellspacing=\"0\" width=\"100%\">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>DOB</th>
                                                <th>Check-In Day</th>
                                                <th>Gender</th>
                                                <th>Activities & Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                                $ouput = $ouput . "<tr>" . "<td>" . $row[0] . "</td>"; // id
                                $ouput = $ouput . "<td>" . $row[1] . "</td>"; // first name
                                $ouput = $ouput . "<td>" . $row[2] . "</td>"; // last name
                                $ouput = $ouput . "<td>" . $row[3] . "</td>"; 
                                $ouput = $ouput . "<td>" . $row[4] . "</td>";
                                $ouput = $ouput . "<td>" . $row[5] . "</td>"; // gender
                                $pname = $row[1] . " " . $row[2];
                                $link = "activity.php?id=" . $row[0] . "&fname=" . $row[1] . "&lname=" . $row[2] . "&sex=" . $row[5];
                                $ouput = $ouput . "<td>" . "<a href=\"$link\" class=\"btn btn-default\" role=\"button\">Go To Patient</a>" . "</td></tr>";
                            }
                            $ouput = $ouput . "</tbody></table></div></div>";
                            mysqli_free_result($result);

                        } else {
                            $ouput = "<div class=\"col-sm-12 result\">
                                    <h5>All patients have checked out</h5></div>";
                        }  
                        echo "$ouput";
                        mysqli_close($dbc); 
                    }
                }
            ?>   
        </div>
    </div>
</div>
</body>
</html>

<!-- To do: 1. Show 5 patients without checkout date?
            2. Add correct activities in activities table
            3. Add correct activities-role relations in activ_role table
-->