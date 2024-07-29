<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch additional user information from the database based on customer_id
$customer_id = $_SESSION['user_id'];

// Connect to the database
$connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
if (!$connection) {
    echo "An error occurred while connecting to the database.";
    exit;
}

// Query to fetch user details from the customer table
$query = "SELECT * FROM customer WHERE customer_id = $1";
$result = pg_query_params($connection, $query, array($customer_id));

if ($result) {
    $userDetails = pg_fetch_assoc($result);
} else {
    echo "An error occurred while fetching user details.";
    exit;
}

// Close the database connection
pg_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
</head>

<body>
    <div class="container">
        <h2>Profile: <?php echo $userDetails['customer_name']; ?></h2>
        <p>Email: <?php echo $userDetails['email']; ?></p>
        <p>Mobile No: <?php echo $userDetails['mobile_no']; ?></p>
        <p>Gender: <?php echo $userDetails['gender']; ?></p>
        <p>Date of Birth: <?php echo $userDetails['date_of_birth']; ?></p>
        <!-- Add more user information as needed -->
    </div>
</body>

</html>
