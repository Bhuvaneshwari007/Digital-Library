<!-- customer_management.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Published eBook Management</title>
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

        /* Adjust the width of the Date of Publication column */
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
        <h1>Self-Published eBook Management</h1>
    </header>

    <div class="container">
        <?php
            $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");

            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                // Fetch and display self-published ebook data
                $query = "SELECT * FROM public.selfpublishedebook";
                $result = pg_query($connection, $query);

                if (!$result) {
                    echo "Error fetching self-published ebook data.";
                } else {
                    echo "<table>
                            <tr>
                                <th>DSID</th>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Age Level</th>
                                <th>Date of Publication</th>
                                <th>Action</th>
                            </tr>";

                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['dsid']}</td>
                                <td>{$row['title']}</td>
                                <td>{$row['genre']}</td>
                                <td>{$row['age_level']}</td>
                                <td>{$row['date_of_publication']}</td>
                                <td>
                                    <form method='POST' action='delete_ebook.php'>
                                        <input type='hidden' name='dsid' value='{$row['dsid']}'>
                                        <button type='submit' name='delete_ebook'>Delete</button>
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
