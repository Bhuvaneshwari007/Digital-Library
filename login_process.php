<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    $email = $_POST['email'];
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    // Hash the password using a suitable hashing algorithm (e.g., bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $result = pg_query_params(
        $connection,
        'SELECT * FROM customer WHERE email = $1 AND customer_id = $2 AND password = $3',
        array($email, $userid, $hashedPassword)
    );

    if ($result) {
        $row = pg_fetch_assoc($result);

        // Store user information in the session
        $_SESSION['user_id'] = $row['customer_id'];
        $_SESSION['user_name'] = $row['customer_name'];
        $_SESSION['user_email'] = $row['email'];

        // Redirect to the dashboard or profile page
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid credentials. Please try again.";
    }

    pg_close($connection);
}
?>
