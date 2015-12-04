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
function get_cost($type, $rid)
{
    require ('../mysqli_connect.php'); // Connect to the db.
    $pid = $_GET["id"];
    if ($type=='sg') {
        $q = "SELECT SUM(freq * time_duration) as 'Total' FROM reports WHERE (patient_id=$pid AND role_id=$rid AND activity_category='S')";
    } else if ($type=='po') {
        $q = "SELECT SUM(freq * time_duration) as 'Total' FROM reports WHERE (patient_id=$pid AND role_id=$rid AND activity_category='PO')";
    } else {
        $q = "SELECT SUM(freq * time_duration) as 'Total' FROM reports WHERE (patient_id=$pid AND role_id=$rid)";
    }  
    $r = @mysqli_query($dbc, $q);  // run query
    $q2 = "SELECT salary FROM roles WHERE role_id=$rid";   
    $r2 = @mysqli_query($dbc, $q2);  // run query 
    if (mysqli_num_rows($r) == 1 & mysqli_num_rows($r2) == 1) { // ok
        $row = mysqli_fetch_assoc($r);
        $row2 = mysqli_fetch_assoc($r2);
        $result = $row['Total'] * $row2['salary'] / 60;
        return number_format($result,0);
    }
    mysqli_close($dbc);
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
        <title> Patient Report </title>
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
                    <span class="glyphicon glyphicon-copy"></span> Patient Activity
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
                        <strong>Postoperative Surgery</strong> or <strong>CABG Total</strong>  
                        for the patient report. </div>
                </div>
                <!-- Header with surgery & postop care selection -->
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a data-toggle="pill" href="#surgery"> <h5>CABG Surgery</h5> </a></li>
                    <li><a data-toggle="pill" href="#postop"> <h5>Postoperative Care</h5> </a></li>
                    <li><a data-toggle="pill" href="#total"> <h5>CABG Total</h5> </a></li>
                </ul><br/>
                <div class="tab-content">
                    <!-- Surgery Activity Content -->
                    <div id="surgery" class="tab-pane fade in active">
                        <div class="panel-group" id="surgery2">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#surgery2" href="#sg"> CABG Surgery Cost </a>
                                </h4>
                            </div>
                            <!-- Table -->
                            <div id="sg" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <table id="sg-dl" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Direct Labor</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Anesthesiologist</td>
                                                <td><span class="sg" name="sg-an"><?php echo get_cost('to',1) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                                <td>Cardiovascular Surgeon</td>
                                                <td><span class="sg" name="sg-cs"><?php echo get_cost('to',3) ?></span></td>                                                     
                                            </tr> 
                                            <tr>
                                                <td>Physician Assistant</td>
                                                <td><span class="sg" name="sg-pa"><?php echo get_cost('to',10) ?></span></td>
                                            </tr>                                            
                                            <tr>
                                                <td>Registered Nurse</td>
                                                <td><span class="sg" name="sg-rn"><?php echo get_cost('to',8) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                                <td>Scrub Tech</td>
                                                <td><span class="sg" name="sg-st"><?php echo get_cost('to',13) ?></span></td>
                                            </tr>  
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong><span id="sg-result"></span></strong></td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                    <!--Direct Material-->
                                    <table id="sg-dm" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Direct Material</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Other</td>
                                            <td><span name="sg-dm">1</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Overhead-->
                                    <table id="sg-oh" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Overhead</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Other</td>
                                            <td><span name="sg-oh">1000</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>    
                    <!-- Post-Op Activity Content -->
                    <div id="postop" class="tab-pane fade in">
                        <div class="panel-group" id="postop2">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#postop2" href="#po"> Postoperative Care Cost </a>
                                </h4>
                            </div>
                            <!-- Table -->
                            <div id="po" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <table id="po-dl" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Direct Labor</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Case Manager</td>
                                            <td><span class="po" name="po-cm"><?php echo get_cost('to',4) ?></span></td>                                                
                                            </tr>    
                                            <tr>
                                            <td>Physician Assistant</td>
                                            <td><span class="po" name="po-pa"><?php echo get_cost('to',10) ?></span></td>
                                            </tr>                                             
                                            <tr>
                                            <td>Registered Nurse</td>
                                            <td><span class="po" name="po-rn"><?php echo get_cost('to',8) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                            <td>Respiratory Therapist</td>
                                            <td><span class="po" name="po-rt"><?php echo get_cost('to',12) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong><span id="po-result"></span></strong></td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                    <!--Direct Material-->
                                    <table id="po-dm" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Direct Material</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Other</td>
                                            <td><span name="po-dm">1000</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Overhead-->
                                    <table id="po-oh" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Overhead</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Other</td>
                                            <td><span name="po-oh">1000</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>                        
                    </div> 
                    <!-- Total Activity Content -->
                    <div id="total" class="tab-pane fade in">
                        <div class="panel-group" id="total2">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#total2" href="#to"> Total Cost </a>
                                </h4>
                            </div>
                            <!-- Table -->
                            <div id="to" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <table id="to-dl" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Direct Labor</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Anesthesiologist</td>
                                            <td><span class="to" name="to-an"><?php echo get_cost('to',1) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                            <td>Cardiovascular Surgeon</td>
                                            <td><span class="to" name="to-cs"><?php echo get_cost('to',3) ?></span></td>                                                     
                                            </tr>                                            
                                            <tr>
                                            <td>Case Manager</td>
                                            <td><span class="to" name="to-cm"><?php echo get_cost('to',4) ?></span></td>                                                     
                                            </tr>    
                                            <tr>
                                            <td>Physician Assistant</td>
                                            <td><span class="to" name="to-pa"><?php echo get_cost('to',10) ?></span></td>
                                            </tr>                                             
                                            <tr>
                                            <td>Registered Nurse</td>
                                            <td><span class="to" name="to-rn"><?php echo get_cost('to',8) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                            <td>Respiratory Therapist</td>
                                            <td><span class="to" name="to-rt"><?php echo get_cost('to',12) ?></span></td>                                                     
                                            </tr> 
                                            <tr>
                                            <td>Scrub Tech</td>
                                            <td><span class="to" name="to-st"><?php echo get_cost('to',13) ?></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong><span id="to-result"></span></strong></td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                    <!--Direct Material-->
                                    <table id="to-dm" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Direct Material</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Other</td>
                                            <td><span name="to-dm">1000</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Overhead-->
                                    <table id="to-oh" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Overhead</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Other</td>
                                            <td><span name="to-oh">1000</span></td>                                                 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>                        
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <script>
        function calculateSum() {
            var sum = 0;
            $(".sg").each(function() { // iterate through each td based on class
                var value = $(this).text().replace(',', '');
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#sg-result').text(sum);

            var sum = 0;
            // iterate through each td based on class and add the values
            $(".po").each(function() {
                var value = $(this).text().replace(',', '');  
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#po-result').text(sum);

            var sum = 0;
            $(".to").each(function() {
                var value = $(this).text().replace(',', '');
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#to-result').text(sum);
        }
        $(calculateSum);
    </script>
    </body>
</html>        
