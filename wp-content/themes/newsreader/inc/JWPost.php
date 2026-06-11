<?php

class JWPost {
    public $postId = 0;
    public $category = [];
    public $thumbnails = [];
    public $title = '';
    public $slug = '';
    public $date = '';
    public $icon = '';
    public $type = '';
    public $episodeId = '';
    public $link = '';
    public $videoid = '';
    public $excerpt = '';
    public $content = '';
    public $source = [];

    public function __construct(WP_Post $post, bool $withContent = false) {
        $this->postId     = $post->ID;
        $this->slug       = $post->post_name;
        $this->date       = $post->post_date;
        $this->type       = $post->post_type;
        $this->title      = $post->post_title;
        $this->link       = get_permalink($post->ID);
        $this->videoid    = get_field("video_id", $post->ID);
        $this->source     = $this->getTheSource($post->ID);
        $this->category   = $this->getTheCategory($post->ID);
        $this->thumbnails = $this->getTheThumbnails($post->ID);
        $this->icon       = $this->getTheIcon($post->post_type);

        if ($withContent) {
            $this->content = apply_filters('the_content', $post->post_content);
        } else {
            $this->excerpt = get_the_excerpt($post);
        }

        if ($this->postId > 0) {
            if ($this->type === "video") {
                $this->videoid = get_field("video_id", $this->postId);
            } elseif ($this->type === "podcast") {
                $this->episodeId = get_field("buzzsprout_episode_id", $this->postId);
            }
        }
    }

    protected function getTheCategory(int $postId): array {
        $categories = get_the_category($postId);
        $category = ['link' => '', 'name' => '', 'id' => ''];

        if (!empty($categories)) {
            $theCategory = array_shift($categories);
            $category = [
                'link'       => get_term_link($theCategory),
                'name'       => $theCategory->name,
                'slug'       => $theCategory->slug,
                'id'         => $theCategory->term_taxonomy_id,
                'iconColor'  => get_field('icon_color', $theCategory)
            ];
        }

        return $category;
    }

    protected function getTheThumbnails(int $postId): array {
        $thumbnailId = get_post_thumbnail_id($postId);
        $thumbnails = [];

        if ($thumbnailId) {
            foreach (get_intermediate_image_sizes() as $size) {
                $image = wp_get_attachment_image_src($thumbnailId, $size);
                if ($image) {
                    $thumbnails[$size] = [
                        'src' => $image[0],
                        'width' => $image[1],
                        'height' => $image[2],
                    ];
                }
            }
        }

        return $thumbnails;
    }

    protected function getTheSource(int $postId): array {
        $link = get_field("article_source", $postId);
        $name = get_field("article_outlet", $postId);

        return [
            "name" => !empty($name) ? $name : "Judicial Watch",
            "link" => !empty($link) ? $link : "",
        ];
    }

    protected function getTheIcon(string $postType): string {
        return $postType === "video"
            ? "fab fa-youtube"
            : ($postType === "podcast" ? "fas fa-microphone" : "fas fa-newspaper");
    }
}
