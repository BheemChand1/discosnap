<?php
include 'connection.php';
?>
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

<body>
    <div class="wrapper">
        <?php include 'tabbing.php'; ?>
        <div class="main">
            <?php include 'header.php'; ?>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                           <form id="clientForm">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="clientNameEn" class="form-label">Client Name (English)</label>
            <input type="text" class="form-control" id="clientNameEn" name="client_name_en" placeholder="Enter client name in English">
        </div>
        <div class="col-md-6">
            <label for="clientNameHe" class="form-label">Client Name (Hebrew)</label>
            <input type="text" class="form-control" id="clientNameHe" name="client_name_he" placeholder="הזן את שם הלקוח בעברית" dir="rtl">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" required>
        </div>
        <div class="col-md-6">
           
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
        </div>
        <div class="col-md-6">
            
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="clubNameEn" class="form-label">Club Name (English)</label>
            <input type="text" class="form-control" id="clubNameEn" name="club_name_en" placeholder="Enter club name in English">
        </div>
        <div class="col-md-6">
            <label for="clubNameHe" class="form-label">Club Name (Hebrew)</label>
            <input type="text" class="form-control" id="clubNameHe" name="club_name_he" placeholder="הזן את שם המועדון בעברית" dir="rtl">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="locationEn" class="form-label">City (English)</label>
            <input type="text" class="form-control" id="locationEn" name="location_en" placeholder="Enter city name in English">
        </div>
        <div class="col-md-6">
            <label for="locationHe" class="form-label">City (Hebrew)</label>
            <input type="text" class="form-control" id="locationHe" name="location_he" placeholder="הזן את שם העיר בעברית" dir="rtl">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="mapLink" class="form-label">Map Link</label>
            <input type="url" class="form-control" id="mapLink" name="map_link" placeholder="Enter Google Maps link" required>
        </div>
        <div class="col-md-6">
            
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
           <label for="url" class="form-label">RTSP LINK</label>
            <input type="url" class="form-control" id="url" name="url" placeholder="Enter URL" required>
        </div>
        <div class="col-md-6">
            
        </div>
    </div>

    <div class="row mb-3">
    <div class="col-md-6">
        <label for="latitude" class="form-label">Latitude</label>
        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude coordinates" required>
        <small class="text-muted">Example: 32.0615 (Use decimal format, no ° or N/S)</small>
    </div>
    <div class="col-md-6"></div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="longitude" class="form-label">Longitude</label>
        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter longitude coordinates" required>
        <small class="text-muted">Example: 34.7723 (Use decimal format, no ° or E/W)</small>
    </div>
    <div class="col-md-6"></div>
</div>


    
    
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="entertainmentTypeEn" class="form-label">Type of Entertainment (English)</label>
            <select class="form-control" id="entertainmentTypeEn" name="entertainment_type_en">
                <option value="">Select type of entertainment</option>
                <option value="Club">Club</option>
                <option value="Bar">Bar</option>
                <option value="Cafe">Cafe</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="entertainmentTypeHe" class="form-label">Type of Entertainment (Hebrew)</label>
            <select class="form-control" id="entertainmentTypeHe" name="entertainment_type_he" dir="rtl">
                <option value="">בחר סוג בידור</option>
                <option value="מועדונים">מועדונים</option>
<option value="ברים">ברים</option>
<option value="בתי קפה">בתי קפה</option>
n>
            </select>
        </div>
    </div>

    <div class="row mb-3">
       <div class="col-md-6 d-flex gap-3">
    <div class="flex-fill">
        <label for="fromDate" class="form-label">Valid From</label>
        <input type="date" class="form-control" id="fromDate" name="from_date" required>
    </div>
    <div class="flex-fill">
        <label for="toDate" class="form-label">Valid To</label>
        <input type="date" class="form-control" id="toDate" name="to_date" required>
    </div>
</div>

        <div class="col-md-6">
            
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="bioEn" class="form-label">Bio (English)</label>
            <textarea class="form-control" id="bioEn" name="bio_en" placeholder="Enter client bio in English" rows="3"></textarea>
        </div>
        <div class="col-md-6">
            <label for="bioHe" class="form-label">Bio (Hebrew)</label>
            <textarea class="form-control" id="bioHe" name="bio_he" placeholder="הזן ביוגרפיה של הלקוח בעברית" dir="rtl" rows="3"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="dealEn" class="form-label">Deal/Discount (English)</label>
            <input type="text" class="form-control" id="dealEn" name="deal_en" placeholder="Enter deal or discount details in English">
        </div>
        <div class="col-md-6">
            <label for="dealHe" class="form-label">Deal/Discount (Hebrew)</label>
            <input type="text" class="form-control" id="dealHe" name="deal_he" placeholder="הזן פרטי מבצע או הנחה בעברית" dir="rtl">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="password" class="form-label">Create Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter admin password" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Create Client</button>
        </div>
    </div>
</form>




                            <!-- Modal -->
                            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="successModalLabel">Success</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Client information has been successfully submitted.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                                id="okayButton">Okay</button>
                                        </div>
                                    </div>
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
                                    <strong>POPCAMZ</strong>
                                </a>
                            </p>
                        </div>
                        <!--<div class="col-6 text-end">-->
                        <!--    <ul class="list-inline">-->
                        <!--        <li class="list-inline-item">-->
                        <!--            <a href="#" class="text-muted">Contact</a>-->
                        <!--        </li>-->
                        <!--        <li class="list-inline-item">-->
                        <!--            <a href="#" class="text-muted">About Us</a>-->
                        <!--        </li>-->
                        <!--        <li class="list-inline-item">-->
                        <!--            <a href="#" class="text-muted">Terms</a>-->
                        <!--        </li>-->
                        <!--        <li class="list-inline-item">-->
                        <!--            <a href="#" class="text-muted">Booking</a>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
   $(document).ready(function () {
    $('#clientForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        let isValid = true;

        // Function to check if at least one field in a pair is filled
        function validatePair(field1, field2) {
            const val1 = $(`#${field1}`).val().trim();
            const val2 = $(`#${field2}`).val().trim();
            if (val1 === "" && val2 === "") {
                isValid = false;
                $(`#${field1}, #${field2}`).addClass('is-invalid'); // Add red border
            } else {
                $(`#${field1}, #${field2}`).removeClass('is-invalid'); // Remove red border
            }
        }

        // Validate all required pairs
        validatePair('clientNameEn', 'clientNameHe');
        validatePair('clubNameEn', 'clubNameHe');
        validatePair('locationEn', 'locationHe');
        validatePair('entertainmentTypeEn', 'entertainmentTypeHe');
        validatePair('bioEn', 'bioHe');
        validatePair('dealEn', 'dealHe');

        if (!isValid) {
            alert("Please fill at least one field from each required pair.");
            return;
        }

        // Collect form data
        const formData = $(this).serialize();

        // Submit form via AJAX if validation passes
        $.ajax({
            url: 'submit_client.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.trim() === "Success") {
                    $('#successModal').modal('show');
                } else {
                    alert('Error: ' + response);
                }
            },
            error: function () {
                alert('An error occurred while submitting the form.');
            }
        });
    });

    // Reset form when modal is closed
    $('#okayButton').on('click', function () {
        $('#clientForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid'); // Remove validation errors
    });
});

</script>







</body>

</html>