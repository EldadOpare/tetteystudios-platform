<?php
// Initialize session system for Vercel serverless
// This must be included BEFORE session_start() is called

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/session_handler.php';

// Only configure if session hasn't started yet
if (session_status() === PHP_SESSION_NONE) {
    // Configure session cookies
    ini_set('session.use_cookies', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? '1' : '0');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.gc_maxlifetime', '86400'); // 24 hours
    ini_set('session.cookie_lifetime', '86400'); // 24 hours

    // Set custom session handler for database storage
    $handler = new SupabaseSessionHandler($supabase, 86400);
    session_set_save_handler($handler, true);

    // Now start the session with our custom handler
    session_start();
}
