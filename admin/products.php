<?php
session_start();
require_once "../database/db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$sql = "SELECT * FROM products ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalProducts = count($products);

$newProducts = 0;
$bestSellers = 0;

foreach ($products as $product) {

    if ((int)$product['is_new'] === 1) {
        $newProducts++;
    }

    if ((int)$product['is_best_seller'] === 1) {
        $bestSellers++;
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Products | Admin</title>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <!-- Main Admin CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/admin-style.css"
    >


    <!-- Product Page CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/products.css"
    >

</head>


<body>


<!-- =================================
     ANIMATED BACKGROUND
================================= -->

<div class="background">

    <span></span>
    <span></span>
    <span></span>
    <span></span>

</div>



<!-- =================================
     MOBILE SIDEBAR BUTTON
================================= -->

<button
    class="sidebar-toggle"
    aria-label="Toggle menu"
>

    <i class="fa-solid fa-bars"></i>

</button>



<!-- =================================
     SIDEBAR
================================= -->

<aside class="sidebar">


    <div class="logo">

        <div class="logo-icon">

            <i class="fa-solid fa-layer-group"></i>

        </div>


        <div>

            <strong>
                Admin
            </strong>

            <small>
                CONTROL PANEL
            </small>

        </div>

    </div>



    <div class="menu-title">
        MAIN MENU
    </div>



    <nav class="menu">


        <a href="dashboard.php">

            <span class="menu-icon">

                <i class="fa-solid fa-chart-pie"></i>

            </span>

            <span>
                Dashboard
            </span>

        </a>



        <a
            href="products.php"
            class="active"
        >

            <span class="menu-icon">

                <i class="fa-solid fa-box"></i>

            </span>

            <span>
                Products
            </span>

        </a>



        <a href="product-create.php">

            <span class="menu-icon">

                <i class="fa-solid fa-plus"></i>

            </span>

            <span>
                Add Product
            </span>

        </a>


    </nav>



    <div class="sidebar-bottom">


        <div class="admin-profile">

            <div class="avatar">
                A
            </div>


            <div>

                <strong>
                    Administrator
                </strong>

                <small>
                    Online
                </small>

            </div>


            <span class="online-dot"></span>

        </div>


        <div class="version">
            Manifest v1.0
        </div>


    </div>

</aside>



<!-- =================================
     MAIN
================================= -->

<main class="main">


    <!-- =================================
         TOP HEADER
    ================================= -->

    <header class="topbar">


        <div class="page-title">


            <span class="eyebrow">

                <span class="pulse"></span>

                CATALOG MANAGEMENT

            </span>


            <h1>

                Products

                <span class="title-icon">

                    <i class="fa-solid fa-boxes-stacked"></i>

                </span>

            </h1>


            <p>
                Manage every item currently available
                in your catalog.
            </p>


        </div>



        <div class="top-actions">


            <div class="catalog-status">

                <span></span>

                CATALOG LIVE

            </div>


            <a
                href="product-create.php"
                class="add-product-btn"
            >

                <i class="fa-solid fa-plus"></i>

                Add Product

            </a>

        </div>


    </header>



    <!-- =================================
         STAT CARDS
    ================================= -->

    <section class="product-stats">


        <!-- TOTAL -->

        <div class="product-stat-card">


            <div class="stat-icon blue">

                <i class="fa-solid fa-box"></i>

            </div>


            <div class="stat-info">

                <span>
                    TOTAL PRODUCTS
                </span>

                <strong
                    class="count-number"
                    data-value="<?= $totalProducts ?>"
                >
                    0
                </strong>

            </div>


            <div class="stat-decoration">
                <i class="fa-solid fa-cube"></i>
            </div>


        </div>



        <!-- NEW -->

        <div class="product-stat-card">


            <div class="stat-icon purple">

                <i class="fa-solid fa-sparkles"></i>

            </div>


            <div class="stat-info">

                <span>
                    NEW ARRIVALS
                </span>

                <strong
                    class="count-number"
                    data-value="<?= $newProducts ?>"
                >
                    0
                </strong>

            </div>


            <div class="stat-decoration">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>


        </div>



        <!-- BEST -->

        <div class="product-stat-card">


            <div class="stat-icon orange">

                <i class="fa-solid fa-fire"></i>

            </div>


            <div class="stat-info">

                <span>
                    BEST SELLERS
                </span>

                <strong
                    class="count-number"
                    data-value="<?= $bestSellers ?>"
                >
                    0
                </strong>

            </div>


            <div class="stat-decoration">
                <i class="fa-solid fa-ranking-star"></i>
            </div>


        </div>



        <!-- STATUS -->

        <div class="product-stat-card">


            <div class="stat-icon green">

                <i class="fa-solid fa-circle-check"></i>

            </div>


            <div class="stat-info">

                <span>
                    CATALOG STATUS
                </span>

                <strong>
                    LIVE
                </strong>

            </div>


            <div class="live-animation">

                <span></span>

            </div>


        </div>


    </section>



    <!-- =================================
         TOOLBAR
    ================================= -->

    <section class="catalog-toolbar">


        <div class="search-box">


            <i class="fa-solid fa-magnifying-glass"></i>


            <input
                type="text"
                id="productSearch"
                placeholder="Search products..."
                autocomplete="off"
            >


            <span class="search-shortcut">
                /
            </span>


        </div>



        <div class="toolbar-right">


            <select
                id="categoryFilter"
                class="category-filter"
            >

                <option value="all">
                    All Categories
                </option>

                <option value="Apparel">
                    Apparel
                </option>

                <option value="Accessories">
                    Accessories
                </option>

                <option value="Home Goods">
                    Home Goods
                </option>

            </select>



            <select
                id="statusFilter"
                class="category-filter"
            >

                <option value="all">
                    All Status
                </option>

                <option value="new">
                    New Arrivals
                </option>

                <option value="best">
                    Best Sellers
                </option>

            </select>


        </div>


    </section>



    <!-- =================================
         PRODUCT TABLE
    ================================= -->

    <section class="products-panel">


        <div class="panel-heading">


            <div>

                <span class="panel-eyebrow">
                    INVENTORY
                </span>


                <h2>
                    Product Catalog
                </h2>

            </div>


            <div class="result-count">

                <span id="visibleCount">
                    <?= $totalProducts ?>
                </span>

                products

            </div>


        </div>



        <div class="table-container">


            <table id="productsTable">


                <thead>

                    <tr>

                        <th>
                            PRODUCT
                        </th>

                        <th>
                            CATEGORY
                        </th>

                        <th>
                            PRICE
                        </th>

                        <th>
                            RATING
                        </th>

                        <th>
                            STATUS
                        </th>

                        <th>
                            REVIEWS
                        </th>

                        <th>
                            ACTIONS
                        </th>

                    </tr>

                </thead>



                <tbody>


                <?php if (empty($products)): ?>

                    <tr>

                        <td
                            colspan="7"
                            class="empty-table"
                        >

                            <div class="empty-state">

                                <div class="empty-state-icon">

                                    <i class="fa-solid fa-box-open"></i>

                                </div>


                                <h3>
                                    No Products Yet
                                </h3>


                                <p>
                                    Your catalog is currently empty.
                                </p>


                                <a
                                    href="product-create.php"
                                    class="empty-add-btn"
                                >

                                    <i class="fa-solid fa-plus"></i>

                                    Add First Product

                                </a>

                            </div>

                        </td>

                    </tr>

                <?php else: ?>


                    <?php foreach ($products as $index => $row): ?>


                    <tr
                        class="product-row"
                        data-name="<?= htmlspecialchars(
                            strtolower($row['name']),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        data-category="<?= htmlspecialchars(
                            $row['category'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        data-new="<?= (int)$row['is_new'] ?>"
                        data-best="<?= (int)$row['is_best_seller'] ?>"
                        style="--row-index: <?= $index ?>"
                    >


                        <!-- PRODUCT -->

                        <td>

                            <div class="product-info">


                                <div class="product-image">


                                    <?php if (!empty($row['image'])): ?>

                                        <img
                                            src="../images/products/<?= htmlspecialchars(
                                                $row['image'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                            alt="<?= htmlspecialchars(
                                                $row['name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                        >

                                    <?php else: ?>

                                        <div class="no-image">

                                            <i class="fa-regular fa-image"></i>

                                        </div>

                                    <?php endif; ?>


                                    <?php if ((int)$row['is_new'] === 1): ?>

                                        <span class="new-dot">
                                            NEW
                                        </span>

                                    <?php endif; ?>


                                </div>



                                <div class="product-name">


                                    <strong>

                                        <?= htmlspecialchars(
                                            $row['name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </strong>


                                    <span>

                                        Product
                                        #<?= htmlspecialchars(
                                            $row['id'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </span>


                                    <?php if (!empty($row['badge'])): ?>

                                        <small class="mini-badge">

                                            <i class="fa-solid fa-tag"></i>

                                            <?= htmlspecialchars(
                                                $row['badge'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </small>

                                    <?php endif; ?>


                                </div>


                            </div>

                        </td>



                        <!-- CATEGORY -->

                        <td>

                            <span class="category-pill">

                                <i class="fa-solid fa-layer-group"></i>

                                <?= htmlspecialchars(
                                    $row['category'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </span>

                        </td>



                        <!-- PRICE -->

                        <td>

                            <div class="price-area">


                                <strong>

                                    $<?= number_format(
                                        (float)$row['price'],
                                        2
                                    ) ?>

                                </strong>


                                <?php if (
                                    !empty($row['compare_price']) &&
                                    (float)$row['compare_price'] >
                                    (float)$row['price']
                                ): ?>

                                    <del>

                                        $<?= number_format(
                                            (float)$row['compare_price'],
                                            2
                                        ) ?>

                                    </del>

                                <?php endif; ?>


                            </div>

                        </td>



                        <!-- RATING -->

                        <td>

                            <div class="rating-area">


                                <div class="stars">

                                    <?php

                                    $rating =
                                        (float)$row['rating'];

                                    $fullStars =
                                        floor($rating);

                                    for (
                                        $i = 1;
                                        $i <= 5;
                                        $i++
                                    ):

                                    ?>

                                        <?php if ($i <= $fullStars): ?>

                                            <i class="fa-solid fa-star"></i>

                                        <?php else: ?>

                                            <i class="fa-regular fa-star"></i>

                                        <?php endif; ?>

                                    <?php endfor; ?>

                                </div>


                                <span>

                                    <?= number_format(
                                        $rating,
                                        1
                                    ) ?>

                                </span>


                            </div>

                        </td>



                        <!-- STATUS -->

                        <td>

                            <div class="status-list">


                                <?php if (
                                    (int)$row['is_new'] === 1
                                ): ?>

                                    <span class="status new">

                                        <i class="fa-solid fa-sparkles"></i>

                                        New

                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    (int)$row['is_best_seller'] === 1
                                ): ?>

                                    <span class="status best">

                                        <i class="fa-solid fa-fire"></i>

                                        Best Seller

                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    (int)$row['is_new'] !== 1 &&
                                    (int)$row['is_best_seller'] !== 1
                                ): ?>

                                    <span class="status normal">

                                        <i class="fa-solid fa-circle"></i>

                                        Standard

                                    </span>

                                <?php endif; ?>


                            </div>

                        </td>



                        <!-- REVIEWS -->

                        <td>

                            <div class="reviews">

                                <i class="fa-regular fa-comment-dots"></i>

                                <?= number_format(
                                    (int)$row['reviews']
                                ) ?>

                            </div>

                        </td>



                        <!-- ACTIONS -->

                        <td>

                            <div class="row-actions">


                                <a
                                    href="edit_product.php?id=<?= urlencode(
                                        $row['id']
                                    ) ?>"
                                    class="action edit"
                                    title="Edit product"
                                >

                                    <i class="fa-solid fa-pen"></i>

                                </a>



                                <a
                                    href="delete_product.php?id=<?= urlencode(
                                        $row['id']
                                    ) ?>"
                                    class="action delete"
                                    title="Delete product"
                                    onclick="return confirm(
                                        'Are you sure you want to delete this product?'
                                    );"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                </a>


                            </div>

                        </td>


                    </tr>


                    <?php endforeach; ?>


                <?php endif; ?>


                </tbody>

            </table>


            <!-- NO SEARCH RESULTS -->

            <div
                id="noResults"
                class="no-results"
            >

                <div class="no-results-icon">

                    <i class="fa-solid fa-magnifying-glass"></i>

                </div>


                <h3>
                    No products found
                </h3>


                <p>
                    Try changing your search or filter.
                </p>

            </div>


        </div>


    </section>



    <!-- =================================
         FOOTER
    ================================= -->

    <footer>

        <span>
            © <?= date("Y") ?> Admin Panel
        </span>


        <span>
            <?= $totalProducts ?> catalog items
        </span>

    </footer>


</main>



<!-- =================================
     JAVASCRIPT
================================= -->

<script src="assets/admin-script.js"></script>


<script>


/* =================================
   COUNT ANIMATION
================================= */

document
    .querySelectorAll(".count-number")
    .forEach(counter => {

        const target =
            Number(
                counter.dataset.value
            );

        let current = 0;

        const duration = 900;

        const start =
            performance.now();


        function animate(time) {

            const progress =
                Math.min(
                    (time - start) / duration,
                    1
                );


            const eased =
                1 -
                Math.pow(
                    1 - progress,
                    3
                );


            current =
                Math.floor(
                    target * eased
                );


            counter.textContent =
                current;


            if (progress < 1) {

                requestAnimationFrame(
                    animate
                );

            } else {

                counter.textContent =
                    target;

            }

        }


        requestAnimationFrame(
            animate
        );

    });



/* =================================
   SEARCH + FILTER
================================= */

const searchInput =
    document.getElementById(
        "productSearch"
    );

const categoryFilter =
    document.getElementById(
        "categoryFilter"
    );

const statusFilter =
    document.getElementById(
        "statusFilter"
    );

const rows =
    document.querySelectorAll(
        ".product-row"
    );

const visibleCount =
    document.getElementById(
        "visibleCount"
    );

const noResults =
    document.getElementById(
        "noResults"
    );


function filterProducts() {


    const search =
        searchInput.value
            .toLowerCase()
            .trim();


    const category =
        categoryFilter.value;


    const status =
        statusFilter.value;


    let visible = 0;


    rows.forEach(row => {


        const name =
            row.dataset.name;


        const rowCategory =
            row.dataset.category;


        const isNew =
            row.dataset.new === "1";


        const isBest =
            row.dataset.best === "1";


        const matchesSearch =
            name.includes(search);


        const matchesCategory =
            category === "all" ||
            rowCategory === category;


        let matchesStatus = true;


        if (status === "new") {

            matchesStatus = isNew;

        }


        if (status === "best") {

            matchesStatus = isBest;

        }


        const show =
            matchesSearch &&
            matchesCategory &&
            matchesStatus;


        if (show) {

            row.style.display = "";

            row.classList.remove(
                "hidden-row"
            );

            visible++;


        } else {

            row.classList.add(
                "hidden-row"
            );


            setTimeout(() => {

                if (
                    row.classList.contains(
                        "hidden-row"
                    )
                ) {

                    row.style.display =
                        "none";

                }

            }, 250);

        }

    });


    visibleCount.textContent =
        visible;


    if (visible === 0) {

        noResults.classList.add(
            "show"
        );

    } else {

        noResults.classList.remove(
            "show"
        );

    }

}


searchInput.addEventListener(
    "input",
    filterProducts
);


categoryFilter.addEventListener(
    "change",
    filterProducts
);


statusFilter.addEventListener(
    "change",
    filterProducts
);



/* =================================
   "/" SEARCH SHORTCUT
================================= */

document.addEventListener(
    "keydown",
    event => {

        if (
            event.key === "/" &&
            document.activeElement.tagName !==
            "INPUT"
        ) {

            event.preventDefault();

            searchInput.focus();

        }


        if (
            event.key === "Escape" &&
            document.activeElement ===
            searchInput
        ) {

            searchInput.value = "";

            filterProducts();

            searchInput.blur();

        }

    }
);



/* =================================
   IMAGE HOVER PARALLAX
================================= */

document
    .querySelectorAll(
        ".product-image img"
    )
    .forEach(image => {


        image.addEventListener(
            "mousemove",
            event => {

                const rect =
                    image.getBoundingClientRect();


                const x =
                    event.clientX -
                    rect.left;


                const y =
                    event.clientY -
                    rect.top;


                const rotateX =
                    ((y / rect.height) -
                    .5) * -8;


                const rotateY =
                    ((x / rect.width) -
                    .5) * 8;


                image.style.transform =
                    `
                    scale(1.08)
                    rotateX(${rotateX}deg)
                    rotateY(${rotateY}deg)
                    `;

            }
        );


        image.addEventListener(
            "mouseleave",
            () => {

                image.style.transform =
                    "";

            }
        );

    });



/* =================================
   ACTION BUTTON CLICK
================================= */

document
    .querySelectorAll(
        ".action"
    )
    .forEach(button => {

        button.addEventListener(
            "click",
            function () {

                this.classList.add(
                    "clicked"
                );

            }
        );

    });

</script>


</body>

</html>

