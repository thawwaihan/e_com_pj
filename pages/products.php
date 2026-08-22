<?php

require_once '../database/db.php';
require_once '../includes/header.php';

$stmt = $pdo->prepare("
    SELECT *
    FROM products
    ORDER BY created_at DESC
");

$stmt->execute();

$products = $stmt->fetchAll();

function money($price)
{
    return '$' . number_format($price, 2);
}

?>

<!-- =====================================================
     SHOP PAGE
===================================================== -->

<main class="products-page">

    <!-- SHOP HEADER -->

    <section class="products-hero">

        <div>

            <span class="eyebrow">
                The Collection
            </span>

            <h1>
                Shop <em>everything.</em>
            </h1>

        </div>

        <p>
            Thoughtfully made pieces for everyday life.
            Browse the complete collection and find
            something worth keeping around.
        </p>

    </section>


    <!-- =================================================
         FILTER BAR
    ================================================= -->

    <section class="products-toolbar">

        <div class="products-count">

            <span id="productCount">
                <?php echo count($products); ?>
            </span>

            products

        </div>


        <div class="products-actions">

            <!-- SEARCH -->

            <div class="product-search">

                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                >

                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    />

                    <line
                        x1="21"
                        y1="21"
                        x2="16.65"
                        y2="16.65"
                    />

                </svg>

                <input
                    type="text"
                    id="productSearch"
                    placeholder="Search products..."
                >

            </div>


            <!-- CATEGORY -->

            <select id="categoryFilter">

                <option value="all">
                    All categories
                </option>

                <?php

                $categories = [];

                foreach ($products as $product) {

                    $category = $product['category'];

                    if (
                        !in_array(
                            $category,
                            $categories
                        )
                    ) {

                        $categories[] = $category;

                    }

                }

                foreach ($categories as $category):

                ?>

                    <option
                        value="<?php echo htmlspecialchars($category); ?>"
                    >

                        <?php echo htmlspecialchars($category); ?>

                    </option>

                <?php endforeach; ?>

            </select>


            <!-- SORT -->

            <select id="sortSelect">

                <option value="default">
                    Sort by
                </option>

                <option value="newest">
                    Newest
                </option>

                <option value="price-low">
                    Price: Low → High
                </option>

                <option value="price-high">
                    Price: High → Low
                </option>

                <option value="rating">
                    Highest Rated
                </option>

            </select>

        </div>

    </section>


    <!-- =================================================
         PRODUCT GRID
    ================================================= -->

    <section class="products-grid" id="productsGrid">

        

        <?php foreach ($products as $i => $p): ?>

<article
    class="card product-card"
    data-category="<?php echo htmlspecialchars($p['category']); ?>"
    data-name="<?php echo htmlspecialchars($p['name']); ?>"
    data-price="<?php echo $p['price']; ?>"
    data-rating="<?php echo $p['rating'] ?? 0; ?>"
    data-created="<?php echo htmlspecialchars($p['created_at']); ?>"
>

        <div class="frame">

            <?php if (!empty($p['badge'])): ?>

                <span class="tag tag-ochre">
                    <?php echo htmlspecialchars($p['badge']); ?>
                </span>

            <?php endif; ?>

            <a
    href="product-detail.php?id=<?php echo (int)$p['id']; ?>"
    class="product-link"
>
    <img
        src="../images/products/<?php echo htmlspecialchars($p['image']); ?>"
        alt="<?php echo htmlspecialchars($p['name']); ?>"
        loading="lazy"
    >
</a>

            <button
                type="button"
                class="quick-add"
                data-product-id="<?php echo (int)$p['id']; ?>"
            >
                + Quick Add
            </button>

        </div>

        <div class="meta">

            <span class="cat">
                <?php echo htmlspecialchars($p['category']); ?>
            </span>

            <h3>
                <a href="product-detail.php?id=<?php echo (int)$p['id']; ?>">
                    <?php echo htmlspecialchars($p['name']); ?>
                </a>
            </h3>

            <div class="rating">

                <span class="stars">

                    <?php

                    $rating = (float)($p['rating'] ?? 0);

                    for ($star = 1; $star <= 5; $star++) {
                        echo $star <= floor($rating)
                            ? '★'
                            : '☆';
                    }

                    ?>

                </span>

                <span>
                    <?php echo number_format($rating, 1); ?>
                    (<?php echo (int)($p['reviews'] ?? 0); ?>)
                </span>

            </div>

            <div class="price-row">

                <span class="price">
                    <?php echo money($p['price']); ?>
                </span>

                <?php if (!empty($p['compare_price'])): ?>

                    <span class="price compare">
                        <?php echo money($p['compare_price']); ?>
                    </span>

                <?php endif; ?>

            </div>

        </div>

    </article>

<?php endforeach; ?>
        <!-- NO RESULTS -->

        <div
            class="no-products"
            id="noProducts"
            style="display:none;"
        >

            <span class="eyebrow">
                Nothing found
            </span>

            <h2>
                No products match your search.
            </h2>

            <button
                type="button"
                id="clearFilters"
                class="btn btn-solid"
            >
                Clear filters
            </button>

        </div>

    </section>

</main>


<?php require_once '../includes/footer.php'; ?>
<script>
const searchInput =
    document.getElementById('productSearch');

const categoryFilter =
    document.getElementById('categoryFilter');

const sortSelect =
    document.getElementById('sortSelect');

const productGrid =
    document.getElementById('productsGrid');

const productCount =
    document.getElementById('productCount');

const noProducts =
    document.getElementById('noProducts');

const clearFilters =
    document.getElementById('clearFilters');


function getCards() {

    return [
        ...productGrid.querySelectorAll(
            '.product-card'
        )
    ];

}


function filterProducts() {

    const search =
        searchInput.value
            .toLowerCase()
            .trim();

    const category =
        categoryFilter.value;


    let visible = [];


    getCards().forEach(card => {

        const name =
            card.dataset.name
                .toLowerCase();

        const cardCategory =
            card.dataset.category;


        const matchesSearch =
            name.includes(search);

        const matchesCategory =
            category === 'all' ||
            cardCategory === category;


        if (
            matchesSearch &&
            matchesCategory
        ) {

            card.style.display = '';

            visible.push(card);

        } else {

            card.style.display = 'none';

        }

    });


    productCount.textContent =
        visible.length;


    noProducts.style.display =
        visible.length === 0
            ? 'block'
            : 'none';

}


function sortProducts() {

    const sort =
        sortSelect.value;

    const cards =
        getCards();


    if (sort === 'default') {

        return;

    }


    cards.sort((a, b) => {

        if (sort === 'price-low') {

            return (
                parseFloat(a.dataset.price) -
                parseFloat(b.dataset.price)
            );

        }


        if (sort === 'price-high') {

            return (
                parseFloat(b.dataset.price) -
                parseFloat(a.dataset.price)
            );

        }


        if (sort === 'rating') {

            return (
                parseFloat(b.dataset.rating) -
                parseFloat(a.dataset.rating)
            );

        }


        if (sort === 'newest') {

            return (
                new Date(b.dataset.created) -
                new Date(a.dataset.created)
            );

        }

    });


    cards.forEach(card => {

        productGrid.appendChild(card);

    });


    // Keep no-results message at the bottom

    productGrid.appendChild(noProducts);

}


searchInput.addEventListener(
    'input',
    filterProducts
);

categoryFilter.addEventListener(
    'change',
    filterProducts
);

sortSelect.addEventListener(
    'change',
    sortProducts
);


clearFilters.addEventListener(
    'click',
    () => {

        searchInput.value = '';

        categoryFilter.value = 'all';

        sortSelect.value = 'default';

        filterProducts();

    }
);
</script>