<?php
/**
 * Assets
 *
 * All enqueues of scripts and styles.
 *
 * @package Newsreader
 */

if ( ! function_exists( 'csco_content_width' ) ) {
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function csco_content_width() {
		/**
		 * The csco_content_width hook.
		 *
		 * @since 1.0.0
		 */
		$GLOBALS['content_width'] = apply_filters( 'csco_content_width', 1200 );
	}
}
add_action( 'after_setup_theme', 'csco_content_width', 0 );

if ( ! function_exists( 'csco_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function csco_enqueue_scripts() {

		$version = csco_get_theme_data( 'Version' );

		// Register theme scripts.
		wp_register_script( 'csco-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), $version, true );

		// Localization array.
		$localize = array(
			'siteSchemeMode'   => get_theme_mod( 'color_scheme', 'system' ),
			'siteSchemeToogle' => get_theme_mod( 'color_scheme_toggle', true ),
		);

		// Localize the main theme scripts.
		wp_localize_script( 'csco-scripts', 'csLocalize', $localize );

        // Enqueue Vue (your custom script).
        if ( is_singular( 'donation_pages' ) ) {
			wp_enqueue_script(
				'vue',
				'https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js',
				array(),
				'2.6.10',
				true
			);
		}


            wp_enqueue_script(
                'donation-script',
                get_stylesheet_directory_uri() . '/assets/js/donation.js',
                array('jquery'), // ensures jQuery loads first
                null,
                true // load in footer
            );
        wp_enqueue_script(
            'custom-script',
            get_stylesheet_directory_uri() . '/assets/js/custom.js',
            array('jquery'), // ensures jQuery loads first
            null,
            true // load in footer
        );

        // Enqueue Gravity Form scripts for form ID=6.
        if ( class_exists( 'GFForms' ) ) {
            gravity_form_enqueue_scripts( 6, true );
        }

		// Enqueue theme scripts.
		wp_enqueue_script( 'csco-scripts' );

		// Enqueue comment reply script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );

			wp_register_script( 'csco-comment-reply', get_template_directory_uri() . '/assets/static/js/comment-reply.js', array(), $version, true );
			wp_enqueue_script( 'csco-comment-reply' );
		}

		wp_register_script( 'csco-swiper', get_template_directory_uri() . '/assets/static/js/swiper-bundle.min.js', array(), $version, true );
		wp_enqueue_script( 'csco-swiper' );

		wp_dequeue_script( sprintf( '%s-reply', 'comment' ) );

        if ((is_page('jwtv') || is_post_type_archive('videos') || get_post_type() === 'videos') || is_singular('videos')):
            // Enqueue YouTube Subscribe button script (Platform.js)
        wp_enqueue_script(
            'youtube-platform',
            'https://apis.google.com/js/platform.js',
            array(),
            null,
            true
        );
        endif;

        // Register theme styles.
		wp_register_style( 'csco-styles', csco_style( get_template_directory_uri() . '/style.css' ), array(), $version );

		$custom_css_path = get_template_directory() . '/assets/css/custom.css';
		$custom_css_ver  = file_exists( $custom_css_path ) ? filemtime( $custom_css_path ) : $version;
		wp_register_style( 'csco-custom-styles', csco_style( get_template_directory_uri() . '/assets/css/custom.css' ), array( 'csco-styles' ), $custom_css_ver );

		// Enqueue theme styles.
		wp_enqueue_style( 'csco-styles' );
		wp_enqueue_style( 'csco-custom-styles' );

		// Add RTL support.
		wp_style_add_data( 'csco-styles', 'rtl', 'replace' );

		// Enqueue typography styles.
		csco_enqueue_typography_styles( 'csco-styles' );

		// Dequeue Contact Form 7 styles.
		wp_dequeue_style( 'contact-form-7' );
	}
}
add_action( 'wp_enqueue_scripts', 'csco_enqueue_scripts', 99 );

/**
 * Remove jQuery Migrate on the front-end.
 *
 * WP core adds jquery-migrate as a dependency of 'jquery'. If no scripts rely on
 * deprecated jQuery APIs, we can safely drop it to reduce render-blocking JS.
 */
function jw_remove_jquery_migrate( $scripts ) {
	if ( is_admin() ) {
		return;
	}

	if ( isset( $scripts->registered['jquery'] ) && ! empty( $scripts->registered['jquery']->deps ) ) {
		$scripts->registered['jquery']->deps = array_diff(
			$scripts->registered['jquery']->deps,
			array( 'jquery-migrate' )
		);
	}
}
add_action( 'wp_default_scripts', 'jw_remove_jquery_migrate' );

