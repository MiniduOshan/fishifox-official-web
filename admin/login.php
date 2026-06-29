<?php
ob_start();
require_once '../config/database.php';

// Check if already logged in via cookie
if (isset($_COOKIE['fishifox_admin_auth'])) {
    $parts = explode('::', base64_decode($_COOKIE['fishifox_admin_auth']));
    if (count($parts) === 2) {
        $stmt = $pdo->prepare("SELECT password FROM admins WHERE email = ?");
        $stmt->execute([$parts[0]]);
        $dbAdmin = $stmt->fetch();
        if ($dbAdmin && $dbAdmin['password'] === $parts[1]) {
            header('Location: index.php');
            exit;
        }
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $pdo->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE ip_address = ?");
    $stmt->execute([$ip]);
    $attemptRecord = $stmt->fetch();

    if ($attemptRecord && $attemptRecord['attempts'] >= 5) {
        $lastAttemptTime = strtotime($attemptRecord['last_attempt']);
        if (time() - $lastAttemptTime < 900) { // 15 minutes = 900 seconds
            die("Too many login failures. Access temporarily suspended for 15 minutes.");
        } else {
            // Reset after 15 minutes
            $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = 0 WHERE ip_address = ?");
            $stmt->execute([$ip]);
        }
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            // Reset attempts on success
            $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
            $stmt->execute([$ip]);

            // Use secure cookie instead of broken server sessions
            $cookieData = base64_encode($admin['email'] . '::' . $admin['password']);
            setcookie('fishifox_admin_auth', $cookieData, time() + 86400 * 7, '/');

            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
            
            // Increment attempts
            if ($attemptRecord) {
                $stmt = $pdo->prepare("UPDATE login_attempts SET attempts = attempts + 1, last_attempt = NOW() WHERE ip_address = ?");
                $stmt->execute([$ip]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO login_attempts (ip_address, attempts, last_attempt) VALUES (?, 1, NOW())");
                $stmt->execute([$ip]);
            }
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - FishiFox</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f8; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .login-container h2 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; color: #666; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #3498db; color: white; border: none; padding: 10px 15px; width: 100%; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #2980b9; }
        .error { color: #e74c3c; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
