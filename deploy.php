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

// Copy index.php
if (file_exists("$source_dir/index.php")) {
    copy("$source_dir/index.php", "$target_dir/index.php");
    echo "Successfully copied index.php to the main website!<br>";
}

// Copy logout.php
if (file_exists("$source_dir/logout.php")) {
    copy("$source_dir/logout.php", "$target_dir/logout.php");
    echo "Successfully copied logout.php to the main website!<br>";
}



echo "<h3>DEPLOYMENT COMPLETE!</h3>";
echo "<p>You can now go to <a href='/admin/login'>https://fishifox.com/admin/login</a> to log in to your main website!</p>";
