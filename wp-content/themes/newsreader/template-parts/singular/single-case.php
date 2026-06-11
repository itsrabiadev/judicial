<!-- Section: Page Title -->
<?php
$post_id = get_the_ID();
$featuredDocument = getFeaturedDoc($post_id);
$relatedDocuments = getRelatedDocument($post_id);
$relatedCases = getRelatedCases($post_id);
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
<small class="post-date">
                    <?php echo get_the_date(); ?>
                    <span class="p-l-5 p-r-5">|</span>
                    Case
                </small>
<div class="post-has-right-sidebar columns">
    <!-- Post -->
    <section class="column post">

        <!-- Featured Video (example YouTube embed from meta or content) -->
        <div class="wysiwyg-content no-printme">
            <div class="container-featured-image responsive-media">
                <?php
                // Example: If you store a YouTube link in post meta
                $youtube_url = get_field('case_video') ?: 'https://www.youtube.com/embed/wQvQ72uJa6g?controls=0';
                if ($youtube_url) :
                    ?>
                    <iframe width="100%" height="500" src="<?php echo esc_url($youtube_url); ?>?controls=0"
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <?php endif; ?>
            </div>
        </div>

        <div class="post-container">
            <div class="column-post wysiwyg-content">

                <div class="post-content">
                    <?php the_content(); ?>

                    <?php if (!empty($featuredDocument)) : ?>
                        <div class="columns is-multiline grid-document-archives is-type-singular no-printme">
                            <div class="column is-full no-printme">
                                <div class="component-card-document no-printme">
                                    <div class="document-image">
                                        <img src="<?php echo esc_url(get_theme_file_uri('assets/images/placeholder/placeholder-document-80x110.png')); ?>"
                                             alt="Document placeholder"/>
                                    </div>
                                    <div class="is-list-flex">
                                        <div class="is-list-col">
                                            <h4 class="component-title">
                                                <a href="<?php echo esc_url($featuredDocument->link); ?>">
                                                    <?php echo esc_html($featuredDocument->title); ?>
                                                </a>
                                            </h4>

                                            <?php if (!empty($featuredDocument->date)) : ?>
                                                <div class="date"><?php echo esc_html($featuredDocument->date); ?></div>
                                            <?php endif; ?>

                                            <div class="columns columns-meta column-meta-page">
                                                <div class="column-dt">Pages:</div>
                                                <div class="column-dd">unknown</div>
                                            </div>

                                            <?php if (!empty($featuredDocument->category) && !empty($featuredDocument->category['name'])) : ?>
                                                <div class="columns columns-meta">
                                                    <div class="column-dt">Category:</div>
                                                    <div class="column-dd">
                                                        <a href="<?php echo esc_url($featuredDocument->category['link']); ?>">
                                                            <?php echo esc_html($featuredDocument->category['name']); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($featuredDocument->tags) && is_array($featuredDocument->tags)) : ?>
                                                <div class="columns columns-meta">
                                                    <div class="column-dt">Tags:</div>
                                                    <div class="column-dd">
                                                        <?php foreach ($featuredDocument->tags as $docTag) : ?>
                                                            <a href="<?php echo esc_url($docTag['link']); ?>">
                                                                <?php echo esc_html($docTag['name']); ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>


                                        <?php if (!empty($featuredDocument->attachment_url)) : ?>
                                            <a href="<?php echo esc_url($featuredDocument->attachment_url); ?>"
                                               class="button is-primary m-t-30 button-download">
                                                Download Case
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-t-50"/>
                    <?php endif; ?>

                    <?php

                    if ($relatedDocuments) : ?>
                        <h4 class="related-documents-hdg">Related Documents</h4>
                        <div class="columns is-multiline grid-document-archives is-type-singular has-multiple">
                            <?php foreach ($relatedDocuments as $relatedDocument) : ?>
                                <div class="column is-full">
                                    <div class="component-card-document">
                                        <div class="document-image">
                                            <?php if (!empty($relatedDocument->thumbnail)) : ?>
                                                <img src="<?php echo esc_url($relatedDocument->thumbnail); ?>"
                                                     alt="<?php echo esc_attr($relatedDocument->title); ?>"/>
                                            <?php else : ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder/placeholder-document-80x110.png'); ?>"
                                                     alt="Placeholder"/>
                                            <?php endif; ?>
                                        </div>
                                        <div class="is-list-flex">
                                            <div class="is-list-col">
                                                <?php if (!empty($relatedDocument->link)): ?>
                                                    <h4 class="component-title">
                                                        <a href="<?php echo esc_url($relatedDocument->link); ?>">
                                                            <?php echo esc_html($relatedDocument->title); ?>
                                                        </a>
                                                    </h4>

                                                    <div class="date"><?php echo esc_html($relatedDocument->date); ?></div>
                                                <?php endif; ?>
                                                <?php if (!empty($relatedDocument->category)) : ?>
                                                    <div class="columns columns-meta">
                                                        <div class="column-dt">Category:</div>
                                                        <div class="column-dd">
                                                            <a href="<?php echo esc_url($relatedDocument->category['link']); ?>">
                                                                <?php echo esc_html($relatedDocument->category['name']); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($relatedDocument->tags)) : ?>
                                                    <div class="columns columns-meta">
                                                        <div class="column-dt">Tags:</div>
                                                        <div class="column-dd">
                                                            <?php foreach ($relatedDocument->tags as $tag) : ?>
                                                                <a href="<?php echo esc_url($tag['link']); ?>">
                                                                    <?php echo esc_html($tag['name']); ?>
                                                                </a>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <a href="/cases" class="button is-primary m-t-25 m-b-35 button-view-more-docs">View More</a>
                        </div>

                    <?php endif; ?>


                </div>
                <?php if ($relatedCases) : ?>
                    <!-- Section: Related Cases -->
                    <section class="cs-posts-area cs-posts-area-posts related-posts">
                        <div class="cs-posts-area__outer">
                            <h1 class="section-title section-title-primary-bordered">Related Cases</h1>
                            <div class="cs-posts-area__main cs-archive-grid  cs-posts-area__archive cs-posts-area__grid cs-posts-area__main-divider" data-pc="3">
                                <?php foreach ($relatedCases as $relatedCase) :
                                    // Make related case the global $post
                                    $post = get_post($relatedCase->postId ?? $relatedCase);
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
                    </section>
                <?php endif; ?>


            </div>
        </div>
    </section>

</div>