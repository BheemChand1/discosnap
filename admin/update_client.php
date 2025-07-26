<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Handle multiple image uploads
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
    $client_id = $_POST['client_id'];
    $client_name_en = $_POST['client_name_en'];
    $client_name_he = $_POST['client_name_he'];
    $club_name_en = $_POST['club_name_en'];
    $club_name_he = $_POST['club_name_he'];
    $location_en = $_POST['location_en'];
    $location_he = $_POST['location_he'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $entertainment_type_en = $_POST['entertainment_type_en'];
    $entertainment_type_he = $_POST['entertainment_type_he'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $bio_en = $_POST['bio_en'];
    $bio_he = $_POST['bio_he'];
    $deal_en = $_POST['deal_en'];
    $deal_he = $_POST['deal_he'];
    $url = $_POST['url'];
    $map_link = $_POST['map_link'];
    
     // New Fields
    $from_date = $_POST['valid_from'];
    $to_date = $_POST['valid_to'];
    $opens_from = !empty($_POST['opens_from']) ? $_POST['opens_from'] : null;
$opens_till = !empty($_POST['opens_till']) ? $_POST['opens_till'] : null;


    // Update query with photos
    $sql = "UPDATE clients SET 
        client_name_en = ?, 
        client_name_he = ?,
        club_name_en = ?, 
        club_name_he = ?,
        location_en = ?, 
        location_he = ?,
        email = ?, 
        mobile = ?, 
        entertainment_type_en = ?, 
        entertainment_type_he = ?,
        latitude = ?, 
        longitude = ?,
        bio_en = ?,
        bio_he = ?,
        deal_en = ?,
        deal_he = ?,
        url = ?,
        map_link = ?,
        from_date = ?, 
        to_date = ?, 
        opens_from = ?, 
        opens_till = ?,
        photos = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssssi", $client_name_en, $client_name_he,$club_name_en, $club_name_he,$location_en, $location_he, $email, $mobile, $entertainment_type_en, $entertainment_type_he, $latitude, $longitude, $bio_en, $bio_he, $deal_en, $deal_he, $url, $map_link, $from_date, $to_date, $opens_from, $opens_till, $photos_str, $client_id);

    if ($stmt->execute()) {
        echo "<script>alert('Client updated successfully!'); window.location='client-profile.php?client_id=$client_id';</script>";
    } else {
        echo "<script>alert('Error updating client!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
