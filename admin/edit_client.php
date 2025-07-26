<?php
include 'connection.php';

// Get client ID
$client_id = $_GET['client_id'] ?? null;
if (!$client_id) {
    die("Client ID is required.");
}

// Fetch client details
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Client not found.");
}

$client = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile - Disco Snap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="wrapper">
        <?php include 'tabbing.php'; ?>
        <div class="main">
            <?php include 'header.php'; ?>
            <main class="content px-3 py-2">
                <div class="container mt-4">
                    <h2>Edit Client Information</h2>
                    <form action="update_client.php" method="POST">
                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">

                        <div class="mb-3">
                            <label class="form-label">Full Name (English)</label>
                            <input type="text" class="form-control" name="client_name_en"
                                value="<?php echo htmlspecialchars($client['client_name_en']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name (Hebrew)</label>
                            <input type="text" dir="rtl" class="form-control" name="client_name_he"
                                value="<?php echo htmlspecialchars($client['client_name_he']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Club (English)</label>
                            <input type="text" class="form-control" name="club_name_en"
                                value="<?php echo htmlspecialchars($client['club_name_en']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Club (Hebrew)</label>
                            <input type="text" dir="rtl" class="form-control" name="club_name_he"
                                value="<?php echo htmlspecialchars($client['club_name_he']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">City (English)</label>
                            <input type="text" class="form-control" name="location_en"
                                value="<?php echo htmlspecialchars($client['location_en']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">City (Hebrew)</label>
                            <input type="text" dir="rtl" class="form-control" name="location_he"
                                value="<?php echo htmlspecialchars($client['location_he']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?php echo htmlspecialchars($client['email']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="mobile"
                                value="<?php echo htmlspecialchars($client['mobile']); ?>">
                        </div>



    <div class="mb-3">
        <label for="entertainmentTypeEn" class="form-label">Type of Entertainment (English)</label>
        <select class="form-control" id="entertainmentTypeEn" name="entertainment_type_en">
            <option value="">Select type of entertainment</option>
            <option value="Club" <?php echo ($client['entertainment_type_en'] == "Club") ? 'selected' : ''; ?>>Club</option>
            <option value="Bar" <?php echo ($client['entertainment_type_en'] == "Bar") ? 'selected' : ''; ?>>Bar</option>
            <option value="Cafe" <?php echo ($client['entertainment_type_en'] == "Cafe") ? 'selected' : ''; ?>>Cafe</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="entertainmentTypeHe" class="form-label">Type of Entertainment (Hebrew)</label>
        <select class="form-control" id="entertainmentTypeHe" name="entertainment_type_he" dir="rtl">
            <option value="">בחר סוג בידור</option>
            <option value="מועדונים" <?php echo ($client['entertainment_type_he'] == "מועדונים") ? 'selected' : ''; ?>>מועדונים</option>
<option value="ברים" <?php echo ($client['entertainment_type_he'] == "ברים") ? 'selected' : ''; ?>>ברים</option>
<option value="בתי קפה" <?php echo ($client['entertainment_type_he'] == "בתי קפה") ? 'selected' : ''; ?>>בתי קפה</option>

        </select>
    </div>

<div class="mb-3">
    <label class="form-label">Bio (English)</label>
    <textarea class="form-control" name="bio_en" rows="4"><?php echo htmlspecialchars($client['bio_en']); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Bio (Hebrew)</label>
    <textarea class="form-control" name="bio_he" rows="4" dir="rtl"><?php echo htmlspecialchars($client['bio_he']); ?></textarea>
</div>

<div class="mb-3">
                            <label class="form-label">Deal (English)</label>
                            <input type="text" class="form-control" name="deal_en"
                                value="<?php echo htmlspecialchars($client['deal_en']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deal (Hebrew)</label>
                            <input type="text" class="form-control" dir="rtl" name="deal_he"
                                value="<?php echo htmlspecialchars($client['deal_he']); ?>">
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" name="latitude"
                                value="<?php echo htmlspecialchars($client['latitude']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" name="longitude"
                                value="<?php echo htmlspecialchars($client['longitude']); ?>">
                        </div>
                        
                        

                        <div class="mb-3">
                            <label class="form-label">RTSP Link</label>
                            <input type="text" class="form-control" name="url"
                                value="<?php echo htmlspecialchars($client['url']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Map Link</label>
                            <input type="text" class="form-control" name="map_link"
                                value="<?php echo htmlspecialchars($client['map_link']); ?>">
                        </div>
                        
                        <div class="mb-3">
    <label class="form-label">Opens From</label>
    <input type="time" class="form-control" name="opens_from"
        value="<?php echo htmlspecialchars($client['opens_from']); ?>">
</div>

<div class="mb-3">
    <label class="form-label">Opens Till</label>
    <input type="time" class="form-control" name="opens_till"
        value="<?php echo htmlspecialchars($client['opens_till']); ?>">
</div>
                        
                        <div class="mb-3">
    <label class="form-label">Valid From</label>
    <input type="date" class="form-control" name="valid_from"
        value="<?php echo htmlspecialchars($client['from_date']); ?>">
</div>

<div class="mb-3">
    <label class="form-label">Valid To</label>
    <input type="date" class="form-control" name="valid_to"
        value="<?php echo htmlspecialchars($client['to_date']); ?>">
</div>


                        <button type="submit" class="btn btn-success">Update Client</button>
                        <a href="view_client.php?client_id=<?php echo $client_id; ?>"
                            class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="index.php" class="text-muted">
                                    <strong>POPCAMZ</strong>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>