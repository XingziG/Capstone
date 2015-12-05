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
    // get days in day2-x
    $qDay = "SELECT DATEDIFF(IFNULL(DATE_SUB(checkout, INTERVAL 1 DAY), CURDATE()), checkin) as 'day' FROM patients WHERE patient_id=$pid";
    $rDay = @mysqli_query($dbc, $qDay);  // run query
    if (mysqli_num_rows($rDay) == 1) { // ok
        $rowDay = mysqli_fetch_assoc($rDay);
        $day = $rowDay['day'];
        if($day > 1) {
            $day -= 1;
        } else {
            $day = 0;
        }
    } else {
        return "error";
    }

    // get time spent 
    if ($type=='sg') {
        $qTime = "SELECT SUM(freq * time_duration) as 'total' FROM reports WHERE (patient_id=$pid AND role_id=$rid AND activity_id<=6)";
    } else if ($type=='po') {
        $qTime = "SELECT
                    (SELECT SUM(freq * time_duration) as 't' FROM reports WHERE patient_id=$pid AND role_id=$rid AND activity_id>6 AND activity_day!='d') +
                    (SELECT $day*SUM(freq * time_duration) as 't' FROM reports WHERE patient_id=$pid AND role_id=$rid AND activity_id>6 AND activity_day='d')
                  AS 'total';";     
    } else {
        $qTime = "SELECT
                    (SELECT SUM(freq * time_duration) as 't' FROM reports WHERE patient_id=$pid AND role_id=$rid AND activity_day!='d') +
                    (SELECT IFNULL($day*SUM(freq * time_duration),0) as 't' FROM reports WHERE patient_id=$pid AND role_id=$rid AND activity_day='d')
                  AS 'total';"; 
    }  
    $rTime = @mysqli_query($dbc, $qTime);  // run query
    // get salary
    $qPay = "SELECT salary FROM roles WHERE role_id=$rid";   
    $rPay = @mysqli_query($dbc, $qPay);  // run query 
    if (mysqli_num_rows($rTime) == 1 & mysqli_num_rows($rPay) == 1) { // ok
        $rowTime = mysqli_fetch_assoc($rTime);
        $rowPay = mysqli_fetch_assoc($rPay);
        $result = $rowTime['total'] * $rowPay['salary'] / 124800; // 52 week * 40 hours * 60 minuts
        return number_format($result,0);
    } else {
        return "error";
    }
    mysqli_close($dbc);
}


function get_bar($graph, $input) {
    require ('../mysqli_connect.php'); // Connect to the db.
    
    $pid = $_GET["id"];
    if ($graph == "cost") {
        if ($input == "hospital") { // get hospital wide cost
            
        } else { // get reimbursement
            
        }
    } else {
        if ($input == "patient") { // get patient stay
            $q = "SELECT DATEDIFF(IFNULL(checkout, CURDATE()), checkin) as 'result' FROM patients WHERE patient_id=$pid";
        } else if ($input == "hospital") { // get hospital wide stay
            
        } else { // get national
            
        }
    }
    
    $r = @mysqli_query($dbc, $q);  // run query
    if (mysqli_num_rows($r) == 1) { // ok
        $rowDay = mysqli_fetch_assoc($r);
        $result = $row['result'];
        return $result;
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
        <script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script> 
        <script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
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
                        for the patient expense report. </div>
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
                                                <th class="col-md-8">Direct Labor</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Anesthesiologist</td>
                                                <td><span class="sg" name="sg-an"><?php echo get_cost('sg',1) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                                <td>Cardiovascular Surgeon</td>
                                                <td><span class="sg" name="sg-cs"><?php echo get_cost('sg',3) ?></span></td>                                                     
                                            </tr> 
                                            <tr>
                                                <td>Physician Assistant</td>
                                                <td><span class="sg" name="sg-pa"><?php echo get_cost('sg',10) ?></span></td>
                                            </tr>                                            
                                            <tr>
                                                <td>Registered Nurse</td>
                                                <td><span class="sg" name="sg-rn"><?php echo get_cost('sg',8) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                                <td>Scrub Tech</td>
                                                <td><span class="sg" name="sg-st"><?php echo get_cost('sg',13) ?></span></td>
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
                                                <th class="col-md-8">Direct Material</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>All Direct Material</td>
                                            <td><span name="sg-dm">1</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Overhead-->
                                    <table id="sg-oh" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-md-8">Overhead</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>All Overhead</td>
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
                                                <th class="col-md-8">Direct Labor</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Case Manager</td>
                                            <td><span class="po" name="po-cm"><?php echo get_cost('po',4) ?></span></td>                                                
                                            </tr>    
                                            <tr>
                                            <td>Physician Assistant</td>
                                            <td><span class="po" name="po-pa"><?php echo get_cost('po',10) ?></span></td>
                                            </tr>                                             
                                            <tr>
                                            <td>Registered Nurse</td>
                                            <td><span class="po" name="po-rn"><?php echo get_cost('po',8) ?></span></td>                                                     
                                            </tr>
                                            <tr>
                                            <td>Respiratory Therapist</td>
                                            <td><span class="po" name="po-rt"><?php echo get_cost('po',12) ?></span></td>                                                     
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
                                                <th class="col-md-8">Direct Material</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>All Direct Material</td>
                                            <td><span name="po-dm">1000</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Overhead-->
                                    <table id="po-oh" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-md-8">Overhead</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>All Overhead</td>
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
                                                <th class="col-md-8">Direct Labor</th>
                                                <th class="col-md-4">Total Cost</th>
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
                                                <th class="col-md-8">Direct Material</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>All Direct Material</td>
                                            <td><span id="to-result2">1000</span></td>                                                     
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--Overhead-->
                                    <table id="to-oh" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-md-8">Overhead</th>
                                                <th class="col-md-4">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>All Overhead</td>
                                            <td><span id="to-result3">1000</span></td>                                                 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>                        
                    </div> 
                </div> 
                <!-- D3 bars -->
                <div class="panel-group" id="d3-graph">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#d3-graph" href="#graph">
                                    Patient Vs. Hospital In Terms of Cost and Length of Stay</a>
                            </h4>
                        </div>
                        <div id="graph" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class='col-sm-12' id="costChart"></div>
                                <div class='col-sm-12' id="timeChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //
        function commaSeparateNumber(val){ 
            // referenced from: http://stackoverflow.com/questions/3883342/add-commas-to-a-number-in-jquery
            while (/(\d+)(\d{3})/.test(val.toString())){
              val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }
        function calculateSum() {
            var sum = 0;
            $(".sg").each(function() { // iterate through each td based on class
                var value = $(this).text().replace(/\,/g, '');
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#sg-result').text(commaSeparateNumber(sum));

            var sum = 0;
            // iterate through each td based on class and add the values
            $(".po").each(function() {
                var value = $(this).text().replace(/\,/g, '');  
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#po-result').text(commaSeparateNumber(sum));

            var sum = 0;
            $(".to").each(function() {
                var value = $(this).text().replace(/\,/g, '');
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#to-result').text(commaSeparateNumber(sum));
        }
        $(calculateSum);

        // D3
        // height & width
        function costChartFunction() {
            // get patient total cost
            $p_cost = parseFloat($("#to-result").text().replace(/\,/g, '')) + parseFloat($("#to-result2").text()) + parseFloat($("#to-result3").text());
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('costChart').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // 1. Cost Table
            var data = [$p_cost,9000,3000];
            var dataLabel = ["Patient Cost","Average Cost (Hospital)","Average Reimbursement"];
            // y-axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([0, 0])
                        .html(function(d) {
                            return "<strong>Cost: $</strong><span style='color:red'>" + d + "</span>"; });

            // create svg canvas            
            var svg = d3.select("#costChart")
                        .append("svg")
                        .attr("width", w + margin.left + margin.right)
                        .attr("height", h + margin.top + margin.bottom)
                        .append("g")
                        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            svg.call(tip);

            // add axis
            var axis = svg.append("g")
                          .attr("class", "axis")
                          .attr("transform", "translate(0,0)")
                          .call(xAxis);

            // add svg bars
            var bars = svg.selectAll("rect")
                            .data(data)
                            .enter()
                            .append("rect")
                            .attr("class", "bar")
                            .attr("y", function(d, i){ return 1+(i*barWidth) + "px"; })
                            .attr("x", function(d){ return 0 + "px"; })
                            .attr("width", function(d){ return x(d) + "px"; })
                            .attr("height", function(d){ return barWidth-1 + "px"; })
                            .attr("fill", "#3D9970")
                            .on("mouseover", tip.show)
                            .on("mouseout", tip.hide);

            // add text labels            
            var lab1 = svg.selectAll("text.lab")
                            .data(dataLabel)
                            .enter()
                            .append("text")
                            .attr("class", "title")
                            .text(function(d, i) { return d; })
                            .attr("x", function(d, i){ return 150 + "px"; })
                            .attr("y", function(d, i){ return barWidth*i+22+ "px"; });
        }
        $(costChartFunction);
        
        function timeChartFunction() {
            // 1. Time Table
            var data = [4,5,3.5];
            var dataLabel = ["Patient Stay","Average Stay (Hospital)","Average Stay (National)"];
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('timeChart').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // x-axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Stay:</strong> <span style='color:red'>" + d + "</span> days"; });

            // create svg canvas            
            var svg = d3.select("#timeChart")
                        .append("svg")
                        .attr("width", w + margin.left + margin.right)
                        .attr("height", h + margin.top + margin.bottom)
                        .append("g")
                        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            svg.call(tip);

            // add axis
            var axis = svg.append("g")
                          .attr("class", "axis")
                          .attr("transform", "translate(0,0)")
                          .call(xAxis);

            // add svg bars
            var bars = svg.selectAll("rect")
                            .data(data)
                            .enter()
                            .append("rect")
                            .attr("class", "bar")
                            .attr("y", function(d, i){ return 1+(i*barWidth) + "px"; })
                            .attr("x", function(d){ return 0 + "px"; })
                            .attr("width", function(d){ return x(d) + "px"; })
                            .attr("height", function(d){ return barWidth-1 + "px"; })
                            .attr("fill", "#0074D9")
                            .on("mouseover", tip.show)
                            .on("mouseout", tip.hide);

            // add text labels            
            var lab1 = svg.selectAll("text.lab")
                            .data(dataLabel)
                            .enter()
                            .append("text")
                            .attr("class", "title")
                            .text(function(d, i) { return d; })
                            .attr("x", function(d, i){ return 150 + "px"; })
                            .attr("y", function(d, i){ return barWidth*i+22+ "px"; });
        }
        $(timeChartFunction);           
    </script>
    </body>
</html>        
