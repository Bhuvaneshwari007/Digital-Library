<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Published eBook Details</title>
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

h1 {
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    color: #777;
}

input,
select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
    padding: 10px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
}

    </style>
    
</head>

<body>
    <div class="container">
        <h1>Self-Published eBook Details</h1>
        <form method="post" action="process_selfpublishedebook.php">
          
            <div class="form-group">
                <label for="account_id">Account ID:</label>
                <input type="text" name="account_id" required>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" name="genre">
            </div>
            <div class="form-group">
                <label for="age_level">Age Level:</label>
                <input type="text" name="age_level">
            </div>
            <div class="form-group">
                <label for="date_of_publication">Date of Publication:</label>
                <input type="date" name="date_of_publication">
            </div>
            <div class="form-group">
                <label for="page_count">Page Count:</label>
                <input type="number" name="page_count">
            </div>
            <div class="form-group">
                <label for="marketplace_id">Marketplace ID:</label>
                <input type="text" name="marketplace_id">
            </div>
            <div class="form-group">
                <label for="paymentmethod">Payment Method:</label>
                <select name="paymentmethod">
                    <option value="eft">EFT</option>
                    <option value="check">Check</option>
                    <option value="wire">Wire</option>
                </select>
            </div>
            <div class="form-group">
                <label for="royalty_plan">Royalty Plan:</label>
                <select name="royalty_plan">
                    <option value="70%">Select an option</option>
                    <option value="70%">70%</option>
                    <option value="30%">30%</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>


</html>
