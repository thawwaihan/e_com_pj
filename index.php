<?php

require_once 'db.php';

$siteName = 'Everyday';

$cartCount = 0;

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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $siteName; ?> — Layer your everyday</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#16181c;
  --ink-soft:#22262c;
  --parchment:#f5f2ec;
  --parchment-2:#ece7dc;
  --line:#dad4c8;
  --ochre:#b8792e;
  --ochre-dark:#8f5c1f;
  --moss:#5c6b4f;
  --white:#fffdf9;
  --text:#1c1c1a;
  --text-muted:#6b6a63;

  --display: 'Anton', sans-serif;
  --body: 'Lora', serif;
  --mono: 'Space Mono', monospace;

  --fs-hero: clamp(3.2rem, 8vw, 8rem);
  --fs-h2: clamp(2rem, 4.5vw, 3.4rem);
  --fs-eyebrow: 0.78rem;

  --pad: clamp(1.25rem, 4vw, 4rem);
  --radius: 2px;
}

*{box-sizing:border-box; margin:0; padding:0;}
html{scroll-behavior:smooth;}
@media (prefers-reduced-motion: reduce){
  html{scroll-behavior:auto;}
  *{animation-duration:0.001ms !important; transition-duration:0.001ms !important;}
}

body{
  font-family:var(--body);
  background:var(--parchment);
  color:var(--text);
  line-height:1.5;
  overflow-x:hidden;
}

img{display:block; max-width:100%; height:auto;}
a{color:inherit; text-decoration:none;}
button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
ul{list-style:none;}

:focus-visible{
  outline: 3px solid var(--ochre);
  outline-offset: 3px;
}

.eyebrow{
  font-family:var(--mono);
  font-size:var(--fs-eyebrow);
  letter-spacing:0.18em;
  text-transform:uppercase;
  color:var(--ochre-dark);
  display:inline-flex;
  align-items:center;
  gap:0.6em;
}
.eyebrow::before{
  content:"";
  width:22px; height:1px;
  background:var(--ochre-dark);
  display:inline-block;
}

/* ---------------------------------------------------------
   SCROLL PROGRESS BAR
--------------------------------------------------------- */
#scroll-progress{
  position:fixed; top:0; left:0; height:3px; width:0%;
  background:var(--ochre);
  z-index:2000;
  transition:width 0.08s linear;
}

/* ---------------------------------------------------------
   NAV
--------------------------------------------------------- */
header.nav{
  position:fixed; top:0; left:0; right:0; z-index:1000;
  display:flex; align-items:center; justify-content:space-between;
  padding: 1.3rem var(--pad);
  background:transparent;
  transition: background 0.35s ease, padding 0.35s ease, box-shadow 0.35s ease;
}
header.nav.scrolled{
  background:rgba(245,242,236,0.92);
  backdrop-filter:blur(10px);
  padding: 0.85rem var(--pad);
  box-shadow:0 1px 0 var(--line);
}
.logo{
  font-family:var(--display);
  font-size:1.6rem;
  letter-spacing:0.04em;
  color:var(--ink);
}
header.nav.on-dark .logo,
header.nav.on-dark .nav-links a,
header.nav.on-dark .icon-btn{
  color:var(--parchment);
}
header.nav.scrolled.on-dark .logo,
header.nav.scrolled.on-dark .nav-links a,
header.nav.scrolled.on-dark .icon-btn{
  color:var(--ink);
}

.nav-links{
  display:flex; gap:2.4rem;
  font-family:var(--mono);
  font-size:0.78rem;
  letter-spacing:0.08em;
  text-transform:uppercase;
}
.nav-links a{position:relative; padding-bottom:4px;}
.nav-links a::after{
  content:""; position:absolute; left:0; bottom:0; height:1px; width:0;
  background:currentColor; transition:width 0.3s ease;
}
.nav-links a:hover::after{width:100%;}

.nav-right{display:flex; align-items:center; gap:1.3rem;}
.icon-btn{position:relative; display:flex; align-items:center;}
.cart-count{
  position:absolute; top:-8px; right:-10px;
  background:var(--ochre); color:var(--white);
  font-family:var(--mono); font-size:0.62rem;
  width:16px; height:16px; border-radius:50%;
  display:flex; align-items:center; justify-content:center;
}
.hamburger{display:none; flex-direction:column; gap:5px;}
.hamburger span{width:22px; height:2px; background:currentColor;}

@media (max-width: 860px){
  .nav-links{display:none;}
  .hamburger{display:flex;}
}

/* ---------------------------------------------------------
   HERO — layered "strata" parallax
--------------------------------------------------------- */
.hero{
  position:relative;
  min-height:100svh;
  display:flex; flex-direction:column; justify-content:center;
  background:var(--ink);
  color:var(--parchment);
  overflow:hidden;
  padding: 0 var(--pad);
}
.strata-lines{position:absolute; inset:0; z-index:0; pointer-events:none;}
.strata-lines span{
  position:absolute; left:-10%; width:120%; height:1px;
  background:rgba(245,242,236,0.09);
}
.hero-content{position:relative; z-index:2; max-width:1100px; margin:0 auto; width:100%; padding-top:5rem;}
.hero-eyebrow{color:var(--ochre); font-family:var(--mono); font-size:0.8rem; letter-spacing:0.2em; text-transform:uppercase;}
.hero h1{
  font-family:var(--display);
  font-size:var(--fs-hero);
  line-height:0.92;
  letter-spacing:0.01em;
  text-transform:uppercase;
  margin:1.1rem 0 1.6rem;
}
.hero h1 em{font-style:normal; color:var(--ochre);}
.hero p{
  max-width:520px;
  font-size:1.08rem;
  color:rgba(245,242,236,0.78);
  margin-bottom:2.4rem;
}
.hero-ctas{display:flex; gap:1rem; flex-wrap:wrap; align-items:center;}

.btn{
  font-family:var(--mono);
  font-size:0.78rem;
  letter-spacing:0.1em;
  text-transform:uppercase;
  padding:1rem 1.8rem;
  border:1px solid currentColor;
  transition:background 0.3s ease, color 0.3s ease, transform 0.2s ease;
  display:inline-block;
}
.btn-solid{background:var(--ochre); border-color:var(--ochre); color:var(--white);}
.btn-solid:hover{background:var(--ochre-dark); border-color:var(--ochre-dark); transform:translateY(-2px);}
.btn-outline{color:var(--parchment);}
.btn-outline:hover{background:var(--parchment); color:var(--ink); transform:translateY(-2px);}

.scroll-cue{
  position:absolute; bottom:2.2rem; left:var(--pad);
  z-index:2; display:flex; align-items:center; gap:0.7rem;
  font-family:var(--mono); font-size:0.68rem; letter-spacing:0.14em;
  color:rgba(245,242,236,0.6); text-transform:uppercase;
}
.scroll-cue .line{width:1px; height:34px; background:rgba(245,242,236,0.4); position:relative; overflow:hidden;}
.scroll-cue .line::after{
  content:""; position:absolute; top:-100%; left:0; width:100%; height:100%;
  background:var(--ochre); animation:cue 1.8s ease-in-out infinite;
}
@keyframes cue{ 50%{top:0;} 100%{top:100%;} }

/* ---------------------------------------------------------
   MARQUEE STRIP
--------------------------------------------------------- */
.marquee{
  background:var(--ochre); color:var(--white);
  overflow:hidden; white-space:nowrap;
  padding:0.7rem 0;
  border-bottom:1px solid var(--ink);
}
.marquee-track{display:inline-block; animation:scroll-left 26s linear infinite;}
.marquee span{
  font-family:var(--mono); font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase;
  margin-right:2.6rem;
}
@keyframes scroll-left{ from{transform:translateX(0);} to{transform:translateX(-50%);} }

/* ---------------------------------------------------------
   REVEAL ON SCROLL
--------------------------------------------------------- */
.reveal{opacity:0; transform:translateY(36px); transition:opacity 0.8s ease, transform 0.8s ease;}
.reveal.is-visible{opacity:1; transform:translateY(0);}
.reveal-stagger.is-visible{transition-delay:calc(var(--i, 0) * 90ms);}

/* ---------------------------------------------------------
   SECTION HEADERS
--------------------------------------------------------- */
.section{padding: clamp(4rem,8vw,7rem) var(--pad);}
.section-head{
  display:flex; justify-content:space-between; align-items:flex-end;
  gap:2rem; margin-bottom:3rem; flex-wrap:wrap;
}
.section-head h2{
  font-family:var(--display);
  font-size:var(--fs-h2);
  text-transform:uppercase;
  line-height:1;
  margin-top:0.5rem;
}
.section-head p{color:var(--text-muted); max-width:360px; font-size:0.95rem;}

/* ---------------------------------------------------------
   HANG-TAG price badge (signature motif)
--------------------------------------------------------- */
.tag{
  position:absolute; top:14px; left:14px; z-index:3;
  background:var(--parchment);
  border:1px solid var(--ink);
  padding:0.35rem 0.7rem 0.35rem 1.1rem;
  font-family:var(--mono); font-size:0.66rem; letter-spacing:0.08em;
  text-transform:uppercase;
  transform:rotate(-4deg);
  transition:transform 0.3s ease;
}
.tag::before{
  content:""; position:absolute; left:6px; top:50%; transform:translateY(-50%);
  width:5px; height:5px; border-radius:50%; border:1px solid var(--ink); background:var(--parchment);
}
.tag.tag-ochre{background:var(--ochre); color:var(--white); border-color:var(--ochre-dark);}
.tag.tag-ochre::before{border-color:var(--white); background:transparent;}

/* ---------------------------------------------------------
   NEW ARRIVALS — horizontal rail
--------------------------------------------------------- */
.rail-wrap{position:relative;}
.rail{
  display:flex; gap:1.4rem; overflow-x:auto; scroll-snap-type:x mandatory;
  padding-bottom:1.5rem; scrollbar-width:none;
}
.rail::-webkit-scrollbar{display:none;}
.rail .card{
  scroll-snap-align:start;
  flex:0 0 clamp(220px, 28vw, 300px);
}
.rail-controls{display:flex; gap:0.7rem; margin-top:1.5rem; justify-content:flex-end;}
.rail-btn{
  width:44px; height:44px; border:1px solid var(--ink); border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  transition:background 0.25s ease, color 0.25s ease;
}
.rail-btn:hover{background:var(--ink); color:var(--parchment);}

.card{position:relative;}
.card .frame{
  position:relative; overflow:hidden; background:var(--parchment-2);
  aspect-ratio: 4 / 5;
}
.card .frame img{
  width:100%; height:100%; object-fit:cover;
  transition:transform 0.7s cubic-bezier(.2,.7,.2,1), filter 0.7s ease;
}
.card:hover .frame img{transform:scale(1.06);}
.card:hover .tag{transform:rotate(0deg);}
.card .quick-add{
  position:absolute; left:0; right:0; bottom:0; z-index:3;
  background:var(--ink); color:var(--parchment);
  font-family:var(--mono); font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;
  text-align:center; padding:0.85rem;
  transform:translateY(100%);
  transition:transform 0.35s ease;
}
.card:hover .quick-add{transform:translateY(0);}
.card .meta{padding-top:0.9rem;}
.card .cat{font-family:var(--mono); font-size:0.66rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--text-muted);}
.card h3{font-family:var(--body); font-weight:600; font-size:1.02rem; margin:0.3rem 0 0.35rem;}
.price-row{display:flex; align-items:baseline; gap:0.6rem;}
.price{font-family:var(--mono); font-size:0.92rem;}
.price.compare{color:var(--text-muted); text-decoration:line-through; font-size:0.78rem;}

/* ---------------------------------------------------------
   BEST SELLERS — dark section, ranked grid
--------------------------------------------------------- */
.section-dark{background:var(--ink); color:var(--parchment);}
.section-dark .section-head p{color:rgba(245,242,236,0.6);}
.section-dark .eyebrow{color:var(--ochre);}
.section-dark .eyebrow::before{background:var(--ochre);}

.bs-grid{
  display:grid; grid-template-columns:repeat(4, 1fr); gap:1.6rem;
}
@media (max-width: 1080px){ .bs-grid{grid-template-columns:repeat(2,1fr);} }
@media (max-width: 560px){ .bs-grid{grid-template-columns:1fr;} }

.bs-card{position:relative;}
.rank-num{
  position:absolute; top:-0.6rem; left:-0.4rem; z-index:0;
  font-family:var(--display); font-size:5.5rem; line-height:1;
  color:rgba(245,242,236,0.08);
  pointer-events:none;
}
.bs-card .frame{
  position:relative; z-index:1; overflow:hidden; aspect-ratio:4/5;
  background:var(--ink-soft); border:1px solid rgba(245,242,236,0.12);
}
.bs-card .frame img{width:100%; height:100%; object-fit:cover; transition:transform 0.7s ease;}
.bs-card:hover .frame img{transform:scale(1.06);}
.bs-card .meta{padding-top:0.9rem; position:relative; z-index:1;}
.bs-card .cat{font-family:var(--mono); font-size:0.64rem; letter-spacing:0.1em; text-transform:uppercase; color:rgba(245,242,236,0.5);}
.bs-card h3{font-family:var(--body); font-weight:600; font-size:1rem; margin:0.3rem 0 0.4rem;}
.rating{font-family:var(--mono); font-size:0.72rem; color:rgba(245,242,236,0.65); display:flex; gap:0.5rem; align-items:center; margin-bottom:0.4rem;}
.stars{color:var(--ochre); letter-spacing:1px;}

/* ---------------------------------------------------------
   NEWSLETTER
--------------------------------------------------------- */
.newsletter{
  background:var(--parchment-2);
  padding: clamp(4rem,8vw,6rem) var(--pad);
  text-align:center;
  border-top:1px solid var(--line);
  border-bottom:1px solid var(--line);
}
.newsletter h2{
  font-family:var(--display); font-size:clamp(1.8rem,4vw,3rem);
  text-transform:uppercase; margin: 0.6rem 0 1rem;
}
.newsletter p{color:var(--text-muted); max-width:460px; margin:0 auto 2rem;}
.nl-form{display:flex; max-width:440px; margin:0 auto; border:1px solid var(--ink);}
.nl-form input{
  flex:1; border:none; background:transparent; padding:1rem 1.1rem;
  font-family:var(--body); font-size:0.95rem; color:var(--text);
}
.nl-form input:focus{outline:none;}
.nl-form button{
  background:var(--ink); color:var(--parchment);
  font-family:var(--mono); font-size:0.75rem; letter-spacing:0.1em; text-transform:uppercase;
  padding:0 1.5rem;
}
.nl-form button:hover{background:var(--ochre);}

/* ---------------------------------------------------------
   FOOTER
--------------------------------------------------------- */
footer{
  background:var(--ink); color:rgba(245,242,236,0.75);
  padding: 4rem var(--pad) 2rem;
}
.foot-grid{
  display:grid; grid-template-columns:1.4fr 1fr 1fr 1fr; gap:2.5rem;
  padding-bottom:3rem; border-bottom:1px solid rgba(245,242,236,0.14);
}
@media (max-width:760px){ .foot-grid{grid-template-columns:1fr 1fr;} }
.foot-grid .logo{color:var(--parchment); margin-bottom:0.8rem; display:block;}
.foot-grid p{font-size:0.88rem; max-width:260px; color:rgba(245,242,236,0.55);}
.foot-col h4{
  font-family:var(--mono); font-size:0.7rem; letter-spacing:0.12em; text-transform:uppercase;
  color:rgba(245,242,236,0.5); margin-bottom:1rem;
}
.foot-col ul li{margin-bottom:0.6rem; font-size:0.9rem;}
.foot-col ul li a:hover{color:var(--ochre);}
.foot-bottom{
  display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;
  padding-top:1.6rem; font-family:var(--mono); font-size:0.7rem; letter-spacing:0.05em; color:rgba(245,242,236,0.45);
}
</style>
</head>
<body>

<div id="scroll-progress"></div>

<header class="nav on-dark" id="siteNav">
  <a href="#" class="logo"><?php echo htmlspecialchars($siteName); ?></a>
  <nav class="nav-links">
    <a href="#home">Home</a>
    <a href="#new-arrivals">New Arrivals</a>
    <a href="#best-sellers">Best Sellers</a>
    <a href="#newsletter">Newsletter</a>
  </nav>
  <div class="nav-right">
    <button class="icon-btn" aria-label="Search">
      <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </button>
    <button class="icon-btn" aria-label="Cart">
      <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <span class="cart-count"><?php echo (int)$cartCount; ?></span>
    </button>
    <button class="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
  </div>
</header>

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
                src="images/products/<?php echo htmlspecialchars($p['image']); ?>"
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
    src="images/products/<?php echo htmlspecialchars($p['image']); ?>"
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

<!-- ============ FOOTER ============ -->
<footer>
  <div class="foot-grid">
    <div>
      <a href="#" class="logo"><?php echo htmlspecialchars($siteName); ?></a>
      <p>Considered goods for daily life — clothing, tableware and small objects, made to be layered and kept.</p>
    </div>
    <div class="foot-col">
      <h4>Shop</h4>
      <ul>
        <li><a href="#new-arrivals">New Arrivals</a></li>
        <li><a href="#best-sellers">Best Sellers</a></li>
        <li><a href="#">Home Goods</a></li>
        <li><a href="#">Apparel</a></li>
      </ul>
    </div>
    <div class="foot-col">
      <h4>Help</h4>
      <ul>
        <li><a href="#">Shipping</a></li>
        <li><a href="#">Returns</a></li>
        <li><a href="#">Size Guide</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
    <div class="foot-col">
      <h4>Company</h4>
      <ul>
        <li><a href="#">About</a></li>
        <li><a href="#">Journal</a></li>
        <li><a href="#">Careers</a></li>
      </ul>
    </div>
  </div>
  <div class="foot-bottom">
    <span>© <?php echo date("Y"); ?> <?php echo htmlspecialchars($siteName); ?>. All rights reserved.</span>
    <span>Built with PHP</span>
  </div>
</footer>

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
