<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class EnvEditorService
{
    protected string $envPath;
    protected string $backupPath;

    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->backupPath = base_path('.env.backup');
    }

    /**
     * Get current ENV value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return env($key, $default);
    }

    /**
     * Update single ENV variable
     */
    public function set(string $key, mixed $value): bool
    {
        return $this->updateMany([$key => $value]);
    }

    /**
     * Update multiple ENV variables at once
     */
    public function updateMany(array $data): bool
    {
        if (!$this->isWritable()) {
            Log::error('ENV file is not writable: ' . $this->envPath);
            return false;
        }

        try {
            // Create backup first
            $this->createBackup();

            $content = file_get_contents($this->envPath);

            foreach ($data as $key => $value) {
                $content = $this->replaceOrAddKey($content, $key, $value);
            }

            // Write with exclusive lock
            if (file_put_contents($this->envPath, $content, LOCK_EX) === false) {
                throw new Exception('Failed to write to .env file');
            }

            return true;
        } catch (Exception $e) {
            Log::error('ENV update failed: ' . $e->getMessage());
            $this->restoreBackup();
            return false;
        }
    }

    /**
     * Replace or add a key in ENV content
     */
    protected function replaceOrAddKey(string $content, string $key, mixed $value): string
    {
        $key = strtoupper(trim($key));
        $formattedValue = $this->formatValue($value);

        // Pattern to match the key (handles quoted and unquoted values)
        $pattern = "/^" . preg_quote($key, '/') . "=.*$/m";

        if (preg_match($pattern, $content)) {
            // Replace existing key
            $content = preg_replace($pattern, "{$key}={$formattedValue}", $content);
        } else {
            // Add new key at the end
            $content = rtrim($content) . "\n{$key}={$formattedValue}";
        }

        return $content;
    }

    /**
     * Format value for ENV file
     */
    protected function formatValue(mixed $value): string
    {
        // Handle null
        if (is_null($value)) {
            return '';
        }

        // Handle boolean
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        // Handle numeric (keep as-is for integers)
        if (is_numeric($value) && !str_contains((string)$value, ' ')) {
            return (string)$value;
        }

        $value = (string)$value;

        // Check if value needs quotes
        $needsQuotes = $value === '' ||
            preg_match('/[\s#"\'\\\\$]/', $value) ||
            str_contains($value, '=');

        if ($needsQuotes) {
            // Escape backslashes and double quotes
            $escaped = str_replace(['\\', '"'], ['\\\\', '\\"'], $value);
            return '"' . $escaped . '"';
        }

        return $value;
    }

    /**
     * Check if ENV file is writable
     */
    public function isWritable(): bool
    {
        return file_exists($this->envPath) && is_writable($this->envPath);
    }

    /**
     * Create backup of ENV file
     */
    protected function createBackup(): bool
    {
        try {
            return copy($this->envPath, $this->backupPath);
        } catch (Exception $e) {
            Log::warning('Could not create ENV backup: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Restore from backup
     */
    public function restoreBackup(): bool
    {
        if (!file_exists($this->backupPath)) {
            return false;
        }

        try {
            return copy($this->backupPath, $this->envPath);
        } catch (Exception $e) {
            Log::error('Could not restore ENV backup: ' . $e->getMessage());
            return false;
        }
    }
}
