<?php
require_once __DIR__ . '/Supabase.php';

// Set Supabase URL and Key from environment variables
$supabaseUrl = getenv('SUPABASE_URL');
$supabaseKey = getenv('SUPABASE_ANON_KEY');

// Validate Supabase credentials
if (empty($supabaseUrl) || empty($supabaseKey)) {
    die('Supabase credentials are missing.');
}

try {
    // Initialize Supabase
    $supabase = new Supabase($supabaseUrl, $supabaseKey);

} catch (Exception $e) {
    die("Supabase initialization failed: " . $e->getMessage());
}

?>