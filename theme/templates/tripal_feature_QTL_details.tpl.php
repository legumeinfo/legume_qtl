<?php
  $feature  = $variables['node']->feature;
  //echo "<br><br>tripal_feature_QTL_base.tpl.php Feature object: <pre>";var_dump($feature);echo "</pre><br><br><br>";
  
  //tripal_core_expand_chado_vars deprecated
  //$feature = tripal_core_expand_chado_vars($feature, 'table', 'featureprop', 
  //                                         array('return_array' => 1));
  $feature = chado_expand_var($feature, 'table', 'featureprop', 
                              array('return_array' => 1));
  //echo "<br><br>Feature object expanded: <pre>";var_dump($feature);echo "</pre><br><br><br>";
  
  // Process featureprop 
  $properties = $feature->featureprop;
  //echo "<br><br>Feature properties: <pre>";var_dump($properties);echo "</pre><br><br><br>";
  
  $interval_calc_method = 'N/A';
  if ($properties) {
    foreach ($properties AS $prop) {
//echo $feature->feature_id .": " . $prop->type_id->name . " = " . $prop->value . "<br>";
      if ($prop->value != '') {
        if ($prop->type_id->cv_id->name == 'local' 
                  && $prop->type_id->name == 'interval calculation method') {
          $interval_calc_method = $prop->value;
        }
      }//property has a value
    }//each property
  }//there are property records
  
  // Retrieve QTL details
  $qtl_details = $feature->qtl_details;
//echo "<br><br>qtl details: <pre>";var_dump($qtl_details);echo "</pre><br><br><br>";

  // Nearest Marker
  $nearest_marker = 'unknown';
  if ($qtl_details->nearest_marker) {
    $id = $qtl_details->nearest_marker[0]->feature_id;
    $name = $qtl_details->nearest_marker[0]->name;
    $nearest_marker = "<a href=\"/ID$id\">$name</a>";
  }
//echo "<br><br>nearest marker: <pre>";var_dump($nearest_marker);echo "</pre><br><br><br>";

  // Flanking Marker Low
  $flanking_marker_low = 'unknown';
  if ($qtl_details->flanking_marker_low) {
    $id = $qtl_details->flanking_marker_low[0]->feature_id;
    $name = $qtl_details->flanking_marker_low[0]->name;
    $flanking_marker_low = "<a href=\"/feature/arachis/hypogaea/genetic_marker/$name\">$name</a>";
  }
//echo "<br><br>flanking marker low: <pre>";var_dump($flanking_marker_low);echo "</pre><br><br><br>";

  // Flanking Marker High
  $flanking_marker_high = 'unknown';
  if ($qtl_details->flanking_marker_high) {
    $id = $qtl_details->flanking_marker_high[0]->feature_id;
    $name = $qtl_details->flanking_marker_high[0]->name;
    $flanking_marker_high = "<a href=\"/ID$id\">$name</a>";
  }
//echo "<br><br>flanking marker high: <pre>";var_dump($flanking_marker_high);echo "</pre><br><br><br>";

//echo "map information: <pre>";var_dump($qtl_details->map_pos);echo "</pre><br><br><br>";
  // Parent1
  $parent1 = 'unknown';
  if ($qtl_details->map_pos->parent1) {
    $name = $qtl_details->map_pos->parent1;
    $id = $qtl_details->map_pos->parent1_id;
    $parent1 = "<a href=\"/node/$id\">$name</a>";
  }

  // Parent2
  $parent2 = 'unknown';
  if ($qtl_details->map_pos->parent2) {
    $name = $qtl_details->map_pos->parent2;
    $id = $qtl_details->map_pos->parent2_id;
    $parent2 = "<a href=\"/node/$id\">$name</a>";
  }
  
  // Population
//echo "population: " . $qtl_details->map_pos->mapping_population . "<br><br><br>";
  $population = "unknown";
  if ($qtl_details->map_pos->mapping_population) {
      $population = $qtl_details->map_pos->mapping_population;
  }

  // LOD, Likelihood ratio, Marker R2, Total R2
  $lod              = 'N/A';
  $likelihood_ratio = 'N/A';
  $marker_r2        = 'N/A';
  $total_r2         = 'N/A';
  $additivity       = 'N/A';
  foreach ($qtl_details->analysis as $analysis) {
    if ($analysis->name && $analysis->name == 'LOD') {
      $lod = $analysis->rawscore;
    }
    if ($analysis->name && $analysis->name == 'likelihood ratio') {
      $likelihood_ratio = $analysis->rawscore;
    }
    if ($analysis->name && $analysis->name == 'marker R2') {
      $marker_r2 = $analysis->rawscore;
    }
    if ($analysis->name && $analysis->name == 'total R2') {
      $total_r2 = $analysis->rawscore;
    }
    if ($analysis->name && $analysis->name == 'additivity') {
      $additivity = $analysis->rawscore;
    }
  }//LOD, et cetera
//echo "analysis: <pre>";var_dump($qtl_details->analysis);echo "</pre><br><br><br>";
?>

<div class="tripal_feature-data-block-desc tripal-data-block-desc"></div> 

<?php
  // the $headers array is an array of fields to use as the column headers. 
  // additional documentation can be found here 
  // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
  // This table for the analysis has a vertical header (down the first column)
  // so we do not provide headers here, but specify them in the $rows array below.
  $headers = array();
  
  // the $rows array contains an array of rows where each row is an array
  // of values for each column of the table in that row.  Additional documentation
  // can be found here:
  // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7 
  $rows = array();
  
  // Interval Calculation Method
  $rows[] = array(
    array(
      'data' => 'Interval Calculation Method',
      'header' => TRUE,
      'width'  => '270',
    ),
    $interval_calc_method
  );
  // Start Position
  $rows[] = array(
    array(
      'data' => 'Start Position',
      'header' => TRUE,
    ),
    $qtl_details->map_pos->start
  );
  // End Position
  $rows[] = array(
    array(
      'data' => 'End Position',
      'header' => TRUE,
    ),
    $qtl_details->map_pos->end
  );
  // Interval Calculation Method
  $rows[] = array(
    array(
      'data' => 'Interval Calculation Method',
      'header' => TRUE,
    ),
    $interval_calc_method
  );
  // Nearest Marker
  $rows[] = array(
    array(
      'data' => 'Nearest Marker',
      'header' => TRUE,
    ),
    $nearest_marker
  );
  // Flanking Marker Low
  $rows[] = array(
    array(
      'data' => 'Flanking Marker Low',
      'header' => TRUE,
    ),
    $flanking_marker_low
  );
  // Flanking Marker High
  $rows[] = array(
    array(
      'data' => 'Flanking Marker High',
      'header' => TRUE,
    ),
    $flanking_marker_high
  );
  // Parent1
  $rows[] = array(
    array(
      'data' => 'Parent1',
      'header' => TRUE,
    ),
    $parent1
  );
  // Parent2
  $rows[] = array(
    array(
      'data' => 'Parent2',
      'header' => TRUE,
    ),
    $parent2
  );
  // LOD
  $rows[] = array(
    array(
      'data' => 'LOD',
      'header' => TRUE,
    ),
    $lod
  );
  // Likelihood ratio
  $rows[] = array(
    array(
      'data' => 'Likelihood ratio',
      'header' => TRUE,
    ),
    $likelihood_ratio
  );
  // Marker R2
  $rows[] = array(
    array(
      'data' => 'Marker R2',
      'header' => TRUE,
    ),
    $marker_r2
  );
  // Total R2
  $rows[] = array(
    array(
      'data' => 'Total R2',
      'header' => TRUE,
    ),
    $total_r2
  );
  // Additivity
  $rows[] = array(
    array(
      'data' => 'Additivity',
      'header' => TRUE,
    ),
    $additivity
  );
 
  // the $table array contains the headers and rows array as well as other
  // options for controlling the display of the table.  Additional
  // documentation can be found here:
  // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
  $table = array(
    'header' => $headers,
    'rows' => $rows,
    'attributes' => array(
      'id' => 'tripal_feature-table-base',
      'class' => 'tripal-data-table'
    ),
    'sticky' => FALSE,
    'caption' => '',
    'colgroups' => array(),
    'empty' => '',
  );
  
  // once we have our table array structure defined, we call Drupal's theme_table()
  // function to generate the table.
  print theme_table($table); 
