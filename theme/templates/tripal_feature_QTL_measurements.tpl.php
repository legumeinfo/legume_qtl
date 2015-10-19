<?php
  $feature = $variables['node']->feature;
  $options = array('return_array' => 1);
  $feature = chado_expand_var($feature, 'table', 'analysisfeature', $options);
  $analyses = $feature->analysisfeature;
  // don't show this page if there are no analyses
  if (count($analyses) > 0) { 
?>
    <div class="tripal_feature-data-block-desc tripal-data-block-desc">
      These types of measurements were collected for this QTL.
    </div> 
<?php
  // the $headers array is an array of fields to use as the colum headers.
  // additional documentation can be found here
  // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
  $headers = array('Measurement' ,'Description');
  
  // the $rows array contains an array of rows where each row is an array
  // of values for each column of the table in that row.  Additional documentation
  // can be found here:
  // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
  $rows = array();
  
  foreach ($analyses as $analysis) {
    $analysis = chado_expand_var($analysis, 'field', 'analysis.description');
//echo "<pre>";var_dump($analysis->analysis_id);echo "</pre>";
    $analysis_name = $analysis->analysis_id->name;
    if (property_exists($analysis->analysis_id, 'nid')) {
      $analysis_name = l($analysis_name, "node/" . $analysis->analysis_id->nid);
    } 
    $rows[] = array(
      $analysis_name,
      $analysis->analysis_id->description,
    );
  }
   
  // the $table array contains the headers and rows array as well as other
  // options for controlling the display of the table.  Additional
  // documentation can be found here:
  // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
  $table = array(
    'header' => $headers,
    'rows' => $rows,
    'attributes' => array(
      'id' => 'tripal_feature-table-analyses',
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
} 

