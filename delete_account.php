<?php
include "connection.php";
if(isset($_GET['donor_id']))
{
    $donor_id = $_GET['donor_id'];
	$sql_donation = "select *  from donors x, donations y where x.donor_id = y.donor_id and y.status = 0" ;
	$result_donation = $conn->query($sql_donation);
	if($result_donation)
	{
		$num_rows = $result_donation->num_rows;
		if($num_rows != 0) 
		{	
					echo"cannot delete your account since you have some pending donations, you can delete when all donations are complete";
					echo "<br><a href= 'donorD.php'>Go back to dashboard</a>";
		}
		else
		{
			$sql = "DELETE FROM donors WHERE donor_id = $donor_id";
			if($conn->query($sql) === true)
			{ 
				echo "Record was deleted successfully."; 
				echo "<br><a href= 'index.html'>Go back to homepage</a>";
			} 
			else
			{ 
    			echo "ERROR: Could not able to execute $sql. "  
                                         . conn->error; 
			} 
		}
			
    }
    
}
?>
