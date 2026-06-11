<?php
namespace ThemeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CSCO_Signup extends Widget_Base {

    public function get_name() {
        return 'signup';
    }

    public function get_title() {
        return __( 'Signup Form Section', 'msw' );
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_settings',
            [ 'label' => __( 'Settings', 'msw' ) ]
        );

        $this->add_control(
            'form_type',
            [
                'label' => __( 'Form Type', 'msw' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'form',
                'options' => [
                    'form'    => __( 'Show Form', 'msw' ),
                    'no-form' => __( 'Hide Form', 'msw' ),
                ],
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'   => __( 'Heading', 'msw' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Join Our Newsletter', 'msw' ),
            ]
        );

        // Background image
        $this->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'msw' ),
                'type'  => Controls_Manager::MEDIA,
            ]
        );

        // Background color
        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'msw' ),
                'type'  => Controls_Manager::COLOR,
            ]
        );

        // Gravity Forms dropdown
        if ( class_exists( '\GFAPI' ) ) {
            $forms   = \GFAPI::get_forms();
            $options = [];

            if ( ! empty( $forms ) ) {
                foreach ( $forms as $form ) {
                    $options[ $form['id'] ] = $form['title'];
                }
            }

            $this->add_control(
                'gravity_form_id',
                [
                    'label'     => __( 'Select Gravity Form', 'msw' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $options,
                    'default'   => ! empty( $options ) ? array_key_first( $options ) : '',
                    'condition' => [ 'form_type' => 'form' ],
                ]
            );
        }

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( $settings['form_type'] === 'no-form' ) {
            return;
        }

        // Inline background styles
        $styles = '';
        if ( ! empty( $settings['background_image']['url'] ) ) {
            $styles .= "background-image: url('" . esc_url( $settings['background_image']['url'] ) . "'); background-repeat: no-repeat; background-size: cover; background-position: center;";
        }
        if ( ! empty( $settings['background_color'] ) ) {
            // Only apply color if no image is set
            if ( empty( $settings['background_image']['url'] ) ) {
                $styles .= "background-color: " . esc_attr( $settings['background_color'] ) . ";";
            }
        }

        echo '<section class="join" style="' . esc_attr( $styles ) . '"><div class="container section-content-container">';
        echo '<h1>' . esc_html( $settings['heading'] ) . '</h1>';

        if ( ! empty( $settings['gravity_form_id'] ) && function_exists( '\gravity_form' ) ) {
            \gravity_form( $settings['gravity_form_id'], false, false, false, '', true );
        } else {
            echo '<p>' . __( 'Please select a Gravity Form from widget settings.', 'msw' ) . '</p>';
        }

        echo '</div></section>';
    }
}
