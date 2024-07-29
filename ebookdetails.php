<?php
$connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
if (!$connection) {
    echo "An error occurred.<br>";
    exit;
}

$dsid = isset($_GET['dsid']) ? $_GET['dsid'] : null;

if ($dsid) {
    $query = "SELECT * FROM ebookdetails WHERE dsid = $1";
    $result = pg_query_params($connection, $query, array($dsid));

    if ($result && $row = pg_fetch_assoc($result)) {
        echo "<h2>Details for eBook: {$row['dsid']}</h2>";
        echo "<p>Language: {$row['Language']}</p>";
        echo "<p>File Size: {$row['file_size']}</p>";
        echo "<p>Age Level: {$row['age_level']}</p>";
        echo "<p>Genre: {$row['genre']}</p>";
        echo "<p>Rating: {$row['rating']}</p>";
        echo "<p>Page Count: {$row['page_count']}</p>";
    } else {
        echo "Details not found for the selected eBook.";
    }
} else {
    echo "Invalid request. DSID not provided.";
}

pg_close($connection);
?>
