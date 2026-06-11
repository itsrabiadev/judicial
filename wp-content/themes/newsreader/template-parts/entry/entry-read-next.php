<?php
/**
 * The template part for displaying post read next section.
 *
 * @package Newsreader
 */

$options = array(
	'image_orientation' => get_theme_mod( 'post_read_next_image_orientation', 'landscape-16-9' ),
	'image_size'        => get_theme_mod( 'post_read_next_image_size', 'csco-thumbnail-uncropped' ),
);

$read_next_post_meta = get_theme_mod( 'post_read_next_meta', array( 'category', 'author', 'date' ) );
$read_next_layout    = get_theme_mod( 'read_next_layout', 'grid' );
$read_next_class     = 'cs-read-next__grid';
$limit               = 3;

$read_next_post_heading = get_theme_mod( 'post_read_next_heading', 'Read more' );

// Thumbnail size.
$thumbnail_size_mobile = 'csco-thumbnail-uncropped';
$thumbnail_size        = $options['image_size'];

/**
 * Custom: Get related posts from ACF relationship fields
 */

// ✅ Use your related posts instead of csco_get_read_next_post_ids()
$read_next_posts = newsreader_get_related_posts( get_the_ID(), array( 'field_5bb68204a35a1' ), $limit );

if ( ! empty( $read_next_posts ) ) {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => $limit,
		'post__in'            => wp_list_pluck( $read_next_posts, 'ID' ),
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	);

	$next_posts_query = new WP_Query( $args );

	if ( $next_posts_query->have_posts() ) {
		set_query_var( 'csco_in_read_next', true );
		?>
		<section class="cs-read-next">
			<div class="cs-read-next__heading">
				<h2><?php echo do_shortcode( $read_next_post_heading ); ?></h2>
			</div>

			<div class="cs-posts-area__read-next <?php echo esc_attr( $read_next_class ); ?>">
				<?php
				while ( $next_posts_query->have_posts() ) {
					$next_posts_query->the_post();
					?>
					<article <?php post_class(); ?>>
						<div class="cs-entry__outer">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['image_orientation'] ); ?>" data-scheme="inverse">
									<div class="cs-overlay-background">
										<?php the_post_thumbnail( $thumbnail_size_mobile ); ?>
										<?php the_post_thumbnail( $thumbnail_size ); ?>
									</div>
									<?php csco_the_post_format_icon(); ?>
									<a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"></a>
								</div>
							<?php } ?>

							<div class="cs-entry__inner cs-entry__content">
								<?php csco_get_post_meta( array( 'category' ), true, $read_next_post_meta ); ?>

								<?php the_title( '<h3 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '"><span>', '</span></a></h3>' ); ?>

								<?php if ( get_theme_mod( 'read_next_excerpt', false ) ) { ?>
									<div class="cs-entry__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></div>
								<?php } ?>

								<?php csco_get_post_meta( array( 'author', 'date', 'comments' ), true, $read_next_post_meta ); ?>
							</div>
						</div>
					</article>
					<?php
				}
				?>
			</div>
		</section>
		<?php
		set_query_var( 'csco_in_read_next', false );
	}
	wp_reset_postdata();
}
