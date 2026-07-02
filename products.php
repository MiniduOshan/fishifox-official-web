<?php
require_once 'config/database.php';
$data['projects'] = $pdo->query("SELECT * FROM projects")->fetchAll();
?>
<?php include 'includes/header.php'; ?>

<!-- Products Page Header -->
<section class="hero bbc-hero" id="hero" style="min-height: auto; padding-top: 140px; padding-bottom: 20px; background: transparent;">
    <div class="hero-content" style="max-width: 1200px; text-align: left; margin: 0 auto; padding: 0 20px;">
        <h1 class="bbc-page-title" style="font-family: 'Arial', sans-serif; font-size: 40px; font-weight: bold; color: var(--text-primary); margin: 0; border-bottom: 2px solid #B80000; padding-bottom: 10px; display: inline-block;">Products & Case Studies</h1>
    </div>
</section>

<!-- Products Grid Section -->
<section class="portfolio-section" id="portfolio" style="padding-top: 20px; padding-bottom: 80px;">
    <div class="portfolio-layout-wrapper" style="display: block; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="portfolio-grid-mask" style="width: 100%;">
            <div class="portfolio-grid-side" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                <?php if(!empty($data['projects'])): ?>
                <?php foreach($data['projects'] as $project): ?>
                <?php 
                    $hasUrl = !empty($project['url']);
                    $urlAttr = $hasUrl ? 'href="' . htmlspecialchars($project['url']) . '" target="_blank" style="text-decoration: none; color: inherit; display: block;"' : 'style="display: block;"';
                    $tag = $hasUrl ? 'a' : 'div';
                ?>
                <<?= $tag ?> <?= $urlAttr ?> class="portfolio-card reveal" style="width: 100%;">
                    <?php if(!empty($project['image'])): ?>
                        <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    <?php else: ?>
                        <div class="portfolio-img-placeholder" style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; background: #333; font-size: 3rem; border-radius: 8px 8px 0 0;"><?= htmlspecialchars($project['icon'] ?? '📁') ?></div>
                    <?php endif; ?>
                    <div class="portfolio-content" style="padding: 20px;">
                        <span class="portfolio-tag" style="display: inline-block; padding: 5px 10px; background: rgba(184,0,0,0.1); color: #B80000; font-size: 0.8rem; border-radius: 4px; margin-bottom: 10px;">Product</span>
                        <h3 class="portfolio-title" style="margin-bottom: 10px; font-size: 1.2rem;"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="portfolio-desc" style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.5;"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                    </div>
                </<?= $tag ?>>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--text-primary);">No projects available.</p>
            <?php endif; ?>
            </div>
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
