<!-- Section: Page Content -->
<section class="page-content page-container container-1100 p-b-50 page-special-report">
    <div class="columns columns-page-content is-multiline">
        <div class="column is-narrow column-report is-hidden-mobile">
            <?php
            $image = get_field('report_image', get_the_ID());
            if ( ! empty( $image['url'] ) ) : ?>
                <img src="<?php echo esc_url( $image['url'] ); ?>" alt="">
            <?php endif; ?>
        </div>

        <div class="column column-form">
            <!-- Page Content -->
            <div class="wysiwyg-content">
                <?php the_content(); ?>
            </div>

            <?php
//           $form = gravity_form(get_field('special_report_gravity_form', get_the_ID()), false, false, false, null, true, 1, false);
            $form = get_field('special_report_gravity_form', get_the_ID());
            if ( $form ) {
                echo do_shortcode('[gravityform id="'.$form.'" title="false" description="false" ajax="true"]');

                //echo $form;
            }

            $disclaimer = get_field('disclaimer',get_the_ID());
            if ( $disclaimer ) : ?>
                <small class="m-t-20 is-inline-block">
                    <?php echo esc_html( $disclaimer ); ?>
                </small>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
     /**
         * Prompt download on success
         */
        jQuery(document).on('gform_confirmation_loaded', function(event, formId){

            var id = '<?= get_the_ID() ?>';

            window.location = '/download-special-report.php?id=<?= get_the_ID() ?>';

        });
</script>
