<?php
/**
 * @author    Maciej Klepaczewski <matt@fasterwebsite.com>
 * @link      https://fasterwebsite.com/
 * @copyright Copyright (c) 2020, Maciej Klepaczewski FasterWebsite.com
 */
declare(strict_types=1);

namespace fasterwebsite\wp\cli\require;

use WP_CLI\Utils;
use WP_CLI_Command;
use WP_CLI;

class RequireCommand extends WP_CLI_Command {

    /**
     * Regular expression pattern to match __FILE__ and __DIR__ constants.
     *
     * We try to be smart and only replace the constants when they are not within quotes.
     * Regular expressions being stateless, this is probably not 100% correct for edge cases.
     *
     * @see https://regex101.com/r/9hXp5d/4/
     *
     * @var string
     */
    const FILE_DIR_PATTERN = '/(?>\'[^\']*?\')|(?>"[^"]*?")|(?<file>\b__FILE__\b)|(?<dir>\b__DIR__\b)/m';

    /**
     * Loads and executes a PHP file.
     *
     * Note: because code is executed within a method, global variables need
     * to be explicitly globalized.
     *
     * ## OPTIONS
     *
     * <file>
     * : The path to the PHP file to execute.  Use '-' to run code from STDIN.
     *
     * [<arg>...]
     * : One or more arguments to pass to the file. They are placed in the $args variable.
     *
     * [--skip-wordpress]
     * : Load and execute file without loading WordPress.
     *
     * @when before_wp_load
     *
     * ## EXAMPLES
     *
     *     wp eval-file my-code.php value1 value2
     */
    public function __invoke($args, $assoc_args) {
        $file = array_shift($args);

        if (!file_exists($file)) {
            WP_CLI::error("'$file' does not exist.");
        }

        if (null === Utils\get_flag_value($assoc_args, 'skip-wordpress')) {
            WP_CLI::get_runner()->load_wordpress();
        }

        self::execute_eval($file, $args);
    }

    /**
     * Evaluate a provided file.
     *
     * @param string $file Filepath to execute, or - for STDIN.
     * @param mixed  $args Array of positional arguments to pass to the file.
     */
    private static function execute_eval($file, $args) {
        require($file);
    }
}
