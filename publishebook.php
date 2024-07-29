<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish eBook</title>
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
       body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff; /* White Text Color */
        }

        nav {
            display: flex;
            justify-content: space-around;
          /*  background-color: #5a2a00;  Darker Chocolate Brown */
            padding: 10px 0;
            width: 100%;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #804000; /* Highlight on Hover */
        }

        .container {
            max-width: 800px;
            margin: 20px 0;
            padding: 30px;
         /*   background-color: rgba(138, 77, 45, 0.8); /* Lighter Chocolate Brown with Opacity */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .container h2 {
         /*   color: #3d1f00; /* Darker Chocolate Brown Heading */
            font-size: 32px;
            margin-bottom: 20px;
        }

        .container p {
            color: #fff; /* White Text Color */
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .container .campaign {
            color: #804000; /* Highlighted Campaign Text Color */
            font-size: 22px;
            font-weight: bold;
        }

        .publish-btn {
            background-color: #804000; /* Button Color */
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .publish-btn:hover {
           /* background-color: #5a2a00; /* Darker Brown on Hover */
        }
    </style>
</head>

<body>
    <header>
        <h1>Directly Publish eBook</h1>
    </header>

    <nav>
        <a href="home.php">Home</a>
        <a href="directpublish.php">Publish Your Masterpiece</a>
        <a href="banksdetail.php">Set Up Your Bank Details</a>
        <a href="dashboard.php?account_id=$account_id">Explore Your Dashboard</a>

        <a href="withholdpayments.php">Optimize Your Earnings</a>
    </nav>

    <div class="container">
        <!-- Your page content goes here -->
        <h2>Welcome to the World of eBook Publishing!</h2>
        <p>Unleash your creativity and share your stories with the world. It's time to turn your ideas into captivating eBooks that resonate with readers globally.</p>
        <p>Ready to embark on your publishing journey? Then, start creating literary magic!</p>
        <a href="directpublish.php" class="publish-btn">Publish Your Masterpiece</a>
        <!-- Add more content as needed -->
    </div>

    <script src="script.js"></script>
</body>

</html>
