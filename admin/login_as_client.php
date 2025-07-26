<?php
session_name('client_session'); // Use a custom session name for the client
session_start();
require 'connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['id'];

    // Validate and sanitize input
    $client_id = intval($client_id);

    // Fetch client details from the database using the ID
    $query = "SELECT * FROM clients WHERE id = $client_id";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $client = $result->fetch_assoc();

        // Set session variables for the client
        $_SESSION['user_id'] = $client['id'];

        // Redirect to the client's folder/dashboard
        header("Location: ../client/index.php");
        exit;
    } else {
        // Client not found
        $_SESSION['error'] = 'Client not found.';
        header("Location: index.php");
        exit;
    }
} else {
    // Redirect back if accessed directly
    header("Location: index.php");
    exit;
}
?>