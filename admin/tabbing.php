<aside id="sidebar" class="js-sidebar">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo">
            <h3 class=""><a href="index.php"><img src="../img/pop_logo.png" alt="POPCAMZ Logo"
                        style="height: 50px; margin-right: 10px;"> </a><a href="index.php">Popcamz</a></h3>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Admin Options
            </li>
            <li class="sidebar-item">
                <a href="index.php" class="sidebar-link">
                    <i class="fa-solid fa-list pe-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-users"></i>
                    Clients
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">

                        <a href="createclient.php" class="sidebar-link"><i class="fa-solid fa-user-plus"></i>&emsp14;
                            Create
                            Clients</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="client_list.php" class="sidebar-link"> <i class="fa-solid fa-address-book"></i>&emsp14;
                            Clients List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="client_status.php" class="sidebar-link"> <i
                                class="fa-solid fa-address-book"></i>&emsp14;
                            Clients Status</a>
                    </li>
                    <!--<li class="sidebar-item">-->
                    <!--    <a href="client_login.php" class="sidebar-link"> <i-->
                    <!--            class="fa-solid fa-address-book"></i>&emsp14;-->
                    <!--        Clients Login</a>-->
                    <!--</li>-->
                </ul>
            </li>
        </ul>
    </div>
</aside>