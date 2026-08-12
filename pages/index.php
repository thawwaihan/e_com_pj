<?php

require_once '../database/db.php';
require_once '../includes/header.php';

// New arrivals
$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE is_new = 1
    ORDER BY created_at DESC
");

$stmt->execute();

$newArrivals = $stmt->fetchAll();

$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE is_best_seller = 1
    ORDER BY rating DESC
    LIMIT 4
");

$stmt->execute();

$bestSellers = $stmt->fetchAll();

function money($price)
{
    return '$' . number_format($price, 2);
}

?>

<!-- ============ HERO ============ -->
<section class="hero" id="home">
  <div class="strata-lines" id="strataLines"></div>
  <div class="hero-content">
    <p class="hero-eyebrow">Goods for the everyday · SS26</p>
    <h1>Layer your<br><em>everyday</em></h1>
    <p>Considered clothing, tableware and small objects — built to be added to, worn in, and kept around. New drops land weekly.</p>
    <div class="hero-ctas">
      <a href="#new-arrivals" class="btn btn-solid">Shop New Arrivals</a>
      <a href="#best-sellers" class="btn btn-outline">See Best Sellers</a>
    </div>
  </div>
  <div class="scroll-cue"><span class="line"></span> Scroll</div>
</section>

<div class="marquee">
  <div class="marquee-track">
    <span class="marquee-track" style="display:inline;">
      <?php for ($i=0; $i<2; $i++): ?>
        <span>Free shipping over $75</span>
        <span>New drops every Friday</span>
        <span>30-day returns</span>
        <span>Made to last</span>
      <?php endfor; ?>
    </span>
  </div>
</div>

<!-- ============ NEW ARRIVALS ============ -->
<section class="section" id="new-arrivals">
  <div class="section-head reveal">
    <div>
      <span class="eyebrow">Just Landed</span>
      <h2>New Arrivals</h2>
    </div>
    <p>Fresh from the workshop — small batches, restocked rarely. Browse the newest additions to the shelf.</p>
  </div>

  <div class="rail-wrap">
    <div class="rail" id="rail">
      <?php foreach ($newArrivals as $i => $p): ?>

    <article
        class="card reveal reveal-stagger"
        style="--i: <?php echo $i; ?>"
    >

        <div class="frame">

            <?php if (!empty($p['badge'])): ?>
                <span class="tag tag-ochre">
                    <?php echo htmlspecialchars($p['badge']); ?>
                </span>
            <?php endif; ?>

            <img
                src="../images/products/<?php echo htmlspecialchars($p['image']); ?>"
                alt="<?php echo htmlspecialchars($p['name']); ?>"
                loading="lazy"
            >

            <button class="quick-add">
                + Quick Add
            </button>

        </div>

        <div class="meta">

            <span class="cat">
                <?php echo htmlspecialchars($p['category']); ?>
            </span>

            <h3>
                <?php echo htmlspecialchars($p['name']); ?>
            </h3>

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
    </div>

    <div class="rail-controls">
      <button class="rail-btn" id="railPrev" aria-label="Scroll left">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button class="rail-btn" id="railNext" aria-label="Scroll right">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
      </button>
    </div>
  </div>
</section>

<!-- ============ BEST SELLERS ============ -->
<section class="section section-dark" id="best-sellers">
  <div class="section-head reveal">
    <div>
      <span class="eyebrow">Ranked by sales, this month</span>
      <h2>Best Sellers</h2>
    </div>
    <p>The four pieces everyone keeps coming back for — ranked by units sold, updated monthly.</p>
  </div>

  <div class="bs-grid">
    <?php foreach ($bestSellers as $i => $p): ?>
      <article class="bs-card reveal reveal-stagger" style="--i:<?php echo $i; ?>">
        <span class="rank-num">0<?php echo (int)$p['rating'];?></span>
        
        <div class="frame">
            <img
    src="../images/products/<?php echo htmlspecialchars($p['image']); ?>"
    alt="<?php echo htmlspecialchars($p['name']); ?>"
    loading="lazy"
>
        </div>
        <div class="meta">
          <span class="cat"><?php echo htmlspecialchars($p['category']); ?></span>
          <h3><?php echo htmlspecialchars($p['name']); ?></h3>
          <div class="rating">
    <span class="stars">
        <?php
        $rating = (float)($p['rating'] ?? 0);

        for ($i = 1; $i <= 5; $i++) {
            echo $i <= floor($rating) ? '★' : '☆';
        }
        ?>
    </span>

    <span>
        <?php echo number_format($rating, 1); ?>
        (<?php echo (int)($p['reviews'] ?? 0); ?>)
    </span>
</div>
          <div class="price-row">
            <span class="price"><?php echo money($p['price']); ?></span>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="newsletter reveal" id="newsletter">
  <span class="eyebrow">Stay stocked</span>
  <h2>Get first access to new drops</h2>
  <p>One email a week — new arrivals, restocks, and the occasional discount. No noise.</p>
  <form class="nl-form" onsubmit="event.preventDefault(); this.querySelector('button').textContent='Subscribed ✓';">
    <input type="email" placeholder="you@email.com" required aria-label="Email address">
    <button type="submit">Subscribe</button>
  </form>
</section>
<?php require_once '../includes/footer.php'; ?>
<script>
const nav = document.getElementById('siteNav');
const hero = document.getElementById('home');
function handleNav(){
  const heroH = hero.offsetHeight;
  const y = window.scrollY;
  nav.classList.toggle('scrolled', y > 40);
  nav.classList.toggle('on-dark', y < heroH - 90);
}
document.addEventListener('scroll', handleNav, { passive:true });
handleNav();

const progress = document.getElementById('scroll-progress');
function handleProgress(){
  const h = document.documentElement;
  const scrolled = h.scrollTop;
  const height = h.scrollHeight - h.clientHeight;
  progress.style.width = (height > 0 ? (scrolled / height) * 100 : 0) + '%';
}
document.addEventListener('scroll', handleProgress, { passive:true });
handleProgress();

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
if (reduceMotion) {
  document.querySelectorAll('.reveal').forEach(el => el.classList.add('is-visible'));
} else {
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));
}

const strataWrap = document.getElementById('strataLines');
const LINE_COUNT = 7;
for (let i = 0; i < LINE_COUNT; i++) {
  const line = document.createElement('span');
  line.style.top = (12 + i * 13) + '%';
  line.dataset.speed = (0.1 + i * 0.04).toFixed(2);
  strataWrap.appendChild(line);
}
const strataLines = strataWrap.querySelectorAll('span');
function handleParallax(){
  if (reduceMotion) return;
  const y = window.scrollY;
  strataLines.forEach(line => {
    const speed = parseFloat(line.dataset.speed);
    line.style.transform = `translateY(${y * speed}px)`;
  });
}
document.addEventListener('scroll', handleParallax, { passive:true });

const rail = document.getElementById('rail');
const railPrev = document.getElementById('railPrev');
const railNext = document.getElementById('railNext');
function railScrollAmount(){
  const card = rail.querySelector('.card');
  return card ? card.getBoundingClientRect().width + 22 : 300;
}
railNext.addEventListener('click', () => rail.scrollBy({ left: railScrollAmount(), behavior:'smooth' }));
railPrev.addEventListener('click', () => rail.scrollBy({ left: -railScrollAmount(), behavior:'smooth' }));

const cartBadge = document.querySelector('.cart-count');
document.querySelectorAll('.quick-add').forEach(btn => {
  btn.addEventListener('click', () => {
    cartBadge.textContent = (parseInt(cartBadge.textContent, 10) + 1);
  });
});
</script>

</body>
</html>
