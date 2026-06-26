<?php
$dataFile = 'data/content.json';
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
}
?>
<?php include 'includes/header.php'; ?>

<!-- News Page Header -->
<section class="hero" id="hero" style="min-height: 50vh; align-items: flex-end; padding-bottom: 50px;">
    <div class="hero-content">
        <h1 class="hero-title" style="font-size: clamp(32px, 5vw, 60px);">
            <span class="line">Latest Updates</span>
        </h1>
        <p class="hero-description">Stay up-to-date with the latest news, announcements, and insights from FishiFox.</p>
    </div>
</section>

<!-- News Grid Section -->
<section class="news-section" id="news" style="padding-top: 0;">
    <div class="news-grid reveal" style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <?php if(!empty($data['news'])): ?>
            <?php foreach($data['news'] as $news): ?>
            <div class="news-card" style="background: var(--glass-bg); backdrop-filter: blur(20px); border: 1px solid var(--glass-border); padding: 2rem; border-radius: 12px; width: 350px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                <?php if(!empty($news['image'])): ?>
                    <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                <?php endif; ?>
                <span class="news-date" style="color: var(--primary-light); font-size: 0.9rem; font-weight: bold;"><?= htmlspecialchars($news['date']) ?></span>
                <h3 class="news-title" style="margin: 1rem 0; font-size: 1.25rem; font-family: 'Space Grotesk', sans-serif;"><?= htmlspecialchars($news['title']) ?></h3>
                <p class="news-desc" style="color: var(--text-secondary); flex: 1; line-height: 1.6;"><?= htmlspecialchars($news['content']) ?></p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news available at the moment. Check back later!</p>
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
