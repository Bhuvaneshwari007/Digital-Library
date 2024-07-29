<?php
// Ensure that the necessary data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the PostgreSQL database
    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    // Retrieve and sanitize data from the form
    $fullname = pg_escape_string($connection, $_POST['fullname']);
    $email = pg_escape_string($connection, $_POST['email']);
    $mobile = pg_escape_string($connection, $_POST['mobile']);
    $password = pg_escape_string($connection, $_POST['password']);
    $date = pg_escape_string($connection, $_POST['date']);
    $gender = pg_escape_string($connection, $_POST['gender']);
    $marketplace_id = pg_escape_string($connection, $_POST['marketplace']);

    // Check if the email already exists
    $email_exists_query = "SELECT COUNT(*) FROM userprofile WHERE email = '$email'";
    $email_exists_result = pg_query($connection, $email_exists_query);
    $email_exists = pg_fetch_result($email_exists_result, 0);

    if ($email_exists > 0) {
        echo "<script>alert('Email already exists. Please use a different email address.'); window.location.href = 'createaccount.php';</script>";


    } else {
        // Generate customer_id based on email and some random characters
        $customer_id = substr(md5($email . time()), 0, 20);

        // Use prepared statements for better security
        $query = "INSERT INTO customer (customer_id, customer_name, email, mobile_no, gender, date_of_birth, marketplace_id, password)
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $params = array($customer_id, $fullname, $email, $mobile, $gender, $date, $marketplace_id, $password);

        $result = pg_query_params($connection, $query, $params);
        

        if ($result) {
            echo "<script>alert('Account created successfully! Your Customer ID is: $customer_id'); window.location.href = 'createaccount.php';</script>";

            
        } else {
            http_response_code(500);
            echo "An error occurred while inserting data.<br>";
        }
    }

    pg_close($connection);
} else {
    echo "Invalid request method.<br>";
}
?>
