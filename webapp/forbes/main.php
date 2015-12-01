<!-- To do: link to add patient & search patient
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <title> Main </title>
    </head>
    <body>
        <!-- php -->
        <?php // The user is redirected here from login.php.
        function redirect_user ($page) {
            // Start defining the URL...
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
            $url = rtrim($url, '/\\');
            $url .= '/' . $page;
            // Redirect the user: 
            header("Location: $url"); exit(); // Quit the script.
        }
        if (!isset($_COOKIE['email'])) { // If no cookie is present, redirect:
            require ('login.php');
            redirect_user('login.php');
        }        
        ?>
        <!-- Displays the main Page -->
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
                        <h5>Welcome, <br/> <?php echo "{$_COOKIE['name']}" ?>!</h5>
                    </div>
                    <!-- Logout -->
                    <a href="logout.php" class="btn btn-info btn-lg">
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
                        <div class="panel-heading"> 
                            Please <strong>search</strong> a patient or 
                            <strong>add</strong> a new patient. </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
        
    