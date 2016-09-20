<?php
  $feature  = $variables['node']->feature;

  $qtl_details = $feature->qtl_details;
//echo "<pre>";var_dump($qtl_details);echo "</pre>";

  // Note that only be one experiment will be associated with a particular QTL
  $experiment = $feature->experiments[0];
//echo "<pre>";var_dump($experiment);echo "</pre>";
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

  // Publication 
  if ($qtl_details->pub_nid) {
    $citation = "<a href=\"/pub/" . $qtl_details->pub_nid . "\">";
    $citation .= $qtl_details->citation . "</a>";
  }
  $rows[] = array(
    array(
      'data' => 'Publication',
      'header' => TRUE,
      'width' => 200,
    ),
    $citation,
  );

  // Year & Location
  $rows[] = array(
    array(
      'data' => 'Location and/or Year',
      'header' => TRUE,
      'width' => 200,
    ),
    $experiment['geolocation'],
  );

  // Description
  $rows[] = array(
    array(
      'data' => 'Description',
      'header' => TRUE,
      'width' => 200,
    ),
    $experiment['project_description'],
  );

  // Comment
  $rows[] = array(
    array(
      'data' => 'Comment',
      'header' => TRUE,
      'width' => 200,
    ),
    $experiment['project_comment'],
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
