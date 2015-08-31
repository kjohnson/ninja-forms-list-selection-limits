<div class="wrap">

    <h2><?php _e( 'Ninja Forms', 'ninja-forms' ); ?> <?php _e( 'List Selection Limits', NF_ListSelectionLimits::TEXTDOMAIN ); ?></h2>

    <p>Adds a quantitative restriction option to the list field based on previous submissions for a given form.</p>

    <?php include NF_ListSelectionLimits::$dir . 'includes/templates/admin-menu-toolbar.html.php'; ?>

    <?php if( '' == $tab )
        include NF_ListSelectionLimits::$dir . 'includes/templates/admin-menu-settings.html.php';
    ?>

</div>