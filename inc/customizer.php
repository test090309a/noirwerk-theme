<?php
/**
 * Noirwerk Customizer Settings
 */

function noirwerk_customizer($wp_customize) {
    // Farben
    $wp_customize->add_setting('noirwerk_primary_color', array(
        'default' => '#D6001C',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'noirwerk_primary_color', array(
        'label' => __('Primärfarbe', 'noirwerk'),
        'section' => 'colors',
        'settings' => 'noirwerk_primary_color',
    )));
    
    // Hintergrundfarbe
    $wp_customize->add_setting('noirwerk_bg_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'noirwerk_bg_color', array(
        'label' => __('Hintergrundfarbe', 'noirwerk'),
        'section' => 'colors',
        'settings' => 'noirwerk_bg_color',
    )));
    
    // Footer Text
    $wp_customize->add_section('noirwerk_footer', array(
        'title' => __('Footer', 'noirwerk'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('noirwerk_footer_text', array(
        'default' => 'Systeme aus Licht und Logik. Gebaut in Berlin, getestet gegen die Nacht.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('noirwerk_footer_text', array(
        'label' => __('Footer Text', 'noirwerk'),
        'section' => 'noirwerk_footer',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'noirwerk_customizer');