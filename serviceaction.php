	<?php
		
		echo $_POST['from'];
	    echo $_POST['to'];
		
		session_start();
		include("includes/db.php");

		$graph = "select * from edges";
		$run_g = mysqli_query($con, $graph);
		while($row_g = mysqli_fetch_array($run_g)) {
			$from = $row_g['from_node'];
			$to = $row_g['to_node'];
			$cost = $row_g['best_cost'];
			$time = $row_g['best_time'];
			$dist = $row_g['distance'];

			$g_cost[$from][$to] = $cost;
			$g_time[$from][$to] = $time;
			$g_dist[$from][$to] = $dist;
			///echo "done";

		}

		$_SESSION['graph'] = 1;


		if($_POST['criteria'] == 1) {
			$g = $g_dist;
		}
		else if($_POST['criteria'] == 2) {
			$g = $g_cost;
		}
		else if($_POST['criteria'] == 3) {
			$g = $g_time;
		}

		$a = $_POST['from'];
		$b = $_POST['to'];
		
		$q = "select * from nodes where node_title = '$a'";
		$run_q = mysqli_query($con, $q);
		$row_q = mysqli_fetch_array($run_q);
		$a = $row_q['node_id'];

		$q = "select * from nodes where node_title = '$b'";
		$run_q = mysqli_query($con, $q);
		$row_q = mysqli_fetch_array($run_q);
		$b = $row_q['node_id'];

		//initialize the array for storing
		$S = array();//the nearest path with its parent and weight
		$Q = array();//the left nodes without the nearest path


		$q = "select * from nodes";
		$run_q = mysqli_query($con, $q);
		while($row_q = mysqli_fetch_array($run_q)) {
			$val = $row_q['node_id'];
			$Q[$val] = 99999;
		}

		$Q[$a] = 0;

		//start calculating
		while(!empty($Q)){
			$min = array_search(min($Q), $Q);//the most min weight
			if($min == $b) break;
			if(isset($g[$min]) ) {
				foreach($g[$min] as $key=>$val) {

					if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
						$Q[$key] = $Q[$min] + $val;
						$S[$key] = array($min, $Q[$key]);

					}
				}
			}
			unset($Q[$min]);
		}

		//list the path
		$path = array();
		$pos = $b;

		if (!array_key_exists($b, $S)) 
		{
			///echo "Found no way.";
			$_SESSION['from']=$_POST['from'];
			$_SESSION['to']  =$_POST['to']  ;
			$_SESSION['status']=0;
			header('Location: result.php'); 
			return;
		}
		else 
		{
			while($pos != $a)
			{
				$path[] = $pos;
				$pos = $S[$pos][0];
			}
			$path[] = $a;
			$path = array_reverse($path);
			
			$_SESSION['status']=1;
			$_SESSION['from']=$_POST['from'];
			$_SESSION['to']  =$_POST['to']  ;
			$_SESSION['path']  =$path ;
			$_SESSION['criteria']=$_POST['criteria'];
			$_SESSION['length']=$S[$b][1];
			
			echo "<br />From $a to $b";
			echo "<br />The length is ".$S[$b][1];
			echo "<br />Path is ".implode('->', $path);
			header('Location: result.php');
		}

		?>