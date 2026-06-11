<?php
/**
 * The template for displaying a single Petition
 *
 * @package Newsreader
 */

if ( ! function_exists( 'jw_get_petition_layout_type' ) ) {
	require_once get_theme_file_path( '/inc/petition-helpers.php' );
}

get_header(); ?>
<style>
    .cs-site-content .cs-entry__title{
        display:none;
    }
</style>
<div id="primary" class="cs-content-area page page-petition">

    <?php
    while ( have_posts() ) :
        the_post();

        // Default template part
        $template_part = 'template-parts/singular/petitions/simple-layout';

        // Read ACF field for layout type
        $layoutType = jw_get_petition_layout_type();

        switch ($layoutType) {

            case 'basic_simple':
                $template_part = 'template-parts/singular/petitions/simple-layout';
                break;
            case 'featured_graphic':
                $template_part = 'template-parts/singular/petitions/featured-graphic-layout';
                break;
            case 'basic_sidebar':
                $template_part = 'template-parts/singular/petitions/simple-sidebar-layout';
                break;

        }

        // Load the correct layout
        get_template_part($template_part);

    endwhile;
    ?>

</div><!-- #primary -->
<?php if(!in_array($layoutType,['featured_graphic','basic_sidebar','basic_simple'])):?>
<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>
