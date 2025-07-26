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
            $sql = "SELECT client_name_en, client_name_he, club_name_en, club_name_he, mobile, camera_status, email FROM clients WHERE id = '$user_id'";
            // Execute the query
            $result = $conn->query($sql);
            // Fetch the result
            $client = $result->fetch_assoc();

            // Assign data to variables
            $client_name_en = $client['client_name_en'];
            $client_name_he = $client['client_name_he'];
            $club_name_en = $client['club_name_en'];
            $club_name_he = $client['club_name_he'];
            $mobile = $client['mobile'];
            $email = $client['email'];
            $cameraStatus = $client['camera_status'] == 1 ? 'Active' : 'Off';

$conn->close();

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


            <!-- USER Information -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- User Information Box -->
                    <!-- User Information Box -->
<div class="col-md-6">
    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-between p-4 h-100">
        <i class="fa fa-user fa-3x text-primary"></i>
        <div class="ms-3">
            <h6 class="mb-1">
                <span class="d-block">Club Name (English): 
                    <a href="profile.php" class="text-white text-decoration-none">
                        <?php echo htmlspecialchars($club_name_en); ?>
                    </a>
                </span>
                <span class="d-block text-end">שם מועדון (עברית): 
                    <a href="profile.php" class="text-white text-decoration-none">
                        <?php echo htmlspecialchars($club_name_he); ?>
                    </a>
                </span>
            </h6>
            <h6 class="mb-1">
                <span class="d-block">Email: 
                    <a href="mailto:<?php echo htmlspecialchars($email); ?>" class="text-white text-decoration-none">
                        <?php echo htmlspecialchars($email); ?>
                    </a>
                </span>
            </h6>
            <h6 class="mb-1">
                <span class="d-block">Phone: 
                    <a href="tel:<?php echo htmlspecialchars($mobile); ?>" class="text-white text-decoration-none">
                        <?php echo htmlspecialchars($mobile); ?>
                    </a>
                </span>
            </h6>
            <h6 class="mb-0">
                <span class="d-block">Camera Status: <?php echo htmlspecialchars($cameraStatus); ?></span>
            </h6>
        </div>
    </div>
</div>


                    <!-- Camera Status Box -->
                    <div class="col-md-6">
                        <div
                            class="bg-secondary text-white rounded d-flex align-items-center justify-content-between p-4 h-100">
                            <i class="fa fa-video fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Camera Status</p>
                                <h6 class="mb-0"><a href="camera-switch.php"
                                        class="text-white text-decoration-none"><?php echo htmlspecialchars($cameraStatus); ?></a>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USER Information End -->



            <!-- Widgets Start -->
            <!-- <div class="container-fluid pt-4 px-4">
                <div class="row g-4">

                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <iframe class="position-relative rounded w-100 h-100"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                                frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"
                                style="filter: grayscale(100%) invert(92%) contrast(83%); border: 0;"></iframe>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Widgets End -->



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