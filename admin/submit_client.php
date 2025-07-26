<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Function to check if value exists, otherwise set NULL
    function sanitizeInput($value) {
        return isset($value) && $value !== '' ? $value : null;
    }

    // Collect and sanitize data from POST request
    $client_name_en = sanitizeInput($_POST['client_name_en'] ?? null);
    $client_name_he = sanitizeInput($_POST['client_name_he'] ?? null);
    $mobile = sanitizeInput($_POST['mobile'] ?? null);
    $email = sanitizeInput($_POST['email'] ?? null);
    $club_name_en = sanitizeInput($_POST['club_name_en'] ?? null);
    $club_name_he = sanitizeInput($_POST['club_name_he'] ?? null);
    $from_date = sanitizeInput($_POST['from_date'] ?? null);
    $to_date = sanitizeInput($_POST['to_date'] ?? null);
    $password = isset($_POST['password']) && $_POST['password'] !== '' ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $location_en = sanitizeInput($_POST['location_en'] ?? null);
    $location_he = sanitizeInput($_POST['location_he'] ?? null);
    $mapLink = sanitizeInput($_POST['map_link'] ?? null);
    $url = sanitizeInput($_POST['url'] ?? null);
    $bio_en = sanitizeInput($_POST['bio_en'] ?? null);
    $bio_he = sanitizeInput($_POST['bio_he'] ?? null);
    $deal_en = sanitizeInput($_POST['deal_en'] ?? null);
    $deal_he = sanitizeInput($_POST['deal_he'] ?? null);
    $entertainment_type_en = sanitizeInput($_POST['entertainment_type_en'] ?? null);
    $entertainment_type_he = sanitizeInput($_POST['entertainment_type_he'] ?? null);
    $latitude = sanitizeInput($_POST['latitude'] ?? null);
    $longitude = sanitizeInput($_POST['longitude'] ?? null);

    // Prepare the SQL query
    $stmt = $conn->prepare(
        "INSERT INTO clients (
            client_name_en, client_name_he, mobile, email, 
            club_name_en, club_name_he, from_date, to_date, password, 
            location_en, location_he, map_link, url, 
            bio_en, bio_he, deal_en, deal_he, entertainment_type_en, entertainment_type_he, latitude, longitude
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    // Bind parameters dynamically with NULL support
    $stmt->bind_param(
        "sssssssssssssssssssss", 
        $client_name_en, 
        $client_name_he, 
        $mobile, 
        $email, 
        $club_name_en, 
        $club_name_he, 
        $from_date, 
        $to_date, 
        $password, 
        $location_en, 
        $location_he, 
        $mapLink, 
        $url, 
        $bio_en, 
        $bio_he, 
        $deal_en, 
        $deal_he, 
        $entertainment_type_en,
        $entertainment_type_he,
        $latitude, 
        $longitude
    );

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
