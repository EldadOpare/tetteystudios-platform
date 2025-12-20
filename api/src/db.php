<?php
require_once __DIR__ . '/Supabase.php';

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

    // Create separate instance with service role key for storage operations
    if (!empty($supabaseServiceKey)) {
        $supabaseService = new Supabase($supabaseUrl, $supabaseServiceKey);
    } else {
        // Fallback to anon key if service key not available
        $supabaseService = $supabase;
    }

} catch (Exception $e) {
    die("Supabase initialization failed: " . $e->getMessage());
}

?>