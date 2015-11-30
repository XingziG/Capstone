<!-- To do: 
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <title> Main </title>
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
        <?php // The user is redirected here from login.php.
        if (!isset($_COOKIE['email'])) { // If no cookie is present, redirect:
            require ('includes/login_functions. inc.php');
            redirect_user();
        }
        
        // Set the page title and include the HTML header:
        $page_title = 'Welcome!';
        // Print a customized message:
        echo "<h1>Welcome!</h1><p>You are now logged in, {$_COOKIE['email']}!</p>
        <p><a href=\"logout.php\">Logout</a></p>";
        ?>
        <!-- Displays the main Page -->
        <div class="main">
        </div>
    </body>
</html>
        
    