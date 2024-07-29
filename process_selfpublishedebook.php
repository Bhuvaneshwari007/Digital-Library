<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the PostgreSQL database
    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred while connecting to the database.<br>";
        exit;
    }

    // Generate a unique dsid (you can customize this generation logic based on your requirements)
    $dsid = uniqid('ebook_', true);

    // Retrieve and sanitize data from the form
    $account_id = isset($_POST['account_id']) ? pg_escape_string($connection, $_POST['account_id']) : '';
    $title = isset($_POST['title']) ? pg_escape_string($connection, $_POST['title']) : '';
    $genre = isset($_POST['genre']) ? pg_escape_string($connection, $_POST['genre']) : '';
    $age_level = isset($_POST['age_level']) ? pg_escape_string($connection, $_POST['age_level']) : '';
    $date_of_publication = isset($_POST['date_of_publication']) ? $_POST['date_of_publication'] : null;
    $page_count = isset($_POST['page_count']) ? (int)$_POST['page_count'] : null;
    $marketplace_id = isset($_POST['marketplace_id']) ? pg_escape_string($connection, $_POST['marketplace_id']) : '';
    $paymentmethod = isset($_POST['paymentmethod']) ? pg_escape_string($connection, $_POST['paymentmethod']) : '';
    $royalty_plan = isset($_POST['royalty_plan']) ? pg_escape_string($connection, $_POST['royalty_plan']) : '';

    // Use prepared statements for better security
    $query = "INSERT INTO public.selfpublishedebook(
        dsid, account_id, title, genre, age_level, date_of_publication, page_count, marketplace_id, paymentmethod,royalty_plan)
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9,$10)";
    $insert_params = array($dsid, $account_id, $title, $genre, $age_level, $date_of_publication, $page_count, $marketplace_id, $paymentmethod,$royalty_plan);

    $result = pg_query_params($connection, $query, $insert_params);

    if ($result) {
        // Book details added successfully, redirect to publishebook.php
        header("Location: publishebook.php");
        exit;
    } else {
        http_response_code(500);
        echo "An error occurred while inserting data.<br>";
    }

    pg_close($connection);
}
?>
