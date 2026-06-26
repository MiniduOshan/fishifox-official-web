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
        <a href="services.php" class="hero-cta">Explore Services</a>
    </div>
    <div class="scroll-indicator"><div class="scroll-line"></div></div>
</section>

<!-- Stats Grid Module -->
<section class="stats-section" id="stats">
    <div class="stats-container">
        <div class="stat-card reveal">
            <div class="stat-icon">👥</div>
            <div class="stat-number" data-target="85">0</div>
            <div class="stat-label">Active Clients</div>
        </div>
        <div class="stat-card reveal">
            <div class="stat-icon">📊</div>
            <div class="stat-number" data-target="450">0</div>
            <div class="stat-label">Projects Done</div>
        </div>
        <div class="stat-card reveal">
            <div class="stat-icon">🌟</div>
            <div class="stat-number" data-target="27">0</div>
            <div class="stat-label">Team Advisors</div>
        </div>
        <div class="stat-card reveal">
            <div class="stat-icon">🏆</div>
            <div class="stat-number" data-target="15">0</div>
            <div class="stat-label">Glorious Years</div>
        </div>
    </div>
</section>

<!-- Tools Catalog Module -->
<section class="tools-section" id="tools">
    <div class="section-header reveal">
        <p class="section-label">Our Tools</p>
        <h2 class="section-title">Awesome Custom Products</h2>
    </div>
    <div class="tools-grid">
        <div class="tool-card reveal">
            <div class="tool-icon">📁</div>
            <h3 class="tool-title">POS Sri Lanka</h3>
            <p class="tool-desc">Sleek point-of-sale systems tailored for Sri Lankan retail, dining, and cafes, featuring offline caching and inventory sync.</p>
        </div>
        <div class="tool-card reveal">
            <div class="tool-icon">🧪</div>
            <h3 class="tool-title">Medi Lab</h3>
            <p class="tool-desc">A specialized Laboratory Management System built to streamline laboratory diagnostics, patient records, and doctor portal audits.</p>
        </div>
        <div class="tool-card reveal">
            <div class="tool-icon">🎨</div>
            <h3 class="tool-title">Web Design</h3>
            <p class="tool-desc">We create high-converting, fully customized digital experiences with integrated shopping carts and inventory platforms.</p>
        </div>
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

<script>
    // Localized typography sequencer scripts injection mapping hook block
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

        // Numerical ticking engine metrics execution code
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