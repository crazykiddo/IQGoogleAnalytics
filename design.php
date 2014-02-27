<!doctype html>
<html>
	<head>
        <title>Google Analytics</title>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
       <link type="text/css" rel="stylesheet" href="style.css" media="all">
	   <script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	   <script type="text/javascript" src="js/Chart.min.js"></script>
	   <script type="text/javascript" src="js/javascripts.js"></script>
    </head>
	<body>
		<?php
		if ($access){
		?>
		<div class="topmenu">
			<a class="leftmenuicon" href='javascript:void(0);'>
				IQ
			</a>
			<a class="toplogo" href='/'>Google Analytics</a>			
			<span style="margin:0 auto;height:32px;line-height:32px;">
				<!--<a style="float:none;" href="javascript:void(0);">DEBUG</a>-->
				<select id="curaccount" onchange="SetSiteProfile(this);" style="height:25px;line-height:25px;margin-top:3px;">
					<option value="">--- SELECT A SITE ---</option>
					<?php echo GetAccountListDropdown(); ?>
				</select>
			</span>
			<a class='right' href='?logout'>Logout</a>
		</div>
		<?php
		}
		?>
		
        <div class="main" id="main">
			<?php if ($access){
						if (isset($_SESSION['aid']) && isset($_SESSION['pid'])){
							GetDataTest2($_SESSION['pid']);
							?>							
					<canvas id="canvas" height="450" width="600"></canvas>					
					<script>
						var data1 = [65,59,90,81,56,55,40];
						var data2 = [28,48,40,19,96,27,100];
						var labels = ["January","February","March","April","May","June","July"];
						ShowChart_Bars("canvas", data1, data2, labels);
		/*var barChartData = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					data : [28,48,40,19,96,27,100]
				}
			]
			
		}

	var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);*/
	
	</script>
			<?php
						}else{
			?>
							Please select a site to view
			<?php
						}
			?>
				<?php //GetDataTest('74627844'); ?>
			<?php } else{ ?>
				Nada
			<?php } ?>
			<?php //echo $debuginfo; ?>
			<?php
			//echo getProfileIdFromAccount($service);
			//echo $service->management_profiles->getProfileId();
			//UA-42543704-1
			if (isset($_SESSION['aid'])){
			//echo "aid : ".$_SESSION['aid'];
			}
			if (isset($_SESSION['pid'])){
			//echo "<br>pid : ".$_SESSION['pid'];
			}
			?>
        </div>
		
		<div class="debugbox" id="debugbox" style="display:xnone;"><?php echo $debuginfo; ?></div>
	</body>
</html>