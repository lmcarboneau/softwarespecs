<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
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
require_once("php/replacements.class.php");

$replacements = new replacements($database);
$replacementList = $replacements->getReplacementList();
$tableRows = "";
$month = date('M');

$statusFilter = array(
	0=>false,
	1=>false,
	2=>false,
	3=>false
);

if(isset($_GET['status'])){
	$statusFilter[$_GET['status']] = true;
} elseif (isset($_POST['status'])){
	$statusFilter[$_POST['status']] = true;
} else {
	$statusFilter = array(
		0=>true,
		1=>true,
		2=>true,
		3=>false
	);
}

$search = null;
if(isset($_GET['search'])){
	$search = $_GET['search'];
} elseif (isset($_POST['search'])){
	$search = $_POST['search'];
}


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


foreach($replacementList as $replacementRow){
	$tableRows .= "<tr class='table-select' style='cursor:pointer;'>\n";

	$tableRows .= "\t<td class='date_submitted'>";
	$tableRows .= $replacementRow['date_submitted']."</td>\n";

	$tableRows .= "\t<td class='id' style='display:none;'>";
	$tableRows .= $replacementRow['replacementID']."</td>\n";

	$tableRows .= "\t<td class='customer_name'>";
	$tableRows .= $replacementRow['customer_name']."</td>\n";

	$tableRows .= "\t<td class='gardener_name'>";
	$tableRows .= $replacementRow['first_name']." ".$replacementRow['last_name']."</td>\n";
	
	$tableRows .= "\t<td class='emergency'>";
	$tableRows .= $yesNo[$replacementRow['emergency']]."</td>\n";

	$tableRows .= "\t<td class='status_id' style='display:none;'>";
	$tableRows .= $replacementRow['status']."</td>\n";
	
	$tableRows .= "\t<td class='status'>";
	$tableRows .= $statusString[$replacementRow['status']]."</td>\n";


	$tableRows .= "</tr>\n";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Replacements List">
    <meta name="designer" content="Stetson Gafford">
    <meta name="author" content="Lindsey Carboneau">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Plant Replacement Manager Replacements</title>

    <!-- Bootstrap core CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script src="js/List.js"></script>

	<script language="JavaScript">
		// Set up List.js table on load
		$(document).ready ( function(){
			var options = {
	  			valueNames: [ 'gardener_name', 'customer_name', 'emergency', 'status_id', 'status', 'date_submitted' ]
			};

			// Init list
			var replacementList = new List('replacements', options);

   			var sort = "";
	   		var direction = "asc";
	   		var sort_btns = $(".sortbtn");
	   		var filter_checks = $(".filter");
	   		var filter = [true, true, true, true];

	   		sort_btns.click(function(){
	   			var clicked = $(this);
	   			var sortid = clicked.attr("data-sort");
	   			if (sort == sortid){
	   				direction = (direction == "asc") ? "desc" : "asc";
	   			} else {
	   				direction = "asc";
	   			}
	     		sort = sortid;
	   			replacementList.sort(sort, { order: direction});

	   			sort_btns.removeClass("btn-primary");
	   			clicked.addClass("btn-primary");
	   		});

	   		filter_checks.change(function(){
	   			var clicked = $(this);
	   			var filterID = clicked.attr("data-filter");
	   			filter[filterID] = this.checked;

	   			replacementList.filter(function(item) {
				   var id =item.values().status_id;
				   return filter[id];
				});
				replacementList.update();
	   		});

	   		// We "click" the sort-by-customer button on page load
	   		// so that the list starts out sorted
	   		$(".sort-default").trigger("click");
	   		$(".sort-default-desc").trigger("click").trigger("click");

	   		filter_checks.trigger("change");

	   		// This section detects a click in the customer table
	   		// and submits the customer ID to customerForm.php
	   		$(".table-select").click(function (){
	   			var id = $(this).find('.id').text();
	   			$("#selectID").val(id);
	   			$("#selectForm").submit();
	   		});

	   		// Filter the list with the php search value from get/post
	   		<?php echo (empty($search)) ? '' : 'replacementList.search("'.$search.'");';?>
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
          <li><a href="technicians.php">Technicians</a></li>
          <li class="active"><a href="replacements.php">Replacements</a></li>        </ul>
      </div>

    <br>
	<div class="row" >  
		<div id="replacements" style="margin:20px">
			<div class="navbar navbar-default">
				<form class="navbar-form" role="form">
					<input type="text" class="search form-control" placeholder="<?php echo (empty($search)) ? "Search Customers":$search;?>" style="max-width:20%"/>
					&nbsp;&nbsp;
					<input data-filter=0 class='filter' type="checkbox" <?php echo ($statusFilter[0]) ? "checked": ""; ?>/> 
					Needs Approval
					&nbsp;&nbsp;
					<input data-filter=1 class='filter' type="checkbox" <?php echo ($statusFilter[1]) ? "checked": ""; ?>/> 
					Approved
					&nbsp;&nbsp;
					<input data-filter=2 class='filter' type="checkbox" <?php echo ($statusFilter[2]) ? "checked": ""; ?>/> 
					Completed
					&nbsp;&nbsp;
					<input data-filter=3 class='filter' type="checkbox" <?php echo ($statusFilter[3]) ? "checked": ""; ?>/> 
					Cancelled
					<a href="replacementForm.php" class="btn btn-success" style="float:right">
					New Replacement
					</a>
				</form>
			</div>
			<table class="table table-striped table-hover table-responsive panel panel-default">
				<thead>
					<tr>
						<th>
							<button data-sort="date_submitted" class="sortbtn sort-default-desc btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Date
							</button>
						</th>
						<th>
							<button data-sort="customer_name" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Customer
							</button>
						</th>
						<th>
							<button data-sort="gardener_name" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Technician
							</button>
						</th>
						<th>
							<button data-sort="emergency" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Emergency
							</button>
						</th>
						<th>
							<button data-sort="status" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Status
							</button>
						</th>
						

					</tr>
				</thead>
				<tbody class="list">
					<?php echo $tableRows; ?>
				</tbody>
			</table>
		</div>
		<!-- Hidden form to submit which customer was clicked -->
		<div style="display:none;">
			<form id="selectForm" action="replacementForm.php" method="post">
				<input id="selectID" type="text" name="id" value="5"/>
			</form>
		</div>
	</div> <!-- ends panel 'row' div -->


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
