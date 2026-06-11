<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Newsreader
 */

get_header(); 
$defaultImagePath = get_theme_file_uri('assets/images/section-title-bg-lawsuits.jpg');

?>
<style>
    .component-subpage-title {
        background-image: url(<?= $defaultImagePath?>);
    }
</style>
<div id="primary" class="cs-content-area">

    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <?php get_template_part('template-parts/singular/single-case'); ?>


    <?php endwhile; ?>

</div>
<?php get_sidebar('case'); ?>
<?php get_footer(); ?>
