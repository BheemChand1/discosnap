<?php
// Database credentials
$servername = "localhost"; // MySQL server address
$username = "aksh9412_disco_snap_user"; // Replace with your MySQL username
$password = "aMNt%}gT.lor"; // Replace with your MySQL password (empty string if no password)
$database = "aksh9412_disco_snap"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connection successful!";
}
?>