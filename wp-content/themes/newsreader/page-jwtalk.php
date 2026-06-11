<?php
/**
 * The template for displaying all single pages.
 *
 * @package Newsreader
 */

get_header(); ?>
<style>
    .cs-entry__header{
        display:none;
    }
</style>
<div id="primary" class="cs-content-area page-jwtalk">

    <?php
    /**
     * The csco_main_before hook.
     *
     * @since 1.0.0
     */
    do_action( 'csco_main_before' );
    ?>

    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <?php
        /**
         * The csco_page_before hook.
         *
         * @since 1.0.0
         */
        do_action( 'csco_page_before' );
        ?>

        <?php get_template_part( 'template-parts/singular/page-jwtalk' ); ?>

        <?php
        /**
         * The csco_page_after hook.
         *
         * @since 1.0.0
         */
        do_action( 'csco_page_after' );
        ?>

    <?php endwhile; ?>

    <?php
    /**
     * The csco_main_after hook.
     *
     * @since 1.0.0
     */
    do_action( 'csco_main_after' );
    ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
