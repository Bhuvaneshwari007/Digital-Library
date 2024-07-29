<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Publish your eBook!</title>
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

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="date"] {
            padding: 8px 5px;
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

        .details {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .details span {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <!-- Your PHP code and form go here -->
    <?php
    // Include the PHP script here
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include the correct path to your insert_author.php file
        include "C:/xampp/htdocs/DigitalLibrary/insert_author.php";

        // Establish a database connection
        $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");

        // Check if the connection was successful
        if (!$connection) {
            echo "An error occurred while connecting to the database.";
            exit;
        }

        // Additional code to insert into the 'direct_publishers' table
        $account_id = $_POST['account_id'];
        $phone_no = $_POST['mobile'];
        $dob = $_POST['date'];
        $bussiness_type = $_POST['bussiness_type'];
        $legal_name = $_POST['legal_name'];

        // Check if the account with the provided ID already exists
        $check_account_query = "SELECT * FROM public.direct_publishers WHERE account_id = $1";
        $check_account_params = array($account_id);
        $check_account_result = pg_query_params($connection, $check_account_query, $check_account_params);
        
        if ($check_account_result && pg_num_rows($check_account_result) > 0) {
            $account_details = pg_fetch_assoc($check_account_result);
        } else {
            // Insert new account if it doesn't exist
            $insert_query = "INSERT INTO public.direct_publishers (account_id, bussiness_type, phone_no, legal_name, dob) 
                             VALUES ($1, $2, $3, $4, $5)";
            $insert_params = array($account_id, $bussiness_type, $phone_no, $legal_name, $dob);
            $result_insert = pg_query_params($connection, $insert_query, $insert_params);

            if (!$result_insert) {
                echo "An error occurred while inserting data into direct_publishers table.";
            }
        }

        // Close the database connection
        pg_close($connection);
    }
    ?>

    <form method="post">
        <h1>Direct Publish</h1>
        <h2>Create your author account</h2>
        <div class="form-group">
            <label for="account_id">Account ID</label>
            <input type="text" name="account_id" id="account_id" placeholder="Enter your account ID" required>
        </div>
        <div class="form-group">
            <label for="bussiness_type">Business Type</label>
            <select name="bussiness_type" id="bussiness_type" required>
                <option value="" selected disabled>Select your business type</option>
                <option value="Individual">Individual</option>
                <option value="Corporation">Corporation</option>
            </select>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" id="mobile" placeholder="Enter your mobile number" required>
        </div>
        <div class="form-group">
            <label for="legal_name">Legal Name</label>
            <input type="text" name="legal_name" id="legal_name" placeholder="Enter your legal name" required>
        </div>
        <div class="form-group">
            <label for="date">Birth Date</label>
            <input type="date" name="date" id="date" required>
        </div>
        <div class="form-group submit-btn">
            <input type="submit" value="Submit">
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($account_details)) {
            echo "<div class='details'>Account with ID <span>$account_id</span> already exists. Details: $account_details</div>";
        } else {
            echo "<div class='details'>Account created successfully! Your Customer ID is: $customer_id</div>";
            echo "<script>setTimeout(function(){ window.location.href = '../index.php'; }, 3000);</script>";
        }
    }
    ?>

    <script src="script.js"></script>
</body>

</html>
