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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <style>
        /* General DataTable background and text color */
        #clientTable_wrapper {
            color: #fff;
            /* Text color for DataTable */
        }

        #clientTable {
            background-color: #333;
            /* Table background */
            color: #fff;
            /* Text color */
            border-color: #444;
            /* Table border color */
        }

        #clientTable thead {
            background-color: #444;
            /* Header background */
            color: #fff;
            /* Header text color */
        }

        #clientTable tbody tr {
            background-color: #333;
            /* Row background */
            border-bottom: 1px solid #555;
            /* Row border */
        }

        #clientTable tbody tr:hover {
            background-color: #555;
            /* Row hover background */
        }

       
    </style>
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
    <?php
    // Handle Activate/Deactivate action
    if (isset($_GET['id']) && isset($_GET['status'])) {
        $id = intval($_GET['id']);
        $status = intval($_GET['status']);

        // Update the client's status
        $query = "UPDATE clients SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ii", $status, $id);
            $stmt->execute();

            // Check if the update was successful
            $message = ($stmt->affected_rows > 0) ? "Status updated successfully." : "Failed to update status.";
            $stmt->close();
        } else {
            $message = "Failed to prepare the statement.";
        }
    }

    // Fetch data from the clients table
    $query = "SELECT id, client_name_en, client_name_he, email, mobile, status FROM clients";
    $result = $conn->query($query);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <?php if (isset($message)): ?>
                    <div class="alert alert-info">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <table class="table table-bordered" id="clientTable">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Name (EN)</th>
                            <th>Name (HE)</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result->num_rows > 0): 
                            $srNo = 1;
                            while ($row = $result->fetch_assoc()): 
                        ?>
                            <tr>
                                <td><?php echo $srNo++; ?></td>
                                <td><?php echo !empty($row['client_name_en']) ? htmlspecialchars($row['client_name_en']) : 'Not mentioned'; ?></td>
                                <td dir="rtl"><?php echo !empty($row['client_name_he']) ? htmlspecialchars($row['client_name_he']) : 'לא צוין'; ?></td>
                                <td><?php echo !empty($row['email']) ? htmlspecialchars($row['email']) : 'Not mentioned'; ?></td>
                                <td><?php echo !empty($row['mobile']) ? htmlspecialchars($row['mobile']) : 'Not mentioned'; ?></td>
                                <td>
                                    <?php echo ($row['status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 1): ?>
                                        <a href="?id=<?php echo $row['id']; ?>&status=0" class="btn btn-danger btn-sm">Deactivate</a>
                                    <?php else: ?>
                                        <a href="?id=<?php echo $row['id']; ?>&status=1" class="btn btn-success btn-sm">Activate</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No clients found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
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

    <script>
        $(document).ready(function () {
            $('#clientTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                responsive: true,
                dom: 'Bfrtip'
            });
        });
    </script>

</body>

</html>