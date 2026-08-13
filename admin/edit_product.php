
<?php
session_start();
require_once "../database/db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Product ID is required.");
}


/* =========================
   GET PRODUCT
========================= */

$sql = "SELECT * FROM products WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'id' => $id
]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}


/* =========================
   UPDATE PRODUCT
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $badge = $_POST['badge'] ?? '';
        $price = $_POST['price'] ?? 0;
        $compare_price = $_POST['compare_price'] ?? 0;
        $rating = $_POST['rating'] ?? 0;
        $reviews = $_POST['reviews'] ?? 0;

        $isNew = isset($_POST['is_new']) ? 1 : 0;
        $isBestSeller = isset($_POST['is_best_seller']) ? 1 : 0;

        /* Keep old image */
        $image = $product['image'];


        /* =========================
           IMAGE UPLOAD
        ========================= */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {

            $uploadDir = "../images/products/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }


            $originalName = $_FILES['image']['name'];

            $extension = strtolower(
                pathinfo(
                    $originalName,
                    PATHINFO_EXTENSION
                )
            );


            $allowedExtensions = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];


            if (!in_array(
                $extension,
                $allowedExtensions
            )) {

                die(
                    "Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed."
                );

            }


            $imageName =
                uniqid('product_', true)
                . '.'
                . $extension;


            $imagePath =
                $uploadDir . $imageName;


            if (
                !move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    $imagePath
                )
            ) {

                die("Failed to upload image.");

            }


            /* Delete old image */

            if (
                !empty($product['image']) &&
                file_exists(
                    $uploadDir . $product['image']
                )
            ) {

                unlink(
                    $uploadDir . $product['image']
                );

            }


            $image = $imageName;

        }


        /* =========================
           UPDATE DATABASE
        ========================= */

        $updateStmt = $pdo->prepare("
            UPDATE products SET

                name = :name,
                category = :category,
                badge = :badge,
                price = :price,
                compare_price = :compare_price,
                rating = :rating,
                reviews = :reviews,
                is_new = :is_new,
                is_best_seller = :is_best_seller,
                image = :image

            WHERE id = :id
        ");


        $updateStmt->execute([

            'name' => $name,
            'category' => $category,
            'badge' => $badge,
            'price' => $price,
            'compare_price' => $compare_price,
            'rating' => $rating,
            'reviews' => $reviews,
            'is_new' => $isNew,
            'is_best_seller' => $isBestSeller,
            'image' => $image,
            'id' => $id

        ]);


        header("Location: products.php");

        exit;


    } catch (PDOException $e) {

        die(
            "Error updating product: "
            . $e->getMessage()
        );

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

    <title>Edit Product</title>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <!-- Dashboard CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/admin-style.css"
    >


    <!-- Edit Page CSS -->

    <link
        rel="stylesheet"
        href="../assets/css/product-edit.css"
    >

</head>


<body>


<!-- =========================
     ANIMATED BACKGROUND
========================= -->

<div class="background">

    <span></span>
    <span></span>
    <span></span>
    <span></span>

</div>



<!-- =========================
     MOBILE BUTTON
========================= -->

<button
    class="sidebar-toggle"
    aria-label="Toggle menu"
>

    <i class="fa-solid fa-bars"></i>

</button>



<!-- =========================
     SIDEBAR
========================= -->

<aside class="sidebar">


    <div class="logo">

        <div class="logo-icon">

            <i class="fa-solid fa-layer-group"></i>

        </div>


        <div>

            <strong>Admin</strong>

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



<!-- =========================
     MAIN
========================= -->

<main class="main">


    <!-- TOPBAR -->

    <header class="topbar">


        <div class="welcome">


            <span class="eyebrow">

                <span class="pulse"></span>

                PRODUCT MANAGEMENT

            </span>


            <h1>

                Edit Product

                <span class="edit-icon">
                    <i class="fa-solid fa-pen"></i>
                </span>

            </h1>


            <p>

                Update the details and appearance
                of this catalog item.

            </p>


        </div>



        <div class="top-actions">


            <div class="product-id">

                <i class="fa-solid fa-hashtag"></i>

                Product ID:
                <strong>
                    <?php
                    echo htmlspecialchars(
                        $id,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </strong>

            </div>


            <a
                href="products.php"
                class="back-button"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>


        </div>


    </header>



    <!-- =========================
         FORM
    ========================= -->

    <section class="edit-layout">


        <!-- =====================
             LEFT FORM
        ====================== -->

        <div class="edit-panel">


            <div class="panel-header">


                <div>

                    <span class="panel-eyebrow">
                        PRODUCT DETAILS
                    </span>

                    <h2>
                        General Information
                    </h2>

                </div>


                <div class="panel-icon">

                    <i class="fa-solid fa-pen-to-square"></i>

                </div>


            </div>



            <form
                method="POST"
                enctype="multipart/form-data"
                id="productForm"
            >


                <!-- PRODUCT NAME -->

                <div class="form-group full">

                    <label for="name">

                        Product Name

                        <span>*</span>

                    </label>


                    <div class="input-wrapper">

                        <i class="fa-solid fa-tag"></i>


                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?php
                            echo htmlspecialchars(
                                $product['name'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>"
                            placeholder="Example: Classic Overshirt"
                            required
                        >

                    </div>

                </div>



                <!-- TWO COLUMN -->

                <div class="form-grid">


                    <!-- CATEGORY -->

                    <div class="form-group">

                        <label for="category">

                            Category

                            <span>*</span>

                        </label>


                        <div class="input-wrapper">

                            <i class="fa-solid fa-layer-group"></i>


                            <select
                                id="category"
                                name="category"
                                required
                            >

                                <option value="">
                                    Select Category
                                </option>


                                <option
                                    value="Apparel"
                                    <?php
                                    echo (
                                        $product['category']
                                        === 'Apparel'
                                    )
                                    ? 'selected'
                                    : '';
                                    ?>
                                >
                                    Apparel
                                </option>


                                <option
                                    value="Accessories"
                                    <?php
                                    echo (
                                        $product['category']
                                        === 'Accessories'
                                    )
                                    ? 'selected'
                                    : '';
                                    ?>
                                >
                                    Accessories
                                </option>


                                <option
                                    value="Home Goods"
                                    <?php
                                    echo (
                                        $product['category']
                                        === 'Home Goods'
                                    )
                                    ? 'selected'
                                    : '';
                                    ?>
                                >
                                    Home Goods
                                </option>

                            </select>


                            <i class="fa-solid fa-chevron-down select-arrow"></i>

                        </div>

                    </div>



                    <!-- BADGE -->

                    <div class="form-group">

                        <label for="badge">
                            Badge
                        </label>


                        <div class="input-wrapper">

                            <i class="fa-solid fa-certificate"></i>


                            <input
                                type="text"
                                id="badge"
                                name="badge"
                                value="<?php
                                echo htmlspecialchars(
                                    $product['badge'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                                placeholder="New / Popular / Just In"
                            >

                        </div>

                    </div>



                    <!-- PRICE -->

                    <div class="form-group">

                        <label for="price">

                            Price

                            <span>*</span>

                        </label>


                        <div class="input-wrapper">

                            <span class="currency">
                                $
                            </span>


                            <input
                                type="number"
                                id="price"
                                name="price"
                                step="0.01"
                                min="0"
                                value="<?php
                                echo htmlspecialchars(
                                    $product['price'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                                placeholder="59.00"
                                required
                            >

                        </div>

                    </div>



                    <!-- COMPARE PRICE -->

                    <div class="form-group">

                        <label for="compare_price">

                            Compare Price

                        </label>


                        <div class="input-wrapper">

                            <span class="currency">
                                $
                            </span>


                            <input
                                type="number"
                                id="compare_price"
                                name="compare_price"
                                step="0.01"
                                min="0"
                                value="<?php
                                echo htmlspecialchars(
                                    $product['compare_price'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                                placeholder="79.00"
                            >

                        </div>

                    </div>



                    <!-- RATING -->

                    <div class="form-group">

                        <label for="rating">
                            Rating
                        </label>


                        <div class="input-wrapper">

                            <i class="fa-solid fa-star rating-star"></i>


                            <input
                                type="number"
                                id="rating"
                                name="rating"
                                step="0.1"
                                min="0"
                                max="5"
                                value="<?php
                                echo htmlspecialchars(
                                    $product['rating'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                            >


                            <span class="input-suffix">
                                / 5
                            </span>

                        </div>

                    </div>



                    <!-- REVIEWS -->

                    <div class="form-group">

                        <label for="reviews">
                            Reviews
                        </label>


                        <div class="input-wrapper">

                            <i class="fa-regular fa-comment"></i>


                            <input
                                type="number"
                                id="reviews"
                                name="reviews"
                                min="0"
                                value="<?php
                                echo htmlspecialchars(
                                    $product['reviews'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                            >

                        </div>

                    </div>


                </div>



                <!-- =====================
                     PRODUCT STATUS
                ====================== -->

                <div class="status-section">


                    <div class="section-title">

                        <div>

                            <span class="panel-eyebrow">
                                VISIBILITY
                            </span>

                            <h3>
                                Product Status
                            </h3>

                        </div>


                        <i class="fa-solid fa-sliders"></i>

                    </div>



                    <div class="checkbox-group">


                        <label class="status-card">


                            <input
                                type="checkbox"
                                name="is_new"
                                value="1"

                                <?php
                                echo (
                                    (int)$product['is_new']
                                    === 1
                                )
                                ? 'checked'
                                : '';
                                ?>
                            >


                            <div class="check-icon new">

                                <i class="fa-solid fa-sparkles"></i>

                            </div>


                            <div>

                                <strong>
                                    New Arrival
                                </strong>

                                <small>
                                    Highlight this product as new
                                </small>

                            </div>


                            <span class="custom-check">
                                <i class="fa-solid fa-check"></i>
                            </span>


                        </label>



                        <label class="status-card">


                            <input
                                type="checkbox"
                                name="is_best_seller"
                                value="1"

                                <?php
                                echo (
                                    (int)$product['is_best_seller']
                                    === 1
                                )
                                ? 'checked'
                                : '';
                                ?>
                            >


                            <div class="check-icon best">

                                <i class="fa-solid fa-fire"></i>

                            </div>


                            <div>

                                <strong>
                                    Best Seller
                                </strong>

                                <small>
                                    Mark as a popular product
                                </small>

                            </div>


                            <span class="custom-check">
                                <i class="fa-solid fa-check"></i>
                            </span>


                        </label>


                    </div>


                </div>



                <!-- BUTTONS -->

                <div class="form-buttons">


                    <a
                        href="products.php"
                        class="cancel-btn"
                    >

                        <i class="fa-solid fa-xmark"></i>

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="update-btn"
                    >

                        <span>
                            <i class="fa-solid fa-floppy-disk"></i>
                            Update Product
                        </span>

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>


                </div>


            </form>

        </div>



        <!-- =====================
             RIGHT IMAGE
        ====================== -->

        <aside class="preview-panel">


            <div class="panel-header">


                <div>

                    <span class="panel-eyebrow">
                        PREVIEW
                    </span>

                    <h2>
                        Product Image
                    </h2>

                </div>


                <div class="panel-icon purple">

                    <i class="fa-regular fa-image"></i>

                </div>


            </div>



            <!-- IMAGE -->

            <div class="image-preview">


                <div class="image-glow"></div>


                <img
                    id="imagePreview"
                    src="../images/products/<?php
                    echo htmlspecialchars(
                        $product['image'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                    alt="Product Image"
                >


                <div class="image-overlay">

                    <i class="fa-solid fa-camera"></i>

                    <span>
                        Preview
                    </span>

                </div>


            </div>



            <!-- CURRENT IMAGE -->

            <div class="current-image-info">

                <div class="info-icon">

                    <i class="fa-solid fa-check"></i>

                </div>


                <div>

                    <strong>
                        Current image
                    </strong>

                    <small>

                        <?php
                        echo htmlspecialchars(
                            $product['image'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </small>

                </div>

            </div>



            <!-- UPLOAD -->

            <label
                for="image"
                class="upload-box"
            >

                <div class="upload-icon">

                    <i class="fa-solid fa-cloud-arrow-up"></i>

                </div>


                <strong>
                    Change Image
                </strong>


                <span>
                    Click to upload a new image
                </span>


                <small>
                    JPG, JPEG, PNG or WEBP
                </small>


                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    form="productForm"
                >

            </label>


        </aside>


    </section>



    <!-- FOOTER -->

    <footer>

        <span>
            © <?php echo date("Y"); ?> Admin Panel
        </span>


        <span>
            Editing Product #<?php echo $id; ?>
        </span>

    </footer>


</main>



<script src="assets/admin-script.js"></script>


<script>

/* =========================
   IMAGE PREVIEW
========================= */

const imageInput =
    document.getElementById("image");

const imagePreview =
    document.getElementById("imagePreview");


if (imageInput) {

    imageInput.addEventListener(
        "change",
        function () {

            const file = this.files[0];

            if (!file) {
                return;
            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    imagePreview.src =
                        event.target.result;

                    imagePreview.classList.add(
                        "preview-animation"
                    );

                };


            reader.readAsDataURL(file);

        }
    );

}


/* =========================
   INPUT FOCUS EFFECT
========================= */

document
    .querySelectorAll(
        ".input-wrapper input, .input-wrapper select"
    )
    .forEach(input => {

        input.addEventListener(
            "focus",
            () => {

                input
                    .closest(".input-wrapper")
                    .classList.add("focused");

            }
        );


        input.addEventListener(
            "blur",
            () => {

                input
                    .closest(".input-wrapper")
                    .classList.remove("focused");

            }
        );

    });


/* =========================
   CHECKBOX ANIMATION
========================= */

document
    .querySelectorAll(".status-card")
    .forEach(card => {

        card.addEventListener(
            "click",
            () => {

                card.classList.add("clicked");

                setTimeout(() => {

                    card.classList.remove(
                        "clicked"
                    );

                }, 350);

            }
        );

    });

</script>


</body>

</html>
