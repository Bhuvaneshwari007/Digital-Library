<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        td {
            vertical-align: middle;
        }

        button {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <header>
        <h1>Dashboard</h1>
    </header>

    <div class="container">
        <?php
        // Get account_id from URL parameter
        $account_id = isset($_GET['account_id']) ? $_GET['account_id'] : '';

        // Validate account_id
        if (!empty($account_id)) {
            // Connect to the PostgreSQL database
            $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
            if (!$connection) {
                echo "An error occurred while connecting to the database.<br>";
                exit;
            }

            // Fetch self-published eBooks for the customer
            $query = "SELECT * FROM selfpublishedebook WHERE account_id = $1";
            $result = pg_query_params($connection, $query, array($account_id));

            if (!$result) {
                echo "An error occurred while fetching data.<br>";
            } else {
                // Display table header
                echo "<table>
                        <tr>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Age Level</th>
                            <th>Date of Publication</th>
                            <th>No of orders</th>
                            <th>Royalty Plan</th>
                            <th>Actions</th>
                        </tr>";

                // Display each row of the result with a remove button
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['title']}</td>
                            <td>{$row['genre']}</td>
                            <td>{$row['age_level']}</td>
                            <td>{$row['date_of_publication']}</td>
                            <td>{$row['no_of_orders']}</td>
                            <td>{$row['royalty_plan']}</td>
                            <td>
                                <form method='POST' action='remove_from_dashboard.php'>
                                    <input type='hidden' name='dsid' value='{$row['dsid']}'>
                                    <button type='submit' name='remove_from_dashboard'>Remove</button>
                                </form>
                            </td>
                        </tr>";
                }

                echo "</table>";
            }

            // Close the database connection
            pg_close($connection);
        } else {
            echo "Invalid account_id.";
        }
        ?>
    </div>

    <script>
        function removeEbook(dsid) {
            var account_id = "<?php echo $account_id; ?>";

            var confirmRemove = confirm("Are you sure you want to remove this eBook?");
            if (confirmRemove) {
                window.location.href = "remove_ebook.php?dsid=" + dsid + "&account_id=" + account_id;
            }
        }
    </script>
</body>

</html>
