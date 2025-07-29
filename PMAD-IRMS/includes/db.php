<?php
// Database connection settings
$host = 'localhost'; // Change if your DB is hosted elsewhere
$db   = 'pmad'; // Change to your database name
$user = 'root'; // Change to your DB username
$pass = ''; // Change to your DB password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?> 