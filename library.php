<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        /* Add CSS styles for heart icon */
    </style>
</head>

<body>
    <h2>Welcome to your Library</h2>

    <?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    // Fetch additional user information from the database based on customer_id
    $customer_id = $_SESSION['user_id'];

    $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }

    $query = "SELECT customerlibrary.dsid, ebook.title, ebook.isbn, customerlibrary.expire_date, customerlibrary.pagesread
              FROM customerlibrary 
              LEFT JOIN ebook ON customerlibrary.dsid = ebook.dsid
              WHERE customer_id = $1";

    $result = pg_query_params($connection, $query, array($customer_id));

    if (!$result) {
        echo "An error occurred.<br>";
    }
    ?>
    <table border="1">
        <tr>
            <th>DSID</th>
            <th>Title</th>
            <th>ISBN</th>
            <th>Expire Date</th>
            <th>PagesRead</th>
            <th>Remove</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($result)) {
            echo "
            <tr>
            <td>{$row['dsid']}</td>
            <td>{$row['title']}</td>
            <td>{$row['isbn']}</td>
            <td>{$row['expire_date']}</td>
            <td>{$row['pagesread']}</td>
            <td>
                <form method='POST' action='remove_from_library.php'>
                    <input type='hidden' name='dsid' value='{$row['dsid']}'>
                    <button type='submit' name='remove_from_library'>Remove</button>
                </form>
            </td>
            </tr>
            ";
        }
        ?>
    </table>
</body>

</html>
