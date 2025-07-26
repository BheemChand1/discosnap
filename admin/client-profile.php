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
    <div class="card bg-dark text-white">
<div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <h5 class="card-title mb-0 me-2">Client Profile</h5>
        <?php if (!empty($client['photos'])): ?>
            <?php 
            $photos = explode(',', $client['photos']);
            foreach ($photos as $photo) {
                $photo = trim($photo);
                if ($photo) {
                    $img_src = (strpos($photo, 'http://') === 0 || strpos($photo, 'https://') === 0) ? $photo : '../uploads/' . htmlspecialchars($photo);
                    echo '<img src="' . htmlspecialchars($img_src) . '" class="rounded border" style="max-height:40px; max-width:40px; margin-right:4px;">';
                }
            }
            ?>
        <?php endif; ?>
        <button class="btn btn-success btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addPhotoModal"><i class="fas fa-plus"></i> Add Photo</button>
    </div>
    <a href="edit_client.php?client_id=<?php echo $client_id; ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-edit"></i> Edit
    </a>
</div>

<!-- Modal for adding more photos -->
<div class="modal fade" id="addPhotoModal" tabindex="-1" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPhotoModalLabel">Add More Photos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="update_client.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
          <div class="mb-3">
            <label class="form-label">Select Photos</label>
            <input type="file" class="form-control" name="client_photos[]" multiple accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Upload</button>
        </div>
      </form>
    </div>
  </div>
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateThumbnailLabel">Update Thumbnail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <div class="card bg-dark-subtle mb-4">
            <div class="card-header">
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
        <div class="card bg-dark-subtle mb-4">
            <div class="card-header">
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

<!-- Google Map Section -->
                <div class="col-md-12">
                    <div class="card bg-dark-subtle">
                        <div class="card-header">
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