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
    $archive_columns_desktop = (int) get_theme_mod('archive_columns_desktop', 3);
}

?>
<?php
global $post;
$postId = get_the_ID();

// First check manual related_videos field (ACF or meta)
$relatedPosts = get_field('related_videos', $postId);

if (!$relatedPosts) {
    // fallback: latest 6 videos
    $relatedPosts = get_posts([
        'post_type' => 'videos',
        'numberposts' => 6,
        'post__not_in' => [$postId],
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);
}
?>
<style>
    <?php if (get_the_post_thumbnail_url($postId)): ?>
        .page-jwtv-bg {
            background-image: url(<?php echo esc_url(get_the_post_thumbnail_url($postId)); ?>);
            background-color: black;
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            width: 100%;
            height: 500px;
            position: absolute;
            top: 0;
            z-index: 0;
        }

        .page-jwtv-bg:before {
            content: "";
            display: inline-block;
            position: absolute;
            width: 100%;
            height: 500px;
            background: linear-gradient(rgba(0, 0, 0, 0.4) 40%, rgba(0, 0, 0, 0.4) 10%, rgba(0, 0, 0, 0.45) 50%, rgba(0, 0, 0, 0.912763) 90%);
        }

        main {
            background-color: black;
            color: white;
        }

        .cs-entry__title a,
        .cs-entry__post-meta,
        a,p {
            color: #ffffff;
        }

        .cs-entry__post-meta .cs-meta-author-link .cs-meta-author-name {
            color: #ffffff;
        }

        #breadcrumbs {
            display: none;
        }

        .cs-entry__header .cs-entry__title {
            text-transform: uppercase;
            color: white;
        }

    <?php endif; ?>
</style>

<section class="jwtv-player">
    <div class="post-container">
        <?php get_template_part('template-parts/partials/socials'); ?>
        <div class="column-post">
        <div class="meta">
            <span class="date"><?php echo esc_html(get_the_date()); ?></span>
            <?php
            $categories = wp_get_post_terms(get_the_ID(), 'playlists');

            if (!empty($categories) && !is_wp_error($categories)) {
                $featuredCategory = $categories[0]; // first category
                ?>
                <span class="divider">|</span>
                <span>
                    <a href="<?php echo esc_url(get_term_link($featuredCategory)); ?>">
                        <?php echo esc_html($featuredCategory->name); ?>
                    </a>
                </span>
            <?php } ?>
        </div>


        <div class="wysiwyg-content">
            <?php
            // Get custom field video ID (change 'video_id' to your actual meta key)
            $youtubeId = get_post_meta(get_the_ID(), 'video_id', true);
            if ($youtubeId):
                ?>
                <div class="responsive-media">
                    <iframe width="<?php echo wp_is_mobile() ? '950' : '90%'; ?>" height="<?php echo wp_is_mobile() ? '534' : '534.375'; ?>"
                        src="https://www.youtube.com/embed/<?php echo esc_attr($youtubeId); ?>?rel=0&enablejsapi=1"
                        frameborder="0" allow="autoplay; encrypted-media" class="media-item" allowfullscreen>
                    </iframe>
                </div>
            <?php endif; ?>

            <div class="invert-body-text description">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
    </div>
    

    </div>
</section>

<?php if ($relatedPosts): ?>
    <section class="container-1140">
    <!-- Section: Related Cases -->
    <div class="cs-posts-area cs-posts-area-posts videos-post">
        <div class="cs-posts-area__outer">
            <h1 class="section-title section-title-primary-bordered">Watch More</h1>
            <div class="js-slick jwtv-slides" data-pc="3">
                <?php foreach ($relatedPosts as $relatedPost):
                $options['class'] = 'jwtv-slide';
                                        if ($option_li_var > 3) {
                                            $options['class'] .= ' is-hidden-mobile';
                                        }
                    // Make related case the global $post
                    $post = get_post($relatedPost);
                    setup_postdata($post);

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
    </div>
    </section>
<?php endif; ?>