<?php
// The user is redirected here from login.php.
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
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script> 
        <script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
        <script src="sankey.js"></script>
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
                        <strong>Postoperative Surgery</strong> or <strong> Total</strong>  
                        for the patient expense report. </div>
                </div>
                <!-- Header with surgery & postop care selection -->
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a data-toggle="pill" href="#surgery"> <h5>CABG Surgery</h5> </a></li>
                    <li><a data-toggle="pill" href="#postop"> <h5>Postoperative Care</h5> </a></li>
                    <li><a data-toggle="pill" href="#total"> <h5>Total (CABG and Postoperative)</h5> </a></li>
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
                                            <?php echo get_table_value("sg")?>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong><span id="sg-result"></span></strong></td>
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
                                            <?php echo get_table_value("po")?>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong><span id="po-result"></span></strong></td>
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
                                    <a data-toggle="collapse" data-parent="#total2" href="#to"> Total (CABG and Postoperative) </a>
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
                                            <?php echo get_table_value("to")?>
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
                                            <td><span id="to-result2"><?php echo get_dm()?></span></td>
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
                                            <td><span id="to-result3"><?php echo get_oh()?></span></td>
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
                                    Total (CABG and Postoperative) - Patient Vs. Hospital Performance Analysis</a>
                            </h4>
                        </div>
                        <div id="graph" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class='col-sm-12' id="costSankey"></div><br/>
                                <div class='col-sm-12' id="costChart"></div><br/>
                                <div class='col-sm-12' id="timeChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
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
        function sankeyChartFunction() {
            var units = "$";
            var margin = {top: 10, right: 50, bottom: 10, left: 20},
                width = document.getElementById("costSankey").offsetWidth - margin.left - margin.right,
                height = 250 - margin.top - margin.bottom;

            var formatNumber = d3.format(",.0f"),    // zero decimal places
                format = function(d) { return units + formatNumber(d); },
                color = d3.scale.category10();

            // append the svg canvas to the page
            var svg = d3.select("#costSankey").append("svg")
                        .attr("width", width + margin.left + margin.right)
                        .attr("height", height + margin.top + margin.bottom)
                        .append("g")
                        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            // Set the sankey diagram properties
            var sankey = d3.sankey()
                            .nodeWidth(36)
                            .nodePadding(40)
                            .size([width, height]);

            var path = sankey.link();

            // load the data   
            var dl = parseFloat($("#to-result").text().replace(/\,/g, '')); 
            var dm = parseFloat($("#to-result2").text().replace(/\,/g, ''));
            var oh = parseFloat($("#to-result3").text().replace(/\,/g, ''));
            var ri = 29689; 
            var toc = dl + dm + oh; // total cost
            if (toc > ri) {
                var de = toc - ri; // deficit
                var graph = {"nodes":
                            [
                            {"node":0,"name":"Direct Labor"},
                            {"node":1,"name":"Direct Material"},
                            {"node":2,"name":"Overhead"},
                            {"node":3,"name":"Average Cost"},
                            {"node":4,"name":"Reimbursement"},
                            {"node":5,"name":"Deficit"}
                            ],
                        "links":
                            [
                            {"source":0,"target":3,"value":dl},
                            {"source":1,"target":3,"value":dm},
                            {"source":2,"target":3,"value":oh},
                            {"source":3,"target":4,"value":ri},
                            {"source":3,"target":5,"value":de}
                        ]};   
            } else {
                var re = ri - toc; // revenue
                var graph = {"nodes":
                            [
                            {"node":0,"name":"Direct Labor"},
                            {"node":1,"name":"Direct Material"},
                            {"node":2,"name":"Overhead"},
                            {"node":3,"name":"Average Cost"},
                            {"node":4,"name":"Reimbursement"},
                            {"node":5,"name":"Revenue"}
                            ],
                        "links":
                            [
                            {"source":0,"target":3,"value":dl},
                            {"source":1,"target":3,"value":dm},
                            {"source":2,"target":3,"value":oh},
                            {"source":3,"target":4,"value":toc},
                            {"source":5,"target":4,"value":re}
                        ]} 
            }            
            
            sankey.nodes(graph.nodes)
                  .links(graph.links)
                  .layout(32);

            // add in the links
            var link = svg.append("g").selectAll(".link")
                        .data(graph.links)
                        .enter().append("path")
                        .attr("class", "link")
                        .attr("d", path)
                        .style("fill", "none")
                        .style("stroke", "tan")
                        .style("stroke-opacity", ".33")
                        .on("mouseover", function() { d3.select(this).style("stroke-opacity", ".5") } )
                        .on("mouseout", function()  { d3.select(this).style("stroke-opacity", ".2") } )
                        .style("stroke-width", function(d) { return Math.max(1, d.dy); })
                        .sort(function(a, b) { return b.dy - a.dy; });

            // add the link titles
            link.append("title")
                .text(function(d) {
                    return d.source.name + " -> " + d.target.name + "\n" + format(d.value); });

            // add in the nodes
            var node = svg.append("g").selectAll(".node")
                            .data(graph.nodes)
                            .enter().append("g")
                            .attr("class", "node")
                            .attr("transform", function(d) { 
                                return "translate(" + d.x + "," + d.y + ")"; })
                            .call(d3.behavior.drag()
                            .origin(function(d) { return d; })
                            .on("dragstart", function() {  this.parentNode.appendChild(this); })
                            .on("drag", dragmove));

            // add the rectangles for the nodes - here
            node.append("rect")
                  .attr("height", function(d) { return d.dy; })
                  .attr("width", sankey.nodeWidth())
                  .style("fill", function(d) { 
                      return d.color = color(d.name.replace(/ .*/, "")); })
                  .style("fill-opacity", ".9")
                  .style("shape-rendering", "crispEdges")
                  .style("stroke", function(d) { 
                      return d3.rgb(d.color).darker(2); })
                  .append("title")
                  .text(function(d) { 
                      return d.name + "\n" + format(d.value); });

            // add in the title for the nodes
            node.append("text")
                .attr("x", -6)
                .attr("y", function(d) { return d.dy / 2; })
                .attr("dy", ".35em")
                .attr("text-anchor", "end")
                .attr("transform", null)
                .text(function(d) { return d.name + ": " + format(d.value); })
                .filter(function(d) { return d.x < width / 2; })
                .attr("x", 6 + sankey.nodeWidth())
                .attr("text-anchor", "start");

            // the function for moving the nodes
            function dragmove(d) {
                d3.select(this).attr("transform", 
                    "translate(" + d.x + "," + (
                        d.y = Math.max(0, Math.min(height - d.dy, d3.event.y))
                    ) + ")");
                sankey.relayout();
                link.attr("d", path);
            }
        }
        $(sankeyChartFunction);       
        
        function costChartFunction() {
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('costChart').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // 1. Cost Table
            var p_cost = parseFloat($("#to-result").text().replace(/\,/g, '')) + parseFloat($("#to-result2").text()) + parseFloat($("#to-result3").text());            
            var h_cost = parseFloat("<?php echo get_barchart_value('cost', 'hospital'); ?>");
            var data = [p_cost, h_cost, 29689];
            var dataLabel = ["Patient Cost","Average Hospital Cost","Average Reimbursement"];
            // y-axis
            var x = d3.scale.linear().domain([0, d3.max(data).toFixed(0)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([0, 0])
                        .html(function(d) {
                            return "<strong>Cost: $</strong><span style='color:red'>" + commaSeparateNumber(d.toFixed(0)) + "</span>"; });

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
                            .attr("width", function(d){ return x(d.toFixed(0)) + "px"; })
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
            // Data Table
            var p_time = parseFloat("<?php echo get_barchart_value('time', 'patient'); ?>");
            var h_time = parseFloat("<?php echo get_barchart_value('time', 'hospital'); ?>");
            var data = [p_time, h_time, 6.8];
            var dataLabel = ["Patient Stay","Average Stay (Hospital)","Average Stay (National)"];
            // canvas size
            var barWidth = 30;
            var margin = {top: 60, right: 60, bottom: 20, left: 20};
            var w = document.getElementById('timeChart').offsetWidth - margin.left - margin.right;
            var h = 3 * barWidth;
            // x-axis
            var x = d3.scale.linear().domain([0, d3.max(data).toFixed(1)]).range([0, w]);
            var xAxis = d3.svg.axis()
                          .scale(x)
                          .orient("top");            
            // tool tip
            var tip = d3.tip()
                        .attr("class", "d3-tip")
                        .offset([1, 1])
                        .html(function(d) {
                            return "<strong>Stay:</strong> <span style='color:red'>" + d.toFixed(1) + "</span> days"; });

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
                            .attr("width", function(d){ return x(d.toFixed(1)) + "px"; })
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