<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
	
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a class="brand" href="index.php">
				Survey for H2O			
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="dropdown">						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-cog"></i>
							Accounts
							<b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<li><a href="javascript:;">Settings</a></li>
							<li><a href="javascript:;">Help</a></li>
						</ul>						
					</li>
					 <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> Welcome, <?php echo $class->getCurrentUser($class->username_field);  ?>!<b class="caret"></b></a>
					<ul class="dropdown-menu">
				 		 <li><a href="javascript:;">Profile</a></li>
				  		<li><a href="?action=logout">Logout</a></li>
					</ul>
			  	</li>
				</ul>			
				<form class="navbar-search pull-right">
					<input type="text" class="search-query" placeholder="Search">
				</form>
			
			</div><!--/.nav-collapse -->	
		</div> <!-- /container -->
	</div> <!-- /navbar-inner -->
</div> <!-- /navbar -->
    
<div class="subnavbar pagination-centered">
	<div class="subnavbar-inner">
		<div class="container">
			<ul class="mainnav">
				<li><a href="index.php"><i class="icon-dashboard"></i><span>Dashboard</span></a></li>
				<li><a href="reference.php"><i class="icon-list-alt"></i><span>Surveys</span> </a> </li>
			    <li><a href="#"><i class="icon-bar-chart"></i><span>Charts</span> </a> </li>
				<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Drop Example</span> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="#">Item 1</a></li>
					<li><a href="#">Item 2</a></li>
					<li><a href="#">Etc.</a></li>
				  </ul>
				</li>
			</ul>
		</div> <!-- /container -->
	</div> <!-- /subnavbar-inner -->
</div> <!-- /subnavbar -->
