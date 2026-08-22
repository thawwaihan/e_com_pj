
<?php 
require_once '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | Dress & Fashion Boutique</title>
  <!-- Google Fonts & Font Awesome Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/contact.css">

  
</head>
<body>

  <div class="contact-container">
    
    <!-- Left Column: Contact Info Section -->
    <div>
      <div class="section-title">Contact Info Section</div>
      <div class="glass-card info-card">
        <div>
          <h1>Get in Touch</h1>
          <p class="description">
            Have questions about custom sizing, bespoke tailoring, or your recent dress order? Our boutique styling team is here to assist you.
          </p>

          <ul class="contact-list">
            <li class="contact-item">
              <i class="fa-regular fa-envelope"></i>
              <a href="mailto:support@yourbrand.com">support@yourbrand.com</a>
            </li>
            <li class="contact-item">
              <i class="fa-solid fa-location-dot"></i>
              <span>452 Fashion Avenue, Suite 10, New York, NY</span>
            </li>
            <li class="contact-item">
              <i class="fa-solid fa-phone"></i>
              <a href="tel:+1234567890">+1 (800) 555-DRESS</a>
            </li>
          </ul>
        </div>

        <div class="store-hours">
          <h4>Boutique Hours</h4>
          <p>Mon – Sat: 10:00 AM – 7:00 PM EST</p>
          <p>Sunday: By Appointment Only</p>
        </div>
      </div>
    </div>

    <!-- Right Column: Contact Form -->
    <div>
      <div class="section-title">Contact Form</div>
      <div class="glass-card">
        <form id="clothingContactForm" onsubmit="event.preventDefault(); alert('Message sent successfully!');">
          
          <div class="form-group">
            <input type="text" id="fullName" placeholder="Your Name *" required>
          </div>

          <div class="form-group">
            <input type="email" id="email" placeholder="Email Address *" required>
          </div>

          <div class="form-group">
            <select id="inquiryType">
              <option value="" disabled selected>Inquiry Type (Optional)</option>
              <option value="order">Order & Shipping Status</option>
              <option value="custom">Custom Dress / Tailoring Request</option>
              <option value="sizing">Sizing & Fit Advice</option>
              <option value="returns">Returns & Exchanges</option>
            </select>
          </div>

          <div class="form-group">
            <input type="text" id="orderId" placeholder="Order ID (Optional)">
          </div>

          <div class="form-group">
            <textarea id="message" placeholder="Write your message..." required></textarea>
          </div>

          <button type="submit" class="btn-submit">Send Message</button>
        </form>
      </div>
    </div>

  </div>

</body>
</html>