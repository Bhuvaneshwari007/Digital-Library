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

// Fetch plan details from the form
$plan_id = $_POST['plan']; // Assuming 'plan' is the name attribute in the form
$amount = $_POST['amount'];
$duration  = $_POST['duration'];


// Initialize variables to store payment details
$transaction_id = '';
$date_of_transaction = '';
$transaction_type = 'Credit';
$currency = 'INR'; // You may want to get this from the plan details or elsewhere

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payNow'])) {
    // Generate a unique transaction_id
    $transaction_id = uniqid('TXN');

    // Get the current date
    $date_of_transaction = date('Y-m-d');

    // Get other payment details from the form
    $card_number = $_POST['cardNumber'];
    $expiry_date = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $payment_method = $_POST['paymentMethod'];

    // Perform basic validation (you should perform more thorough validation)
    if (empty($card_number) || empty($expiry_date) || empty($cvv)) {
        echo "Please fill in all the payment details.";
    } else {
        // Here, you would typically integrate with a payment gateway
        // For this example, we're just echoing the details
        echo "Payment Details:<br>";
        echo "Transaction ID: $transaction_id<br>";
        echo "Date: $date_of_transaction<br>";
        echo "Amount: $amount $currency<br>";
        echo "Card Number: $card_number<br>";
        echo "Expiry Date: $expiry_date<br>";
        echo "CVV: $cvv<br>";
        echo "Payment Method: $payment_method<br>";

        // Insert subscription details into the subscription_details table
$start_date = date('Y-m-d'); // Assuming the subscription starts immediately

// Calculate end date based on the selected plan's duration
$end_date = date('Y-m-d', strtotime($start_date . ' + ' . $duration . ' days'));


$query_subscription_details = "INSERT INTO subscription_details (customer_id, plan_id, start_date, end_date) VALUES ($1, $2, $3, $4)";
$result_subscription_details = pg_query_params($connection, $query_subscription_details, array($customer_id, $plan_id, $start_date, $end_date));

if (!$result_subscription_details) {
    echo "Error inserting subscription details.";
} else {
    echo "Subscription details inserted. End Date: " . $end_date;

    // Redirect to index.php after successful payment
    header("Location: index.php");
    exit;
}

    }
}

// Close the database connection
pg_close($connection);
?>
