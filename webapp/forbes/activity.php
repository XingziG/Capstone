<?php
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
        <title>Activities</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
                    <!-- Generate Patient Report -->
                    <a href="logout.php" class="btn btn-info btn-lg btn-block">
                        <span class="glyphicon glyphicon-paste"></span> Patient Report
                    </a><br/>                
                    <!-- Logout -->
                    <a href="logout.php" class="btn btn-info btn-lg btn-block">
                        <span class="glyphicon glyphicon-log-out"></span> Log out
                    </a>
                </div>
                <!-- Main Content -->
                <div class="col-sm-9 main">
                    <img src="head.jpg" alt="Allegheny Health Network">
                    <h1 class="head">Forbes Regional Hospital <br/> CABG Expense Analyzer </h1><hr>
                    <!-- Header with surgery & postop care selection -->
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#surgery"> <h5>CABG Surgery</h5> </a></li>
                        <li><a data-toggle="pill" href="#postop"> <h5>Postoperative Care</h5> </a></li>
                    </ul>
                    <!-- Activity Content -->
                    <div class="tab-content">
                        <!-- Surgery Activity Content -->
                        <div id="surgery" class="tab-pane fade in active">
                            <h3> Surgery Activities </h3>
                            <p>Please type in the activities.</p>
                            <div class="panel-group" id="surgery2">
                                <!--Direct labor-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#labor"> Direct Labor </a>
                                        </h4>
                                    </div>
                                    <div id="labor" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            Direct labor
                                        </div>
                                    </div>
                                </div>
                                <!--Direct material-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#material"> Direct Material </a>
                                        </h4>
                                    </div>
                                    <div id="material" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Direct material
                                        </div>
                                    </div> 
                                </div>    
                                <!--Overhead-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#overhead"> Overhead </a>
                                        </h4>
                                    </div>
                                    <div id="overhead" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Overhead
                                        </div>
                                    </div>                             
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-lg center-block" name="surgery">Submit</button>
                        </div>
                        <!-- Post-Op Care Content -->
                        <div id="postop" class="tab-pane fade in">
                            <div class="panel panel-default" style="width:100%">
                                <div class="panel-heading"> Please click on the <strong>day</strong> of the care and the 
                                <strong>actor</strong> to fill in the activity time, frequency and actor's name. </div>
                            </div>
                            <!-- Post-Op Day Selection -->
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a data-toggle="tab" href="#day0"> Day 0 </a></li>
                                <li><a data-toggle="pill" href="#day1"> Day 1 </a></li>
                                <li><a data-toggle="pill" href="#day2"> Day 2 - Day X </a></li>
                                <li><a data-toggle="pill" href="#dday"> Discharge Day </a></li>
                            </ul>
                            <!-- Content for each Post-Op Day -->
                            <div class="tab-content">
                                <div id="day0" class="tab-pane fade in active">
                                    <div class="panel-group" id="postday0">
                                        <!--RN-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#postday0" href="#postday0-rn"> Registered Nurse </a>
                                                </h4>
                                            </div>
                                            <!--RN table-->
                                            <div id="postday0-rn" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <table id="rn" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Stay With Patient (Shift 1)</td>
                                                                <td><input type="text" id="d0-rn-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d0-rn-r1-time" name="time" value="8"></td>
                                                                <td><input type="text" id="d0-rn-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Stay With Patient (Shift 2)</td>
                                                                <td><input type="text" id="d0-rn-r2-freq" name="freq"></td>
                                                                <td><input type="text" id="d0-rn-r2-time" name="time" value="8"></td>
                                                                <td><input type="text" id="d0-rn-r2-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--PA-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday0" href="#postday0-pa">Physician Assistant</a>
                                                </h4>
                                            </div>
                                            <div id="postday0-pa" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="pa" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Placing Orders</td>
                                                                <td><input type="text" id="d0-pa-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d0-pa-r1-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d0-pa-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--RT-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday0" href="#postday0-rt">Respiratory Therapist</a>
                                                </h4>
                                            </div>
                                            <div id="postday0-rt" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="rt" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Connect Ventilator</td>
                                                                <td><input type="text" id="d0-rt-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d0-rt-r1-time" name="time" value="20"></td>
                                                                <td><input type="text" id="d0-rt-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg center-block" name="day0">Submit</button>
                                </div>
                                <div id="day1" class="tab-pane fade">                           
                                    <div class="panel-group" id="postday1">
                                        <!--RN-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#postday1" href="#postday1-rn"> Registered Nurse </a>
                                                </h4>
                                            </div>
                                            <!--RN table-->
                                            <div id="postday1-rn" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <table id="rn" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Check Vitals</td>
                                                                <td><input type="text" id="d1-rn-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r1-time" name="time" value="5"></td>
                                                                <td><input type="text" id="d1-rn-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Give Medicine</td>
                                                                <td><input type="text" id="d1-rn-r2-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r2-time" name="time" value="5"></td>
                                                                <td><input type="text" id="d1-rn-r2-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Check X-Ray, EKG</td>
                                                                <td><input type="text" id="d1-rn-r3-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r3-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d1-rn-r3-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Provide Meals</td>
                                                                <td><input type="text" id="d1-rn-r4-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r4-time" name="time" value="15"></td>
                                                                <td><input type="text" id="d1-rn-r4-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Monitor Intake Output</td>
                                                                <td><input type="text" id="d1-rn-r5-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r5-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d1-rn-r5-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Stand Patient</td>
                                                                <td><input type="text" id="d1-rn-r6-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r6-time" name="time" value="15"></td>
                                                                <td><input type="text" id="d1-rn-r6-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr> 
                                                            <tr>
                                                            <td>Walk Patient</td>
                                                                <td><input type="text" id="d1-rn-r7-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r7-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d1-rn-r7-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Family Education</td>
                                                                <td><input type="text" id="d1-rn-r8-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r8-time" name="time" value="90"></td>
                                                                <td><input type="text" id="d1-rn-r8-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>     
                                                            <tr>
                                                            <td>Clean Patient</td>
                                                                <td><input type="text" id="d1-rn-r9-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rn-r9-time" name="time" value="60"></td>
                                                                <td><input type="text" id="d1-rn-r9-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>                                                             
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--PA-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday1" href="#postday1-pa">Physician Assistant</a>
                                                </h4>
                                            </div>
                                            <div id="postday1-pa" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="pa" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Check Lab Results</td>
                                                                <td><input type="text" id="d1-pa-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-pa-r1-time" name="time" value="5"></td>
                                                                <td><input type="text" id="d1-pa-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Talk to Patient, Nurse</td>
                                                                <td><input type="text" id="d1-pa-r2-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-pa-r2-time" name="time" value="15"></td>
                                                                <td><input type="text" id="d1-pa-r2-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Place Orders, Write Notes</td>
                                                                <td><input type="text" id="d1-pa-r3-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-pa-r3-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d1-pa-r3-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--RT-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday1" href="#postday1-rt">Respiratory Therapist</a>
                                                </h4>
                                            </div>
                                            <div id="postday1-rt" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="rt" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Extubation Process</td>
                                                                <td><input type="text" id="d1-rt-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rt-r1-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d1-rt-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>                                    
                                        <!--IC-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday1" href="#postday1-ic">IC Doctor</a>
                                                </h4>
                                            </div>
                                            <div id="postday1-ic" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="ic" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Take Rounds</td>
                                                                <td><input type="text" id="d1-rt-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d1-rt-r1-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d1-rt-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>                                    
                                        <!--CM-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday1" href="#postday1-cm">Case Manger</a>
                                                </h4>
                                            </div>
                                            <div id="postday1-cm" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="cm" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Plan, Review Case</td>
                                                                <td><input type="text" id="d2-cm-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-cm-r1-time" name="time" value="20"></td>
                                                                <td><input type="text" id="d2-cm-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg center-block" name="day1">Submit</button>
                                </div>
                                <div id="day2" class="tab-pane fade">
                                    <div class="panel-group" id="postday2">
                                        <!--RN-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#postday2" href="#postday2-rn"> Registered Nurse </a>
                                                </h4>
                                            </div>
                                            <!--RN table-->
                                            <div id="postday2-rn" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <table id="rn" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Check Vitals</td>
                                                                <td><input type="text" id="d2-rn-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r1-time" name="time" value="5"></td>
                                                                <td><input type="text" id="d2-rn-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Give Medicine</td>
                                                                <td><input type="text" id="d2-rn-r2-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r2-time" name="time" value="5"></td>
                                                                <td><input type="text" id="d2-rn-r2-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Check X-Ray, EKG</td>
                                                                <td><input type="text" id="d2-rn-r3-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r3-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d2-rn-r3-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Provide Meals</td>
                                                                <td><input type="text" id="d2-rn-r4-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r4-time" name="time" value="15"></td>
                                                                <td><input type="text" id="d2-rn-r4-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Monitor Intake Output</td>
                                                                <td><input type="text" id="d2-rn-r5-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r5-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d2-rn-r5-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Stand Patient</td>
                                                                <td><input type="text" id="d2-rn-r6-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r6-time" name="time" value="15"></td>
                                                                <td><input type="text" id="d2-rn-r6-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr> 
                                                            <tr>
                                                            <td>Walk Patient</td>
                                                                <td><input type="text" id="d2-rn-r7-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r7-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d2-rn-r7-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Family Education</td>
                                                                <td><input type="text" id="d2-rn-r8-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r8-time" name="time" value="90"></td>
                                                                <td><input type="text" id="d2-rn-r8-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>     
                                                            <tr>
                                                            <td>Clean Patient</td>
                                                                <td><input type="text" id="d2-rn-r9-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-rn-r9-time" name="time" value="60"></td>
                                                                <td><input type="text" id="d2-rn-r9-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>                                                             
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--PA-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday2" href="#postday2-pa">Physician Assistant</a>
                                                </h4>
                                            </div>
                                            <div id="postday2-pa" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="pa" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Check Lab Results</td>
                                                                <td><input type="text" id="d2-pa-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-pa-r1-time" name="time" value="5"></td>
                                                                <td><input type="text" id="d2-pa-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Talk to Patient, Nurse</td>
                                                                <td><input type="text" id="d2-pa-r2-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-pa-r2-time" name="time" value="15"></td>
                                                                <td><input type="text" id="d2-pa-r2-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Place Orders, Write Notes</td>
                                                                <td><input type="text" id="d2-pa-r3-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-pa-r3-time" name="time" value="10"></td>
                                                                <td><input type="text" id="d2-pa-r3-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--CM-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postday2" href="#postday2-cm">Case Manger</a>
                                                </h4>
                                            </div>
                                            <div id="postday2-cm" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="cm" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Plan, Review Case</td>
                                                                <td><input type="text" id="d2-cm-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="d2-cm-r1-time" name="time" value="20"></td>
                                                                <td><input type="text" id="d2-cm-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg center-block" name="day2">Submit</button>
                                </div>
                                <div id="dday" class="tab-pane fade">
                                    <div class="panel-group" id="postdday">
                                        <!--RN-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#postdday" href="#postdday-rn"> Registered Nurse </a>
                                                </h4>
                                            </div>
                                            <!--RN table-->
                                            <div id="postdday-rn" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <table id="rn" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Check Vitals</td>
                                                                <td><input type="text" id="dd-rn-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r1-time" name="time" value="5"></td>
                                                                <td><input type="text" id="dd-rn-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Give Medicine</td>
                                                                <td><input type="text" id="dd-rn-r2-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r2-time" name="time" value="5"></td>
                                                                <td><input type="text" id="dd-rn-r2-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Check X-Ray, EKG</td>
                                                                <td><input type="text" id="dd-rn-r3-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r3-time" name="time" value="10"></td>
                                                                <td><input type="text" id="dd-rn-r3-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Provide Meals</td>
                                                                <td><input type="text" id="dd-rn-r4-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r4-time" name="time" value="15"></td>
                                                                <td><input type="text" id="dd-rn-r4-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Monitor Intake Output</td>
                                                                <td><input type="text" id="dd-rn-r5-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r5-time" name="time" value="10"></td>
                                                                <td><input type="text" id="dd-rn-r5-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Stand Patient</td>
                                                                <td><input type="text" id="dd-rn-r6-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r6-time" name="time" value="15"></td>
                                                                <td><input type="text" id="dd-rn-r6-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr> 
                                                            <tr>
                                                            <td>Walk Patient</td>
                                                                <td><input type="text" id="dd-rn-r7-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r7-time" name="time" value="10"></td>
                                                                <td><input type="text" id="dd-rn-r7-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Family Education</td>
                                                                <td><input type="text" id="dd-rn-r8-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-rn-r8-time" name="time" value="90"></td>
                                                                <td><input type="text" id="dd-rn-r8-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>                                                    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--PA-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postdday" href="#postdday-pa">Physician Assistant</a>
                                                </h4>
                                            </div>
                                            <div id="postdday-pa" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="pa" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Write Discharge Summary</td>
                                                                <td><input type="text" id="dd-pa-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-pa-r1-time" name="time" value="75"></td>
                                                                <td><input type="text" id="dd-pa-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--CM-->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#postdday" href="#postdday-cm">Case Manger</a>
                                                </h4>
                                            </div>
                                            <div id="postdday-cm" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table id="cm" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Frequency</th>
                                                                <th>Time (Minutes)</th>
                                                                <th>Performer</th>                                                        
                                                                <th>Total Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>Talk to Patient, Family, etc</td>
                                                                <td><input type="text" id="dd-cm-r1-freq" name="freq"></td>
                                                                <td><input type="text" id="dd-cm-r1-time" name="time" value="120"></td>
                                                                <td><input type="text" id="dd-cm-r1-perf" name="perf" autocomplete="on"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Check out date -->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="form-group">
                                                    <label class="control-label"> Check-Out Date </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text" id="datepicker" name="cday" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg center-block" name="dday">Submit</button>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                // add datepicker
                $( "#datepicker" ).each(function(){
                    $(this).datepicker({
                        dateFormat: "yy-mm-dd",
                        yearRange: "-100:+0",
                        changeMonth: true,
                        changeYear: true,
                        maxDate: 0
                    });
                });
                // calculate total cost
                $('input[name=freq],input[name=time]').keyup(function(e) {
                    var $row = $(this).parent().parent();
                    var total = parseFloat($row.find('input[name=freq]').val() * $row.find('input[name=time]').val());
                    //update the row total
                    $row.find('.total').text(total);
                }); 
            });
        </script> 
    </body>
</html>

<!-- To do: 1. Future work: add actors & corresponding activities
            2. connect to db - display entered info
            4. Visualization / Report
-->