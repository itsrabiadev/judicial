<?php
/**
 * ACF Global Options Fetcher
 * Gathers grouped ACF options fields into arrays.
 */

if (!defined('ABSPATH')) exit;

if (!function_exists('get_field')) return;
function get_social_media_settings() {
    return [
        'facebook' => get_field('facebook', 'option') ?: '',
        'twitter' => get_field('twitter', 'option') ?: '',
        'youtube' => get_field('youtube', 'option') ?: '',
        'instagram' => get_field('instagram', 'option') ?: '',
        'truth' => get_field('truth', 'option') ?: '',
        'youtube_playlists_to_sync' => get_field('youtube_playlists_to_sync', 'option') ?: '',
    ];
}


function get_top_header_link() {
    return array_filter([
        'top_header_text' => get_field('top_header_text', 'option'),
        'top_header_link' => get_field('top_header_link', 'option'),
    ]) ?: null;
}




