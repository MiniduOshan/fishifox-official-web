<?php
$dataFile = 'data/content.json';
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
}
?>
<?php include 'includes/header.php'; ?>

<!-- FAQ Page Header -->
<section class="hero" id="hero" style="min-height: 50vh; align-items: flex-end; padding-bottom: 50px;">
    <div class="hero-content">
        <h1 class="hero-title" style="font-size: clamp(32px, 5vw, 60px);">
            <span class="line">Frequently Asked</span>
            <span class="line">Questions</span>
        </h1>
        <p class="hero-description">Find answers to common questions about our services, processes, and expertise.</p>
    </div>
</section>

<!-- Accordion Hub Module -->
<section class="faq-section" id="faq" style="padding-top: 0;">
    <div class="faq-container reveal">
        <?php if(!empty($data['faq'])): ?>
            <?php foreach($data['faq'] as $index => $item): ?>
            <div class="faq-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="faq-header" onclick="this.parentElement.classList.toggle('active')">
                    <span class="faq-question"><?= htmlspecialchars($item['question']) ?></span>
                    <div class="faq-icon-wrapper">▼</div>
                </div>
                <div class="faq-content">
                    <p><?= htmlspecialchars($item['answer']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No FAQs available.</p>
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
