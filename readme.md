# Installation
```bash
composer require fasterwebsite/wp-cli-require
```
# Usage
```bash
wp require path/to/script.php  
```

# Why `wp require` is better than `wp eval-file`

WP CLI `require` allows you to execute script you have stored in a PHP file. It's very similar to
`wp eval-file`. However, while `eval-file` executes the script using `eval()`, this command uses `require`.

Advantages of `require` over `eval()`:
- `eval()` does not support `declare(strict_types=1);`,
- `eval()` does some funky stuff with `namesapce`'s (I don't remember specifics, sorry ;-) )
- you can't debug (e.g. with XDebug) code executed with `eval()`,
- in case something goes wrong you get a nice stack trace instead of `eval'd code`,