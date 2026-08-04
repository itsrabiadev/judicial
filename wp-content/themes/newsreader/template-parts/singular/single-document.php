<?php

global $post;

// Get meta and thumbnails
$meta        = [
    'title' => get_the_title($post->ID),
];
$thumbnails  = [];
$pdfImage    = get_post_meta( $post->ID, '_document_cover_image' );
$coverImage  = get_field( 'document_image', $post->ID );

if ( $coverImage && isset( $coverImage['url'] ) ) {
    $thumbnails['coverimage'] = $coverImage['url'];
}

if ( is_countable( $pdfImage ) && count( $pdfImage ) ) {
    $thumbnails['pdf'] = $pdfImage[0];
}

if ( has_post_thumbnail( $post->ID ) ) {
    $thumbnail_id  = get_post_thumbnail_id( $post->ID );
    $thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
    $thumbnails['medium_large'] = [
        'src' => get_the_post_thumbnail_url( $post->ID, 'medium_large' ),
        'alt' => $thumbnail_alt ?: get_the_title( $thumbnail_id ),
    ];
} elseif ( ! empty( $thumbnails['coverimage'] ) ) {
    $thumbnails['medium_large'] = [
        'src' => $thumbnails['coverimage'],
        'alt' => $meta['title'],
    ];
} elseif ( ! empty( $thumbnails['pdf'] ) ) {
    $thumbnails['medium_large'] = [
        'src' => $thumbnails['pdf'],
        'alt' => $meta['title'],
    ];
}


// Social share links
$social = [
    'link'  => get_permalink($post->ID),
    'title' => get_the_title($post->ID),
    'tweet' => urlencode(get_the_title($post->ID) . ' ' . get_permalink($post->ID)),
];

// File Upload (ACF or meta)
$fileUpload = get_field('attachment', $post->ID);

$data=[];
$categories = get_the_terms($post->ID, 'document_categories');
if (!empty($categories) && !is_wp_error($categories)) {
    $documentTerm = $categories[0]; // first term
    $data['source'] = [
        'id'   => '',
        'name' => $documentTerm->name,
        'link' => get_term_link($documentTerm->term_id, 'document_categories'),
    ];
}

// ✅ Document Tags (limit to 3)
$tags = get_the_terms($post->ID, 'document_tags');

$data['tagged'] = [];

if (!empty($tags) && !is_wp_error($tags)) {
    // limit to 3 like take(3)
    $tags = array_slice($tags, 0, 3);

    $data['tagged'] = $tags;
}
$data['postId'] = $post->ID;
?>
<?php
// Set options.
$options = csco_get_archive_options();

// Location.
$main_classes = ' cs-posts-area__' . $options['location'];

// Layout.
$main_classes .= ' cs-posts-area__' . $options['layout'];

// Divider.
$grid_divider = false;
$grid_class = '';

if ('grid' === $options['layout'] || 'full' === $options['layout']) {

    $location = 'archive';

    if ('home' === $options['location']) {
        $location = 'home';
    }

    $grid_divider = get_theme_mod($location . '_divider', true);
    $grid_class = '';

    if ('grid' === $options['layout']) {
        $columns_dk = get_theme_mod($location . '_columns_desktop', 3);
        $columns_lt = get_theme_mod($location . '_columns_laptop', 2);
        $columns_tb = get_theme_mod($location . '_columns_tablet', 2);
        $columns_mb = get_theme_mod($location . '_columns_mobile', 1);
    }

    if ($grid_divider) {
        $grid_class = 'cs-posts-area__main-divider';
    }
}

// Archives Banner.
if ('archive' === $options['location']) {
    $archive_columns_desktop = (int)get_theme_mod('archive_columns_desktop', 3);
}

?>
<section class="post">

    <?php if (!empty($thumbnails['medium_large']['src'])) : ?>
        <div class="container-featured-image no-printme">
            <?php if ( ! empty( $thumbnail_id ) ) : ?>
                <?php
                // Real attachment (post's own featured image): use the responsive-image
                // API so srcset/sizes render, instead of a single fixed-size URL.
                echo wp_get_attachment_image(
                    $thumbnail_id,
                    'medium_large',
                    false,
                    array( 'class' => 'post-featured-image' )
                );
                ?>
            <?php else : ?>
                <?php // Cover image / PDF-generated preview: these are plain URLs (ACF field, not an attachment ID), so no srcset is available here. ?>
                <img src="<?php echo esc_url($thumbnails['medium_large']['src']); ?>"
                     alt="<?php echo esc_attr($thumbnails['medium_large']['alt']); ?>"
                     class="post-featured-image">
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="post-container">

        <div class="column-post wysiwyg-content">

<!--            <div id="print-header" class="print-header printme">-->
<!--                <img src="/wp-content/themes/judicial-watch/assets/images/logo-color.png">-->
<!--            </div>-->

            <small class="post-date no-printme"><?php get_template_part('template-parts/partials/date-and-source', null, ['data' => $data]); ?></small>

            <?php if ( ! empty( $meta['title'] ) ) : ?>
                <h1 class="post-title"><?php echo esc_html( $meta['title'] ); ?></h1>
            <?php endif; ?>

            <?php if (!empty($thumbnails['pdf'])) : ?>
                <div class="no-printme document-preview"
                     style="background-image: url('<?php echo esc_url($thumbnails['coverimage'] ?? $thumbnails['pdf']); ?>')">
                </div>
            <?php endif; ?>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <?php if ($fileUpload) : ?>
                <div class="document-action-buttons no-printme">
                    <a class="button button-primary" href="<?php echo esc_url($fileUpload['url']); ?>">
                        View
                    </a>
                    <a href="#" class="button button-primary btn-download-file">
                        Download
                    </a>
                </div>
            <?php endif; ?>


        </div>
    </div>
</section>

<hr>

<?php
// Related Posts Section
$relatedPosts = get_field( 'related_posts', $post->ID );
if ( ! is_array( $relatedPosts ) ) {
    $relatedPosts = [];
}

$related_ids  = [];
$relatedPosts = array_values(
    array_filter(
        $relatedPosts,
        static function ( $relatedPost ) use ( $post, &$related_ids ) {
            $related_id = $relatedPost instanceof WP_Post ? $relatedPost->ID : (int) $relatedPost;
            if ( ! $related_id || $related_id === (int) $post->ID || in_array( $related_id, $related_ids, true ) ) {
                return false;
            }
            $related_ids[] = $related_id;
            return true;
        }
    )
);

if ( ! $relatedPosts ) {
    $relatedPosts = get_posts(
        [
            'post_type'      => 'documents',
            'numberposts'    => 3,
            'post__not_in'   => [ $post->ID ],
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]
    );
}
if ($relatedPosts) :
    ?>
    <section class="cs-posts-area cs-posts-area-posts related-posts">
        <div class="cs-posts-area__outer">
            <h1 class="section-title section-title-primary-bordered">Related</h1>
            <div class="cs-posts-area__main cs-archive-grid  cs-posts-area__archive cs-posts-area__grid cs-posts-area__main-divider" data-pc="3">
                <?php foreach ($relatedPosts as $relatedPost) :
                    // Make related case the global $post
                    setup_postdata($relatedPost);
                    $pdfImage   = get_post_meta( get_the_ID(), '_document_cover_image' );
                    $coverImage = get_field( 'document_image', get_the_ID() );

                    $options['image_url'] = '';
                    if ( is_array( $coverImage ) && isset( $coverImage['url'] ) && ! empty( $coverImage['url'] ) ) {
                        $options['image_url'] = $coverImage['url'];

                    } elseif ( is_countable( $pdfImage ) && count( $pdfImage ) && ! empty( $pdfImage[0] ) ) {
                        $options['image_url'] = $pdfImage[0];
                    }
                    // Pass options if needed
                    set_query_var('options', $options);

                    if ('full' === $options['layout']) {
                        get_template_part('template-parts/archive/content-full');
                    } else {
                        get_template_part('template-parts/archive/entry');
                    }
                    ?>

                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>

            </div>
        </div>
    </section>
<?php endif; ?>

<script>
    jQuery(document).ready(function($) {
        $('.btn-download-file').on('click', function(e) {
            e.preventDefault();
            window.location = '/download-document.php?id=<?php echo $post->ID; ?>';
        });
    });
</script>


