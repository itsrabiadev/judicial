<?php
/**
 * Template part for displaying Petition layout content
 *
 * @package Newsreader
 */

$post_id = get_the_ID();

// Page fields (ACF)
$page_fields = get_fields( $post_id );
$layout      = jw_get_petition_layout( $post_id );

// Background image / color
$backgroundImage = jw_get_petition_background_image_url( $post_id );
$backgroundColor = ! empty( $layout['page_background_color'] ) ? $layout['page_background_color'] : '';

// Text color
$invert_text = jw_petition_uses_white_text( $post_id );

// Petition gravity form
$form_id = ! empty( $page_fields['petition_gravity_form'] ) ? $page_fields['petition_gravity_form'] : '';
$form    = $form_id ? gravity_form( $form_id, false, false, false, null, false, 1, false ) : '';

// Other content
$pageTitle       = get_the_title( $post_id );
$pageDescription = ! empty( $page_fields['description'] ) ? $page_fields['description'] : '';
$pageFinePrint   = '';
if ( ! empty( $page_fields['fine_print'] ) ) {
	$pageFinePrint = $page_fields['fine_print'];
} elseif ( ! empty( $page_fields['finePrint'] ) ) {
	$pageFinePrint = $page_fields['finePrint'];
}
$formBackground = ! empty( $layout['form_background_color'] ) ? $layout['form_background_color'] : '#000';

// Media (ACF flexible: image or video)
$mediaType  = ! empty( $page_fields['media']['type'] ) ? $page_fields['media']['type'] : '';
$mediaImage = ! empty( $page_fields['media']['image']['sizes']['medium_large'] ) ? $page_fields['media']['image']['sizes']['medium_large'] : '';
$mediaAlt   = ! empty( $page_fields['media']['image']['alt'] ) ? $page_fields['media']['image']['alt'] : '';
$mediaVideo = ! empty( $page_fields['media']['video'] ) ? $page_fields['media']['video'] : '';

$invert_class = $invert_text ? ' invert-body-text' : '';

$bg_cover_classes = 'bg-cover p-b-100';
if ( $backgroundImage ) {
	$bg_cover_classes .= ' bg-cover-featured-graphic';
}

$bg_cover_style = '';
if ( $backgroundColor && ! $backgroundImage ) {
	$bg_cover_style = 'background-color: ' . esc_attr( $backgroundColor ) . ';';
}
?>

<?php if ( $backgroundImage || $backgroundColor ) : ?>
	<style>
		<?php if ( $backgroundImage ) : ?>
			#breadcrumbs {
				display: none;
			}

			@media (min-width: 1200px) {
				.cs-sidebar-disabled .cs-entry__content-wrap {
					background: transparent;
				}
			}

			@media (min-width: 1280px) {
				.cs-entry__content-wrap {
					background: transparent;
				}
			}

		<?php endif; ?>
		main {
			<?php if ( $backgroundImage ) : ?>
				background-image: url('<?php echo esc_url( $backgroundImage ); ?>');
				background-repeat: no-repeat;
			<?php endif; ?>
			<?php if ( $backgroundColor ) : ?>
				background-color: <?php echo esc_attr( $backgroundColor ); ?>;
				<?php if ( $backgroundImage ) : ?>
				background-size: contain !important;
				background-position: top center;
				<?php endif; ?>
			<?php endif; ?>
		}
		<?php if ( $backgroundColor ) : ?>
			.cs-entry__content-wrap {
				background-color: transparent;
			}
		<?php endif; ?>
		.entry-content b,
		.entry-content strong {
			color: <?php echo $invert_text ? '#ffffff' : '#000000'; ?>;
		}
	</style>
<?php endif; ?>

<?php
$sidebar_wrapper_class = 'cs-entry__wrap page page-petition petition-layout-sidebar';
if ( ! $backgroundImage ) {
	$sidebar_wrapper_class .= ' petition-layout-sidebar--no-graphic';
}
?>

<div class="<?php echo esc_attr( $sidebar_wrapper_class ); ?>">
	<?php do_action( 'csco_entry_wrap_start' ); ?>

	<div class="cs-entry__container">
		<div class="cs-entry__content-wrap">
			<div class="entry-content">

				<div class="<?php echo esc_attr( $bg_cover_classes ); ?>"<?php echo $bg_cover_style ? ' style="' . esc_attr( $bg_cover_style ) . '"' : ''; ?>>
					<section class="page-content page-container p-t-120 mobile-p-t-40 container-950<?php echo esc_attr( $invert_class ); ?>">
						<div class="petition-layout-sidebar__grid">

							<!-- Page Content -->
							<div class="petition-layout-sidebar__main<?php echo $backgroundImage ? ' petition-layout-sidebar__main--has-bg' : ''; ?>">
								<div class="wysiwyg-content<?php echo esc_attr( $invert_class ); ?>">

									<h1 class="petition-title p-t-5 m-b-25"><?php echo esc_html( $pageTitle ); ?></h1>

									<?php if ( ! $backgroundImage && 'image' === $mediaType && $mediaImage ) : ?>
										<img src="<?php echo esc_url( $mediaImage ); ?>" alt="<?php echo esc_attr( $mediaAlt ); ?>">
									<?php elseif ( 'video' === $mediaType && $mediaVideo ) : ?>
										<div class="responsive-media">
											<iframe width="750" height="421.875"
												src="https://www.youtube.com/embed/<?php echo esc_attr( $mediaVideo ); ?>?rel=0&controls=0"
												allow="autoplay; encrypted-media" frameborder="0"
												allowfullscreen></iframe>
										</div>
									<?php endif; ?>

									<?php if ( $pageDescription ) : ?>
										<div class="petition-description">
											<?php echo wp_kses_post( $pageDescription ); ?>
										</div>
									<?php endif; ?>

									<?php if ( $pageFinePrint ) : ?>
										<small class="is-inline-block p-t-150 mobile-p-t-10<?php echo $invert_text ? ' has-text-white' : ''; ?>">
											<?php echo wp_kses_post( $pageFinePrint ); ?>
										</small>
									<?php endif; ?>
								</div>
							</div>

							<!-- Sidebar Form -->
							<div class="petition-layout-sidebar__form column-sidebar wysiwyg-content<?php echo esc_attr( $invert_class ); ?>" style="background-color: <?php echo esc_attr( $formBackground ); ?>;">
								<?php if ( $form ) : ?>
									<?php echo $form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php endif; ?>
							</div>
						</div>
					</section>
				</div>

			</div>
		</div>
	</div>

	<?php do_action( 'csco_entry_wrap_end' ); ?>
</div>
