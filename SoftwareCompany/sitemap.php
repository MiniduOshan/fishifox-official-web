<?php
/**
 * FishiFox Dynamic XML Sitemap Generator Engine
 * Generates SEO-compliant crawling maps automatically.
 */

// 1. Force the server to output genuine XML instead of standard HTML
header("Content-Type: application/xml; charset=utf-8");

// 2. Initialize the XML structural schema definition wrapper
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

// 3. Define your base canonical production URL
$baseUrl = "https://fishifox.com/"; // Replace with your production domain name

/**
 * Helper function to cleanly structure individual URL nodes
 */
function addSitemapUrl($url, $lastMod, $changeFreq, $priority) {
    echo '  <url>' . PHP_EOL;
    echo '    <loc>' . htmlspecialchars($url) . '</loc>' . PHP_EOL;
    echo '    <lastmod>' . $lastMod . '</lastmod>' . PHP_EOL;
    echo '    <changefreq>' . $changeFreq . '</changefreq>' . PHP_EOL;
    echo '    <priority>' . $priority . '</priority>' . PHP_EOL;
    echo '  </url>' . PHP_EOL;
}

// --- MODULE A: STATIC FILE PAGES ROUTING ---
$currentDate = date('Y-m-d');

// High-priority core landing pages
addSitemapUrl($baseUrl, $currentDate, 'weekly', '1.0');
addSitemapUrl($baseUrl . 'index.php', $currentDate, 'weekly', '0.9');
addSitemapUrl($baseUrl . 'services.php', $currentDate, 'weekly', '0.8');
addSitemapUrl($baseUrl . 'portfolio.php', $currentDate, 'weekly', '0.8');
addSitemapUrl($baseUrl . 'about.php', $currentDate, 'monthly', '0.7');
addSitemapUrl($baseUrl . 'contact.php', $currentDate, 'monthly', '0.7');


// --- MODULE B: DYNAMIC CONTENT EXPANSIONS (Optional Framework Stubs) ---
/*
// If you expand your custom tools or database entries later, loop them in here cleanly:
$databaseItems = [
    ['slug' => 'pos-sri-lanka', 'updated' => '2026-06-25'],
    ['slug' => 'medi-lab', 'updated' => '2026-06-26']
];

foreach ($databaseItems as $item) {
    addSitemapUrl($baseUrl . 'tools.php?product=' . $item['slug'], $item['updated'], 'monthly', '0.6');
}
*/

// Close out the URL set structural bracket tag string securely
echo '</urlset>' . PHP_EOL;
