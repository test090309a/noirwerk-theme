<?php
/**
 * Noirwerk Helper Functions
 */

function noirwerk_get_icon($type) {
    $icons = array(
        'rect' => '<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="13"/><path d="M8 21h8M12 17v4"/></svg>',
        'circle' => '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><path d="M12 2v4M12 18v4M2 12h4M18 12h4"/></svg>',
        'triangle' => '<svg viewBox="0 0 24 24"><path d="M8 3 3 12l5 9M16 3l5 9-5 9M13 3l-2 18"/></svg>',
        'wave' => '<svg viewBox="0 0 24 24"><path d="M4 18V6l8 6 8-6v12"/></svg>',
    );
    return isset($icons[$type]) ? $icons[$type] : '';
}

function noirwerk_fallback_menu() {
    echo '<ul class="nav__list">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'noirwerk') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#services')) . '">' . __('Services', 'noirwerk') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#projekte')) . '">' . __('Projekte', 'noirwerk') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#about')) . '">' . __('Über uns', 'noirwerk') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#kontakt')) . '">' . __('Kontakt', 'noirwerk') . '</a></li>';
    echo '</ul>';
}