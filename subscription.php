<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans</title>
    <style>
        .subscription-button {
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
    <h1>Subscription Plans</h1>

    <?php
    $connection = pg_connect("host=localhost
                              dbname=DigitalLibrary
                              user=postgres
                              password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    // Fetch all marketplace IDs for the dropdown
    $marketplaceQueryAll = "SELECT marketplace_id, marketplace_country FROM marketplace";
    $marketplaceResultAll = pg_query($connection, $marketplaceQueryAll);

    // Display the dropdown
    echo "<form method='get'>";
    echo "<label for='marketplaceDropdown'>Select Marketplace:</label>";
    echo "<select id='marketplaceDropdown' name='marketplace' onchange='this.form.submit()'>";
    while ($marketplaceRowAll = pg_fetch_assoc($marketplaceResultAll)) {
        $marketplaceIdAll = $marketplaceRowAll['marketplace_id'];
        $marketplaceCountryAll = $marketplaceRowAll['marketplace_country'];
        $selected = ($_GET['marketplace'] == $marketplaceIdAll) ? "selected" : "";
        echo "<option value='$marketplaceIdAll' $selected>$marketplaceIdAll - $marketplaceCountryAll</option>";
    }
    echo "</select>";
    echo "</form>";

    // Check if the selected marketplace parameter is provided
    if (isset($_GET['marketplace'])) {
        $selectedMarketplaceId = $_GET['marketplace'];

        // Fetch marketplace details to show the domain
        $marketplaceQuery = "SELECT * FROM marketplace WHERE marketplace_id = '$selectedMarketplaceId'";
        $marketplaceResult = pg_query($connection, $marketplaceQuery);

        if ($marketplaceRow = pg_fetch_assoc($marketplaceResult)) {
            $selectedMarketplaceDomain = $marketplaceRow['marketplace_country'];
            echo "<p>Selected Marketplace Domain: $selectedMarketplaceDomain</p>";
        }

        // Fetch subscription plans for the selected marketplace_id
        $query = "SELECT * FROM subscriptions WHERE marketplace_id = '$selectedMarketplaceId'";
        $result = pg_query($connection, $query);

        // Display subscription plans
        while ($row = pg_fetch_assoc($result)) {
            $plan_id = $row['plan_id'];
            $plan_name = $row['plan_name'];
            $description = $row['description'];
            $duration = $row['duration'];
            $price = $row['price'];
            $currency = $row['currency'];
            $marketplace_id = $row['marketplace_id'];

            echo "
            <a href=\"index.php?subscriptions=$plan_id&marketplace=$marketplace_id\" class=\"subscription-button\">
                $plan_name - $description (Duration: $duration days, Price: $price $currency)
            </a><br>
            ";
        }
    } else {
        // Handle case where marketplace parameter is not provided
        echo "<p>No marketplace selected. Please go back to the main page.</p>";
    }
    ?>

    <a href="index.php" class="back-button">Back to Main Page</a>
</body>

</html>
