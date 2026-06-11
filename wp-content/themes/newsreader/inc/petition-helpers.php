<?php
/**
 * Petition layout helpers (ACF layout group + legacy fields).
 *
 * @package Newsreader
 */

if ( ! function_exists( 'jw_get_petition_layout' ) ) {
	/**
	 * Normalized petition layout fields from the ACF "layout" group.
	 *
	 * @param int|null $post_id Post ID.
	 * @return array<string, mixed>
	 */
	function jw_get_petition_layout( $post_id = null ) {
		$post_id = $post_id ? (int) $post_id : get_the_ID();

		if ( ! $post_id ) {
			return array();
		}

		$layout = get_field( 'layout', $post_id );
		if ( ! is_array( $layout ) ) {
			$layout = array();
		}

		$legacy_map = array(
			'design_type'           => 'layout_design_type',
			'form_background_color' => 'layout_form_background_color',
			'page_background_image' => 'layout_page_background_image',
			'page_background_color' => 'layout_page_background_color',
			'text_color'            => 'layout_text_color',
		);

		foreach ( $legacy_map as $key => $legacy_key ) {
			if ( isset( $layout[ $key ] ) && '' !== $layout[ $key ] && null !== $layout[ $key ] ) {
				continue;
			}

			$value = get_field( $legacy_key, $post_id );
			if ( null !== $value && '' !== $value && false !== $value ) {
				$layout[ $key ] = $value;
			}
		}

		return $layout;
	}
}

if ( ! function_exists( 'jw_petition_uses_white_text' ) ) {
	/**
	 * Whether the petition layout is configured for light text on a dark background.
	 *
	 * @param int|null $post_id Post ID.
	 */
	function jw_petition_uses_white_text( $post_id = null ) {
		$layout = jw_get_petition_layout( $post_id );

		return ! empty( $layout['text_color'] ) && 'white' === $layout['text_color'];
	}
}

if ( ! function_exists( 'jw_get_petition_background_image_url' ) ) {
	/**
	 * Background image URL for a petition page.
	 *
	 * @param int|null $post_id Post ID.
	 */
	function jw_get_petition_background_image_url( $post_id = null ) {
		$layout = jw_get_petition_layout( $post_id );
		$image  = $layout['page_background_image'] ?? null;

		if ( is_array( $image ) && ! empty( $image['url'] ) ) {
			return $image['url'];
		}

		if ( is_string( $image ) && $image ) {
			return $image;
		}

		return '';
	}
}

if ( ! function_exists( 'jw_get_petition_layout_type' ) ) {
	/**
	 * Resolve the petition layout type from ACF (supports legacy group field).
	 *
	 * @param int|null $post_id Post ID.
	 */
	function jw_get_petition_layout_type( $post_id = null ) {
		$layout = jw_get_petition_layout( $post_id );
		$type   = $layout['design_type'] ?? '';

		return is_string( $type ) ? $type : '';
	}
}

if ( ! function_exists( 'jw_petition_body_classes' ) ) {
	/**
	 * Body classes for petition templates (matches judicial-watch behavior).
	 *
	 * @param string[] $classes Body classes.
	 * @return string[]
	 */
	function jw_petition_body_classes( $classes ) {
		if ( ! is_singular( 'petitions' ) ) {
			return $classes;
		}

		$classes[] = 'p-t-0';
		$classes[] = 'page-template-petition';

		$layout_type = jw_get_petition_layout_type();

		if ( 'basic_sidebar' === $layout_type ) {
			$classes[] = 'page-template-petition-2col';

			if ( jw_get_petition_background_image_url() ) {
				$classes[] = 'petition-has-page-background';
			}
		}

		return $classes;
	}

	add_filter( 'body_class', 'jw_petition_body_classes' );
}

if ( ! function_exists( 'jw_get_petition_hidden_status_label' ) ) {
	/**
	 * Human-readable label for the petition "Hidden" post status.
	 */
	function jw_get_petition_hidden_status_label() {
		return _x( 'Hidden', 'petitions', 'newsreader' );
	}
}

if ( ! function_exists( 'jw_register_petition_hidden_post_status' ) ) {
	/**
	 * Register a "Hidden" status for petitions (excluded from listing, still viewable by URL).
	 */
	function jw_register_petition_hidden_post_status() {
		register_post_status(
			'rejected',
			array(
				'label'                     => jw_get_petition_hidden_status_label(),
				// Must be public so WordPress allows direct URL views; archive uses pre_get_posts below.
				'public'                    => true,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop(
					'Hidden <span class="count">(%s)</span>',
					'Hidden <span class="count">(%s)</span>',
					'newsreader'
				),
			)
		);
	}

	add_action( 'init', 'jw_register_petition_hidden_post_status' );
}

if ( ! function_exists( 'jw_petition_hidden_post_status_admin_footer' ) ) {
	/**
	 * Show "Hidden" in the Publish box and status dropdown on petition edit screens.
	 *
	 * WordPress core only renders built-in statuses in #post-status-display; custom statuses
	 * appear blank after save unless we inject the label and add the dropdown option.
	 */
	function jw_petition_hidden_post_status_admin_footer() {
		global $post;

		if ( ! $post || 'petitions' !== $post->post_type ) {
			return;
		}

		$hidden_label = jw_get_petition_hidden_status_label();
		$is_hidden    = ( 'rejected' === $post->post_status );
		?>
<script>
jQuery(function($) {
	function jwSetPetitionHiddenStatus() {
		var label = <?php echo wp_json_encode( $hidden_label ); ?>,
			$select = $('#post_status');

		if ( ! $select.length ) {
			return;
		}

		if ( ! $select.find('option[value="rejected"]').length ) {
			$select.append($('<option>', { value: 'rejected', text: label }));
		}

		if ( <?php echo $is_hidden ? 'true' : 'false'; ?> || $('#hidden_post_status').val() === 'rejected' || $select.val() === 'rejected' ) {
			$select.val('rejected');
			$('#hidden_post_status').val('rejected');
			$('#post-status-display').text(label);
		}
	}

	jwSetPetitionHiddenStatus();
	$(window).on('load', jwSetPetitionHiddenStatus);

	$(document).on('click', '.save-post-status', function() {
		setTimeout(function() {
			if ( $('#post_status').val() === 'rejected' ) {
				$('#hidden_post_status').val('rejected');
				$('#post-status-display').text(<?php echo wp_json_encode( $hidden_label ); ?>);
			}
		}, 0);
	});
});
</script>
		<?php
	}

	add_action( 'admin_footer-post.php', 'jw_petition_hidden_post_status_admin_footer' );
	add_action( 'admin_footer-post-new.php', 'jw_petition_hidden_post_status_admin_footer' );
}

if ( ! function_exists( 'jw_preserve_petition_hidden_status_on_save' ) ) {
	/**
	 * Keep Hidden status when updating a petition (WordPress treats Update like Publish).
	 */
	function jw_preserve_petition_hidden_status_on_save( $data, $postarr ) {
		if ( empty( $data['post_type'] ) || 'petitions' !== $data['post_type'] ) {
			return $data;
		}

		if ( ! empty( $_POST['post_status'] ) && 'rejected' === sanitize_key( wp_unslash( $_POST['post_status'] ) ) ) {
			$data['post_status'] = 'rejected';
			return $data;
		}

		$post_id = ! empty( $postarr['ID'] ) ? (int) $postarr['ID'] : 0;
		if ( ! $post_id || 'rejected' !== get_post_field( 'post_status', $post_id ) ) {
			return $data;
		}

		if ( ! empty( $_POST['hidden_post_status'] ) && 'rejected' === sanitize_key( wp_unslash( $_POST['hidden_post_status'] ) ) ) {
			$data['post_status'] = 'rejected';
		}

		return $data;
	}

	add_filter( 'wp_insert_post_data', 'jw_preserve_petition_hidden_status_on_save', 99, 2 );
}

if ( ! function_exists( 'jw_append_petition_hidden_post_status_quick_edit' ) ) {
	/**
	 * Add "Hidden" to Quick Edit and Bulk Edit status dropdowns on the petitions list.
	 */
	function jw_append_petition_hidden_post_status_quick_edit() {
		global $post_type;

		if ( 'petitions' !== $post_type ) {
			return;
		}

		$label = esc_js( _x( 'Hidden', 'petitions', 'newsreader' ) );
		echo "
<script>
jQuery(function($) {
	$('#inline-edit select[name=\"_status\"], #bulk-edit select[name=\"_status\"]').append(
		$('<option>', { value: 'rejected', text: '{$label}' })
	);
});
</script>
";
	}

	add_action( 'admin_footer-edit.php', 'jw_append_petition_hidden_post_status_quick_edit' );
}

if ( ! function_exists( 'jw_exclude_hidden_petitions_from_archive' ) ) {
	/**
	 * Keep hidden petitions off the archive listing (publish only).
	 */
	function jw_exclude_hidden_petitions_from_archive( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'petitions' ) ) {
			return;
		}

		$query->set( 'post_status', 'publish' );
	}

	add_action( 'pre_get_posts', 'jw_exclude_hidden_petitions_from_archive' );
}
