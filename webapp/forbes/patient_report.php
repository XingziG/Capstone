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
                <a href="main.php" class="btn btn-info btn-lg btn-block">
                    <span class="glyphicon glyphicon-home"></span> Home
                </a><br/>
                <!-- User -->
                <div class="well well">
                    <h4>Welcome, <br/><?php echo "{$_COOKIE['name']}" ?>!</h4>
                </div>
                <!-- Patient -->
                <div class="well well">
                    <h4>Patient Info</h4>
                    <ul class="nav nav-pills nav-stacked">
                        <li>Name: <?php echo $_GET["fname"].' '.$_GET["lname"]; ?></li>
                        <li>ID: <?php echo $_GET["id"]; ?></li>
                        <li>Gender: <?php echo $_GET["sex"] ?></li>
                    </ul>
                </div>
                <!-- Back to Patient Activity -->
                <a href="
                    <?php 
                        $link = "activity.php?id=" . $_GET["id"] . "&fname=" . $_GET["fname"] . "&lname=" . $_GET["lname"] . "&sex=" . $_GET["sex"];
                        echo "$link";        
                    ?>" class="btn btn-info btn-lg btn-block">
                    <span class="glyphicon glyphicon-paste"></span> Patient Activity
                </a><br/>                
                <!-- Logout -->
                <a href="logout.php" class="btn btn-info btn-lg btn-block">
                    <span class="glyphicon glyphicon-log-out"></span> Log out
                </a>
            </div>
            <!-- Main Content -->
            <div class="col-sm-10 main">
                <!-- Header -->
                <img src="head.jpg" alt="Allegheny Health Network">
                <h1 class="head">Forbes Regional Hospital <br/> CABG Expense Analyzer </h1><hr>
                <!-- Page Information -->
                <div class="panel panel-default" style="width:100%">
                    <div class="panel-heading"> Please click on the <strong>CABG Surgery</strong>, 
                        <strong>Postoperative Surgery</strong> or <strong>Total Activity</strong>  
                        for the patient report. </div>
                </div>
                <!-- Header with surgery & postop care selection -->
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a data-toggle="pill" href="#surgery"> <h5>CABG Surgery</h5> </a></li>
                    <li><a data-toggle="pill" href="#postop"> <h5>Postoperative Care</h5> </a></li>
                    <li><a data-toggle="pill" href="#total"> <h5>Total Activity</h5> </a></li>
                </ul><br/>
                <div class="tab-content">
                    <!-- Surgery Activity Content -->
                    <div id="surgery" class="tab-pane fade in active">
                        <h5>Hi</h5>
                    </div>    
                    <!-- Post-Op Activity Content -->
                    <div id="postop" class="tab-pane fade in">
                        <h5>Hii</h5>
                    </div> 
                    <!-- Total Activity Content -->
                    <div id="total" class="tab-pane fade in">
                        <h5>Hiii</h5>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    </body>
</html>        
