<?php
// redirect user to another webpage based on login result
function redirect_user ($page) {
    // Start defining the URL...
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
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
        $q = "SELECT email, name FROM users WHERE email='$e' AND pass='$p'";
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

        if (empty($_POST["fname"])) {
            $errors['fnameErr'] = 'Name is required';
        } else {
            $fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
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
            $q = "INSERT INTO users (email, name, pass) VALUES ('$email', '$fname', '$password')";
            $r = @mysqli_query($dbc, $q); // Run the query.
            if ($r) { // If it ran OK.
                $successRegister = true;
                $message = 'Successfully Registered!';
            } else {
                // Public message:
                $message = '<h1>System Error</h1>
                <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                // Debugging message:
                $message = $message . '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
            }
        } else {
            $successRegister = false;
            $message = 'The following error(s) occurred:<br />';
            foreach ($errors as $msg) {
                $message = $message . " - $msg<br />\n";
            }
        }
    } else { // login button clicked
        list ($check, $data) = check_login($dbc, $_POST['username'], $_POST['userpass']);
        if ($check) { // OK!
            // Set the cookies:
            setcookie ('email', $data['email']);
            setcookie ('name', $data['name']);
            // Redirect:
            redirect_user('main.php');
        } else { // Unsuccessful!
            $errors = $data; // Assign $data to $errors
            $message = 'The following error(s) occurred:<br />';
            foreach ($errors as $msg) {
                $message = $message . " - $msg<br />\n";
            }
        }               
    }
    mysqli_close($dbc); // Close the database connection.
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>        
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title> Login </title>               
    </head>
    <body>
        <!-- Displays the Login Page -->
        <div class="container-fluid">
            <div class="main">
                <!-- Header -->
                <img src="head.jpg" alt="Allegheny Health Network">
                <h1 class="head">Forbes Regional Hospital <br/> CABG Expense Analyzer </h1><hr>
                <!-- Page Information -->
                <p class="error" style="margin-left: 6em">
                    <?php if(isset($check) && !$check) echo "$message" ?></p>
                <div class="panel panel-default">
                    <div class="panel-heading"> Please enter your email and passowrd to login. </div>
                </div>
                <!-- Login -->
                <form class="form-horizontal" method="POST" action="login.php">
                    <div class="form-group">
                        <label class="control-label col-sm-4"> User Email </label>
                        <div class="input-group col-xs-4">
                            <input class="form-control" type="text" name="username" required>
                            <div class="input-group-addon">@ahn.org</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Password </label>
                        <div class="col-xs-4 input-group">
                            <input class="form-control" type="password" name="userpass" required>
                        </div>
                    </div>
                    <center>
                        <button type="submit" name="login" class="btn btn-info btn-lg">Login</button>
                    </center> 
                </form>
                <!-- Registration -->
                <hr>
                <p class="error" style="margin-left: 6em;">
                    <?php if(isset($successRegister)) echo "$message" ?></p>
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <label class="checkbox-inline">
                            <input type="checkbox" id="register"/>New user? Please click the checkbox. 
                        </label> 
                    </div>
                </div>

                <form class="form-horizontal" id="registerForm" method="POST" action="login.php">
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Hospital Email </label>
                        <div class="input-group col-xs-4">
                            <input class="form-control" type="text" name="email" required>
                            <div class="input-group-addon">@ahn.org</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Full Name </label>
                        <div class="col-xs-4 input-group">
                            <input class="form-control" type="text" name="fname" required>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Password </label>
                        <div class="col-xs-4 input-group">
                            <input class="form-control" type="password" name="password" id="pw1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Re-type Password </label>
                        <div class="col-xs-4 input-group">
                            <input class="form-control" type="password" name="password2" id="pw2" required>
                        </div>
                    </div>
                    <center>
                        <button type="submit" name="register" class="btn btn-info btn-lg">Register</button>
                    </center>
                </form> 
            </div>
        </div>        
        <script>
        $(document).ready(function () {
            // show or hide register box
            $("#register").change(function () { 
                $("#registerForm").fadeToggle(this.checked);
            }).change();
            // validate form input
            $('form.form-horizontal :input').blur(function() {
                if( $(this).val().length == 0 ) { // input is empty
                    $(this).parent().after($("<label class='control-label col-sm-6'><span class='error'> Please fill this in </span></label>"));
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
            $('form.form-horizontal :input').focus(function() {
                $(this).parent().next("label").empty();
            });
        });
        </script>    
    </body>
</html>