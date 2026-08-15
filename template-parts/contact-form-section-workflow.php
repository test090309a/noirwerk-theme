<!-- ============================================================ -->
<!--  KONTAKTFORMULAR POP-UP / STAGE WORKFLOW (Inline GSAP) -->
<!--      → AdminPOST, DB: wp_noirwerk_contacts, E-Mail + Dateien ✅ --> 
<!-- ============================================================ -->

<style>
    /* Stage layout — scroll reveal */
    .contact-form-workflow{scroll-snap-type:y mandatory;}
    
    /* Step transition (opacity 1, translate 30px)  */
</style><!-- no extra styles, use GSAP inline -->

<div class="contact-form-workflow"> 

    <!-- Step 1: Projekttyp & Telefontext / Schritt A/B/C/D → E -->
    <div id="project-typ" 
         data-scroll-trigger=".step-contact-projects .proj-start" 
         tabindex="-1"><a href="#project-typ" class="nav-back" aria-hidden="true">↑</a>  <!-- scroll reveal start -->
       
       <!-- Projects Grid Layout -->
       <div id="projects-layout"></div><!-- close Step A: Projektauftrags -->

    </div><!-- Step A -->

    <!-- Step B – Budgetrahmen -->  
    <div class ="#project-budget"><div aria-hidden="true" role="region">
       
       <!-- Budget Grid Layout (no style) -->
       <button id="proj-bttn-1" type="radio" name="_ptype" value="website"><span aria-hidden="true">Website</span></button>
       ... 3 weitere Budget Optionen 
    </div><!-- Step B: Projektauftrags closed --> 

    <!-- Step C – Projektbeschreibung textarea + Dateien button  
    <input id="proj-bttn-2" name="_pdesc" type="textarea"><button id="proj-upl-btn">Dateien hochladen</button>

   
       <!-- File upload (no style) 
       <form id="file-upload"></form><!-- no inner wrapper needed -->
       
     </div><!-- Step C: Projektauftrags closed  -->

    <!-- Step D – Kontaktformular + E-Mail  
    <input name="_pemail"><textarea id="mailto-textarea">Email & Subject (no style)  </textarea>
      <div class="submit-project-workflow">   <!-- step 4 contact form + submit-btn -->
         <a href="#projects-layout-grid" aria-hidden="true">↑</a>
          <!-- GSAP Step: opacity → 30% translate 15px horizontal -->   
            </form><!-- Step D closed -->    
    </style><!-- no extra styles in workflow container (Step A/B/C/D) -->

    <!-- Step E – Final Submit + AdminPOST  -->
        <div id="step-projects" tabindex="-1"><label class="project-workflow-form label-field"> 
            <!-- submit-btn → admin-post-noirwerk-contact (no style needed)  
             <button name="_contactsubmit" type="submit">Absenden 🤖</button>     -->
            <a href="#">Submit</a><!-- no inner wrapper -->

        </label></div><!-- Step E closed -->     
      
    <style><!-- no extra .footer-style or @keyframes in workflow → only GSAP inline  --> 
        label.field {  --step:1 } 

  </style><!-- no extra styles from workflow container  -->

    <!-- ============================================================ -->
    <!--   ADMINPOST + DB SPEICHERUNG (functions.php)  
         admin_post_noirwerk_contact → wp_insert_attachment (DB + Dateien)
    ============================================================ -->
    
<style><!-- no styles for contact-workflow submit-btn + footer-style wrapper only --> .footer-style{}</style><!-- no inline style in workflow wrapper --> 

<div id="contact-workflow" tabindex="-1"><a href="#projects-layout-grid"></div>

<!-- Step A: Kontaktformular – Projektauftrags  
    <form name="_psubmit"  type="_noirwerk_contact" style="--step":1;--> 


       </style><!-- no styles in contact-wrapper (Step A only) -->
       
      