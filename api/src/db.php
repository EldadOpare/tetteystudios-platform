<?php
require_once __DIR__ . '/Supabase.php';

// Set Supabase URL and Key
$supabaseUrl = 'https://qqwwtartsqtxyoirsiio.supabase.co';
$supabaseKey = 'sb_publishable__54GYg9DdVMepcbgDo1W-A_5T2uKOcu';

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