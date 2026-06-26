</div> <!-- Close .snap-container -->

    <style>
        .footer {
            background-color: var(--bg-secondary);
            padding: 4rem 2rem 2rem;
            color: var(--text-primary);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 2rem;
        }
        .footer-brand {
            flex: 1;
            min-width: 250px;
        }
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            text-decoration: none;
        }
        .footer-logo img {
            height: 40px;
        }
        .footer-logo span {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: var(--text-primary);
            letter-spacing: 1px;
        }
        .footer-links {
            flex: 1;
            min-width: 200px;
        }
        .footer-links h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }
        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: var(--accent-color);
        }
        .footer-social {
            flex: 1;
            min-width: 200px;
        }
        .footer-social h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }
        .social-icons {
            display: flex;
            gap: 1rem;
        }
        .social-icons a {
            color: var(--text-secondary);
            font-size: 1.5rem;
            text-decoration: none;
            transition: transform 0.3s, color 0.3s;
        }
        .social-icons a:hover {
            color: var(--accent-color);
            transform: translateY(-3px);
        }
        .footer-bottom {
            max-width: 1200px;
            margin: 3rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
    </style>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <a href="#hero" class="footer-logo">
                    <img src="assets/images/logo.png" alt="FishiFox Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span style="display:none;">FishiFox</span>
                </a>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    Your premier IT solutions provider in Sri Lanka. Diving to an unexpected depth to bring you digital excellence.
                </p>
            </div>
            
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="footer-social">
                <h3>Connect With Us</h3>
                <div class="social-icons">
                    <a href="#" title="Facebook">📘</a>
                    <a href="#" title="Twitter">🐦</a>
                    <a href="#" title="Instagram">📸</a>
                    <a href="#" title="LinkedIn">💼</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2010 - <?= date('Y') ?>, FishiFox. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Execution Module Pipelines -->
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/scroll.js"></script>
    <script src="assets/js/parallax.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/fluid.js"></script>
</body>
</html>