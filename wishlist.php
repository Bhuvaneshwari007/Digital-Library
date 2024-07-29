<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        /* Add CSS styles for heart icon */
        .heart-icon {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Wishlist</h2>

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

    $query = "SELECT wishlist.dsid, ebook.title, ebook.isbn
              FROM wishlist 
              LEFT JOIN ebook ON wishlist.dsid = ebook.dsid
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
            <th>AccessType</th>
            <th>Remove from Wishlist</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($result)) {
            echo "
            <tr>
            <td>{$row['dsid']}</td>
            <td>{$row['title']}</td>
            <td>{$row['isbn']}</td>
            <td>
                <form method='POST' action='add_to_library.php'>
                    <input type='hidden' name='dsid' value='{$row['dsid']}'>
                    <button type='submit' name='add_to_library'>Add to Library</button>
                </form>
            </td>
            <td>
                <form method='POST' action='remove_from_wishlist.php'>
                    <input type='hidden' name='dsid' value='{$row['dsid']}'>
                    <button type='submit' name='remove_from_wishlist'>Remove</button>
                </form>
            </td>
            </tr>
            ";
        }
        ?>
    </table>
</body>

</html>
