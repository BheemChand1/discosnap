<?php

session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../logout.php"); // Redirect to login page if not logged in
    exit();
}

include '../connection.php';
  
// Retrieve user information from the session
$client_id = $_SESSION['user_id'];
 
  

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
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Popcamz</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .edit-btn {
            position: absolute;
            right: 1rem;
            top: 1rem;
        }

        .hebrew-text {
            direction: rtl;
            text-align: right;
        }

        .map-container {
            height: 300px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content ">
            <!-- Navbar Start -->
            <?php include 'header.php'; ?>
            <!-- Navbar End -->


<div class="container mt-4 px-5 py-3 bg-dark text-light rounded">
    <h2 class="text-center">Edit Client Information</h2>
    <form action="update_client.php" method="POST">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">

        <div class="mb-3">
            <label class="form-label">Full Name (English)</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="client_name_en"
                value="<?php echo htmlspecialchars($client['client_name_en']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Full Name (Hebrew)</label>
            <input type="text" dir="rtl" class="form-control bg-secondary text-light border-light" name="client_name_he"
                value="<?php echo htmlspecialchars($client['client_name_he']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Club (English)</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="club_name_en"
                value="<?php echo htmlspecialchars($client['club_name_en']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Club (Hebrew)</label>
            <input type="text" dir="rtl" class="form-control bg-secondary text-light border-light" name="club_name_he"
                value="<?php echo htmlspecialchars($client['club_name_he']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">City (English)</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="location_en"
                value="<?php echo htmlspecialchars($client['location_en']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">City (Hebrew)</label>
            <input type="text" dir="rtl" class="form-control bg-secondary text-light border-light" name="location_he"
                value="<?php echo htmlspecialchars($client['location_he']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control bg-secondary text-light border-light" name="email"
                value="<?php echo htmlspecialchars($client['email']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="mobile"
                value="<?php echo htmlspecialchars($client['mobile']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Type of Entertainment (English)</label>
            <select class="form-control bg-secondary text-light border-light" name="entertainment_type_en">
                <option value="">Select type of entertainment</option>
                <option value="Club" <?php echo ($client['entertainment_type_en'] == "Club") ? 'selected' : ''; ?>>Club</option>
                <option value="Bar" <?php echo ($client['entertainment_type_en'] == "Bar") ? 'selected' : ''; ?>>Bar</option>
                <option value="Cafe" <?php echo ($client['entertainment_type_en'] == "Cafe") ? 'selected' : ''; ?>>Cafe</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Type of Entertainment (Hebrew)</label>
            <select class="form-control bg-secondary text-light border-light" name="entertainment_type_he" dir="rtl">
                <option value="">בחר סוג בידור</option>
                <option value="מועדונים" <?php echo ($client['entertainment_type_he'] == "מועדונים") ? 'selected' : ''; ?>>מועדונים</option>
                <option value="ברים" <?php echo ($client['entertainment_type_he'] == "ברים") ? 'selected' : ''; ?>>ברים</option>
                <option value="בתי קפה" <?php echo ($client['entertainment_type_he'] == "בתי קפה") ? 'selected' : ''; ?>>בתי קפה</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Bio (English)</label>
            <textarea class="form-control bg-secondary text-light border-light" name="bio_en" rows="4"><?php echo htmlspecialchars($client['bio_en']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Bio (Hebrew)</label>
            <textarea class="form-control bg-secondary text-light border-light" name="bio_he" rows="4" dir="rtl"><?php echo htmlspecialchars($client['bio_he']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Deal (English)</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="deal_en"
                value="<?php echo htmlspecialchars($client['deal_en']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Deal (Hebrew)</label>
            <input type="text" class="form-control bg-secondary text-light border-light" dir="rtl" name="deal_he"
                value="<?php echo htmlspecialchars($client['deal_he']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Latitude</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="latitude"
                value="<?php echo htmlspecialchars($client['latitude']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Longitude</label>
            <input type="text" class="form-control bg-secondary text-light border-light" name="longitude"
                value="<?php echo htmlspecialchars($client['longitude']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Opens From</label>
            <input type="time" class="form-control bg-secondary text-light border-light" name="opens_from"
                value="<?php echo htmlspecialchars($client['opens_from']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Opens Till</label>
            <input type="time" class="form-control bg-secondary text-light border-light" name="opens_till"
                value="<?php echo htmlspecialchars($client['opens_till']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Valid From</label>
            <input type="date" class="form-control bg-secondary text-light border-light" name="valid_from"
                value="<?php echo htmlspecialchars($client['from_date']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Valid To</label>
            <input type="date" class="form-control bg-secondary text-light border-light" name="valid_to"
                value="<?php echo htmlspecialchars($client['to_date']); ?>">
        </div>

       
        <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control bg-secondary text-light border-light" name="password" placeholder="Enter Password To Change">
</div>

 <div class="text-center">
            <button type="submit" class="btn btn-success">Update Client</button>
            <a href="view_client.php?client_id=<?php echo $client_id; ?>" class="btn btn-outline-light">Cancel</a>
        </div>
        
    </form>
</div>








        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>