<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png">
    <title>Popcamz</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<?php
include 'connection.php'; // Include the database connection

// Queries to get counts
$totalClientsQuery = "SELECT COUNT(*) AS total_clients FROM clients";
$barsQuery = "SELECT COUNT(*) AS total_bars FROM clients WHERE entertainment_type_en = 'bar'";
$clubsQuery = "SELECT COUNT(*) AS total_clubs FROM clients WHERE entertainment_type_en = 'club'";
$cafesQuery = "SELECT COUNT(*) AS total_cafes FROM clients WHERE entertainment_type_en = 'cafe'";

// Execute queries and fetch data
$totalClientsResult = $conn->query($totalClientsQuery)->fetch_assoc()['total_clients'];
$barsResult = $conn->query($barsQuery)->fetch_assoc()['total_bars'];
$clubsResult = $conn->query($clubsQuery)->fetch_assoc()['total_clubs'];
$cafesResult = $conn->query($cafesQuery)->fetch_assoc()['total_cafes'];

$conn->close();
?>

<body>
    <div class="wrapper">
        <?php include 'tabbing.php'; ?>
        <div class="main">
            <?php include 'header.php'; ?>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Admin Dashboard</h4>
                    </div>
                    <div class="row">
                        <!-- Total Clients -->
                        <div class="col-12 col-md-3 d-flex">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-3 d-flex flex-fill">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4>Total Clients</h4>
                                            <i class="fas fa-users fa-3x text-danger"></i>
                                        </div>
                                        <p class="mb-0">
                                            Number of Clients: <strong style="font-size: 1.5rem;">
                                                <?php echo $totalClientsResult; ?>
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Bars -->
                        <div class="col-12 col-md-3 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Total Bars</h4>
                                        <i class="fas fa-building fa-3x text-danger"></i>
                                    </div>
                                    <p class="mb-0">
                                        Number of Bars: <strong style="font-size: 1.5rem;">
                                            <?php echo $barsResult; ?>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Clubs -->
                        <div class="col-12 col-md-3 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Total Clubs</h4>
                                        <i class="fas fa-compact-disc fa-3x text-danger"></i>
                                    </div>
                                    <p class="mb-0">
                                        Number of Clubs: <strong style="font-size: 1.5rem;">
                                            <?php echo $clubsResult; ?>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Cafes -->
                        <div class="col-12 col-md-3 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Total Cafe's</h4>
                                        <i class="fas fa-beer fa-3x text-danger"></i>
                                    </div>
                                    <p class="mb-0">
                                        Number of Cafe's: <strong style="font-size: 1.5rem;">
                                            <?php echo $cafesResult; ?>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>Popcamz</strong>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>