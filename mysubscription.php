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
$query = "SELECT * FROM subscription_details WHERE customer_id = $1";
$result = pg_query_params($connection, $query, array($customer_id));

// Initialize $userDetails with default values
$userDetails = [
    'plan_id' => 'N/A',
    'start_date' => 'N/A',
    'end_date' => 'N/A',
];

if ($result) {
    $userDetails = pg_fetch_assoc($result) ?? $userDetails;
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Subscription Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        h2 {
            color: #4285f4;
            margin-bottom: 20px;
        }

        .subscription-details {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .subscription-details p {
            margin: 8px 0;
        }

        .subscription-details .bold {
            font-weight: bold;
        }

        .subscription-details button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .subscription-details button:hover {
            background-color: #45a049;
        }

        .subscription-details hr {
            margin-top: 16px;
            margin-bottom: 16px;
            border: 0;
            border-top: 1px solid #ddd;
        }

        .subscription-details .topic {
            font-weight: bold;
            color: #4285f4;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User Subscription Details</h2>
        <div class="subscription-details">
            <p><span class="topic">Plan ID:</span> <?php echo $userDetails['plan_id']; ?></p>
            <p><span class="topic">Start Date:</span> <?php echo $userDetails['start_date']; ?></p>
            <p><span class="topic">End Date:</span> <?php echo $userDetails['end_date']; ?></p>
            <!-- Add more user information as needed -->
            <hr>
            <button onclick="window.location.href='subscribeuser.php'">Renew Subscription</button>
        </div>
    </div>
</body>

</html>
