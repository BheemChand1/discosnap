<?php
include 'connection.php';

if (isset($_POST['status']) && isset($_POST['user_id'])) {
    $status = $_POST['status'];
    $user_id = $_POST['user_id'];

    // Update the status in the database
    $query = "UPDATE clients SET status = $status WHERE id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>