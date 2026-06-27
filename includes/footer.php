</div> <!-- Close .snap-container -->

    <style>
        .footer {
            background-color: var(--footer-bg);
            padding: 5rem 2rem 2rem;
            color: #f8fafc;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-family: 'Inter', sans-serif;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
        }
        .footer-brand {
            padding-right: 2rem;
        }
        .footer-logo {
            display: inline-flex;
            align-items: center;
            margin-bottom: 1.5rem;
            text-decoration: none;
            transition: transform 0.3s;
        }
        .footer-logo:hover {
            transform: scale(1.02);
        }
        .footer-logo img {
            height: 50px;
        }
        .footer-links h3, .footer-social h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #ffffff;
            position: relative;
            padding-bottom: 0.5rem;
        }
        .footer-links h3::after, .footer-social h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent-color);
        }
        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer-links a:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }
        .social-icons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .social-icons a:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }
        .footer-bottom {
            max-width: 1200px;
            margin: 4rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
        }

        @media (max-width: 992px) {
            .footer-container {
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
            }
            .footer-brand {
                grid-column: span 2;
                padding-right: 0;
            }
        }

        @media (max-width: 600px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
            .footer-brand {
                grid-column: span 1;
            }
        }
    </style>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <a href="#hero" class="footer-logo">
                    <img src="assets/images/logo.png" alt="FishiFox Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span style="display:none;">FishiFox</span>
                </a>
                <p style="color: #94a3b8; line-height: 1.6;">
                    Your premier IT solutions provider in Sri Lanka. Diving to an unexpected depth to bring you digital excellence.
                </p>
                <div style="margin-top: 1rem; display: flex; gap: 1rem; font-size: 0.9rem;">
                    <a href="terms-conditions" style="color: var(--accent-color); text-decoration: none;">Terms & Conditions</a>
                    <span style="color: rgba(255, 255, 255, 0.2);">|</span>
                    <a href="privacy-policy" style="color: var(--accent-color); text-decoration: none;">Privacy Policy</a>
                </div>
            </div>
            
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index#about">About Us</a></li>
                    <li><a href="news">News</a></li>
                    <li><a href="faq">FAQ</a></li>
                    <li><a href="index#contact">Contact</a></li>
                </ul>
            </div>

            <div class="footer-social">
                <h3>Connect With Us</h3>
                <div class="social-icons">
                    <?php
                    // Ensure PDO is available
                    global $pdo;
                    $socials = ['facebook' => '#', 'twitter' => '#', 'instagram' => '#', 'linkedin' => '#'];
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
                    <a href="<?= htmlspecialchars($socials['facebook']) ?>" target="_blank" rel="noopener noreferrer" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="<?= htmlspecialchars($socials['twitter']) ?>" target="_blank" rel="noopener noreferrer" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="<?= htmlspecialchars($socials['instagram']) ?>" target="_blank" rel="noopener noreferrer" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="<?= htmlspecialchars($socials['linkedin']) ?>" target="_blank" rel="noopener noreferrer" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2010 - <?= date('Y') ?>, FishiFox. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Execution Module Pipelines -->
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/parallax.js"></script>
    <script src="assets/js/script.js?v=<?= time() ?>"></script>
    <script src="assets/js/fluid.js?v=<?= time() ?>"></script>
</body>
</html>