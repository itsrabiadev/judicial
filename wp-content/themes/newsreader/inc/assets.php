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

if ( ! function_exists( 'jw_page_needs_swiper' ) ) {
	/**
	 * Whether the current singular page actually uses a Swiper-powered widget
	 * (cs-carousel, cs-posts-slider, or the cs-posts "elementor-slider" layout).
	 *
	 * Elementor stores all of a post's widget config in one `_elementor_data`
	 * postmeta JSON blob (including nested tabs / load-more layout values), so
	 * a substring scan of that blob is enough — no need to walk the widget tree.
	 *
	 * Caveat: this can't see Swiper usage coming from an Elementor Pro
	 * theme-builder global template (e.g. a carousel placed in a global header/
	 * footer), because that lives in a different post's _elementor_data. None
	 * currently do (verified against this codebase) — re-check this helper if
	 * a global carousel/slider template is added later.
	 */
	function jw_page_needs_swiper() {
		if ( ! is_singular() ) {
			return true; // Archives/search results aren't a single _elementor_data blob — fail open.
		}

		$post_id = get_queried_object_id();

		if ( ! $post_id ) {
			return true;
		}

		$elementor_data = get_post_meta( $post_id, '_elementor_data', true );

		if ( ! $elementor_data ) {
			return false;
		}

		foreach ( array( 'cs-carousel', 'cs-posts-slider', 'elementor-slider' ) as $needle ) {
			if ( false !== strpos( $elementor_data, $needle ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'csco_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function csco_enqueue_scripts() {

		$version = csco_get_theme_data( 'Version' );

		// Register theme scripts.
		wp_register_script( 'csco-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), filemtime( get_template_directory() . '/assets/js/scripts.js' ), true );

		// Localization array.
		$localize = array(
			'siteSchemeMode'   => get_theme_mod( 'color_scheme', 'system' ),
			'siteSchemeToogle' => get_theme_mod( 'color_scheme_toggle', true ),
		);

		// Localize the main theme scripts.
		wp_localize_script( 'csco-scripts', 'csLocalize', $localize );

		// Donation flow (Vue + VeeValidate app): only needed on the donation_pages template.
		if ( is_singular( 'donation_pages' ) ) {
			wp_enqueue_script(
				'vue',
				'https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js',
				array(),
				'2.6.10',
				true
			);

			wp_enqueue_script(
				'donation-script',
				get_stylesheet_directory_uri() . '/assets/js/donation.js',
				array( 'jquery' ), // ensures jQuery loads first
				filemtime( get_stylesheet_directory() . '/assets/js/donation.js' ),
				true // load in footer
			);
		}

		wp_enqueue_script(
			'custom-script',
			get_stylesheet_directory_uri() . '/assets/js/custom.js',
			array( 'jquery' ), // ensures jQuery loads first
			filemtime( get_stylesheet_directory() . '/assets/js/custom.js' ),
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

		// Swiper: only load on pages that actually contain a carousel/slider widget.
		if ( jw_page_needs_swiper() ) {
			wp_register_script( 'csco-swiper', get_template_directory_uri() . '/assets/static/js/swiper-bundle.min.js', array(), $version, true );
			wp_enqueue_script( 'csco-swiper' );
		}

		wp_dequeue_script( sprintf( '%s-reply', 'comment' ) );

		if ( ( is_page( 'jwtv' ) || is_post_type_archive( 'videos' ) || get_post_type() === 'videos' ) || is_singular( 'videos' ) ) :
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

		// Legacy Judicial Watch overrides. Previously a hardcoded <link> in
		// template-parts/header-judicial.php (which, worse, prints inside <body> —
		// see that file's notes); now enqueued so it loads once, in dependency
		// order, with real cache-busting.
		$jw_legacy_css_path = get_template_directory() . '/assets/assets/css/style.css';

		if ( file_exists( $jw_legacy_css_path ) ) {
			wp_register_style( 'jw-legacy-styles', get_template_directory_uri() . '/assets/assets/css/style.css', array( 'csco-styles' ), filemtime( $jw_legacy_css_path ) );
			wp_enqueue_style( 'jw-legacy-styles' );
		}

		$custom_css_path = get_template_directory() . '/assets/css/custom.css';
		$custom_css_ver  = file_exists( $custom_css_path ) ? filemtime( $custom_css_path ) : $version;
		wp_register_style(
			'csco-custom-styles',
			csco_style( get_template_directory_uri() . '/assets/css/custom.css' ),
			file_exists( $jw_legacy_css_path ) ? array( 'csco-styles', 'jw-legacy-styles' ) : array( 'csco-styles' ),
			$custom_css_ver
		);

		// Enqueue theme styles.
		wp_enqueue_style( 'csco-styles' );
		wp_enqueue_style( 'csco-custom-styles' );

		// Font Awesome 6.5.2 — only the icon styles actually referenced in this
		// theme (fas/solid, far/regular, fab/brands). `all.css` also ships
		// light/duotone/thin/sharp weights this codebase never uses.
		wp_enqueue_style( 'jw-fontawesome', 'https://use.fontawesome.com/releases/v6.5.2/css/fontawesome.css', array(), null );
		wp_enqueue_style( 'jw-fontawesome-solid', 'https://use.fontawesome.com/releases/v6.5.2/css/solid.css', array( 'jw-fontawesome' ), null );
		wp_enqueue_style( 'jw-fontawesome-regular', 'https://use.fontawesome.com/releases/v6.5.2/css/regular.css', array( 'jw-fontawesome' ), null );
		wp_enqueue_style( 'jw-fontawesome-brands', 'https://use.fontawesome.com/releases/v6.5.2/css/brands.css', array( 'jw-fontawesome' ), null );

		// No-sidebar single-post layout fix. Previously a hardcoded <link> in
		// header-judicial.php; same condition, now enqueued so it prints in
		// <head> and after custom.css so its rules actually win the cascade.
		// Skip the homepage — it is Elementor-built and uses its own full-width layout.
		$jw_layout_css = get_template_directory() . '/assets/css/no-sidebar-layout.css';

		if (
			is_singular()
			&& ! is_front_page()
			&& function_exists( 'csco_get_page_sidebar' )
			&& 'disabled' === csco_get_page_sidebar()
			&& file_exists( $jw_layout_css )
		) {
			wp_register_style( 'jw-no-sidebar-layout', get_template_directory_uri() . '/assets/css/no-sidebar-layout.css', array( 'csco-custom-styles' ), filemtime( $jw_layout_css ) );
			wp_enqueue_style( 'jw-no-sidebar-layout' );
		}

		// Add RTL support.
		wp_style_add_data( 'csco-styles', 'rtl', 'replace' );

		// Enqueue typography styles.
		csco_enqueue_typography_styles( 'csco-styles' );

		// Dequeue Contact Form 7 styles.
		wp_dequeue_style( 'contact-form-7' );
	}
}
add_action( 'wp_enqueue_scripts', 'csco_enqueue_scripts', 99 );

if ( ! function_exists( 'jw_fontawesome_crossorigin' ) ) {
	/**
	 * Add crossorigin to the Font Awesome CDN <link> tags.
	 *
	 * Not using `integrity` here: splitting all.css into per-style files means
	 * each URL needs its own SRI hash. Pull the correct hashes from Font
	 * Awesome's CDN docs (https://use.fontawesome.com) before relying on SRI
	 * for these — a wrong/guessed hash blocks the stylesheet outright.
	 */
	function jw_fontawesome_crossorigin( $html, $handle ) {
		$fa_handles = array( 'jw-fontawesome', 'jw-fontawesome-solid', 'jw-fontawesome-regular', 'jw-fontawesome-brands' );

		if ( in_array( $handle, $fa_handles, true ) ) {
			$html = str_replace( " />", ' crossorigin="anonymous" />', $html );
		}

		return $html;
	}
}
add_filter( 'style_loader_tag', 'jw_fontawesome_crossorigin', 10, 2 );

if ( ! function_exists( 'jw_resource_hints' ) ) {
	/**
	 * Preconnect / dns-prefetch for third-party CDNs used on every page load,
	 * so the browser opens the connection before the stylesheet request itself.
	 * fonts.gstatic.com is already added by CSCO_Customizer_Fonts_Google::resource_hints().
	 */
	function jw_resource_hints( $urls, $relation_type ) {
		if ( 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href'        => 'https://fonts.googleapis.com',
				'crossorigin' => 'anonymous',
			);
			$urls[] = array(
				'href'        => 'https://use.fontawesome.com',
				'crossorigin' => 'anonymous',
			);
		}

		if ( 'dns-prefetch' === $relation_type ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = 'https://use.fontawesome.com';
		}

		return $urls;
	}
}
add_filter( 'wp_resource_hints', 'jw_resource_hints', 10, 2 );

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

