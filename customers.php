
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

    <title>Plant Replacement Manager Customers</title>

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
	  			valueNames: [ 'customerID', 'customer_name', 'technician_name', 'stats_curr_rep' ]
			};

			// Init list
			var contactList = new List('customers', options);
   		});
	</script>

  </head>

  <body>

    <div class="container">
	
	<!-- Menu buttons -->
      <div class="masthead">
	  
        <p class="navbar-text navbar-right">
		<span class="glyphicon glyphicon-user"></span>
		&nbsp;User Name <br>
		<button type="button" class="btn btn-xs btn-success pull-right">
		Log Out</button>
		</p>
			
		<h3><img src="img/ipslogosmall.jpg"></h3>
        
		<ul class="nav nav-justified">
          <li><a href="#">Dashboard</a></li>
          <li class="active"><a href="#">Customers</a></li>
          <li><a href="#">Technicians</a></li>
          <li><a href="#">Replacements</a></li>
        </ul>
		
      </div>

    <br>
	<div class="row" >  
		<div id="customers" style="margin:20px">
			<input type="text" class="search form-control" placeholder="Search Customers" />
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							<button class="sort btn btn-default" data-sort="customer_name" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Customer Name
							</button>
						</th>
						<th>
							<button class="sort btn btn-default" data-sort="technician_name" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Technician Name
							</button>
						</th>
						<th>
							<button class="sort btn btn-default" data-sort="stats_curr_rep" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Current Replacements
							</button>
						</th>
					</tr>
				</thead>
				<tbody class="list">
					<tr>
						<td class="customerID" style="display:none;">1</td>
						<td class="customer_name">Bobs Automotive</td>
						<td class="technician_name">John</td>
						<td class="stats_curr_rep">40%</td>
					</tr>
					<tr>
						<td class="customerID" style="display:none;">2</td>
						<td class="customer_name">FGCU</td>
						<td class="technician_name">John</td>
						<td class="stats_curr_rep">20%</td>
					</tr>
					<tr>
						<td class="customerID" style="display:none;">3</td>
						<td class="customer_name">Dunkin Donuts</td>
						<td class="technician_name">Steve</td>
						<td class="stats_curr_rep">80%</td>
					</tr>
				</tbody>
			</table>
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
