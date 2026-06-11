<?php
$sidebar = apply_filters( 'csco_sidebar', 'cases' );

if ( 'disabled' !== csco_get_page_sidebar() ) {

    // Only for 'documents' CPT archive

    // Default sidebar
    ?>
    <aside id="secondary" class="cs-widget-area cs-sidebar__area">
        <div class="cs-sidebar__inner">

            <?php do_action( 'csco_sidebar_start' ); ?>

            <?php dynamic_sidebar( $sidebar ); ?>

            <?php do_action( 'csco_sidebar_end' ); ?>

        </div>
    </aside>
<?php } ?>
