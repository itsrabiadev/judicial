<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Newsreader
 */

get_header(); ?>
<style>
	.cs-read-next article .cs-entry__content .cs-entry__post-meta:last-of-type .cs-meta-date {
  display: none;
}

</style>

<div id="primary" class="cs-content-area">

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
		 * The csco_post_before hook.
		 *
		 * @since 1.0.0
		 */
		do_action( 'csco_post_before' );
		?>

			<?php get_template_part( 'template-parts/content-singular' ); ?>

		<?php
		/**
		 * The csco_post_after hook.
		 *
		 * @since 1.0.0
		 */
		do_action( 'csco_post_after' );
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

<?php get_sidebar('read-now'); ?>
<?php get_footer(); ?>
