<?php
/**
 * Template part for displaying full posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newsreader
 */

// Thumbnail size.
$thumbnail_size_mobile = 'csco-thumbnail-uncropped';
$thumbnail_size = 'csco-large';

if ('uncropped' === csco_get_page_preview()) {
    $thumbnail_size = sprintf('%s-uncropped', $thumbnail_size);
}

$default_image_url = isset($options['image_url']) ? $options['image_url'] : '';
$class = !empty($options['class']) ? $options['class'] : '';
?>

<article <?php post_class($class); ?>>
    <div class="cs-entry__full-header">
        <div class="cs-entry__container">
            <?php if (has_post_thumbnail()) {
                ?>
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
                    <div class="cs-overlay-background <?php echo empty($default_image_url) ? 'background-image-missing' : '' ?>">
                        <?php if (!empty($default_image_url)) : ?>
                            <img src="<?php echo esc_url($default_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <img src="<?php echo esc_url($default_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                    </div>

                    <a class="cs-overlay-link" href="<?php echo esc_url(get_permalink()); ?>"
                       title="<?php echo esc_attr(get_the_title()); ?>"></a>
                </div>
            <?php } ?>

            <div class="cs-entry__header-info">
                <?php
                csco_get_post_meta(array('category'), true, $options['meta']);

                the_title('<h2 class="cs-entry__title"><a href="' . esc_url(get_permalink()) . '"><span>', '</span></a></h2>');

                csco_get_post_meta(array('author', 'date', 'comments'), true, $options['meta']);
                ?>
            </div>
        </div>
    </div>

    <div class="cs-entry__wrap">
        <div class="cs-entry__container">
            <div class="cs-entry__content-wrap">
                <div class="cs-entry-type-<?php echo esc_attr($options['summary_type']); ?> ">
                    <?php
                    if ('summary' === $options['summary_type']) {
                        the_excerpt();
                    } else {
                        $more_link_text = false;


                        $more_link_text = sprintf(
                        /* translators: %s: Name of current post */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'newsreader'),
                            get_the_title()
                        );

                        the_content($more_link_text);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>
