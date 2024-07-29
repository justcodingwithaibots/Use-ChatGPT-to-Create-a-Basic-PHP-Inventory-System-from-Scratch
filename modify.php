<?php
// Database connection details
$host = 'localhost'; // Change this if your database is on a different host
$dbname = 'db_products';
$username = 'root';
$password = '';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the product ID from the query string
$id = $_GET['id'];

// Fetch the current details of the product
$stmt = $conn->prepare("SELECT name, descriptions, unit, quantity, price_per_unit, currency FROM tbl_list WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die('Product not found');
}

$stmt->bind_result($name, $descriptions, $unit, $quantity, $price_per_unit, $currency);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .link {
            text-align: center;
            margin-top: 20px;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form action="modify-execute.php" method="POST">
        <h2>Modify Product</h2>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label for="descriptions">Descriptions:</label>
        <input type="text" id="descriptions" name="descriptions" value="<?php echo htmlspecialchars($descriptions); ?>" required>

        <label for="unit">Unit:</label>
        <input type="text" id="unit" name="unit" value="<?php echo htmlspecialchars($unit); ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>

        <label for="price_per_unit">Price per Unit:</label>
        <input type="text" id="price_per_unit" name="price_per_unit" value="<?php echo htmlspecialchars($price_per_unit); ?>" required>

        <label for="currency">Currency:</label>
        <select id="currency" name="currency" required>
            <option value="USD" <?php if ($currency == 'USD') echo 'selected'; ?>>USD</option>
            <option value="EUR" <?php if ($currency == 'EUR') echo 'selected'; ?>>EUR</option>
            <option value="GBP" <?php if ($currency == 'GBP') echo 'selected'; ?>>GBP</option>
            <option value="JPY" <?php if ($currency == 'JPY') echo 'selected'; ?>>JPY</option>
            <!-- Add more currencies as needed -->
        </select>

        <button type="submit">Update Product</button>
    </form>

    <div class="link">
        <a href="landing.php">Back to Landing Page</a>
    </div>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
