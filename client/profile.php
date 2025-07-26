<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../logout.php");
    exit();
}

include '../connection.php';
$user_id = $_SESSION['user_id'];

// Handle photo deletion before any HTML output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_photo'], $_POST['photo'], $_POST['client_id'])) {
    $client_id = intval($_POST['client_id']);
    $photo_to_delete = trim($_POST['photo']);
    // Fetch current photos
    $sql = "SELECT photos FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $photos = '';
    if ($row = $result->fetch_assoc()) {
        $photos = $row['photos'];
    }
    $stmt->close();
    $photos_arr = array_filter(array_map('trim', explode(',', $photos)));
    // Remove the photo
    $new_photos = [];
    foreach ($photos_arr as $p) {
        if ($p !== $photo_to_delete) {
            $new_photos[] = $p;
        } else {
            // Try to delete the file if it's a local file
            if (strpos($p, 'http://') !== 0 && strpos($p, 'https://') !== 0) {
                $file_path = realpath(__DIR__ . '/../uploads/' . $p);
                if ($file_path && file_exists($file_path)) {
                    @unlink($file_path);
                }
            }
        }
    }
    $photos_str = implode(',', $new_photos);
    // Update DB
    $sql = "UPDATE clients SET photos = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $photos_str, $client_id);
    $stmt->execute();
    $stmt->close();
    // Redirect to self
    header("Location: profile.php");
    exit();
}

// Retrieve user information from the session
$sql = "SELECT client_name_en, mobile, email FROM clients WHERE id = '$user_id'";
$result = $conn->query($sql);
$client = $result->fetch_assoc();
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
        <div class="content">
            <!-- Navbar Start -->
            <?php include 'header.php'; ?>
            <!-- Navbar End -->


            <div class="container-fluid">
                    <div class="row">
                        
                        <?php
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch client data

$sql = "SELECT * FROM clients WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
} else {
    die("Client not found.");
}
?>

<div class="col-md-12">
    <div class="card bg-dark text-white">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Client Profile</h5>
            <a href="edit_client.php" class="btn btn-primary btn-sm">
    <i class="fas fa-edit"></i> Edit
</a>
        </div>
        <div class="card-body">
            <div class="row">
    <!-- Profile Header -->
    <div class="col-md-12 mb-4 text-center">
    <img src="<?php echo !empty($client['club_thumbnail']) ? htmlspecialchars($client['club_thumbnail']) : 'https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/person-circle.svg'; ?>" 
         class="mb-3" 
         alt="Profile Picture" 
         width="80" id="thumbnailPreview">
         <br>
         <!-- Update Thumbnail Button -->
    <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#updateThumbnailModal">Update Thumbnail</button>

    <h3 class="client-name">
        <?php echo htmlspecialchars($client['client_name_en'] ?? 'Not mentioned'); ?> / 
        <?php echo htmlspecialchars($client['client_name_he'] ?? 'Not mentioned'); ?>
    </h3>
</div>

<!-- Modal -->
<div class="modal fade" id="updateThumbnailModal" tabindex="-1" aria-labelledby="updateThumbnailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="updateThumbnailLabel">Update Thumbnail</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="thumbnailForm" action="upload_thumbnail.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($client['id']); ?>">
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Choose a new thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('thumbnail').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('thumbnailPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>


    <!-- Personal Information Section -->
    <div class="col-md-6">
        <div class="card bg-dark text-white mb-4">
            <div class="card-header bg-secondary text-white">
                <h5><i class="fas fa-user me-2"></i> Personal Information (English)</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush bg-dark">
                    <li class="list-group-item bg-dark text-white"><strong>Full Name:</strong> <?php echo htmlspecialchars($client['client_name_en'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Email:</strong> <?php echo htmlspecialchars($client['email'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Phone:</strong> <?php echo htmlspecialchars($client['mobile'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Club:</strong> <?php echo htmlspecialchars($client['club_name_en'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Location:</strong> <?php echo htmlspecialchars($client['location_en'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Bio:</strong> <?php echo htmlspecialchars($client['bio_en'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Deal:</strong> <?php echo htmlspecialchars($client['deal_en'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Entertainment Type:</strong> <?php echo htmlspecialchars($client['entertainment_type_en'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Latitude:</strong> <?php echo htmlspecialchars($client['latitude'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Longitude:</strong> <?php echo htmlspecialchars($client['longitude'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Valid From:</strong> <?php echo htmlspecialchars($client['from_date'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Valid To:</strong> <?php echo htmlspecialchars($client['to_date'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Open's From:</strong> <?php echo htmlspecialchars($client['opens_from'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>Open's Till:</strong> <?php echo htmlspecialchars($client['opens_till'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>RTSP LINK:</strong> <?php echo htmlspecialchars($client['url'] ?? 'Not mentioned'); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 text-end" dir="rtl">
        <div class="card bg-dark text-white mb-4">
            <div class="card-header bg-secondary text-white">
                <h5><i class="fas fa-user me-2"></i> מידע אישי (Hebrew)</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush bg-dark">
                    <li class="list-group-item bg-dark text-white"><strong>שם מלא:</strong> <?php echo htmlspecialchars($client['client_name_he'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>אימייל:</strong> <?php echo htmlspecialchars($client['email'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>טלפון:</strong> <?php echo htmlspecialchars($client['mobile'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>מועדון:</strong> <?php echo htmlspecialchars($client['club_name_he'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>מיקום:</strong> <?php echo htmlspecialchars($client['location_he'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>אודות:</strong> <?php echo htmlspecialchars($client['bio_he'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>מבצע:</strong> <?php echo htmlspecialchars($client['deal_he'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white">
    <strong>סוג בידור:</strong> 
    <?php echo htmlspecialchars($client['entertainment_type_he'] ?? 'Not mentioned'); ?>
</li>

                    <li class="list-group-item bg-dark text-white"><strong>קו רוחב:</strong> <?php echo htmlspecialchars($client['latitude'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>קו אורך:</strong> <?php echo htmlspecialchars($client['longitude'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>תקף מ:</strong> <?php echo htmlspecialchars($client['from_date'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>תקף עד:</strong> <?php echo htmlspecialchars($client['to_date'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>פתוח מ:</strong> <?php echo htmlspecialchars($client['opens_from'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>פתוח עד:</strong> <?php echo htmlspecialchars($client['opens_till'] ?? 'Not mentioned'); ?></li>
                    <li class="list-group-item bg-dark text-white"><strong>קישור RTSP:</strong> <?php echo htmlspecialchars($client['url'] ?? 'Not mentioned'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Photos Section -->
<div class="col-md-12 mb-4">
    <div class="card bg-dark text-white">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-images me-2"></i>Photos</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPhotosModal"><i class="fas fa-plus"></i> Add Photos</button>
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                $photos = [];
                if (!empty($client['photos'])) {
                    $photos = array_filter(array_map('trim', explode(',', $client['photos'])));
                }
                foreach ($photos as $photo) {
                    $img_src = (strpos($photo, 'http://') === 0 || strpos($photo, 'https://') === 0) ? $photo : '../uploads/' . htmlspecialchars($photo);
                ?>
                <div class="col-6 col-md-3 mb-3 d-flex flex-column align-items-center justify-content-center position-relative">
                    <img src="<?php echo htmlspecialchars($img_src); ?>" class="img-fluid rounded border mb-2" style="max-height:120px; max-width:100%;">
                    <form method="POST" action="profile.php" onsubmit="return confirm('Are you sure you want to delete this photo?');" style="display:inline;">
                        <input type="hidden" name="delete_photo" value="1">
                        <input type="hidden" name="photo" value="<?php echo htmlspecialchars($photo); ?>">
                        <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($client['id']); ?>">
                        <button type="submit" class="btn btn-danger btn-sm position-absolute" style="top:5px; right:10px; border-radius:50%;"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Photos Modal -->
<div class="modal fade" id="addPhotosModal" tabindex="-1" aria-labelledby="addPhotosModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="addPhotosModalLabel">Add Photos</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../admin/upload_client_photos.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($client['id']); ?>">
          <div class="mb-3">
            <label for="client_photos" class="form-label">Select Photos</label>
            <input type="file" class="form-control" id="client_photos" name="client_photos[]" multiple accept="image/*" required>
          </div>
          <button type="submit" class="btn btn-success">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>
                <div class="col-md-12">
    <div class="card bg-dark text-white">
        <div class="card-header bg-secondary text-white">
            <h5><i class="fas fa-map-marker-alt me-2"></i> Location</h5>
        </div>
        <div class="card-body">
            <iframe width="100%" height="300" frameborder="0" 
                src="https://www.google.com/maps?q=<?php echo htmlspecialchars($client['latitude']); ?>,<?php echo htmlspecialchars($client['longitude']); ?>&output=embed">
            </iframe>
        </div>
    </div>
</div>


        </div>
    </div>
</div>


<?php $conn->close(); ?>

                    </div>
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