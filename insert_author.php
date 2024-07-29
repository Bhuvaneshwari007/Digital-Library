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
    $account_id = isset($_POST['account_id']) ? pg_escape_string($connection, $_POST['account_id']) : '';
    $phone_no = isset($_POST['phone_no']) ? pg_escape_string($connection, $_POST['phone_no']) : '';
    $dob = isset($_POST['dob']) ? pg_escape_string($connection, $_POST['dob']) : '';
    $bussiness_type = isset($_POST['bussiness_type']) ? pg_escape_string($connection, $_POST['bussiness_type']) : '';
    $legal_name = isset($_POST['legal_name']) ? pg_escape_string($connection, $_POST['legal_name']) : '';

    // Check if the account already exists
    $account_exists_query = "SELECT COUNT(*) FROM direct_publishers WHERE account_id = '$account_id'";
    $account_exists_result = pg_query($connection, $account_exists_query);
    $account_exists = pg_fetch_result($account_exists_result, 0);

    if ($account_exists > 0) {
        // Redirect to publishebook.php if the account already exists
        header("Location: publishebook.php?account_id=$account_id");
        exit;
    } else {
        // Use prepared statements for better security
        $query = "INSERT INTO public.direct_publishers(
            account_id, phone_no, dob, bussiness_type, legal_name)
                  VALUES ($1, $2, $3, $4, $5)";
        $insert_params = array($account_id, $phone_no, $dob, $bussiness_type, $legal_name);

        $result = pg_query_params($connection, $query, $insert_params);

        if ($result) {
            echo "<script>alert('Account created successfully!'); window.location.href = 'index.php';</script>";
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
