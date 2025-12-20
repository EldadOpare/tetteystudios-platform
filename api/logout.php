<?php
require_once __DIR__ . '/src/session_init.php';
require_once __DIR__ . '/src/auth.php';
logout();
header('Location: index.php');
exit;
