<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newsreader
 */

$options = get_query_var('options');

if (empty($options['image_url'])) {
    if (is_post_type_archive('documents') || is_singular('documents') || is_tax('document_tags') || is_tax('document_categories')) {

        $options['image_url'] = csco_get_document_image_url(get_the_ID());
    }

}
// Set post class.
$post_class = __return_empty_string();

// Thumbnail size.
$thumbnail_size_mobile = 'csco-thumbnail-uncropped';
$thumbnail_size = $options['image_size'];
$class = !empty($options['class']) ? $options['class'] : '';
$default_image_url = isset($options['image_url']) ? $options['image_url'] : '';
?>

<article <?php post_class($post_class . $class); ?>>

    <div class="cs-entry__outer">
        <?php if (has_post_thumbnail()) { ?>
            <div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr($options['image_orientation']); ?>"
                data-scheme="inverse">

                <div class="cs-overlay-background">
                    <?php the_post_thumbnail($thumbnail_size_mobile); ?>
                    <?php the_post_thumbnail($thumbnail_size); ?>
                </div>

                <?php csco_get_video_background('archive'); ?>
                <?php csco_the_post_format_icon(); ?>
                <a class="cs-overlay-link" href="<?php echo esc_url(get_permalink()); ?>"
                    title="<?php echo esc_attr(get_the_title()); ?>"></a>
            </div>
        <?php } else { ?>
            <div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr($options['image_orientation']); ?>"
                data-scheme="inverse">
                <div
                    class="cs-overlay-background <?php echo empty($default_image_url) ? 'background-image-missing' : '' ?>">
                    <?php if (!empty($default_image_url)): ?>
                        <img src="<?php echo esc_url($default_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                        <img src="<?php echo esc_url($default_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                </div>

                <a class="cs-overlay-link" href="<?php echo esc_url(get_permalink()); ?>"
                    title="<?php echo esc_attr(get_the_title()); ?>"></a>
            </div>
        <?php } ?>

        <div class="cs-entry__inner cs-entry__content">
            <?php csco_get_post_meta(array('category'), true, $options['meta']); ?>

            <?php the_title('<h2 class="cs-entry__title"><a href="' . esc_url(get_permalink()) . '"><span>', '</span></a></h2>'); ?>

            <?php if ($options['excerpt']) { ?>
                <div class="cs-entry__excerpt">
                    <?php echo esc_attr(get_the_excerpt()); ?>
                </div>
            <?php } ?>

            <?php csco_get_post_meta(array('author', 'date', 'comments', 'views'), true, $options['meta']); ?>
        </div>
    </div>
</article>