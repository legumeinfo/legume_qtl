<?php
  $feature  = $variables['node']->feature;
//echo "<br><br>tripal_feature_QTL_base.tpl.php variables object: <pre>";var_dump($variables);echo "</pre><br><br><br>";
//echo "<br><br>tripal_feature_QTL_base.tpl.php Feature object: <pre>";var_dump($feature);echo "</pre><br><br><br>";

  $qtl_details = $feature->qtl_details;
//echo "<br><br>tripal_feature_QTL_base.tpl.php QTL details: <pre>";var_dump($qtl_details);echo "</pre><br><br><br>";

  // QTL symbol from publication
  $expt_qtl_symbol = $qtl_details->expt_qtl_symbol;

  // Trait Name
  $trait_name = $qtl_details->expt_trait_name;
  
  // Trait Description
  $trait_description = $qtl_details->expt_trait_description;
  
  // Trait Unit
  $trait_unit = $qtl_details->trait_unit;
  
  // Trait Class
  $trait_class = $qtl_details->trait_class;
  
  // Treatment
  $treatment = $qtl_details->treatment;
  
  // Publication
  $citation = 'N/A';
  //echo "Publications: <pre>";var_dump($qtl_details->pub_expt);echo "</pre><br><br><br>";
  if ($qtl_details->pub_nid) {
    $citation = "<a href=\"/pub/" . $qtl_details->pub_nid . "\">";
    $citation .= $qtl_details->citation . "</a>";
  }

  // Organism
  $organism = $feature->organism_id->genus . " " 
            . $feature->organism_id->species . " (" 
            . $feature->organism_id->common_name .")";
  if (property_exists($feature->organism_id, 'nid')) {
    $organism = l("<i>" . $feature->organism_id->genus . " " 
                  . $feature->organism_id->species . "</i> ("  
                  . $feature->organism_id->common_name .")", 
                  $feature->organism_id->common_name, 
                  array('html' => TRUE));
  } 
  
  // Map(s)
  $map_positions = $feature->map_positions;
  $map_array = array();
  foreach ($map_positions as $map_position) {
    $map = makeMapLink($map_position);
    $map .= " (<b>linkage group:</b> " . makeLgMapLink($map_position) . ')';
    array_push($map_array, $map);
  };
  $maps = (count($map_array) > 0) ? implode('; ', $map_array) : '';
  
  // Comments
  $comments = $qtl_details->comments;
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
  
  /////// MAIN QTL SECTION /////////
  
  // Name row
  $rows[] = array(
    array(
      'data' => 'QTL Name',
      'header' => TRUE,
      'width' => 200,
      'style' => 'background-color:#c9c9c9;color:#101010',
    ),
    $feature->name,
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

  /////// TRAIT INFORMATION ///////
  
  $rows[] = array(
    array(
      'data' => 'Trait Information',
      'header' => TRUE,
      'colspan' => 2,
      'style' => 'background-color:#c9c9c9;color:#101010',
    ),
  );
  
  // Trait Name
  $rows[] = array(
    array(
      'data' => 'Trait name',
      'header' => TRUE,
    ),
    $qtl_details->trait_name,
  );
  // Trait Description
  $rows[] = array(
    array(
      'data' => 'Trait Description',
      'header' => TRUE,
    ),
    $qtl_details->trait_description,
  );
  // Trait Class
  $rows[] = array(
    array(
      'data' => 'Trait Class',
      'header' => TRUE,
    ),
    $trait_class,
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

  /////// QTL INFORMATION ///////
  
  $rows[] = array(
    array(
      'data' => 'QTL Information',
      'header' => TRUE,
      'colspan' => 2,
      'style' => 'background-color:#c9c9c9;color:#101010',
    ),
  );
  
  // Trait Unit
  $rows[] = array(
    array(
      'data' => 'Trait Unit',
      'header' => TRUE,
    ),
    $trait_unit,
  );
  // Treatment
  $rows[] = array(
    array(
      'data' => 'Treatment',
      'header' => TRUE,
    ),
    $treatment,
  );
  // Organism row
  $organism = $feature->organism_id->genus . " " 
            . $feature->organism_id->species . " (" 
            . $feature->organism_id->common_name .")";
  if (property_exists($feature->organism_id, 'nid')) {
    $organism = l("<i>" . $feature->organism_id->genus . " " 
                  . $feature->organism_id->species . "</i> ("  
                  . $feature->organism_id->common_name .")", 
                  $feature->organism_id->common_name, 
                  array('html' => TRUE));
  } 
  $rows[] = array(
    array(
      'data' => 'Organism',
      'header' => TRUE,
    ),
    $organism,
  );
  // Map(s)
  $rows[] = array(
    array(
      'data' => 'Map(s)',
      'header' => TRUE,
    ),
    $maps,
  );
  // Comments
  $rows[] = array(
    array(
      'data' => 'Comments',
      'header' => TRUE,
    ),
    $comments,
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

  /////// PUBLICATION QTL INFORMATION SECTION /////////
  
  $rows[] = array(
    array(
      'data' => 'Publication Information',
      'header' => TRUE,
      'colspan' => 2,
      'style' => 'background-color:#c9c9c9;color:#101010',
    ),
  );
  // Publication
  $rows[] = array(
    array(
      'data' => 'Publication',
      'header' => TRUE,
    ),
    $citation,
  );
  // publication QTL symbol
  $rows[] = array(
    array(
      'data' => 'Publication QTL Symbol',
      'header' => TRUE
    ),
    $expt_qtl_symbol,
  );
  // publication trait Name
  $rows[] = array(
    array(
      'data' => 'Publication Trait Name',
      'header' => TRUE,
    ),
    $trait_name,
  );
  // publication trait description
  $rows[] = array(
    array(
      'data' => 'Publication Trait Description',
      'header' => TRUE,
    ),
    $trait_description,
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
  