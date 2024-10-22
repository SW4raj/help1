<?php
// Set up database connection details
$servername = "localhost"; // Usually 'localhost'
$username = "root"; // Your database username (default for XAMPP is root)
$password = ""; // Your database password (default for XAMPP is empty)
$database = "freelancing_site"; // The name of your database (replace with your actual DB name)

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
