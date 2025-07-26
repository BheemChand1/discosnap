<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><img src="../img/pop_logo.png" alt="POPCAMZ Logo"
                    style="height: 50px; margin-right: 10px;">Popcamz</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/defalut-user-photo.jpg" alt="" style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0"><?php echo $client_name; ?></h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

            <a href="profile.php" class="nav-item nav-link"><i class="fa fa-user-circle me-2"
                    style="font-size: 24px; color: #007bff;" title="Update Profile"></i>
                </i>
                </i>Profile</a>

            <a href="edit_client.php" class="nav-item nav-link"><i class="fa fa-sync me-2"
                    style="font-size: 20px; color: #007bff;"></i>
                </i>
                </i>Update Profile</a>

            <a href="camera-switch.php" class="nav-item nav-link"><i class="fa fa-toggle-off me-2"
                    style="font-size: 20px; color: #007bff;"></i>
                </i>
                </i>Camera Switch</a>

            <a href="update-offers.php" class="nav-item nav-link">
                <i class="fa fa-gift me-2" style="font-size: 20px; color: #007bff;"></i>
                Update Offers
            </a>


        </div>
    </nav>
</div>