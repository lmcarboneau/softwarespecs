<?php
date_default_timezone_set('America/New_York');
session_start(); // initialize the session
require_once("php/util.class.php");
if(!util::checkLogged()){
	$_SESSION = array();
	session_destroy();
	header('Location: ' . "/login.php", true, 303);
   	die();
}
require_once("php/database.class.php");
$database = new database();
require_once("php/technicians.class.php");
$technicians = new technicians($database);
require_once("php/replacements.class.php");
$replacements = new replacements($database);

$technicianID = null;
if (isset($_GET['id'])){
	$technicianID = $_GET['id'];
}else if (isset($_POST['id'])){
	$technicianID = $_POST['id'];
}
if (is_null($technicianID)){
   header('Location: ' . "technicians.php", true, 303);
   die();
}

$thisTechnician = $technicians->getTechnician($technicianID);
$replacementsList = $replacements->getReplacementsForTechnician($technicianID, 5);
$monthlyData = $technicians->getMonthlyData($technicianID, 5);

// Uncomment this to view raw customer data for debugging
 //echo "<pre>"; print_r($replacementsList); echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="App Dashboard">
    <meta name="designer" content="Stetson Gafford">
    <meta name="author" content="Lindsey Carboneau">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Technician Detail Information</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">   

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">  
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/data.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>

    <script language="JavaScript">
		// Set up monthly data chart on load
		$(document).ready ( function(){
		    $('#monthly_graph').highcharts({
		    	chart:{
		    		// Edit chart spacing
			        spacingBottom: 10,
			        spacingTop: 10,
			        spacingLeft: 10,
			        spacingRight: 10,
		    	},
		    	title: {
		            text: ""
		        },
		        legend:{
				     align: 'center',
				     verticalAlign: 'top',
				     floating: false        
				},
		        xAxis: {
		        	labels:{
		        		enabled:true
		        	},
                	categories: [<?php
		        		 	if (count($monthlyData) > 0){
								foreach($monthlyData as $data){
									echo "'".date("F", strtotime($data['date']))."',";
								}
							}
		        		 	?>]
	            },
			    yAxis: [{ // Primary yAxis
		            labels: {
		            	enabled:true,
		                format: '{value}$',

		            },
		            title: {
		            	enabled:false,
		                text: 'Profit',

		            },
		            

		        }, { // Secondary yAxis
		            gridLineWidth: 0,
		            floor:0,
		            title: {
		            	enabled:false,
		                text: 'Replacements',
		                style: {
		                    color: Highcharts.getOptions().colors[0]
		                }
		            },
		            labels: {
		            	enabled:true,
		                format: '{value}%',
		                style: {
		                    color: Highcharts.getOptions().colors[0]
		                }
		            },
		            opposite: true
		        }],
		        series: [{
		        	name:'Profit',
		        	lineWidth:2,
		        	data: [<?php
		        		 	if (count($monthlyData) > 0){
								foreach($monthlyData as $data){
									$profit = 0;
									if ($data['amount_billed'] > 0){
										if ($data['cost_of_replacements'] > 0){
											$profit = ($data['amount_billed'] - $data['cost_of_replacements']);
										} else {
											$profit = $data['amount_billed'];
										}
									}
									echo $profit.",";
								}
							}
		        		 	?>],
		        	yAxis: 0,
		        	tooltip: {
                		valueSuffix: '$'
            		},
            		color: '#000000',
            		shadow: {
					    color: 'black',
					    width: 2,
					    offsetX: 1,
					    offsetY: 2
					}
		        },
		        {
		        	name:'Replacements',
		        	lineWidth:2,
		        	data: [<?php
		        		 	if (count($monthlyData) > 0){
								foreach($monthlyData as $data){
									$replacements = 0;
									if ($data['number_of_replacements'] > 0 && $data['num_plants'] > 0){
										$replacements = $data['number_of_replacements'] / $data['num_plants'] * 100;
										$replacements = round($replacements);
									}
									echo $replacements.",";
								}
							}
		        		 	?>],
		        	yAxis: 1,
		        	tooltip: {
                		valueSuffix: '%'
            		},
            		color: Highcharts.getOptions().colors[0],
            		shadow: {
					    color: 'black',
					    width: 2,
					    offsetX: 1,
					    offsetY: 2
					}
		        }]
		    });
		});
	</script>
    

  </head>

  <body>

    <div class="container">
	
	<!-- Menu buttons -->
      <div class="masthead">
	  
        <p class="navbar-text navbar-right">
		<span class="glyphicon glyphicon-user"></span>
		&nbsp;<?php echo $_SESSION['displayname'];?><br>
		<a href="/logout.php" class="btn btn-xs btn-success pull-right">
		Log Out</a>
		</p>
			
		<h3><img src="img/ipslogosmall.jpg"></h3>
        
		<ul class="nav nav-justified">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="customers.php">Customers</a></li>
          <li class="active"><a href="technicians.php">Technicians</a></li>
          <li><a href="replacements.php">Replacements</a></li>
        </ul>
		
      </div>

	<div class="page-header">  
	  <p style="float:right;"><a href="#"><button type="button" class="btn btn-success">Edit Technician Info</button></a></p>
	  <!-- PHP GOES HERE -->
	  <h2><?php echo $thisTechnician['first_name']." ".$thisTechnician['last_name'];?></h2>
	</div>  

	<!-- Main body, with graphs and such -->
	<div class="row">
		<div class="col-md-6">
			<img
			  width="50%"
			  height="250"
			  frameborder="0" style="border:0"
			  src="sample_tech.jpg"/>
			<br>
			<div class="row" style="width:100%">
				<div class="col-md-6">
				<a style="width:100%" href="customers.php?search=<?php echo urlencode($thisTechnician['first_name']." ".$thisTechnician['last_name']);?>"class="btn btn-success">View Assigned Customers</a>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div id="stats-monthly" class="list-group" >
          		<a class="list-group-item list-group-item-success"><b>Monthly Stats</b></a>
				<div class="list-group-item" id="monthly_graph" style="width:100%; height: 300px; margin: 0 auto"></div>
			</div>
			<div id="stats-replacements" class="list-group">
				<a class="list-group-item list-group-item-success"><b>Recent Replacements</b></a>
				<table class="table table-bordered table-striped table-hover">   
					<thead>
						<tr>
							<th>Date </th>
							<th>Customer </th>
							<th>Emergency </th>
							<th>Status </th>
						</tr>
					</thead>
					<tbody>
						<?php
						$yesNo = array(
							0=>"No",
							1=>"Yes"
						);

						$statusString = array(
							0=>"Needs Approval",
							1=>"Approved",
							2=>"Completed",
							3=>"Cancelled"
						);
						if (count($replacementsList) > 0){
							foreach($replacementsList as $replacement){
								echo "<tr>\n";
								echo "<td>".$replacement['date_submitted']."</td>\n";
								echo "<td>".$replacement['customer_name']."</td>\n";
								echo "<td>".$yesNo[$replacement['emergency']]."</td>\n";
								echo "<td>".$statusString[$replacement['status']]."</td>\n";
								echo "</tr>";
							}
						}
						?>
						<tr>
						 <td colspan="4" align="center">
						   <a class="btn btn-success" href="replacements.php?search=<?php echo urlencode($thisTechnician['first_name']." ".$thisTechnician['last_name']);?>">View All Replacements</a>
						 </td>
						</tr>
					<tbody>
				 </table>
			</div>
		
		</div>
		
	</div>
	
	  <!-- Site footer -->
      <div class="footer">
        <p>&copy; Multitrack Engineering 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
  </body>
</html>