<?php
include 'patient_functions.php';
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
                    <a href="
                        <?php 
                            $link = "patient_report.php?id=" . $_GET["id"] . "&fname=" . $_GET["fname"] . "&lname=" . $_GET["lname"] . "&sex=" . $_GET["sex"];
                            echo "$link";        
                        ?>" class="btn btn-info btn-lg btn-block">
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
                    <div class="panel panel-default" style="width:100%">
                        <div class="panel-heading"> Please click on the <strong>CABG Surgery</strong> or 
                            <strong>Postoperative Surgery</strong> and then the <strong>actor</strong> 
                            to fill in the activity time, frequency and actor's name. </div>
                    </div>
                    <!-- Header with surgery & postop care selection -->
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#surgery"> <h5>CABG Surgery</h5> </a></li>
                        <li><a data-toggle="pill" href="#postop"> <h5>Postoperative Care</h5> </a></li>
                    </ul><br/>
                    <!-- Activity Content -->
                    <div class="tab-content">
                        <!-- Surgery Activity Content -->
                        <div id="surgery" class="tab-pane fade in active">
                            <form method="POST" action="active_handler.php">
                                <input type="hidden" name="pid" value="<?php echo $_GET["id"]; ?>">
                                <div class="panel-group" id="surgery2">
                                <!-- Anesthesiologist -->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#anesthesiologist"> Anesthesiologist </a>
                                        </h4>
                                    </div>
                                    <!-- Anesthesiologist Table -->
                                    <div id="anesthesiologist" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <table id="sg-an" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Time (Minutes)</th>
                                                        <th>Performer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Transesophaegal Echocardiogram</td>
                                                        <td><input type="text" id="sg-an-r1-time" name="1-0-1-t" 
                                                                   value="<?php echo get_result('time_duration',1,0,1) ?>"></td>
                                                        <td><input type="text" id="sg-an-r1-perf" name="1-0-1-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',1,0,1) ?>"></td>                                                        
                                                    </tr>
                                                    <tr>
                                                    <td>Surgery Completion OR Departure</td>
                                                        <td><input type="text" id="sg-an-r2-time" name="6-0-1-t" 
                                                                   value="<?php echo get_result('time_duration',6,0,1) ?>"></td>
                                                        <td><input type="text" id="sg-an-r2-perf" name="6-0-1-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',6,0,1) ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Cardiovascular Surgeon -->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#cs"> Cardiovascular Surgeon </a>
                                        </h4>
                                    </div>
                                    <!-- CS Table -->
                                    <div id="cs" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table id="sg-cs" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Time (Minutes)</th>
                                                        <th>Performer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Median Sternotomy</td>
                                                        <td><input type="text" id="sg-cs-r1-time" name="4-0-3-t"
                                                                   value="<?php echo get_result('time_duration',4,0,3) ?>"></td>
                                                        <td><input type="text" id="sg-cs-r1-perf" name="4-0-3-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',4,0,3) ?>"></td>
                                                    </tr>                                                    
                                                    <tr>
                                                    <td>Grafting</td>
                                                        <td><input type="text" id="sg-cs-r2-time" name="5-0-3-t"
                                                                   value="<?php echo get_result('time_duration',5,0,3) ?>"></td>
                                                        <td><input type="text" id="sg-cs-r2-perf" name="5-0-3-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',5,0,3) ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>                                           
                                <!-- Physician Assistant -->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#physician"> Physician Assistant </a>
                                        </h4>
                                    </div>
                                    <!-- PA Table -->
                                    <div id="physician" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table id="sg-pa" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Time (Minutes)</th>
                                                        <th>Performer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Transesophaegal Echocardiogram</td>
                                                        <td><input type="text" id="sg-pa-r1-time" name="1-0-10-t" 
                                                                   value="<?php echo get_result('time_duration',1,0,10) ?>"></td>
                                                        <td><input type="text" id="sg-pa-r1-perf" name="1-0-10-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',1,0,10) ?>"></td>                                                        
                                                    </tr>
                                                    <tr>
                                                    <td>Pre-Surgical Procedures</td>
                                                        <td><input type="text" id="sg-pa-r2-time" name="2-0-10-t"
                                                                   value="<?php echo get_result('time_duration',2,0,10) ?>"></td>
                                                        <td><input type="text" id="sg-pa-r2-perf" name="2-0-10-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',2,0,10) ?>"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Scavenging of the Saphenous Vein</td>
                                                        <td><input type="text" id="sg-pa-r3-time" name="3-0-10-t"
                                                                   value="<?php echo get_result('time_duration',3,0,10) ?>"></td>
                                                        <td><input type="text" id="sg-pa-r3-perf" name="3-0-10-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',3,0,10) ?>"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Grafting</td>
                                                        <td><input type="text" id="sg-pa-r4-time" name="5-0-10-t"
                                                                   value="<?php echo get_result('time_duration',5,0,10) ?>"></td>
                                                        <td><input type="text" id="sg-pa-r4-perf" name="5-0-10-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',5,0,10) ?>"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Surgery Completion to OR Departure</td>
                                                        <td><input type="text" id="sg-pa-r5-time" name="6-0-10-t"
                                                                   value="<?php echo get_result('time_duration',6,0,10) ?>"></td>
                                                        <td><input type="text" id="sg-pa-r5-perf" name="6-0-10-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',6,0,10) ?>"></td>
                                                    </tr>                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Registered Nurse -->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#nurse"> Registered Nurse </a>
                                        </h4>
                                    </div>
                                    <!-- RN Table -->
                                    <div id="nurse" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table id="sg-rn" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Time (Minutes)</th>
                                                        <th>Performer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Pre-Surgical Procedures</td>
                                                        <td><input type="text" id="sg-rn-r1-time" name="2-0-8-t"
                                                                   value="<?php echo get_result('time_duration',2,0,8) ?>"></td>
                                                        <td><input type="text" id="sg-rn-r1-perf" name="2-0-8-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',2,0,8) ?>"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Surgery Completion to OR Departure</td>
                                                        <td><input type="text" id="sg-rn-r2-time" name="6-0-8-t"
                                                                   value="<?php echo get_result('time_duration',6,0,8) ?>"></td>
                                                        <td><input type="text" id="sg-rn-r2-perf" name="6-0-8-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',6,0,8) ?>"></td>
                                                    </tr>                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scub Tech -->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#scrub"> Scrub Tech </a>
                                        </h4>
                                    </div>
                                    <!-- ST Table -->
                                    <div id="scrub" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table id="sg-st" class="table table-striped" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Time (Minutes)</th>
                                                        <th>Performer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Pre-Surgical Procedures</td>
                                                        <td><input type="text" id="sg-st-r1-time" name="2-0-13-t"
                                                                   value="<?php echo get_result('time_duration',2,0,13) ?>"></td>
                                                        <td><input type="text" id="sg-st-r1-perf" name="2-0-13-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',2,0,13) ?>"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Median Sternotomy</td>
                                                        <td><input type="text" id="sg-st-r2-time" name="4-0-13-t"
                                                                   value="<?php echo get_result('time_duration',4,0,13) ?>"></td>
                                                        <td><input type="text" id="sg-st-r2-perf" name="4-0-13-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',4,0,13) ?>"></td>
                                                    </tr>                                                    
                                                    <tr>
                                                    <td>Grafting</td>
                                                        <td><input type="text" id="sg-st-r3-time" name="5-0-13-t"
                                                                   value="<?php echo get_result('time_duration',5,0,13) ?>"></td>
                                                        <td><input type="text" id="sg-st-r3-perf" name="5-0-13-p" autocomplete="on"
                                                                   value="<?php echo get_result('performer',5,0,13) ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--Direct material-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#surgery2" href="#material"> Direct Material (DRG Code) </a>
                                        </h4>
                                    </div>
                                    <div id="material" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4"> DRG Code </label>
                                                <select class="form-control" name="drg" style="width:500px" required>
                                                    <option value="7918.88" <?php if(get_dm() == 7918.88) echo 'selected'?>>233 - Coronary bypass with cardiac catheterization with MCC </option>
                                                    <option value="6774.33" <?php if(get_dm() == 6774.33) echo 'selected'?>>234 - Coronary bypass with cardiac catheterization without MCC </option>
                                                    <option value="6490.10" <?php if(get_dm() == 6490.10) echo 'selected'?>>235 - Coronary bypass without cardiac catheterization with MCC </option>
                                                    <option value="6095.94" <?php if(get_dm() == 6095.94) echo 'selected'?>>236 - Coronary bypass without cardiac catheterization without MCC </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <button type="submit" class="btn btn-info btn-lg center-block" name="surgery">Submit CABG</button>
                            </form>    
                        </div>
                        <!-- Post-Op Care Content -->
                        <div id="postop" class="tab-pane fade in">
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
                                    <form method="POST" action="active_handler.php">
                                        <input type="hidden" name="pid" value="<?php echo $_GET["id"]; ?>">
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
                                                            <td>Stay With Patient</td>
                                                                <td><input type="text" id="d0-rn-r1-freq" name="7-0-8-freq"
                                                                           value="<?php echo get_result('freq',7,0,8) ?>"></td>
                                                                <td><input type="text" id="d0-rn-r1-time" name="7-0-8-time"
                                                                           value="<?php echo get_result('time_duration',7,0,8) ?>"></td>
                                                                <td><input type="text" id="d0-rn-r1-perf" name="7-0-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',7,0,8) ?>"></td>
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
                                                                <td><input type="text" id="d0-pa-r1-freq" name="16-0-10-freq"
                                                                           value="<?php echo get_result('freq',16,0,10) ?>"></td>
                                                                <td><input type="text" id="d0-pa-r1-time" name="16-0-10-time"
                                                                           value="<?php echo get_result('time_duration',16,0,10) ?>"></td>
                                                                <td><input type="text" id="d0-pa-r1-perf" name="16-0-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',16,0,10) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--RT no activity in db!! -->
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
                                                                <td><input type="text" id="d0-rt-r1-freq" name="19-0-12-freq"
                                                                           value="<?php echo get_result('freq',19,0,12) ?>"></td>
                                                                <td><input type="text" id="d0-rt-r1-time" name="19-0-12-time"
                                                                           value="<?php echo get_result('time_duration',19,0,12) ?>"></td>
                                                                <td><input type="text" id="d0-rt-r1-perf" name="19-0-12-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',19,0,12) ?>"></td>
                                                                <td><span class="total"></span></td>                 
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <button type="submit" class="btn btn-info btn-lg center-block" name="day0">Submit Day0</button>
                                    </form>
                                </div>  
                                <div id="day1" class="tab-pane fade">  
                                    <form method="POST" action="active_handler.php">
                                        <input type="hidden" name="pid" value="<?php echo $_GET["id"]; ?>">
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
                                                                <td><input type="text" id="d1-rn-r1-freq" name="8-1-8-freq"
                                                                           value="<?php echo get_result('freq',8,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r1-time" name="8-1-8-time"
                                                                           value="<?php echo get_result('time_duration',8,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r1-perf" name="8-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',8,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Administer Medicine</td>
                                                                <td><input type="text" id="d1-rn-r2-freq" name="9-1-8-freq"
                                                                           value="<?php echo get_result('freq',9,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r2-time" name="9-1-8-time"
                                                                           value="<?php echo get_result('time_duration',9,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r2-perf" name="9-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',9,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Check X-Ray, EKG</td>
                                                                <td><input type="text" id="d1-rn-r3-freq" name="10-1-8-freq"
                                                                           value="<?php echo get_result('freq',10,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r3-time" name="10-1-8-time"
                                                                           value="<?php echo get_result('time_duration',10,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r3-perf" name="10-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',10,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Provide Meals</td>
                                                                <td><input type="text" id="d1-rn-r4-freq" name="11-1-8-freq"
                                                                           value="<?php echo get_result('freq',11,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r4-time" name="11-1-8-time"
                                                                           value="<?php echo get_result('time_duration',11,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r4-perf" name="11-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',11,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                     
                                                            </tr>
                                                            <tr>
                                                            <td>Monitor Intake Output</td>
                                                                <td><input type="text" id="d1-rn-r5-freq" name="12-1-8-freq"
                                                                           value="<?php echo get_result('freq',12,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r5-time" name="12-1-8-time"
                                                                           value="<?php echo get_result('time_duration',12,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r5-perf" name="12-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',12,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                               
                                                            </tr>  
                                                            <tr>
                                                            <td>Stand Patient</td>
                                                                <td><input type="text" id="d1-rn-r6-freq" name="23-1-8-freq"
                                                                           value="<?php echo get_result('freq',23,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r6-time" name="23-1-8-time"
                                                                           value="<?php echo get_result('time_duration',23,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r6-perf" name="23-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',23,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr> 
                                                            <tr>
                                                            <td>Walk Patient</td>
                                                                <td><input type="text" id="d1-rn-r7-freq" name="13-1-8-freq"
                                                                           value="<?php echo get_result('freq',13,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r7-time" name="13-1-8-time"
                                                                           value="<?php echo get_result('time_duration',13,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r7-perf" name="13-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',13,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Family Education</td>
                                                                <td><input type="text" id="d1-rn-r8-freq" name="14-1-8-freq"
                                                                           value="<?php echo get_result('freq',14,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r8-time" name="14-1-8-time"
                                                                           value="<?php echo get_result('time_duration',14,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r8-perf" name="14-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',14,1,8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>     
                                                            <tr>
                                                            <td>Clean Patient</td>
                                                                <td><input type="text" id="d1-rn-r9-freq" name="15-1-8-freq"
                                                                           value="<?php echo get_result('freq',15,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r9-time" name="15-1-8-time"
                                                                           value="<?php echo get_result('time_duration',15,1,8) ?>"></td>
                                                                <td><input type="text" id="d1-rn-r9-perf" name="15-1-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',15,1,8) ?>"></td>
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
                                                                <td><input type="text" id="d1-pa-r1-freq" name="17-1-10-freq"
                                                                           value="<?php echo get_result('freq',17,1,10) ?>"></td>
                                                                <td><input type="text" id="d1-pa-r1-time" name="17-1-10-time"
                                                                           value="<?php echo get_result('time_duration',17,1,10) ?>"></td>
                                                                <td><input type="text" id="d1-pa-r1-perf" name="17-1-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',17,1,10) ?>"></td>
                                                                <td><span class="total"></span></td>                                                    
                                                            </tr>
                                                            <tr>
                                                            <td>Talk to Patient, Nurse</td>
                                                                <td><input type="text" id="d1-pa-r2-freq" name="24-1-10-freq"
                                                                           value="<?php echo get_result('freq',24,1,10) ?>"></td>
                                                                <td><input type="text" id="d1-pa-r2-time" name="24-1-10-time"
                                                                           value="<?php echo get_result('time_duration',24,1,10) ?>"></td>
                                                                <td><input type="text" id="d1-pa-r2-perf" name="24-1-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',24,1,10) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Place Orders, Write Notes</td>
                                                                <td><input type="text" id="d1-pa-r3-freq" name="16-1-10-freq"
                                                                           value="<?php echo get_result('freq',16,1,10) ?>"></td>
                                                                <td><input type="text" id="d1-pa-r3-time" name="16-1-10-time"
                                                                           value="<?php echo get_result('time_duration',16,1,10) ?>"></td>
                                                                <td><input type="text" id="d1-pa-r3-perf" name="16-1-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',16,1,10) ?>"></td>
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
                                                                <td><input type="text" id="d1-rt-r1-freq" name="20-1-12-freq"
                                                                           value="<?php echo get_result('freq',20,1,12) ?>"></td>
                                                                <td><input type="text" id="d1-rt-r1-time" name="20-1-12-time"
                                                                           value="<?php echo get_result('time_duration',20,1,12) ?>"></td>
                                                                <td><input type="text" id="d1-rt-r1-perf" name="20-1-12-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',20,1,12) ?>"></td>
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
                                                                <td><input type="text" id="d2-cm-r1-freq" name="21-1-4-freq"
                                                                           value="<?php echo get_result('freq',21,1,4) ?>"></td>
                                                                <td><input type="text" id="d2-cm-r1-time" name="21-1-4-time"
                                                                           value="<?php echo get_result('time_duration',21,1,4) ?>"></td>
                                                                <td><input type="text" id="d2-cm-r1-perf" name="21-1-4-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',21,1,4) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <button type="submit" class="btn btn-info btn-lg center-block" name="day1">Submit Day1</button>
                                    </form>
                                </div>
                                <div id="day2" class="tab-pane fade">
                                    <form method="POST" action="active_handler.php">
                                        <input type="hidden" name="pid" value="<?php echo $_GET["id"]; ?>">
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
                                                                <td><input type="text" id="d2-rn-r1-freq" name="8-n-8-freq"
                                                                           value="<?php echo get_result('freq',8,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r1-time" name="8-n-8-time"
                                                                           value="<?php echo get_result('time_duration',8,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r1-perf" name="8-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',8,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Give Medicine</td>
                                                                <td><input type="text" id="d2-rn-r2-freq" name="9-n-8-freq"
                                                                           value="<?php echo get_result('freq',9,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r2-time" name="9-n-8-time"
                                                                           value="<?php echo get_result('time_duration',9,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r2-perf" name="9-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',9,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Check X-Ray, EKG</td>
                                                                <td><input type="text" id="d2-rn-r3-freq" name="10-n-8-freq"
                                                                           value="<?php echo get_result('freq',10,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r3-time" name="10-n-8-time"
                                                                           value="<?php echo get_result('time_duration',10,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r3-perf" name="10-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',10,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Provide Meals</td>
                                                                <td><input type="text" id="d2-rn-r4-freq" name="11-n-8-freq"
                                                                           value="<?php echo get_result('freq',11,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r4-time" name="11-n-8-time"
                                                                           value="<?php echo get_result('time_duration',11,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r4-perf" name="11-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',11,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Monitor Intake Output</td>
                                                                <td><input type="text" id="d2-rn-r5-freq" name="12-n-8-freq"
                                                                           value="<?php echo get_result('freq',12,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r5-time" name="12-n-8-time"
                                                                           value="<?php echo get_result('time_duration',12,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r5-perf" name="12-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',12,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Stand Patient</td>
                                                                <td><input type="text" id="d2-rn-r6-freq" name="23-n-8-freq"
                                                                           value="<?php echo get_result('freq',23,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r6-time" name="23-n-8-time"
                                                                           value="<?php echo get_result('time_duration',23,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r6-perf" name="23-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',23,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr> 
                                                            <tr>
                                                            <td>Walk Patient</td>
                                                                <td><input type="text" id="d2-rn-r7-freq" name="13-n-8-freq"
                                                                           value="<?php echo get_result('freq',13,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r7-time" name="13-n-8-time"
                                                                           value="<?php echo get_result('time_duration',13,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r7-perf" name="13-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',13,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Family Education</td>
                                                                <td><input type="text" id="d2-rn-r8-freq" name="14-n-8-freq"
                                                                           value="<?php echo get_result('freq',14,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r8-time" name="14-n-8-time"
                                                                           value="<?php echo get_result('time_duration',14,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r8-perf" name="14-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',14,'n',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>     
                                                            <tr>
                                                            <td>Clean Patient</td>
                                                                <td><input type="text" id="d2-rn-r9-freq" name="15-n-8-freq"
                                                                           value="<?php echo get_result('freq',15,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r9-time" name="15-n-8-time"
                                                                           value="<?php echo get_result('time_duration',15,'n',8) ?>"></td>
                                                                <td><input type="text" id="d2-rn-r9-perf" name="15-n-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',15,'n',8) ?>"></td>
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
                                                                <td><input type="text" id="d2-pa-r1-freq" name="17-n-10-freq"
                                                                           value="<?php echo get_result('freq',17,'n',10) ?>"></td>
                                                                <td><input type="text" id="d2-pa-r1-time" name="17-n-10-time"
                                                                           value="<?php echo get_result('time_duration',17,'n',10) ?>"></td>
                                                                <td><input type="text" id="d2-pa-r1-perf" name="17-n-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',17,'n',10) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Talk to Patient, Nurse</td>
                                                                <td><input type="text" id="d2-pa-r2-freq" name="24-n-10-freq"
                                                                           value="<?php echo get_result('freq',24,'n',10) ?>"></td>
                                                                <td><input type="text" id="d2-pa-r2-time" name="24-n-10-time"
                                                                           value="<?php echo get_result('time_duration',24,'n',10) ?>"></td>
                                                                <td><input type="text" id="d2-pa-r2-perf" name="24-n-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',24,'n',10) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Place Orders, Write Notes</td>
                                                                <td><input type="text" id="d2-pa-r3-freq" name="16-n-10-freq"
                                                                           value="<?php echo get_result('freq',16,'n',10) ?>"></td>
                                                                <td><input type="text" id="d2-pa-r3-time" name="16-n-10-time"
                                                                           value="<?php echo get_result('time_duration',16,'n',10) ?>"></td>
                                                                <td><input type="text" id="d2-pa-r3-perf" name="16-n-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',16,'n',10) ?>"></td>
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
                                                                <td><input type="text" id="d2-cm-r1-freq" name="21-n-4-freq"
                                                                           value="<?php echo get_result('freq',21,'n',4) ?>"></td>
                                                                <td><input type="text" id="d2-cm-r1-time" name="21-n-4-time"
                                                                           value="<?php echo get_result('time_duration',21,'n',4) ?>"></td>
                                                                <td><input type="text" id="d2-cm-r1-perf" name="21-n-4-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',21,'n',4) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <button type="submit" class="btn btn-info btn-lg center-block" name="day2">Submit Day2-X</button>
                                    </form>    
                                </div>
                                <div id="dday" class="tab-pane fade">
                                    <form method="POST" action="active_handler.php">
                                        <input type="hidden" name="pid" value="<?php echo $_GET["id"]; ?>">
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
                                                                <td><input type="text" id="dd-rn-r1-freq" name="8-d-8-freq"
                                                                           value="<?php echo get_result('freq',8,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r1-time" name="8-d-8-time"
                                                                           value="<?php echo get_result('time_duration',8,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r1-perf" name="8-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',8,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Give Medicine</td>
                                                                <td><input type="text" id="dd-rn-r2-freq" name="9-d-8-freq"
                                                                           value="<?php echo get_result('freq',9,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r2-time" name="9-d-8-time"
                                                                           value="<?php echo get_result('time_duration',9,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r2-perf" name="9-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',9,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Check X-Ray, EKG</td>
                                                                <td><input type="text" id="dd-rn-r3-freq" name="10-d-8-freq"
                                                                           value="<?php echo get_result('freq',10,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r3-time" name="10-d-8-time"
                                                                           value="<?php echo get_result('time_duration',10,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r3-perf" name="10-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',10,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Provide Meals</td>
                                                                <td><input type="text" id="dd-rn-r4-freq" name="11-d-8-freq" 
                                                                           value="<?php echo get_result('freq',11,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r4-time" name="11-d-8-time"
                                                                           value="<?php echo get_result('time_duration',11,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r4-perf" name="11-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',11,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Monitor Intake Output</td>
                                                                <td><input type="text" id="dd-rn-r5-freq" name="12-d-8-freq"
                                                                           value="<?php echo get_result('freq',12,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r5-time" name="12-d-8-time"
                                                                           value="<?php echo get_result('time_duration',12,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r5-perf" name="12-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',12,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>  
                                                            <tr>
                                                            <td>Stand Patient</td>
                                                                <td><input type="text" id="dd-rn-r6-freq" name="23-d-8-freq"
                                                                           value="<?php echo get_result('freq',23,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r6-time" name="23-d-8-time"
                                                                           value="<?php echo get_result('time_duration',23,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r6-perf" name="23-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',23,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr> 
                                                            <tr>
                                                            <td>Walk Patient</td>
                                                                <td><input type="text" id="dd-rn-r7-freq" name="13-d-8-freq"
                                                                           value="<?php echo get_result('freq',13,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r7-time" name="13-d-8-time"
                                                                           value="<?php echo get_result('time_duration',13,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r7-perf" name="13-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',13,'d',8) ?>"></td>
                                                                <td><span class="total"></span></td>                                                        
                                                            </tr>
                                                            <tr>
                                                            <td>Family Education</td>
                                                                <td><input type="text" id="dd-rn-r8-freq" name="14-d-8-freq"
                                                                           value="<?php echo get_result('freq',14,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r8-time" name="14-d-8-time"
                                                                           value="<?php echo get_result('time_duration',14,'d',8) ?>"></td>
                                                                <td><input type="text" id="dd-rn-r8-perf" name="14-d-8-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',14,'d',8) ?>"></td>
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
                                                                <td><input type="text" id="dd-pa-r1-freq" name="18-d-10-freq"
                                                                           value="<?php echo get_result('freq',18,'d',10) ?>"></td>
                                                                <td><input type="text" id="dd-pa-r1-time" name="18-d-10-time"
                                                                           value="<?php echo get_result('time_duration',18,'d',10) ?>"></td>
                                                                <td><input type="text" id="dd-pa-r1-perf" name="18-d-10-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',18,'d',10) ?>"></td>
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
                                                            <td>Talk to Family / Social Worker</td>
                                                                <td><input type="text" id="dd-cm-r1-freq" name="22-d-4-freq"
                                                                           value="<?php echo get_result('freq',22,'d',4) ?>"></td>
                                                                <td><input type="text" id="dd-cm-r1-time" name="22-d-4-time"
                                                                           value="<?php echo get_result('time_duration',22,'d',4) ?>"></td>
                                                                <td><input type="text" id="dd-cm-r1-perf" name="22-d-4-perf" autocomplete="on"
                                                                           value="<?php echo get_result('performer',22,'d',4) ?>"></td>
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
                                                        <input class="form-control" type="text" id="datepicker" value="<?php echo get_discharge_day() ?>" name="cday">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <button type="submit" class="btn btn-info btn-lg center-block" name="dday">Submit Discharge Day</button>
                                    </form>    
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
                $("input[name*='freq'],input[name*='time']").keyup(function(e) {
                    var $row = $(this).parent().parent();
                    var total = parseFloat($row.find('input[name*=freq]').val() * $row.find('input[name*=time]').val());
                    //update the row total
                    $row.find('.total').text(total);
                }); 
            });
        </script> 
    </body>
</html>

<!-- To do: 1. Future work: add actors & corresponding activities
-->