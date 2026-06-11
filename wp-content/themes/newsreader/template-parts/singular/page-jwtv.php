<?php
// Dynamically fetch variables as in JWTV.php

// Get current post ID
$post_id = get_the_ID();

// Featured post logic (adapted from JWTV.php)
$featuredPost = get_field('featured_video', $post_id);
$featuredPostCaption = get_field('featured_video_caption', $post_id);

if (!$featuredPost) {
    $featuredPostArr = get_posts([
        'numberposts' => 1,
        'post_type' => 'videos',
        'post_status' => 'publish'
    ]);
    $featuredPost = $featuredPostArr ? $featuredPostArr[0] : null;
}


if ($featuredPost) {
    // Make sure $featuredPost is a WP_Post object
    if (is_array($featuredPost) && isset($featuredPost[0])) {
        $featuredPostObj = get_post($featuredPost[0]->ID);
    } else {
        $featuredPostObj = null;
    }

    if ($featuredPostObj) {
        $featuredPostArr = [
            'ID' => $featuredPostObj->ID,
            'title' => get_the_title($featuredPostObj),
            'link' => get_permalink($featuredPostObj),
            'date' => get_the_date('', $featuredPostObj),
            'content' => get_post_field('post_content', $featuredPostObj),
            'caption' => $featuredPostCaption,
            'video_id' => get_field('video_id', $featuredPostObj->ID),
            'category' => null,
        ];
        $terms = get_the_terms($featuredPostObj, 'playlists');
        if ($terms && !is_wp_error($terms)) {
            $featuredPostArr['category'] = [
                'name' => $terms[0]->name,
                'link' => get_term_link($terms[0])
            ];
        }
        $featuredPost = $featuredPostArr;
    } else {
        $featuredPost = null;
    }
} else {
    $featuredPost = null;
}

// Grouped posts logic (simplified, adjust as needed)
$shuffledPostGroup = [];
$featuredPlaylists = get_field('featured_jwtv_categories', $post_id);
if ($featuredPlaylists) {
    $posts = [];
    foreach ($featuredPlaylists as $taxonomyTerm) {
        $taxPosts = get_posts([
            'post_type' => 'videos',
            'numberposts' => 6,
            'tax_query' => [
                [
                    'taxonomy' => $taxonomyTerm->taxonomy,
                    'field' => 'term_id',
                    'terms' => $taxonomyTerm->term_id,
                    'include_children' => true,
                ]
            ]
        ]);
        $jwTaxPosts = [];
        foreach ($taxPosts as $post) {
            $jwTaxPosts[] = [
                'post' => [
                    'ID' => $post->ID,
                    'title' => get_the_title($post),
                    'link' => get_permalink($post),
                    'date' => get_the_date('', $post),
                ],
                'video_id' => get_field('video_id', $post->ID)
            ];
        }
        $posts[] = [
            'posts' => $jwTaxPosts,
            'name' => $taxonomyTerm->name,
            'link' => get_term_link($taxonomyTerm->term_id, 'playlists')
        ];
    }
    // Shuffle logic: first 3 fixed, rest shuffled
    $fixedPostGroup = array_slice($posts, 0, 3);
    $postGroupsForShuffle = array_slice($posts, 3);
    shuffle($postGroupsForShuffle);
    $shuffledPostGroup = array_merge($fixedPostGroup, $postGroupsForShuffle);
}

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
    $archive_columns_desktop = (int) get_theme_mod('archive_columns_desktop', 3);
}
// Default values for archive page.
$title = get_the_title();
$permalink = get_pagenum_link(get_query_var('paged') ?: 1); // current archive page URL

// Encode values for social links.
$social_tweet = urlencode("Judicial Watch - {$title} - {$permalink}");
$social_link = urlencode($permalink);
$social_title = urlencode($title);


?>
<style>
    <?php if (get_the_post_thumbnail_url($featuredPost['ID'])): ?>
        .page-jwtv-bg {
            background-image: url(<?php echo esc_url(get_the_post_thumbnail_url($featuredPost['ID'])); ?>);
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
        a {
            color: #ffffff;
        }

        .cs-entry__post-meta .cs-meta-author-link .cs-meta-author-name {
            color: #ffffff;
        }

        #breadcrumbs {
            display: none;
        }

    <?php endif; ?>
</style>

<div class="jwtv-index-with-socialbar container-1140">
    <div class="column-social-widget component-social-share-widget">
        <div class="component-title">Share: </div>
        <div class="social-links">
            <a target="_blank" class="social-link"
                href="https://twitter.com/intent/tweet?text=<?php echo $social_tweet; ?>">
                <span class="twitter-social"><img src="<?php echo get_theme_file_uri('assets/images/twitter.png'); ?>"
                        alt="Twitter"></span>
            </a>
            <a target="_blank" class="social-link" href="https://facebook.com/sharer.php?u=<?php echo $social_link; ?>">
                <span class="facebook-social"><img src="<?php echo get_theme_file_uri('assets/images/facebook.png'); ?>"
                        alt="Facebook"></span>
            </a>
            <a target="_blank" class="social-link" href="http://www.reddit.com/submit?url=<?php echo $social_link; ?>">
                <span class="reddit-social"><img src="<?php echo get_theme_file_uri('assets/images/reddit.png'); ?>"
                        alt="Reddit"></span>
            </a>
            <a target="_blank" class="social-link"
                href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $social_link; ?>">
                <span class="linkedin-social"><img src="<?php echo get_theme_file_uri('assets/images/linkedin.png'); ?>"
                        alt="LinkedIn"></span>
            </a>
            <a target="_blank" class="social-link" href="https://telegram.me/share/url?url=<?php echo $social_link; ?>">
                <span class="telegram-social"><img
                        src="<?php echo get_theme_file_uri('assets/images/talegram-logo.png'); ?>"
                        alt="Telegram"></span>
            </a>
            <a target="_blank" class="social-link" href="https://gettr.com/share?url=<?php echo $social_link; ?>">
                <span class="gettr-social"><img src="<?php echo get_theme_file_uri('assets/images/Gettr-logo.png'); ?>"
                        alt="Gettr"></span>
            </a>
            <a class="social-link"
                href="mailto:?subject=<?php echo str_replace('+', ' ', $social_title); ?>&body=<?php echo $social_link; ?>">
                <span class="gmail-social"><img src="<?php echo get_theme_file_uri('assets/images/gmail.png'); ?>"
                        alt="Email"></span>
            </a>
            <a class="social-link" href="javascript:void(0)" onclick="window.print()">
                <span class="print-social"><img src="<?php echo get_theme_file_uri('assets/images/print.png'); ?>"
                        alt="Print"></span>
            </a>
        </div>
    </div>
    <div class="jwtv-index-content">
        <?php if ($featuredPost): ?>
            <section class="featured-post">
                <div class="column-post">
                    <div class="meta">
                        <span class="date"><?php echo esc_html($featuredPost['date'] ?? ''); ?></span>
                        <?php if (!empty($featuredPost['category']['name'])): ?>
                            <span class="divider"></span>
                            <a class="category" href="<?php echo esc_url($featuredPost['category']['link']); ?>">
                                <?php echo esc_html($featuredPost['category']['name']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <h1 class="post-title">
                        <a
                            href="<?php echo esc_url($featuredPost['link']); ?>"><?php echo esc_html($featuredPost['title']); ?></a>
                    </h1>
                    <div class="wysiwyg-content">
                        <div class="invert-body-text description">
                            <?php // echo !empty($featuredPost['caption']) ? esc_html($featuredPost['caption']) : wp_trim_words(strip_tags($featuredPost['content']), 40); ?>
                        </div>
                    </div>
                </div>
                <div class="column-play-icon">
                    <a href="<?php echo esc_url($featuredPost['link']); ?>" class="js-play-video">
                        <img class="play-icon"
                            src="/wp-content/themes/judicial-watch/assets/images/icon-play-yellow-lg.png" />
                    </a>
                </div>
            </section>

        <?php endif; ?>

        <section class="container-1140">
            <?php foreach ($shuffledPostGroup as $postGroup): ?>
                <?php $option_li_var = 1; ?>
                <div class="component-jwtv-slider delay-2s">
                    <h2 class="component-title">
                        <a href="<?php echo esc_url($postGroup['link']); ?>"><?php echo esc_html($postGroup['name']); ?></a>
                    </h2>
                    <?php if (!empty($postGroup['posts'])): ?>
                        <!-- Section: Related Cases -->
                        <section class="cs-posts-area cs-posts-area-posts related-posts">
                            <div class="cs-posts-area__outer">

                                <div class="js-slick jwtv-slides" data-pc="3">
                                    <?php foreach ($postGroup['posts'] as $postData): ?>

                                        <?php

                                        $options['class'] = 'jwtv-slide';
                                        if ($option_li_var > 3) {
                                            $options['class'] .= ' is-hidden-mobile';
                                        }
                                        // Make related case the global $post
                                        $post = get_post($postData->postId ?? $postData['post']['ID']);
                                        setup_postdata($post);

                                        // Pass options if needed
                                        set_query_var('options', $options);

                                        if ('full' === $options['layout']) {
                                            get_template_part('template-parts/archive/content-full');
                                        } else {
                                            get_template_part('template-parts/archive/entry');
                                        }

                                        $option_li_var = $option_li_var + 1
                                            ?>

                                    <?php endforeach; ?>
                                    <?php wp_reset_postdata(); ?>
                                    <div class="jwtv-button is-mobile is-hidden-tablet">
                                        <a href="<?php echo esc_url($postGroup['link']); ?>"" type=" button"
                                            class="button button-primary">View All</a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
</div>

<script>
    // Video dialog
    var $videoDialog = jQuery('.modal-video');
    var $playButton = jQuery('.js-play-video');
    var $featuredVideo = jQuery('.js-play-featured-video')
    var featuredVideoSrc = 'https://www.youtube.com/embed/<?php echo esc_js($featuredPost['video_id'] ?? ''); ?>?autoplay=1';
    var $modalClose = jQuery('.modal-close');

    $playButton.on('click', function (e) {
        e.preventDefault();
        $videoDialog.addClass('is-active');
        $featuredVideo.attr('src', featuredVideoSrc);
    });
    $modalClose.on('click', function () {
        $videoDialog.removeClass('is-active');
        $featuredVideo.attr('src', 'empty');
    });

    // Sliders
    function jwtvallSlider() {
        var $slickSliders = jQuery('.jwtv-slides');
        $slickSliders.each(function (index, elem) {
            var $this = jQuery(this);

            $this.slick({
                arrows: true,
                slidesToShow: 3,
                variableWidth: true,
                slidesToScroll: 3,
                infinite: false,
                draggable: true,
                prevArrow: '<button type="button" class="slick-prev"><span class="fas fa-chevron-left"></span></button>',
                nextArrow: '<button type="button" class="slick-next"><span class="fas fa-chevron-right"></span></button>',
                waitForAnimate: false,

                responsive: [
                    {
                        breakpoint: 768,
                        settings: "unslick"
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            arrows: true,
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            arrows: true
                        }
                    },
                ]
            });
        });
    }

    // Animations
    var $videoHoverDivs = jQuery(document).find('.slick-slide > div');
    var $jwtvSlides = jQuery('.jwtv-slide');
    jQuery('.slick-slide').on('mouseenter', function () {
        var $this = jQuery(this);
        $videoHoverDivs.removeClass('is-hovered');
        $jwtvSlides.stop();
        $jwtvSlides.css('max-width', '');

        $this.find('.jwtv-slide').animate({
            maxWidth: 400
        }, 350, function () {
            jQuery(document).find($this).find('> div').addClass('is-hovered')
        });

    })

    jQuery('.slick-slide').on('mouseleave', function () {
        $videoHoverDivs.removeClass('is-hovered');
        $jwtvSlides.stop();
        $jwtvSlides.css('max-width', '');
    })
    /* Sliders remove in mobile*/
    //jwtvallSlider();

    jQuery(window).resize(function () {
        var $windowWidth = jQuery(window).width();
        if ($windowWidth > 768) {
            //jwtvallSlider();
        }
    });
</script>