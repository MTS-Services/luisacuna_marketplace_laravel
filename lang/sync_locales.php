<?php

/**
 * One-off script: sync all keys from lang/en.json into de, es, fr, it, jp.
 * Preserves existing translations; missing keys get the English value as placeholder.
 * Run from project root: php lang/sync_locales.php
 */
$langDir = __DIR__;
$enPath = $langDir.'/en.json';
$locales = ['de', 'es', 'fr', 'it', 'jp'];

$en = json_decode(file_get_contents($enPath), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    fwrite(STDERR, "Invalid en.json\n");
    exit(1);
}

foreach ($locales as $locale) {
    $path = $langDir.'/'.$locale.'.json';
    if (! is_file($path)) {
        echo "Skip {$locale}: file not found\n";

        continue;
    }
    $current = json_decode(file_get_contents($path), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        fwrite(STDERR, "Invalid {$locale}.json\n");

        continue;
    }
    $merged = [];
    foreach ($en as $key => $enValue) {
        $merged[$key] = $current[$key] ?? $enValue;
    }
    $json = json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($path, $json."\n");
    $added = count($merged) - count($current);
    echo "{$locale}.json: ".count($merged).' keys'.($added > 0 ? " (+{$added} new)" : '')."\n";
}

echo "Done.\n";
