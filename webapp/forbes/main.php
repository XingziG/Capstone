<!-- To do: 
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <title> Main </title>
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
            .error { color: #FF0000; font: italic bold 0.9em Times New Roman;  }  
        </style> 
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
            redirect_user();
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
                        <div class="panel-heading"> Please search a patient or add a new patient. </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
        
    