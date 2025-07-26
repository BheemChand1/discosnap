<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and assign POST data
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

    // Optional Fields
    $from_date = $_POST['valid_from'];
    $to_date = $_POST['valid_to'];
    $opens_from = !empty($_POST['opens_from']) ? $_POST['opens_from'] : null;
    $opens_till = !empty($_POST['opens_till']) ? $_POST['opens_till'] : null;
    $address_en = $_POST['address_en'] ?? '';
    $address_he = $_POST['address_he'] ?? '';

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
            address_en = ?, 
            address_he = ?, 
            password = ?
            WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssssssssssssssssi",
            $client_name_en, $client_name_he,
            $club_name_en, $club_name_he,
            $location_en, $location_he,
            $email, $mobile,
            $entertainment_type_en, $entertainment_type_he,
            $latitude, $longitude,
            $bio_en, $bio_he,
            $deal_en, $deal_he,
            $url, $map_link,
            $from_date, $to_date,
            $opens_from, $opens_till,
            $address_en, $address_he,
            $password,
            $client_id
        );
    } else {
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
            address_en = ?, 
            address_he = ?
            WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssssssssssssssssssi",
            $client_name_en, $client_name_he,
            $club_name_en, $club_name_he,
            $location_en, $location_he,
            $email, $mobile,
            $entertainment_type_en, $entertainment_type_he,
            $latitude, $longitude,
            $bio_en, $bio_he,
            $deal_en, $deal_he,
            $url, $map_link,
            $from_date, $to_date,
            $opens_from, $opens_till,
            $address_en, $address_he,
            $client_id
        );
    }

    if ($stmt->execute()) {
        echo "<script>alert('Client updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating client!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
