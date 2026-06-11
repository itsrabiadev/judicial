<?php
/**
 * Template part for displaying post in Swiper slider
 *
 * @package Newsreader
 */

$options     = get_query_var( 'options' );
$entry_class = get_query_var( 'entry_class' );

$meta = array();

if ( 'true' === $options['meta_author'] ) {
    $meta[] = 'author';
}

if ( 'true' === $options['meta_date'] ) {
    $meta[] = 'date';
}

if ( 'true' === $options['meta_category'] ) {
    $meta[] = 'category';
}

if ( 'true' === $options['meta_comments'] ) {
    $meta[] = 'comments';
}

if ( 'true' === $options['meta_views'] ) {
    $meta[] = 'views';
}

// Thumbnail size.
$thumbnail_size_mobile = 'csco-thumbnail-uncropped';
$thumbnail_size        = $options['attachment_size'];
?>

<article <?php post_class( 'cs-entry cs-entry--slider swiper-slide' ); ?>>
    <div class="<?php echo esc_attr( $entry_class ); ?>">

        <?php if ( has_post_thumbnail() && $options['thumbnail'] ) { ?>
            <div class="cs-entry__inner cs-entry__overlay cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['attachment_orientation'] ); ?>">

                <div class="cs-overlay-background">
                    <?php the_post_thumbnail( $thumbnail_size_mobile ); ?>
                    <?php the_post_thumbnail( $thumbnail_size ); ?>
                </div>

                <?php
                if ( 'true' === $options['video'] ) {
                    csco_get_video_background( 'elementor', null, 'default', 'true' === $options['video_controls'] ? true : false );
                }
                ?>

                <?php
                if ( 'true' === $options['post_format'] ) {
                    csco_the_post_format_icon();
                }
                ?>

                <a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link" title="<?php echo esc_attr( get_the_title() ); ?>"></a>
            </div>
        <?php } ?>

        <div class="cs-entry__inner cs-entry__content">

            <?php csco_get_post_meta( array( 'category' ), true, $meta ); ?>

            <?php
            $title_full   = get_the_title();
            $title_length = isset( $options['title_length'] ) ? intval( $options['title_length'] ) : 0;
            if ( $title_length > 0 ) {
                $display_title = wp_strip_all_tags( $title_full );
                if ( function_exists( 'mb_strlen' ) ) {
                    $len = mb_strlen( $display_title );
                    if ( $len > $title_length ) {
                        $display_title = mb_substr( $display_title, 0, $title_length ) . '…';
                    }
                } else {
                    if ( strlen( $display_title ) > $title_length ) {
                        $display_title = substr( $display_title, 0, $title_length ) . '…';
                    }
                }
            } else {
                $display_title = $title_full;
            }
            ?>
            <h2 class="cs-entry__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( $display_title ); ?></a></h2>

            <?php
            if ( 'true' === $options['excerpt'] ) {
                $content = csco_get_the_excerpt( $options['excerpt_length'] );

                if ( $content ) {
                    ?>
                    <div class="cs-entry__excerpt">
                        <?php echo esc_html( $content ); ?>
                    </div>
                    <?php
                }
            }
            ?>

            <?php csco_get_post_meta( array( 'author', 'date', 'views', 'comments' ), true, $meta ); ?>
        </div>
    </div>
</article>
