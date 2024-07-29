<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

// Fetch user details from session variables
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account</title>
    <!-- Add your head content here -->
</head>

<body>
    <h1>Welcome, <?php echo $user_name; ?>!</h1>
    <p>User ID: <?php echo $user_id; ?></p>
    <p>Email: <?php echo $user_email; ?></p>

    <!-- Add more content as needed -->

    <a href="logout.php">Logout</a>
</body>

</html>
