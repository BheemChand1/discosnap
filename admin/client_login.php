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

        /* DataTable pagination and search bar styling */
        .dataTables_wrapper .dataTables_filter input {
            background-color: #222;
            /* Search input background */
            color: #fff;
            /* Search input text color */
            border: 1px solid #555;
            /* Search input border */
        }

        .dataTables_wrapper .dataTables_length select {
            background-color: #222;
            /* Dropdown background */
            color: #fff;
            /* Dropdown text color */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #333;
            /* Pagination button background */
            color: #fff !important;
            /* Pagination button text */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #555;
            /* Pagination hover background */
            color: #fff !important;
            /* Pagination hover text */
        }

        /* Styling the info and pagination text */
        .dataTables_wrapper .dataTables_info {
            color: #aaa;
            /* Text color for info and pagination */
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
                        // Fetch data from the clients table
                        $query = "SELECT id, client_name, club_name, email, mobile, password, status FROM clients";
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
                                                <th>Name</th>
                                                <th>Club Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result->num_rows > 0): ?>
                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['club_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                        <td>
                                                            <form method="POST" action="login_as_client.php" target="_blank"
                                                                style="display:inline;">
                                                                <input type="hidden" name="id"
                                                                    value="<?php echo htmlspecialchars($row['id']); ?>">
                                                                <button type="submit" class="btn btn-primary">Login</button>
                                                            </form>


                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No clients found.</td>
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