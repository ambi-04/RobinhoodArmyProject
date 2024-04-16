	<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>robin_dashboard</title>
	<link rel="stylesheet" type="text/css" href="robin_dashboard.css"> 
	</head>
	<body>
	<header>
		<h3>Robin Dashboard </h3>

        
		<div class="tab">
			<button class="tablinks" onclick="openTab(event, 'Home')" id="defaultOpen">Home</button>
			<button class="tablinks" onclick="openTab(event, 'Completed Donations')">Completed Donations</button>
			<button class="tablinks" onclick="openTab(event, 'Pending Donations')">Pending Donations</button>
			<button class="tablinks" onclick="openTab(event, 'Account Settings')" >Account Settings</button>
            <button onclick="logout()">Logout</button>
		</div>
	</header>
		
		<div id="Home" class="tabcontent">
		<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
			include "connection.php";
			
			session_start();
			$username = $_SESSION['username'];
			$password = $_SESSION['password'];

			//retreive the details of the robin
			$sql = "SELECT * FROM robins WHERE username = '$username' AND password = '$password'";
			$result = $conn->query($sql);
			$robin_row = $result->fetch_assoc();
			$pincode = $robin_row['pincode'];//$pincode variable now stores the pincode
			$contactNumber = $robin_row['contactNumber'];
			$residential_address = $robin_row['residential_address'];
			$robinId = $robin_row['robinId'];
			$name = $robin_row['name'];
        
			$poc_id = $robin_row['poc_id']; // Assuming this is the column name in robins table

			echo "<pre><h4> ROBIN ID: $robinId  Name:  $name  Contact Number:  $contactNumber  pincode: $pincode  </h4></pre><hr>";
			
			//retreive the poc details assigned to that robin
			$poc_sql = "SELECT * FROM pocs WHERE poc_id = '$poc_id'";
			$poc_result = $conn->query($poc_sql);
			$poc_row = $poc_result->fetch_assoc();
			$poc_name = $poc_row['name'];
			$poc_contact = $poc_row['contact'];
			$poc_pincode = $poc_row['pincode'];
			
			echo "<h4> Center head : </h4>";
			echo "<pre><h4> POC ID: $poc_id  Name:  $poc_name  Contact Number:  $poc_contact  pincode: $poc_pincode  </h4></pre><hr>";
			
		?>	
		</div>

		<div id="Completed Donations" class="tabcontent">
		
			<h4>Below are your completed donations:</h4>
			<?php
$sql_completedDonations = "SELECT donation_id, status FROM donations WHERE robinId = '{$robin_row['robinId']}' AND status = 1";
$result_completedDonations = $conn->query($sql_completedDonations);

// Check if any completed donations exist
if ($result_completedDonations->num_rows > 0) {
    // Output data of each row
    while ($row = $result_completedDonations->fetch_assoc()) {
        $donation_id = $row["donation_id"];
        $status = $row["status"];
        
        // Query to fetch food details
        $sql_food_details = "SELECT food_name, quantity, prep_time, date FROM food WHERE donation_id = '$donation_id'";
        $result_food_details = $conn->query($sql_food_details);

        // Query to fetch donor details
        $sql_donor_details = "SELECT name, email, contact, address, pincode FROM donors WHERE donor_id = (SELECT donor_id FROM donations WHERE donation_id = '$donation_id')";
        $result_donor_details = $conn->query($sql_donor_details);

        // Check if food details exist
        if ($result_food_details && $result_food_details->num_rows > 0) {
            echo "<h4>Completed Donation ID: " . $donation_id . "</h4>";
            echo "<h4>Status: " . ($status ? "Completed" : "Pending") . "</h4>";

            // Display food details
            echo "<h4>Food Details:</h4>";
            echo "<ul>"; // Start unordered list
            while ($food_row = $result_food_details->fetch_assoc()) {
                echo "<li>";
                foreach ($food_row as $key => $value) {
                    echo $key . ": " . $value . "<br>";
                }
                echo "</li>";
            }
            echo "</ul>"; // End unordered list
        } else {
            echo "<h4>Completed Donation ID: " . $donation_id . "</h4>";
            echo "<h4>Status: " . ($status ? "Completed" : "Pending") . "</h4>";
            echo "<h4>Food Details: No food details found</h4>";
        }

        // Display donor details
        echo "<h4>Donor Details:</h4>";
        $donor_details = $result_donor_details->fetch_assoc();
        foreach ($donor_details as $key => $value) {
            echo $key . ": " . $value . "<br>";
        }

        echo "<hr>"; // Separate each completed donation details
    }
} else {
    // If no completed donations found
    echo "Sorry, No completed donations found.";
}
	
	
?>

	</div>

		<div id="Pending Donations" class="tabcontent">
			<h5>Below are pending donations details:</h5>
			<?php
$sql_completedDonations = "SELECT donation_id, status FROM donations WHERE robinId = '{$robin_row['robinId']}' AND status = 0";
$result_completedDonations = $conn->query($sql_completedDonations);

// Check if any completed donations exist
if ($result_completedDonations->num_rows > 0) {
    // Output data of each row
    while ($row = $result_completedDonations->fetch_assoc()) {
        $donation_id = $row["donation_id"];
        $status = $row["status"];
        
        // Query to fetch food details
        $sql_food_details = "SELECT food_name, quantity, prep_time, date FROM food WHERE donation_id = '$donation_id'";
        $result_food_details = $conn->query($sql_food_details);

        // Query to fetch donor details
        $sql_donor_details = "SELECT name, email, contact, address, pincode FROM donors WHERE donor_id = (SELECT donor_id FROM donations WHERE donation_id = '$donation_id')";
        $result_donor_details = $conn->query($sql_donor_details);

        // Check if food details exist
        if ($result_food_details && $result_food_details->num_rows > 0) {
            echo "<h4>Donation ID: " . $donation_id . "</h4>";
            echo "<h4><p style='color:red;'>Status: Pending</p></h4>";

            // Add a form for each pending donation with a "done" button
            echo "<form method='post' action='change_status.php'>";
            echo "<input type='hidden' name='donation_id' value='$donation_id'>";
            echo "<input type='submit' name='completed' value='Mark as Completed'>";
            echo "</form>";
            
            // Display food details
            echo "<h4>Food Details:</h4>";
            echo "<ul>"; // Start unordered list
            while ($food_row = $result_food_details->fetch_assoc()) {
                echo "<li>";
                foreach ($food_row as $key => $value) {
                    echo $key . ": " . $value . "<br>";
                }
                echo "</li>";
            }
            echo "</ul>"; // End unordered list
        } else {
            echo "<h4>Donation ID: " . $donation_id . "</h4>";
            echo "<h4><p style='color:red;'>Status: Pending</p></h4>";
            echo "<h4>Food Details: No food details found</h4>";
        }

        // Display donor details
        echo "<h4>Donor Details:</h4>";
        $donor_details = $result_donor_details->fetch_assoc();
        foreach ($donor_details as $key => $value) {
            echo $key . ": " . $value . "<br>";
        }

        echo "<hr>"; // Separate each completed donation details
    }
} else {
    // If no completed donations found
    echo "Good job! No pending donations found.";
}
?>


		</div>

		
		<div id="Account Settings" class="tabcontent mini-box">
			<p style="text-align: center;"> <strong>Edit the fields which you want to update </p>
			
			<form  method="POST"action='robin_account_settings.php'>
				
            <p style="text-align: center;"><label for="NewUsername">username  </label></p>
            <p style="text-align: center;"><input type="text" id="NewUsername" name="NewUsername" value="<?php echo"$username"; ?>"><br></p>

			<p style="text-align: center;">	<label for="password">password  </label></p>
			<p style="text-align: center;">	<input type="text" id="password" name="password" value="<?php echo"$password"; ?>"><br></p>
				
            <p style="text-align: center;"><label for="contactNumber">contact</label></p>
            <p style="text-align: center;">   <input type="text" id="contactNumber" name="contactNumber" value="<?php echo"$contactNumber"; ?>"><br></p>
                
            <p style="text-align: center;">   <label for="residential_address">address</label></p>
            <p style="text-align: center;">  <input type="text" id="residential_address" name="residential_address" value="<?php echo"$residential_address"; ?>"><br></p>
                
            <p style="text-align: center;">  <label for="name">Name</label></p>
            <p style="text-align: center;">  <input type="text" id="name" name="name" value="<?php echo"$name"; ?>"><br></p>

            <p style="text-align: center;"><input type='hidden' name='robinId' value="<?php echo"$robinId"; ?>"></p>
			<p style="text-align: center;">	<input type="submit" value="submit" name="submit"></p>
				
			</form>
		</div>

	<script>
        function logout() {
        // Redirect to homepage.html
        window.location.href = "index.html";
    }

		function openTab(evt, tabName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(tabName).style.display = "block";
			evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>

	</body>
</html>

