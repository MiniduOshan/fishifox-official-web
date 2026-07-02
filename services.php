<?php
require_once 'config/database.php';

$data['services'] = $pdo->query("SELECT * FROM services")->fetchAll();
?>
<?php include 'includes/header.php'; ?>

<!-- Services Page Header -->
<section class="hero bbc-hero" id="hero" style="min-height: auto; padding-top: 140px; padding-bottom: 20px; background: transparent;">
    <div class="hero-content" style="max-width: 1200px; text-align: left; margin: 0 auto; padding: 0 20px;">
        <h1 class="bbc-page-title" style="font-family: 'Arial', sans-serif; font-size: 40px; font-weight: bold; color: var(--text-primary); margin: 0; border-bottom: 2px solid #B80000; padding-bottom: 10px; display: inline-block;">Our Services</h1>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services" style="padding-top: 50px; padding-bottom: 100px;">
    <div class="section-header reveal">
        <p class="section-label">What We Do</p>
        <h2 class="section-title">We Specialize In</h2>
        <p class="section-desc">Transforming your digital presence with cutting-edge solutions tailored to your unique needs.</p>
    </div>
    <div class="services-grid">
        <?php if(!empty($data['services'])): ?>
            <?php foreach($data['services'] as $service): ?>
            <div class="service-card reveal">
                <?php if(!empty($service['image'])): ?>
                    <img src="<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['title']) ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                <?php elseif(!empty($service['icon'])): ?>
                    <div class="service-icon">
                        <i class="<?= htmlspecialchars($service['icon']) ?>"></i>
                    </div>
                <?php endif; ?>
                <h3 class="service-title"><?= htmlspecialchars($service['title']) ?></h3>
                <p class="service-desc"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                <a href="/#contact" class="service-link">Get Quote →</a>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--text-primary);">No services available.</p>
        <?php endif; ?>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.to('.hero-title .line', { opacity: 1, y: 0, duration: 0.7, delay: 0.1 });
        gsap.to('.hero-description', { opacity: 1, y: 0, duration: 0.7, delay: 0.3 });
    });
</script>

<?php include 'includes/footer.php'; ?>
