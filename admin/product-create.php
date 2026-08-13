<?php
session_start();
require_once "../database/db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $price = $_POST["price"] ?? "";
    $comparePrice = $_POST["compare_price"] ?? "";
    $badge = trim($_POST["badge"] ?? "");
    $rating = $_POST["rating"] ?? 0;
    $reviews = $_POST["reviews"] ?? 0;

    $isNew = isset($_POST["is_new"]) ? 1 : 0;
    $isBestSeller = isset($_POST["is_best_seller"]) ? 1 : 0;


    if ($name === "" || $category === "" || $price === "") {

        $error = "Name, category and price are required.";

    } else {

        try {

            $imageName = null;


            /* =========================
               IMAGE UPLOAD
            ========================= */

            if (
                isset($_FILES["image"]) &&
                $_FILES["image"]["error"] === UPLOAD_ERR_OK
            ) {

                $uploadDir = "../images/products/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }


                $originalName = $_FILES["image"]["name"];

                $extension = strtolower(
                    pathinfo(
                        $originalName,
                        PATHINFO_EXTENSION
                    )
                );


                $allowedExtensions = [
                    "jpg",
                    "jpeg",
                    "png",
                    "webp"
                ];


                if (!in_array(
                    $extension,
                    $allowedExtensions
                )) {

                    $error =
                        "Only JPG, JPEG, PNG and WEBP images are allowed.";

                } else {

                    $imageName =
                        uniqid("product_", true)
                        . "."
                        . $extension;


                    $imagePath =
                        $uploadDir . $imageName;


                    if (
                        !move_uploaded_file(
                            $_FILES["image"]["tmp_name"],
                            $imagePath
                        )
                    ) {

                        $error =
                            "Failed to upload image.";

                    }

                }

            }


            /* =========================
               INSERT PRODUCT
            ========================= */

            if ($error === "") {

                $sql = "

                    INSERT INTO products
                    (
                        name,
                        category,
                        price,
                        compare_price,
                        image,
                        badge,
                        rating,
                        reviews,
                        is_new,
                        is_best_seller
                    )

                    VALUES
                    (
                        :name,
                        :category,
                        :price,
                        :compare_price,
                        :image,
                        :badge,
                        :rating,
                        :reviews,
                        :is_new,
                        :is_best_seller
                    )

                ";


                $stmt = $pdo->prepare($sql);


                $stmt->execute([

                    ":name" => $name,

                    ":category" => $category,

                    ":price" => $price,

                    ":compare_price" =>
                        $comparePrice !== ""
                            ? $comparePrice
                            : null,

                    ":image" => $imageName,

                    ":badge" =>
                        $badge !== ""
                            ? $badge
                            : null,

                    ":rating" => $rating,

                    ":reviews" => $reviews,

                    ":is_new" => $isNew,

                    ":is_best_seller" => $isBestSeller

                ]);


                $message =
                    "Product added successfully!";


                $_POST = [];

            }


        } catch (PDOException $e) {

            $error =
                "Database error: "
                . $e->getMessage();

        }

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

    <title>Add Product</title>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <!-- Main Dashboard Style -->

    <link
        rel="stylesheet"
        href="../assets/css/admin-style.css"
    >


    <!-- Create Product Style -->

    <link
        rel="stylesheet"
        href="../assets/css/product-create.css"
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
     MOBILE SIDEBAR BUTTON
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



        <a href="products.php">

            <span class="menu-icon">

                <i class="fa-solid fa-box"></i>

            </span>

            <span>
                Products
            </span>

        </a>



        <a
            href="product-create.php"
            class="active"
        >

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

                Add Product

                <span class="add-icon">

                    <i class="fa-solid fa-plus"></i>

                </span>

            </h1>


            <p>

                Add a new product to your store catalog.

            </p>


        </div>



        <div class="top-actions">


            <div class="create-badge">

                <span></span>

                READY TO CREATE

            </div>


            <a
                href="products.php"
                class="back-button"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Products

            </a>


        </div>


    </header>



    <!-- =========================
         ALERTS
    ========================= -->

    <?php if ($message): ?>

        <div class="alert success">

            <div class="alert-icon">

                <i class="fa-solid fa-check"></i>

            </div>


            <div>

                <strong>
                    Success
                </strong>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $message,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <button
                type="button"
                class="alert-close"
            >

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

    <?php endif; ?>



    <?php if ($error): ?>

        <div class="alert danger">

            <div class="alert-icon">

                <i class="fa-solid fa-exclamation"></i>

            </div>


            <div>

                <strong>
                    Something went wrong
                </strong>

                <span>

                    <?php
                    echo htmlspecialchars(
                        $error,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>

                </span>

            </div>


            <button
                type="button"
                class="alert-close"
            >

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

    <?php endif; ?>



    <!-- =========================
         CREATE LAYOUT
    ========================= -->

    <section class="create-layout">


        <!-- =====================
             PRODUCT FORM
        ====================== -->

        <div class="create-panel">


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

                    <i class="fa-solid fa-box-open"></i>

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
                            placeholder="Example: Classic Overshirt"
                            required
                            value="<?php
                            echo htmlspecialchars(
                                $_POST["name"] ?? "",
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>"
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
                                        ($_POST["category"] ?? "")
                                        === "Apparel"
                                    )
                                    ? "selected"
                                    : "";
                                    ?>
                                >
                                    Apparel
                                </option>


                                <option
                                    value="Accessories"
                                    <?php
                                    echo (
                                        ($_POST["category"] ?? "")
                                        === "Accessories"
                                    )
                                    ? "selected"
                                    : "";
                                    ?>
                                >
                                    Accessories
                                </option>


                                <option
                                    value="Home Goods"
                                    <?php
                                    echo (
                                        ($_POST["category"] ?? "")
                                        === "Home Goods"
                                    )
                                    ? "selected"
                                    : "";
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
                                placeholder="New / Popular / Just In"
                                value="<?php
                                echo htmlspecialchars(
                                    $_POST["badge"] ?? "",
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
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
                                placeholder="59.00"
                                required
                                value="<?php
                                echo htmlspecialchars(
                                    $_POST["price"] ?? "",
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
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
                                placeholder="79.00"
                                value="<?php
                                echo htmlspecialchars(
                                    $_POST["compare_price"] ?? "",
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
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
                                    $_POST["rating"] ?? "0",
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                            >

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
                                    $_POST["reviews"] ?? "0",
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


                        <!-- NEW -->

                        <label class="status-card">

                            <input
                                type="checkbox"
                                name="is_new"
                                value="1"

                                <?php
                                echo isset(
                                    $_POST["is_new"]
                                )
                                ? "checked"
                                : "";
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



                        <!-- BEST SELLER -->

                        <label class="status-card">

                            <input
                                type="checkbox"
                                name="is_best_seller"
                                value="1"

                                <?php
                                echo isset(
                                    $_POST["is_best_seller"]
                                )
                                ? "checked"
                                : "";
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
                                    Mark this as a popular product
                                </small>

                            </div>


                            <span class="custom-check">

                                <i class="fa-solid fa-check"></i>

                            </span>

                        </label>


                    </div>


                </div>



                <!-- =====================
                     BUTTONS
                ====================== -->

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
                        class="create-btn"
                    >

                        <span>

                            <i class="fa-solid fa-plus"></i>

                            Add Product

                        </span>


                        <i class="fa-solid fa-arrow-right"></i>

                    </button>


                </div>


            </form>

        </div>



        <!-- =====================
             IMAGE PANEL
        ====================== -->

        <aside class="preview-panel">


            <div class="panel-header">


                <div>

                    <span class="panel-eyebrow">
                        PRODUCT MEDIA
                    </span>

                    <h2>
                        Product Image
                    </h2>

                </div>


                <div class="panel-icon purple">

                    <i class="fa-regular fa-image"></i>

                </div>


            </div>



            <!-- IMAGE PREVIEW -->

            <div class="image-preview">


                <div class="image-glow"></div>


                <div
                    class="empty-image"
                    id="emptyImage"
                >

                    <div class="empty-icon">

                        <i class="fa-regular fa-image"></i>

                    </div>


                    <strong>
                        No Image Selected
                    </strong>


                    <span>
                        Upload an image to preview it
                    </span>

                </div>


                <img
                    id="imagePreview"
                    alt="Product Preview"
                >


                <div class="image-overlay">

                    <i class="fa-solid fa-eye"></i>

                    <span>
                        Preview
                    </span>

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
                    Upload Product Image
                </strong>


                <span>
                    Click here to select an image
                </span>


                <small>
                    JPG · JPEG · PNG · WEBP
                </small>


                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    form="productForm"
                >

            </label>



            <!-- IMAGE INFO -->

            <div class="image-tip">

                <div class="tip-icon">

                    <i class="fa-solid fa-lightbulb"></i>

                </div>


                <div>

                    <strong>
                        Image tip
                    </strong>

                    <small>
                        Use a clear product image with
                        a simple background.
                    </small>

                </div>

            </div>


        </aside>


    </section>



    <!-- FOOTER -->

    <footer>

        <span>
            © <?php echo date("Y"); ?> Admin Panel
        </span>


        <span>
            Create new catalog item
        </span>

    </footer>


</main>



<!-- =========================
     JAVASCRIPT
========================= -->

<script src="assets/admin-script.js"></script>


<script>


/* =========================
   IMAGE PREVIEW
========================= */

const imageInput =
    document.getElementById("image");

const imagePreview =
    document.getElementById("imagePreview");

const emptyImage =
    document.getElementById("emptyImage");


if (imageInput) {

    imageInput.addEventListener(
        "change",
        function () {

            const file = this.files[0];

            if (!file) {
                return;
            }


            /* Check file type */

            const allowed = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];


            if (!allowed.includes(file.type)) {

                alert(
                    "Please select JPG, PNG or WEBP image."
                );

                this.value = "";

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    imagePreview.src =
                        event.target.result;


                    imagePreview.style.display =
                        "block";


                    emptyImage.style.display =
                        "none";


                    imagePreview.classList.remove(
                        "preview-animation"
                    );


                    void imagePreview.offsetWidth;


                    imagePreview.classList.add(
                        "preview-animation"
                    );

                };


            reader.readAsDataURL(file);

        }
    );

}



/* =========================
   INPUT FOCUS
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
   ALERT CLOSE
========================= */

document
    .querySelectorAll(".alert-close")
    .forEach(button => {

        button.addEventListener(
            "click",
            () => {

                const alert =
                    button.closest(".alert");

                alert.classList.add(
                    "alert-hide"
                );


                setTimeout(() => {

                    alert.remove();

                }, 400);

            }
        );

    });



/* =========================
   FORM SUBMIT ANIMATION
========================= */

const form =
    document.getElementById("productForm");


if (form) {

    form.addEventListener(
        "submit",
        function () {

            const button =
                form.querySelector(".create-btn");


            if (button) {

                button.classList.add(
                    "loading"
                );


                button.querySelector(
                    "span"
                ).innerHTML = `

                    <i class="fa-solid fa-spinner fa-spin"></i>

                    Creating Product...

                `;

            }

        }
    );

}

</script>


</body>

</html>
