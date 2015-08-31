<?php if ( ! defined( 'ABSPATH' ) ) exit;

/*
Plugin Name: Ninja Forms - List Selection Limits
Plugin URI: http://kylebjohnson.me
Description: Adds a quantitative restriction option to the list field based on previous submissions for a given form.
Version: 0.0.1

Author: Kyle B. Johnson
Author URI: http://kylebjohnson.me

Copyright 2015 Kyle B. Johnson.
*/

if( ! class_exists( 'NF_Base_Menu' ) ) {
    require_once 'classes/menu.class.php';
}
require_once 'includes/admin/menu.php';

/**
 * Class NF_ListSelectionLimits
 */
class NF_ListSelectionLimits
{
    const VERSION = '0.0.1';

    const TEXTDOMAIN = 'ninja-forms-list-selection-limits';

    /**
     * Plugin Directory
     *
     * @var string $dir
     */
    public static $dir = '';

    /**
     * Plugin URL
     *
     * @var string $url
     */
    public static $url = '';

    /**
     * Ninja Forms Extension Updater
     *
     * @var NF_Extension_Updater
     */
    public $NF_Extension_Updater;


    /**
     * Constructor
     */
    public function __construct()
    {
        self::$dir = plugin_dir_path( __FILE__ );

        self::$url = plugin_dir_url( __FILE__ );

        add_action( 'plugins_loaded', array( $this, 'ninja_forms_includes' ) );
    }



    /*
    * Public Methods
    */

    /**
     * Ninja Forms Includes
     *
     * Include plugin files for use in Ninja Forms
     */
    public function ninja_forms_includes()
    {
        require_once self::$dir . 'includes/actions/list-selection-limits.php';
    }

    /**
     * Extension Setup License
     *
     * Register with the Ninja Forms licensing system through Easy Digital Downloads
     */
    public function ninja_forms_extension_setup_license()
    {
        if ( class_exists( 'NF_Extension_Updater' ) ) {
            $this->NF_Extension_Updater = new NF_Extension_Updater( 'ListSelectionLimits', self::VERSION, 'Kyle B. Johnson', __FILE__, 'list-selection-limits' );
        }
    }



    /*
     * Private Methods
     */

    //Add private methods here
}

new NF_ListSelectionLimits();