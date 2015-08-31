<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Menu_ListSelectionLimits extends NF_Base_Menu
{
    public $menu_slug = 'ninja-forms-list-selection-limits';

    public function __construct()
    {
        $this->name  = 'list-selection-limits';
        $this->title = __( 'List Selection Limits', NF_ListSelectionLimits::TEXTDOMAIN );

        $this->settings = array(
            'example1' => __( 'Example One', NF_ListSelectionLimits::TEXTDOMAIN ),
            'example2' => __( 'Example Two', NF_ListSelectionLimits::TEXTDOMAIN ),
        );

        parent::__construct();
    }

    /**
     * Display
     *
     * The default display method.
     */
    public function display()
    {
        $this->tab = ( isset( $_GET['tab'] ) ) ? $_GET['tab'] : '';
        include NF_ListSelectionLimits::$dir . 'includes/templates/admin-menu.html.php';
    }

    /**
     * Enqueue Styles
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
        /* Handle       */ 'ninja-forms-list-selection-limits-admin-css',
            /* Source       */ NF_ListSelectionLimits::$url . '/assets/css/dev/ninja-forms-list-selection-limits-admin.css',
            /* Dependencies */ FALSE,
            /* Version      */ NF_ListSelectionLimits::VERSION,
            /* In Footer    */ FALSE
        );
    }

    /**
     * Enqueue Scripts
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
        /* Handle       */ 'ninja-forms-list-selection-limits-admin-js',
            /* Source       */ NF_ListSelectionLimits::$url . '/assets/js/min/ninja-forms-list-selection-limits-admin.min.js',
            /* Dependencies */ array( 'jquery' ),
            /* Version      */ NF_ListSelectionLimits::VERSION,
            /* In Footer    */ TRUE
        );
    }


} // End NF_ListSelectionLimits_Menu Class

new NF_Menu_ListSelectionLimits();
