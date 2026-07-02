</div> <!-- Close .snap-container -->

    <style>
        .footer {
            background-color: var(--footer-bg, #0f172a);
            padding: 5rem 2rem 2rem;
            color: #f8fafc;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gradient, linear-gradient(90deg, #e62e72 0%, #f76840 50%, #fcaa28 100%));
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            position: relative;
            z-index: 10;
        }

        .footer-widget h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #ffffff;
            position: relative;
            padding-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-widget h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: var(--primary, #e62e72);
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

        .footer-desc {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
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
            display: inline-flex;
            align-items: center;
        }

        .footer-links a::before {
            content: '\203A';
            margin-right: 8px;
            font-size: 1.2rem;
            color: var(--primary, #e62e72);
            transition: transform 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .footer-links a:hover::before {
            transform: translateX(4px);
        }

        .footer-contact-info {
            list-style: none;
            padding: 0;
        }

        .footer-contact-info li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .footer-contact-info i {
            margin-right: 12px;
            margin-top: 4px;
            color: var(--primary, #e62e72);
            font-size: 1.1rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-icons a:hover {
            background-color: var(--primary, #e62e72);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 46, 114, 0.3);
            border-color: var(--primary, #e62e72);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 4rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-bottom p {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
        }

        .footer-bottom-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            margin-left: 1.5rem;
            transition: color 0.3s;
        }

        .footer-bottom-links a:hover {
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            .footer-bottom-links a {
                margin: 0 0.75rem;
            }
            .footer-bottom-links {
                margin-top: 1rem;
            }
        }
    </style>

    <footer class="footer">
        <div class="footer-container">
            <!-- Brand Section -->
            <div class="footer-widget">
                <a href="/" class="footer-logo">
                    <!-- Assuming logo exists, replace src as needed -->
                    <img src="assets/images/logo-light.png" alt="FishiFox" onerror="this.src='assets/images/logo.png'">
                </a>
                <p class="footer-desc">
                    FishiFox delivers the most engaging and up-to-date content. Stay connected with us for the latest news, updates, and more.
                </p>
                <?php
                // Fetch social links dynamically if possible
                $socials = ['facebook' => '#', 'twitter' => '#', 'instagram' => '#', 'linkedin' => '#'];
                if (isset($conn)) {
                    $sql = "SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'social_%'";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $key = str_replace('social_', '', $row['setting_key']);
                            if (!empty($row['setting_value'])) {
                                $socials[$key] = $row['setting_value'];
                            }
                        }
                    }
                }
                ?>
                <div class="social-icons">
                    <a href="<?= htmlspecialchars($socials['facebook']) ?>" target="_blank" rel="noopener noreferrer" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="<?= htmlspecialchars($socials['twitter']) ?>" target="_blank" rel="noopener noreferrer" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="<?= htmlspecialchars($socials['instagram']) ?>" target="_blank" rel="noopener noreferrer" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="<?= htmlspecialchars($socials['linkedin']) ?>" target="_blank" rel="noopener noreferrer" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <?php
            if (isset($conn)) {
                $catResult = $conn->query("SELECT * FROM footer_categories");
                if ($catResult && $catResult->num_rows > 0) {
                    while ($cat = $catResult->fetch_assoc()) {
                        echo '<div class="footer-widget footer-links">';
                        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
                        echo '<ul>';
                        $linkResult = $conn->query("SELECT * FROM footer_links WHERE category_id = " . intval($cat['id']));
                        if ($linkResult && $linkResult->num_rows > 0) {
                            while ($link = $linkResult->fetch_assoc()) {
                                echo '<li><a href="' . htmlspecialchars($link['url']) . '">' . htmlspecialchars($link['name']) . '</a></li>';
                            }
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
                }
            } else if (isset($pdo)) {
                $cats = $pdo->query("SELECT * FROM footer_categories")->fetchAll();
                foreach ($cats as $cat) {
                    echo '<div class="footer-widget footer-links">';
                    echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
                    echo '<ul>';
                    $stmt = $pdo->prepare("SELECT * FROM footer_links WHERE category_id = ?");
                    $stmt->execute([$cat['id']]);
                    $links = $stmt->fetchAll();
                    foreach ($links as $link) {
                        echo '<li><a href="' . htmlspecialchars($link['url']) . '">' . htmlspecialchars($link['name']) . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>

            <!-- Contact Info -->
            <div class="footer-widget">
                <h3>Contact Us</h3>
                <ul class="footer-contact-info">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>123 FishiFox Street, Tech City, 10110</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span>+1 (234) 567-8900</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span>info@fishifox.com</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2010 - <?= date('Y') ?> FishiFox. All Rights Reserved.</p>
            <div class="footer-bottom-links">
                <a href="/privacy.php">Privacy</a>
                <a href="/terms.php">Terms</a>
            </div>
        </div>
    </footer>

    <!-- Execution Module Pipelines -->
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/parallax.js"></script>
    <script src="assets/js/script.js?v=<?= time() ?>"></script>
    <script src="assets/js/fluid.js?v=<?= time() ?>"></script>
</body>
</html>