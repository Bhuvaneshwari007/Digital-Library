<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>

<body>
    <?php
    // Include the PHP script here
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "C:/xampp/htdocs/DigitalLibrary/createaccount/insert_customer.php";

    }
    ?>

    <form method="post">
        <h2>Create an account</h2>
        <div class="form-group fullname">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" placeholder="Enter your full name" required>
        </div>
        <div class="form-group email">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email" placeholder="Enter your email address" required>
        </div>
        <div class="form-group mobile">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" id="mobile" placeholder="Enter your mobile number" required>
        </div>
        <div class="form-group password">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
        </div>
        <div class="form-group date">
            <label for="date">Birth Date</label>
            <input type="date" name="date" id="date" placeholder="Select your date" required>
        </div>
        <div class="form-group gender">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="" selected disabled>Select your gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <!-- Modify the dropdown button to fetch data from the 'marketplace' table -->
        <div class="form-group dropdown-button">
            <label for="marketplace">MarketPlace</label>
            <select name="marketplace" id="marketplace" required>
                <option value="" selected disabled>Select a marketplace</option>
                <?php
                $connection = pg_connect("host=localhost dbname=DigitalLibrary user=postgres password=2004");
                if (!$connection) {
                    echo "An error occurred.<br>";
                    exit;
                }
                $result = pg_query($connection, "SELECT * FROM marketplace");
                if (!$result) {
                    echo "An error occurred.<br>";
                    exit;
                }

                while ($row = pg_fetch_assoc($result)) {
                    $marketplaceID = $row['marketplace_id'];
                    $marketplaceCountry = $row['marketplace_country'];

                    echo "<option value=\"$marketplaceID\">$marketplaceCountry</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group login-link">
            <p>Already have an account? <a href="login.html">Login</a></p>
        </div>
        <div class="form-group submit-btn">
            <input type="submit" value="Submit">
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($customer_id)) {

            echo "<script>alert('Account created successfully! Your Customer ID is: $customer_id'); window.location.href = 'createaccount.php';</script>";

            echo "<script>setTimeout(function(){ window.location.href = '../index.php'; }, 3000);</script>";
        } else {
            echo "An error occurred while creating the account.";
        }
    }
    ?>

    <script src="script.js"></script>
</body>

</html>