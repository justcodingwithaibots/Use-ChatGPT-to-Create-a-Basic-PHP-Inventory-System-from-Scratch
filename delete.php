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

// Prepare an SQL statement to delete the product
$stmt = $conn->prepare("DELETE FROM tbl_list WHERE id = ?");
$stmt->bind_param("s", $id);

// Execute the statement
$stmt->execute();

// Redirect to the landing page
header('Location: landing.php');

// Close the statement and connection
$stmt->close();
$conn->close();
?>
