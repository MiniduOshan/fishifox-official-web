<?php
if (php_sapi_name() !== 'cli' && (!isset($_GET['token']) || $_GET['token'] !== 'init123')) {
    die("Unauthorized access to database initialization. Provide ?token=init123 parameter.");
}
$host = '127.0.0.1';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS fishifox_db");
    $pdo->exec("USE fishifox_db");

    // Create tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        setting_key VARCHAR(50) PRIMARY KEY,
        setting_value TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        icon VARCHAR(255),
        image VARCHAR(255),
        title VARCHAR(255),
        description TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        icon VARCHAR(255),
        image VARCHAR(255),
        title VARCHAR(255),
        description TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATE,
        title VARCHAR(255),
        slug VARCHAR(255),
        image VARCHAR(255),
        content TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image_url VARCHAR(255)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT,
        answer TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS stats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        icon VARCHAR(255),
        number VARCHAR(50),
        label VARCHAR(255)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS footer_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS footer_links (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT,
        name VARCHAR(255),
        url VARCHAR(255),
        FOREIGN KEY (category_id) REFERENCES footer_categories(id) ON DELETE CASCADE
    )");

    echo "Tables created successfully.\n";

    // Load data from JSON
    $dataFile = __DIR__ . '/data/content.json';
    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $data = json_decode($json, true);

        // Clear existing data before inserting
        $pdo->exec("TRUNCATE TABLE settings");
        $pdo->exec("TRUNCATE TABLE services");
        $pdo->exec("TRUNCATE TABLE projects");
        $pdo->exec("TRUNCATE TABLE news");
        $pdo->exec("TRUNCATE TABLE clients");
        $pdo->exec("TRUNCATE TABLE faqs");
        $pdo->exec("TRUNCATE TABLE stats");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $pdo->exec("TRUNCATE TABLE footer_categories");
        $pdo->exec("TRUNCATE TABLE footer_links");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        // Insert Settings
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)");
        if (isset($data['vision'])) $stmt->execute(['vision', $data['vision']]);
        if (isset($data['mission'])) $stmt->execute(['mission', $data['mission']]);
        if (isset($data['contact']['address'])) $stmt->execute(['contact_address', $data['contact']['address']]);

        // Insert Services
        $stmt = $pdo->prepare("INSERT INTO services (icon, title, description, image) VALUES (?, ?, ?, ?)");
        if (isset($data['services'])) {
            foreach ($data['services'] as $service) {
                $stmt->execute([
                    $service['icon'] ?? '',
                    $service['title'] ?? '',
                    $service['description'] ?? '',
                    $service['image'] ?? ''
                ]);
            }
        }

        // Insert Projects
        $stmt = $pdo->prepare("INSERT INTO projects (icon, title, description, image) VALUES (?, ?, ?, ?)");
        if (isset($data['projects'])) {
            foreach ($data['projects'] as $project) {
                $stmt->execute([
                    $project['icon'] ?? '',
                    $project['title'] ?? '',
                    $project['description'] ?? '',
                    $project['image'] ?? ''
                ]);
            }
        }

        // Insert News
        $stmt = $pdo->prepare("INSERT INTO news (date, title, content, image) VALUES (?, ?, ?, ?)");
        if (isset($data['news'])) {
            foreach ($data['news'] as $newsItem) {
                $stmt->execute([
                    $newsItem['date'] ?? null,
                    $newsItem['title'] ?? '',
                    $newsItem['content'] ?? '',
                    $newsItem['image'] ?? ''
                ]);
            }
        }

        // Insert Clients
        $stmt = $pdo->prepare("INSERT INTO clients (image_url) VALUES (?)");
        if (isset($data['clients'])) {
            foreach ($data['clients'] as $clientUrl) {
                $stmt->execute([$clientUrl]);
            }
        }

        // Insert FAQs
        $stmt = $pdo->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        if (isset($data['faq'])) {
            foreach ($data['faq'] as $faq) {
                $stmt->execute([$faq['question'] ?? '', $faq['answer'] ?? '']);
            }
        }

        // Insert Stats
        $stmt = $pdo->prepare("INSERT INTO stats (icon, number, label) VALUES (?, ?, ?)");
        if (isset($data['stats'])) {
            foreach ($data['stats'] as $stat) {
                $stmt->execute([
                    $stat['icon'] ?? '',
                    $stat['number'] ?? '',
                    $stat['label'] ?? ''
                ]);
            }
        }

        echo "Data imported successfully.\n";
    } else {
        echo "Warning: data/content.json not found. No data imported.\n";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
