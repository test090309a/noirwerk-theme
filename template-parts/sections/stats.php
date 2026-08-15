<?php 
// Wir nutzen die Theme Mod API für Werte ohne Plugin

$stat_01 = get_theme_mod( 'my_stat_01', '870' ); // Fallback: 870%
$stat_label_01 = get_theme_mod( 'my_stat_lbl_01', 'Projekte abgeschlossen' );

$stat_02 = get_theme_mod( 'my_stat_02', '15' );
$stat_label_02 = get_theme_mod( 'my_stat_lbl_02', 'Jahre Erfahrung' );

$stat_03 = get_theme_mod( 'my_stat_03', '24/7' ); // Fallback: 24/7
$stat_label_03 = get_theme_mod( 'my_stat_lbl_03', 'Support Verfügbarkeit' );
?>

<section class="stats-section">
    <div class="container stats-container">

        <!-- Statistik Item 1 -->
        <div class="col col-4 stat-item" data-count="<?php echo esc_attr($stat_01); ?>">
            <?php if ( ! empty( $stat_label_01 ) ): ?>
                <h3><?php echo wp_kses_post( $stat_label_01 ); ?></h3>
                
                <!-- Hier wird die Zahl angezeigt -->
                <span class="number"><?php echo absint( $stat_02 ); ?>%</span> 
            <?php endif; ?>
        </div>

        <!-- Statistik Item 2 (Beispiel für eine andere Struktur) -->
        <div class="col col-4 stat-item" data-count="<?php echo esc_attr($stat_03); ?>">
             <?php if ( ! empty( $stat_label_02 ) ): ?>
                <h3><?php echo wp_kses_post( $stat_label_02 ); ?></h3>
                
                 <!-- Hier wird die Zahl angezeigt -->
                <span class="number"><?php echo absint( $stat_03 ); ?>+</span> 
            <?php endif; ?>
        </div>

    </div>
</section>
