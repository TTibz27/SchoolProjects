
<?php include('./class/loginClass.php'); ?>
<?php $class = new mainLogin(); ?>

<?php
/**
 * @category	H20 Employee Eval System - Main Page
 * @author		Software Engineering - H20 Project
 * @version		1.0
 * @see			documentation.html
 */

// Check if POST was sent
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	// If the username and password fiels not empty, check for valid credentials
	if($_POST['username'] != "" && $_POST['password'] != "") {
	
		// Credentials passed through Whirpool encryption algorithm
		if($class->checkCredentials($_POST['username'], $_POST['password']) == true) {
			$class->setUser($_POST['username']);
			
			// This redirects back to the index.php, once credentials are validated
			// The "Location:" can be changed to any desired redirect page, or you place any scripts below this statement to execute
			header('Location: index.php');
		} 
		
		// Display invalid credential message
		else {
			$message = "Incorrect username or password."; $type = "danger";
		}
	} 
	
	// Display warning message if no credentials are given at all
	else {
		$message = "Please enter a username and password"; $type = "warning";
	}
}

// Log out the user if GET action is called and equals 'logout'
if(isset($_GET['action']) && $_GET['action'] == "logout") {
	$class->killSession();
	
	// The below redirects back to the index.php after the logout button is clicked. This can also be changed as needed
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="utf-8">
        <title>H20 - Employee Evaluation Portal</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 
    
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
		
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/pages/signin.css" rel="stylesheet" type="text/css">
	<link href="css/pages/dashboard.css" rel="stylesheet">
	<script type="text/javascript" src="//www.google.com/jsapi"></script>
				<script type="text/javascript">
				  google.load('visualization', '1', {packages: ['corechart']});
				</script>
				<script type="text/javascript">
				  function drawVisualization() {
					// Create and populate the data table.
					var data = google.visualization.arrayToDataTable([
					  ['Category',					'Admin',	'User1',	'Average for All Employees'],
					  ['Communications',			2,      	4,        	3],					  
					  ['Cooperation',				3,      	2,			2.5],
					  ['Cost Consciousness',		4,			5,			4.5],
					  ['Dependability',				5,      	2,        	3.5],
					  ['Initiative',				3,			4,			3.5],
					  ['Job Knowledge',				4,			3,			3.5],
					  ['Judgement',					2,			4,			3],
					  ['Planning & Organization',	3,			3,			3],	
					  ['Problem Solving',			3,      	1,        	2],
					  ['Quality',					3,      	4,         	3.5],
					  ['Quantity',					2,			5,			3.5],
					  ['Use of Tech',				5,      	3,         	4] 
					]);
				  
					// Create and draw the visualization.
					var ac = new google.visualization.ComboChart(document.getElementById('visualization'));
					ac.draw(data, {
					  title : 'H2O Form - Employee Summary',
					  width: 1100,
					  height: 400,
					  vAxis: {title: "Score"},
					  hAxis: {title: "Category"},
					  seriesType: "bars",
					  series: {5: {type: "line"}}
					});
				  }

				  google.setOnLoadCallback(drawVisualization);
				</script>
</head>
<body>

	<?php // If the current user IS NOT logged in, prompt for login ?>
	<?php if($class->isLoggedIn() == false) { 
	header('Location: login.php');?>
			
	
	<?php // If the current user IS logged in, display dashboard ?>
	<?php } else { ?>
		<?php include 'navbar.php';?>		
	<div class="main">
		<div class="main-inner">
		<div class="container">
		  <div class="row">
			<div class="span12">
			  <div class="widget widget-nopad">
		<div class="widget-header"> <i class="icon-list-alt"></i>
		  <h3> Today's Stats </h3>
		</div>
		<div class="widget-content">
		<!-- /widget-header -->

				<div id="visualization" style="width: 1100px; height: 400px;"></div>
		</div>
	  </div>
         
          <!-- /widget -->
        </div>
        <!-- /span6 -->
        <div class="span6">
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Shortcuts</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts">
				  <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span class="shortcut-label">Apps</span></a>
				  <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-bookmark"></i><span class="shortcut-label">Bookmarks</span></a>
				  <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-signal"></i><span class="shortcut-label">Reports</span> </a>
				  <a href="javascript:;" class="shortcut"> <i class="shortcut-icon icon-comment"></i><span class="shortcut-label">Comments</span></a>
				  <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-user"></i><span class="shortcut-label">Users - <?php echo $class->getUserCount()?></span></a>
				  <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-file"></i><span class="shortcut-label">Notes</span></a>
				  <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-picture"></i> <span class="shortcut-label">Photos</span> </a>
			  </div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-signal"></i>
              <h3>Cool chart here</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
             <canvas id="area-chart" class="chart-holder" height="600" width="538"> 
				</canvas>
              <!-- /area-chart --> 
            </div>
			 <script type="text/javascript" src="//www.google.com/jsapi"></script>
				<script type="text/javascript">
				  google.load('visualization', '1', {packages: ['corechart']});
				</script>
				<!-- <div id="visualization" style="width: 1300px; height: 400px;"></div> -->
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
     
		</div>
	    <!-- /span6 --> 
	   </div>
	   <!-- /row --> 
	  </div>
	 <!-- /container --> 
    </div>
  <!-- /main-inner --> 
  </div>
	<!-- /main -->
		<?php } ?>
 </div>
</div>
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/signin.js"></script>
</body>
</html>
