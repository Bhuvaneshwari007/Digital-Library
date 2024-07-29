<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['remove_from_wishlist']) && isset($_POST['dsid'])) {
    $customer_id = $_SESSION['user_id'];
    $dsid = $_POST['dsid'];

    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    // Remove the book from the wishlist
    $remove_query = "DELETE FROM wishlist WHERE customer_id = $1 AND dsid = $2";
    $remove_result = pg_query_params($connection, $remove_query, array($customer_id, $dsid));

    if ($remove_result) {
        echo "<script>alert('Book removed from your wishlist successfully.'); window.location.href = 'wishlist.php';</script>";
    } else {
        echo "<script>alert('Error removing book from your wishlist.'); window.location.href = 'wishlist.php';</script>";
    }

    pg_close($connection);
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'wishlist.php';</script>";
}
?>
