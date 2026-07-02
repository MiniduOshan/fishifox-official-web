<?php
require_once 'config/database.php';

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $pdo->prepare("SELECT * FROM news WHERE slug = ?");
    $stmt->execute([$slug]);
    $article = $stmt->fetch();
} else {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();
}

if (!$article) {
    header("Location: news");
    exit;
}
?>
<?php include 'includes/header.php'; ?>

<section class="article-section" style="padding: 120px 20px 80px; position: relative; z-index: 10;">
    <div style="max-width: 900px; margin: 0 auto; background: #ffffff; border-radius: 16px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); overflow: hidden; position: relative;">
        
        <?php if(!empty($article['image'])): ?>
            <div style="width: 100%; height: 450px; position: relative;">
                <img src="<?= strpos($article['image'], 'http') === 0 ? htmlspecialchars($article['image']) : $base_url . htmlspecialchars(ltrim($article['image'], '/')) ?>" alt="<?= htmlspecialchars($article['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 40%);"></div>
            </div>
        <?php endif; ?>

        <div style="padding: 50px 8%; position: relative;">
            <a href="<?= $base_url ?>news" style="color: #ef4444; text-decoration: none; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.95rem; margin-bottom: 25px; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s;"><i class="fa-solid fa-arrow-left"></i> Back to News</a>
            
            <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 700; color: #0f172a; margin: 0 0 15px; line-height: 1.15; letter-spacing: -1px;"><?= htmlspecialchars($article['title']) ?></h1>
            
            <div style="font-family: 'Inter', sans-serif; color: #64748b; font-size: 0.95rem; font-weight: 500; margin-bottom: 40px; padding-bottom: 25px; border-bottom: 1px solid #e2e8f0;">
                Published on <?= date('F j, Y', strtotime($article['date'])) ?>
            </div>
            
            <div class="article-content" style="font-family: 'Inter', sans-serif; font-size: 1.15rem; line-height: 1.8; color: #334155;">
                <p style="margin-bottom: 1.5rem;"><?= nl2br(htmlspecialchars($article['content'])) ?></p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
