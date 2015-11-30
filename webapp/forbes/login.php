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
            label { /* Defines form labels */
                display: inline-block;
                width:10em;
                text-align: left;
            }
            input[type=submit] { /* Defines submit button */
                padding:5px 15px; 
                background:-moz-linear-gradient(top, #1280a8 5%, #21444a 100%);
                border:0 none;
                cursor:pointer;
                -webkit-border-radius: 15px;
                border-radius: 15px; 
                text-align: center;
                color:#ffffff;
                font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size:0.8em;
                font-weight:bold;
                padding:0.5em 1.5em;
            }
        </style>                
    </head>
    <body>
        <!-- php -->
        <?php
        // redirect user to another webpage based on login result
        function redirect_user ($page = 'index. php') {
            // Start defining the URL...
            $url = 'http://' . $_SERVER['HTTP_ HOST'] . dirname($_SERVER['PHP_SELF']);
            $url = rtrim($url, '/\\');
            $url .= '/' . $page;
            // Redirect the user: 
            header("Location: $url"); exit(); // Quit the script.
        }
        // check login info from database
        function check_login($dbc, $username = '', $userpass = '') {
            $errors = array();
            if (empty($username)) { // username
                $errors[] = 'You forgot to enter your email address.';
            } else{
                $e = mysqli_real_escape_string($dbc, trim($username));
            }
            if (empty($userpass)) { // password
                $errors[] = 'You forgot to enter your password.';
            }else{
                $p = mysqli_real_escape_string($dbc, trim($userpass));
            }
            if (empty($errors)) { // If everything's OK.
                // Retrieve for the email/password combination:
                $q = "SELECT email, pass FROM users WHERE email='$e' AND pass='$p'";
                $r = @mysqli_query ($dbc, $q); // run query       
                // Check the result:
                if (mysqli_num_rows($r) == 1) { // Fetch the record               
                    $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
                    return array(true, $row);
                } else { // Not a match!
                    $errors[] = 'The email address and password entered do not match.';
                }
            }
            return array(false, $errors);
        }
        // when a button is clicked
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require ('../mysqli_connect.php'); // Connect to the db.
            if (isset($_POST['register'])) { // register button clicked
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

                if (empty($errors)) { //everything is OK, register the user into the db
                    //make a query:
                    $q = "INSERT INTO users (email, pass) VALUES ('$email', '$password')";
                    $r = @mysqli_query($dbc, $q); // Run the query.
                    if ($r) { // If it ran OK.
                        $successRegister = true;
                    } else {
                        // Public message:
                        echo '<h1>System Error</h1>
                        <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                        // Debugging message:
                        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                    }
                } else {
                    $successRegister = false;
                }
            } else { // login button clicked
                list ($check, $data) = check_login($dbc, $_POST['username'], $_POST['userpass']);
                if ($check) { // OK!
                    // Set the cookies:
                    setcookie ('user_id', $data['user_id']);
                    setcookie ('first_name', $data['first_name']);
                    // Redirect:
                    redirect_user('main.php');
                } else { // Unsuccessful!
                    $errors = $data; // Assign $data to $errors
                    echo '<h1>Error!</h1><p class="error">The following error(s) occurred:<br />';
                    foreach ($errors as $msg) {
                        echo " - $msg<br />\n";
                    }
                }               
            }
            mysqli_close($dbc); // Close the database connection.
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
            <form class="formfield" method="POST" action="login.php">
                <label> User Email </label>
                    <input type="text" name="username" size="26" required>@ahn.org<br/>
                <label> Password </label>
                    <input type="password" name="userpass" size="26" required><br/>
                <input type="submit" name="login" value="Login" class="button">
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
                    <label> Hospital Email </label>
                        <input type="text" name="email" size="26" required>@ahn.org<br/>
                    <label> New Password </label>
                        <input type="password" name="password" id="pw1" size="26" required><br/>
                    <label> Re-type Password </label>
                        <input type="password" name="password2" id="pw2" size="26" required><br/> 
                    <input type="submit" name="register" value="Register" class="button">
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