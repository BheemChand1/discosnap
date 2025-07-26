<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../logout.php"); // Redirect to login page if not logged in
    exit();
}

include '../connection.php';
// Retrieve user information from the session
$user_id = $_SESSION['user_id'];
// Prepare the SQL query
$sql = "SELECT client_name_en, mobile, email FROM clients WHERE id = '$user_id'";
// Execute the query
$result = $conn->query($sql);
// Fetch the result
$client = $result->fetch_assoc();

// Assign data to variables
$client_name = $client['client_name_en'];
$mobile = $client['mobile'];
$email = $client['email'];

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
        <div class="content">
            <!-- Navbar Start -->
            <?php include 'header.php'; ?>
            <!-- Navbar End -->






            <?php
                       
            // Check if the form is submitted to update the offer
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['client_id'])) {
                $client_id = $_POST['client_id'];
                $new_deal_en = $_POST['deal_en'];
                $new_deal_he = $_POST['deal_he'];

                // Update the deal in the database
                $sql = "UPDATE clients SET deal_en = ?, deal_he = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $new_deal_en, $new_deal_he, $client_id);

                if ($stmt->execute()) {
                    // Success message
                    $message = "Offer updated successfully!";
                } else {
                    // Error message
                    $message = "Error updating offer: " . $conn->error;
                }
            }

            // Fetch client data from the clients table
            $sql = "SELECT id, client_name_en, client_name_he, deal_en, deal_he FROM clients WHERE id = $user_id";
            $result = $conn->query($sql);
            ?>

            <div class="container-fluid pt-4 px-4 bg-dark text-white min-vh-100">
                <?php if (isset($message)): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="row g-4 justify-content-center">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-6">
                            <div class="card bg-secondary border-light shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo htmlspecialchars($row['client_name_en']) . " / " . htmlspecialchars($row['client_name_he']); ?>
                                    </h5>
                                    <p class="card-text">
                                        Offer (EN): <?php echo htmlspecialchars($row['deal_en']); ?>
                                    </p>
                                    <p class="card-text">
                                        Offer (HE): <?php echo htmlspecialchars($row['deal_he']); ?>
                                    </p>
                                    <form action="" method="post">
                                        <input type="hidden" name="client_id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group">
                                            <label for="deal_en">Update Offer (EN)</label>
                                            <input type="text" class="form-control" id="deal_en" name="deal_en"
                                                value="<?php echo htmlspecialchars($row['deal_en']); ?>" required>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="deal_he">Update Offer (HE)</label>
                                            <input type="text" dir='rtl' class="form-control" id="deal_he" name="deal_he"
                                                value="<?php echo htmlspecialchars($row['deal_he']); ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
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