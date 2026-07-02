<?php
require_once 'config/database.php';
$data['news'] = $pdo->query("SELECT * FROM news ORDER BY is_headline DESC, date DESC, id DESC")->fetchAll();
?>
<?php include 'includes/header.php'; ?>

<!-- News Page Header -->
<section class="hero bbc-hero" id="hero" style="min-height: auto; padding-top: 140px; padding-bottom: 20px; background: transparent;">
    <div class="hero-content" style="max-width: 1200px; text-align: left; margin: 0 auto; padding: 0 20px;">
        <h1 class="bbc-page-title" style="font-family: 'Arial', sans-serif; font-size: 40px; font-weight: bold; color: var(--text-primary); margin: 0; border-bottom: 2px solid #B80000; padding-bottom: 10px; display: inline-block;">News</h1>
    </div>
</section>

<!-- News Grid Section -->
<section class="news-section bbc-news-container" id="news" style="padding-top: 20px; padding-bottom: 80px;">
    <div class="bbc-news-grid reveal" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <?php if(!empty($data['news'])): ?>
            <?php foreach($data['news'] as $index => $news): ?>
            <a href="<?= $base_url ?>news/<?= htmlspecialchars($news['slug'] ?? $news['id']) ?>.html" class="bbc-news-card <?= $index === 0 ? 'bbc-featured-story' : '' ?>">
                <?php if(!empty($news['image'])): ?>
                    <div class="bbc-img-wrapper">
                        <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="bbc-news-img">
                    </div>
                <?php endif; ?>
                <div class="bbc-news-content">
                    <h3 class="bbc-news-title"><?= htmlspecialchars($news['title']) ?></h3>
                    <p class="bbc-news-desc"><?= nl2br(htmlspecialchars($news['content'])) ?></p>
                    <span class="bbc-news-date"><?= htmlspecialchars($news['date']) ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--text-primary);">No news available at the moment. Check back later!</p>
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
