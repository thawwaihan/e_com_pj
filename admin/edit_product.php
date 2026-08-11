<?php
require_once "../database/db.php";
$id=$_GET['id'] ?? null;
if(!$id){
    die("Product ID is required.");
}
$sql="Select * FROM products WHERE id=:id";
$stmt=$pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC); 
if(!$product){
    die("Product not found.");
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    try{
    $name=$_POST['name'];
    $category=$_POST['category'];
    $badge=$_POST['badge'];
    $price=$_POST['price'];
    $compare_price=$_POST['compare_price'];
    $rating=$_POST['rating'];
    $reviews=$_POST['reviews'];
    $isNew=isset($_POST['is_new']) ? 1 : 0;
    $isBestSeller=isset($_POST['is_best_seller']) ? 1 : 0;
    
$image = $product['image'];


if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK
) {

    $uploadDir = "../images/products/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $originalname = $_FILES['image']['name'];

    $extension = strtolower(
        pathinfo($originalname, PATHINFO_EXTENSION)
    );

    $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];

    if (!in_array($extension, $allowedExtensions)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed.");
    }

    $imageName = uniqid('product_', true) . '.' . $extension;

    $imagePath = $uploadDir . $imageName;

    if (
        !move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $imagePath
        )
    ) {
        die("Failed to upload image.");
    }

    if (
        !empty($product['image']) &&
        file_exists($uploadDir . $product['image'])
    ) {
        unlink($uploadDir . $product['image']);
    }

    $image = $imageName;
}
    $updatestmt=$pdo->prepare("UPDATE products SET name=:name, category=:category, badge=:badge, price=:price, compare_price=:compare_price, rating=:rating, reviews=:reviews,is_new=:is_new, is_best_seller=:is_best_seller,image=:image WHERE id=:id");
    $updatestmt->execute([
        'name'=>$name,
        'category'=>$category,
        'badge'=>$badge,
        'price'=>$price,
        'image'=>$image,
        'compare_price'=>$compare_price,
        'rating'=>$rating,
        'reviews'=>$reviews,
        'is_new'=>$isNew,
        'is_best_seller'=>$isBestSeller,
        'id'=>$id
    ]); 
    header("Location: products.php");
    }catch(PDOException $e){
        die("Error updating product: " . $e->getMessage()); 
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="form-container">

    <form method="POST" enctype="multipart/form-data">

        <div class="form-grid">

            <!-- Product Name -->
            <div class="form-group full">
                <label for="name">Product Name</label>
                <input type="hidden" name="id" value="...">
                <input
                    type="text"
                    id="name"
                    value="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                    name="name"
                    placeholder="Example: Classic Overshirt"
                    required
                >
            </div>


            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>

                <select id="category" name="category" required>

                    <option value="">Select Category</option>

                    <option value="Apparel" <?php echo ($product['category'] === 'Apparel') ? 'selected' : ''; ?>>
                        Apparel
                    </option>

                    <option value="Accessories" <?php echo ($product['category'] === 'Accessories') ? 'selected' : ''; ?>>
                        Accessories
                    </option>

                    <option value="Home Goods" <?php echo ($product['category'] === 'Home Goods') ? 'selected' : ''; ?>>
                        Home Goods
                    </option>

                </select>
            </div>


            <!-- Badge -->
            <div class="form-group">
                <label for="badge">Badge</label>

                <input
                    type="text"
                    id="badge"
                    value="<?php echo htmlspecialchars($product['badge'], ENT_QUOTES, 'UTF-8'); ?>"
                    name="badge"
                    placeholder="New / Popular / Just In"
                >
            </div>


            <!-- Price -->
            <div class="form-group">
                <label for="price">Price</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    step="0.01"
                    min="0"
                    value="<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="59.00"
                    required
                >
            </div>


            <!-- Compare Price -->
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
                    value="<?php echo htmlspecialchars($product['compare_price'], ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="79.00"
                >
            </div>


            <!-- Rating -->
            <div class="form-group">
                <label for="rating">Rating</label>

                <input
                    type="number"
                    id="rating"
                    name="rating"
                    step="0.1"
                    min="0"
                    max="5"
                    value="<?php echo htmlspecialchars($product['rating'], ENT_QUOTES, 'UTF-8'); ?>"
                >
            </div>


            <!-- Reviews -->
            <div class="form-group">
                <label for="reviews">Reviews</label>

                <input
                    type="number"
                    id="reviews"
                    name="reviews"
                    min="0"
                    value="<?php echo htmlspecialchars($product['reviews'], ENT_QUOTES, 'UTF-8'); ?>"
                >
            </div>


            <!-- Current Image -->
            <div class="form-group full">

                <label>Current Product Image</label>

                <div>
                    <img
                        src="../images/products/<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="Current Product"
                        style="
                            width: 150px;
                            height: 150px;
                            object-fit: cover;
                            border: 1px solid #ddd;
                            padding: 5px;
                        "
                    >
                </div>

            </div>


            <!-- New Image -->
            <div class="form-group full">

                <label for="image">
                    Change Product Image
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Leave empty if you don't want to change the image.
                </small>

            </div>


            <!-- Product Status -->
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
                            <?php echo ($product['is_new'] === 1) ? 'checked' : ''; ?>
>
                        New Arrival

                    </label>


                    <label class="checkbox-item">

                        <input
                            type="checkbox"
                            name="is_best_seller"
                            value="1"
                            <?php echo ($product['is_best_seller'] === 1) ? 'checked' : ''; ?>
>

                        Best Seller

                    </label>

                </div>

            </div>

        </div>


        <!-- Buttons -->
        <div class="buttons">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Product
            </button>


            <a
                href="products.php"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>
</body>
</html>