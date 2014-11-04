<?php
/**
 * @file
 * Implementation of hooks to create a feature content type
 */



/**
 * Implements hook_node_view().
 * Acts on all content types.
 *
 * @ingroup legume_qtl
 */
function legume_qtl_node_view($node, $view_mode, $langcode) {
  if ($node->type != 'chado_feature') { return; }

  $path = drupal_get_path('module', 'legume_qtl');
  
  switch ($view_mode) {
    case 'full':
      if ($node->feature->type_id->name == 'QTL') {
        // we want to override the base feature theme
        $node->content['tripal_feature_base'] = array(
          '#markup' => theme("tripal_feature_QTL_base",
                             array('node' => $node)),
          '#tripal_toc_id'    => 'base',
          '#tripal_toc_title' => 'QTL Overview',
          '#weight' => -100,
        );
        $node->content['tripal_feature_QTL_base'] = array(
          '#markup' => theme("tripal_feature_QTL_base",
                             array('node' => $node)),
          '#tripal_toc_id'    => 'qtl',
          '#tripal_toc_title' => 'QTL Overview',
          '#weight' => -100,
        );
        
        $node->content['tripal_feature_properties'] = array(
          '#markup' => theme('tripal_feature_QTL_details', array('node' => $node)),
          '#tripal_toc_id'    => 'properties',
          '#tripal_toc_title' => 'QTL Details',
        );
        $node->content['tripal_feature_QTL_details'] = array(
          '#markup' => theme("tripal_feature_QTL_details",
                             array('node' => $node)),
          '#tripal_toc_id'    => 'qtl_details',
          '#tripal_toc_title' => 'QTL Details',
          '#weight' => -70,
        );
        
        $node->content['tripal_feature_Map_Pos'] = array(
          '#markup' => theme("tripal_feature_Map_Pos",
                             array('node' => $node)),
          '#tripal_toc_id'    => 'map_position',
          '#tripal_toc_title' => 'Map Positions',
          '#weight' => -60,
        );
        
        $node->content['tripal_feature_analyses'] = array(
          '#markup' => theme('tripal_feature_analyses', array('node' => $node)),
          '#tripal_toc_id'    => 'analyses',
          '#tripal_toc_title' => 'Measurements',
        );
        $node->content['tripal_feature_QTL_measurements'] = array(
          '#markup' => theme("tripal_feature_QTL_measurements",
                             array('node' => $node)),
          '#tripal_toc_id'    => 'measurements',
          '#tripal_toc_title' => 'Measurements',
          '#weight' => -50,
        );
        
        $node->content['tripal_feature_terms'] = array(
          '#markup' => theme('tripal_feature_terms', array('node' => $node)),
          '#tripal_toc_id'    => 'terms',
          '#tripal_toc_title' => 'Trait',
        );
        $node->content['tripal_feature_QTL_trait'] = array(
          '#markup' => theme("tripal_feature_QTL_trait",
                             array('node' => $node)),
          '#tripal_toc_id'    => 'terms',
          '#tripal_toc_title' => 'Trait',
          '#weight' => -30,
        );

      }
      break;
      
    case 'teaser':
      break;
      
    default:
      break;
  }
//echo "<pre>";var_dump(array_keys($node->content));echo "</pre>";
}


function correctThis($include) {
  $include = trim($include);
  if ($include && $include != '') {
    $include = " $include";
  }
  $correct_this = "
    <div>
      We welcome <a href=\"\contact\">corrections</a> to this record. Please provide contact 
      information$include in your note.
    </div>";
  return t($correct_this);
}
