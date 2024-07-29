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
    // Redirect to failure page if the connection fails
    header('Location: newproduct-failed.php');
    exit();
}

// Retrieve form data
$id = $_POST['id'];
$name = $_POST['name'];
$descriptions = $_POST['descriptions'];
$unit = $_POST['unit'];
$quantity = $_POST['quantity'];
$price_per_unit = $_POST['price_per_unit'];
$currency = $_POST['currency'];

// Prepare an SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO tbl_list (id, name, descriptions, unit, quantity, price_per_unit, currency) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssids", $id, $name, $descriptions, $unit, $quantity, $price_per_unit, $currency);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to landing page on success
    header('Location: landing.php');
} else {
    // Redirect to failure page on error
    header('Location: newproduct-failed.php');
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
