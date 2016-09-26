<?php
/* eksc- no longer used (09/26/16)
$feature = $variables['node']->feature;

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
    // the $headers array is an array of fields to use as the column headers.
    // additional documentation can be found here
    // https://api.drupal.org/api/drupal/includes%21theme.inc/function/theme_table/7
    $headers = array('Trait', 'Definition', 'Ontology terms');
    
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

      // Get attached OBO terms
      $obo_terms = array();
      $cvterm_dbxref = chado_expand_var($term->cvterm_id, 'table', 'cvterm_dbxref', $options);
      $cvterm_dbxrefs = $cvterm_dbxref->cvterm_dbxref;
      foreach ($cvterm_dbxrefs as $r) {
//echo "<pre>";var_dump($r);echo "</pre><br><br><br>";
         $dbxref = $r->dbxref_id;
         $dbxref = chado_expand_var($dbxref, 'table', 'cvterm', $options);
//echo "<pre>";var_dump($dbxref);echo "</pre><br><br><br>";
         $obo_term = $dbxref->db_id->name . ':' . $dbxref->accession;
         $obo_term .= ' (' . $dbxref->cvterm[0]->name . ')';
         $obo_terms[] = $obo_term;
      }
//echo "<pre>";var_dump($obo_terms);echo "</pre><br><br><br>";
      
    
      $rows[] = array(
        array('data' => $accession, 'width' => '15%'),
        $term->cvterm_id->definition,
        implode(', ', $obo_terms),
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
        'id' => "tripal_feature-table-terms-$i",
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

    $i++;
  }
}
*/
