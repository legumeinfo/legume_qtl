<?php
// The marker link is for GDR only
$marker_link = "/node/";

$feature  = $variables['node']->feature;
$feature = tripal_core_expand_chado_vars($feature, 'table', 'featureprop', 
                                         array('return_array' => 1));
//echo "Feature: <pre>";var_dump($feature);echo "</pre><br><br><br>";
                                         
// Process featureprop 
$properties = $feature->featureprop;

$trait_name           = 'N/A';
$trait_description    = 'N/A';
$trait_unit           = 'N/A';
$treatment            = 'N/A';
$interval_calc_method = 'N/A';
$linkage_group        = 'N/A';
$publication_lg       = 'N/A';
$comments             = "N/A";

if ($properties) {
//echo "Properties: <pre>";var_dump($properties);echo "</pre><br><br><Br>";
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
      else if ($prop->type_id->cv_id->name == 'local' 
                && $prop->type_id->name == 'interval calculation method') {
        $interval_calc_method = $prop->value;
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
$qtl_details = $feature->legume_qtl->qtl_details;

// Base URL for LIS cMap instance
$lis_cmap = "http://cmap.comparative-legumes.org/cgi-bin/cmap/viewer";

// Synonyms
$synonyms        = '';
$expt_qtl_symbol = 'N/A';
//echo "Synonyms: <pre>";var_dump($qtl_details->synonyms);echo "</pre><br><br><br>";
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

// Trait class
$trait_class = 'N/A';
if ($qtl_details->trait_class 
      && $qtl_details->trait_class[0]->name != '') {
  $trait_class = $qtl_details->trait_class[0]->name;
}

// Nearest Marker
$nearest_marker = 'N/A';
if ($qtl_details->nearest_marker) {
  $id = $qtl_details->nearest_marker[0]->feature_id;
  $name = $qtl_details->nearest_marker[0]->name;
  $nearest_marker = "<a href=\"/ID$id\">$name</a>";
}

// Flanking Marker Low
$flanking_marker_low = 'N/A';
if ($qtl_details->flanking_marker_low) {
  $id = $qtl_details->flanking_marker_low[0]->feature_id;
  $name = $qtl_details->flanking_marker_low[0]->name;
  $flanking_marker_low = "<a href=\"/ID$id\">$name</a>";
}

// Flanking Marker High
$flanking_marker_high = 'N/A';
if ($qtl_details->flanking_marker_high) {
  $id = $qtl_details->flanking_marker_high[0]->feature_id;
  $name = $qtl_details->flanking_marker_high[0]->name;
  $flanking_marker_high = "<a href=\"/ID$id\">$name</a>";
}

//echo "map information: <pre>";var_dump($qtl_details->map_pos);echo "</pre><br><br><br>";
// Parent1
$parent1 = 'N/A';
if ($qtl_details->map_pos->parent1) {
  $name = $qtl_details->map_pos->parent1;
  $id = $qtl_details->map_pos->parent1_id;
  $parent1 = "<a href=\"/node/$id\">$name</a>";
}

// Parent2
$parent2 = 'N/A';
if ($qtl_details->map_pos->parent2) {
  $name = $qtl_details->map_pos->parent2;
  $id = $qtl_details->map_pos->parent2_id;
  $parent2 = "<a href=\"/node/$id\">$name</a>";
}

// Population
$population = "N/A";
if ($qtl_details->population->pop_nid) {
    $population = "<a href=\"/node/" . $qtl_details->population->pop_nid . "\">". $qtl_details->population->uniquename . "</a>";
} else if ($qtl_details->population->uniquename) {
    $population = $qtl_details->population->uniquename;
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

// Publication
$citation = 'N/A';
//echo "Publications: <pre>";var_dump($qtl_details->pub_expt);echo "</pre><br><br><br>";
if ($qtl_details->pub_expt) {
  $citation = "<a href=\"pub/" . $qtl_details->pub_expt[0]->pub_id . "\">";
  $citation .= $qtl_details->pub_expt[0]->citation . "</a>";
}

?>
<div id="tripal_feature-base-box" class="tripal_feature-info-box tripal-info-box">
  <div class="tripal_feature-info-box-title tripal-info-box-title"> <?php print $feature->type_id->name ?> Details</div>
  <div class="tripal_feature-info-box-desc tripal-info-box-desc"></div> <?php 
    if($feature->is_obsolete == 't') { ?>
      <div class="tripal_feature-obsolete">This feature is obsolete</div> <?php 
    } ?>
    <table id="tripal_feature-base-table" class="tripal_feature-table tripal-table tripal-table-vert">
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th width="45%">QTL Label</th>
        <td><?php print $feature->uniquename; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-odd-row">
        <th>QTL Symbol</th>
        <td><?php print $feature->name; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th nowrap>Experiment QTL symbol</th>
        <td><?php print $expt_qtl_symbol; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Trait Name</th>
        <td><?php print $trait_name; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Trait Description</th>
        <td><?php print $trait_description; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Trait Unit</th>
        <td><?php print $trait_unit; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Trait Class</th>
        <td><?php print $trait_class; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Treatment</th>
        <td><?php print $treatment; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Interval Calculation Method</th>
        <td><?php print $interval_calc_method; ?></td>
      </tr>
      
      <tr class="tripal_feature-table-even-row tripal-table-odd-row">
        <th nowrap>Linkage Group Name from Publication</th>
        <td><?php print $publication_lg;?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th nowrap>Linkage Group</th>
        <td>
          <?php 
            print $linkage_group;
            if ($qtl_details->map_pos->lis_lg_map_accession
                  && $qtl_details->map_pos->lis_lg_map_accession != '') {
              print " [<a href=\"$lis_cmap".$qtl_details->map_pos->lis_lg_map_accession."\" ";
              print "target=\"_blank\">cMap</a>]";
            }
          ?>
        </td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-odd-row">
        <th nowrap>Start Position</th>
        <td><?php print $qtl_details->map_pos->start;?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th nowrap>End Position</th>
        <td><?php print $qtl_details->map_pos->end;?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-odd-row">
        <th nowrap>Map</th>
        <td>
          <?php 
            print $qtl_details->map_pos->map_name;
            if ($qtl_details->map_pos->lis_map_accession
                  && $qtl_details->map_pos->lis_map_accession != '') {
              print " [<a href=\"$lis_cmap".$qtl_details->map_pos->lis_map_accession."\" ";
              print "target=\"_blank\">cMap</a>]";
            }
          ?>
        </td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Interval Calculation Method</th>
        <td><?php print $interval_calc_method; ?></td>
      </tr>
      
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Nearest Marker</th>
        <td><?php print $nearest_marker; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Flanking Marker Low</th>
        <td><?php print $flanking_marker_low; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Flanking Marker High</th>
        <td><?php print $flanking_marker_high; ?></td>
      </tr>

      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th nowrap>Parent1</th>
        <td><?php print $parent1; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Parent2</th>
        <td><?php print $parent2; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th nowrap>LOD</th>
        <td><?php print $lod; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-odd-row">
        <th nowrap>Likelihood ratio</th>
        <td><?php print $likelihood_ratio; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-even-row">
        <th>Marker R2</th>
        <td><?php print $marker_r2; ?></td>
      </tr>
      <tr class="tripal_feature-table-even-row tripal-table-odd-row">
        <th>Total R2</th>
        <td><?php print $total_r2; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Additivity</th>
        <td><?php print $additivity; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-odd-row">
        <th>Publication</th>
        <td><?php print $citation; ?></td>
      </tr>
      <tr class="tripal_feature-table-odd-row tripal-table-even-row">
        <th>Comments</th>
        <td><?php print $comments; ?></td>
      </tr>
   </table>
</div>
