<?php
require_once 'config/database.php';

$data = [];

// Fetch settings
$stmt = $pdo->query("SELECT * FROM settings");
while ($row = $stmt->fetch()) {
    $data[$row['setting_key']] = $row['setting_value'];
}
$data['vision'] = $data['vision'] ?? '';
$data['mission'] = $data['mission'] ?? '';
$data['contact'] = ['address' => $data['contact_address'] ?? ''];

// Fetch other tables
$data['services'] = $pdo->query("SELECT * FROM services")->fetchAll();
$data['projects'] = $pdo->query("SELECT * FROM projects")->fetchAll();
$data['news'] = $pdo->query("SELECT * FROM news ORDER BY date DESC, id DESC")->fetchAll();
$data['clients'] = $pdo->query("SELECT * FROM clients")->fetchAll();
$data['stats'] = $pdo->query("SELECT * FROM stats")->fetchAll();
$data['faq'] = $pdo->query("SELECT * FROM faqs")->fetchAll();
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
                <div class="stat-number" data-target="<?= htmlspecialchars($stat['number']) ?>">0</div>
                <div class="stat-label"><?= htmlspecialchars($stat['label']) ?></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="stat-card reveal">
                <div class="stat-number" data-target="0">0</div>
                <div class="stat-label">No stats available</div>
            </div>
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
                <p class="service-desc"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                <a href="#contact" class="service-link">Get Quote →</a>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No services available.</p>
        <?php endif; ?>
    </div>
</section>



<!-- Vision & Mission Section -->
<section class="about-section parallax-section" id="about" style="text-align: center;">
    <div class="parallax-bg-image" style="background-image: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=2070');"></div>
    <div class="parallax-overlay"></div>
    <div class="parallax-content">
        <div class="section-header reveal">
            <p class="section-label" style="color: var(--primary-gold);">About Us</p>
            <h2 class="section-title" style="color: white;">Vision & Mission</h2>
        </div>
        <div class="reveal glass-panel" style="max-width: 800px; margin: 0 auto; padding: 3rem; border-radius: 24px;">
            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-light);">Our Vision</h3>
            <p style="font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem; color: #e2e8f0;"><?= nl2br(htmlspecialchars($data['vision'] ?? '')) ?></p>
            
            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary-light);">Our Mission</h3>
            <p style="font-size: 1.1rem; line-height: 1.6; color: #e2e8f0;"><?= nl2br(htmlspecialchars($data['mission'] ?? '')) ?></p>
        </div>
    </div>
</section>



<!-- Portfolio Section -->
<section class="portfolio-section" id="portfolio" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="portfolio-layout-wrapper">
        <div class="portfolio-header-side reveal">
            <p class="section-label">Our Work</p>
            <h2 class="section-title" style="margin-bottom: 20px; text-align: left;">Case Studies & Products</h2>
            <p class="section-desc" style="text-align: left; line-height: 1.6;">Explore some of our finest deliveries. We design robust digital experiences tailored to elevate brands and engage users.</p>
        </div>
        
        <div class="portfolio-grid-mask">
            <div class="portfolio-grid-side">
                <?php if(!empty($data['projects'])): ?>
                <?php foreach($data['projects'] as $project): ?>
                <?php 
                    $hasUrl = !empty($project['url']);
                    $urlAttr = $hasUrl ? 'href="' . htmlspecialchars($project['url']) . '" target="_blank" style="text-decoration: none; color: inherit; display: block;"' : 'style="display: block;"';
                    $tag = $hasUrl ? 'a' : 'div';
                ?>
                <<?= $tag ?> <?= $urlAttr ?> class="portfolio-card reveal">
                    <?php if(!empty($project['image'])): ?>
                        <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    <?php else: ?>
                        <div class="portfolio-img-placeholder"><?= htmlspecialchars($project['icon'] ?? '📁') ?></div>
                    <?php endif; ?>
                    <div class="portfolio-content">
                        <span class="portfolio-tag">Product</span>
                        <h3 class="portfolio-title"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="portfolio-desc"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                    </div>
                </<?= $tag ?>>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No projects available.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</section>



<!-- Clients Section -->
<section class="clients-section" id="clients" style="overflow: hidden; padding-bottom: 60px;">
    <div class="section-header reveal">
        <p class="section-label">Trusted By</p>
        <h2 class="section-title">Our Clientele</h2>
    </div>
    
    <?php 
    // Real-world sample logos for demonstration
    $clientLogos = [];
    if (!empty($data['clients'])) {
        foreach ($data['clients'] as $c) {
            $clientLogos[] = $c['image_url'];
        }
    } else {
        $clientLogos = [
            'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg',
            'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg'
        ];
    }
    ?>
    <div class="clients-marquee-wrapper reveal">
        <div class="clients-marquee-track">
            <?php foreach($clientLogos as $logo): ?>
                <img src="<?= htmlspecialchars($logo) ?>" alt="Client Logo">
            <?php endforeach; ?>
            <!-- Duplicated for seamless infinite looping -->
            <?php foreach($clientLogos as $logo): ?>
                <img src="<?= htmlspecialchars($logo) ?>" alt="Client Logo">
            <?php endforeach; ?>
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
            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 24px; margin-bottom: 5px;">Contact Information</h3>
            <p style="color: var(--text-secondary); font-size: 15px;">Feel free to reach out to us with any questions or project inquiries. We would love to hear from you!</p>
            <div class="contact-details">
                <div class="contact-detail-item">
                    <div class="contact-detail-icon">📍</div>
                    <div class="contact-detail-text">
                        <h5>LOCATION</h5>
                        <p><?= nl2br(htmlspecialchars($data['contact']['address'] ?? 'No146/120D, Salmal Place, Mattegoda, Kottawa, Sri Lanka')) ?></p>
                    </div>
                </div>
                <div class="contact-detail-item">
                    <div class="contact-detail-icon">📞</div>
                    <div class="contact-detail-text">
                        <h5>Phone</h5>
                        <p><?= htmlspecialchars($data['contact']['phone'] ?? '+94 777 615 169') ?></p>
                    </div>
                </div>
                <div class="contact-detail-item">
                    <div class="contact-detail-icon">✉️</div>
                    <div class="contact-detail-text">
                        <h5>Email</h5>
                        <p><a href="mailto:info@fishifox.com" style="color: inherit; text-decoration: none;"><?= htmlspecialchars($data['contact']['email'] ?? 'info@fishifox.com') ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Hero Parallax Setup
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


        // Horizontal Scroll for Portfolio
        const portfolioSection = document.querySelector('.portfolio-section');
        const portfolioGrid = document.querySelector('.portfolio-grid-side');
        const portfolioMask = document.querySelector('.portfolio-grid-mask');
        
        if (portfolioGrid && portfolioSection && portfolioMask) {
            portfolioSection.style.overflow = 'hidden';
            
            let getScrollAmount = () => {
                let overflow = portfolioGrid.scrollWidth - portfolioMask.offsetWidth;
                // Only move if there is overflow
                return overflow > 0 ? -(overflow + 40) : 0;
            };

            let getScrollEnd = () => {
                let overflow = portfolioGrid.scrollWidth - portfolioMask.offsetWidth;
                return overflow > 0 ? `+=${overflow}` : "+=0";
            };

            let mm = gsap.matchMedia();
            mm.add("(min-width: 1025px)", () => {
                gsap.to(portfolioGrid, {
                    x: getScrollAmount,
                    ease: "none",
                    scrollTrigger: {
                        trigger: portfolioSection,
                        start: "top 5%",
                        end: getScrollEnd,
                        pin: true,
                        scrub: 1,
                        invalidateOnRefresh: true
                    }
                });
            });
        }


        // Stats Counter Effect
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