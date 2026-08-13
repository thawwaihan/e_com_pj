<?php
$adminName = $_SESSION['user_name'] ?? 'Administrator';
$currentPage=basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar -->
    <aside class="sidebar">

        <div class="logo">

            <div class="logo-icon">
                <i class="fa-solid fa-layer-group"></i>
            </div>

            <div>
                <strong>Admin</strong>
                <small>CONTROL PANEL</small>
            </div>

        </div>

        <div class="menu-title">
            MAIN MENU
        </div>

        <nav class="menu">

            <a href="dashboard.php" class="<?= $currentPage=='dashboard.php'?'active':'' ?>">
                <span class="menu-icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="products.php" class="<?= $currentPage=='products.php'?'active':'' ?>">
                <span class="menu-icon">
                    <i class="fa-solid fa-box"></i>
                </span>
                <span>Products</span>
            </a>

            <a href="product-create.php" class="<?= $currentPage=='product-create.php'?'active':'' ?>">
                <span class="menu-icon">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span>Add Product</span>
            </a>
           <a href="../auth/logout.php">
                <span class="menu-icon">
                    <i class="fa-solid fa-logout"></i>
                </span>
                <span>Logout</span>
            </a>
        </nav>

        <div class="sidebar-bottom">

            <div class="admin-profile">

                <div class="avatar">
    <?= strtoupper(substr($adminName, 0, 1)) ?>
</div>

                <div>
                    <strong>
    <?= htmlspecialchars($adminName) ?>
</strong>

<small>Online</small>
                </div>

                <span class="online-dot"></span>

            </div>
            
            <div class="version">
                Manifest v1.0
            </div>

        </div>

    </aside>