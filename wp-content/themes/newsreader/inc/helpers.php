<?php
function get_staff_data($repeater_field, $sub_field, $post_id = null) {
    $items = get_field($repeater_field, $post_id);
    if (empty($items) || !is_array($items)) {
        return [];
    }

    $staff = [];
    foreach ($items as $item) {
        $staff_post = $item[$sub_field] ?? null;
        if (!$staff_post || !is_object($staff_post)) {
            continue;
        }

        $staff[] = (object) [
            'ID'         => $staff_post->ID,
            'title'      => get_the_title($staff_post->ID),
            'team_title' => get_field('team_title', $staff_post->ID),
            'content'    => apply_filters('the_content', $staff_post->post_content),
            'thumbnail'  => get_the_post_thumbnail_url($staff_post->ID, 'thumbnail'),
        ];
    }

    return $staff;
}

// Helper: careers fetcher
function get_career_data( $order_field, $post_id ) {
    $items = get_field( $order_field, $post_id );
    if ( empty( $items ) || ! is_array( $items ) ) {
        return [];
    }

    $careers = [];
    foreach ( $items as $item ) {
        $career_post = $item['career'] ?? null;
        if ( ! $career_post ) {
            continue;
        }

        $careers[] = (object) [
            'ID'         => $career_post->ID,
            'title'      => get_the_title( $career_post->ID ),
            'department' => get_field( 'department', $career_post->ID ),
            'reports_to' => get_field( 'reports_to', $career_post->ID ),
            'status'     => get_field( 'status', $career_post->ID ),
            'summary'    => get_field( 'summary', $career_post->ID ),
            'content'    => apply_filters( 'the_content', $career_post->post_content ),
        ];
    }
    return $careers;
}

function dumpdie($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die;
}
function getRelatedDocument( $post_id ) {
    $relatedPosts = get_field( 'related_documents', $post_id );
    if ( empty( $relatedPosts ) ) {
        return null;
    }

    $docs = [];
    foreach ( $relatedPosts as $post ) {
        $doc = new \stdClass();
        $doc->postId = $post->ID;
        $doc->title  = get_the_title( $post->ID );
        $doc->link   = get_permalink( $post->ID );
        $doc->date   = get_the_date( '', $post->ID );

        // Thumbnail
        $thumb = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
        $doc->thumbnail = $thumb ? $thumb : null;

        // Category
        $categories = wp_get_post_terms( $post->ID, 'document_categories' );
        if ( ! empty( $categories ) ) {
            $doc->category = [
                'name' => $categories[0]->name,
                'link' => get_term_link( $categories[0] ),
            ];
        }

        // Tags
        $tags = wp_get_post_terms( $post->ID, 'document_tags' );
        if ( ! empty( $tags ) ) {
            $doc->tags = [];
            foreach ( $tags as $tag ) {
                $doc->tags[] = [
                    'name' => $tag->name,
                    'link' => get_term_link( $tag ),
                ];
            }
        }

        $docs[] = $doc;
    }

    return $docs;
}


function getFeaturedDoc($post_id)
{
    $featuredPost = get_field('case_document', $post_id);

    $featuredDocument = null;
    if ( $featuredPost instanceof WP_Post ) {
        $featuredDocument = new \stdClass();
        $featuredDocument->postId = $featuredPost->ID;
        $featuredDocument->title  = get_the_title( $featuredPost->ID );
        $featuredDocument->link   = get_permalink( $featuredPost->ID );
        $featuredDocument->date   = get_the_date( '', $featuredPost->ID );

        // Category
        $categories = wp_get_post_terms( $featuredPost->ID, 'document_categories' );
        if ( ! empty( $categories ) ) {
            $featuredDocument->category = [
                'name' => $categories[0]->name,
                'link' => get_term_link( $categories[0] )
            ];
        }

        // Tags
        $tags = wp_get_post_terms( $featuredPost->ID, 'document_tags' );
        if ( ! empty( $tags ) ) {
            $featuredDocument->tags = [];
            foreach ( $tags as $tag ) {
                $featuredDocument->tags[] = [
                    'name' => $tag->name,
                    'link' => get_term_link( $tag )
                ];
            }
        }

        // Attachment (from ACF field)
        $attachment = get_field('attachment', $featuredPost->ID);
        if ( $attachment ) {
            $featuredDocument->attachment_url = $attachment['url'];
        }
    }
    return $featuredDocument;
}

function getRelatedCases( $post_id ) {
    $relatedPosts = get_field( 'related_cases', $post_id );

    if ( empty( $relatedPosts ) ) {
        return null;
    }

    $cases = [];
    foreach ( $relatedPosts as $post ) {
        $case = new \stdClass();
        $case->postId = $post->ID;
        $case->title  = get_the_title( $post->ID );
        $case->link   = get_permalink( $post->ID );
        $case->date   = get_the_date( '', $post->ID );

        // Thumbnail
        $thumb = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
        $case->thumbnail = $thumb ? $thumb : null;

        // Categories (document_categories taxonomy)
        $categories = wp_get_post_terms( $post->ID, 'document_categories' );
        if ( ! empty( $categories ) ) {
            $case->category = [
                'name' => $categories[0]->name,
                'link' => get_term_link( $categories[0] ),
            ];
        }

        // Tags (optional – if you need them)
        $tags = wp_get_post_terms( $post->ID, 'document_tags' );
        if ( ! empty( $tags ) ) {
            $case->tags = [];
            foreach ( $tags as $tag ) {
                $case->tags[] = [
                    'name' => $tag->name,
                    'link' => get_term_link( $tag ),
                ];
            }
        }

        $cases[] = $case;
    }

    return $cases;
}
function newsreader_get_related_posts( $postId, $acfKeys, $limit = 3 ) {
	$posts = [];

	foreach ( $acfKeys as $acfKey ) {
		$acfObject = get_field_object( $acfKey, $postId );
		if ( $acfObject && $acfObject["type"] === "relationship" ) {

			// posts already chosen in ACF
			$chosen = get_field( $acfKey, $postId );
			if ( ! is_array( $chosen ) ) {
				$chosen = [];
			}

			// pad choices if fewer than limit
			$choices = $limit - count( $chosen );
			if ( $choices > 0 ) {
				$args = array(
					'post_type'           => 'post',
					'post__not_in'        => array_merge( array( $postId ), wp_list_pluck( $chosen, 'ID' ) ),
					'posts_per_page'      => $choices,
					'orderby'             => 'date',
					'ignore_sticky_posts' => true,
				);
				$newChoices = get_posts( $args );
				$chosen     = array_merge( $chosen, $newChoices );
			}

			$posts[ $acfObject["name"] ] = $chosen;
		}
	}

	if ( count( $posts ) === 1 ) {
		$posts = array_shift( $posts );
	}

	if ( is_array( $posts ) && ! empty( $posts ) ) {
		usort(
			$posts,
			function ( $a, $b ) {
				return strtotime( $b->post_date ) - strtotime( $a->post_date );
			}
		);
	}

	return $posts;
}
