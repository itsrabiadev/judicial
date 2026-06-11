<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Newsreader
 */

get_header(); ?>

<div id="primary" class="cs-content-area page page-donate">


    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <?php get_template_part('template-parts/singular/single-donation_page'); ?>


    <?php endwhile; ?>

</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

