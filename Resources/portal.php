<?php

session_start();

if (!isset($_SESSION["u"])) {
	header("Location: index.html");
	exit ;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Portal</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="css/bootstrap.min.css" rel="stylesheet">		<!--<link href="css/datepicker3.css" rel="stylesheet">-->
 
		<script type='text/javascript' src="js/jquery-1.10.2.min.js"></script>
		<script type='text/javascript' src="js/bootstrap.min.js"></script>		<!--<script type='text/javascript' src="js/bootstrap-datepicker.min.js"></script>-->
		<!-- <script type='text/javascript' src="js/jquery.validate.min.js"></script> -->
		

<!--
	**COMMON** 
table selected row 
+
label for validator -->
		<style>		    .deltextcontent {		      position: absolute;		      right: 5px;		      top: 0;		      bottom: 0;		      height: 14px;		      margin: auto;		      font-size: 14px;		      cursor: pointer;		      color: #ccc;		    }			
			.table-striped tbody tr.highlight td {
				background-color: #B0BED9;
			}

			label.error { color: #FF0000; font-size: 11px; display: block; width: 100%; white-space: nowrap; float: none; margin: 8px 0 -8px 0; padding: 0!important; }
		</style>
		
		<script type="text/javascript">
			//**COMMON** function for child PHP
			// Get the selected row
			function getSelected(selector) {
				var lines=null;
				
				$('#' + selector + ' > tbody  > tr').each(function() {
					if ($(this).hasClass('highlight')) {

						lines = $('td', $(this)).map(function(index, td) {
							return $(td).data('name'); 
						});

						return false;
					}
				});

				return lines;
			}
			
			//commmon get valid date now for mySQL
			function twoDigits(d) {
			    if(0 <= d && d < 10) return "0" + d.toString();
			    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
			    return d.toString();
			}
		
			function date_now4mysql()
			{
				var d = new Date();
				var str_date = d.getFullYear() + "-" + twoDigits(d.getMonth() + 1) + "-" + twoDigits(d.getDate()) + " " + twoDigits(d.getHours()) + ":" + twoDigits(d.getMinutes()) + ":" + twoDigits(d.getSeconds());
				console.log(str_date);
				return str_date;
			}

		
			//JQUERY START HERE////////////////////////////
			$(function() {
				var x = "<?= $_SESSION['u']?>";
			
				$("#logout").html("Έξοδος (" + x + ")");				
			});
			
			//JQUERY END HERE////////////////////////////


			//logout
			// $(document).on("click", "#logout", function(e) {
				// e.preventDefault();
			// });
				
			</script>
	</head>
	<body>
	<div id="loading" style="display:none;background-color:rgba(0,0,0,0.5);position:absolute;top:0;left:0;height:100%;width:100%;z-index:999;vertical-align:middle; text-align:center"><img src='css/loading.gif' />
	</div>
	
<div id="box" style="padding: 10px">
		<ul class='nav nav-pills' id='tabContainer'>
			
			<li class="active">
				<a href="#clubsTAB" data-toggle='tab'>Όμιλοι</a>
			</li>
			
			<li>
				<a href="#tcTAB" data-toggle='tab'>powered by PipisCrew</a>
			</li>

			<li class="nav navbar-nav navbar-right">
				<a href="logout.php" id="logout">Έξοδος</a>
			</li>

		</ul>

		<!-- TABS Content [START] -->
		<div id="tabsContent" class="tab-content">


			<div class="tab-pane fade in active" id="clubsTAB">
				<div id="clubs">
					<?php
					include ('tab_clubs.php');
					?>
				</div>
				<div id="clubs_details">
				</div>
			</div>
		</div>
		<!-- TABS Content [END] -->
</div>
	</body>
</html>