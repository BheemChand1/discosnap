<?php
include 'connection.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $error = "";

    // Check in both admin and client tables
    $sql = "SELECT id, username, password, 'admin' AS user_type FROM admin WHERE username = ?
            UNION
            SELECT id, email AS username, password, 'client' AS user_type FROM clients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];

            // Redirect based on user type
            if ($user['user_type'] == 'admin') {
                header("Location: ./admin/index.php");
            } else {
                header("Location: ./client/index.php");
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Incorrect username.";
    }
 if (!empty($error)) {
        // Display or handle the error (e.g., pass it back to the form)
        echo $error;
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="icon" type="image/png" href="../img/favicon-32x32.png">
    <title>Popcamz</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./client/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="./client/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./client/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./client/css/style.css" rel="stylesheet">

    <style>
        body {
            background: url('./img/popcamz-background.webp') no-repeat center center fixed;
            background-size: cover;
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


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="d-flex align-items-center">
                                <img src="./img/pop_logo.png" alt="POPCAMZ Logo"
                                    style="height: 50px; margin-right: 10px;">
                                <h6 class="text-primary m-0">POPCAMZ</h6>
                            </a>
                            <h4>Sign In</h4>
                        </div>
                     
                        <form method="POST" action="">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="username"
                                    placeholder="name@example.com" required>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="password"
                                    placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>

                            <?php if (isset($error)): ?>
                                <div class="text-danger mb-3"> <?php echo $error; ?> </div>
                            <?php endif; ?>

                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./client/lib/chart/chart.min.js"></script>
    <script src="./client/lib/easing/easing.min.js"></script>
    <script src="./client/lib/waypoints/waypoints.min.js"></script>
    <script src="./client/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="./client/lib/tempusdominus/js/moment.min.js"></script>
    <script src="./client/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="./client/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="./client/js/main.js"></script>
</body>

</html>