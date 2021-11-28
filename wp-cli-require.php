<?php
/*
Plugin Name: WP CLI require command
Plugin URI: https://fasterwebsite.com/
Description: Provides wp cli require
Author: Maciej Klepaczewski
Author URI: https://fasterwebsite.com/
Version: 0.2
*/

/**
 * @author Maciej Klepaczewski <matt@fasterwebsite.com>
 * @link https://fasterwebsite.com/
 * @copyright Copyright (c) 2021, Maciej Klepaczewski FasterWebsite.com
 */
declare(strict_types=1);

namespace fasterwebsite\wp\cli\require;

add_action('cli_init', static function() : void {
    require_once __DIR__ . '/RequireCommand.php';
    WP_CLI::add_command('require', RequireCommand::class);
});