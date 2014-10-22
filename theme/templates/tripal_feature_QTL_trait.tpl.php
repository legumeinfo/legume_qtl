<?php
$feature = $variables['node']->feature;

/*not sure if this is useful, yet
$sql = "
  SELECT cvterm_id FROM {cvterm} 
  WHERE name='QTL symbol' 
        AND cv_id=(SELECT cv_id FROM {cv} WHERE name='local')";
$trait_type = chado_query($sql)->fetchField();
echo "QTL symbol: $trait_type";
*/

$options = array('return_array' => 1);
$feature = chado_expand_var($feature, 'table', 'feature_cvterm', $options);
$terms = $feature->feature_cvterm;

// order the terms by CV
$s_terms = array();
if ($terms) {
  foreach ($terms as $term) {
    $s_terms[$term->cvterm_id->cv_id->name][] = $term;  
  }
}


if (count($s_terms) > 0) {
?>
  <div class="tripal_feature-data-block-desc tripal-data-block-desc">
    Trait information for this QTL
  </div>
<?php
  // iterate through each term
  $i = 0;
  foreach ($s_terms as $cv => $terms) {  
    // the $headers array is an array of fields to use as the colum headers.
    // additional documentation can be found here
    // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
    $headers = array('Term', 'Definition');
    
    // the $rows array contains an array of rows where each row is an array
    // of values for each column of the table in that row.  Additional documentation
    // can be found here:
    // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
    $rows = array();
    
    foreach ($terms as $term) { 
      $accession = $term->cvterm_id->dbxref_id->accession;
      if (is_numeric($term->cvterm_id->dbxref_id->accession)) {
        $accession = $term->cvterm_id->dbxref_id->db_id->name . ":" . $term->cvterm_id->dbxref_id->accession;
      }
//      if ($term->cvterm_id->dbxref_id->db_id->urlprefix) {
//        $accession = l($accession, $term->cvterm_id->dbxref_id->db_id->urlprefix . $accession, array('attributes' => array("target" => '_blank')));
//      } 
      
      $rows[] = array(
        array('data' => $accession, 'width' => '15%'),
        $term->cvterm_id->name
      );
    } 

/*    
    // generate the link to configure a database, but only if the user is
    // a tripal administrator
    $configure_link = '';
    if (user_access('administer tripal')) {
      $db_id = $term->cvterm_id->dbxref_id->db_id->db_id;
      $configure_link = l('[configure term links]', "admin/tripal/chado/tripal_db/edit/$db_id", array('attributes' => array("target" => '_blank')));
    }
*/
    
    // the $table array contains the headers and rows array as well as other
    // options for controlling the display of the table.  Additional
    // documentation can be found here:
    // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
    $table = array(
      'header' => $headers,
      'rows' => $rows,
      'attributes' => array(
        'id' => "tripal_feature-table-terms-$i",
        'class' => 'tripal-data-table'
      ),
      'sticky' => FALSE,
      'caption' => '',//Vocabulary:  <b>' . ucwords(preg_replace('/_/', ' ', $cv)) . '</b> ' . $configure_link,
      'colgroups' => array(),
      'empty' => '',
    );
    
    // once we have our table array structure defined, we call Drupal's theme_table()
    // function to generate the table.
    print theme_table($table);
    $i++;
  }
}
