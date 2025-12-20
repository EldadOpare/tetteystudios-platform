<?php
require_once __DIR__ . '/Supabase.php';
require_once __DIR__ . '/load_env.php';

// Set Supabase URL and Key from environment variables
$supabaseUrl = getenv('SUPABASE_URL');
$supabaseKey = getenv('SUPABASE_ANON_KEY') ?: getenv('SUPABASE_KEY');
$supabaseServiceKey = getenv('SUPABASE_SERVICE_ROLE_KEY');

// Validate Supabase credentials
if (empty($supabaseUrl) || empty($supabaseKey)) {
    die('Supabase credentials are missing.');
}

try {
    $supabase = new Supabase($supabaseUrl, $supabaseKey);

    // Create service instance for storage uploads that bypass RLS
    if (!empty($supabaseServiceKey)) {
        $supabaseStorage = new Supabase($supabaseUrl, $supabaseServiceKey);
    } else {
        $supabaseStorage = $supabase;
    }
} catch (Exception $e) {
    die("Supabase initialization failed: " . $e->getMessage());
}

?>