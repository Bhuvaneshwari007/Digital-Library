<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Bank Details</title>
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
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

        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #555;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #777;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit-btn {
            margin-top: 15px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>
</head>

<body>
<?php
// Include the PHP script here to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the PostgreSQL database
    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred while connecting to the database.<br>";
        echo pg_last_error($connection); // Display the error
        exit;
    }

    // Retrieve and sanitize data from the form
    $account_id = isset($_POST['account_id']) ? pg_escape_string($connection, $_POST['account_id']) : '';
    $bank_location = isset($_POST['bank_location']) ? pg_escape_string($connection, $_POST['bank_location']) : '';
    $bank_account_no = isset($_POST['bank_account_no']) ? pg_escape_string($connection, $_POST['bank_account_no']) : '';
    $ifsccode = isset($_POST['ifsccode']) ? pg_escape_string($connection, $_POST['ifsccode']) : '';
    $account_holder_name = isset($_POST['account_holder_name']) ? pg_escape_string($connection, $_POST['account_holder_name']) : '';
    $bank_name = isset($_POST['bank_name']) ? pg_escape_string($connection, $_POST['bank_name']) : '';

    // Use prepared statements for better security
    $query = "INSERT INTO public.author_bank(
        account_id, bank_location, bank_account_no, ifsccode, account_holder_name, bank_name)
              VALUES ($1, $2, $3, $4, $5, $6)";
    $insert_params = array($account_id, $bank_location, $bank_account_no, $ifsccode, $account_holder_name, $bank_name);

    $result = pg_query_params($connection, $query, $insert_params);

    if ($result) {
        echo "<script>alert('Bank details added successfully!');</script>";
    } else {
        http_response_code(500);
        echo "An error occurred while inserting data.<br>";
        echo pg_last_error($connection); // Display the error
    }

    pg_close($connection);
}
?>


    <form method="post">
        <h1>Author Bank Details</h1>
        <div class="form-group">
            <label for="account_id">Account ID</label>
            <input type="text" name="account_id" id="account_id" placeholder="Enter your account ID" required>
        </div>
        <div class="form-group">
            <label for="bank_location">Bank Location</label>
            <input type="text" name="bank_location" id="bank_location" placeholder="Enter bank location" required>
        </div>
        <div class="form-group">
            <label for="bank_account_no">Bank Account Number</label>
            <input type="text" name="bank_account_no" id="bank_account_no" placeholder="Enter bank account number" required>
        </div>
        <div class="form-group">
            <label for="ifsccode">IFSC Code</label>
            <input type="text" name="ifsccode" id="ifsccode" placeholder="Enter IFSC code" required>
        </div>
        <div class="form-group">
            <label for="account_holder_name">Account Holder Name</label>
            <input type="text" name="account_holder_name" id="account_holder_name" placeholder="Enter account holder name" required>
        </div>
        <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" name="bank_name" id="bank_name" placeholder="Enter bank name" required>
        </div>
        <div class="form-group submit-btn">
            <input type="submit" value="Submit">
        </div>
    </form>

    <script src="script.js"></script>
</body>

</html>
