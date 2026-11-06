<?php
/**
 * Script sementara untuk menjalankan migration.
 * HAPUS FILE INI SETELAH SELESAI!
 */

// Pastikan hanya bisa diakses dengan key rahasia
if (($_GET['key'] ?? '') !== 'sinfas-migrate-2026') {
    http_response_code(403);
    die('Forbidden');
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>🔧 Running Migration...</h2><pre>";

try {
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo Illuminate\Support\Facades\Artisan::output();
    echo "\n\n✅ Migration berhasil!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "</pre>";
echo "<br><p style='color:red;font-weight:bold;'>⚠️ HAPUS FILE INI SETELAH SELESAI! (public/run-migrate.php)</p>";
