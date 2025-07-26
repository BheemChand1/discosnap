<?php
require 'connection.php'; // Ensure this file establishes a MySQLi connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['client_id'])) {
        die("<script>alert('Invalid request: Client ID is missing'); window.history.back();</script>");
    }

    $client_id = intval($_POST['client_id']);
    $upload_dir = '../uploads/';
    $allowed_types = ['webp'];

    $file = $_FILES['thumbnail'];
    $file_name = basename($file['name']);
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate file type
    if (!in_array($file_ext, $allowed_types)) {
        die("<script>alert('Invalid file type. Only WebP format is allowed'); window.history.back();</script>");
    }

    // Validate file size (Max: 1MB)
    if ($file_size > 1 * 1024 * 1024) {
        die("<script>alert('File size must be less than 1MB'); window.history.back();</script>");
    }

    // Generate unique file name
    $new_file_name = uniqid('thumb_', true) . '.' . $file_ext;
    $upload_path = $upload_dir . $new_file_name;
    $full_url = 'https://' . $_SERVER['HTTP_HOST'] . '/uploads/' . $new_file_name;

    // Move file to uploads directory
    if (move_uploaded_file($file_tmp, $upload_path)) {
        // Update database using MySQLi
        $sql = "UPDATE clients SET club_thumbnail = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $full_url, $client_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Thumbnail updated successfully!'); window.location.href = document.referrer;</script>";
        } else {
            unlink($upload_path); // Remove uploaded file if DB update fails
            echo "<script>alert('Database update failed'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('File upload failed'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method'); window.history.back();</script>";
}
?>
