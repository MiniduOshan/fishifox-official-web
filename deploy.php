<?php
// This script will copy the files from the sub-folder to the main website folder.
$source_dir = __DIR__ . '/admin';
$target_dir = __DIR__ . '/../admin';

if (!is_dir($target_dir)) {
    die("Error: Cannot find the main admin directory at $target_dir. Permissions issue or wrong path.");
}

// Copy login.php
if (file_exists("$source_dir/login.php")) {
    copy("$source_dir/login.php", "$target_dir/login.php");
    echo "Successfully copied login.php to the main website!<br>";
}

// Copy dashboard.php
if (file_exists("$source_dir/dashboard.php")) {
    copy("$source_dir/dashboard.php", "$target_dir/dashboard.php");
    echo "Successfully copied dashboard.php to the main website!<br>";
}

// Copy logout.php
if (file_exists("$source_dir/logout.php")) {
    copy("$source_dir/logout.php", "$target_dir/logout.php");
    echo "Successfully copied logout.php to the main website!<br>";
}

// Copy style.css
$css_source = __DIR__ . '/assets/css/style.css';
$css_target = __DIR__ . '/../assets/css/style.css';
if (file_exists($css_source)) {
    copy($css_source, $css_target);
    echo "Successfully copied style.css to the main website!<br>";
}

// Copy navbar.php
$nav_source = __DIR__ . '/includes/navbar.php';
$nav_target = __DIR__ . '/../includes/navbar.php';
if (file_exists($nav_source)) {
    copy($nav_source, $nav_target);
    echo "Successfully copied navbar.php to the main website!<br>";
}

// Copy .htaccess
$htaccess_source = __DIR__ . '/.htaccess';
$htaccess_target = __DIR__ . '/../.htaccess';
if (file_exists($htaccess_source)) {
    copy($htaccess_source, $htaccess_target);
    echo "Successfully copied .htaccess to the main website!<br>";
}



echo "<h3>DEPLOYMENT COMPLETE!</h3>";
echo "<p>You can now go to <a href='/admin/login'>https://fishifox.com/admin/login</a> to log in to your main website!</p>";
