<?php
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'email' is provided in the URL
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Delete query
    $sql = "DELETE FROM clients WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Client deleted successfully');
                window.location.href='client_list.php'; // Change to your main page
              </script>";
    } else {
        echo "<script>
                alert('Error deleting client: " . $conn->error . "');
                window.location.href='client_list.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request');
            window.location.href='client_list.php';
          </script>";
}

$conn->close();
?>
