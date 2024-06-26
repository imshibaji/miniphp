<?php
namespace Shibaji\Core;

class Console
{
    private static $commands = [];

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

    // ANSI background color codes
    const ANSI_BG_BLACK = "\033[40m";
    const ANSI_BG_RED = "\033[41m";
    const ANSI_BG_GREEN = "\033[42m";
    const ANSI_BG_YELLOW = "\033[43m";
    const ANSI_BG_BLUE = "\033[44m";
    const ANSI_BG_PURPLE = "\033[45m";
    const ANSI_BG_CYAN = "\033[46m";
    const ANSI_BG_WHITE = "\033[47m";

    public static function welcome(){
        echo "\n";
        Console::writeWithFontSize('Welcome to the MiniPHP console', 3);
        Console::writeColored("\nVersion: ".APP['version'], Console::ANSI_CYAN);
        echo "\n================================================\n\n";
    }

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

    /**
     * Writes a message to the console output with specified background color.
     *
     * @param string $message The message to display.
     * @param string $bgColor ANSI background color code constant from this class.
     */
    public static function writeBackgroundColored(string $message, string $bgColor)
    {
        echo $bgColor . $message . self::ANSI_RESET;
    }

    /**
     * Writes a message to the console output with specified font size.
     *
     * @param string $message The message to display.
     * @param int $size Font size (1 for small, 2 for normal, 3 for large).
     */
    public static function writeWithFontSize(string $message, int $size)
    {
        switch ($size) {
            case 1:
                echo "\033[2m" . $message . self::ANSI_RESET; // Small font (dim)
                break;
            case 2:
                echo $message; // Normal font (default)
                break;
            case 3:
                echo self::ANSI_BOLD . $message . self::ANSI_RESET; // Large font (bold)
                break;
            default:
                echo $message; // Default to normal font
                break;
        }
    }

    /**
     * Registers a console command.
     *
     * @param string $name The name of the command.
     * @param callable $callback The callback to execute when the command is run.
     */
    public static function command(string $name, callable $callback)
    {
        self::$commands[] = [
            'pattern' => $name,
            'callback' => $callback,
            'purpose' => null,
        ];
    }

    /**
     * Sets the purpose of a command.
     *
     * @param string $name The name of the command.
     * @param string $purpose The purpose of the command.
     */
    public static function purpose(string $name, string $purpose)
    {
        foreach (self::$commands as &$command) {
            if ($command['pattern'] === $name) {
                $command['purpose'] = $purpose;
                break;
            }
        }
    }

    /**
     * Executes a registered command.
     *
     * @param string $input The command line input.
     */
    public static function run(string $input)
    {
        try {
            foreach (self::$commands as $command) {
                if (self::matches($command['pattern'], $input, $matches)) {
                    array_shift($matches);
                    call_user_func_array($command['callback'], $matches);
                    return;
                }
            }

            self::writeLine("Command '$input' not found.");
        } catch (\Throwable $th) {
            self::writeColored($th->getMessage() . PHP_EOL, self::ANSI_RED);
        }
    }

    /**
     * Handles console commands.
     *
     * @param string $prompt The prompt message to display.
     */
    public static function handleCommands(string $prompt)
    {
        while (true) {
            self::writeColored($prompt, self::ANSI_BLUE);
            $input = self::readLine();
            if (empty($input)) {
                continue;
            }
            self::run($input);
        }
    }

    /**
     * Lists all registered commands with their descriptions.
     */
    public static function listCommands()
    {
        foreach (self::$commands as $command) {
            $name = $command['pattern'];
            $description = $command['purpose'] ?? 'No description available';
            self::writeColored($name . ': ', self::ANSI_GREEN);
            self::writeLine($description);
        }
    }

    /**
     * Checks if the command name matches the input pattern.
     *
     * @param string $pattern The command pattern to match.
     * @param string $input The input string to check.
     * @param array $matches Variable to store the matches.
     * @return bool
     */
    private static function matches($pattern, $input, &$matches): bool
    {
        $pattern = '/^' . preg_replace('/\{[^\}]+\}/', '([^ ]+)', str_replace('/', '\/', $pattern)) . '$/';
        return preg_match($pattern, $input, $matches);
    }


    public static function runQuick(){
        // Ensure the script is being run in the CLI environment
        if (php_sapi_name() == 'cli') {
            global $argc, $argv;

            // Execute the command if provided in the CLI arguments
            if ($argc > 1) {
                $command = implode(' ', array_slice($argv, 1));
                Console::run($command);
            } else {
                Console::writeLine('Available commands:');
                Console::writeLine('==============================');
                Console::listCommands();
                echo "\n";
        }
        } else {
            // Output an error message if the script is not run from the CLI
            echo "This script can only be run from the command line." . PHP_EOL;
            exit(1);
        }
    }
}
