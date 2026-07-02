<?php include 'includes/header.php'; ?>

<!-- Contact Section -->
<section class="contact-section" id="contact" style="padding-top:140px; padding-bottom:100px;">
    <div class="section-header reveal" style="opacity:1; transform:none;">
        <p class="section-label">Get in Touch</p>
        <h2 class="section-title">Ready to Start Your Project?</h2>
        <p class="section-desc">
            We'd love to hear about your project. Send us a message and we'll respond as soon as possible.
        </p>
    </div>

    <div class="contact-wrapper">
        <div class="contact-main-card">
            <!-- Left -->
            <div class="contact-info-panel">
                <h3>Contact Information</h3>
                <div class="contact-details">
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-detail-text">
                            <h5>Address</h5>
                            <p>No.146/120D, Salmal Place,<br>Mattegoda, Kottawa, Sri Lanka</p>
                        </div>
                    </div>
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-detail-text">
                            <h5>Phone</h5>
                            <p>+94 777 615 169</p>
                        </div>
                    </div>
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-detail-text">
                            <h5>Email</h5>
                            <p>info@fishifox.com</p>
                        </div>
                    </div> 
                    <!-- Connect With Us -->
                    <div class="contact-social">
                        <h5>Connect With Us</h5>
                        <div class="social-icons">
                            <?php
                            global $pdo;
                            $socials = [
                                'facebook'  => '#',
                                'twitter'   => '#',
                                'instagram' => '#',
                                'linkedin'  => '#'
                            ];
                            if (isset($pdo)) {
                                $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'social_%'");

                                while ($row = $stmt->fetch()) {
                                    $key = str_replace('social_', '', $row['setting_key']);

                                    if (!empty($row['setting_value'])) {
                                        $socials[$key] = $row['setting_value'];
                                    }
                                }
                            }
                            ?>
                            <a href="<?= htmlspecialchars($socials['facebook']) ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="<?= htmlspecialchars($socials['twitter']) ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="<?= htmlspecialchars($socials['instagram']) ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="<?= htmlspecialchars($socials['linkedin']) ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>                 
                </div>
            </div>

            <!-- Right -->
            <div class="contact-form-panel">
                <h3>Send Us a Message</h3>
                <form action="contact-submit.php" method="POST">
                    <div class="form-row">
                        <input type="text" name="name" placeholder="Full Name" required>

                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <input type="text" name="subject" placeholder="Subject">
                    <textarea
                        name="message"
                        rows="7"
                        placeholder="Tell us about your project..."
                        required></textarea>
                    <button type="submit">
                        Send Message
                    </button>

                    
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>