<?php
namespace ThemeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

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
            ],
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

    /* --------------------------------------
     * RENDER WIDGET OUTPUT
     * -------------------------------------- */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $uid = 'cs-posts-slider-' . $this->get_id();

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

                    <?php while ($query->have_posts()):
                        $query->the_post();
                        
                        ?>
                        <div class="swiper-slide">
                            <div class="cs-slide-item" style="text-align: <?php echo esc_attr($settings['text_alignment']); ?>">

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

                <!-- Swiper Navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

            <style>
                /* Slide Wrapper Background */
                #<?php echo $uid; ?> .cs-slide-item {
                    background-color: #ffffff;
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

                /* Swiper Navigation Arrows - hidden by default, show on hover */
                #<?php echo esc_attr($uid); ?> .swiper-button-next,
                #<?php echo esc_attr($uid); ?> .swiper-button-prev {
                    opacity: 0;
                    pointer-events: none;
                    transition: opacity 180ms ease;
                }

                /* Reveal on hover of the slider wrapper */
                #<?php echo esc_attr($uid); ?>:hover .swiper-button-next,
                #<?php echo esc_attr($uid); ?>:hover .swiper-button-prev {
                    opacity: 1;
                    pointer-events: auto;
                }

                /* Arrow glyph styling */
                #<?php echo esc_attr($uid); ?> .swiper-button-next::after {
                    content: "\276F" !important;
                    /* ❯ */
                    font-size: 32px;
                    font-weight: 700;
                    color: #FFFFFF;
                    display: none;
                }

                #<?php echo esc_attr($uid); ?> .swiper-button-prev::after {
                    content: "\276E" !important;
                    /* ❮ */
                    font-size: 32px;
                    font-weight: 700;
                    color: #FFFFFF;
                    display: none;
                }

                @media (hover: none) {

                    /* On touch-only devices show arrows */
                    #<?php echo esc_attr($uid); ?> .swiper-button-next,
                    #<?php echo esc_attr($uid); ?> .swiper-button-prev {
                        opacity: 1;
                        pointer-events: auto;
                    }
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
