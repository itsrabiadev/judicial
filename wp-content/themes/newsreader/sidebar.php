<?php
$sidebar = apply_filters( 'csco_sidebar', 'sidebar-main' );

if ( 'disabled' !== csco_get_page_sidebar() ) {

    // Only for 'documents' CPT archive

    // Default sidebar
    ?>
    <aside id="secondary" class="cs-widget-area cs-sidebar__area">
        <div class="cs-sidebar__inner">

            <?php
            if ( (is_post_type_archive( 'documents' ) || get_post_type() === 'documents') && !is_singular()  ) {

                // Your custom taxonomies
                $taxonomies = array( 'document_categories', 'document_tags' );

                foreach ( $taxonomies as $taxonomy_name ) {
                    $taxonomy_obj = get_taxonomy( $taxonomy_name );
                    if ( ! $taxonomy_obj ) continue;

                    echo ' <div class="widget_text widget custom_html-5 widget_custom_html">';
                    echo '<h2 class="widgettitle">' . esc_html( $taxonomy_obj->label ) . '</h2>';
                    echo '<ul class="p-0">';

                    // Fetch terms for this taxonomy that have published posts
                    $terms = get_terms( array(
                        'taxonomy'   => $taxonomy_name,
                        'hide_empty' => true, // only terms with posts
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'number'     => 20,
                    ) );

                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $term ) {
                            echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '">'
                                . esc_html( $term->name ) . '</a></li>';
                        }
                    }

                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>
            <?php if ( (is_post_type_archive( 'videos' ) || get_post_type() === 'videos') || is_singular('videos')  ): ?>
            <div class="widget_text widget custom_html-5 widget_custom_html">
                <div class="column column-logo" style="background-color: #0e131a">
                    <a href="/jwtv">
                        <img src="/wp-content/themes/judicial-watch/assets/images/jw-tv-new1-logo.png"/>
                    </a>
                </div>

                <div class="column column-youtube">
                    <div class="g-ytsubscribe" data-channel="JudicialWatch"></div>
                </div>
            </div>
            <?php endif; ?>
            <?php do_action( 'csco_sidebar_start' ); ?>

            <?php dynamic_sidebar( $sidebar ); ?>

            <?php do_action( 'csco_sidebar_end' ); ?>

        </div>
    </aside>
<?php } ?>
