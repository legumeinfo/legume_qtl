<?php
  $feature  = $variables['node']->feature;
//echo "<br><br>tripal_feature_Map_Pos.tpl.php Feature object: <pre>";var_dump($feature);echo "</pre><br><br><br>";
  
  $qtl_details = $feature->qtl_details;
  $map_positions = $feature->map_positions;
//echo "<br><br>tripal_feature_Map_Pos.tpl.php Map position object: <pre>";var_dump($map_positions);echo "</pre><br><br><br>";

  $positions = array();
  foreach ($map_positions as $map_position) {
    // Interval Calculation Method
    $interval_calc_method = $map_position->int_calc_meth;
  
    // Map
    $map_name = makeMapLink($map_position);

    // Linkage group
    $lg = makeLgMapLink($map_position);

    // coordinates
    $left_end  = $map_position->left_end;
    $right_end = $map_position->right_end;
    
    // QTL peak
    $qtl_peak = $map_position->qtl_peak;
    
    // Mapping population
    $mapping_population = $map_position->mapping_population;
    
    // Parent1
    $parent1 = 'N/A';
    if ($map_position->parent1) {
      $name = $map_position->parent1;
      $nid = $map_position->parent1_nid;
      $parent1 = "<a href=\"/node/$nid\">$name</a>";
    }

    // Parent2
    $parent2 = 'N/A';
    if ($map_position->parent2) {
      $name = $map_position->parent2;
      $nid = $map_position->parent2_nid;
      $parent2 = "<a href=\"/node/$nid\">$name</a>";
    }
  
    // Population
//echo "population: " . $map_positions->mapping_population . "<br><br><br>";
    $population = "N/A";
    if ($map_position->mapping_population) {
        $population = $map_position->mapping_population;
    }

    array_push($positions, array(
      'interval_calc_method' => $interval_calc_method,
      'map_name' => $map_name,
      'lg' => $lg,
      'qtl_peak' => $qtl_peak,
      'left_end' => $left_end,
      'right_end' => $right_end,
      'mapping_population' => $mapping_population,
      'parent1'=> $parent1,
      'parent2' => $parent2,
      'population' => $population,
    ));
  }
//echo "<br><br>tripal_feature_Map_Pos.tpl.php Map positions: <pre>";var_dump($positions);echo "</pre><br><br><br>";
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
  
  // Name row
  $rows[] = array(
    array(
      'data' => 'QTL Name',
      'header' => TRUE,
      'width' => 200,
      'style' => 'background-color:#c9c9c9;color:#101010',
    ),
    '<b>'.$feature->name.'</b>',
  );

  if (count($positions) == 0) {
    $rows[] = array(
      array(
        'data' => 'No position information available.',
        'header' => FALSE,
        'colspan' => 3,
        'style' => 'color:#101010;background-color:#ffffff',
      ),
    );  
  }
  else {
    /////// SEPARATOR /////////
    
    $rows[] = array(
      array(
        'data' => '',
        'header' => TRUE,
        'height' => 6,
        'style' => 'background-color:white',
      ),
      array(
        'data' => '',
        'style' => 'background-color:white',
      ),
    );

    for ($i=0; $i<count($positions); $i++) {
      $rows[] = array(
        array(
          'data' => 'Map Position ' . ($i+1),
          'header' => TRUE,
          'colspan' => 2,
          'style' => 'background-color:#c9c9c9;color:#101010',
        ),
      );
      // Map
      $rows[] = array(
        array(
          'data' => 'Map',
          'header' => TRUE,
          'width' => 200,
        ),
        $positions[$i]['map_name'],
      );
      // Linkage group
      $rows[] = array(
        array(
          'data' => 'Linkage Group',
          'header' => TRUE,
        ),
        $positions[$i]['lg'],
      );
      // QTL peak
      $rows[] = array(
        array(
          'data' => 'QTL Peak',
          'header' => TRUE,
        ),
        $positions[$i]['qtl_peak'],
      );
      // Start Position
      $rows[] = array(
        array(
          'data' => 'Start Position',
          'header' => TRUE,
        ),
        $positions[$i]['left_end'],
      );
      // End Position
      $rows[] = array(
        array(
          'data' => 'End Position',
          'header' => TRUE,
        ),
        $positions[$i]['right_end'],
      );
      // Mapping population
      $rows[] = array(
        array(
          'data' => 'Mapping Population',
          'header' => TRUE,
        ),
        $positions[$i]['population'],
      );
      // Parent1
      $rows[] = array(
        array(
          'data' => 'Parent1',
          'header' => TRUE,
        ),
        $positions[$i]['parent1'],
      );
      // Parent2
      $rows[] = array(
        array(
          'data' => 'Parent2',
          'header' => TRUE,
        ),
        $positions[$i]['parent2'],
      );
      // Interval Calculation Method
      $rows[] = array(
        array(
          'data' => 'Interval Calculation Method',
          'header' => TRUE,
        ),
        $positions[$i]['interval_calc_method'],
      );
      $rows[] = array(
        array(
          'data' => '',
          'header' => TRUE,
          'height' => 6,
          'style' => 'background-color:white',
        ),
        array(
          'data' => '',
          'style' => 'background-color:white',
        ),
      );
    }//each map position
  }//at least 1 map position
  
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

  // accept user corrections
  print correctThis("and include QTL name and publication");
