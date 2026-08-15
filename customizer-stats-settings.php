<?php
/**
 * Noirwerk Theme Functions
 */

// ============================================================
// CUSTOMIZER-EINSTELLUNGEN FÜR STATISTIKEN ERFOLGREICH DEFINIERT!
// ============================================================

function my_theme_customize_register( $wp_customize ) {
    
    // Neue Sektion erstellen, damit es übersichtlich bleibt
    $wp_customize->add_section( 'my_stats_section', array(
        'title'    => __( 'Meine Statistiken (ohne Plugin)', 'text-domain' ),
        'priority' => 30,
    ) );

    // Feld 1: Die große Zahl / Prozentzahl (PROJEKTE ABGESCHLOSSEN)
    $wp_customize->add_setting( 'my_stat_01', array(
        'default'           => '870',
        'sanitize_callback' => 'absint'
    ) );

    // Feld 2: Label für Statistik 1 (PROJEKTE ABGESCHLOSSEN)
    $wp_customize->add_setting( 'my_stat_lbl_01', array( // label für stat_01 
        'default'           => 'Projekte abgeschlossen',
         'sanitize_callback' => 'wp_kses_post'
    ) );

     $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            'my_stat_lbl_01',
            array( // label für stat_01
                'label'   => __( 'Beschreibung zu Statistik 1', 'text-domain' ),
                'section' => 'my_stats_section',
                'type'    => 'textarea' // TEXTAREA als Label-Feld Typ 
            )
        ) );

    // Feld 3: KONTAKTE (ZAHLENDIE KONTATE)
    $wp_customize->add_setting( 'my_stat_02', array(
        'default'           => '15',
         'sanitize_callback' => 'absint' 
     ) );

       $wp_customize->add_control('my_stat_02', array( // die zweite Zahl
             'label'   => __( 'Statistik 2 (z.B. KONTATE)', 'text-domain' ),
             'section' => 'my_stats_section',
             'type'    => 'number',
         ));

        // Feld 4: PROBLEME BEI EREIGENISSEN (NUMMER) 
        $wp_customize->add_setting( 'my_stat_03', array(
            'default'           => '27',
             'sanitize_callback' => 'absint'
     ) );

        // Feld 5: PROBLEME BEI EREIGENISSEN (BE SCHREIBUNG)
         $wp_customize->add_setting( 'my_stat_lbl_03', array( // label für stat_lbl_03 
            'default'           => 'Probleme bei Ereignissen',
             'sanitize_callback' => 'wp_kses_post'
        ) );

          $wp_customize->add_control( new WP_Customize_Control( // Label-Control mit TEXTAREA Typ
                $wp_customize, // der customize-control Name
                'my_stat_lbl_03', // stat_lbl für die Statistik-Labels
                array(
                    'label'   => __( 'Beschreibung zu Statistik 3', 'text-domain' ),
                    'section' => 'my_stats_section',
                    'type'    => 'textarea' 
                )
            ) ); 

        // Feld 6: ZUFRIEDENE KUNDEN (FESTGESETZTER WERT) - NICHT ÜBER CUSTOMIZER STEUERBAR!
         $wp_customize->add_setting( 'my_stat_04', array(
             'default'           => '152', // Zufriedene Kunden mit einem festgelegten Wert von 150+ 
              'sanitize_callback' => 'absint' // Feste Zahl als Default-Wert und Sanitierungs-Funktion
        ) );

         $wp_customize->add_control( 'my_stat_04', array(
             'label'   => __( 'Zufriedene Kunden (fest)', 'text-domain' ),
             'section' => 'my_stats_section',
             'type'    => 'hidden' // Verstecktes Feld, da es nicht bearbeitet werden soll! 
         ));

}
add_action( 'customize_register', 'my_theme_customize_register' );
