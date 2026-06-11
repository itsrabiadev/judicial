<?php
/**
 * The template for displaying all single pages.
 *
 * @package Newsreader
 */

get_header(); 
       $defaultImagePath = get_theme_file_uri('assets/images/section-title-bg-issues.jpg');

        $backgroundImage = get_field('page_header_background_image', $page->postId) ?: $defaultImagePath;
        if (is_array($backgroundImage)) {
            $backgroundImage = $backgroundImage['url'];
        }
?>
<style>
	.component-subpage-title {
		background-image: url(<?= $backgroundImage ?>);
	}
	.cs-entry__media{
		display:none;
	}
</style>

<div id="primary" class="cs-content-area">

	<?php
	/**
	 * The csco_main_before hook.
	 *
	 * @since 1.0.0
	 */
	do_action('csco_main_before');
	?>

	<?php
	while (have_posts()):
		the_post();
		?>

		<?php
		/**
		 * The csco_page_before hook.
		 *
		 * @since 1.0.0
		 */
		do_action('csco_page_before');
		?>

		<?php get_template_part('template-parts/content-singular'); ?>

		<?php
		/**
		 * The csco_page_after hook.
		 *
		 * @since 1.0.0
		 */
		do_action('csco_page_after');
		?>

	<?php endwhile; ?>

	<?php
	/**
	 * The csco_main_after hook.
	 *
	 * @since 1.0.0
	 */
	do_action('csco_main_after');
	?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>