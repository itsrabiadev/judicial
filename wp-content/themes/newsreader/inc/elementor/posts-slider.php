<?php
namespace ThemeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH'))
    exit;

class CSCO_Posts_Slider extends Widget_Base
{
    public function get_name()
    {
        return 'cs-posts-slider';
    }

    public function get_title()
    {
        return esc_html__('Posts Slider', 'newsreader');
    }

    public function get_icon()
    {
        return 'cs-icon-el-burst_mode';
    }

    public function get_categories()
    {
        return ['theme'];
    }

    protected function _register_controls()
    {
        /* --------------------------
         * POSTS CONTENT
         * -------------------------- */
        $this->start_controls_section('posts_content', [
            'label' => esc_html__('Posts', 'newsreader'),
        ]);

        $this->add_control('post_type', [
            'label' => __('Post Type', 'newsreader'),
            'type' => Controls_Manager::TEXT,
            'default' => 'post',
        ]);

        $this->add_control('number_items', [
            'label' => esc_html__('Number of Posts', 'newsreader'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5,
        ]);

        $this->add_control('order_by', [
            'label' => __('Order By', 'newsreader'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => 'Date',
                'title' => 'Title',
                'rand' => 'Random',
                'menu_order' => 'Menu Order (manual)',
            ],
            'description' => __('Choose "Menu Order (manual)" to sort by a drag-and-drop order plugin (e.g. Simple Custom Post Order). For a one-off hand-picked list, use the Manual Selection field below instead.', 'newsreader'),
        ]);

        $this->add_control('order', [
            'label' => __('Order', 'newsreader'),
            'type' => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'ASC' => 'Ascending',
                'DESC' => 'Descending',
            ],
        ]);

        $this->add_control('manual_order_heading', [
            'label'     => esc_html__('Manual Order', 'newsreader'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $manual_repeater = new Repeater();

        $manual_repeater->add_control('post_id', [
            'label'       => esc_html__('Post', 'newsreader'),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'options'     => $this->get_post_options(),
        ]);

        $this->add_control('manual_posts', [
            'label'       => esc_html__('Manual Selection', 'newsreader'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $manual_repeater->get_controls(),
            'title_field' => 'Post #{{{ post_id }}}',
            'description' => esc_html__('The dropdown lists only posts tagged "home-slider", so the list stays short — tag a post with "home-slider" to make it selectable here. Pick posts in the exact order you want them shown, and drag rows to reorder. When this list has any posts it overrides Order By, Category and Tag above. Leave it empty to use the automatic query.', 'newsreader'),
        ]);

        $this->add_control('filter_category', [
            'label' => __('Filter by Category (slug)', 'newsreader'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
        ]);

        $this->add_control('filter_tag', [
            'label' => __('Filter by Tag (slug)', 'newsreader'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
        ]);

        $this->add_control('show_excerpt', [
            'label' => esc_html__('Display Excerpt', 'newsreader'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control('excerpt_length', [
            'label' => esc_html__('Excerpt Length', 'newsreader'),
            'type' => Controls_Manager::NUMBER,
            'default' => 20,
        ]);

        $this->add_control('title_length', [
            'label' => esc_html__('Heading Length', 'newsreader'),
            'type' => Controls_Manager::NUMBER,
            'default' => 10,
        ]);

        $this->end_controls_section();

        /* --------------------------
         * SLIDER SETTINGS
         * -------------------------- */
        $this->start_controls_section('slider_settings', [
            'label' => esc_html__('Slider', 'newsreader'),
        ]);

        $this->add_control('slides_per_view', [
            'label' => esc_html__('Slides per View', 'newsreader'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
        ]);

        $this->add_control('autoplay', [
            'label' => esc_html__('Autoplay', 'newsreader'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('autoplay_delay', [
            'label' => esc_html__('Autoplay Delay (ms)', 'newsreader'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5000,
        ]);

        $this->add_control('slide_speed', [
            'label' => esc_html__('Slide Speed (ms)', 'newsreader'),
            'type' => Controls_Manager::NUMBER,
            'default' => 800,
        ]);

        $this->add_control('show_arrows', [
            'label' => esc_html__('Show Arrows', 'newsreader'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Prev / next arrows overlaid on the left and right edges of the card.', 'newsreader'),
        ]);

        $this->add_control('show_counter', [
            'label' => esc_html__('Show Slide Counter', 'newsreader'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Small "1 / 3" badge in the top-right corner so visitors know there is more than one slide.', 'newsreader'),
        ]);

        $this->add_control('show_progress_bar', [
            'label' => esc_html__('Show Autoplay Countdown Bar', 'newsreader'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Thin bar across the top of the card that fills as each slide counts down. Only shows when Autoplay is on.', 'newsreader'),
        ]);

        $this->add_control('progress_bar_color', [
            'label' => esc_html__('Countdown Bar Color', 'newsreader'),
            'type' => Controls_Manager::COLOR,
            'default' => '#cc0100', // Judicial Watch brand red (matches in-card category links)
            'condition' => [ 'show_progress_bar' => 'yes' ],
        ]);

        $this->end_controls_section();

        /* --------------------------
         * STYLE SECTION
         * -------------------------- */
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Style', 'newsreader'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => esc_html__('Title Color', 'newsreader'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cs-entry__title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('excerpt_color', [
            'label' => esc_html__('Excerpt Color', 'newsreader'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cs-entry__excerpt' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('text_alignment', [
            'label' => esc_html__('Text Alignment', 'newsreader'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center' => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'right' => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
            ],
            'default' => 'center',
        ]);

        $this->add_control(
            'show_category',
            [
                'label' => esc_html__('Show Category', 'newsreader'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Show Date', 'newsreader'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control('slides_gap', [
    'label' => esc_html__('Gap Between Slides (px)', 'newsreader'),
    'type' => Controls_Manager::NUMBER,
    'default' => 20,
]);
$this->add_control('thumbnail_size', [
    'label' => __('Thumbnail Size', 'newsreader'),
    'type' => Controls_Manager::SELECT,
    'default' => 'large',
    'options' => [
        'thumbnail' => 'Thumbnail (150x150)',
        'medium' => 'Medium',
        'large' => 'Large',
        'full' => 'Full',
    ],
]);
$this->add_control('thumbnail_height', [
    'label' => __('Thumbnail Height (px)', 'newsreader'),
    'type' => Controls_Manager::NUMBER,
    'default' => 300,
    'description' => 'Set the height of the post thumbnail images.',
]);
$this->add_control('slides_per_view_tablet', [
    'label' => __('Slides per View (Tablet)', 'newsreader'),
    'type' => Controls_Manager::NUMBER,
    'default' => 3,
]);

$this->add_control('slides_per_view_mobile', [
    'label' => __('Slides per View (Mobile)', 'newsreader'),
    'type' => Controls_Manager::NUMBER,
    'default' => 1,
]);





        $this->end_controls_section();
    }

    /**
     * Build the list of posts shown in the Manual Selection picker.
     *
     * Runs only in the editor / admin, so it never adds a query on normal
     * front-end page loads (the saved IDs render fine without this list).
     *
     * @return array [ post_id => "Title (#ID)" ]
     */
    private function get_post_options()
    {
        $is_editor = false;
        if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->editor ) ) {
            $is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
        }

        if ( ! is_admin() && ! $is_editor && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            return [];
        }

        /*
         * The picker is scoped to a single tag, so the list stays extremely short:
         * only posts carrying this tag are candidates for manual selection. To make
         * a post appear in the picker, give it this tag. Change the slug below (or
         * override via the 'csco_posts_slider_picker_tag' filter) if a slider ever
         * uses a different tag.
         */
        $picker_tag = apply_filters( 'csco_posts_slider_picker_tag', 'home-slider' );

        $options = array();

        $query = new \WP_Query(
            array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'tag'                 => $picker_tag,
                'posts_per_page'      => 200,
                'orderby'             => 'date',
                'order'               => 'DESC',
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
                'suppress_filters'    => true,
            )
        );

        foreach ( $query->posts as $p ) {
            $options[ $p->ID ] = $p->post_title . ' (#' . $p->ID . ')';
        }

        wp_reset_postdata();

        return $options;
    }

    /* --------------------------------------
     * RENDER WIDGET OUTPUT
     * -------------------------------------- */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $uid = 'cs-posts-slider-' . $this->get_id();

        // Collect any hand-picked posts from the Manual Selection repeater.
        $manual_ids = array();
        if ( ! empty( $settings['manual_posts'] ) && is_array( $settings['manual_posts'] ) ) {
            foreach ( $settings['manual_posts'] as $row ) {
                if ( ! empty( $row['post_id'] ) ) {
                    $manual_ids[] = (int) $row['post_id'];
                }
            }
        }

        if ( ! empty( $manual_ids ) ) {
            // Manual selection wins: show exactly these posts, in this exact order.
            $args = array(
                'post_type'           => 'any',
                'post_status'         => 'publish',
                'post__in'            => $manual_ids,
                'orderby'             => 'post__in',
                'posts_per_page'      => count( $manual_ids ),
                'ignore_sticky_posts' => true,
            );
        } else {
            // Automatic query (original behavior).
            $args = [
                'post_type' => $settings['post_type'],
                'posts_per_page' => $settings['number_items'],
                'orderby' => $settings['order_by'],
                'order' => $settings['order'],
            ];

            if (!empty($settings['filter_category'])) {
                $args['category_name'] = $settings['filter_category'];
            }
            if (!empty($settings['filter_tag'])) {
                $args['tag'] = $settings['filter_tag'];
            }
        }

        $query = new \WP_Query($args);

        if ($query->have_posts()):
        
            $height='auto';
        if($settings['slides_per_view']!=1){
            $height=esc_attr($settings['thumbnail_height']).'px';
        }
        ?>

            <div id="<?php echo esc_attr($uid); ?>" class="cs-posts-slider-wrapper swiper"
                data-slides-per-view="<?php echo esc_attr($settings['slides_per_view']); ?>"
                data-slides-per-view-tablet="<?php echo esc_attr($settings['slides_per_view_tablet']); ?>"
    data-slides-per-view-mobile="<?php echo esc_attr($settings['slides_per_view_mobile']); ?>"
                data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>"
                data-autoplay-delay="<?php echo esc_attr($settings['autoplay_delay']); ?>"
                data-slide-speed="<?php echo esc_attr($settings['slide_speed']); ?>"
                data-slides-gap="<?php echo esc_attr($settings['slides_gap']); ?>"
                data-post-count="<?php echo esc_attr($query->post_count); ?>">

                <div class="swiper-wrapper">

                    <?php
                    $total_slides = (int) $query->post_count;
                    $slide_index  = 0;
                    while ($query->have_posts()):
                        $query->the_post();
                        $slide_index++;
                        ?>
                        <div class="swiper-slide">
                            <div class="cs-slide-item" style="text-align: <?php echo esc_attr($settings['text_alignment']); ?>">

                                <?php if ($settings['show_progress_bar'] === 'yes' && $settings['autoplay'] === 'yes'): ?>
                                    <div class="cs-slider-progress"><span class="cs-slider-progress__bar"></span></div>
                                <?php endif; ?>

                                <?php if ($settings['show_counter'] === 'yes'): ?>
                                    <div class="cs-slider-counter"><?php echo esc_html($slide_index . ' / ' . $total_slides); ?></div>
                                <?php endif; ?>

                                <?php if (has_post_thumbnail()): ?>
                                     <a href="<?= get_the_permalink(get_the_ID())?>">
                                    <div class="cs-overlay-background">
                                       
                                   <?php the_post_thumbnail($settings['thumbnail_size'],['style' => 'height:'.$height]); ?>

                                    </div>
                                    </a>
                                <?php endif; ?>
 <?php if ($settings['show_category'] === 'yes'): ?>
                                <div class="cs-entry__post-meta">
                                    <div class="cs-meta-category">
                                        <ul class="post-categories">
                                            <?php
                                            $cat = get_the_category();
                                            if (!empty($cat)) { ?>
                                                <li><a href="<?= get_the_permalink($cat[0]->ID); ?>"
                                                        rel="category tag"><?= esc_html($cat[0]->name); ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <h2 class="cs-entry__title">
                                   <a href="<?= get_the_permalink(get_the_ID())?>"> <?php echo wp_trim_words(get_the_title(), $settings['title_length'], '...'); ?></a>
                                </h3>

                                <?php if ($settings['show_excerpt'] === 'yes'):
                                    $content = csco_get_the_excerpt($settings['excerpt_length']);
                                    ?>
                                    <div class="cs-entry__excerpt">
                                        <?php echo esc_html($content); ?>
                                </div>
                                <?php endif; ?>
                                 <?php if ($settings['show_date'] === 'yes'): ?>
                                <div class="cs-entry__post-meta">
                                    <div class="cs-meta-date"><?php echo esc_html(get_the_date()); ?></div>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>

                <?php if ($settings['show_arrows'] === 'yes'): ?>
                <!-- Swiper Navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <?php endif; ?>
            </div>

            <style>
                /* Slide Wrapper Background */
                #<?php echo $uid; ?> .cs-slide-item {
                    background-color: #ffffff;
                    position: relative; /* anchor for overlay cues; does not affect the card's look */
                }

                /* Autoplay countdown bar — sits on the very top edge of the card */
                #<?php echo esc_attr($uid); ?> .cs-slider-progress {
                    position: absolute;
                    top: 0; left: 0; right: 0;
                    height: 4px;
                    background: rgba(0, 0, 0, .12);
                    z-index: 8;
                    pointer-events: none;
                }
                #<?php echo esc_attr($uid); ?> .cs-slider-progress__bar {
                    display: block;
                    height: 100%;
                    width: 0;
                    background: <?php echo esc_attr($settings['progress_bar_color']); ?>;
                    transition: width 120ms linear;
                }

                /* Slide counter — badge in the top-right corner of the card */
                #<?php echo esc_attr($uid); ?> .cs-slider-counter {
                    position: absolute;
                    top: 12px; right: 12px;
                    z-index: 9;
                    background: rgba(6, 20, 40, .72);
                    color: #ffffff;
                    font-size: 12px;
                    font-weight: 700;
                    letter-spacing: .06em;
                    line-height: 1;
                    padding: 5px 10px;
                    border-radius: 999px;
                    pointer-events: none;
                }

                /* Default (mobile first) */
    #<?php echo $uid; ?> .cs-overlay-background img {
        width: 100%;
        height: auto;
        object-fit: contain; /* Mobile uses contain */
        display: block;
    }

    /* Tablet (768px and up) */
    @media (min-width: 768px) {
        #<?php echo $uid; ?> .cs-overlay-background img {
            object-fit: contain; /* Tablet also contain */
        }
    }

    /* Desktop (1024px and up) */
    @media (min-width: 1024px) {
        #<?php echo $uid; ?> .cs-overlay-background img {
            object-fit: contain; /* Desktop uses cover */
        }
    }

                /* Custom Title & Excerpt Colors */
                #<?php echo $uid; ?> .cs-entry__title {
                    color:
                        <?php echo esc_attr($settings['title_color']); ?>
                    ;
                    padding-left: 10px;
                    padding-top: 10px;
                }

                #<?php echo $uid; ?> .cs-entry__excerpt {
                    color:
                        <?php echo esc_attr($settings['excerpt_color']); ?>
                    ;
                    padding-left: 10px;
                    padding-bottom:5px;
                }
                 #<?php echo $uid; ?> .cs-meta-category {
                    padding-left: 10px;
                }
                  #<?php echo $uid; ?> .cs-meta-date {
                    padding-left: 10px;
                }

                /* Navigation arrows — always visible, circular, inside the card edges */
                #<?php echo esc_attr($uid); ?> .swiper-button-next,
                #<?php echo esc_attr($uid); ?> .swiper-button-prev {
                    width: 44px;
                    height: 44px;
                    margin-top: -22px;
                    border-radius: 50%;
                    background: rgba(6, 20, 40, .62);
                    transition: background 150ms ease, transform 150ms ease;
                    z-index: 10;
                }
                #<?php echo esc_attr($uid); ?> .swiper-button-prev { left: 12px; }
                #<?php echo esc_attr($uid); ?> .swiper-button-next { right: 12px; }

                #<?php echo esc_attr($uid); ?> .swiper-button-next:hover,
                #<?php echo esc_attr($uid); ?> .swiper-button-prev:hover {
                    background: #cc0100; /* brand red on hover */
                    transform: scale(1.06);
                }

                #<?php echo esc_attr($uid); ?> .swiper-button-prev::after { content: "\276E"; } /* ❮ */
                #<?php echo esc_attr($uid); ?> .swiper-button-next::after { content: "\276F"; } /* ❯ */

                #<?php echo esc_attr($uid); ?> .swiper-button-next::after,
                #<?php echo esc_attr($uid); ?> .swiper-button-prev::after {
                    font-size: 18px;
                    font-weight: 700;
                    color: #ffffff;
                }
            </style>

            <script>
                jQuery(function ($) {
                    const slider = document.querySelector('#<?php echo $uid; ?>');
                    const postCount = Number(slider.dataset.postCount);
                    const slidesPerView = Number(slider.dataset.slidesPerView) || 1;
                    const enableLoop = postCount >= slidesPerView * 2;
                    new Swiper(slider, {
                        loop: enableLoop,
                        speed: Number(slider.dataset.slideSpeed),
                        spaceBetween: Number(slider.dataset.slidesGap),
                        autoplay: slider.dataset.autoplay === 'yes' ? {
                            delay: Number(slider.dataset.autoplayDelay),
                            disableOnInteraction: false,
                        } : false,
                        navigation: {
                            nextEl: '#<?php echo $uid; ?> .swiper-button-next',
                            prevEl: '#<?php echo $uid; ?> .swiper-button-prev'
                        },
                        on: {
                            autoplayTimeLeft: function (s, time, progress) {
                                slider.querySelectorAll('.cs-slider-progress__bar').forEach(function (bar) {
                                    bar.style.width = ((1 - progress) * 100) + '%';
                                });
                            },
                            slideChangeTransitionStart: function () {
                                slider.querySelectorAll('.cs-slider-progress__bar').forEach(function (bar) {
                                    bar.style.width = '0%';
                                });
                            }
                        },
                        breakpoints: {
                            0: {
                                slidesPerView: Number(slider.dataset.slidesPerViewMobile)
                            },
                            768: {
                                slidesPerView: Number(slider.dataset.slidesPerViewTablet)
                            },
                            1024: {
                                slidesPerView: Number(slider.dataset.slidesPerView)
                            }
                        }
                    });
                });
            </script>

        <?php else:
            echo '<p>No posts found.</p>';
        endif;
    }
}
