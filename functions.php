<?php
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );



return new class {
    private $paths = [
        __DIR__ . '/excerpts/autoload.php',
        __DIR__ . '/traits/autoload.php',
        __DIR__ . '/requests/autoload.php',
        __DIR__ . '/bootstrap/app.php',
        __DIR__ . '/models/autoload.php',
        __DIR__ . '/**/autoload.php',
    ];

    public function __construct()
    {
        $this->defined();

        foreach ($this->paths as $path) {
            foreach (glob($path) as $file) {
                require_once $file;
            }
        }
    }

    public function defined()
    {
        define('THEME_DIR', get_stylesheet_directory());
        define('THEME_URL', get_stylesheet_directory_uri());
        define('CONFIG_DIR', THEME_DIR . '/configs');
    }
};