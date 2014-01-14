<?php
// $Id: views-exposed-form.tpl.php,v 1.4.4.1 2009/11/18 20:37:58 merlinofchaos Exp $
/**
 * @file views-exposed-form--QTL.tpl.php
 *
 * This template handles the layout of the views exposed filter form.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 *   - $widget->label: The visible label to print. May be optional.
 *   - $widget->operator: The operator for the widget. May be optional.
 *   - $widget->widget: The widget itself.
 *   - $button: The submit button for the form.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($q)): ?>
  <?php
    // This ensures that, if clean URLs are off, the 'q' is added first so that
    // it shows up first in the URL.
    print $q;
  ?>
<?php endif;?>
<?php if (empty($GLOBALS['_GET']['name'])) {?>
<div class="views-qtl_search-exposed-form views-exposed-form" 
     style="background-color:#FFFFFF;margin:0px 20px 20px 20px;border:1px solid #CCCCCC;">
  <div class="views-exposed-widgets clear-block">
    
    <?php 
//       $organism     = $widgets['filter-organism'];
       $qtl          = $widgets['filter-qtl_symbol'];
       $trait_class  = $widgets['filter-trait_class'];
       $pub_qtl_name = $widgets['filter-expt_qtl_symbol'];
//echo "<pre>";var_dump($widgets);echo "</pre>";
//echo "<pre>";var_dump($qtl);echo "</pre>";
 
       $view = views_get_current_view();
       if (empty($view->exposed_input)) {
          unset ($view->attachment_after);
          unset ($view->display);
       }
//echo "<pre>";var_dump($view);echo "</pre>";
    ?>
    <a id="search-form-top"></a>
    <div id="views-qtl_search-exposed-widgets" style="margin:10px 20px 10px 20px;">
         <fieldset id="views-qtl-exposed-widgets-fieldset" 
                   class="views-qtl-exposed-widgets-fields" 
                   style="padding: 10px 20px 10px 20px;">
            <legend>QTL Search Criteria</legend>
            
            <div>
              <p>
                 Search QTLs by any combination of trait name, published symbol or label.
<?php /*echo "<pre>";var_dump($trait_class);echo "</pre>";*/?>
              </p>
            </div>
            

<table>
  <tr>
<!-- organism 
    <td>
            <div class="views-qtl_search-exposed-widget" 
                 style="float:left;clear:left;margin-top: 10px">
               <div class="views-qtl_search-form-labels" style="width:90px;">
                  <label for="<?php print $organism->id; ?>">
                    <?php print $organism->label; ?>
                  </label>
               </div>
               <?php if (!empty($organism->operator)): ?>
                 <div class="tripal_search_feature-views-operator" 
                      style="float:left; margin-left:10px;">
                   <?php 
                      $organism->operator 
                          = str_replace('Is equal to', 'Exactly', $organism->operator);
                      $organism->operator 
                          = str_replace('<option value="!=">Is not equal to</option>', '', 
                                        $organism->operator);
                      print $organism->operator; 
                   ?>
                 </div>
               <?php endif; ?>
               
               <div class="tripal_search_feature-views-widget" 
                    style="float:left; margin-left:10px;">
                  <?php print $organism->widget; ?>
               </div>
            </div>
    </td>
<!--qtl-->             
    <td>
            <div class="views-qtl-exposed-widget" 
                 style="float:left;clear:left;margin-top: 10px;">
               <div class="views-qtl_search-form-labels" style="width:90px;">
                  <label for="<?php print $qtl->id; ?>">
                    <?php print $qtl->label; ?>
                  </label>
               </div>
               <?php if (!empty($qtl->operator)): ?>
                 <div class="tripal_search_feature-views-operator" 
                      style="float:left; margin-left:10px;">
                   <?php 
                      $qtl->operator 
                          = str_replace('Is equal to', 'Exactly', $qtl->operator);
                      $qtl->operator 
                          = str_replace('<option value="!=">Is not equal to</option>', '', 
                                        $qtl->operator);
                      print $qtl->operator; 
                   ?>
                 </div>
               <?php endif; ?>
               <div class="tripal_search_feature-views-widget" 
                    style="float:left; margin-left:10px;">
                  <?php print $qtl->widget; ?>
               </div>
               <div class="tripal_search_feature-views-example" 
                    style="float:left;margin-left: 10px;">
                 (e.g. branching, acid)
               </div>
            </div>
    </td>
    <td>
<!-- pub_qtl_name -->
            <div class="views-qtl-exposed-widget" 
                 style="float:left;clear:left;margin-top: 10px;">
               <div class="views-qtl_search-form-labels" style="width:200px;">
                  <label for="<?php print $pub_qtl_name->id; ?>">
                    <?php print $pub_qtl_name->label; ?>
                  </label>
               </div>
               <?php if (!empty($pub_qtl_name->operator)): ?>
                 <div class="tripal_search_feature-views-operator" 
                      style="float:left; margin-left:10px;">
                   <?php 
                      $pub_qtl_name->operator 
                          = str_replace('Is equal to', 'Exactly', $pub_qtl_name->operator);
                      $pub_qtl_name->operator 
                          = str_replace('<option value="!=">Is not equal to</option>', '', 
                                        $pub_qtl_name->operator);
                      print $pub_qtl_name->operator; 
                   ?>
                 </div>
               <?php endif; ?>
               <div class="tripal_search_feature-views-widget" 
                    style="float:left; margin-left:10px;">
                  <?php print $pub_qtl_name->widget; ?>
               </div>
               <div class="tripal_search_feature-views-example" 
                    style="float:left;margin-left: 10px;">
                 (e.g. Tae, Brn)
               </div>
            </div>
    </td>
<!-- trait class -->
    <td>
            <div class="views-qtl_search-exposed-widget" 
                 style="float:left;clear:left;margin-top: 10px">
               <div class="views-qtl_search-form-labels" style="width:115px;">
                  <label for="<?php print $trait_class->id; ?>">
                    <?php print $trait_class->label; ?>
                  </label>
               </div>
               <?php if (!empty($trait_class->operator)): ?>
                 <div class="tripal_search_feature-views-operator" 
                      style="float:left; margin-left:10px;">
                   <?php 
                      $trait_class->operator 
                          = str_replace('Is equal to', 'Exactly', $trait_class->operator);
                      $trait_class->operator 
                          = str_replace('<option value="!=">Is not equal to</option>', '', 
                                        $trait_class->operator);
                      print $trait_class->operator; 
                   ?>
                 </div>
               <?php endif; ?>
               
               <div class="tripal_search_feature-views-widget" 
                    style="float:left; margin-left:10px;">
                  <?php print $trait_class->widget; ?>
               </div>
            </div>

    </td>
  </tr>
</table>

<!-- submit/reset -->
            <div class="views-qtl-exposed-widget" style="padding-top:8px;clear:both;">       
              <?php $button = preg_replace("'Apply'", "Search", $button); print $button ?>
              <input type="Button" value="Reset" 
                     onClick="window.location='<?php global $base_url;print "$base_url/search/qtl"?>';">
            </div>
         </fieldset>
      </div>
  </div>
</div>

<?php }?>
