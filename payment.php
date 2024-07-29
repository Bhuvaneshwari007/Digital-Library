<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        .payment-form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Payment Details</h2>

        <div class="payment-form">
            <form id="paymentForm" method="post" action="pay.php">
                <label for="plan">Selected Plan:</label>
                <input type="text" id="plan" name="plan" readonly value="<?php echo htmlspecialchars($_GET['plan_name']); ?>">

                <label for="plan">Plan ID:</label>
                <input type="text" id="plan" name="plan" readonly value="<?php echo htmlspecialchars($_GET['plan_id']); ?>">


                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" readonly value="<?php echo htmlspecialchars($_GET['amount']); ?>">


                <label for="duration">Duration:</label>
                <input type="text" id="duration" name="duration" readonly value="<?php echo htmlspecialchars($_GET['duration']); ?>">


                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter your card number">

                <label for="expiryDate">Expiry Date:</label>
                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY">

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" placeholder="Enter CVV">

                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" name="paymentMethod">
                    <option value="card">Credit/Debit Card</option>
                    <option value="upi">UPI</option>
                    <option value="netBanking">Net Banking</option>
                </select>

                <button type="submit" name="payNow">Pay Now</button>
            </form>
        </div>
    </div>

</body>

</html>
