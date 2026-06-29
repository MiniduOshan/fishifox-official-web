<?php
setcookie('fishifox_admin_auth', '', time() - 3600, '/');
header('Location: login');
exit;
