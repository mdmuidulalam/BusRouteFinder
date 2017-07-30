		<html>
		<?php
		include("includes/db.php");
		session_start();
		$status=$_SESSION['status'];
		$from=$_SESSION['from'];
		$to=$_SESSION['to'];
		$path=(array)$_SESSION['path'];
		$ct=$_SESSION['criteria'];
		$length=$_SESSION['length'];
		if($status==1)
		{
			echo "From $from to $to ";
			if($ct==1)
			echo "<br />The length is ".$length;
			else if($ct==2)
			echo "<br />The cost is ".$length;
			///echo "<br />Path is ".implode('->', $path);
			echo "<br />";
			for( $i=0 ; $i <sizeof($path) ; $i++ )
			{
				$q = "select * from nodes where node_id = '$path[$i]'";
				$run_q = mysqli_query($con, $q);
				$row_q = mysqli_fetch_array($run_q);
				$b = $row_q['node_title'];
				if($i==0)echo " $b ";
				else
				{
					echo "  >  $b " ;
				}
				$a=$b;
			}
			echo "<br />";
			echo "<br />";
			echo "<br />";
			for( $i=0 ; $i <sizeof($path) ; $i++ )
			{
				$q = "select * from nodes where node_id = '$path[$i]'";
				$run_q = mysqli_query($con, $q);
				$row_q = mysqli_fetch_array($run_q);
				$b = $row_q['node_title'];
				if($i==0);
				else
				{
					echo " $a to  $b " ;
					echo "<br />";
					echo "<br />";
					$q = "select * from edges where from_node = '".$path[$i-1]."' and to_node='".$path[$i]."'";
					///echo $q;
					$run_q = mysqli_query($con, $q);
					$row_q = mysqli_fetch_array($run_q);
					$ed = $row_q['edge_id'];
					///echo $ed;
					$q = "select * from bus where edge_id = '$ed'";
					$run_q = mysqli_query($con, $q);
					///$row_q = mysqli_fetch_array($run_q);
					$result= $run_q;
					if ($result->num_rows > 0) 
					{
						$ret =  array();
						while($row = $result->fetch_assoc()) {
							///array_push($ret, $row[$retKey]);
							echo "Bus Name: ".$row['bus_title'];
							echo "<br />";
							echo "Bus Name: ".$row['cost'];
							echo "<br />";
							echo "<br />";
						}
						return $ret;
					}
				}
				$a=$b;
			}
		}
		else
		{
			echo "
		<body background='noway.jpg' >
		
		</body>";
		}
		
		?>
		</html>