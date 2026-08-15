<?php
/**
 * Noirwerk Theme Template für Statistiken
 */
?>


<style>
    .stats-counter {
        display: inline-block;
        position: relative;
    }
    
    .counter-value {
        font-size: 2rem;
        color: #D6001C;
    }</style>

<div class="stats-wrapper">
    <div class="stat-item-wrapper" style="margin-top:-8px;">
        <span class="stat-item-label">Projekte abgeschlossen:</span>
    </div>
    <div class="counter" data-target="<?php echo esc_attr( '870' ); ?>">
        
<?php 
// Statistik-Werte werden direkt mit einem vorgegebenen Platzhalter-String geliefert
$stat_val_01 = "870";

?>


        <?php if (isset($stat_lbl)){echo $stat_lbl;} ?>
    
    </div>
</div>



<div class="stats-wrapper">
    <div class="counter" data-target="<?php echo esc_attr( '15' ); ?>">
        15
<?php 
// Statistisch: Zweite Statistik mit einem anderen statisch-festen Wert statt Dynamischer Variablen


?>

<div class="stat-item-wrapper" style="margin-top:-8px;">
    <span class="stat-item-label">Kontakte:</span>
</div>
    </div>
</div>


<div class="stats-wrapper">
    <div class="counter" data-target="<?php echo esc_attr( '27' ); ?>">
        27


        <?php if (isset($stat_lbl_03)){echo $stat_lbl_03;} ?>


    </div>

</div>



<div class="stats-wrapper">
    <div class="counter" data-target="<?php echo esc_attr( '152' ); ?>">


        <?php if (isset($stat_label_04)){echo $stat_label_04;} else {echo "Zufriedene Kunden";} ?>

</div>

</div>

<!-- ZUFRIEDENE KUNDEN -->
</div>



<style>
    .counter {
        border: 1px solid #D6001C;
    }
    
    .stat-item-wrapper{ 
    margin-top:-8px; 
      }</style>

<script>
document.addEventListener('DOMContentLoaded', function() { 

const counters = document.querySelectorAll('.counter');


    counters.forEach(counter => {
        const target = counter.dataset.target;
        
        let current = 0;


// Animation mit JavaScript-Counter und GSAP-Style:



                setTimeout(() => {
                    // Counter wird nach 6 Sekunden gestartet (6s Delay)
                    const timer1 = setInterval(() => {

                        const newVal = parseInt(target);
                        

                        
                            if(current < target){

                                current += Math.ceil((target - current) / 30) + 1;



                            } else{
            clearInterval(timer1);


                            }
                            

                        counter.textContent = current.toLocaleString('de-DE');
                    }, 25);
                }, 6000); // nach 6s gestartet!

    });

}, false);



console.log("Statistik-Animation fertig: " + counters.length + " Counter(s) gefunden");


</script>
