<?php
namespace Shibaji\Core;

class Console
{
    // ANSI color codes
    const ANSI_RESET = "\033[0m";
    const ANSI_BOLD = "\033[1m";
    const ANSI_UNDERLINE = "\033[4m";
    const ANSI_BLACK = "\033[0;30m";
    const ANSI_RED = "\033[0;31m";
    const ANSI_GREEN = "\033[0;32m";
    const ANSI_YELLOW = "\033[0;33m";
    const ANSI_BLUE = "\033[0;34m";
    const ANSI_PURPLE = "\033[0;35m";
    const ANSI_CYAN = "\033[0;36m";
    const ANSI_WHITE = "\033[0;37m";

    /**
     * Reads a line from the console input.
     *
     * @param string $prompt The prompt message to display.
     * @return string The input from the user.
     */
    public static function readLine(string $prompt = ''): string
    {
        if ($prompt) {
            echo $prompt;
        }

        return trim(fgets(STDIN));
    }

    /**
     * Reads a password from the console input (hides input).
     *
     * @param string $prompt The prompt message to display.
     * @return string The password input from the user.
     */
    public static function readPassword(string $prompt = ''): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            echo $prompt;
            return trim(fgets(STDIN));
        }

        if ($prompt) {
            echo $prompt;
        }

        system('stty -echo');
        $password = trim(fgets(STDIN));
        system('stty echo');
        echo PHP_EOL;

        return $password;
    }

    /**
     * Writes a line to the console output.
     *
     * @param string $message The message to display.
     */
    public static function writeLine(string $message = '')
    {
        echo $message . PHP_EOL;
    }

    /**
     * Writes a message to the console output without a newline.
     *
     * @param string $message The message to display.
     */
    public static function write(string $message)
    {
        echo $message;
    }

    /**
     * Writes a message to the console output with specified color.
     *
     * @param string $message The message to display.
     * @param string $color ANSI color code constant from this class.
     */
    public static function writeColored(string $message, string $color)
    {
        echo $color . $message . self::ANSI_RESET;
    }

    // Usage example with command handling
    // Define commands and their callbacks
    /* Example Uses
    $commands = [
        'hello' => function () {
            Console::writeLine("Hello, world!");
        },
        'greet' => function ($name) {
            Console::writeLine("Hello, $name!");
        },
        'sum' => function ($a, $b) {
            $result = $a + $b;
            Console::writeLine("Sum of $a and $b is: $result");
        },
        'exit' => function () {
            Console::writeLine("Goodbye!");
            exit;
        },
    ];

    // Start handling commands
    Console::handleCommands('Enter a command: ', $commands);
    */
    /**
     * Handles console commands.
     *
     * @param string $prompt The prompt message to display.
     * @param array $commands An associative array of commands mapped to their respective callbacks.
     */
    public static function handleCommands(string $prompt, array $commands)
    {
        while (true) {
            self::writeLine($prompt);
            $input = self::readLine();

            if (empty($input)) {
                continue;
            }

            $parts = explode(' ', $input);
            $command = $parts[0];

            if (isset($commands[$command])) {
                $callback = $commands[$command];
                $args = array_slice($parts, 1);
                call_user_func_array($callback, $args);
            } else {
                self::writeLine("Command '$command' not found.");
            }
        }
    }
}