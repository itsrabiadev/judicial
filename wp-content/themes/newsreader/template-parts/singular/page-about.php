
<?php
/**
 * Template part singular content
 *
 * @package Newsreader
 */

$post_id = get_the_ID();
$page    = get_post( $post_id );

// default background
$defaultImagePath = get_theme_file_uri( 'assets/images/section-title-bg-issues.jpg' );
$backgroundImage  = get_field( 'page_header_background_image', $post_id ) ?: $defaultImagePath;
if ( is_array( $backgroundImage ) && isset( $backgroundImage['url'] ) ) {
    $backgroundImage = $backgroundImage['url'];
}

// Build context (replacement for $this->context)
$context = [
    'page'            => $page,
    'backgroundImage' => $backgroundImage,

    'investigationsTab' => [
        'description' => get_field( 'investigations_tab_description', $post_id ),
        'staff'       => get_staff_data( 'investigations_staff_order', 'investigations_staff_member', $post_id ),
    ],
    'legalTab' => [
        'description' => get_field( 'legal_tab_description', $post_id ),
        'staff'       => get_staff_data( 'legal_staff_order', 'legal_staff_member', $post_id ),
    ],
    'boardTab' => [
        'description' => get_field( 'board_tab_description', $post_id ),
        'staff'       => get_staff_data( 'board_staff_order', 'board_staff_member', $post_id ),
    ],
    'staffTab' => [
        'description' => get_field( 'staff_tab_description', $post_id ),
        'staff'       => get_staff_data( 'staff_order', 'staff_member', $post_id ),
    ],
    'careersTab' => [
        'description' => get_field( 'career_tab_description', $post_id ),
        'careers'     => get_career_data( 'careers_order', $post_id ),
    ],
];
?>

<div class="cs-entry__wrap page page-about page-template-2col">

    <?php
    /**
     * The csco_entry_wrap_start hook.
     *
     * @since 1.0.0
     */
    do_action( 'csco_entry_wrap_start' );
    ?>

    <div class="cs-entry__container">

        <?php
        /**
         * The csco_entry_container_start hook.
         *
         * @since 1.0.0
         */
        do_action( 'csco_entry_container_start' );
        ?>

        <div class="cs-entry__content-wrap">


            <div class="entry-content">
                <!-- Header with dynamic background -->

                <section class="page-content page-container">
                    <div class="column-content p-b-30">
                        <div id="about_tabs" class="component-tabs">

                            <!-- Subpage nav -->
                            <div class="subpage-nav tabs-nav">
                                <li class="subpage-nav-item is-active" data-push-state="mission">Mission</li>
                                <li class="subpage-nav-item" data-push-state="investigations">Investigations</li>
                                <li class="subpage-nav-item" data-push-state="legal">Legal</li>
                                <li class="subpage-nav-item" data-push-state="board">Board</li>
                                <li class="subpage-nav-item" data-push-state="staff">Staff</li>
                                <li class="subpage-nav-item" data-push-state="careers">Careers</li>
                            </div>

                            <div class="tab-content">
                                <!-- Mission -->
                                <div id="mission" class="tab-pane is-active">
                                    <div class="wysiwyg-content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>

                                <!-- Investigations -->
                                <div id="investigations" class="tab-pane wysiwyg-content">
                                    <h1>Judicial Watch Investigations Team</h1>
                                    <?php if ( ! empty( $context['investigationsTab']['description'] ) ) : ?>
                                        <?php echo $context['investigationsTab']['description']; ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $context['investigationsTab']['staff'] ) ) : ?>
                                        <div class="staff-search">
                                            <input type="text" class="input js-filter-staff"
                                                   placeholder="Search for Investigations Team Member"/>
                                        </div>

                                        <?php foreach ( $context['investigationsTab']['staff'] as $staff_item ) : ?>
                                            <div class="team-item p-t-20">
                                                <div class="columns">
                                                    <?php if ( ! empty( $staff_item->thumbnail ) ) : ?>
                                                        <div class="column is-narrow column-headshot">
                                                            <img src="<?php echo esc_url( $staff_item->thumbnail ); ?>" alt=""/>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="column column-title">
                                                        <div class="title-content">
                                                            <h4><?php echo esc_html( $staff_item->title ); ?></h4>
                                                            <p class="has-text-primary"><?php echo esc_html( $staff_item->team_title ); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-content wysiwyg-content">
                                                    <?php echo $staff_item->content ; ?>
                                                </div>
                                                <div class="row-buttons">
                                                    <?php
                                                    if ( strlen( strip_tags( $staff_item->content ) ) > 200 ) : ?>
                                                        <button type="button"
                                                                class="button is-primary is-inverted is-slim js-expand-bio">
                                                            Expand Bio
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Legal -->
                                <div id="legal" class="tab-pane wysiwyg-content">
                                    <h1>Judicial Watch Legal Team</h1>
                                    <?php if ( ! empty( $context['legalTab']['description'] ) ) : ?>
                                        <?php echo ( $context['legalTab']['description'] ); ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $context['legalTab']['staff'] ) ) : ?>
                                        <div class="staff-search">
                                            <input type="text" class="input js-filter-staff"
                                                   placeholder="Search for Legal Team Member"/>
                                        </div>

                                        <?php foreach ( $context['legalTab']['staff'] as $staff_item ) : ?>
                                            <div class="team-item p-t-20">
                                                <div class="columns">
                                                    <?php if ( ! empty( $staff_item->thumbnail ) ) : ?>
                                                        <div class="column is-narrow column-headshot">
                                                            <img src="<?php echo esc_url( $staff_item->thumbnail ); ?>" alt=""/>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="column column-title">
                                                        <div class="title-content">
                                                            <h4><?php echo esc_html( $staff_item->title ); ?></h4>
                                                            <p class="has-text-primary"><?php echo esc_html( $staff_item->team_title ); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-content wysiwyg-content">
                                                    <?php echo $staff_item->content ; ?>
                                                </div>
                                                <div class="row-buttons">
                                                    <?php
                                                    if ( strlen( strip_tags( $staff_item->content ) ) > 200 ) : ?>
                                                        <button type="button"
                                                                class="button is-primary is-inverted is-slim js-expand-bio">
                                                            Expand Bio
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Board -->
                                <div id="board" class="tab-pane wysiwyg-content">
                                    <h1>Judicial Watch Board</h1>
                                    <?php if ( ! empty( $context['boardTab']['description'] ) ) : ?>
                                        <?php echo ( $context['boardTab']['description'] ); ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $context['boardTab']['staff'] ) ) : ?>
                                        <?php foreach ( $context['boardTab']['staff'] as $staff_item ) : ?>
                                            <div class="team-item p-t-20">
                                                <div class="columns">
                                                    <?php if ( ! empty( $staff_item->thumbnail ) ) : ?>
                                                        <div class="column is-narrow column-headshot">
                                                            <img src="<?php echo esc_url( $staff_item->thumbnail ); ?>" alt=""/>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="column column-title">
                                                        <div class="title-content">
                                                            <h4><?php echo esc_html( $staff_item->title ); ?></h4>
                                                            <p class="has-text-primary"><?php echo esc_html( $staff_item->team_title ); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row-content wysiwyg-content">
                                                    <?php echo $staff_item->content ; ?>
                                                </div>
                                                <div class="row-buttons">
                                                    <?php
                                                    if ( strlen( strip_tags( $staff_item->content ) ) > 200 ) : ?>
                                                        <button type="button"
                                                                class="button is-primary is-inverted is-slim js-expand-bio">
                                                            Expand Bio
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div id="staff" class="tab-pane wysiwyg-content">
                                    <h1>Judicial Watch Staff Team</h1>
                                    <?php if ( ! empty( $context['staffTab']['description'] ) ) : ?>
                                        <?php echo ( $context['staffTab']['description'] ); ?>
                                    <?php endif; ?>

                                   
                                </div>
                                <!-- Careers -->
                                <div id="careers" class="tab-pane wysiwyg-content">
                                    <h1>Careers</h1>
                                    <?php if ( ! empty( $context['careersTab']['description'] ) ) : ?>
                                        <?php echo ( $context['careersTab']['description'] ); ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $context['careersTab']['careers'] ) ) : ?>
                                        <?php foreach ( $context['careersTab']['careers'] as $career_post ) :
                                            //pre($career_post)
                                            ?>
                                            <div class="career-item p-t-20">
                                                <div class="title-content">
                                                    <h2><?php echo esc_html( $career_post->title ); ?></h2>
                                                    <?php if ( ! empty( $career_post->department ) ) : ?>
                                                        <p><strong>Department:</strong> <?php echo esc_html( $career_post->department); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ( ! empty( $career_post->reports_to ) ) : ?>
                                                        <p><strong>Reports To:</strong> <?php echo esc_html( $career_post->reports_to); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ( ! empty( $career_post->status ) ) : ?>
                                                        <p><strong>Status:</strong> <?php echo esc_html($career_post->status ); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ( ! empty( $career_post->summary ) ) : ?>
                                                        <p><strong>Summary:</strong> <?php echo ( $career_post->summary ); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ( ! empty($career_post->content ) ) : ?>
                                                        <div class="description wysiwyg-content">
                                                            <?php echo ( $career_post->content ); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div><!-- .tab-content -->
                        </div><!-- .component-tabs -->
                    </div>
                </section>
            </div>


        </div>

        <?php
        /**
         * The csco_entry_container_end hook.
         *
         * @since 1.0.0
         */
        do_action( 'csco_entry_container_end' );
        ?>

    </div>

    <?php
    /**
     * The csco_entry_wrap_end hook.
     *
     * @since 1.0.0
     */
    do_action( 'csco_entry_wrap_end' );
    ?>
</div>






