<?php // The user is redirected here from login.php.
include 'data_retriever.php';
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
        <script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script> 
        <script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
        <title> Hospital Report </title>
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
                        for the hospital-wide expense report. </div>
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
                                            <?php echo get_patient_cost("sg")?>
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
                                            <td><span name="sg-dm"><?php echo get_all_dm() ?></span></td>
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
                                            <td><span name="sg-oh"><?php echo get_all_oh() ?></span></td>
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
                                            <?php echo get_patient_cost("po")?>
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
                                            <?php echo get_patient_cost("to")?>
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
                                    Hospital Vs. National Average In Terms of Cost and Stay Duration</a>
                            </h4>
                        </div>
                        <div id="graph" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class='col-sm-12 col-md-0' id="costChart"></div>
                                <div class='col-sm-12 col-md-0' id="ageChart1"></div>
                                <div class='col-sm-12 col-md-0' id="ageChart2"></div>
                                <div class='col-sm-12 col-md-0' id="diabetesChart1"></div>
                                <div class='col-sm-12 col-md-0' id="diabetesChart2"></div>
                                <div class='col-sm-12 col-md-0' id="insuranceChart1"></div>
                                <div class='col-sm-12 col-md-0' id="insuranceChart2"></div>
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
            $(this).find('#sg-result').text(commaSeparateNumber(sum.toFixed(2)));

            var sum = 0;
            // iterate through each td based on class and add the values
            $(".po").each(function() {
                var value = $(this).text().replace(/\,/g, '');  
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#po-result').text(commaSeparateNumber(sum.toFixed(2)));

            var sum = 0;
            $(".to").each(function() {
                var value = $(this).text().replace(/\,/g, '');
                if(!isNaN(value) && value.length != 0) { // add only if the value is number
                    sum += parseFloat(value);
                }
            });
            $(this).find('#to-result').text(commaSeparateNumber(sum.toFixed(2)));
        }
        $(calculateSum);

        // D3
        function costChartFunction() { // hospital cost
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('costChart').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // Cost Table
            var h_cost = parseFloat("<?php echo get_patient_value('cost', 'avg', 'hospital'); ?>").toFixed(0);
            var data = [h_cost, 6000];
            var dataLabel = ["Average Cost (Hospital)","Average Reimbursement"];
            // axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Cost:</strong> <span style='color:red'>" + d + "</span>"; });

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
        
        // Age
        function ageChartFunction() { // age cost
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('ageChart1').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // Cost Table
            var age1_cost = parseFloat("<?php echo get_patient_value('cost','age','1'); ?>").toFixed(0);
            var age2_cost = parseFloat("<?php echo get_patient_value('cost','age','2'); ?>").toFixed(0);
            var age3_cost = parseFloat("<?php echo get_patient_value('cost','age','3'); ?>").toFixed(0);
            var data = [age1_cost, age2_cost, age3_cost];
            var dataLabel = ["Average Cost (Age: 35-)","Average Cost (Age: 35 - 65)","Average Cost (Age: 65+)"];
            // axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Cost:</strong> <span style='color:red'>" + d + "</span>"; });

            // create svg canvas            
            var svg = d3.select("#diabetesChart1")
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
        $(ageChartFunction); 
        
        function ageChartFunction2() { // age stay
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('diabetesChart1').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // get avg stay
            var age1_stay = parseFloat("<?php echo get_patient_value('cost','age','1'); ?>").toFixed(0);
            var age2_stay = parseFloat("<?php echo get_patient_value('cost','age','2'); ?>").toFixed(0);
            var age3_stay = parseFloat("<?php echo get_patient_value('cost','age','3'); ?>").toFixed(0);
            var data = [age1_stay, age2_stay, age3_stay];
            var dataLabel = ["Average Stay (Age: 35-)","Average Stay (Age: 35 - 65)","Average Stay (Age: 65+)"];
            // y-axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Stay:</strong> <span style='color:red'>" + d + "</span>"; });

            // create svg canvas            
            var svg = d3.select("#diabetesChart1")
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
        $(ageChartFunction2);  
        
        // daibetes
        function diabetesChartFunction() { // diabetes cost
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('diabetesChart1').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // Cost Table
            var d_cost = parseFloat("<?php echo get_patient_value('cost','diabetes','Y'); ?>").toFixed(0);
            var nd_cost = parseFloat("<?php echo get_patient_value('cost','diabetes','N'); ?>").toFixed(0);
            var data = [d_cost, nd_cost];
            var dataLabel = ["Average Cost with Diabetes","Average Cost without Diabetes"];
            // axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Cost:</strong> <span style='color:red'>" + d + "</span>"; });

            // create svg canvas            
            var svg = d3.select("#diabetesChart1")
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
        $(diabetesChartFunction); 
        
        function diabetesChartFunction2() { // diabetes stay
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('diabetesChart1').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // 1. Cost Table
            // get avg cost
            var d_cost = parseFloat("<?php echo get_patient_value('stay','diabetes','Y'); ?>").toFixed(0);
            var nd_cost = parseFloat("<?php echo get_patient_value('stay','diabetes','N'); ?>").toFixed(0);
            var data = [d_cost, nd_cost];
            var dataLabel = ["Average Stay with Diabetes","Average Stay without Diabetes"];
            // y-axis
            var x = d3.scale.linear().domain([0, d3.max(data)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Stay:</strong> <span style='color:red'>" + d + "</span>"; });

            // create svg canvas            
            var svg = d3.select("#diabetesChart1")
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
        $(diabetesChartFunction2);    

        // insurance   
        
    </script>
    </body>
</html>        
