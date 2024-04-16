
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";

if(isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch donor details based on username and password
    $sql = "SELECT * FROM donors WHERE username = '$username' AND password = '$password'";
    
    // Execute the SQL query
    $result = $conn->query($sql);

    if($result) {
        $num_rows = $result->num_rows;
        if($num_rows == 1) {
            // Retrieve the details of the donor
            $row = $result->fetch_assoc();
            $donor_id = $row['donor_id'];

            // Start session and store donor ID
            session_start();
            $_SESSION['donor_id'] = $donor_id;

            // Redirect to the donor dashboard
            header("Location: donorD.php");
            exit();
        } else {
            // Invalid username or password
            echo "<p>Invalid username or password.</p>";
        }
    } else {
        // Error executing query
        echo "Error: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>




<!-- <?php
//this is commented code

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "database.php";

if(isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    // SQL query to fetch donor details based on username and password
    $sql = "SELECT * FROM donors WHERE username = '$username' AND password = '$password'";

    // Execute the SQL query
    $result = $conn->query($sql);

    if($result) {

        $num_rows = $result->num_rows;

        if($num_rows == 1) {
            // Retrieve the details of the donor
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $address = $row['address'];
            $donor_id = $row['donor_id'];
            $email = $row['email'];

            // Display donor details
            echo "<pre><h4> Donor ID: $donor_id    Name: $name  Email ID:  $email Residential Address: $address  </h4></pre><hr>";
            echo "<a href='food.html'>Donate food</a>";
			
            // Start session and store donor ID
            session_start();
            $_SESSION['donor_id'] = $donor_id;
        } else {
            echo "<p>Invalid username or password.</p>";
        }
    } else {
        // Debugging: Print any errors that occur during query execution
        echo "Error: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?> --> 
