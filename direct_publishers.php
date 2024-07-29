<!-- direct_publisher_management.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Publisher Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #232f3e;
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
            background-color: #232f3e;
            color: white;
        }

        td {
            vertical-align: middle;
        }

        /* Adjust the width of the columns as needed */
        td:nth-child(1) {
            width: 120px; /* Account ID column width */
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

        /* Center the table */
        table {
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <header>
        <h1>Direct Publisher Management</h1>
    </header>

    <div class="container">
        <?php
            $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");

            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                // Fetch and display direct publisher data
                $query = "SELECT * FROM public.direct_publishers";
                $result = pg_query($connection, $query);

                if (!$result) {
                    echo "Error fetching direct publisher data.";
                } else {
                    echo "<table>
                            <tr>
                                <th>Account ID</th>
                                <th>Business Type</th>
                                <th>Phone Number</th>
                                <th>Legal Name</th>
                                <th>Date of Birth</th>
                                <th>Action</th>
                            </tr>";

                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['account_id']}</td>
                                <td>{$row['bussiness_type']}</td>
                                <td>{$row['phone_no']}</td>
                                <td>{$row['legal_name']}</td>
                                <td>{$row['dob']}</td>
                                <td>
                                    <form method='POST' action='delete_direct_publisher.php'>
                                        <input type='hidden' name='account_id' value='{$row['account_id']}'>
                                        <button type='submit' name='delete_direct_publisher'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                    }

                    echo "</table>";
                }
            }

            // Close the database connection
            pg_close($connection);
        ?>
    </div>
</body>

</html>
