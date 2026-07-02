<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$isHome = ($currentPage === 'index.php' || $currentPage === '');
$base = $isHome ? '' : '/';
?>
<nav class="nav">
    <a href="/" class="logo">
        <img src="assets/images/logo.png" alt="FishiFox Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <span class="logo-text" style="display:none; font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:24px; color:var(--text-primary); letter-spacing:1px;">FishiFox</span>
    </a>
    
    <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <ul class="nav-links" id="nav-links">
        <li><a href="services">Services</a></li>
        <li><a href="about">About</a></li>
        <li><a href="products">Products</a></li>
        <li><a href="news">News</a></li>
        <li><a href="#contact">Contact Us</a></li>

        <li class="mobile-cta">
            <a href="<?= $base ?>#services" class="nav-cta">Get Started</a>
        </li>
    </ul>

    <!-- Destop Button -->
    <a href="<?= $base ?>#services" class="nav-cta desktop-cta">
        Get Started
    </a>
</nav>