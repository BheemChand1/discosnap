<?php
header('Content-Type: application/json');
include('../connection.php'); // Include your database connection file

// Get raw POST data
$data = json_decode(file_get_contents("php://input"));

// Check if user_id and language are provided
if (isset($data->user_id) && isset($data->lang)) {
    $user_id = $data->user_id;
    $language = $data->lang;
    // Validate language input (only 'en' or 'he' allowed)
    if (!in_array($language, ['en', 'he'])) {
        echo json_encode(["message" => "Invalid language. Use 'en' or 'he'."]);
        exit;
    }

    // Prepare the SQL query to get favorites with client details
    $query = "SELECT clients.* FROM favorites 
              JOIN clients ON favorites.club_id = clients.id 
              WHERE favorites.user_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter to the SQL query
        $stmt->bind_param("i", $user_id);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            $favorites = [];
            while ($row = $result->fetch_assoc()) {
                // Filter the response based on the requested language
                $filtered_data = [
                    "id" => $row["id"],
                    "client_name" => $row["client_name_" . $language],
                    "mobile" => $row["mobile"],
                    "email" => $row["email"],
                    "club_name" => $row["club_name_" . $language],
                    "location" => $row["location_" . $language],
                    "map_link" => $row["map_link"],
                    "url" => $row["url"],
                    "from_date" => $row["from_date"],
                    "to_date" => $row["to_date"],
                    "bio" => $row["bio_" . $language],
                    "deal" => $row["deal_" . $language],
                    "entertainment_type" => $row["entertainment_type_" . $language],
                    "camera_status" => $row["camera_status"],
                    "status" => $row["status"],
                    "latitude" => $row["latitude"],
                    "longitude" => $row["longitude"],
                    "club_thumbnail" => $row["club_thumbnail"],
                    "opens_from" => $row["opens_from"],
                    "opens_till" => $row["opens_till"],
                    "created_at" => $row["created_at"]
                ];
                $favorites[] = $filtered_data;
            }

            echo json_encode(["favorites" => $favorites]);
        } else {
            echo json_encode(["message" => "Failed to fetch favorites"]);
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(["message" => "Failed to prepare statement"]);
    }
} else {
    echo json_encode(["message" => "user_id and language are required"]);
}

// Close connection
$conn->close();
?>
