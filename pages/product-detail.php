<?php
include '../includes/header.php';
require_once '../database/db.php';


// Get product ID
$productId = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);


// Invalid ID
if (!$productId) {

    header("Location: products.php");

    exit;

}


// Get product
$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$productId]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);


// Product doesn't exist
if (!$product) {

    header("Location: products.php");

    exit;

}


function money($price)
{
    return '$' . number_format($price, 2);
}


require_once '../includes/header.php';

?>

<main class="product-detail-page">

    <!-- Breadcrumb -->

    <div class="product-breadcrumb">
        <a href="products.php">
            Shop
        </a>

        <span>/</span>

        <span>
            <?php echo htmlspecialchars(
                $product['name']
            ); ?>
        </span>

    </div>


    <!-- Product -->

    <section class="product-detail">

        <!-- LEFT : IMAGE -->

        <div class="product-detail-image">

            <?php if (!empty($product['badge'])): ?>

                <span class="tag tag-ochre">

                    <?php echo htmlspecialchars(
                        $product['badge']
                    ); ?>

                </span>

            <?php endif; ?>


            <div class="product-detail-frame">

                <img
                    src="../images/products/<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                >

            </div>

        </div>


        <!-- RIGHT : INFORMATION -->

        <div class="product-detail-info">

            <span class="eyebrow">

                <?php echo htmlspecialchars(
                    $product['category']
                ); ?>

            </span>


            <h1>

                <?php echo htmlspecialchars(
                    $product['name']
                ); ?>

            </h1>


            <!-- Rating -->

            <div class="detail-rating">

                <span class="stars">

                    <?php

                    $rating =
                        (float)(
                            $product['rating'] ?? 0
                        );

                    for (
                        $star = 1;
                        $star <= 5;
                        $star++
                    ) {

                        echo $star <= floor($rating)
                            ? '★'
                            : '☆';

                    }

                    ?>

                </span>

                <span>

                    <?php echo number_format(
                        $rating,
                        1
                    ); ?>

                    ·

                    <?php echo (int)(
                        $product['reviews'] ?? 0
                    ); ?>

                    reviews

                </span>

            </div>


            <!-- Price -->

            <div class="detail-price">

                <span class="price">

                    <?php echo money(
                        $product['price']
                    ); ?>

                </span>


                <?php if (
                    !empty($product['compare_price'])
                ): ?>

                    <span class="price compare">

                        <?php echo money(
                            $product['compare_price']
                        ); ?>

                    </span>

                <?php endif; ?>

            </div>


            <!-- Description -->

            <div class="product-description">

                <p>

                    Designed for everyday use and made
                    with quality materials. A considered
                    piece that fits naturally into your
                    everyday collection.

                </p>

            </div>


            <!-- Quantity -->

            <div class="quantity-section">

                <span class="quantity-label">
                    Quantity
                </span>


                <div class="quantity-control">

                    <button
                        type="button"
                        id="quantityMinus"
                    >
                        −
                    </button>

                    <input
                        type="number"
                        id="quantity"
                        value="1"
                        min="1"
                        max="99"
                    >

                    <button
                        type="button"
                        id="quantityPlus"
                    >
                        +
                    </button>

                </div>

            </div>


            <!-- Add to Cart -->

            <button
                type="button"
                class="add-to-cart-btn"
                id="addToCart"
                data-product-id="<?php echo (int)$product['id']; ?>"
            >

                Add to Cart

            </button>


            <!-- Extra information -->

            <div class="product-info-list">

                <div>

                    <span>
                        Category
                    </span>

                    <strong>
                        <?php echo htmlspecialchars(
                            $product['category']
                        ); ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Shipping
                    </span>

                    <strong>
                        Free shipping over $75
                    </strong>

                </div>


                <div>

                    <span>
                        Returns
                    </span>

                    <strong>
                        30-day returns
                    </strong>

                </div>

            </div>

        </div>

    </section>

</main>
<script>

const quantity =
    document.getElementById('quantity');

const minus =
    document.getElementById('quantityMinus');

const plus =
    document.getElementById('quantityPlus');


minus.addEventListener('click', () => {

    let value =
        parseInt(quantity.value);

    if (value > 1) {

        quantity.value = value - 1;

    }

});


plus.addEventListener('click', () => {

    let value =
        parseInt(quantity.value);

    if (value < 99) {

        quantity.value = value + 1;

    }

});


quantity.addEventListener('change', () => {

    let value =
        parseInt(quantity.value);

    if (isNaN(value) || value < 1) {

        quantity.value = 1;

    }

    if (value > 99) {

        quantity.value = 99;

    }

});

</script>

<?php require_once '../includes/footer.php'; ?>