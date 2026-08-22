<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Everyday — Contact</title>
  
  <!-- Fonts: Anton for Impactful Headers, Space Mono for Technical Accent, Inter for Body -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@300;400;500;600&family=Playfair+Display:ital@1&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-dark: #121314;
      --bg-card: #18191b;
      --bg-input: #0e0f10;
      --text-white: #f4f4f2;
      --text-muted: #8e9095;
      --accent-ochre: #b5813e;
      --accent-ochre-hover: #c9934a;
      --border-color: rgba(255, 255, 255, 0.12);
      --font-display: 'Anton', sans-serif;
      --font-serif: 'Playfair Display', serif;
      --font-mono: 'Space Mono', monospace;
      --font-body: 'Inter', sans-serif;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: var(--bg-dark);
      color: var(--text-white);
      font-family: var(--font-body);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    /* --- Navigation Bar --- */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.75rem 4rem;
      border-bottom: 1px solid var(--border-color);
      background-color: var(--bg-dark);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .brand-logo {
      font-family: var(--font-serif);
      font-size: 1.85rem;
      font-style: italic;
      color: var(--text-white);
      text-decoration: none;
      letter-spacing: -0.5px;
    }

    .nav-links {
      display: flex;
      gap: 2.5rem;
      list-style: none;
    }

    .nav-links a {
      font-family: var(--font-mono);
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--text-muted);
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.14em;
      transition: color 0.2s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: var(--text-white);
    }

    .nav-icons {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .icon-btn {
      background: none;
      border: none;
      color: var(--text-white);
      cursor: pointer;
      display: flex;
      align-items: center;
      position: relative;
    }

    .cart-badge {
      font-family: var(--font-mono);
      font-size: 0.65rem;
      position: absolute;
      top: -6px;
      right: -8px;
      background-color: var(--accent-ochre);
      color: #fff;
      padding: 1px 5px;
      border-radius: 999px;
      font-weight: bold;
    }

    /* --- Page Container --- */
    .main-wrapper {
      max-width: 1400px;
      margin: 0 auto;
      padding: 4rem 4rem 6rem;
    }

    /* Sub-header / Meta Tag */
    .section-tag {
      font-family: var(--font-mono);
      font-size: 0.8rem;
      color: var(--accent-ochre);
      letter-spacing: 0.2em;
      text-transform: uppercase;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .section-tag::before {
      content: "";
      display: inline-block;
      width: 24px;
      height: 1.5px;
      background-color: var(--accent-ochre);
    }

    /* Title Layout */
    .page-header {
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 3.5rem;
      margin-bottom: 4rem;
    }

    .page-title {
      font-family: var(--font-display);
      font-size: clamp(3.5rem, 8vw, 7.5rem);
      line-height: 0.95;
      text-transform: uppercase;
      letter-spacing: 0.02em;
    }

    .page-title span {
      color: var(--accent-ochre);
      display: block;
    }

    /* --- Contact Grid --- */
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1.3fr;
      gap: 5rem;
    }

    /* Info Column */
    .info-column {
      display: flex;
      flex-direction: column;
      gap: 3rem;
    }

    .info-desc {
      font-family: var(--font-mono);
      color: var(--text-muted);
      font-size: 0.95rem;
      line-height: 1.8;
      max-width: 480px;
    }

    .info-list {
      display: flex;
      flex-direction: column;
      gap: 2rem;
      border-top: 1px solid var(--border-color);
      padding-top: 2rem;
    }

    .info-item h4 {
      font-family: var(--font-mono);
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--accent-ochre);
      margin-bottom: 0.4rem;
    }

    .info-item p, 
    .info-item a {
      color: var(--text-white);
      font-size: 1.1rem;
      text-decoration: none;
      font-weight: 300;
      transition: color 0.2s;
    }

    .info-item a:hover {
      color: var(--accent-ochre);
    }

    /* Form Column */
    .form-column {
      background-color: var(--bg-card);
      padding: 3rem;
      border: 1px solid var(--border-color);
    }

    .form-group {
      margin-bottom: 2rem;
    }

    .form-group label {
      display: block;
      font-family: var(--font-mono);
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--text-muted);
      margin-bottom: 0.75rem;
    }

    .form-control {
      width: 100%;
      background-color: var(--bg-input);
      border: 1px solid var(--border-color);
      color: var(--text-white);
      padding: 1rem 1.25rem;
      font-family: var(--font-mono);
      font-size: 0.9rem;
      transition: all 0.25s ease;
      outline: none;
    }

    .form-control:focus {
      border-color: var(--accent-ochre);
      box-shadow: 0 0 0 1px var(--accent-ochre);
    }

    .form-control::placeholder {
      color: #4a4d52;
    }

    textarea.form-control {
      resize: vertical;
      min-height: 140px;
    }

    /* Category Selector / Radio Chips */
    .topic-selector {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
      gap: 0.75rem;
      margin-top: 0.5rem;
    }

    .topic-chip input {
      display: none;
    }

    .topic-chip label {
      display: block;
      padding: 0.75rem 1rem;
      background: var(--bg-input);
      border: 1px solid var(--border-color);
      color: var(--text-muted);
      font-family: var(--font-mono);
      font-size: 0.75rem;
      text-align: center;
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin: 0;
      transition: all 0.2s ease;
    }

    .topic-chip input:checked + label {
      border-color: var(--accent-ochre);
      background-color: var(--accent-ochre);
      color: #fff;
      font-weight: 700;
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      padding: 1.25rem 2rem;
      background-color: var(--accent-ochre);
      color: #ffffff;
      border: none;
      font-family: var(--font-mono);
      font-size: 0.85rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      cursor: pointer;
      transition: background-color 0.2s ease, transform 0.1s ease;
      margin-top: 1rem;
    }

    .btn-submit:hover {
      background-color: var(--accent-ochre-hover);
    }

    .btn-submit:active {
      transform: scale(0.99);
    }

    /* Response Feedback Box */
    .form-status {
      display: none;
      padding: 1rem;
      margin-top: 1.5rem;
      font-family: var(--font-mono);
      font-size: 0.85rem;
      text-align: center;
      border: 1px solid;
    }
    .form-status.success {
      display: block;
      background: rgba(181, 129, 62, 0.1);
      border-color: var(--accent-ochre);
      color: var(--accent-ochre);
    }

    /* --- Responsive Breakpoints --- */
    @media (max-width: 1024px) {
      .navbar {
        padding: 1.5rem 2rem;
      }
      .main-wrapper {
        padding: 3rem 2rem 5rem;
      }
      .contact-grid {
        grid-template-columns: 1fr;
        gap: 3.5rem;
      }
      .form-column {
        padding: 2rem;
      }
    }

    @media (max-width: 640px) {
      .nav-links {
        display: none; /* Hide for simple mobile view */
      }
      .page-title {
        font-size: 3.5rem;
      }
      .topic-selector {
        grid-template-columns: 1fr 1fr;
      }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <a href="#" class="brand-logo">Everyday</a>
    
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">Shop</a></li>
      <li><a href="#">Best Sellers</a></li>
      <li><a href="#">Newsletter</a></li>
      <li><a href="#" class="active">Contact</a></li>
    </ul>

    <div class="nav-icons">
      <!-- Search Icon -->
      <button class="icon-btn" aria-label="Search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </button>

      <!-- Cart Icon -->
      <button class="icon-btn" aria-label="Shopping Cart">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <path d="M16 10a4 4 0 0 1-8 0"></path>
        </svg>
        <span class="cart-badge">0</span>
      </button>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-wrapper">
    <div class="page-header">
      <div class="section-tag">Direct Line &bull; SS26 Inquiries</div>
      <h1 class="page-title">
        Reach Out To
        <span>Everyday.</span>
      </h1>
    </div>

    <div class="contact-grid">
      <!-- Left: Brand Info & Support Details -->
      <section class="info-column">
        <p class="info-desc">
          Considered support for considered goods &mdash; whether you have an inquiry regarding order dispatches, custom sizing, or press relations.
        </p>

        <div class="info-list">
          <div class="info-item">
            <h4>Customer Support</h4>
            <a href="mailto:support@everydaygoods.com">support@everydaygoods.com</a>
          </div>

          <div class="info-item">
            <h4>Studio & Showroom</h4>
            <p>742 Evergreen Terrace, Sector 4<br/>Mon &mdash; Fri, 09:00 &mdash; 18:00</p>
          </div>

          <div class="info-item">
            <h4>Press & Wholesales</h4>
            <a href="mailto:press@everydaygoods.com">press@everydaygoods.com</a>
          </div>
        </div>
      </section>

      <!-- Right: Contact Form -->
      <section class="form-column">
        <form id="contactForm">
          <div class="form-group">
            <label>Inquiry Topic</label>
            <div class="topic-selector">
              <div class="topic-chip">
                <input type="radio" id="orders" name="topic" value="Orders" checked>
                <label for="orders">Orders</label>
              </div>
              <div class="topic-chip">
                <input type="radio" id="returns" name="topic" value="Returns">
                <label for="returns">Returns</label>
              </div>
              <div class="topic-chip">
                <input type="radio" id="general" name="topic" value="General">
                <label for="general">General</label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="fullName">Your Name</label>
            <input type="text" id="fullName" class="form-control" placeholder="e.g. Alex Morgan" required />
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" class="form-control" placeholder="you@email.com" required />
          </div>

          <div class="form-group">
            <label for="orderNumber">Order Number (Optional)</label>
            <input type="text" id="orderNumber" class="form-control" placeholder="#ED-2026-XXXX" />
          </div>

          <div class="form-group">
            <label for="message">Your Message</label>
            <textarea id="message" class="form-control" placeholder="Describe your inquiry with detail..." required></textarea>
          </div>

          <button type="submit" class="btn-submit">Dispatch Message</button>
          
          <div id="formStatus" class="form-status">
            Message received. Our studio team will get back to you within 24 hours.
          </div>
        </form>
      </section>
    </div>
  </main>

  <script>
    // Form Interaction Handling
    const contactForm = document.getElementById('contactForm');
    const formStatus = document.getElementById('formStatus');

    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      
      const submitBtn = contactForm.querySelector('.btn-submit');
      const originalText = submitBtn.textContent;
      
      // UX State Changes
      submitBtn.textContent = 'Transmitting...';
      submitBtn.disabled = true;

      setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        formStatus.classList.add('success');
        contactForm.reset();
      }, 900);
    });
  </script>
</body>
</html>