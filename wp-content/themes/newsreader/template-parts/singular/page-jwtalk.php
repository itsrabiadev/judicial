<?php
/**
 * Template Name: JW Talk Template
 */

get_header();

// Get the latest (featured) podcast
$featuredQuery = new WP_Query([
    'post_type'      => 'podcasts',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
]);

$featuredPost = $featuredQuery->have_posts() ? $featuredQuery->posts[0] : null;

// Get more podcasts (excluding featured one)
$moreQuery = new WP_Query([
    'post_type'      => 'podcasts',
    'post_status'    => 'publish',
    'posts_per_page' => 6, // adjust as needed
    'post__not_in'   => $featuredPost ? [$featuredPost->ID] : [],
    'paged'          => get_query_var('paged') ?: 1,
]);

$defaultImage = get_stylesheet_directory_uri() . '/assets/images/default.jpg'; // safer path

// Options (only if available)
$options = function_exists('csco_get_archive_options') ? csco_get_archive_options() : [
    'location' => 'archive',
    'layout'   => 'grid',
];
?>

<!-- Latest Podcast -->
<?php if ($featuredPost): ?>
<section class="the-latest">
    <div class="container-1140">
        <h1 class="section-title">The Latest</h1>
        <div class="columns is-multiline is-marginless is-paddingless">

            <div class="column column-image">
                <?php $thumb = get_the_post_thumbnail_url($featuredPost->ID, 'large'); ?>
                <div class="featured-image<?php echo $thumb ? '' : ' background-image-missing'; ?>">
                    <?php if ($thumb): ?>
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($featuredPost->ID)); ?>">
                    <?php endif; ?>
                    </div>
            </div>

            <div class="column-post">
                <h2>
                    <a href="<?php echo get_permalink($featuredPost->ID); ?>" class="post-title">
                        <?php echo esc_html(get_the_title($featuredPost->ID)); ?>
                    </a>
                </h2>
                <div class="excerpt">
                    <?php
                    $excerpt = has_excerpt($featuredPost->ID)
                        ? get_the_excerpt($featuredPost->ID)
                        : wp_trim_words(wp_strip_all_tags($featuredPost->post_content), 30);
                    echo esc_html($excerpt);
                    ?>
                </div>

                <?php
                $buzzsproutLink = get_post_meta($featuredPost->ID, 'buzzsproutLink', true);
                $itunesLink     = get_post_meta($featuredPost->ID, 'itunesLink', true);
                ?>
                <?php if ($buzzsproutLink): ?>
                    <div class="podcast-ui">
                        <script src="<?php echo esc_url($buzzsproutLink); ?>.js?player=small"
                                type="text/javascript" charset="utf-8"></script>

                        <?php if ($itunesLink): ?>
                            <a href="<?php echo esc_url($itunesLink); ?>" class="apple-itunes-link">
                                <span class="fab fa-apple"></span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>
<?php if ($moreQuery->have_posts()): ?>
<div class="cs-posts-area cs-posts-area-posts videos-post">
    <div class="cs-posts-area__outer">
        <h1 class="section-title section-title-primary-bordered">Tom Fitton's Weekly Update</h1>
        <div id="jwtalk-ajax-posts" class="cs-posts-area__main cs-archive-grid cs-posts-area__archive cs-posts-area__grid cs-posts-area__main-divider" data-pc="3">
            <?php while ($moreQuery->have_posts()): $moreQuery->the_post(); ?>
                <?php
                set_query_var('options', $options);
                if ('full' === $options['layout']) {
                    get_template_part('template-parts/archive/content-full');
                } else {
                    get_template_part('template-parts/archive/entry');
                }
                ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <?php
        // Calculate if there are more posts to load
        $total_posts = $moreQuery->found_posts;
        $posts_per_page = $moreQuery->query_vars['posts_per_page'];
        $paged = $moreQuery->query_vars['paged'];
        $max_pages = $moreQuery->max_num_pages;
        ?>
        <?php if ($paged < $max_pages): ?>
            <div class="cs-posts-area__loadmore-wrap" style="text-align:center; margin-top:30px;">
                <button id="jwtalk-loadmore" class="cs-btn cs-btn-primary" data-paged="<?php echo esc_attr($paged + 1); ?>">Load More</button>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var loadmoreBtn = document.getElementById('jwtalk-loadmore');
    if (!loadmoreBtn) return;
    loadmoreBtn.addEventListener('click', function() {
        var btn = this;
        var paged = parseInt(btn.getAttribute('data-paged'), 10);
        btn.disabled = true;
        btn.textContent = 'Loading...';
        var data = new FormData();
        data.append('action', 'jwtalk_loadmore');
        data.append('paged', paged);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            body: data
        })
        .then(response => response.text())
        .then(html => {
            var container = document.getElementById('jwtalk-ajax-posts');
            container.insertAdjacentHTML('beforeend', html);
            btn.setAttribute('data-paged', paged + 1);
            // Hide button if no more posts
            if (!html.trim()) {
                btn.style.display = 'none';
            } else {
                btn.disabled = false;
                btn.textContent = 'Load More';
            }
        });
    });
});
</script>

