<?php
$cartCount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Everyday— Layer your everyday</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div id="scroll-progress"></div>

<header class="nav on-dark" id="siteNav">
  <a href="#" class="logo">Everyday</a>
  <nav class="nav-links">
    <a href="index.php">Home</a>
    <a href="#new-arrivals">New Arrivals</a>
    <a href="#best-sellers">Best Sellers</a>
    <a href="#newsletter">Newsletter</a>
    <a href="contact.php">Contact</a>
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