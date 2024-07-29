<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_to_library']) && isset($_POST['dsid'])) {
    $customer_id = $_SESSION['user_id'];
    $dsid = $_POST['dsid'];

    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    // Check if the book is already in the library
    $check_query = "SELECT * FROM customerlibrary WHERE customer_id = $1 AND dsid = $2";
    $check_result = pg_query_params($connection, $check_query, array($customer_id, $dsid));

    if (pg_num_rows($check_result) > 0) {
        echo "<script>alert('Book is already in your library.'); window.location.href = 'books.php';</script>";
    } else {
        try {
            // Attempt to add the book to the user's library
            $insert_query = "INSERT INTO customerlibrary (customer_id, dsid) VALUES ($1, $2)";
            $insert_result = pg_query_params($connection, $insert_query, array($customer_id, $dsid));

            if (!$insert_result) {
                echo "<script>alert('Only subscribed users can access this book.'); window.location.href = 'books.php';</script>";
            } else {
                echo "<script>alert('Book added to your library successfully.'); window.location.href = 'books.php';</script>";
            }
        } catch (Exception $e) {
            // Handle PostgreSQL exception and check for the specific trigger condition
            if (strpos($e->getMessage(), 'Only subscribed users can add subscribed books to their library') !== false) {
                echo "<script>alert('Only subscribed users can access this book.'); window.location.href = 'books.php';</script>";
            } else {
                echo "<script>alert('An unexpected error occurred.'); window.location.href = 'books.php';</script>";
            }
        }
    }

    pg_close($connection);
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'books.php';</script>";
}
?>
