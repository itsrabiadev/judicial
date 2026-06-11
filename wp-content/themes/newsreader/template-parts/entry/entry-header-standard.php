<?php
/**
 * The template part for displaying standard entry header.
 *
 * @package Newsreader
 */

$header_class = '';

if (has_post_thumbnail()) {
	$header_class = 'cs-has-image';
}
?>
<div class="cs-entry__header cs-entry__header-standard">
	<div class="cs-entry__header-inner">
		<div class="cs-entry__outer">
			<div class="cs-entry__inner cs-entry__content <?php echo  $header_class ?>">
				<?php get_template_part( 'template-parts/entry/entry-header-primary-info' ); ?>
			</div>
		</div>
	</div>
</div>
