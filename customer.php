<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
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

        /* Adjust the width of the Date of Birth column */
        td:nth-child(6) {
            width: 120px;
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
        <h1>Customer Management</h1>
    </header>

    <div class="container">
        <?php
            $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");

            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                // Fetch and display customer data
                $query = "SELECT * FROM public.customer";
                $result = pg_query($connection, $query);

                if (!$result) {
                    echo "Error fetching customer data.";
                } else {
                    echo "<table>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Marketplace ID</th>
                                <th>Action</th>
                            </tr>";

                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['customer_id']}</td>
                                <td>{$row['customer_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['mobile_no']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['date_of_birth']}</td>
                                <td>{$row['marketplace_id']}</td>
                                <td>
                                    <form method='POST' action='delete_customer.php'>
                                        <input type='hidden' name='customer_id' value='{$row['customer_id']}'>
                                        <button type='submit' name='delete_customer'>Delete</button>
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
