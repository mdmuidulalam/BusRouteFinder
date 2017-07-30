					<!DOCTYPE html>
			<html >
			  <head>
				<meta charset="UTF-8">
				<title>Add Bus </title>
				
				
				
				
					<style>
				  

			body{
				margin: 0;
				padding: 0;
				background: #fff;

				color: #fff;
				font-family: Arial;
				font-size: 12px;
			}

			.body{
				position: absolute;
				top: -20px;
				left: -20px;
				right: -40px;
				bottom: -40px;
				width: auto;
				height: auto;
				background-image: url(http://ginva.com/wp-content/uploads/2012/07/city-skyline-wallpapers-008.jpg);
				background-size: cover;
				-webkit-filter: blur(5px);
				z-index: 0;
			}

			.grad{
				position: absolute;
				top: -20px;
				left: -20px;
				right: -40px;
				bottom: -40px;
				width: auto;
				height: auto;
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
				z-index: 1;
				opacity: 0.7;
			}

			.header{
				position: absolute;
				top: calc(50% - 35px);
				left: calc(50% - 255px);
				z-index: 2;
			}

			.header div{
				float: left;
				color: #fff;
				font-family: 'Exo', sans-serif;
				font-size: 35px;
				font-weight: 200;
			}

			.header div span{
				color: #5379fa !important;
			}

			.login{
				position: absolute;
				top: calc(50% - 75px);
				left: calc(50% - 50px);
				height: 150px;
				width: 350px;
				padding: 10px;
				z-index: 2;
			}

			.login input[type=text]{
				width: 250px;
				height: 30px;
				background: transparent;
				border: 1px solid rgba(255,255,255,0.6);
				border-radius: 2px;
				color: #fff;
				font-family: 'Exo', sans-serif;
				font-size: 16px;
				font-weight: 400;
				padding: 4px;
			}

			.login input[type=password]{
				width: 250px;
				height: 30px;
				background: transparent;
				border: 1px solid rgba(255,255,255,0.6);
				border-radius: 2px;
				color: #fff;
				font-family: 'Exo', sans-serif;
				font-size: 16px;
				font-weight: 400;
				padding: 4px;
				margin-top: 10px;
			}

			.login input[type=submit]{
				width: 260px;
				height: 35px;
				background: #fff;
				border: 1px solid #fff;
				cursor: pointer;
				border-radius: 2px;
				color: #a18d6c;
				font-family: 'Exo', sans-serif;
				font-size: 16px;
				font-weight: 400;
				padding: 6px;
				margin-top: 10px;
			}

			.login input[type=submit]:hover{
				opacity: 0.8;
			}

			.login input[type=submit]:active{
				opacity: 0.6;
			}

			.login input[type=text]:focus{
				outline: none;
				border: 1px solid rgba(255,255,255,0.9);
			}

			.login input[type=password]:focus{
				outline: none;
				border: 1px solid rgba(255,255,255,0.9);
			}

			.login input[type=button]:focus{
				outline: none;
			}

			::-webkit-input-placeholder{
			   color: rgba(255,255,255,0.6);
			}

			::-moz-input-placeholder{
			   color: rgba(255,255,255,0.6);
			}
				</style>

				
					<script src="js/prefixfree.min.js"></script>

				
			  </head>


				<form action="" method="post">
				<div class="body"></div>
					<div class="grad"></div>
					<div class="header">
						<div>Add<span>Bus</span></div>
					</div>
					<br>
					
					<div class="login">
							<!--<input type="text" placeholder="From" name="from"><br>
							<input type="text" placeholder="To" name="to"><br>
							<input type="submit" value="Get started!" /> -->
					<input type = "text" name = "from_node" placeholder="from">
					<input type = "text" name = "to_node" placeholder="to">
					<input type = "text" name = "bus" placeholder="bus name">
					<input type = "text" name = "fare" placeholder="bus fare">
					<input type = "text" name = "time" placeholder="time">
					<input type="submit" name="addBus" value="Submit Form" />							
					</div>
				</form>
					
			</html>


		<?php
		include("includes/db.php");
		if(isset($_POST['addBus'])) {

			$from = $_POST['from_node'];
			$to = $_POST['to_node'];
			$bus = $_POST['bus'];
			$cost = $_POST['fare'];
			$time = $_POST['time'];    

			$q = "select * from nodes where node_title = '$from'";
			$run_q = mysqli_query($con, $q);
			$row_q = mysqli_fetch_array($run_q);
			$from = $row_q['node_id'];

			$q = "select * from nodes where node_title = '$to'";
			$run_q = mysqli_query($con, $q);
			$row_q = mysqli_fetch_array($run_q);
			$to = $row_q['node_id'];

			$q = "select * from edges where from_node = '$from' AND to_node = '$to'";
			$run_q = mysqli_query($con, $q);
			if(!mysqli_num_rows($run_q)) {
				echo "no such edge<br>";
			}
			else {
				$row_q = mysqli_fetch_array($run_q);
				$edge = $row_q['edge_id'];

				$q = "insert into Bus (edge_id, bus_title, cost, time) values ('$edge', '$bus', '$cost', '$time')";
				$run_q = mysqli_query($con, $q);

				$q = "select * from Bus where edge_id = '$edge'";
				$run_q = mysqli_query($con, $q);
				$min = 99999;
				while($row_q = mysqli_fetch_array($run_q)) {
					if ($row_q['cost'] < $min )
						$min = $row_q['cost'];
				}

				$q = "update edges set best_cost = '$min' where edge_id = '$edge'";
				$run_q = mysqli_query($con, $q);

				$q = "select * from Bus where edge_id = '$edge'";
				$run_q = mysqli_query($con, $q);
				$min = 99999;
				while($row_q = mysqli_fetch_array($run_q)) {
					if ($row_q['time'] < $min )
						$min = $row_q['time'];
				}

				$q = "update edges set best_time = '$min' where edge_id = '$edge'";
				$run_q = mysqli_query($con, $q);
			}
		}


		?>
