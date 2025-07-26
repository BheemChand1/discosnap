<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'] ?? null;
    $photo = $_POST['photo'] ?? '';
    if (!$client_id || !$photo) {
        echo 'error';
        exit;
    }

    // Fetch current photos
    $sql = "SELECT photos FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $photos = $row['photos'];
        $photos_arr = array_filter(explode(',', $photos));
        // Remove the photo from the array (match full URL or filename)
        $photo_basename = basename(parse_url($photo, PHP_URL_PATH));
        $photos_arr = array_filter($photos_arr, function($item) use ($photo, $photo_basename) {
            $item = trim($item);
            if ($item === $photo) return false;
            // Also remove if just the filename matches
            $item_basename = basename(parse_url($item, PHP_URL_PATH));
            if ($item_basename === $photo_basename) return false;
            return true;
        });
        $new_photos = implode(',', $photos_arr);
        // Update DB
        $update = $conn->prepare("UPDATE clients SET photos = ? WHERE id = ?");
        $update->bind_param('si', $new_photos, $client_id);
        $update->execute();
        $update->close();
        // Delete file from server if local
        if (strpos($photo, 'http://') === false && strpos($photo, 'https://') === false) {
            $file_path = realpath(__DIR__ . '/../uploads/' . $photo);
            if ($file_path && file_exists($file_path)) {
                @unlink($file_path);
            }
        } else {
            // If full URL, try to extract filename and delete
            $parsed = parse_url($photo);
            if (isset($parsed['path'])) {
                $basename = basename($parsed['path']);
                $file_path = realpath(__DIR__ . '/../uploads/' . $basename);
                if ($file_path && file_exists($file_path)) {
                    @unlink($file_path);
                }
            }
        }
        echo 'success';
        exit;
    }
}
echo 'error';
