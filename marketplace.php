<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select Marketplace</title>
    <style>
        .marketplace-button {
            display: block;
            margin: 10px;
            padding: 10px;
            text-align: center;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>Select Your Marketplace</h1>

    <?php
    $connection = pg_connect("host=localhost
                              dbname=DigitalLibrary
                              user=postgres
                              password=2004");
    if(!$connection) {
        echo "An error occurred.<br>";
        exit;
    }
    $result = pg_query($connection, "SELECT * FROM marketplace");
    if(!$result) {
        echo "An error occurred.<br>";
        exit;
    }
    ?>

    <?php
    while($row = pg_fetch_assoc($result)) {
        $marketplaceID = $row['marketplace_id'];
        $marketplaceCountry = $row['marketplace_country'];

        echo "
        <a href=\"index.php?marketplace=$marketplaceID\" class=\"marketplace-button\">
            $marketplaceCountry
        </a>
        ";
    }
    ?>

</body>
</html>
