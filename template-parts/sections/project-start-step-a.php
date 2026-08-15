<!-- ============================================================ -->
<!-- STEP A - Projekt-Typ (4 Optionen: Website, App, Branding, Motion) -->
<!-- ============================================================ -->

<label class="project-start__select" for="project_start_type">
  <span class="project-start__label" aria-hidden="true"><?php _e('Projekt Typ', 'noirwerk'); ?></span>

  <!-- Radio Group: Website & App (Required / Not Required) → Website Required, App Not -->
  <input id="project_start_webtype" value="_ps_type1" name="_pstart_type[]" type="radio" 
         class="project-start__option prj-opt-group web-opt" required checked style="outline:none;border:0;opacity:0;width:1px;height:1px;margin:-999em;cursor:pointer">

  <span data-step="1" class="ps-label project-start__label ps-sub" data-toggle-target="#project_start_webtype">
    Web<br>Plattform, Website, Landingpage
  </span><i aria-hidden="true"></i><span style="width:60%"></span>

  <!-- Radio Group: App (Not Required) -->
  <input id="project_start_app_type" value="_ps_type2" name="_pstart_type[]" type="radio" 
         class="project-start__option prj-opt-group app-opt" required style="outline:none;border:0;opacity:0;width:1px;height:1px;margin:-999em;cursor:pointer">

  <span data-step="1" class="ps-label project-start__label ps-sub" id="ps-app-type" data-toggle-target="#project_start_app_type"
        style="display:none" aria-hidden="true">
    Applikation<br>Mobile oder Webapp (React, Vue)
  </span><i aria-hidden="true"></i><span style="width:60%"></span>

  <!-- Radio Group: Branding (Required / Not Required) -->
  <input id="project_start_brand_type" value="_ps_type3" name="_pstart_type[]" type="radio" 
         class="project-start__option prj-opt-group branding-opt" required style="outline:none;border:0;opacity:0;width:1px;height:1px;margin:-999em;cursor:pointer">

  <span data-step="1" class="ps-label project-start__label ps-sub" data-toggle-target="#project_start_brand_type"
        style="display:none" aria-hidden="true">
    Branding<br>Markensystem, Visuelle Identität
  </span><i aria-hidden="true"></i><span style="width:60%"></span>

  <!-- Radio Group: Motion (Not Required) -->
  <input id="project_start_motion_type" value="_ps_type4" name="_pstart_type[]" type="radio" 
         class="project-start__option prj-opt-group motion-opt" required style="outline:none;border:0;opacity:0;width:1px;height:1px;margin:-999em;cursor:pointer">

  <span data-step="1" class="ps-label project-start__label ps-sub" id="ps-motion-type" data-toggle-target="#project_start_motion_type"
        style="display:none" aria-hidden="true">
    Motion<br>Animation, Video, 3D-Motion
  </span><i aria-hidden="true"></i><span style="width:60%"></span>

</label><!-- close Step A -->

<div class="btn-group project-start__submit">
  <button type="button" name="_pstart_submit_step1a" id="ps-btn-step1a" hidden disabled class="btn btn--red">Weiter →<i aria-hidden="true"></i></button>
  <button type="button" id="ps-back-step2" disabled class="btn project-start__back btn-prev-step">Zurück</span><a href="#projekte">&larr;</a></div><!-- close btn-group -->

<style>.project-start__submit{ position:absolute; margin-top:1.735em; }</style>