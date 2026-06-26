<?php
$dataFile = '../data/content.json';
$data = json_decode(file_get_contents($dataFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_about'])) {
        $data['vision'] = $_POST['vision'];
        $data['mission'] = $_POST['mission'];
    } elseif (isset($_POST['save_service'])) {
        $icon = $_POST['service_icon'];
        $image = $_POST['service_image'];
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
            $index = $_POST['edit_service_index'];
            if (empty($image) && empty($_FILES['service_image_file']['name'])) {
                $image = $data['services'][$index]['image'] ?? '';
            }
            $data['services'][$index] = ['icon' => $icon, 'image' => $image, 'title' => $title, 'description' => $desc];
        } else {
            $data['services'][] = ['icon' => $icon, 'image' => $image, 'title' => $title, 'description' => $desc];
        }
    } elseif (isset($_POST['delete_service'])) {
        array_splice($data['services'], $_POST['delete_service'], 1);
    } elseif (isset($_POST['save_project'])) {
        $icon = $_POST['project_icon'];
        $image = $_POST['project_image'];
        $title = $_POST['project_title'];
        $desc = $_POST['project_desc'];

        if (isset($_FILES['project_image_file']) && $_FILES['project_image_file']['error'] == 0) {
            $fileName = time() . '_' . basename($_FILES['project_image_file']['name']);
            $targetPath = '../assets/images/uploads/' . $fileName;
            if (move_uploaded_file($_FILES['project_image_file']['tmp_name'], $targetPath)) {
                $image = 'assets/images/uploads/' . $fileName;
            }
        }

        if (isset($_POST['edit_project_index']) && $_POST['edit_project_index'] !== '') {
            $index = $_POST['edit_project_index'];
            if (empty($image) && empty($_FILES['project_image_file']['name'])) {
                $image = $data['projects'][$index]['image'] ?? '';
            }
            $data['projects'][$index] = ['icon' => $icon, 'image' => $image, 'title' => $title, 'description' => $desc];
        } else {
            $data['projects'][] = ['icon' => $icon, 'image' => $image, 'title' => $title, 'description' => $desc];
        }
    } elseif (isset($_POST['delete_project'])) {
        array_splice($data['projects'], $_POST['delete_project'], 1);
    } elseif (isset($_POST['save_news'])) {
        $date = $_POST['news_date'];
        $title = $_POST['news_title'];
        $image = $_POST['news_image'];
        $content = $_POST['news_content'];

        if (isset($_FILES['news_image_file']) && $_FILES['news_image_file']['error'] == 0) {
            $fileName = time() . '_' . basename($_FILES['news_image_file']['name']);
            $targetPath = '../assets/images/uploads/' . $fileName;
            if (move_uploaded_file($_FILES['news_image_file']['tmp_name'], $targetPath)) {
                $image = 'assets/images/uploads/' . $fileName;
            }
        }

        if (isset($_POST['edit_news_index']) && $_POST['edit_news_index'] !== '') {
            $index = $_POST['edit_news_index'];
            if (empty($image) && empty($_FILES['news_image_file']['name'])) {
                $image = $data['news'][$index]['image'] ?? '';
            }
            $data['news'][$index] = ['date' => $date, 'title' => $title, 'image' => $image, 'content' => $content];
        } else {
            $data['news'][] = ['date' => $date, 'title' => $title, 'image' => $image, 'content' => $content];
        }
    } elseif (isset($_POST['delete_news'])) {
        array_splice($data['news'], $_POST['delete_news'], 1);
    } elseif (isset($_POST['update_clients'])) {
        $clientsStr = $_POST['clients'];
        $clientsArr = array_map('trim', explode("\n", $clientsStr));
        $data['clients'] = array_filter($clientsArr);
    } elseif (isset($_POST['save_stat'])) {
        $icon = $_POST['stat_icon'];
        $number = $_POST['stat_number'];
        $label = $_POST['stat_label'];
        if (isset($_POST['edit_stat_index']) && $_POST['edit_stat_index'] !== '') {
            $data['stats'][$_POST['edit_stat_index']] = ['icon' => $icon, 'number' => $number, 'label' => $label];
        } else {
            $data['stats'][] = ['icon' => $icon, 'number' => $number, 'label' => $label];
        }
    } elseif (isset($_POST['delete_stat'])) {
        array_splice($data['stats'], $_POST['delete_stat'], 1);
    } elseif (isset($_POST['update_contact'])) {
        $data['contact']['address'] = $_POST['contact_address'];
    }

    if (!isset($data['stats'])) {
        $data['stats'] = [
            ['icon' => '👥', 'number' => 85, 'label' => 'Active Clients'],
            ['icon' => '📊', 'number' => 450, 'label' => 'Projects Done'],
            ['icon' => '🌟', 'number' => 27, 'label' => 'Team Advisors'],
            ['icon' => '🏆', 'number' => 15, 'label' => 'Glorious Years']
        ];
    }
    if (!isset($data['contact'])) {
        $data['contact'] = ['address' => 'No. 146/120D, Salmal Place, Mattegoda, Kottawa, Sri Lanka'];
    }

    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FishiFox</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="admin-header">
    <h1>FishiFox Admin Dashboard</h1>
    <a href="../index.php" target="_blank">View Website</a>
</div>

<div class="admin-layout">
    <div class="admin-sidebar">
        <ul>
            <li><a class="nav-link active" data-target="about-card">Vision & Mission</a></li>
            <li><a class="nav-link" data-target="stats-card">Stats</a></li>
            <li><a class="nav-link" data-target="services-card">Services</a></li>
            <li><a class="nav-link" data-target="projects-card">Projects</a></li>
            <li><a class="nav-link" data-target="news-card">News</a></li>
            <li><a class="nav-link" data-target="clients-card">Clients</a></li>
            <li><a class="nav-link" data-target="contact-card">Contact</a></li>
        </ul>
    </div>

    <div class="admin-container">

        <!-- About Section -->
        <div class="admin-card active" id="about-card">
            <h2>Vision & Mission</h2>
            <form method="post">
                <div class="form-group">
                    <label>Vision</label>
                    <textarea name="vision" required><?= htmlspecialchars($data['vision'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Mission</label>
                    <textarea name="mission" required><?= htmlspecialchars($data['mission'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="update_about" class="btn">Update Vision & Mission</button>
            </form>
        </div>

        <!-- Stats Section -->
        <div class="admin-card" id="stats-card">
            <h2>Stats (Counters)</h2>
            <table>
                <tr>
                    <th>Icon</th>
                    <th>Target Number</th>
                    <th>Label</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($data['stats'] ?? [] as $index => $stat): ?>
                <tr>
                    <td><?= htmlspecialchars($stat['icon'] ?? '') ?></td>
                    <td><?= htmlspecialchars($stat['number'] ?? '') ?></td>
                    <td><?= htmlspecialchars($stat['label'] ?? '') ?></td>
                    <td>
                        <button type="button" class="btn edit-stat-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $index ?>" data-icon="<?= htmlspecialchars($stat['icon'] ?? '') ?>" data-number="<?= htmlspecialchars($stat['number'] ?? '') ?>" data-label="<?= htmlspecialchars($stat['label'] ?? '') ?>">Edit</button>
                        <form method="post" style="display:inline;">
                            <button type="submit" name="delete_stat" value="<?= $index ?>" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h3 id="stat-form-title">Add New Stat</h3>
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

        <!-- Services Section -->
        <div class="admin-card" id="services-card">
            <h2>Services</h2>
            <table>
                <tr>
                    <th>Icon</th>
                    <th>Image URL</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($data['services'] ?? [] as $index => $service): ?>
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
                        <button type="button" class="btn edit-service-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $index ?>" data-icon="<?= htmlspecialchars($service['icon'] ?? '') ?>" data-image="<?= htmlspecialchars($service['image'] ?? '') ?>" data-title="<?= htmlspecialchars($service['title'] ?? '') ?>" data-desc="<?= htmlspecialchars($service['description'] ?? '') ?>">Edit</button>
                        <form method="post" style="display:inline;">
                            <button type="submit" name="delete_service" value="<?= $index ?>" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h3 id="service-form-title">Add New Service</h3>
            <form method="post" enctype="multipart/form-data" id="service-form">
                <input type="hidden" name="edit_service_index" id="edit_service_index" value="">
                <div class="form-group">
                    <label>Icon (Emoji or Text - Optional)</label>
                    <input type="text" name="service_icon" id="service_icon">
                </div>
                <div class="form-group">
                    <label>Image Upload (Local file - Optional)</label>
                    <input type="file" name="service_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>OR Image URL (External link - Optional)</label>
                    <input type="url" name="service_image" id="service_image" placeholder="https://example.com/image.jpg">
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

        <!-- Projects Section -->
        <div class="admin-card" id="projects-card">
            <h2>Projects (Portfolio)</h2>
            <table>
                <tr>
                    <th>Icon</th>
                    <th>Image URL</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($data['projects'] ?? [] as $index => $project): ?>
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
                        <button type="button" class="btn edit-project-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $index ?>" data-icon="<?= htmlspecialchars($project['icon'] ?? '') ?>" data-image="<?= htmlspecialchars($project['image'] ?? '') ?>" data-title="<?= htmlspecialchars($project['title'] ?? '') ?>" data-desc="<?= htmlspecialchars($project['description'] ?? '') ?>">Edit</button>
                        <form method="post" style="display:inline;">
                            <button type="submit" name="delete_project" value="<?= $index ?>" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h3 id="project-form-title">Add New Project</h3>
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
                    <label>Title</label>
                    <input type="text" name="project_title" id="project_title" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="project_desc" id="project_desc" required></textarea>
                </div>
                <button type="submit" name="save_project" id="project-submit-btn" class="btn">Add Project</button>
                <button type="button" id="project-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
            </form>
        </div>

        <!-- News Section -->
        <div class="admin-card" id="news-card">
            <h2>News</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Image URL</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($data['news'] ?? [] as $index => $news): ?>
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
                        <button type="button" class="btn edit-news-btn" style="background:#f39c12; margin-bottom:5px;" data-index="<?= $index ?>" data-date="<?= htmlspecialchars($news['date'] ?? '') ?>" data-image="<?= htmlspecialchars($news['image'] ?? '') ?>" data-title="<?= htmlspecialchars($news['title'] ?? '') ?>" data-content="<?= htmlspecialchars($news['content'] ?? '') ?>">Edit</button>
                        <form method="post" style="display:inline;">
                            <button type="submit" name="delete_news" value="<?= $index ?>" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h3 id="news-form-title">Add News Item</h3>
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
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea name="news_content" id="news_content" required></textarea>
                </div>
                <button type="submit" name="save_news" id="news-submit-btn" class="btn">Add News</button>
                <button type="button" id="news-cancel-btn" class="btn" style="display:none; background:#7f8c8d;">Cancel</button>
            </form>
        </div>

        <!-- Clients Section -->
        <div class="admin-card" id="clients-card">
            <h2>Clients Logos</h2>
            <form method="post">
                <div class="form-group">
                    <label>Client Logo URLs (One external link per line, e.g., https://example.com/logo.png)</label>
                    <textarea name="clients" required rows="6"><?= htmlspecialchars(implode("\n", $data['clients'] ?? [])) ?></textarea>
                </div>
                <button type="submit" name="update_clients" class="btn">Update Clients</button>
            </form>
        </div>

        <!-- Contact Section -->
        <div class="admin-card" id="contact-card">
            <h2>Contact Information</h2>
            <form method="post">
                <div class="form-group">
                    <label>Headquarters Address</label>
                    <textarea name="contact_address" required rows="3"><?= htmlspecialchars($data['contact']['address'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="update_contact" class="btn">Update Contact</button>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const cards = document.querySelectorAll('.admin-card');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            cards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });

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
                document.getElementById('service_image').value = this.getAttribute('data-image');
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
                document.getElementById('project_title').value = this.getAttribute('data-title');
                document.getElementById('project_desc').value = this.getAttribute('data-desc');
                document.getElementById('project-form-title').innerText = 'Edit Project';
                document.getElementById('project-submit-btn').innerText = 'Update Project';
                projectCancelBtn.style.display = 'inline-block';
                document.getElementById('project_title').focus();
            });
        });
        projectCancelBtn.addEventListener('click', function() {
            document.getElementById('project-form').reset();
            document.getElementById('edit_project_index').value = '';
            document.getElementById('project-form-title').innerText = 'Add New Project';
            document.getElementById('project-submit-btn').innerText = 'Add Project';
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
});
</script>

</body>
</html>
