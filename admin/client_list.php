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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <style>
        /* Custom styling for DataTables in dark theme */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: #666 !important;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: #333 !important;
            color: #fff !important;
            border: 1px solid #666 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #666 !important;
            color: #fff !important;
            border-color: #666 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #444 !important;
            color: #fff !important;
            border-color: #666 !important;
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
                        <div class="row">
                            <div class="col-md-12">
                                <!--add here-->
                                <div class="card bg-dark text-white">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Client Information</h5>
                                    </div>
                                    <div class="card-body">
                                       <?php
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch clients data
$sql = "SELECT id, client_name_en, client_name_he, mobile, email, club_name_en, club_name_he FROM clients";
$result = $conn->query($sql);
?>

<table id="clientTable" class="table table-dark table-hover">
    <thead>
        <tr>
            <th>Client Name (EN)</th>
            <th>Client Name (HE)</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Club (EN)</th>
            <th>Club (HE)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check if values are null or empty
                $client_name_en = !empty($row['client_name_en']) ? $row['client_name_en'] : "Not Present";
                $client_name_he = !empty($row['client_name_he']) ? $row['client_name_he'] : "Not Present";
                $club_name_en = !empty($row['club_name_en']) ? $row['club_name_en'] : "Not Present";
                $club_name_he = !empty($row['club_name_he']) ? $row['club_name_he'] : "Not Present";

                echo "<tr>
                    <td>{$client_name_en}</td>
                    <td>{$client_name_he}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['mobile']}</td>
                    <td>{$club_name_en}</td>
                    <td>{$club_name_he}</td>
                    <td>
                        <a href='client-profile.php?client_id={$row['id']}' class='btn btn-info btn-sm' data-bs-toggle='tooltip' title='View More'>
                            <i class='fas fa-eye'></i>
                        </a>
                        <button class='btn btn-danger btn-sm' data-bs-toggle='tooltip' title='Delete' onclick='deleteClient(\"{$row['id']}\")'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>No clients found</td></tr>";
        }
        ?>
    </tbody>
</table>

<script>
function deleteClient(id) {
    if (confirm("Are you sure you want to delete this client?")) {
        window.location.href = "delete_client.php?id=" + id;
    }
}
</script>

<?php
$conn->close();
?>


                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $('#clientTable').DataTable({
                                            "theme": "dark",
                                            "pageLength": 10,
                                            "order": [[0, "asc"]],
                                            "language": {
                                                "search": "Search clients:",
                                                "lengthMenu": "Show _MENU_ entries",
                                                "info": "Showing _START_ to _END_ of _TOTAL_ clients"
                                            }
                                        });

                                        // Initialize tooltips
                                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                            return new bootstrap.Tooltip(tooltipTriggerEl)
                                        });
                                    });
                                </script>
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
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>


</body>

</html>