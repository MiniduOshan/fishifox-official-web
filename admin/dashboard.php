<?php
ob_start();
require_once '../config/database.php';

$isAuthenticated = false;
if (isset($_COOKIE['fishifox_admin_auth'])) {
    $parts = explode('::', base64_decode($_COOKIE['fishifox_admin_auth']));
    if (count($parts) === 2) {
        $stmt = $pdo->prepare("SELECT password FROM admins WHERE email = ?");
        $stmt->execute([$parts[0]]);
        $dbAdmin = $stmt->fetch();
        if ($dbAdmin && $dbAdmin['password'] === $parts[1]) {
            $isAuthenticated = true;
        }
    }
}

if (!$isAuthenticated) {
    header('Location: login');
    exit;
}

// Fetch all data for display
$data = [];

// Fetch settings
$stmt = $pdo->query("SELECT * FROM settings");
while ($row = $stmt->fetch()) {
    $data[$row['setting_key']] = $row['setting_value'];
}
// Set fallbacks for settings
$data['vision'] = $data['vision'] ?? '';
$data['mission'] = $data['mission'] ?? '';
$data['contact'] = [
    'address' => $data['contact_address'] ?? '',
    'tp' => $data['contact_tp'] ?? '',
    'email' => $data['contact_email'] ?? ''
];

// Fetch other tables
$data['services'] = $pdo->query("SELECT * FROM services")->fetchAll();
$data['projects'] = $pdo->query("SELECT * FROM projects")->fetchAll();
$data['news'] = $pdo->query("SELECT * FROM news")->fetchAll();
$data['clients'] = $pdo->query("SELECT * FROM clients")->fetchAll();
$data['stats'] = $pdo->query("SELECT * FROM stats")->fetchAll();
$data['faq'] = $pdo->query("SELECT * FROM faqs")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize all POST inputs
    array_walk_recursive($_POST, function(&$value) {
        $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    });
    if (isset($_POST['update_about'])) {
        $vision = $_POST['vision'];
        $mission = $_POST['mission'];
        $stmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES ('vision', ?), ('mission', ?)");
        $stmt->execute([$vision, $mission]);
    } elseif (isset($_POST['save_service'])) {
        $icon = $_POST['service_icon'] ?? '';
        $image = $_POST['service_image'] ?? '';
        $title = $_POST['service_title'];
        $desc = $_POST['service_desc'];

        if (isset($_FILES['service_image_file']) && $_FILES['service_image_file']['error'] == 0) {
            $fileName = time() . '_' . basename($_FILES['service_image_file']['name']);
            $targetPath = '../assets/images/uploads/' . $fileName;
            if (move_uploaded_file($_FILES['service_image_file']['tmp_name'], $targetPath)) {
                $image = 'assets/images/uploads/' . $fileName;
            }
        }

        if (isset($_POST['edit_service_index']) && $_POST['edit_service_index'] !== '') {
            $id = $_POST['edit_service_index'];
            if (empty($image) && empty($_FILES['service_image_file']['name'])) {
                // Keep old image
                $stmt = $pdo->prepare("UPDATE services SET icon=?, title=?, description=? WHERE id=?");
                $stmt->execute([$icon, $title, $desc, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE services SET icon=?, image=?, title=?, description=? WHERE id=?");
                $stmt->execute([$icon, $image, $title, $desc, $id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO services (icon, image, title, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$icon, $image, $title, $desc]);
        }
    } elseif (isset($_POST['delete_service'])) {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
        $stmt->execute([$_POST['delete_service']]);
    } elseif (isset($_POST['save_project'])) {
        $icon = $_POST['project_icon'];
        $image = $_POST['project_image'];
        $title = $_POST['project_title'];
        $desc = $_POST['project_desc'];
        $url = $_POST['project_url'] ?? null;

        if (isset($_FILES['project_image_file']) && $_FILES['project_image_file']['error'] == 0) {
            $fileName = time() . '_' . basename($_FILES['project_image_file']['name']);
            $targetPath = '../assets/images/uploads/' . $fileName;
            if (move_uploaded_file($_FILES['project_image_file']['tmp_name'], $targetPath)) {
                $image = 'assets/images/uploads/' . $fileName;
            }
        }

        if (isset($_POST['edit_project_index']) && $_POST['edit_project_index'] !== '') {
            $id = $_POST['edit_project_index'];
            if (empty($image) && empty($_FILES['project_image_file']['name'])) {
                $stmt = $pdo->prepare("UPDATE projects SET icon=?, title=?, description=?, url=? WHERE id=?");
                $stmt->execute([$icon, $title, $desc, $url, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE projects SET icon=?, image=?, title=?, description=?, url=? WHERE id=?");
                $stmt->execute([$icon, $image, $title, $desc, $url, $id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (icon, image, title, description, url) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$icon, $image, $title, $desc, $url]);
        }
    } elseif (isset($_POST['delete_project'])) {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id=?");
        $stmt->execute([$_POST['delete_project']]);
    } elseif (isset($_POST['save_news'])) {
        $date = $_POST['news_date'];
        $title = $_POST['news_title'];
        $image = $_POST['news_image'];
        $content = $_POST['news_content'];
        $is_headline = isset($_POST['news_is_headline']) ? 1 : 0;

        if (isset($_FILES['news_image_file']) && $_FILES['news_image_file']['error'] == 0) {
            $fileName = time() . '_' . basename($_FILES['news_image_file']['name']);
            $targetPath = '../assets/images/uploads/' . $fileName;
            if (move_uploaded_file($_FILES['news_image_file']['tmp_name'], $targetPath)) {
                $image = 'assets/images/uploads/' . $fileName;
            }
        }

        if (isset($_POST['edit_news_index']) && $_POST['edit_news_index'] !== '') {
            $id = $_POST['edit_news_index'];
            if (empty($image) && empty($_FILES['news_image_file']['name'])) {
                $stmt = $pdo->prepare("UPDATE news SET date=?, title=?, content=?, is_headline=? WHERE id=?");
                $stmt->execute([$date, $title, $content, $is_headline, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE news SET date=?, title=?, image=?, content=?, is_headline=? WHERE id=?");
                $stmt->execute([$date, $title, $image, $content, $is_headline, $id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO news (date, title, image, content, is_headline) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$date, $title, $image, $content, $is_headline]);
        }
    } elseif (isset($_POST['delete_news'])) {
        $stmt = $pdo->prepare("DELETE FROM news WHERE id=?");
        $stmt->execute([$_POST['delete_news']]);
    } elseif (isset($_POST['save_client'])) {
        $image = $_POST['client_image'] ?? '';
        
        if (isset($_FILES['client_image_file']) && $_FILES['client_image_file']['error'] == 0) {
            $fileName = time() . '_' . basename($_FILES['client_image_file']['name']);
            $targetPath = '../assets/images/uploads/' . $fileName;
            if (move_uploaded_file($_FILES['client_image_file']['tmp_name'], $targetPath)) {
                $image = 'assets/images/uploads/' . $fileName;
            }
        }

        if (isset($_POST['edit_client_index']) && $_POST['edit_client_index'] !== '') {
            $id = $_POST['edit_client_index'];
            if (empty($image) && empty($_FILES['client_image_file']['name'])) {
                // Keep old image
            } else {
                $stmt = $pdo->prepare("UPDATE clients SET image_url=? WHERE id=?");
                $stmt->execute([$image, $id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO clients (image_url) VALUES (?)");
            $stmt->execute([$image]);
        }
    } elseif (isset($_POST['delete_client'])) {
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id=?");
        $stmt->execute([$_POST['delete_client']]);
    } elseif (isset($_POST['save_stat'])) {
        $icon = $_POST['stat_icon'];
        $number = $_POST['stat_number'];
        $label = $_POST['stat_label'];
        if (isset($_POST['edit_stat_index']) && $_POST['edit_stat_index'] !== '') {
            $id = $_POST['edit_stat_index'];
            $stmt = $pdo->prepare("UPDATE stats SET icon=?, number=?, label=? WHERE id=?");
            $stmt->execute([$icon, $number, $label, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO stats (icon, number, label) VALUES (?, ?, ?)");
            $stmt->execute([$icon, $number, $label]);
        }
    } elseif (isset($_POST['delete_stat'])) {
        $stmt = $pdo->prepare("DELETE FROM stats WHERE id=?");
        $stmt->execute([$_POST['delete_stat']]);
    } elseif (isset($_POST['update_contact'])) {
        $address = $_POST['contact_address'];
        $tp = $_POST['contact_tp'];
        $email = $_POST['contact_email'];
        $stmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES ('contact_address', ?), ('contact_tp', ?), ('contact_email', ?)");
        $stmt->execute([$address, $tp, $email]);
    } elseif (isset($_POST['update_socials'])) {
        $fb = $_POST['social_facebook'];
        $tw = $_POST['social_twitter'];
        $ig = $_POST['social_instagram'];
        $li = $_POST['social_linkedin'];
        $stmt = $pdo->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES ('social_facebook', ?), ('social_twitter', ?), ('social_instagram', ?), ('social_linkedin', ?)");
        $stmt->execute([$fb, $tw, $ig, $li]);
    } elseif (isset($_POST['save_faq'])) {
        $question = $_POST['faq_question'];
        $answer = $_POST['faq_answer'];
        if (isset($_POST['edit_faq_index']) && $_POST['edit_faq_index'] !== '') {
            $id = $_POST['edit_faq_index'];
            $stmt = $pdo->prepare("UPDATE faqs SET question=?, answer=? WHERE id=?");
            $stmt->execute([$question, $answer, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
            $stmt->execute([$question, $answer]);
        }
    } elseif (isset($_POST['delete_faq'])) {
        $stmt = $pdo->prepare("DELETE FROM faqs WHERE id=?");
        $stmt->execute([$_POST['delete_faq']]);
    }

    header("Location: dashboard");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FishiFox</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>

<div class="admin-header">
    <h1>FishiFox Admin Dashboard</h1>
    <div>
        <a href="../index.php" target="_blank" style="margin-right: 15px; color: black;">View Website</a>
        <a href="logout.php" style="background: #e74c3c; padding: 5px 10px; color: white; text-decoration: none; border-radius: 4px;">Logout</a>
    </div>
</div>

<div class="admin-layout">
    <div class="admin-sidebar">
        <ul>
            <li><a class="nav-link active" data-target="news-card">News</a></li>
            <li><a class="nav-link" data-target="projects-card">Products</a></li>
            <li><a class="nav-link" data-target="stats-card">Stats</a></li>
            <li><a class="nav-link" data-target="about-card">About</a></li>
            <li><a class="nav-link" data-target="services-card">Services</a></li>
            <li><a class="nav-link" data-target="clients-card">Clients</a></li>
            <li><a class="nav-link" data-target="contact-card">Contact</a></li>
            <li><a class="nav-link" data-target="socials-card">Socials</a></li>
            <li><a class="nav-link" data-target="faq-card">FAQ</a></li>
        </ul>
    </div>

    <div class="admin-container">

        <!-- About Section -->
        <div class="admin-card" id="about-card">
            <h2>About</h2>
            <form method="post">
                <div class="form-group">
                    <label>Vision</label>
                    <textarea name="vision" required><?= htmlspecialchars($data['vision'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Mission</label>
                    <textarea name="mission" required><?= htmlspecialchars($data['mission'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="update_about" class="btn">Update About</button>
            </form>
        </div>

        <!-- Stats Section -->
        <div class="admin-card" id="stats-card">
            <h2>Stats (Counters)</h2>
            <div class="split-layout">
                <div class="form-section">
                    <h3 id="stat-form-title" style="margin-top: 0;">Add New Stat</h3>
                    <form method="post" id="stat-form">
                        <input type="hidden" name="edit_stat_index" id="edit_stat_index" value="">
                        <div class="form-group">
                            <label>Icon (Emoji)</label>
                            <input type="text" name="stat_icon" id="stat_icon" required>
                        </div>
                        <div class="form-group">
                            <label>Number (Target)</label>
                            <input type="number" name="stat_number" id="stat_number" required>
                        </div>
                        <div class="form-group">
                            <label>Label</label>
                            <input type="text" name="stat_label" id="stat_label" required>
                        </div>
                        <button type="submit" name="save_stat" id="stat-submit-btn" class="btn">Add Stat</button>
                        <button type="button" id="stat-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
                    </form>
                </div>
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Icon</th>
                            <th>Target Number</th>
                            <th>Label</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['stats'] ?? [] as $stat): ?>
                        <tr>
                            <td><?= htmlspecialchars($stat['icon'] ?? '') ?></td>
                            <td><?= htmlspecialchars($stat['number'] ?? '') ?></td>
                            <td><?= htmlspecialchars($stat['label'] ?? '') ?></td>
                            <td>
                                <button type="button" class="btn edit-stat-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $stat['id'] ?>" data-icon="<?= htmlspecialchars($stat['icon'] ?? '') ?>" data-number="<?= htmlspecialchars($stat['number'] ?? '') ?>" data-label="<?= htmlspecialchars($stat['label'] ?? '') ?>">Edit</button>
                                <form method="post" style="display:inline;">
                                    <button type="submit" name="delete_stat" value="<?= $stat['id'] ?>" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="admin-card" id="services-card">
            <h2>Services</h2>
            <div class="split-layout">
                <div class="form-section">
                    <h3 id="service-form-title" style="margin-top: 0;">Add New Service</h3>
                    <form method="post" enctype="multipart/form-data" id="service-form">
                        <input type="hidden" name="edit_service_index" id="edit_service_index" value="">
                        <div class="form-group">
                            <label>Icon (Emoji or Text - Optional)</label>
                            <input type="text" name="service_icon" id="service_icon">
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="service_title" id="service_title" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="service_desc" id="service_desc" required></textarea>
                        </div>
                        <button type="submit" name="save_service" id="service-submit-btn" class="btn">Add Service</button>
                        <button type="button" id="service-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
                    </form>
                </div>
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Icon</th>
                            <th>Image URL</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['services'] ?? [] as $service): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['icon'] ?? '') ?></td>
                            <td>
                                <?php if(!empty($service['image'])): ?>
                                    <img src="<?= htmlspecialchars($service['image']) ?>" alt="Preview" style="max-width: 50px; max-height: 50px;">
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($service['title'] ?? '') ?></td>
                            <td><?= htmlspecialchars($service['description'] ?? '') ?></td>
                            <td>
                                <button type="button" class="btn edit-service-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $service['id'] ?>" data-icon="<?= htmlspecialchars($service['icon'] ?? '') ?>" data-image="<?= htmlspecialchars($service['image'] ?? '') ?>" data-title="<?= htmlspecialchars($service['title'] ?? '') ?>" data-desc="<?= htmlspecialchars($service['description'] ?? '') ?>">Edit</button>
                                <form method="post" style="display:inline;">
                                    <button type="submit" name="delete_service" value="<?= $service['id'] ?>" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="admin-card" id="projects-card">
            <h2>Products (Portfolio)</h2>
            <div class="split-layout">
                <div class="form-section">
                    <h3 id="project-form-title" style="margin-top: 0;">Add New Product</h3>
                    <form method="post" enctype="multipart/form-data" id="project-form">
                        <input type="hidden" name="edit_project_index" id="edit_project_index" value="">
                        <div class="form-group">
                            <label>Icon (Emoji or Text - Optional)</label>
                            <input type="text" name="project_icon" id="project_icon">
                        </div>
                        <div class="form-group">
                            <label>Image Upload (Local file - Optional)</label>
                            <input type="file" name="project_image_file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>OR Image URL (External link - Optional)</label>
                            <input type="url" name="project_image" id="project_image" placeholder="https://example.com/image.jpg">
                        </div>
                        <div class="form-group">
                            <label>Product Link URL (Optional)</label>
                            <input type="url" name="project_url" id="project_url" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="project_title" id="project_title" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="project_desc" id="project_desc" required></textarea>
                        </div>
                        <button type="submit" name="save_project" id="project-submit-btn" class="btn">Add Product</button>
                        <button type="button" id="project-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
                    </form>
                </div>
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Icon</th>
                            <th>Image URL</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['projects'] ?? [] as $project): ?>
                        <tr>
                            <td><?= htmlspecialchars($project['icon'] ?? '') ?></td>
                            <td>
                                <?php if(!empty($project['image'])): ?>
                                    <img src="<?= htmlspecialchars($project['image']) ?>" alt="Preview" style="max-width: 50px; max-height: 50px;">
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($project['title'] ?? '') ?></td>
                            <td><?= htmlspecialchars($project['description'] ?? '') ?></td>
                            <td>
                                <button type="button" class="btn edit-project-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $project['id'] ?>" data-icon="<?= htmlspecialchars($project['icon'] ?? '') ?>" data-image="<?= htmlspecialchars($project['image'] ?? '') ?>" data-title="<?= htmlspecialchars($project['title'] ?? '') ?>" data-desc="<?= htmlspecialchars($project['description'] ?? '') ?>" data-url="<?= htmlspecialchars($project['url'] ?? '') ?>">Edit</button>
                                <form method="post" style="display:inline;">
                                    <button type="submit" name="delete_project" value="<?= $project['id'] ?>" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- News Section -->
        <div class="admin-card active" id="news-card">
            <h2>News</h2>
            <div class="split-layout">
                <div class="form-section">
                    <h3 id="news-form-title" style="margin-top: 0;">Add News Item</h3>
                    <form method="post" enctype="multipart/form-data" id="news-form">
                        <input type="hidden" name="edit_news_index" id="edit_news_index" value="">
                        <div class="form-group">
                            <label>Date (YYYY-MM-DD)</label>
                            <input type="date" name="news_date" id="news_date" required>
                        </div>
                        <div class="form-group">
                            <label>Image Upload (Local file - Optional)</label>
                            <input type="file" name="news_image_file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>OR Image URL (External link - Optional)</label>
                            <input type="url" name="news_image" id="news_image" placeholder="https://example.com/news.jpg">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="news_title" id="news_title" required>
                            
                            <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: var(--text-secondary); cursor: pointer;">
                                <input type="checkbox" name="news_is_headline" id="news_is_headline" style="width: auto; margin: 0;">
                                Set as Featured Headline (Will appear first)
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="news_content" id="news_content" required></textarea>
                        </div>
                        <button type="submit" name="save_news" id="news-submit-btn" class="btn">Add News</button>
                        <button type="button" id="news-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
                    </form>
                </div>
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Image URL</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['news'] ?? [] as $news): ?>
                        <tr>
                            <td><?= htmlspecialchars($news['date'] ?? '') ?></td>
                            <td>
                                <?php if(!empty($news['image'])): ?>
                                    <img src="<?= htmlspecialchars($news['image']) ?>" alt="Preview" style="max-width: 50px; max-height: 50px;">
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($news['title'] ?? '') ?></td>
                            <td><?= htmlspecialchars($news['content'] ?? '') ?></td>
                            <td>
                                <button type="button" class="btn edit-news-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $news['id'] ?>" data-date="<?= htmlspecialchars($news['date'] ?? '') ?>" data-image="<?= htmlspecialchars($news['image'] ?? '') ?>" data-title="<?= htmlspecialchars($news['title'] ?? '') ?>" data-content="<?= htmlspecialchars($news['content'] ?? '') ?>" data-headline="<?= $news['is_headline'] ?? 0 ?>">Edit</button>
                                <form method="post" style="display:inline;">
                                    <button type="submit" name="delete_news" value="<?= $news['id'] ?>" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Clients Section -->
        <div class="admin-card" id="clients-card">
            <h2>Clients Logos</h2>
            <div class="split-layout">
                <div class="form-section">
                    <h3 id="client-form-title" style="margin-top: 0;">Add New Client</h3>
                    <form method="post" enctype="multipart/form-data" id="client-form">
                        <input type="hidden" name="edit_client_index" id="edit_client_index" value="">
                        <div class="form-group">
                            <label>Logo Upload (Local file - Optional)</label>
                            <input type="file" name="client_image_file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>OR Logo URL (External link - Optional)</label>
                            <input type="url" name="client_image" id="client_image" placeholder="https://example.com/logo.jpg">
                        </div>
                        <button type="submit" name="save_client" id="client-submit-btn" class="btn">Add Client</button>
                        <button type="button" id="client-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
                    </form>
                </div>
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Preview</th>
                            <th>Image URL</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['clients'] ?? [] as $client): ?>
                        <tr>
                            <td>
                                <?php if(!empty($client['image_url'])): ?>
                                    <img src="<?= htmlspecialchars(strpos($client['image_url'], 'http') === 0 ? $client['image_url'] : '../' . $client['image_url']) ?>" alt="Preview" style="max-width: 50px; max-height: 50px; object-fit: contain;">
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td style="word-break: break-all; max-width: 200px;"><?= htmlspecialchars($client['image_url'] ?? '') ?></td>
                            <td>
                                <button type="button" class="btn edit-client-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $client['id'] ?>" data-image="<?= htmlspecialchars($client['image_url'] ?? '') ?>">Edit</button>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                    <button type="submit" name="delete_client" value="<?= $client['id'] ?>" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="admin-card" id="contact-card">
            <h2>Contact Information</h2>
            <form method="post">
                <div class="form-group">
                    <label>LOCATION</label>
                    <textarea name="contact_address" required rows="3"><?= htmlspecialchars($data['contact']['address'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Telephone</label>
                    <input type="text" name="contact_tp" value="<?= htmlspecialchars($data['contact']['tp'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="contact_email" value="<?= htmlspecialchars($data['contact']['email'] ?? '') ?>">
                </div>
                <button type="submit" name="update_contact" class="btn">Update Contact</button>
            </form>
        </div>

        <!-- Social Section -->
        <div class="admin-card" id="socials-card">
            <h2>Social Media Links</h2>
            <form method="post">
                <div class="form-group">
                    <label>Facebook URL</label>
                    <input type="url" name="social_facebook" value="<?= htmlspecialchars($data['social_facebook'] ?? '') ?>" placeholder="Leave blank to hide">
                </div>
                <div class="form-group">
                    <label>Twitter (X) URL</label>
                    <input type="url" name="social_twitter" value="<?= htmlspecialchars($data['social_twitter'] ?? '') ?>" placeholder="Leave blank to hide">
                </div>
                <div class="form-group">
                    <label>Instagram URL</label>
                    <input type="url" name="social_instagram" value="<?= htmlspecialchars($data['social_instagram'] ?? '') ?>" placeholder="Leave blank to hide">
                </div>
                <div class="form-group">
                    <label>LinkedIn URL</label>
                    <input type="url" name="social_linkedin" value="<?= htmlspecialchars($data['social_linkedin'] ?? '') ?>" placeholder="Leave blank to hide">
                </div>
                <button type="submit" name="update_socials" class="btn">Update Social Links</button>
            </form>
        </div>

        <!-- FAQ Section -->
        <div class="admin-card" id="faq-card">
            <h2>Frequently Asked Questions</h2>
            <div class="split-layout">
                <div class="form-section">
                    <h3 id="faq-form-title" style="margin-top: 0;">Add New FAQ</h3>
                    <form method="post" id="faq-form">
                        <input type="hidden" name="edit_faq_index" id="edit_faq_index" value="">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="faq_question" id="faq_question" required>
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea name="faq_answer" id="faq_answer" required></textarea>
                        </div>
                        <button type="submit" name="save_faq" id="faq-submit-btn" class="btn">Add FAQ</button>
                        <button type="button" id="faq-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
                    </form>
                </div>
                <div class="table-section">
                    <table>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['faq'] ?? [] as $faq): ?>
                        <tr>
                            <td><?= htmlspecialchars($faq['question'] ?? '') ?></td>
                            <td><?= htmlspecialchars(substr($faq['answer'] ?? '', 0, 50)) ?>...</td>
                            <td style="white-space: nowrap;">
                                <button type="button" class="btn edit-faq-btn" 
                                    data-index="<?= $faq['id'] ?>" 
                                    data-question="<?= htmlspecialchars($faq['question'] ?? '') ?>" 
                                    data-answer="<?= htmlspecialchars($faq['answer'] ?? '') ?>"
                                    style="background-color: #f59e0b;">Edit</button>
                                <form method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                    <input type="hidden" name="delete_faq" value="<?= $faq['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const cards = document.querySelectorAll('.admin-card');

    // Check for saved tab
    const savedTab = localStorage.getItem('activeAdminTab');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            cards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
            
            // Save active tab
            localStorage.setItem('activeAdminTab', targetId);
        });
    });

    // Restore saved tab on load
    if (savedTab) {
        const targetLink = document.querySelector(`.nav-link[data-target="${savedTab}"]`);
        if (targetLink) {
            targetLink.click();
        }
    }

    // Stat Edit Logic
    const editStatBtns = document.querySelectorAll('.edit-stat-btn');
    const statCancelBtn = document.getElementById('stat-cancel-btn');
    if (statCancelBtn) {
        editStatBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_stat_index').value = this.getAttribute('data-index');
                document.getElementById('stat_icon').value = this.getAttribute('data-icon');
                document.getElementById('stat_number').value = this.getAttribute('data-number');
                document.getElementById('stat_label').value = this.getAttribute('data-label');
                document.getElementById('stat-form-title').innerText = 'Edit Stat';
                document.getElementById('stat-submit-btn').innerText = 'Update Stat';
                statCancelBtn.style.display = 'inline-block';
                document.getElementById('stat_number').focus();
            });
        });
        statCancelBtn.addEventListener('click', function() {
            document.getElementById('stat-form').reset();
            document.getElementById('edit_stat_index').value = '';
            document.getElementById('stat-form-title').innerText = 'Add New Stat';
            document.getElementById('stat-submit-btn').innerText = 'Add Stat';
            this.style.display = 'none';
        });
    }

    // Service Edit Logic
    const editServiceBtns = document.querySelectorAll('.edit-service-btn');
    const serviceCancelBtn = document.getElementById('service-cancel-btn');
    if (serviceCancelBtn) {
        editServiceBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_service_index').value = this.getAttribute('data-index');
                document.getElementById('service_icon').value = this.getAttribute('data-icon');
                document.getElementById('service_title').value = this.getAttribute('data-title');
                document.getElementById('service_desc').value = this.getAttribute('data-desc');
                document.getElementById('service-form-title').innerText = 'Edit Service';
                document.getElementById('service-submit-btn').innerText = 'Update Service';
                serviceCancelBtn.style.display = 'inline-block';
                document.getElementById('service_title').focus();
            });
        });
        serviceCancelBtn.addEventListener('click', function() {
            document.getElementById('service-form').reset();
            document.getElementById('edit_service_index').value = '';
            document.getElementById('service-form-title').innerText = 'Add New Service';
            document.getElementById('service-submit-btn').innerText = 'Add Service';
            this.style.display = 'none';
        });
    }

    // Project Edit Logic
    const editProjectBtns = document.querySelectorAll('.edit-project-btn');
    const projectCancelBtn = document.getElementById('project-cancel-btn');
    if (projectCancelBtn) {
        editProjectBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_project_index').value = this.getAttribute('data-index');
                document.getElementById('project_icon').value = this.getAttribute('data-icon');
                document.getElementById('project_image').value = this.getAttribute('data-image');
                document.getElementById('project_url').value = this.getAttribute('data-url');
                document.getElementById('project_title').value = this.getAttribute('data-title');
                document.getElementById('project_desc').value = this.getAttribute('data-desc');
                document.getElementById('project-form-title').innerText = 'Edit Product';
                document.getElementById('project-submit-btn').innerText = 'Update Product';
                projectCancelBtn.style.display = 'inline-block';
                document.getElementById('project_title').focus();
            });
        });
        projectCancelBtn.addEventListener('click', function() {
            document.getElementById('project-form').reset();
            document.getElementById('edit_project_index').value = '';
            document.getElementById('project-form-title').innerText = 'Add New Product';
            document.getElementById('project-submit-btn').innerText = 'Add Product';
            this.style.display = 'none';
        });
    }

    // News Edit Logic
    const editNewsBtns = document.querySelectorAll('.edit-news-btn');
    const newsCancelBtn = document.getElementById('news-cancel-btn');
    if (newsCancelBtn) {
        editNewsBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_news_index').value = this.getAttribute('data-index');
                document.getElementById('news_date').value = this.getAttribute('data-date');
                document.getElementById('news_image').value = this.getAttribute('data-image');
                document.getElementById('news_title').value = this.getAttribute('data-title');
                document.getElementById('news_is_headline').checked = this.getAttribute('data-headline') === '1';
                document.getElementById('news_content').value = this.getAttribute('data-content');
                document.getElementById('news-form-title').innerText = 'Edit News Item';
                document.getElementById('news-submit-btn').innerText = 'Update News';
                newsCancelBtn.style.display = 'inline-block';
                document.getElementById('news_title').focus();
            });
        });
        newsCancelBtn.addEventListener('click', function() {
            document.getElementById('news-form').reset();
            document.getElementById('edit_news_index').value = '';
            document.getElementById('news-form-title').innerText = 'Add News Item';
            document.getElementById('news-submit-btn').innerText = 'Add News';
            this.style.display = 'none';
        });
    }

    // Client Edit Logic
    const editClientBtns = document.querySelectorAll('.edit-client-btn');
    const clientCancelBtn = document.getElementById('client-cancel-btn');
    if (clientCancelBtn) {
        editClientBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_client_index').value = this.getAttribute('data-index');
                document.getElementById('client_image').value = this.getAttribute('data-image');
                document.getElementById('client-form-title').innerText = 'Edit Client';
                document.getElementById('client-submit-btn').innerText = 'Update Client';
                clientCancelBtn.style.display = 'inline-block';
            });
        });
        clientCancelBtn.addEventListener('click', function() {
            document.getElementById('client-form').reset();
            document.getElementById('edit_client_index').value = '';
            document.getElementById('client-form-title').innerText = 'Add New Client';
            document.getElementById('client-submit-btn').innerText = 'Add Client';
            this.style.display = 'none';
        });
    }

    // FAQ Edit Logic
    const editFaqBtns = document.querySelectorAll('.edit-faq-btn');
    const faqCancelBtn = document.getElementById('faq-cancel-btn');
    if (faqCancelBtn) {
        editFaqBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_faq_index').value = this.getAttribute('data-index');
                document.getElementById('faq_question').value = this.getAttribute('data-question');
                document.getElementById('faq_answer').value = this.getAttribute('data-answer');
                document.getElementById('faq-form-title').innerText = 'Edit FAQ';
                document.getElementById('faq-submit-btn').innerText = 'Update FAQ';
                faqCancelBtn.style.display = 'inline-block';
                document.getElementById('faq_question').focus();
            });
        });
        faqCancelBtn.addEventListener('click', function() {
            document.getElementById('faq-form').reset();
            document.getElementById('edit_faq_index').value = '';
            document.getElementById('faq-form-title').innerText = 'Add New FAQ';
            document.getElementById('faq-submit-btn').innerText = 'Add FAQ';
            this.style.display = 'none';
        });
    }
});
</script>

</body>
</html>
