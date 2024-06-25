<?php

namespace Shibaji\Security;

class CSRF
{
    protected static string $tokenName = '_csrf_token';

    /**
     * Generate CSRF token and store in session.
     *
     * @return string The generated CSRF token.
     */
    public static function generateToken(): string
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $token = bin2hex(random_bytes(32)); // Generate a random token
        $_SESSION[self::$tokenName] = $token;

        return $token;
    }

    /**
     * Verify CSRF token.
     *
     * @param string $token The token to verify.
     * @return bool Returns true if token is valid, false otherwise.
     */
    public static function verifyToken(string $token): bool
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        // Check if session token exists and matches the provided token
        return isset($_SESSION[self::$tokenName]) && $_SESSION[self::$tokenName] === $token;
    }

    /**
     * Get the CSRF token name.
     *
     * @return string The CSRF token name.
     */
    public static function getTokenName(): string
    {
        return self::$tokenName;
    }

    /**
     * Get the CSRF token value.
     *
     * @return string|null The CSRF token value or null if not set.
     */
    public static function getToken(): ?string
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        return $_SESSION[self::$tokenName] ?? null;
    }

    /**
     * Generate CSRF token HTML input field.
     *
     * @return string The HTML input field for CSRF token.
     */
    public static function tokenField(): string
    {
        $token = self::generateToken();
        return '<input type="hidden" name="' . self::$tokenName . '" value="' . $token . '">';
    }
}
