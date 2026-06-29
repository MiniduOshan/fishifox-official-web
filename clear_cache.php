<?php
$cleared = false;
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache reset successfully.<br>";
    $cleared = true;
}
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
    echo "APCu cache cleared successfully.<br>";
    $cleared = true;
}
if (!$cleared) {
    echo "No caching mechanism detected or functions are disabled. Try touching the files to update their timestamps.<br>";
}

// Another trick: touch the directory to update its timestamp, which sometimes invalidates caches
touch(__DIR__ . '/admin/login.php');
touch(__DIR__ . '/admin/index.php');
echo "Done. Please try logging in again.";
