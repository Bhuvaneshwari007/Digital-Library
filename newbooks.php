<!-- books.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Add CSS styles for heart icon and search icon */
        .heart-icon {
            color: red;
            text-decoration: none;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-icon {
            margin-right: 10px;
            width: 20px; /* Adjust the width to your preference */
            height: 20px; /* Adjust the height to your preference */
        }

        .search-input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-btn {
            padding: 8px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="search-container">
        <img src="search-icon.png" alt="Search Icon" class="search-icon">
        <form method="GET">
            <input type="text" name="search" placeholder="Search for books" class="search-input">
            <button type="submit">Search</button>
        </form>
    </div>

    <h2>eBooks available</h2>

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

    // Check if the search parameter is set
    $search = isset($_GET['search']) ? pg_escape_string($_GET['search']) : '';

    // Modify the SQL query to include the search condition for selfpublishedebook table
    $query = "SELECT * FROM selfpublishedebook";
    if (!empty($search)) {
        $query .= " WHERE title ILIKE '%$search%'";
    }

    $result = pg_query($connection, $query);

    if (!$result) {
        echo "An error occurred.<br>";
    }
    ?>
    <table border="1">
        <tr>
            <th>DSID</th>
            <th>Title</th>
            <th>Genre</th>
            <th>Age Level</th>
            <th>Date of Publication</th>
            <th>Action</th>
            <th>Add to Library</th>
            <th>Add to Wishlist</th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($result)) {
            echo "
            <tr>
            <td>{$row['dsid']}</td>
            <td>{$row['title']}</td>
            <td>{$row['genre']}</td>
            <td>{$row['age_level']}</td>
            <td>{$row['date_of_publication']}</td>
            <td><a href='ebookdetails.php?dsid={$row['dsid']}'>View Details</a></td>
            <td>
                <form method='POST' action='add_to_library.php'>
                    <input type='hidden' name='dsid' value='{$row['dsid']}'>
                    <button type='submit' name='add_to_library'>Add to Library</button>
                </form>
            </td>
            <td>
                <form method='POST' action='add_to_wishlist.php'>
                    <input type='hidden' name='dsid' value='{$row['dsid']}'>
                    <button type='submit' name='add_to_wishlist'>Add to Wishlist</button>
                </form>
            </td>
            </tr>
            ";
        }
        ?>
    </table>
</body>

</html>
