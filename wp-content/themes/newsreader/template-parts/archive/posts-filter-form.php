<!-- Post Filter -->
<?php
// Default values for archive page.
$title = get_the_archive_title();
$permalink = get_pagenum_link(get_query_var('paged') ?: 1); // current archive page URL

// Encode values for social links.
$social_tweet = urlencode("Judicial Watch - {$title} - {$permalink}");
$social_link = urlencode($permalink);
$social_title = urlencode($title);

?>
<div class="tabs-nav component-pagination-filter">
    <form name="search_filter" method="get" id="target" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="columns is-multiline is-mobile search-filter-posts is-hidden-tablet is-marginless container">

            <!-- Search Box -->
            <div class="column p-t-0 is-paddingless search-box">
                <p class="control has-icons-right is-three-fifths">
                    <input class="input m-r-20" type="text" placeholder="Search" name="s" value="<?php echo get_search_query(); ?>">
                    <span class="icon is-small is-right">
                        <span class="fas fa-search has-text-primary"></span>
                    </span>
                </p>
            </div>

            <!-- Category Filter -->
            <div class="column p-t-0 filter-box">
                <div class="select is-block">
                    <select class="input input-select" name="cat">
                        <option value="">Filter by</option>
                        <?php
                        $categories = collect(get_terms([
                            'taxonomy' => 'category',
                            'hide_empty' => true,
                            'exclude' => array( 40923, 34898  ),
                            'number'   => 5
                        ]))
                            ->transform(function(WP_Term $category) {
                                if ('Uncategorized' === $category->name) {
                                    // $category->name = 'All';
                                }
                                return $category;
                            })
                            ->toArray();
                        //$categories = get_categories();
                        $current_cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

                        foreach ($categories as $category) : ?>
                            <option value="<?php echo $category->term_id; ?>" <?php selected($current_cat, $category->term_id); ?>>
                                <?php echo esc_html($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="column p-t-0 is-paddingless search-button">
                <input type="submit" class="button is-primary" value="View">
            </div>
        </div>
    </form>

    <!-- Desktop Links Filter -->
    <div class="is-hidden-mobile pagination-filter-post">
        <div class="filter-div"><label>Filter by:</label></div>
        <div class="filter-category">
            <a href="<?php echo esc_url(home_url('/')); ?>/?taxonomy=category" class="pagination-filter-item <?php echo empty($current_cat) ? 'is-active' : ''; ?>">All</a>
            <?php foreach ($categories as $category) : ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                   class="pagination-filter-item <?php echo ($current_cat === $category->term_id) ? 'is-active' : ''; ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="column-social-widget component-social-share-widget">
    <div class="component-title">Share: </div>
    <div class="social-links">
        <a target="_blank" class="social-link" href="https://twitter.com/intent/tweet?text=<?php echo $social_tweet; ?>">
            <span class="twitter-social"><img src="<?php echo get_theme_file_uri('assets/images/twitter.png'); ?>" alt="Twitter"></span>
        </a>
        <a target="_blank" class="social-link" href="https://facebook.com/sharer.php?u=<?php echo $social_link; ?>">
            <span class="facebook-social"><img src="<?php echo get_theme_file_uri('assets/images/facebook.png'); ?>" alt="Facebook"></span>
        </a>
        <a target="_blank" class="social-link" href="http://www.reddit.com/submit?url=<?php echo $social_link; ?>">
            <span class="reddit-social"><img src="<?php echo get_theme_file_uri('assets/images/reddit.png'); ?>" alt="Reddit"></span>
        </a>
        <a target="_blank" class="social-link" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $social_link; ?>">
            <span class="linkedin-social"><img src="<?php echo get_theme_file_uri('assets/images/linkedin.png'); ?>" alt="LinkedIn"></span>
        </a>
        <a target="_blank" class="social-link" href="https://telegram.me/share/url?url=<?php echo $social_link; ?>">
            <span class="telegram-social"><img src="<?php echo get_theme_file_uri('assets/images/talegram-logo.png'); ?>" alt="Telegram"></span>
        </a>
        <a target="_blank" class="social-link" href="https://gettr.com/share?url=<?php echo $social_link; ?>">
            <span class="gettr-social"><img src="<?php echo get_theme_file_uri('assets/images/Gettr-logo.png'); ?>" alt="Gettr"></span>
        </a>
        <a class="social-link" href="mailto:?subject=<?php echo str_replace('+', ' ', $social_title); ?>&body=<?php echo $social_link; ?>">
            <span class="gmail-social"><img src="<?php echo get_theme_file_uri('assets/images/gmail.png'); ?>" alt="Email"></span>
        </a>
        <a class="social-link" href="javascript:void(0)" onclick="window.print()">
            <span class="print-social"><img src="<?php echo get_theme_file_uri('assets/images/print.png'); ?>" alt="Print"></span>
        </a>
    </div>
</div>
<hr class="m-b-50" />