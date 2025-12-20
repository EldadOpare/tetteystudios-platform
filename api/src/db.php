<?php
require_once __DIR__ . '/Supabase.php';
require_once __DIR__ . '/load_env.php';


$supabaseUrl = getenv('SUPABASE_URL');

$supabaseKey = getenv('SUPABASE_ANON_KEY') ?: getenv('SUPABASE_KEY');
$supabaseServiceKey = getenv('SUPABASE_SERVICE_ROLE_KEY');


if (empty($supabaseUrl) || empty($supabaseKey)) {
    die('Supabase credentials are missing.');
}

try {

    $supabase = new Supabase($supabaseUrl, $supabaseKey);


    if (!empty($supabaseServiceKey)) {
        $supabaseService = new Supabase($supabaseUrl, $supabaseServiceKey);
    } else {
   
        $supabaseService = $supabase;
    }

} catch (Exception $e) {
    die("Supabase initialization failed: " . $e->getMessage());
}

?>