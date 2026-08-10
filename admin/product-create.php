<?php

require_once "../db.php";

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
                    pathinfo($originalName, PATHINFO_EXTENSION)
                );

                $allowedExtensions = [
                    "jpg",
                    "jpeg",
                    "png",
                    "webp"
                ];

                if (!in_array($extension, $allowedExtensions)) {

                    $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

                } else {
                    $imageName = uniqid("product_", true) . "." . $extension;
                    $imagePath = $uploadDir . $imageName;
                    move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $imagePath
                    );
                }
            }

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

                $message = "Product added successfully!";

                $_POST = [];
            }

        } catch (PDOException $e) {

            $error = "Database error: " . $e->getMessage();

        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Add Product</title>

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
        max-width: 1100px;
    }

    .topbar {
        margin-bottom: 30px;
    }

    .topbar h1 {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .topbar p {
        color: #777;
    }

    .form-container {
        background: white;
        padding: 30px;
        border: 1px solid #ddd;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    label {
        font-weight: bold;
        margin-bottom: 8px;
    }

    input,
    select {
        padding: 12px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    input:focus,
    select:focus {
        outline: none;
        border-color: #b8792e;
    }

    .checkbox-group {
        display: flex;
        gap: 30px;
        margin-top: 5px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .checkbox-item input {
        width: auto;
    }

    .message {
        padding: 12px;
        margin-bottom: 20px;
        background: #e8f5e9;
        color: #2e7d32;
    }

    .error {
        padding: 12px;
        margin-bottom: 20px;
        background: #ffebee;
        color: #c62828;
    }

    .buttons {
        margin-top: 30px;
        display: flex;
        gap: 15px;
    }

    .btn {
        border: none;
        padding: 14px 25px;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
    }

    .btn-primary {
        background: #16181c;
        color: white;
    }

    .btn-primary:hover {
        background: #b8792e;
    }

    .btn-secondary {
        background: #ddd;
        color: #16181c;
    }

    @media (max-width: 800px) {

        .sidebar {
            width: 180px;
        }

        .main {
            margin-left: 180px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

    }

</style>
```

</head>

<body>

```
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

        <h1>Add Product</h1>

        <p>
            Add a new product to your store.
        </p>

    </div>


    <?php if ($message): ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <div class="form-container">

        <form
            method="POST"
            enctype="multipart/form-data"
        >

            <div class="form-grid">


                <div class="form-group full">

                    <label for="name">
                        Product Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Example: Classic Overshirt"
                        required
                        value="<?php
                            echo htmlspecialchars(
                                $_POST["name"] ?? ""
                            );
                        ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="category">
                        Category
                    </label>

                    <select
                        id="category"
                        name="category"
                        required
                    >

                        <option value="">
                            Select Category
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

                </div>


                <div class="form-group">

                    <label for="badge">
                        Badge
                    </label>

                    <input
                        type="text"
                        id="badge"
                        name="badge"
                        placeholder="New / Popular / Just In"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST["badge"] ?? ""
                            );
                        ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="price">
                        Price
                    </label>

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
                                $_POST["price"] ?? ""
                            );
                        ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="compare_price">
                        Compare Price
                    </label>

                    <input
                        type="number"
                        id="compare_price"
                        name="compare_price"
                        step="0.01"
                        min="0"
                        placeholder="79.00"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST["compare_price"] ?? ""
                            );
                        ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="rating">
                        Rating
                    </label>

                    <input
                        type="number"
                        id="rating"
                        name="rating"
                        step="0.1"
                        min="0"
                        max="5"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST["rating"] ?? "0"
                            );
                        ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="reviews">
                        Reviews
                    </label>

                    <input
                        type="number"
                        id="reviews"
                        name="reviews"
                        min="0"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST["reviews"] ?? "0"
                            );
                        ?>"
                    >

                </div>


                <div class="form-group full">

                    <label for="image">
                        Product Image
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                </div>


                <div class="form-group full">

                    <label>
                        Product Status
                    </label>

                    <div class="checkbox-group">

                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="is_new"
                                value="1"
                            >

                            New Arrival

                        </label>


                        <label class="checkbox-item">

                            <input
                                type="checkbox"
                                name="is_best_seller"
                                value="1"
                            >

                            Best Seller

                        </label>

                    </div>

                </div>


            </div>


            <div class="buttons">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Add Product
                </button>

                <a
                    href="dashboard.php"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</main>
```

</body>

</html>
