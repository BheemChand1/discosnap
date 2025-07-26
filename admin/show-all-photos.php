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
    <div class="wrapper">
        <?php include 'tabbing.php'; ?>
        <div class="main">
            <?php include 'header.php'; ?>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="row">
                        
                        <?php
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch client data
$client_id = $_GET['client_id']; // Replace with dynamic client ID if needed
$sql = "SELECT * FROM clients WHERE id = $client_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
} else {
    die("Client not found.");
}
?>

<div class="col-md-12">
    <h3 class="mb-4">All Client Photos</h3>
    <div class="row">
        <?php
        if (!empty($client['photos'])) {
            $photos = explode(',', $client['photos']);
            foreach ($photos as $photo) {
                $photo = trim($photo);
                if ($photo) {
                    $img_src = (strpos($photo, 'http://') === 0 || strpos($photo, 'https://') === 0) ? $photo : '../uploads/' . htmlspecialchars($photo);
                    echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 position-relative d-flex align-items-center justify-content-center">';
                    echo '<img src="' . htmlspecialchars($img_src) . '" class="img-fluid rounded border" style="max-height:120px; max-width:100%;">';
                    echo '<form method="POST" action="show-all-photos.php?client_id=' . $client_id . '" onsubmit="return confirm(\'Are you sure you want to delete this photo?\');" class="position-absolute" style="top:2px; right:2px; z-index:2;">';
                    echo '<input type="hidden" name="delete_photo" value="' . htmlspecialchars($photo) . '">';
                    echo '<button type="submit" class="btn btn-danger btn-sm" style="border-radius:50%; padding:0.3rem 0.5rem;" title="Delete"><i class="fas fa-trash"></i></button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
        } else {
            echo '<div class="col-12 text-center text-muted">No photos uploaded.</div>';
        }
        ?>
    </div>
</div>



<?php $conn->close(); ?>

                    </div>
                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>Disco Snap</strong>
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