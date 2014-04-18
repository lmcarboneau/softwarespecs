<?php
session_start(); // initialize the session
include("passwords.php");
check_logged(); // if not logged in, user redirected to login page
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

    <title>Plant Replacement Manager Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">

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
          <li class="active"><a href="#">Dashboard</a></li>
          <li><a href="#">Customers</a></li>
          <li><a href="#">Technicians</a></li>
          <li><a href="#">Replacements</a></li>
        </ul>
		
      </div>

	<div class="page-header">  
	  <h1></h1>
	</div>  
	<div class="row">  
		
		  <div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Technician Efficiency<h3>
				</div>	
				<div class="panel-body"> 
				
				Placeholder Text
				
				</div>
				
			</div>
		  </div>
		<div class="col-sm-2">
		</div>
		<div class="col-sm-3">
          <div class="list-group">
            <a href="#" class="list-group-item">
			<span class="badge pull-left">#</span>
			&nbsp;&nbsp;Needs Approval
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
            <a href="#" class="list-group-item">
			<span class="badge pull-left">#</span>
			&nbsp;&nbsp;Approved
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
            <a href="#" class="list-group-item">
			<span class="badge pull-left">#</span>
			&nbsp;&nbsp;Completed
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
            <a href="#" class="list-group-item">
			<span class="badge pull-left">#</span>
			&nbsp;&nbsp;Cancelled
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
          </div>
        </div>
    
	</div> <!-- ends panel 'row' div -->
	<div class="row">  
		
		  <div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Customer Profitability<h3>
				</div>	
				<div class="panel-body"> 
				
				Placeholder Text
				
				</div>
				
			</div>
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
