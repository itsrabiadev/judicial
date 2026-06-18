<?php
/**
 * Strict front-end search: require all terms (AND semantics).
 *
 * The site uses standard WordPress ?s= search. WP Engine Smart Search (AI Toolkit)
 * intercepts those queries and treats whitespace-separated terms as OR by default.
 * This module rewrites multi-word queries to explicit AND syntax server-side only,
 * without changing Smart Search weighting, indexed post types, or plugin core files.
 *
 * PRIMARY STRATEGY (always on):
 *   Rewrite "watson lawsuit" -> "watson AND lawsuit" before Smart Search sees it,
 *   relying on Smart Search's native boolean AND support.
 *
 * FALLBACK STRATEGY (opt-in via constant):
 *   If Smart Search does NOT honor the injected AND operator (possible with
 *   semantic/hybrid modes), enable the post-results filter to drop any returned
 *   post that does not contain ALL terms across title + excerpt + content.
 *   Enable by adding to wp-config.php:  define( 'JW_SMART_SEARCH_AND_FALLBACK', true );
 *
 * @package Newsreader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Minimum length for a term to be treated as a required AND term.
 * Prevents single stray characters from forcing absurd constraints.
 */
if ( ! defined( 'JW_SMART_SEARCH_MIN_TERM_LEN' ) ) {
	define( 'JW_SMART_SEARCH_MIN_TERM_LEN', 2 );
}

/**
 * Original user-entered search text for display (search box, headings, SEO title).
 *
 * @var string|null
 */
$jw_search_display_query = null;

/**
 * The normalized term list for the current strict search (used by fallback filter).
 *
 * @var string[]
 */
$jw_search_active_terms = array();

/**
 * Whether strict AND search rules should apply to this query.
 *
 * @param WP_Query $query Query instance.
 * @return bool
 */
function jw_smart_search_should_apply( $query ) {
	if ( is_admin() || ! $query->is_search() ) {
		return false;
	}

	/**
	 * Limit to the primary front-end search request by default.
	 *
	 * @param bool     $apply Whether to apply strict search rules.
	 * @param WP_Query $query Current query.
	 */
	return (bool) apply_filters( 'jw_smart_search_apply_and_operator', $query->is_main_query(), $query );
}

/**
 * Whether the search string already contains Smart Search boolean operators.
 *
 * @param string $search_query Raw search string.
 * @return bool
 */
function jw_smart_search_has_boolean_operators( $search_query ) {
	if ( preg_match( '/\b(AND|OR|NOT)\b/i', $search_query ) ) {
		return true;
	}

	// Simple Query String required/excluded term prefixes and OR pipe.
	if ( preg_match( '/(?:^|\s)[+\-|]/', $search_query ) ) {
		return true;
	}

	return false;
}

/**
 * Split a search string into terms, preserving quoted phrases.
 *
 * @param string $search_query Raw search string.
 * @return string[]
 */
function jw_smart_search_parse_terms( $search_query ) {
	$terms = array();

	if ( ! preg_match_all( '/"([^"]+)"|(\S+)/', $search_query, $matches, PREG_SET_ORDER ) ) {
		return $terms;
	}

	foreach ( $matches as $match ) {
		$term = '' !== $match[1] ? $match[1] : $match[2];
		$term = trim( wp_strip_all_tags( $term ) );

		if ( '' !== $term ) {
			$terms[] = $term;
		}
	}

	return $terms;
}

/**
 * Normalize parsed terms: strip tags, trim, drop too-short terms, de-duplicate.
 *
 * @param string[] $terms Parsed search terms.
 * @return string[]
 */
function jw_smart_search_normalize_terms( array $terms ) {
	$normalized = array();
	$seen       = array();

	foreach ( $terms as $term ) {
		$term = trim( wp_strip_all_tags( (string) $term ) );

		if ( '' === $term ) {
			continue;
		}

		// Skip terms below the minimum length (multibyte-safe).
		if ( function_exists( 'mb_strlen' ) ) {
			if ( mb_strlen( $term ) < JW_SMART_SEARCH_MIN_TERM_LEN ) {
				continue;
			}
		} elseif ( strlen( $term ) < JW_SMART_SEARCH_MIN_TERM_LEN ) {
			continue;
		}

		// De-duplicate case-insensitively while preserving first-seen casing.
		$key = function_exists( 'mb_strtolower' ) ? mb_strtolower( $term ) : strtolower( $term );
		if ( isset( $seen[ $key ] ) ) {
			continue;
		}
		$seen[ $key ] = true;

		$normalized[] = $term;
	}

	return $normalized;
}

/**
 * Rewrite multi-word searches to explicit AND syntax for Smart Search.
 *
 * @param WP_Query $query Query instance.
 */
function jw_smart_search_apply_and_operator( $query ) {
	if ( ! jw_smart_search_should_apply( $query ) ) {
		return;
	}

	$search = $query->get( 's' );

	if ( ! is_string( $search ) || '' === trim( $search ) ) {
		return;
	}

	// Leave quoted searches and explicit boolean queries untouched.
	if ( preg_match( '/["\']/', $search ) || jw_smart_search_has_boolean_operators( $search ) ) {
		return;
	}

	$terms = jw_smart_search_normalize_terms( jw_smart_search_parse_terms( $search ) );

	if ( count( $terms ) < 2 ) {
		return;
	}

	global $jw_search_display_query, $jw_search_active_terms;
	$jw_search_display_query = trim( $search );
	$jw_search_active_terms  = $terms;

	$rewritten = implode( ' AND ', $terms );
	$query->set( 's', $rewritten );

	// Diagnostic logging so the STAG test can confirm the rewrite fired.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log(
			sprintf(
				'[JW Smart Search] original="%s" rewritten="%s" terms=[%s]',
				$jw_search_display_query,
				$rewritten,
				implode( ', ', $terms )
			)
		);
	}
}
add_action( 'pre_get_posts', 'jw_smart_search_apply_and_operator', 5 );

/**
 * Keep the search box and headings showing the user's original text.
 *
 * @param string $query Current search query value.
 * @return string
 */
function jw_smart_search_restore_display_query( $query ) {
	global $jw_search_display_query;

	if ( ! empty( $jw_search_display_query ) ) {
		return $jw_search_display_query;
	}

	return $query;
}
add_filter( 'get_search_query', 'jw_smart_search_restore_display_query' );

/**
 * FALLBACK: enforce AND at the result level if Smart Search ignores the operator.
 *
 * Only runs when JW_SMART_SEARCH_AND_FALLBACK is defined and true. Drops any
 * returned post that does not contain every active term somewhere in its
 * title, excerpt, or content. This is a safety net for the case where the
 * engine does not treat the injected AND as a strict filter.
 *
 * NOTE: This filters the already-returned result set. It will reduce the
 * displayed count and can interact with pagination, so it is OFF by default.
 * Use it only if the primary AND-injection test shows OR-style leakage.
 *
 * @param WP_Post[] $posts Posts returned for the query.
 * @param WP_Query  $query Query instance.
 * @return WP_Post[]
 */
function jw_smart_search_enforce_and_fallback( $posts, $query ) {
	if ( ! defined( 'JW_SMART_SEARCH_AND_FALLBACK' ) || ! JW_SMART_SEARCH_AND_FALLBACK ) {
		return $posts;
	}

	if ( is_admin() || empty( $posts ) || ! $query->is_search() || ! $query->is_main_query() ) {
		return $posts;
	}

	global $jw_search_active_terms;

	if ( empty( $jw_search_active_terms ) || count( $jw_search_active_terms ) < 2 ) {
		return $posts;
	}

	$filtered = array();

	foreach ( $posts as $post ) {
		$haystack = strtolower(
			wp_strip_all_tags(
				(string) $post->post_title . ' ' .
				(string) $post->post_excerpt . ' ' .
				(string) $post->post_content
			)
		);

		$has_all = true;

		foreach ( $jw_search_active_terms as $term ) {
			$needle = strtolower( $term );

			if ( false === strpos( $haystack, $needle ) ) {
				$has_all = false;
				break;
			}
		}

		if ( $has_all ) {
			$filtered[] = $post;
		}
	}

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log(
			sprintf(
				'[JW Smart Search] fallback filter: %d -> %d posts (terms=[%s])',
				count( $posts ),
				count( $filtered ),
				implode( ', ', $jw_search_active_terms )
			)
		);
	}

	return $filtered;
}
add_filter( 'posts_results', 'jw_smart_search_enforce_and_fallback', 10, 2 );