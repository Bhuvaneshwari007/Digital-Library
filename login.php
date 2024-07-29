<?php
session_start();

$authenticated = false;

if (isset($_POST['verify']) && $_POST['verify'] == "Verify") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : null;

    // Validate and sanitize user input
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $customer_id = filter_var($customer_id, FILTER_SANITIZE_STRING);

    $conn = pg_connect("host=localhost port=5432 dbname=DigitalLibrary user=postgres password=2004");

    if ($conn) {
        $query = "SELECT verify($1, $2, $3) AS result, customer_id, customer_name, email FROM customer WHERE email = $1";
        $res = pg_query_params($conn, $query, array($email, $customer_id, $pwd));

        if ($res) {
            $result = pg_fetch_assoc($res);

            if ($result && $result['result'] == 1) {
                // Verification successful
                $_SESSION['user_id'] = $result['customer_id'];
                $_SESSION['user_name'] = $result['customer_name'];
                $_SESSION['user_email'] = $result['email'];

                $authenticated = true;

                // Redirect to index.html with customer_id as a parameter
                header('location: index.php?customer_id=' . $result['customer_id']);
                exit();
            } else {
                $error_message = "Invalid credentials";
            }
        } else {
            $error_message = "Query execution failed";
        }

        pg_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #f00;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="email">Email ID:</label>
        <input type="text" id="email" name="email" required />

        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" required />

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" required />

        <input type="submit" value="Verify" name="verify" />

        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
    </form>
</body>

</html>
