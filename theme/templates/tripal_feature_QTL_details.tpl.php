<?php
  $feature  = $variables['node']->feature;

  $qtl_details = $feature->qtl_details;
  
  // Nearest Marker
  $nearest_marker = 'unknown';
  if ($qtl_details->nearest_marker) {
    $nid = $qtl_details->nearest_marker_nid;
    $name = $qtl_details->nearest_marker;
    $nearest_marker = "<a href=\"/node/$nid\">$name</a>";
  }

  // Flanking Marker Low
  $flanking_marker_low = '';
  if ($qtl_details->flanking_marker_low) {
    $nid = $qtl_details->flanking_marker_low_nid;
    $name = $qtl_details->flanking_marker_low;
    $flanking_marker_low = "<a href=\"/node/$nid\">$name</a>";
  }

  // Flanking Marker High
  $flanking_marker_high = '';
  if ($qtl_details->flanking_marker_high) {
    $nid = $qtl_details->flanking_marker_high_nid;
    $name = $qtl_details->flanking_marker_high;
    $flanking_marker_high = "<a href=\"/node/$nid\">$name</a>";
  }

  // LOD
  $lod = $qtl_details->lod;

  // Likelihood ratio
  $likelihood_ratio = $qtl_details->likelihood_ratio;
  
  // Marker R2
  $marker_r2 = $qtl_details->marker_r2;
  
  // Total R2
  $total_r2 = $qtl_details->total_r2;
  
  // Additivity
  $additivity = $qtl_details->additivity;
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

  // Nearest Marker
  $rows[] = array(
    array(
      'data' => 'Nearest Marker',
      'header' => TRUE,
      'width' => 200,
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

  // accept user corrections
  print correctThis("and include QTL name and publication");
