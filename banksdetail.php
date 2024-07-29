<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: bankdetails.php");
    exit;
}

// Fetch additional user information from the database based on customer_id
$account_id = $_SESSION['user_id'];

// Connect to the database
$connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
if (!$connection) {
    echo "An error occurred while connecting to the database.";
    exit;
}

// Query to fetch user details from the customer table
$query = "SELECT * FROM author_bank WHERE account_id = $1";
$result = pg_query_params($connection, $query, array($account_id));

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
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin: auto;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            margin: 5px 0;
        }

        .edit-btn {
            background-color: #ff9900;
            color: #fff;
            cursor: pointer;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #e68a00;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User Details</h2>
        <p><strong>Account ID:</strong> <?php echo $userDetails['account_id']; ?></p>
        <p><strong>Bank Location:</strong> <?php echo $userDetails['bank_location']; ?></p>
        <p><strong>Bank Account No:</strong> <?php echo $userDetails['bank_account_no']; ?></p>
        <p><strong>IFSC Code:</strong> <?php echo $userDetails['ifsccode']; ?></p>
        <p><strong>Account Holder Name:</strong> <?php echo $userDetails['account_holder_name']; ?></p>
        <p><strong>Bank Name:</strong> <?php echo $userDetails['bank_name']; ?></p>
        <a href="bankdetails.php" class="edit-btn">Edit Bank Details</a>
    </div>
</body>

</html>
