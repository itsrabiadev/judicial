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
$pageDescription = isset($page_fields['description']) ? $page_fields['description'] : '';
$pageFinePrint   = '';
if ( ! empty( $page_fields['fine_print'] ) ) {
	$pageFinePrint = $page_fields['fine_print'];
} elseif ( ! empty( $page_fields['finePrint'] ) ) {
	$pageFinePrint = $page_fields['finePrint'];
}
?>
<?php if ($backgroundImage || $backgroundColor ) : ?>
<style>
    main{
    <?php if ($backgroundImage) : ?> 
        background-image:url('<?php echo esc_url($backgroundImage); ?>');
        background-repeat: no-repeat;
        
        <?php endif; ?>
    <?php if ($backgroundColor) : ?> background-color:<?php echo esc_attr($backgroundColor); ?>;<?php endif; ?>
    }
    <?php if ($backgroundColor) : ?>
    .cs-entry__content-wrap{
        background-color: transparent;
    }
    <?php endif; ?>
</style>
<?php endif; ?>
<div class="cs-entry__wrap page page-petition">

    <?php do_action('csco_entry_wrap_start'); ?>

    <div class="cs-entry__container">


        <div class="cs-entry__content-wrap">

            <div class="entry-content">
                <div class="bg-cover" >
                    <section class="page-content page-container  mobile-p-b-40  mobile-p-t-40 container-600<?php echo esc_attr( $invert_class ); ?>">
                        <div class="wysiwyg-content<?php echo esc_attr( $invert_class ); ?>">
                            <h1 class="petition-title p-t-5 m-b-25"><?php echo get_the_title() ?></h1>
                             <?php echo wp_kses_post($pageDescription); ?>
                        </div>

                        <?php if ($form) : ?>
                            <div class="wysiwyg-content<?php echo esc_attr( $invert_class ); ?>">
                                <?php echo $form; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($pageFinePrint)) : ?>
                            <div class="wysiwyg-content<?php echo esc_attr( $invert_class ); ?>">
                                <small class="m-t-50 is-inline-block<?php echo $invert_text ? ' has-text-white' : ''; ?>">
                                    <?php echo esc_html($pageFinePrint); ?>
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
