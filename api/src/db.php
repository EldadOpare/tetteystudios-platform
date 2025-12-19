<?php
require_once __DIR__ . '/Supabase.php';

// Load environment variables from .env file or use $_ENV
$supabaseUrl = getenv('SUPABASE_URL') ?: $_ENV['SUPABASE_URL'] ?? '';
$supabaseKey = getenv('SUPABASE_KEY') ?: $_ENV['SUPABASE_KEY'] ?? '';

if (empty($supabaseUrl) || empty($supabaseKey)) {
    die("Supabase configuration missing. Please set SUPABASE_URL and SUPABASE_KEY environment variables.");
}

try {
    $supabase = new Supabase($supabaseUrl, $supabaseKey);

} catch (Exception $e) {
    die("Supabase initialization failed: " . $e->getMessage());
}

?>