<?php
  $feature  = $variables['node']->feature;

  $qtl_details = $feature->qtl_details;

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
                  'node/'.$feature->organism_id->nid, 
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

  $rows[] = array(
    array(
      'data' => 'Details',
      'header' => TRUE,
      'colspan' => 2,
      'style' => 'background-color:#c9c9c9;color:#101010',
    ),
  );
 
  // Favorable allele source
  $favorable_allele_source = 'not specified';
  if ($qtl_details->favorable_allele_source) {
    // Construct stock link
    //   example: /stock/Arachis/hypogaea/Cultivar/89xOL14-11-1-1-1-b2B
    if ($stock_link = getStockLink("$qtl_details->favorable_allele_source")) {
      $favorable_allele_source = l($qtl_details->favorable_allele_source, $stock_link);
    }
    else {
      $favorable_allele_source = $qtl_details->favorable_allele_source;
    }
  }
  $rows[] = array(
    array(
      'data' => 'Favorable Allele Source',
      'header' => TRUE,
      'width' => 200,
    ),
    $favorable_allele_source
  );
  
  // Nearest Marker
  $nearest_marker = 'unknown';
  if ($qtl_details->nearest_marker) {
    $nid = $qtl_details->nearest_marker_nid;
    $name = $qtl_details->nearest_marker;
    $url = getMarkerURL($nid);
    $nearest_marker = "<a id='nearest_marker_link' href=\"/$url\">$name</a>";
  }
  $rows[] = array(
    array(
      'data' => 'Nearest Marker',
      'header' => TRUE,
      'width' => 200,
    ),
    $nearest_marker
  );
  
  // Flanking Marker Low
  $flanking_marker_low = '';
  if ($qtl_details->flanking_marker_low) {
    $nid = $qtl_details->flanking_marker_low_nid;
    $name = $qtl_details->flanking_marker_low;
    $url = getMarkerURL($nid);
    $flanking_marker_low = "<a href=\"/$url\">$name</a>";
  }
  $rows[] = array(
    array(
      'data' => 'Flanking Marker Low',
      'header' => TRUE,
    ),
    $flanking_marker_low
  );
  
  // Flanking Marker High
  $flanking_marker_high = '';
  if ($qtl_details->flanking_marker_high) {
    $nid = $qtl_details->flanking_marker_high_nid;
    $name = $qtl_details->flanking_marker_high;
    $url = getMarkerURL($nid);
    $flanking_marker_high = "<a href=\"/$url\">$name</a>";
  }
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
    $qtl_details->lod
  );
  // Likelihood ratio
  $rows[] = array(
    array(
      'data' => 'Likelihood ratio',
      'header' => TRUE,
    ),
    $qtl_details->likelihood_ratio
  );
  // Marker R2
  $rows[] = array(
    array(
      'data' => 'Marker R2',
      'header' => TRUE,
    ),
    $qtl_details->marker_r2
  );
  // Total R2
  $rows[] = array(
    array(
      'data' => 'Total R2',
      'header' => TRUE,
    ),
    $qtl_details->total_r2
  );
  
  // Additivity
  $rows[] = array(
    array(
      'data' => 'Additivity',
      'header' => TRUE,
    ),
    $qtl_details->additivity
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
  
  // Comments
  $qtl_details = chado_expand_var($qtl_details, 'field', 'qtl_search.comment');
  $comments = $qtl_details->comment;
  $rows[] = array(
    array(
      'data' => 'Comments',
      'header' => TRUE,
    ),
    $comments,
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
  

//////////////////////////////////////////////////////////////////////////////////////////

function getMarkerURL($nid){
  $sql = "SELECT alias FROM url_alias WHERE source='node/$nid'";
  $res = chado_query($sql); 
  if (($rows = $res->fetchAll()) && isset($rows[0]->alias) && $rows[0]->alias != '') {
    return $rows[0]->alias;
  }
  else {
    return "node/$nid";
  }
}//getMarkerURL



