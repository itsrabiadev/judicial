<?php
global $post;

$title = get_the_title(); // Initialize to avoid undefined variable

if (is_singular('cases')) {
    $title = "Latest Lawsuits";
} elseif (is_post_type_archive('petitions')) {
    $title = 'Take Action';
}
elseif (is_singular('documents') || is_post_type_archive('documents')) {
    $title = 'Document Archives';
}
elseif (is_category() || is_tag() || is_tax()) {
    $title = single_term_title('', false);
} elseif (is_post_type_archive()) {
    $title = get_the_archive_title();
} elseif (is_search()) {
    $title = 'Search Results for "' . get_search_query() . '"';
} elseif (is_404()) {
    $title = 'Page Not Found';
} elseif (get_the_title()) {
    $title = get_the_title();
}

if (!is_singular(['post','petitions','videos','donation_pages']) && !is_page('jwtv') && !is_404() && !is_post_type_archive('videos') && !is_tax('playlists') && !is_front_page() && !is_home()):
?>
<style>
.cs-page__header .cs-page__title{
    display:none;
}
.cs-entry__header .cs-entry__title{
    display:none;
}
</style>
<section class="component-subpage-title is-subpage-lawsuits no-printme">
    <h1><?= ($title); ?></h1>
</section>
<?php endif; ?>