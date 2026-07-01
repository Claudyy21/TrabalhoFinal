<?php
/**
 * Sync images from Aula10 to ClientePedidos for offline use.
 * Usage:
 *   php sync_images.php [--source="C:\xampp\htdocs\Aula10\public\uploads\produtos"] [--dest="public/assets/img/produtos"] [--force]
 */

// Default paths
$cwd = dirname(__DIR__);
$defaultSource = 'C:\\xampp\\htdocs\\Aula10\\public\\uploads\\produtos\\';
$defaultDest = $cwd . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'produtos' . DIRECTORY_SEPARATOR;

$options = getopt('', ['source::', 'dest::', 'force']);
$source = $options['source'] ?? $defaultSource;
$dest = $options['dest'] ?? $defaultDest;
$force = array_key_exists('force', $options);

// Normalize paths
$source = rtrim(str_replace('/', DIRECTORY_SEPARATOR, $source), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$dest = rtrim(str_replace('/', DIRECTORY_SEPARATOR, $dest), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

if (!is_dir($source)) {
    fwrite(STDERR, "Source directory not found: $source\n");
    exit(2);
}

if (!is_dir($dest)) {
    if (!mkdir($dest, 0777, true)) {
        fwrite(STDERR, "Failed to create destination directory: $dest\n");
        exit(3);
    }
}

$allowed = ['jpg','jpeg','png','gif','webp','bmp'];
$files = scandir($source);
$copied = 0;
$skipped = 0;
$errors = 0;

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) continue;

    $src = $source . $file;
    $dst = $dest . $file;

    if (file_exists($dst) && !$force) {
        $skipped++;
        echo "SKIP: $file (exists)\n";
        continue;
    }

    if (@copy($src, $dst)) {
        $copied++;
        echo "COPIED: $file\n";
    } else {
        $errors++;
        echo "ERROR copying: $file\n";
    }
}

echo "\nSummary:\n";
echo "  Copied: $copied\n";
echo "  Skipped: $skipped\n";
echo "  Errors: $errors\n";

exit($errors > 0 ? 1 : 0);
