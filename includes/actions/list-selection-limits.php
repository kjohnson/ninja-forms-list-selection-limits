<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Action_ListSelectionLimits extends NF_Notification_Base_Type
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug = 'list-selection-limits';

    /**
     * @var bool
     */
    public $is_detect_limited_list_field = FALSE;

    /**
     * @var array
     */
    private $list_option_counts = array();


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->name = __( 'List Selection Limits', NF_ListSelectionLimits::TEXTDOMAIN );

        add_filter( 'nf_notification_types', array( $this, 'register_action_type' ) );

        add_action( 'ninja_forms_display_pre_init', array( $this, 'detect_limited_list_field' ) );

        add_action( 'ninja_forms_field', array( $this, 'remove_list_options' ), 10, 2 );
    }


    /**
     * Register Action Type
     *
     * @param $types
     * @return array
     */
    public function register_action_type( $types )
    {
        $types[ $this->slug ] = $this;
        return (array) $types;
    }



    /**
     * Edit Screen
     *
     * @return void
     */
    public function edit_screen( $id = '' )
    {
        $list_fields = $this->get_list_fields();

        $settings['field_id'] = Ninja_Forms()->notification( $id )->get_setting( 'field_id' );
        $settings['field_limit'] = Ninja_Forms()->notification( $id )->get_setting( 'field_limit' );

        include NF_ListSelectionLimits::$dir . 'includes/templates/action-list-selection-limits.html.php';
    }



    /**
     * Process
     *
     * @param string $id
     * @return void
     */
    public function process( $id = '' )
    {
        //Process Action Here
    }

    /*
     * HOOKED METHODS
     */

    /**
     * Detect Limited List Field
     */
    public function detect_limited_list_field()
    {
        global $ninja_forms_loading;

        if( ! $ninja_forms_loading ) return;

        $form_id = $ninja_forms_loading->get_form_ID();

        $notifications = nf_get_notifications_by_form_id( $form_id );

        if ( is_array( $notifications ) ) {

            foreach ( $notifications as $id => $n ) {

                if ( nf_get_object_meta_value( $id, 'type' ) == $this->slug && nf_get_object_meta_value( $id, 'active' ) == 1 ) {

                    $this->is_detect_limited_list_field = $id;

                    break;
                }
            }
        }

    }

    /**
     * Remove List Options
     */
    public function remove_list_options( $data, $field_id )
    {
        if( ! $this->is_detect_limited_list_field ) return $data;

        $action_id = $this->is_detect_limited_list_field;

        $limited_field_id = Ninja_Forms()->notification( $action_id )->get_setting( 'field_id' );

        if( $limited_field_id != $field_id ) return $data;

        $field = ninja_forms_get_field_by_id( $field_id );

        $form_id = $field['form_id'];

        $limit = Ninja_Forms()->notification( $action_id )->get_setting( 'field_limit' );;

        $counts = $this->list_option_counts( $form_id, $field_id );

        foreach( $data[ 'list' ][ 'options' ] as $key => $option ){

            if( $limit <= intval( $counts[ $option['label'] ] ) ){

                unset( $data[ 'list' ][ 'options' ][ $key ] );
            }
        }

        return $data;
    }

    /*
     * PRIVATE METHODS
     */

    private function get_list_fields()
    {
        $fields = Ninja_Forms()->form( $_GET['form_id'] )->fields;

        $list_fields = array();

        foreach( $fields as $field ){

            if( '_list' == $field['type'] ){

                $id = $field['id'];
                $label = $field['data']['label'];

                $list_fields[ $id ] = $label;
            }
        }

        return $list_fields;
    }

    public function list_option_counts( $form_id, $field_id )
    {
        if( $this->list_option_counts ) return $this->list_option_counts;

        $subs = Ninja_Forms()->subs()->get( array( 'form_id' => $form_id) );

        foreach( $subs as $sub ){
            $this->list_option_counts[ $sub->fields[ $field_id ] ] = $this->list_option_counts[ $sub->fields[ $field_id ] ] + 1;
        }

        return $this->list_option_counts;
    }

}

new NF_Action_ListSelectionLimits();
