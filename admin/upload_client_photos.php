<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'] ?? null;
    if (!$client_id) {
        echo '<script>alert("Client ID is required."); window.history.back();</script>';
        exit;
    }

    $uploaded_photos = [];
    $upload_dir = '../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    if (isset($_FILES['client_photos']) && count($_FILES['client_photos']['name']) > 0) {
        // Get base URL
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $base_url = $protocol . $host . dirname(dirname($_SERVER['REQUEST_URI'])) . '/uploads/';
        for ($i = 0; $i < count($_FILES['client_photos']['name']); $i++) {
            $tmp_name = $_FILES['client_photos']['tmp_name'][$i];
            $name = basename($_FILES['client_photos']['name'][$i]);
            if ($tmp_name && is_uploaded_file($tmp_name)) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $unique_name = 'client_photo_' . uniqid() . '.' . $ext;
                $target = $upload_dir . $unique_name;
                if (move_uploaded_file($tmp_name, $target)) {
                    $uploaded_photos[] = $base_url . $unique_name;
                }
            }
        }
    }

    // Fetch existing photos if any
    $sql_photos = "SELECT photos FROM clients WHERE id = ?";
    $stmt_photos = $conn->prepare($sql_photos);
    $stmt_photos->bind_param("i", $client_id);
    $stmt_photos->execute();
    $result_photos = $stmt_photos->get_result();
    $existing_photos = '';
    if ($row = $result_photos->fetch_assoc()) {
        $existing_photos = $row['photos'];
    }
    $stmt_photos->close();

    // Merge new and existing photos
    $all_photos = [];
    if (!empty($existing_photos)) {
        $all_photos = explode(',', $existing_photos);
    }
    $all_photos = array_merge($all_photos, $uploaded_photos);
    $photos_str = implode(',', array_filter($all_photos));

    // Update query with photos
    $sql = "UPDATE clients SET photos = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $photos_str, $client_id);
    $stmt->execute();
    $stmt->close();

    echo '<script>alert("Photos uploaded successfully!"); window.location="client-profile.php?client_id=' . $client_id . '";</script>';
    exit;
}

// If not POST
header('Location: client-profile.php');
exit;
