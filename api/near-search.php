<?php
header('Content-Type: application/json');
include '../connection.php';

// Read and decode JSON input from React Native
$inputData = json_decode(file_get_contents('php://input'), true);

if (!isset($inputData['lat']) || !isset($inputData['lon'])) {
    echo json_encode(["error" => "Latitude and Longitude are required"]);
    exit;
}

// Get latitude, longitude, and language from input
$lat = $inputData['lat'];
$lon = $inputData['lon'];
$lang = isset($inputData['lang']) && in_array($inputData['lang'], ['en', 'he']) ? $inputData['lang'] : 'en';

// Haversine formula to calculate distance and join with ratings for average rating
$query = "
    SELECT c.id, 
           c.mobile, 
           c.email, 
           c.map_link, 
           c.url, 
           c.from_date, 
           c.to_date, 
           c.camera_status, 
           c.status, 
           c.photos,
           c.latitude, 
           c.longitude, 
           c.club_thumbnail, 
           c.created_at,
           c.opens_from, 
           c.opens_till,
           COALESCE(c.address_$lang, c.address_he, c.address_en) AS address,
           COALESCE(c.bio_$lang, c.bio_he, c.bio_en) AS bio,
           COALESCE(c.client_name_$lang, c.client_name_he, c.client_name_en) AS client_name,
           COALESCE(c.club_name_$lang, c.club_name_he, c.club_name_en) AS club_name,
           COALESCE(c.location_$lang, c.location_he, c.location_en) AS location,
           COALESCE(c.deal_$lang, c.deal_he, c.deal_en) AS deal,
           COALESCE(c.entertainment_type_$lang, c.entertainment_type_he, c.entertainment_type_en) AS entertainment_type,
           (6371 * ACOS(COS(RADIANS(?)) * COS(RADIANS(c.latitude)) 
           * COS(RADIANS(c.longitude) - RADIANS(?)) + SIN(RADIANS(?)) 
           * SIN(RADIANS(c.latitude)))) AS distance,
           IFNULL(AVG(r.rating), 0) AS average_rating
    FROM clients c
    LEFT JOIN ratings r ON r.club_id = c.id
    WHERE c.status = 1
    GROUP BY c.id
    ORDER BY distance ASC;
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ddd", $lat, $lon, $lat);
$stmt->execute();
$result = $stmt->get_result();

$clubs = [];
while ($row = $result->fetch_assoc()) {
    $clubData = $row;

    // Format distance
    $distanceKm = $row['distance'];
    if ($distanceKm < 1) {
        $distanceMeters = round($distanceKm * 1000);
        $clubData['distance'] = $lang === 'he' ? "{$distanceMeters} מ'" : "{$distanceMeters} m";
    } else {
        $clubData['distance'] = $lang === 'he' ? round($distanceKm, 2) . " ק\"מ" : round($distanceKm, 2) . " km";
    }


    // Format opening and closing times without seconds
    if (isset($clubData['opens_from'])) {
        $clubData['opens_from'] = substr($clubData['opens_from'], 0, 5);
    }

    if (isset($clubData['opens_till'])) {
        $clubData['opens_till'] = substr($clubData['opens_till'], 0, 5);
    }

    // Include formatted average rating
    $clubData['average_rating'] = round($row['average_rating'], 2);

    $clubs[] = $clubData;
}

$stmt->close();
$conn->close();

// Return JSON response
echo json_encode($clubs);
?>
