<?php

require_once get_template_directory() . '/inc/JWPost.php'; // adjust path

class MainMenuManager {

    public function get_main_menu_items_array() {
        // Load the designated menu by name
        $menu = wp_get_nav_menu_object('Main Menu');
        if (!$menu) {
            return [];
        }

        $items = wp_get_nav_menu_items($menu->term_id);
        if (empty($items)) {
            return [];
        }

        $result = [];
        foreach ($items as $item) {
            if ((int) $item->menu_item_parent !== 0) {
                continue; // only top-level items
            }

            $layout = get_field('submenu_layout', $item->ID);
            $submenuExists = !empty($layout) && $layout !== 'none';

            $menuEntry = [
                'id'             => $item->ID,
                'title'          => $item->title,
                'url'            => ($item->type === 'custom' ? $item->url : get_permalink($item->object_id)),
                'submenuExists'  => $submenuExists,
                'submenu'        => []
            ];

            if ($submenuExists) {
                $menuEntry['submenu'] = $this->build_submenu($item->ID, $layout);
            }

            $result[] = $menuEntry;
        }

        return array_map(function($menuEntry) {
            return json_decode(json_encode($menuEntry), true);
        }, $result);

    }

    protected function build_submenu($itemId, $layout) {
        $submenu = ['layout' => $layout];

        if ($layout === 'submenu_links') {
            $submenu['posts'] = $this->build_submenu_links($itemId);
        }
        elseif ($layout === 'submenu_tabs') {
            $submenu['tabs'] = $this->build_submenu_tabs($itemId);
        }

        return $submenu;
    }

    protected function build_submenu_links($itemId) {
        $links = get_field('submenu_layout_links', $itemId) ?: [];
        $out = [];

        foreach ($links as $link) {
            $url = $link['link']['url'] ?? null;
            if (!$url) {
                continue;
            }

            $post_id = url_to_postid($url);
            if ($post_id) {
                $postObj = new JWPost(get_post($post_id), true);
                if (!empty($link['link']['title'])) {
                    $postObj->title = $link['link']['title'];
                }
                $postObj->link = $url;
                if (!empty($link['image']['url'])) {
                    $postObj->thumbnails = [
                        'medium_large' => ['src' => $link['image']['url']]
                    ];
                }
                $out[] = $postObj;
            } else {
                $out[] = (object)[
                    'title'      => $link['link']['title'] ?? '',
                    'url'        => $url,
                    'target'     => $link['link']['target'] ?? '',
                    'thumbnails' => ['medium_large' => ['src' => $link['image']['url'] ?? '']],
                ];
            }
        }

        return $out;
    }

    protected function build_submenu_tabs($itemId) {
        $tabs = get_field('submenu_layout_tabs', $itemId) ?: [];
        $out = [];

        foreach ($tabs as $tab) {
            $type = $tab['submenu_layout_tabs_type'] ?? '';
            if ($type === 'submenu_layout_tabs_categories') {
                foreach ((array) ($tab['submenu_layout_tabs_categories'] ?? []) as $term) {
                    $termObj = get_term($term);
                    if (!$termObj) {
                        continue;
                    }
                    $posts = get_posts([
                        'numberposts' => 7,
                        'post_type' => get_taxonomy($termObj->taxonomy)->object_type,
                        'tax_query' => [[
                            'taxonomy' => $termObj->taxonomy,
                            'field' => 'term_id',
                            'terms' => $termObj->term_id,
                            'include_children' => false
                        ]]
                    ]);
                    $jwposts = array_map(fn($p) => new JWPost($p), $posts);
                    $out[] = (object)[
                        'title'       => $termObj->name,
                        'categoryUrl' => get_term_link($termObj),
                        'posts'       => $jwposts
                    ];
                }
            }
            elseif ($type === 'submenu_layout_tabs_posts') {
                $title = $tab['tab_title'] ?? '';
                $curated = (array) ($tab['submenu_layout_tabs_curated'] ?? []);
                $jwposts = array_map(fn($p) => new JWPost(get_post($p)), $curated);
                $out[] = (object)[
                    'title' => $title,
                    'posts' => $jwposts
                ];
            }
            elseif ($type === 'submenu_layout_tabs_link') {
                $link = $tab['submenu_layout_tabs_links'] ?? [];
                $url   = $link['url'] ?? '';
                if (!$url) continue;
                $post_id = url_to_postid($url);
                $title = $link['title'] ?: ($post_id ? get_the_title($post_id) : '');
                $out[] = (object)[ 'title' => $title, 'url' => $url ];
            }
        }

        return $out;
    }
}
