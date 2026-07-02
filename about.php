<?php
require_once 'config/database.php';

$data = [];
$stmt = $pdo->query("SELECT * FROM settings");
while ($row = $stmt->fetch()) {
    $data[$row['setting_key']] = $row['setting_value'];
}
?>
<?php include 'includes/header.php'; ?>

<!-- About Page Header -->
<section class="hero bbc-hero" id="hero" style="min-height: auto; padding-top: 140px; padding-bottom: 20px; background: transparent;">
    <div class="hero-content" style="max-width: 1200px; text-align: left; margin: 0 auto; padding: 0 20px;">
        <h1 class="bbc-page-title" style="font-family: 'Arial', sans-serif; font-size: 40px; font-weight: bold; color: var(--text-primary); margin: 0; border-bottom: 2px solid #B80000; padding-bottom: 10px; display: inline-block;">About Us</h1>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="about-section parallax-section" id="about" style="text-align: center; padding-top: 50px; padding-bottom: 100px;">
    
    <div class="parallax-overlay"></div>
    <div class="parallax-content" style="padding-top: 40px;">
        <div class="section-header reveal">
            <p class="section-label" style="color: var(--primary-gold);">Our Purpose</p>
            <h2 class="section-title" style="color: var(--primary-light);">Vision & Mission</h2>
        </div>
        <div class="reveal glass-panel" style="max-width: 800px; margin: 0 auto; padding: 3rem; border-radius: 24px;">
            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-light);">Who We Are</h3>
            <p style="font-size: 1.15rem; line-height: 1.7; margin-bottom: 2.5rem; color: #f8fafc;">With a steadfast commitment to delivering top-tier web development, mobile app solutions, IT base research, and digital marketing services, we stand at the forefront of innovation in Sri Lanka’s IT industry.</p>

            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-light);">Our Vision</h3>
            <p style="font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem; color: #e2e8f0;"><?= nl2br(htmlspecialchars($data['vision'] ?? '')) ?></p>
            
            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-light);">Our Mission</h3>
            <p style="font-size: 1.1rem; line-height: 1.6; color: #e2e8f0;"><?= nl2br(htmlspecialchars($data['mission'] ?? '')) ?></p>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.to('.hero-title .line', { opacity: 1, y: 0, duration: 0.7, delay: 0.1 });
        gsap.to('.hero-description', { opacity: 1, y: 0, duration: 0.7, delay: 0.3 });
    });
</script>

<?php include 'includes/footer.php'; ?>
