<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$isHome = ($currentPage === 'index.php' || $currentPage === '');
$base = $isHome ? '' : 'index';
?>
<nav class="nav">
    <a href="index" class="logo">
        <img src="assets/images/logo.png" alt="FishiFox Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <span class="logo-text" style="display:none; font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:24px; color:var(--text-primary); letter-spacing:1px;">FishiFox</span>
    </a>
    <ul class="nav-links">
        <li><a href="<?= $base ?>#services">Services</a></li>
        <li><a href="<?= $base ?>#about">About</a></li>
        <li><a href="<?= $base ?>#portfolio">Portfolio</a></li>
        <li><a href="news" class="<?= $currentPage === 'news.php' ? 'active' : '' ?>">News</a></li>
        <li><a href="<?= $base ?>#clients">Clients</a></li>
        <li><a href="faq" class="<?= $currentPage === 'faq.php' ? 'active' : '' ?>">FAQ</a></li>
    </ul>
    <a href="<?= $base ?>#contact" class="nav-cta">Get Started</a>
</nav>