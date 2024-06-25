<?php
namespace Shibaji\Core;

class Env
{
    /**
     * Load environment variables from .env file.
     *
     * @param string $filePath The path to the .env file.
     * @return void
     * @throws \Exception If the .env file is not found or readable.
     */
    public static function load(string $filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception("The .env file '{$filePath}' does not exist or is not readable.");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Ignore commented lines
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;

                // Optionally, set environment variables in $_SERVER too
                if (!array_key_exists($key, $_SERVER)) {
                    $_SERVER[$key] = $value;
                }
            }
        }
    }

    /**
     * Get an environment variable value by key.
     *
     * @param string $key The environment variable key.
     * @param mixed $default Optional default value if key is not found.
     * @return mixed|null The value of the environment variable or null if not found.
     */
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}