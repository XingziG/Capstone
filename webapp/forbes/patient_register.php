<!-- To do: 1. after success, redirect to main page
-->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <title> Patient Registration </title>
        <style>
            html { 
                /* The background code is referenced from:
                https://css-tricks.com/perfect-full-page-background-image/ */
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
                height: 80px;
                padding-top: 15px;
                /*display: block; margin-left: auto; margin-right: auto*/
            }         
            h1 { /* This defines the header */
                text-align: center;
                font-family: Times New Roman, Times, serif;
            }
            hr { /* This defines the hr line style */
                height: 2px; background-color: #599BB3; width: 80%; border: none;
            }
            .main { /* This defines the div displaying the page */
                font: 1em Hoefler Text, Times New Roman, Times, serif;
                width: 60%; 
                margin: 50px auto;
                padding: 10px;
                background-color: #FFFFFF;
            }  
            .info { /* This defines the page information */
                font: italic bold 1.0em Times New Roman;  
                margin-left: 4em; margin-right: 4em;
            }
            .error { color: #FF0000; font: italic bold 0.9em Times New Roman;  }
            .formfield { /* This defines the login form display */
                font-size: 1em; margin-left: 6em; line-height: 200%;
            }         
            label {
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
        <div class="main"> 
            <img src="head.jpg" alt="Allegheny Health Network">
            <h1>Forbes Regional Hospital <br/>
                CABG Expense Analyzer </h1><hr>
            <!-- Page Information -->
            <p class="info"><br/>
                Please fill in the patient information below. 
            </p>
            <!-- Patient Registration fields -->
            <form class="formfield" id="patientForm" method="POST" action="patient_register.php">
                <label> Patient ID </label>
                    <input type="text" name="id" size="26" required><br/>
                <label> First Name </label>
                    <input type="text" name="fname" size="26" required><br/>
                <label> Last Name </label>
                    <input type="text" name="lname" size="26" required><br/>
                <label> Birth Date </label>
                    <input type="text" class="datepicker" size="26" name="bday" required><br/>
                <label> Check-In Date </label>
                    <input type="text" class="datepicker" size="26" name="cday" required><br/>
                <label> Gender </label> 
                    <input type="radio" name="sex" value="male" checked="checked"> Male &nbsp
                    <input type="radio" name="sex" value="female"> Female <br/>
                <label> Have diabetes? </label>
                    <input type="radio" name="diabetes" value="no" checked="checked"> No &nbsp
                    <input type="radio" name="diabetes" value="yes"> Yes <br/>
                <label> Insurance </label>
                        <select name="insurance" required>
                            <option value="highmark">Highmark Inc.</option>
                            <option value="ibc">Independence Blue Cross</option> 
                            <option value="cbc">Capital Blue Cross</option>
                            <option value="aetna">Aetna Health</option>
                            <option value="upmc"> UPMC Health Plan </option>
                            <option value="other"> Others </option>
                        </select><br/>
                <input type="submit" value="Register Paient">
            </form><br/>  
        </div> 
        <script>
            $(document).ready(function () {
                // add datepicker
                $( ".datepicker" ).each(function(){
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