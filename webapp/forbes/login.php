<!-- To do: 
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <title> Login </title>
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
    <!-- php -->
    <?php // define variables and set to empty values
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        require ('../mysqli_connect.php'); // Connect to the db.

        $errors = array();

        if (empty($_POST["email"])) {
            $errors['emailErr'] = 'Email is required';
        } else {
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        }

        if (!empty($_POST["password"])) {
            if ($_POST['password2'] != $_POST["password"]) {
                $errors['password2Err'] = "Please retype password";
            } else {
                $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            }
        } else {
            $errors['passwordErr'] = "Password is required";
        }

        if (empty($errors)) {
            //everything is OK, register the user into the db

            //make a query:
            $q = "INSERT INTO users (email, pass) VALUES ('$email', '$password')";
            $r = @mysqli_query($dbc, $q); // Run the query.
            if ($r) { // If it ran OK.
                $successRegister = true;

                echo'<h1>Successfully Registered!</h1>';

            } else {
                // Public message:
                echo '<h1>System Error</h1>
                <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                // Debugging message:
                echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
            }
            mysqli_close($dbc); // Close the database connection.
        } else {
            $successRegister = false;
            mysqli_close($dbc);
        }
    }
    ?>
     <!-- Displays the Login Page -->
        <div class="main"> 
            <img src="head.jpg" alt="Allegheny Health Network">
            <h1>Forbes Regional Hospital <br/>
                CABG Expense Analyzer</h1><hr>
            <!-- Page Information -->
            <p class="info"><br/>
                Please type in your user name and passowrd to login. 
            </p>
            <!-- Login -->
            <form action="check_user.php" class="formfield" method="POST">
                <label> User Email </label>
                    <input type="text" name="username" size="26" required>@ahn.org<br/>
                <label> Password </label>
                    <input type="password" name="password" size="26" required><br/>
                <input type="submit" value="Login">
            </form><br/>
            <!-- Registration -->
            <hr>
            <p class="error" style="margin-left: 6em;"><?php if(isset($successRegister) && $successRegister) echo 'Successfully Registered!' ?></p>
            <p class="info"><br/>
                New user? Please click the register checkbox.
                <input type="checkbox" id="register"/> Register          
            </p>
            <div id="register_box">
                <!--<p class="error" style="margin-left: 6em;">All fields are required</p>-->
                <form class="formfield" id="registerForm" method="POST" action="login.php">
                    <label>Hospital Email</label>
                        <input type="text" name="email" size="26" required>@ahn.org<br/>
                    <label>New Password</label>
                        <input type="password" name="password" id="pw1" size="26" required><br/>
                    <label>Re-type Password</label>
                        <input type="password" name="password2" id="pw2" size="26" required><br/> 
                    <input type="submit" value="Register" class="button">
                </form>
            </div>  
        </div> 
        <script>
        $(document).ready(function () {
            // show or hide register box
            $("#register").change(function () { 
                $("#register_box").fadeToggle(this.checked);
            }).change();
            // validate form input
            $('form#registerForm :input').blur(function() {
                if( $(this).val().length == 0 ) { // input is empty
                    $(this).after($("<span class='error'> Please fill this in </span>"));
                } else if ($(this).is("#pw1") | $(this).is("#pw2")) { // when user input password
                    if ($("#pw1").val() != 0 & $("#pw2").val() != 0) { 
                        if ($("#pw2").val() != $("#pw1").val()) { // passwords do not match
                            $(this).after($("<span class='error'> Passwords do not match </span>"));
                        } else { // matching passwords
                            $("#pw1").next("span").empty();
                            $("#pw2").next("span").empty();
                        }
                    }
                }
            });
            // remove warning message when on focus
            $('form#registerForm :input').focus(function() {
                $(this).next("span").empty();
            });
        });
        </script>    
    </body>
</html>