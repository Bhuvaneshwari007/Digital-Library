<?php
$connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_customer'])) {
    $customer_id = $_POST['customer_id'];

    // Delete associated records in customerlibrary first
    $delete_customerlibrary_query = "DELETE FROM public.customerlibrary WHERE customer_id = $1";
    $delete_customerlibrary_result = pg_query_params($connection, $delete_customerlibrary_query, array($customer_id));

    // Delete associated records in wishlist
    $delete_customerwishlist_query = "DELETE FROM public.wishlist WHERE customer_id = $1";
    $delete_customerwishlist_result = pg_query_params($connection, $delete_customerwishlist_query, array($customer_id));

    $delete_subscription_query = "DELETE FROM public.subscription_details WHERE customer_id = $1";
    $delete_subscription_result = pg_query_params($connection, $delete_subscription_query, array($customer_id));

    // Proceed with customer deletion if customerlibrary and wishlist deletions were successful
    if ($delete_customerlibrary_result && $delete_customerwishlist_result && $delete_subscription_result)  {
        $delete_query = "DELETE FROM public.customer WHERE customer_id = $1";
        $delete_result = pg_query_params($connection, $delete_query, array($customer_id));

        if ($delete_result) {
            echo "<script>alert('Customer removed successfully.'); window.location.href = 'customer.php';</script>";
        } else {
            echo "<script>alert('Error removing customer.'); window.location.href = 'customer.php';</script>";
        }
    } else {
        echo "Error deleting associated records.";
    }

    // Close the database connection
    pg_close($connection);
}
?>
