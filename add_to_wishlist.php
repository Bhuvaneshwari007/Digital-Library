<!-- add_to_wishlist.php -->
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_to_wishlist']) && isset($_POST['dsid'])) {
    $customer_id = $_SESSION['user_id'];
    $dsid = $_POST['dsid'];

    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    // Check if the book is already in the wishlist
    $check_query = "SELECT * FROM wishlist WHERE customer_id = $1 AND dsid = $2";
    $check_result = pg_query_params($connection, $check_query, array($customer_id, $dsid));

    if (pg_num_rows($check_result) > 0) {
        echo "<script>alert('Book is already in your wishlist.'); window.location.href = 'books.php';</script>";
    } else {
        // Add the book to the user's wishlist
        $insert_query = "INSERT INTO wishlist (customer_id, dsid) VALUES ($1, $2)";
        $insert_result = pg_query_params($connection, $insert_query, array($customer_id, $dsid));

        if ($insert_result) {
            echo "<script>alert('Book added to your wishlist successfully.'); window.location.href = 'books.php';</script>";
        } else {
            echo "<script>alert('Error adding book to your wishlist.'); window.location.href = 'books.php';</script>";
        }
    }

    pg_close($connection);
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'books.php';</script>";
}
?>
