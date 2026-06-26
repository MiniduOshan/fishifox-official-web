<?php
// Identify current path location logic to append an .active layout class natively
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<nav class="nav">
    <a href="index.php" class="logo">
        <img src="assets/images/logo.png" alt="FishiFox Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <span class="logo-text" style="display:none; font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:24px; color:var(--text-primary); letter-spacing:1px;">FishiFox</span>
    </a>
    <ul class="nav-links">
        <li><a href="services.php" class="<?php echo ($currentPage == 'services.php') ? 'active' : ''; ?>">Services</a></li>
        <li><a href="index.php#tools" class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Tools</a></li>
        <li><a href="portfolio.php" class="<?php echo ($currentPage == 'portfolio.php') ? 'active' : ''; ?>">Portfolio</a></li>
        <li><a href="about.php" class="<?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>">Process</a></li>
        <li><a href="about.php#clients" class="">Clients</a></li>
        <li><a href="index.php#faq" class="">FAQ</a></li>
        <li><a href="contact.php" class="<?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
    </ul>
    <a href="contact.php" class="nav-cta">Get Started</a>
</nav>