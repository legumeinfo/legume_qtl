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
  
  $trait_name           = 'N/A';
  $trait_description    = '';
  $trait_unit           = 'unknown';
  $treatment            = 'unknown';
  $linkage_group        = 'unknown';
  $publication_lg       = 'N/A';
  $comments             = '';

  if ($properties) {
    foreach ($properties AS $prop) {
//echo $feature->feature_id .": " . $prop->type_id->name . " = " . $prop->value . "<br>";
      if ($prop->value != '') {
        if ($prop->type_id->cv_id->name == 'local'
              && $prop->type_id->name == 'experiment trait name') {
          $trait_name = $prop->value;
        } 
        else if ($prop->type_id->cv_id->name == 'local'
                   && $prop->type_id->name == 'experiment trait description') {
          $trait_description = $prop->value;
        } 
        else if ($prop->type_id->cv_id->name == 'local'
                   && $prop->type_id->name == 'trait unit') {
          $trait_unit = $prop->value;
        } 
        else if ($prop->type_id->cv_id->name == 'local' 
                  && $prop->type_id->name == 'QTL study treatment') {
          $treatment = $prop->value;
        }
        else if ($prop->type_id->cv_id->name == 'sequence' 
                  && $prop->type_id->name == 'linkage_group') {
          $linkage_group = $prop->value;
        }
        else if ($prop->type_id->cv_id->name == 'local' 
                  && $prop->type_id->name == 'linkage group name used in publication') {
          $publication_lg = $prop->value;
        }
        else if ($prop->type_id->cv_id->name == 'local' 
                  && $prop->type_id->name == 'comment') {
          $comment = $prop->value;
        }
      }//property has a value
    }//each property
  }//there are property records
  
  // Retrieve QTL details
  $qtl_details = $feature->qtl_details;
//echo "<br><br>qtl details: <pre>";var_dump($qtl_details);echo "</pre><br><br><br>";

  // Base URL for LIS cMap instance
  $lis_cmap = "http://cmap.comparative-legumes.org/cgi-bin/cmap/viewer";
//echo "<br><br>lis_cmap: <pre>";var_dump($lis_cmap);echo "</pre><br><br><br>";

  // Synonyms
  $synonyms        = '';
  $expt_qtl_symbol = 'N/A';
  if ($qtl_details->synonyms) {
      foreach ($qtl_details->synonyms as $syn) {
        if ($syn->cv = 'feature_property'
              && $syn->type == 'symbol') {
          $expt_qtl_symbol = $syn->name;
        }
        else {
          $synonyms .= $syn->name . ". ";
        }
      }
  }
  if ($synonyms == '') {
    $synonyms = 'N/A';
  }
//echo "<br><br>synonyms: <pre>";var_dump($synonyms);echo "</pre><br><br><br>";

  // Trait class
  $trait_class = 'N/A';
  if ($qtl_details->trait_class 
        && $qtl_details->trait_class[0]->name != '') {
    $trait_class = $qtl_details->trait_class[0]->name;
  }
//echo "<br><br>trait class: <pre>";var_dump($trait_class);echo "</pre><br><br><br>";

  // Publication
  $citation = 'N/A';
  //echo "Publications: <pre>";var_dump($qtl_details->pub_expt);echo "</pre><br><br><br>";
  if ($qtl_details->pub_expt) {
    $citation = "<a href=\"/pub/" . $qtl_details->pub_expt[0]->pub_id . "\">";
    $citation .= $qtl_details->pub_expt[0]->citation . "</a>";
  }
//echo "publication: <pre>$citation</pre><br><br><br>";
?>

<div class="tripal_feature-data-block-desc tripal-data-block-desc"></div> 

<?php
  // the $headers array is an array of fields to use as the colum headers. 
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
  
  // Unique Name row
  $rows[] = array(
    array(
      'data' => 'QTL Label',
      'header' => TRUE,
      'width'  => '270',
    ),
    $feature->uniquename
  );
  // Name row
  $rows[] = array(
    array(
      'data' => 'QTL Symbol',
      'header' => TRUE,
    ),
    $feature->name
  );
  // Experiment QTL symbol
  $rows[] = array(
    array(
      'data' => 'Experiment QTL symbol',
      'header' => TRUE
    ),
    $expt_qtl_symbol
  );
  // Trait Name
  $rows[] = array(
    array(
      'data' => 'Trait Name',
      'header' => TRUE,
    ),
    $trait_name
  );
  // Trait Description
  $rows[] = array(
    array(
      'data' => 'Trait Description',
      'header' => TRUE,
    ),
    $trait_description
  );
  // Trait Unit
  $rows[] = array(
    array(
      'data' => 'Trait Unit',
      'header' => TRUE,
    ),
    $trait_unit
  );
  // Trait Class
  $rows[] = array(
    array(
      'data' => 'Trait Class',
      'header' => TRUE,
    ),
    $trait_class
  );
  // Treatment
  $rows[] = array(
    array(
      'data' => 'Treatment',
      'header' => TRUE,
    ),
    $treatment
  );
  // Linkage Group
  if ($qtl_details->map_pos->lis_lg_map_accession
        && $qtl_details->map_pos->lis_lg_map_accession != '') {
    $linkage_group .= " [<a href=\"$lis_cmap".$qtl_details->map_pos->lis_lg_map_accession."\" ";
    $linkage_group .= "target=\"_blank\">CMap</a>]";
  }
  $rows[] = array(
    array(
      'data' => 'Linkage Group',
      'header' => TRUE,
    ),
    $linkage_group
  );
  // Linkage Group Name from Publication
  $rows[] = array(
    array(
      'data' => 'Linkage Group Name from Publication',
      'header' => TRUE,
    ),
    $publication_lg
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
  // Map
  $map = $qtl_details->map_pos->map_name;
  if ($qtl_details->map_pos->lis_map_accession
        && $qtl_details->map_pos->lis_map_accession != '') {
    $map .= " [<a href=\"$lis_cmap".$qtl_details->map_pos->lis_map_accession."\" ";
    $map .= "target=\"_blank\">cMap</a>]";
  }
  $rows[] = array(
    array(
      'data' => 'Map',
      'header' => TRUE,
    ),
    $map
  );
  // Publication
  $rows[] = array(
    array(
      'data' => 'Publication',
      'header' => TRUE,
    ),
    $citation
  );
  // Organism row
  $organism = $feature->organism_id->genus . " " 
            . $feature->organism_id->species . " (" 
            . $feature->organism_id->common_name .")";
  if (property_exists($feature->organism_id, 'nid')) {
    $organism = l("<i>" . $feature->organism_id->genus . " " 
                  . $feature->organism_id->species . "</i> ("  
                  . $feature->organism_id->common_name .")", "node/"
                  . $feature->organism_id->nid, array('html' => TRUE));
  } 
  $rows[] = array(
    array(
      'data' => 'Organism',
      'header' => TRUE,
    ),
    $organism
  );
  // Comments
  $rows[] = array(
    array(
      'data' => 'Comments',
      'header' => TRUE,
    ),
    $comments
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
