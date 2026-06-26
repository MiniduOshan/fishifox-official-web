<?php
$dataFile = 'data/content.json';
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
}
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Segment Module -->
<section class="hero" id="hero">
    <div class="hero-content">
        <p class="hero-subtitle">Welcome to FishiFox</p>
        <h1 class="hero-title">
            <span class="line">Diving to an</span>
            <span class="line">Unexpected Depth</span>
        </h1>
        <p class="hero-description">
            At FishiFox, we’re not just another IT company. We’re your dedicated partner in achieving digital excellence. With a steadfast commitment to delivering top-tier web development, mobile app solutions, IT base research, and digital marketing services, we stand at the forefront of innovation in Sri Lanka’s IT industry.
        </p>
        <a href="#services" class="hero-cta">Explore Services</a>
    </div>
    <div class="scroll-indicator"><div class="scroll-line"></div></div>
</section>

<!-- Stats Grid Module -->
<section class="stats-section" id="stats">
    <div class="stats-container">
        <?php if(!empty($data['stats'])): ?>
            <?php foreach($data['stats'] as $stat): ?>
            <div class="stat-card reveal">
                <div class="stat-icon"><?= htmlspecialchars($stat['icon']) ?></div>
                <div class="stat-number" data-target="<?= htmlspecialchars($stat['number']) ?>">0</div>
                <div class="stat-label"><?= htmlspecialchars($stat['label']) ?></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No stats available.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services">
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
                    <div class="service-icon"><?= htmlspecialchars($service['icon']) ?></div>
                <?php endif; ?>
                <h3 class="service-title"><?= htmlspecialchars($service['title']) ?></h3>
                <p class="service-desc"><?= htmlspecialchars($service['description']) ?></p>
                <a href="#contact" class="service-link">Get Quote →</a>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No services available.</p>
        <?php endif; ?>
    </div>
</section>



<!-- Vision & Mission Section -->
<section class="about-section" id="about" style="padding: 5rem 0; text-align: center;">
    <div class="section-header reveal">
        <p class="section-label">About Us</p>
        <h2 class="section-title">Vision & Mission</h2>
    </div>
    <div class="reveal" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
        <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--accent-color);">Our Vision</h3>
        <p style="font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;"><?= htmlspecialchars($data['vision'] ?? '') ?></p>
        
        <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--accent-color);">Our Mission</h3>
        <p style="font-size: 1.1rem; line-height: 1.6;"><?= htmlspecialchars($data['mission'] ?? '') ?></p>
    </div>
</section>



<!-- Portfolio Section -->
<section class="portfolio-section" id="portfolio">
    <div class="section-header reveal">
        <p class="section-label">Our Work</p>
        <h2 class="section-title">Case Studies & Projects</h2>
    </div>
    <div class="portfolio-grid">
        <?php if(!empty($data['projects'])): ?>
            <?php foreach($data['projects'] as $project): ?>
            <div class="portfolio-card reveal">
                <?php if(!empty($project['image'])): ?>
                    <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                <?php else: ?>
                    <div class="portfolio-img-placeholder"><?= htmlspecialchars($project['icon'] ?? '📁') ?></div>
                <?php endif; ?>
                <div class="portfolio-content">
                    <span class="portfolio-tag">Project</span>
                    <h3 class="portfolio-title"><?= htmlspecialchars($project['title']) ?></h3>
                    <p class="portfolio-desc"><?= htmlspecialchars($project['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No projects available.</p>
        <?php endif; ?>
    </div>
</section>

<!-- News Section -->
<section class="news-section" id="news" style="padding: 5rem 0; background-color: var(--bg-secondary);">
    <div class="section-header reveal">
        <p class="section-label">Latest Updates</p>
        <h2 class="section-title">News & Announcements</h2>
    </div>
    <div class="news-grid reveal" style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <?php if(!empty($data['news'])): ?>
            <?php foreach($data['news'] as $news): ?>
            <div class="news-card" style="background: var(--bg-primary); padding: 2rem; border-radius: 12px; width: 300px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                <?php if(!empty($news['image'])): ?>
                    <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                <?php endif; ?>
                <span class="news-date" style="color: var(--accent-color); font-size: 0.9rem; font-weight: bold;"><?= htmlspecialchars($news['date']) ?></span>
                <h3 class="news-title" style="margin: 1rem 0; font-size: 1.25rem;"><?= htmlspecialchars($news['title']) ?></h3>
                <p class="news-desc" style="color: var(--text-secondary); flex: 1;"><?= htmlspecialchars($news['content']) ?></p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news available.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Clients Section -->
<section class="clients-section" id="clients" style="padding: 5rem 0;">
    <div class="section-header reveal">
        <p class="section-label">Trusted By</p>
        <h2 class="section-title">Our Clientele</h2>
    </div>
    <div class="clients-grid reveal" style="display: flex; gap: 3rem; justify-content: center; flex-wrap: wrap; max-width: 1000px; margin: 3rem auto; padding: 0 2rem;">
        <?php if(!empty($data['clients'])): ?>
            <?php foreach($data['clients'] as $clientLogo): ?>
                <img src="<?= htmlspecialchars($clientLogo) ?>" alt="Client Logo" style="max-height: 80px; filter: grayscale(100%); opacity: 0.7; transition: all 0.3s ease;" onmouseover="this.style.filter='none'; this.style.opacity='1'" onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.7'">
            <?php endforeach; ?>
        <?php else: ?>
            <p>No clients listed.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Accordion Hub Module -->
<section class="faq-section" id="faq">
    <div class="section-header reveal">
        <p class="section-label">FAQ</p>
        <h2 class="section-title">Frequently Asked Questions</h2>
    </div>
    <div class="faq-container reveal">
        <div class="faq-item">
            <div class="faq-header">
                <span class="faq-question">What services does FishiFox offer?</span>
                <div class="faq-icon-wrapper">▼</div>
            </div>
            <div class="faq-content">
                <p>FishiFox specializes in full-scale web development, custom mobile applications (iOS and Android), IT base audits/research, and digital marketing strategies.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="section-header reveal">
        <p class="section-label">Get in Touch</p>
        <h2 class="section-title">Ready to Start Your Project?</h2>
    </div>
    <div class="contact-container reveal">
        <div class="contact-info-panel">
            <div class="contact-details">
                <div class="contact-detail-item">
                    <div class="contact-detail-icon">📍</div>
                    <div class="contact-detail-text">
                        <h5>Headquarters</h5>
                        <p><?= htmlspecialchars($data['contact']['address'] ?? 'No. 146/120D, Salmal Place, Mattegoda, Kottawa, Sri Lanka') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.to('.hero-subtitle', { opacity: 1, y: 0, duration: 0.7, delay: 0.12 });
        document.querySelectorAll('.hero-title .line').forEach((line, index) => {
            const text = line.textContent.trim(); line.innerHTML = '';
            text.split('').forEach((char, i) => {
                const span = document.createElement('span');
                span.className = 'char'; span.textContent = char === ' ' ? '\u00A0' : char;
                line.appendChild(span);
                gsap.to(span, { opacity: 1, y: 0, duration: 0.7, delay: 0.18 + (index * 0.12) + (i * 0.01) });
            });
        });
        gsap.to('.hero-description', { opacity: 1, y: 0, duration: 0.7, delay: 0.38 });
        gsap.to('.hero-cta', { opacity: 1, y: 0, duration: 0.7, delay: 0.5 });
        gsap.to('.scroll-indicator', { opacity: 1, duration: 0.7, delay: 0.62 });

        document.querySelectorAll('.stat-number').forEach(stat => {
            const target = parseInt(stat.getAttribute('data-target'));
            ScrollTrigger.create({
                trigger: stat, start: 'top 85%',
                onEnter: () => {
                    gsap.to(stat, {
                        innerHTML: target, duration: 2, snap: { innerHTML: 1 }, ease: 'power2.out',
                        onUpdate: function() { stat.innerHTML = Math.round(this.targets()[0].innerHTML) + '+'; }
                    });
                }
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>