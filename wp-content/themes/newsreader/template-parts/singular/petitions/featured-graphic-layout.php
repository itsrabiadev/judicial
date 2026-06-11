<?php
/**
 * Template part for displaying Petition layout content
 *
 * @package Newsreader
 */

$post_id = get_the_ID();

// Page fields (ACF)
$page_fields = get_fields($post_id);

$layout          = jw_get_petition_layout( $post_id );
$backgroundImage = jw_get_petition_background_image_url( $post_id );
$backgroundColor = ! empty( $layout['page_background_color'] ) ? $layout['page_background_color'] : '';
$invert_text     = jw_petition_uses_white_text( $post_id );
$invert_class    = $invert_text ? ' invert-body-text' : '';

// Petition gravity form
$form_id = get_field('petition_gravity_form', $post_id);
$form = $form_id ? gravity_form($form_id, false, false, false, null, false, 1, false) : '';

// Other content
$pageDescription = !empty($page_fields['description']) ? $page_fields['description'] : '';
$pageFinePrint = !empty($page_fields['finePrint']) ? $page_fields['finePrint'] : '';
$formBackground = ! empty( $layout['form_background_color'] ) ? $layout['form_background_color'] : '#000';
?>

<?php if ($backgroundImage || $backgroundColor): ?>
    <style>
        <?php if ($backgroundImage): ?>
            #breadcrumbs {
                display: none;
            }

            @media (min-width: 1200px) {
                .cs-sidebar-disabled .cs-entry__content-wrap {
                    background: transparent;
                }
            }

            @media (min-width: 1280px) {
                .cs-entry__content-wrap {
                    background: transparent;
                }
            }

        <?php endif; ?>
        main {
            <?php if ($backgroundImage): ?>
                background-image: url('<?php echo esc_url($backgroundImage); ?>');
                background-repeat: no-repeat;
            <?php endif; ?>
            <?php if ($backgroundColor): ?>
                background-color:
                    <?php echo esc_attr($backgroundColor); ?>
                ;
                background-size: contain !important;
                background-position: top center;
            <?php endif; ?>
        }

        <?php if ($backgroundColor): ?>
            .cs-entry__content-wrap {
                background-color: transparent;
            }

        <?php endif; ?>
        @media (min-width: 768px) {
            .single .entry-content {
                max-width: 1400px;
            }
        }

        @media (min-width: 992px) {
            .cs-entry__wrap:not(:first-child) {
                margin-top: 5rem;
            }
        }

        .cs-entry__content-wrap:first-child {
            margin-top: 2rem;
        }

        @media screen and (min-width: 992px) {
            .cs-entry__content-wrap {
                width: 1400px;
                max-width: 1400px;
                margin-left: auto;
                margin-right: auto;
            }
        }



        .entry-content b,
        .entry-content strong {
            color: <?php echo $invert_text ? '#ffffff' : '#000000'; ?>;
        }
    </style>
<?php endif; ?>

<div class="cs-entry__wrap page page-petition">
    <?php do_action('csco_entry_wrap_start'); ?>

    <div class="cs-entry__container">
        <div class="cs-entry__content-wrap">
            <div class="entry-content">

                <div class="bg-cover bg-cover-featured-graphic">
                    <section
                        class="page-content page-container p-b-120 mobile-p-b-40 p-t-120 mobile-p-t-40 container-950<?php echo esc_attr( $invert_class ); ?>">

                        <!-- Page Content -->
                        <div class="wysiwyg-content featured-graphic-form<?php echo esc_attr( $invert_class ); ?>"
                            style="background-color: <?php echo esc_attr($formBackground); ?>;">
                            <?php if ($form):
                                $allowed_tags = array_merge(wp_kses_allowed_html('post'), array(
                                    'script' => array(
                                        'type' => true,
                                    ),
                                ));
                                ?>
                                <?php if ($pageDescription): ?>
                                    <div class="columns">
                                        <div class="column is-half">
                                            <?php echo $form; ?>
                                        </div>
                                        <div class="column is-half">
                                            <?php echo wp_kses($pageDescription, $allowed_tags); ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php echo $form; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php if ($pageFinePrint): ?>
                            <div class="wysiwyg-content<?php echo esc_attr( $invert_class ); ?>">
                                <small
                                    class="m-t-50 is-inline-block<?php echo $invert_text ? ' has-text-white' : ''; ?>">
                                    <?php echo wp_kses_post($pageFinePrint); ?>
                                </small>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>

            </div>
        </div>
    </div>

    <?php do_action('csco_entry_wrap_end'); ?>
</div>