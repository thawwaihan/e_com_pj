<?php

require_once "../db.php";

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

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f2ec;
            color: #16181c;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #16181c;
            color: white;
            padding: 30px 20px;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .menu a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 14px 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .menu a:hover {
            background: #b8792e;
            color: white;
        }

        .main {
            margin-left: 240px;
            padding: 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .topbar h1 {
            font-size: 32px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border: 1px solid #ddd;
        }

        .card h3 {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .card .number {
            font-size: 35px;
            font-weight: bold;
        }

        .quick-actions {
            margin-top: 40px;
        }

        .quick-actions h2 {
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 15px;
        }

        .action {
            background: #16181c;
            color: white;
            text-decoration: none;
            padding: 15px 25px;
        }

        .action:hover {
            background: #b8792e;
        }

        @media (max-width: 800px) {

            .sidebar {
                width: 180px;
            }

            .main {
                margin-left: 180px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>

    <aside class="sidebar">

        <div class="logo">
            ADMIN
        </div>

        <nav class="menu">

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="products.php">
                Products
            </a>

            <a href="product-create.php">
                Add Product
            </a>

        </nav>

    </aside>


    <main class="main">

        <div class="topbar">

            <h1>Dashboard</h1>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Total Products</h3>

                <div class="number">
                    <?php echo $productCount; ?>
                </div>

            </div>


            <div class="card">

                <h3>New Arrivals</h3>

                <div class="number">
                    <?php echo $newProductCount; ?>
                </div>

            </div>


            <div class="card">

                <h3>Best Sellers</h3>

                <div class="number">
                    <?php echo $bestSellerCount; ?>
                </div>

            </div>

        </div>


        <section class="quick-actions">

            <h2>Quick Actions</h2>

            <div class="actions">

                <a href="product-create.php" class="action">
                    + Add Product
                </a>

                <a href="products.php" class="action">
                    Manage Products
                </a>

            </div>

        </section>

    </main>

</body>

</html>