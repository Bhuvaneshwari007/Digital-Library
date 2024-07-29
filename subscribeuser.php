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

// Query to fetch user's subscription details
$query = "SELECT subscriptions.plan_id,subscriptions.plan_name, subscriptions.description, subscriptions.duration, subscriptions.price, subscriptions.currency
FROM subscriptions
LEFT JOIN customer ON subscriptions.marketplace_id = customer.marketplace_id
WHERE customer.customer_id = $1";
$result = pg_query_params($connection, $query, array($customer_id));

if ($result) {
    $userSubscriptions = pg_fetch_all($result);
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
<style>
body {
    font-family: 'Montserrat', sans-serif;
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
}

h2 {
    color: #4285f4;
    margin-bottom: 20px;
}

.subscription-details {
    border: 1px solid #ccc;
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
    border-top: 1px solid #ccc;
}

.subscription-details .topic {
    font-weight: bold;
    color: #4285f4; /* Adjust the color as needed */
}

    </style>
</head>

<body>
    <div class="container">
        <h2>Subscription Plans</h2>
        <?php
        if ($userSubscriptions) {
            foreach ($userSubscriptions as $subscription) {
                echo "<p>Plan id: " . $subscription['plan_id'] . "</p>";
                echo "<p>Plan Name: " . $subscription['plan_name'] . "</p>";
                echo "<p>Description: " . $subscription['description'] . "</p>";
                echo "<p>Duration: " . $subscription['duration'] . "</p>";
                echo "<p>Price: " . $subscription['price'] . "</p>";
                echo "<p>Currency: " . $subscription['currency'] . "</p>";

                // Check if the plan name is not "Free" before adding the "Buy" button
               // Check if the plan name is not "Free" before adding the "Buy" button
            if ($subscription['plan_name'] !== "Free") {
                echo "<a href='payment.php?plan_id=" . $subscription['plan_id'] . "&plan_name=" . urlencode($subscription['plan_name']) . "&amount=" . $subscription['price'] . "&duration=" . $subscription['duration'] . "'><button>Buy</button></a>";
            } else {
                echo "<p class='bold'>This plan is free.</p>";
            }

                echo "<hr>";
            }
        } else {
            echo "<p>No subscriptions found for the user.</p>";
        }
        ?>
        <!-- Add more user information as needed -->
    </div>
</body>

</html>
