<?php

session_start();
require_once "../database/db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
// Admin information
$adminName = $_SESSION['user_name'] ?? 'Administrator';

// Total products
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$productCount = $stmt->fetchColumn();

// New arrivals
$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM products
    WHERE is_new = 1
");
$newProductCount = $stmt->fetchColumn();

// Best sellers
$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM products
    WHERE is_best_seller = 1
");
$bestSellerCount = $stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/css/admin-style.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <!-- Animated Background -->
    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Mobile Menu -->
    <button class="sidebar-toggle" aria-label="Toggle menu">
        <i class="fa-solid fa-bars"></i>
    </button>
    <?= require_once "aside.php" ?>
    <!-- Main Content -->
    <main class="main">

        <!-- Topbar -->
        <header class="topbar">

            <div class="welcome">

                <span class="eyebrow">
                    <span class="pulse"></span>
                    OVERVIEW
                </span>

                <h1>
                    Dashboard
                    <span class="wave">👋</span>
                </h1>

                <p>
                    Welcome back. Here's what's happening with your catalog.
                </p>

            </div>

            <div class="top-actions">

                <div class="date-box">
                    <i class="fa-regular fa-calendar"></i>

                    <span>
                        <?php echo date("F d, Y"); ?>
                    </span>
                </div>

                <div class="notification">
                    <i class="fa-regular fa-bell"></i>
                    <span></span>
                </div>

            </div>

        </header>


        <!-- Statistics -->
        <section class="stats-grid">

            <!-- Total -->
            <div class="stat-card blue">

                <div class="card-glow"></div>

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>

                    <span class="trend">
                        <i class="fa-solid fa-arrow-up"></i>
                        Catalog
                    </span>

                </div>

                <div class="stat-info">

                    <span class="label">
                        TOTAL PRODUCTS
                    </span>

                    <div
                        class="number counter"
                        data-count="<?php echo (int)$productCount; ?>">
                        0
                    </div>

                </div>

                <div class="progress">
                    <span></span>
                </div>

                <p class="stat-footer">
                    Products currently in your catalog
                </p>

            </div>


            <!-- New -->
            <div class="stat-card purple">

                <div class="card-glow"></div>

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-sparkles"></i>
                    </div>

                    <span class="trend">
                        <i class="fa-solid fa-star"></i>
                        New
                    </span>

                </div>

                <div class="stat-info">

                    <span class="label">
                        NEW ARRIVALS
                    </span>

                    <div
                        class="number counter"
                        data-count="<?php echo (int)$newProductCount; ?>">
                        0
                    </div>

                </div>

                <div class="progress">
                    <span></span>
                </div>

                <p class="stat-footer">
                    Recently added products
                </p>

            </div>


            <!-- Best Sellers -->
            <div class="stat-card orange">

                <div class="card-glow"></div>

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-fire"></i>
                    </div>

                    <span class="trend">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        Hot
                    </span>

                </div>

                <div class="stat-info">

                    <span class="label">
                        BEST SELLERS
                    </span>

                    <div
                        class="number counter"
                        data-count="<?php echo (int)$bestSellerCount; ?>">
                        0
                    </div>

                </div>

                <div class="progress">
                    <span></span>
                </div>

                <p class="stat-footer">
                    Top performing products
                </p>

            </div>

        </section>


        <!-- Bottom Grid -->
        <section class="dashboard-grid">


            <!-- Quick Actions -->
            <div class="panel quick-panel">

                <div class="panel-header">

                    <div>
                        <span class="panel-eyebrow">
                            ACTION CENTER
                        </span>

                        <h2>Quick Actions</h2>
                    </div>

                    <div class="panel-icon">
                        <i class="fa-solid fa-bolt"></i>
                    </div>

                </div>


                <div class="action-grid">

                    <a href="product-create.php" class="action-card add">

                        <div class="action-icon">
                            <i class="fa-solid fa-plus"></i>
                        </div>

                        <div>
                            <strong>Add Product</strong>
                            <span>Create a new catalog item</span>
                        </div>

                        <i class="fa-solid fa-arrow-right arrow"></i>

                    </a>


                    <a href="products.php" class="action-card manage">

                        <div class="action-icon">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>

                        <div>
                            <strong>Manage Products</strong>
                            <span>View and edit your catalog</span>
                        </div>

                        <i class="fa-solid fa-arrow-right arrow"></i>

                    </a>

                </div>

            </div>


            <!-- System Status -->
            <div class="panel status-panel">

                <div class="panel-header">

                    <div>
                        <span class="panel-eyebrow">
                            SYSTEM
                        </span>

                        <h2>Status</h2>
                    </div>

                    <div class="status-badge">
                        <span></span>
                        Healthy
                    </div>

                </div>


                <div class="status-list">

                    <div class="status-item">

                        <div class="status-left">

                            <div class="mini-icon green">
                                <i class="fa-solid fa-database"></i>
                            </div>

                            <div>
                                <strong>Database</strong>
                                <small>MySQL connection</small>
                            </div>

                        </div>

                        <span class="status-online">
                            Connected
                        </span>

                    </div>


                    <div class="status-item">

                        <div class="status-left">

                            <div class="mini-icon blue">
                                <i class="fa-solid fa-server"></i>
                            </div>

                            <div>
                                <strong>Server</strong>
                                <small>Application server</small>
                            </div>

                        </div>

                        <span class="status-online">
                            Online
                        </span>

                    </div>


                    <div class="status-item">

                        <div class="status-left">

                            <div class="mini-icon purple">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <div>
                                <strong>Security</strong>
                                <small>System protection</small>
                            </div>

                        </div>

                        <span class="status-online">
                            Active
                        </span>

                    </div>

                </div>

            </div>

        </section>


        <!-- Footer -->
        <footer>

            <span>
                © <?php echo date("Y"); ?> Admin Panel
            </span>

            <span>
                Built with PHP + MySQL
            </span>

        </footer>

    </main>


    <script src="../assets/js/admin-script.js"></script>

</body>

</html>