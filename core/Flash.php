<?php
namespace Shibaji\Core;

class Flash
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [];
        }
    }

    /**
     * Add a flash message with a specific key.
     *
     * @param string $key
     * @param string $message
     */
    public function add(string $key, string $message): void
    {
        if (!isset($_SESSION['flash_messages'][$key])) {
            $_SESSION['flash_messages'][$key] = [];
        }

        $_SESSION['flash_messages'][$key][] = $message;
    }

    /**
     * Check if there are any flash messages for a specific key.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION['flash_messages'][$key]) && !empty($_SESSION['flash_messages'][$key]);
    }

    /**
     * Get all flash messages for a specific key.
     *
     * @param string $key
     * @return string|mixed
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            $messages = $_SESSION['flash_messages'][$key];
            unset($_SESSION['flash_messages'][$key]);
            return $messages;
        }

        return null;
    }

    /**
     * Clear all flash messages.
     */
    public function clear(): void
    {
        unset($_SESSION['flash_messages']);
    }
}
