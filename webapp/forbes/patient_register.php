<!-- To do: 1. after success, redirect to main page
-->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <title> Patient Registration </title>
        <style> 
            .container-fluid { /* Set background color and height */
                background: 
                    url("bg01.jpg") no-repeat center center fixed; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            } 
            img { /* This defines the header image */
                float: left;
                width: 250px;
                height: 90px;
                padding-top: 15px;
                /*display: block; margin-left: auto; margin-right: auto*/
            }         
            h1 { /* This defines the header text */
                text-align: center;
                font-family: Times New Roman, Times, serif;
                font-weight: bold;
            }
            .sidenav { /* This defines the sidebar */
                padding-top: 110px; margin: 50px auto; 
            }
            hr { /* This defines the hr line style */
                height: 2px; background-color: #599BB3; width: 80%; border: none;
            }
            .main { /* This defines the div displaying the page */
                width: 70%; 
                margin: 50px auto;
                padding: 40px;
                background-color: #FFFFFF;
            }  
            .info { /* This defines the page information */
                font: italic bold 1.0em Times New Roman;  
                margin-left: 4em; margin-right: 4em;
            }
            .error { color: #FF0000; font: italic bold 0.9em Times New Roman;  }         
            label { /* Defines form labels */
                display: inline-block;
                width:10em;
                text-align: left;
            } 
        </style> 
    </head>
    <body>
        <!-- php code here -->
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            require ('../mysqli_connect.php'); // Connect to the db.

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

                echo '<h1>Successful!</h1>';
                
            } else {
                // Public message:
                echo '<h1>System Error</h1>
               <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                    // Debugging message:
                echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
            }
            mysqli_close($dbc); // Close the database connection.
        }
        ?>
        <!-- Displays the Registration Page -->
        <div class="container-fluid">
            <div class="row content">
                <!-- Sidebar -->
                <div class="col-sm-2 sidenav">
                    <!-- Home button -->
                    <a href="#" class="btn btn-info btn-lg">
                      <span class="glyphicon glyphicon-home"></span> Home
                    </a><br/><br/>
                    <!-- User -->
                    <div class="well well">
                        <h5>Welcome, <br/> <?php echo '{$_COOKIE['name']}' ?>!</h5>
                    </div>
                    <!-- Logout -->
                    <a href="#" class="btn btn-info btn-lg">
                      <span class="glyphicon glyphicon-log-out"></span> Log out
                    </a>
                </div>
                <!-- Main Content -->
                <div class="col-sm-10 main">
                    <!-- Header -->
                    <img src="head.jpg" alt="Allegheny Health Network">
                    <h1 class="head">Forbes Regional Hospital <br/> CABG Expense Analyzer </h1><hr>
                    <!-- Page Information -->
                    <div class="panel panel-default" style="margin-left: 4em; margin-right: 4em">
                        <div class="panel-heading"> Please fill in the patient information below. </div>
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
                                <input type="radio" name="sex" value="male" checked="checked"> Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="female"> Female
                            </label> 
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4"> Have diabetes? </label>
                            <label class="radio-inline">
                                <input type="radio" name="diabetes" value="no" checked="checked"> No
                            </label>    
                            <label class="radio-inline">
                                <input type="radio" name="diabetes" value="yes"> Yes 
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4"> Insurance </label>
                                <select class="form-control" name="insurance" style="width:300px" required>
                                    <option value="highmark">Highmark Inc.</option>
                                    <option value="ibc">Independence Blue Cross</option> 
                                    <option value="cbc">Capital Blue Cross</option>
                                    <option value="aetna">Aetna Health</option>
                                    <option value="upmc"> UPMC Health Plan </option>
                                    <option value="other"> Others </option>
                                </select>
                        </div>
                        <!--<input type="submit" value="Register Paient">-->
                        <center>
                            <button type="submit" class="btn btn-info btn-lg">Submit</button>
                        </center>      
                    </form><br/>  
                </div> 
            </div>
        </div>
        <script>
            $(document).ready(function () {
                // add datepicker
                $( "#datepicker, #datepicker2" ).each(function(){
                    $(this).datepicker({
                        dateFormat: "yy-mm-dd",
                        yearRange: "-100:+0",
                        changeMonth: true,
                        changeYear: true
                    });
                });
            });
        </script>    
    </body>
</html>