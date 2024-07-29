<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectronicLibrary</title>
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
            position: relative;
        }

        header h1 {
            display: inline-block;
            margin: 0;
        }

        .login-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        nav {
            text-align: center;
            margin: 20px 0;
        }

        nav a {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            background-color: #ddd;
            border-radius: 5px;
            font-weight: bold;
        }

        nav a:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <h1>ElectronicLibrary</h1>
        <a href="admin.html" class="login-button">Logout</a>
    </header>

    <nav>
        <a href="customer.php">Customer</a>
        <a href="direct_publishers.php">Direct Publishers</a>
        <a href="selfpublishedbooks.php">Self Published Books</a>
        <a href="ebooks.php">eBooks</a>
        <a href="adminauthors.php">Authors</a>
        <a href="publishers.php">Publishers</a>
        <a href="subscription_details.php">Subscription</a>
        <a href="#global-fund">Global Fund</a>
    </nav>

    <!-- Your content goes here -->

</body>

</html>
